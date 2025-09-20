<nav aria-label="Menú de navegación" class="sidebar">
    <div class="logo">🥐</div>
    <ul>
        <li title="Inicio">
            <a href="<?php echo \config\APP_URL; ?>dashboard" class="nav-btn class=" nav-btn <?php echo ($active_page == 'dashboard') ? 'active' : ''; ?>" aria-label="Inicio">
                <lord-icon
                    src="https://cdn.lordicon.com/oeotfwsx.json"
                    colors="primary:#ffffff"
                    trigger="hover"
                    style="width:40px;height:40px">
                </lord-icon>
            </a>
        </li>

        <li class="has-submenu" title="Usuarios">
            <button class="nav-btn class=" nav-btn <?php echo ($active_page == 'usuarios') ? 'active' : ''; ?>" aria-label="Usuarios" aria-expanded="false">
                <lord-icon
                    src="https://cdn.lordicon.com/bushiqea.json"
                    trigger="hover"
                    colors="primary:#ffffff"
                    style="width:45px;height:45px">
                </lord-icon>
            </button>
            <ul class="submenu">
                <li>
                    <a href="<?php echo \config\APP_URL; ?>usuarios">
                        <lord-icon
                            src="https://cdn.lordicon.com/bushiqea.json"
                            trigger="hover"
                            colors="primary:#ffffff"
                            style="width:45px;height:45px">
                        </lord-icon>
                        Usuarios Generales
                    </a>
                </li>
                <li>
                    <a href="<?php echo \config\APP_URL; ?>usuarios_empleados">
                        <lord-icon
                            src="https://cdn.lordicon.com/yanwuwms.json"
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:60px;height:60px">
                        </lord-icon>
                        Usuarios de Empleados
                    </a>
                </li>
                <li>
                    <a href="<?php echo \config\APP_URL; ?>usuarios_clientes">
                        <lord-icon
                            src="https://cdn.lordicon.com/jdgfsfzr.json"
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:60px;height:60px">
                        </lord-icon>
                        Usuarios de Clientes
                    </a>
                </li>
            </ul>
        </li>

        <li class="has-submenu" title="Empleados">
            <button class="nav-btn" aria-label="Empleados" aria-expanded="false">
                <lord-icon
                    src="https://cdn.lordicon.com/yanwuwms.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:50px;height:50px">
                </lord-icon>
            </button>
            <ul class="submenu">
                <li>
                    <a href="<?php echo \config\APP_URL; ?>cargos">
                        <lord-icon
                            src="https://cdn.lordicon.com/zhiiqoue.json"
                            trigger="morph"
                            state="morph-open"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:50px;height:50px">
                        </lord-icon>
                        Cargos
                    </a>
                </li>
                <li>
                    <a href="<?php echo \config\APP_URL; ?>empleados">
                        <lord-icon
                            src="https://cdn.lordicon.com/yanwuwms.json"
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:50px;height:50px">
                        </lord-icon>
                        Empleados
                    </a>
                </li>
            </ul>
        </li>

        <li title="Clientes">
            <a href="<?php echo \config\APP_URL; ?>clientes" class="nav-btn" aria-label="Clientes">
                <lord-icon
                    src="https://cdn.lordicon.com/jdgfsfzr.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:50px;height:50px">
                </lord-icon>
            </a>
        </li>

        <li title="Pedidos">
            <a href="<?php echo \config\APP_URL; ?>pedidos" class="nav-btn" aria-label="Pedidos">
                <lord-icon
                    src="https://cdn.lordicon.com/uisoczqi.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:50px;height:50px">
                </lord-icon>
            </a>
        </li>

        <li class="has-submenu" title="Productos">
            <button class="nav-btn" aria-label="Productos" aria-expanded="false">
                <lord-icon
                    src="https://cdn.lordicon.com/sbrvirwc.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:50px;height:50px">
                </lord-icon>
            </button>
            <ul class="submenu">
                <li>
                    <a href="<?php echo \config\APP_URL; ?>productos">
                        <lord-icon
                            src="https://cdn.lordicon.com/sbrvirwc.json"
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:50px;height:50px">
                        </lord-icon>
                        Productos
                    </a>
                </li>
                <li>
                    <a href="<?php echo \config\APP_URL; ?>materia_prima">
                        <lord-icon
                            src="https://cdn.lordicon.com/jhiqqftv.json"
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:50px;height:50px">
                        </lord-icon>
                        Materia Prima
                    </a>
                </li>
                <li>
                    <a href="<?php echo \config\APP_URL; ?>produccion">
                        <lord-icon
                            src="https://cdn.lordicon.com/asyunleq.json"
                            trigger="hover"
                            state="hover-cog-4"
                            colors="primary:#ffffff"
                            style="width:40px;height:40px">
                        </lord-icon>
                        Producción
                    </a>
                </li>
            </ul>
        </li>

        <li class="has-submenu" title="Facturas">
            <button class="nav-btn" aria-label="Facturas" aria-expanded="false">
                <lord-icon
                    src="https://cdn.lordicon.com/yraqammt.json"
                    trigger="hover"
                    colors="primary:#ffffff"
                    style="width:40px;height:40px">
                </lord-icon>
            </button>
            <ul class="submenu">
                <li>
                    <a href="<?php echo \config\APP_URL; ?>facturas_Ventas">
                        <lord-icon
                            src="https://cdn.lordicon.com/bsdkzyjd.json"
                            trigger="hover"
                            state="hover-spending"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:60px;height:60px">
                        </lord-icon>
                        Facturas de Ventas
                    </a>
                </li>
                <li>
                    <a href="<?php echo \config\APP_URL; ?>facturas_Compras">
                        <lord-icon
                            src="https://cdn.lordicon.com/eeuqpnwy.json"
                            trigger="hover"
                            colors="primary:#ffffff"
                            style="width:60px;height:60px">
                        </lord-icon>
                        Facturas de Compras
                    </a>
                </li>
            </ul>
        </li>

        <li title="Proveedores">
            <a href="<?php echo \config\APP_URL; ?>proveedores" class="nav-btn" aria-label="Proveedores">
                <lord-icon
                    src="https://cdn.lordicon.com/byupthur.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:50px;height:50px">
                </lord-icon>
            </a>
        </li>

        <div class="spacer"></div>

        <li title="Cerrar sesión">
            <a href="<?php echo \config\APP_URL; ?>logout" class="nav-btn" aria-label="Cerrar sesión">
                <lord-icon
                    src="https://cdn.lordicon.com/vfiwitrm.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:50px;height:50px">
                </lord-icon>
            </a>
        </li>
    </ul>
</nav>