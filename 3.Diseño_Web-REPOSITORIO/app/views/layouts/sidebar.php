<nav aria-label="Menú de navegación" class="sidebar">
    <div class="logo">🥐</div>
    <ul>
        <li title="Inicio">
            <a href="<?php echo \config\APP_URL; ?>dashboard" class="nav-btn <?php echo ($active_page == 'dashboard') ? 'active' : ''; ?>" aria-label="Inicio">
                <lord-icon
                    src="https://cdn.lordicon.com/oeotfwsx.json"
                    colors="primary:#ffffff"
                    trigger="hover"
                    style="width:40px;height:40px">
                </lord-icon>
            </a>
        </li>
        <?php if ($_SESSION['rol'] == 'ADMINISTRADOR') {
        ?>
            <li class="has-submenu" title="Usuarios">
                <button class="nav-btn <?php echo ($active_page == 'usuarios') ? 'active' : ''; ?>" aria-label="Usuarios" aria-expanded="false">
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
                                style="width:50px;height:50px">
                            </lord-icon>
                            Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo \config\APP_URL; ?>roles">
                            <lord-icon
                                src="https://cdn.lordicon.com/zhiiqoue.json"
                                trigger="morph"
                                state="morph-open"
                                colors="primary:#ffffff,secondary:#ffffff"
                                style="width:50px;height:50px">
                            </lord-icon>
                            Roles
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo \config\APP_URL; ?>tareas">
                            <lord-icon
                                src="https://cdn.lordicon.com/wwcdwkaf.json"
                                trigger="hover"
                                state="morph-open"
                                colors="primary:#ffffff,secondary:#ffffff"
                                style="width:50px;height:50px">
                            </lord-icon>
                            Tareas
                        </a>
                    </li>
                </ul>
            </li>

            <li class="has-submenu" title="Inventario">
                <button class="nav-btn" aria-label="Productos" aria-expanded="false">
                    <lord-icon
                        src="https://cdn.lordicon.com/sbrvirwc.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:55px;height:55px">
                    </lord-icon>
                </button>
                <ul class="submenu">
                    <li>
                        <a href="<?php echo \config\APP_URL; ?>productos">
                            <lord-icon
                                src="https://cdn.lordicon.com/wjhxvnmc.json"
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
                                src="https://cdn.lordicon.com/fwkrbvja.json"
                                trigger="hover"
                                state="hover-cog-4"
                                colors="primary:#ffffff,secondary:#ffffff"
                                style="width:50px;height:50px">
                            </lord-icon>
                            Ajustes
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo \config\APP_URL; ?>produccion">
                            <lord-icon
                                src="https://cdn.lordicon.com/rrbmabsx.json"
                                trigger="morph"
                                state="morph-open"
                                colors="primary:#ffffff,secondary:#ffffff"
                                style="width:50px;height:50px">
                            </lord-icon>
                            Recetas
                        </a>
                    </li>
                </ul>
            </li>

            <li class="has-submenu" title="Finanzas">
                <button class="nav-btn" aria-label="Facturas" aria-expanded="false">
                    <lord-icon
                        src="https://cdn.lordicon.com/bsdkzyjd.json"
                        trigger="hover"
                        state="hover-spending"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:60px;height:60px">
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
                            Ventas
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo \config\APP_URL; ?>facturas_Ventas">
                            <lord-icon
                                src="https://cdn.lordicon.com/uisoczqi.json"
                                trigger="hover"
                                state="hover-spending"
                                colors="primary:#ffffff,secondary:#ffffff"
                                style="width:80px;height:68px">
                            </lord-icon>
                            Compras (Proveedores)
                        </a>
                    </li>
                </ul>
            </li>

            <li title="Producción">
                <a href="<?php echo \config\APP_URL; ?>pedidos" class="nav-btn" aria-label="Pedidos">
                    <lord-icon
                        src="https://cdn.lordicon.com/asyunleq.json"
                        trigger="hover"
                        state="hover-cog-4"
                        colors="primary:#ffffff"
                        style="width:40px;height:40px">
                    </lord-icon>
                </a>
            </li>
        <?php
        }
        ?>
        <div class="spacer"></div>

        <?php if ($_SESSION['rol'] == 'ADMINISTRADOR' || $_SESSION['rol'] == 'MESERO') {
        ?>
            <!-- PARTE DE MESERO -->
            <li title="Pedidos">
                <a href="<?php echo \config\APP_URL; ?>pedidos" class="nav-btn" aria-label="Pedidos">
                    <img src="<?php echo \config\APP_URL ?>public/images/sidebar/pedidos.png" alt="Pedidos" width="50rem 50rem´x">
                </a>
            </li>
        <?php
        }
        ?>
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