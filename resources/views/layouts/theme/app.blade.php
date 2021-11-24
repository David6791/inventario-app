<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LABSOLIS | Sueldos y Salarios</title>
        @include('layouts.theme.styles')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
                @include('layouts.theme.nav')
                @include('layouts.theme.sidebar')
                <div class="content-wrapper">
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.theme.footer')
            <aside class="control-sidebar control-sidebar-dark">
            </aside>
        </div>
        @include('layouts.theme.scripts')
    </body>
</html>
