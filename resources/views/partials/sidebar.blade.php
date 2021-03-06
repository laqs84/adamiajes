@if(Admin::user())
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Admin::user()->avatar }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Admin::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('admin.online') }}</a>
            </div>

        @if(config('admin.enable_menu_search'))
        <!-- search form (Optional) -->
        <form class="sidebar-form" style="overflow: initial;" onsubmit="return false;">
            <div class="input-group">
                <input type="text" autocomplete="off" class="form-control autocomplete" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
                <ul class="dropdown-menu" role="menu" style="min-width: 210px;max-height: 300px;overflow: auto;">

                    <li>
                        <a href="competencias"><i class="fa fa-th-list"></i>Competencias Base</a>
                    </li>

                </ul>
            </div>
        </form>
        <!-- /.search form -->
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('admin.menu') }}</li>

            <li>
                <a href="/admin">
                    <i class="fa fa-bar-chart"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>Admin</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="/admin/candidatos">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <span>Candidatos</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/administradores">
                            <i class="fa fa-users"></i>
                            <span>Administraor</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/auth/roles">
                            <i class="fa fa-user"></i>
                            <span>Roles</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/auth/permissions">
                            <i class="fa fa-ban"></i>
                            <span>Permisos</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tasks"></i>
                    <span>Competencia</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="/admin/competenciastipos">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            <span>Tipos Competencias</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/competenciasniveles">
                            <i class="fa fa-level-up" aria-hidden="true"></i>
                            <span>Niveles Competencias</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/puestosclasificaciones">
                            <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                            <span>Clasificaciones Puestos</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/competencias">
                            <i class="fa fa-bars"></i>
                            <span>Competencias</span>
                        </a>
                    </li>
                    
                    
                    <li>
                        <a href="/admin/puestos">
                            <i class="fa fa-asterisk"></i>
                            <span>Puestos</span>
                        </a>
                    </li>
                  
                    <li>
                        <a href="/admin/calificacion_resultados">
                            <i class="fa fa-asterisk"></i>
                            <span>Calificaci??n</span>
                        </a>
                    </li>                    

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building"></i>
                    <span>Empresas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/empresasniveles">
                            <i class="fa fa-level-up" aria-hidden="true"></i>
                            <span>Niveles de las Empresas</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/empresas">
                            <i class="fa fa-building"></i>
                            <span>Empresas</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/empresas_pruebas_base">
                            <i class="fa fa-building"></i>
                            <span>Base Pruebas de Empresas</span>
                        </a>
                    </li>                    
                    <li>
                        <a href="/admin/empresa_pruebas">
                            <i class="fa fa-building"></i>
                            <span>Pruebas de Empresas</span>
                        </a>
                    </li>

                    

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-window-restore" aria-hidden="true"></i>
                    <span>Resultados</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="/admin/candidatospruebas">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            <span>Informes</span>
                        </a>
                    </li>

                </ul>
            </li>


        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

@endif