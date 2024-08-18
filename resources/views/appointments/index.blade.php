@extends('layouts.app')

@section('title', 'Reservar Cita')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Reservar Cita</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendario de Citas</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para elegir la franja horaria -->
    <div class="modal fade" id="timeSlotModal" tabindex="-1" role="dialog" aria-labelledby="timeSlotModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeSlotModalLabel">Seleccionar Hora para la Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm">
                        <input type="hidden" id="appointmentId">
                        <div class="form-group">
                            <label for="appointmentTitle">Título de la Cita</label>
                            <input type="text" class="form-control" id="appointmentTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="startTime">Hora de Inicio</label>
                            <select class="form-control" id="startTime" required>
                                @for ($hour = 8; $hour <= 19; $hour++)
                                    <option value="{{ $hour < 10 ? '0' . $hour : $hour }}:00">{{ $hour < 10 ? '0' . $hour : $hour }}:00</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" id="deleteButton" class="btn btn-danger" style="display: none;">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta cita?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmDeleteButton" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var authenticatedUserId = {{ Auth::id() }};
    var existingAppointments = @json($appointments);
    var selectedDate = null;
    var appointmentToDelete = null;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        timeZone: 'Europe/Madrid',
        selectable: true,
        editable: true,
        events: existingAppointments.map(function(appointment) {
            return {
                id: appointment.id,
                title: appointment.user_id === authenticatedUserId ? appointment.title : 'Reservada',
                start: appointment.start,
                end: appointment.end,
                user_id: appointment.user_id,
                editable: appointment.user_id === authenticatedUserId,
                color: appointment.user_id === authenticatedUserId ? '' : '#888888' // Color gris para citas de otros usuarios
            };
        }),
        dateClick: function(info) {
            selectedDate = info.dateStr;
            $('#timeSlotModal').modal('show');
            $('#appointmentId').val('');
            $('#appointmentTitle').val('');
            $('#deleteButton').hide();
            updateAvailableTimeSlots();
        },
        eventClick: function(info) {
            if (info.event.extendedProps.user_id !== authenticatedUserId) {
                Swal.fire('Esta cita está reservada por otro usuario.');
                return;
            }

            selectedDate = info.event.start.toISOString().split('T')[0];
            $('#timeSlotModal').modal('show');
            $('#appointmentId').val(info.event.id);
            $('#appointmentTitle').val(info.event.title);
            var eventStart = new Date(info.event.start);
            $('#startTime').val(eventStart.toTimeString().substring(0, 5));
            $('#deleteButton').show();
            appointmentToDelete = info.event;
            updateAvailableTimeSlots(info.event.id);
        }
    });

    calendar.render();

    function updateAvailableTimeSlots(excludeEventId) {
        var availableSlots = [];
        for (var hour = 8; hour <= 19; hour++) {
            availableSlots.push(hour < 10 ? '0' + hour + ':00' : hour + ':00');
        }

        var events = calendar.getEvents();
        events.forEach(function(event) {
            if (event.id !== excludeEventId && event.start.toISOString().split('T')[0] === selectedDate) {
                var startHour = new Date(event.start).getHours();
                var index = availableSlots.indexOf(startHour < 10 ? '0' + startHour + ':00' : startHour + ':00');
                if (index > -1) {
                    availableSlots.splice(index, 1);
                }
            }
        });

        var startTimeSelect = $('#startTime');
        startTimeSelect.empty();
        availableSlots.forEach(function(slot) {
            startTimeSelect.append($('<option></option>').attr('value', slot).text(slot));
        });

        // Si no hay franjas horarias disponibles
        if (availableSlots.length === 0) {
            Swal.fire('No hay franjas horarias disponibles para este día.');
            $('#timeSlotModal').modal('hide');
        }
    }

    function isTimeSlotAvailable(startTime, appointmentId) {
        var events = calendar.getEvents();
        for (var i = 0; i < events.length; i++) {
            var event = events[i];
            if (event.id !== appointmentId && 
                event.start.toISOString().split('T')[0] === selectedDate &&
                event.start.toTimeString().substring(0, 5) === startTime) {
                return false;
            }
        }
        return true;
    }

    // Guardar o actualizar la cita
    $('#appointmentForm').on('submit', function(event) {
        event.preventDefault();
        var appointmentId = $('#appointmentId').val();
        var title = $('#appointmentTitle').val();
        var startTime = $('#startTime').val();

        console.log('Selected Date:', selectedDate);

        if (title && startTime && selectedDate) {
            if (!isTimeSlotAvailable(startTime, appointmentId)) {
                Swal.fire('Error', 'Esta franja horaria ya está ocupada. Por favor, elige otra.', 'error');
                return;
            }

            var start = new Date(selectedDate + 'T' + startTime + ':00').toISOString();
            var endHour = parseInt(startTime.split(':')[0]) + 1;
            var end = new Date(selectedDate + 'T' + (endHour < 10 ? '0' + endHour : endHour) + ':00:00').toISOString();

            console.log('Sending appointment data:', { title, start, end });

            if (appointmentId) {
                // Actualizar la cita existente
                $.ajax({
                    url: '/appointments/' + appointmentId,
                    method: 'PUT',
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var event = calendar.getEventById(appointmentId);
                        event.setProp('title', title);
                        event.setStart(start);
                        event.setEnd(end);
                        $('#timeSlotModal').modal('hide');
                        Swal.fire('Éxito', 'Cita actualizada correctamente.', 'success');
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON.error || 'No se pudo actualizar la cita. Por favor, inténtalo de nuevo.';
                        Swal.fire('Error', errorMessage, 'error');
                        $('#timeSlotModal').modal('hide');
                    }
                });
            } else {
                // Crear una nueva cita
                $.ajax({
                    url: '/appointments',
                    method: 'POST',
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        calendar.addEvent({
                            id: response.id,
                            title: response.title,
                            start: response.start,
                            end: response.end,
                            allDay: false,
                            editable: true,
                            user_id: authenticatedUserId
                        });
                        $('#timeSlotModal').modal('hide');
                        Swal.fire('Éxito', 'Cita creada correctamente.', 'success');
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON.error || 'No se pudo crear la cita. Por favor, inténtalo de nuevo.';
                        Swal.fire('Error', errorMessage, 'error');
                        $('#timeSlotModal').modal('hide');
                    }
                });
            }
        } else {
            Swal.fire('Error', 'Por favor completa todos los campos requeridos y asegúrate de seleccionar una fecha.', 'error');
        }
    });

    // Eliminar la cita
    $('#deleteButton').on('click', function(event) {
        event.preventDefault();
        $('#deleteConfirmationModal').modal('show');
    });

    $('#confirmDeleteButton').on('click', function() {
        if (appointmentToDelete) {
            $.ajax({
                url: '/appointments/' + appointmentToDelete.id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    appointmentToDelete.remove();
                    $('#deleteConfirmationModal').modal('hide');
                    $('#timeSlotModal').modal('hide');
                    Swal.fire('Éxito', 'Cita eliminada correctamente.', 'success');
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON.error || 'No se pudo eliminar la cita. Por favor, inténtalo de nuevo.';
                    Swal.fire('Error', errorMessage, 'error');
                    $('#deleteConfirmationModal').modal('hide');
                }
            });
        }
    });

    // Manejo del modal y accesibilidad
    $('#timeSlotModal').on('shown.bs.modal', function () {
        $(this).attr('aria-hidden', 'false').focus();
    });

    $('#timeSlotModal').on('hidden.bs.modal', function () {
        $(this).attr('aria-hidden', 'true');
    });
});

</script>
@endpush

