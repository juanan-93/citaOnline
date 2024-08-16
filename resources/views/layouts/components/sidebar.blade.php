<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" class="img-circle elevation-2" alt="User Image">


            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                @can('admin')
                    {{-- admin --}}
                    <li class="nav-item">
                        <a href="{{route('admin.index')}}" class="nav-link">
                            <i class="nav-icon far fa-user"></i>
                            <p>Crear Usuario admin</p>
                        </a>
                    </li>
                    {{-- customer --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Crear paciente</p>
                        </a>
                    </li>
                @endcan
                
                <!-- More sidebar items -->
            </ul>
        </nav>
    </div>
</aside>
