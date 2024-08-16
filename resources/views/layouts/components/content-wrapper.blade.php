<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    @yield('breadcrumb')
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </section>
</div>
