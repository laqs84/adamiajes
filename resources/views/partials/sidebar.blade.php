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
                    <i class="fa fa-tasks"></i>
                    <span>Competencia</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="/admin/competenciastipos">
                            <i class="fa fa-level-up-alt"></i>
                            <span>Tipos Competencias</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/competenciasniveles">
                            <i class="fa fa-level-up-alt"></i>
                            <span>Niveles Competencias</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/admin/puestosclasificaciones">
                            <i class="fa fa-star-half-alt"></i>
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
                            <span>Calificación</span>
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
                        <a href="/admin/empresaniveles">
                            <i class="fa fa-level-up-alt"></i>
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
                    <i class="fa fa-align-justify"></i>
                    <span>Generar Pruebas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="">
                            <i class="fa fa-building"></i>
                            <span></span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-poll"></i>
                    <span>Resultados</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="">
                            <i class="fa fa-building"></i>
                            <span></span>
                        </a>
                    </li>

                </ul>
            </li>


        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>