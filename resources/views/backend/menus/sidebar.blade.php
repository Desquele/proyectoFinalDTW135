<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" >
        <span class="brand-text font-weight" style="color: white">PANEL DE CONTROL</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">

                <!-- ROLES Y PERMISO -->
                @can('sidebar.roles.y.permisos')
                 <li class="nav-item">

                     <a href="#" class="nav-link nav-">
                        <i class="far fa-edit"></i>
                        <p>
                            Roles y Permisos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rol y Permisos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuario</p>
                            </a>
                        </li>

                    </ul>
                 </li>
                @endcan

                <!--Acceder a la lista de gestión de tickets (unicamente admins)-->

                @hasrole('admin')
                    <li class="nav-item">
                        <a href="{{ route('tickets.index') }}" target="frameprincipal" class="nav-link">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>Tickets</p>
                        </a>
                    </li>
                <!-- Acceso a opcion de tipo de cambio (consumo de API) -->
                    <li class="nav-item">
                        <a href="{{ route('api.tipo_cambio') }}" target="frameprincipal" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>Tipo de Cambio Monedas</p>
                        </a>
                    </li>
                @endhasrole

            </ul>
        </nav>

    </div>
</aside>
