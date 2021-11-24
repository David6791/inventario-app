<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/admin.jpg') }}" alt="LABSOLIS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LABSOLIS</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item @if (\Request::is('usuarios') | \Request::is('roles') | \Request::is('permisos') | \Request::is('asignar')) menu-open  @endif">
                    <a href="" class="nav-link @if (\Request::is('usuarios') | \Request::is('roles') | \Request::is('permisos') | \Request::is('asignar')) active  @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Estructuración
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('usuarios') }}" class="nav-link @if (\Request::is('usuarios')) active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('roles') }}" class="nav-link  @if (\Request::is('roles')) active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('permisos') }}" class="nav-link  @if (\Request::is('permisos')) active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permisos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('asignar') }}" class="nav-link  @if (\Request::is('asignar')) active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Asignaciones</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--li class="nav-item @if (\Request::is('areas')) menu-open  @endif">
                    <a href="" class="nav-link @if (\Request::is('areas')) active  @endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Configuraciones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('areas') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Areas</p>
                            </a>
                        </li>
                    </ul>
                </li-->
                <li class="nav-item @if (\Request::is('empleados')) menu-open  @endif">
                    <a href="" class="nav-link @if (\Request::is('empleados')) active  @endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Empleados
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('empleados') }}" class="nav-link @if (\Request::is('empleados')) active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ver Empleados</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Datos Planillas</p>
                    </a>
                </li-->
                <li class="nav-item @if (\Request::is('planillas') | \Request::is('planillas_iva')  ) menu-open @endif">
                    <a href="" class="nav-link @if (\Request::is('planillas') | \Request::is('planillas_iva')) active menu-open @endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Planillas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('planillas') }}" class="nav-link @if (\Request::is('planillas')) active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sueldos</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('planillas_iva') }}" class="nav-link @if (\Request::is('planillas_iva')) active  @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Impositiva RC-IVA</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('areas') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Aportes</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
