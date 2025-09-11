<?php
    include("Index.INFO-USUARIO.PHP");
?>
<!--------------------------------------------------------------------- 🚀 BARRA NAVEGACIÓN SUPERIOR --------------------------------------------------------------------------->
<header class="menu-superior">
            <!-- DIV OPCIÓN DESPLAZAR MENÚ MENU-->
            <div class="menuToggle"></div>

            <img class="imagen_logo" src="../LOGO-PROYECTO.png" style="width:120px;height:80px">
            <!--------------------------------------------------------------------- 🚀 BARRA BUSQUEDA -------------------------------------------------------------------------->
            <div id="child-3 container_busqueda" class="col-md-7">
                <form action="" method="GET">
                    <div id="sub-container_busqueda" class="input-group">
                        <input id="barra_busqueda" type="text" name="buscador" value="<?php if(isset($_GET['buscador'])) {echo $_GET['buscador'];}?>" class="form-control" placeholder="¿Qué deseas buscar?">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
            <!--------------------------------------------------------------------- 🏁 BARRA BUSQUEDA -------------------------------------------------------------------------->

            <!--------------------------------------------------------------------- 🚀 USUARIO-PERFIL -------------------------------------------------------------------------->
            <span class="child-4 navigation__group">
                <img class="profile" src="../IMG/assets/IMG-USER-2.svg" alt="USUARIO">
            </span>
            <div class="dropdown__wrapper hide dropdown__wrapper--fade-in none">
                <nav>
                    <ul>
                        <li class="li_nom_user">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none" stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                            <!--CREAR ICONO DEL PERFIL MEDIANTE PATHS-->
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><!--Crea un rectangulo para definir el limite de espacio-->
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><!--Crea el circulo de contorno-->
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><!--Crea el circulo de la cabeza-->
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /><!--Crea el cuerpo(arco invertido)-->
                            </svg>
                            Campo_NOMBRE
                        </li>
                        <li>
                            <button id="INFO-PERSONAL-BOTON" type="submit" data-toggle="modal" data-target="#modalInfousuario">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                <!--CREAR ICONO DEL CONFIGURACIÓN PATHS-->
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><!--Crea un rectangulo para definir el limite de espacio-->
                                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"/>
                                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><!--Crea el circulo dentro de la rueda-->
                                </svg>
                                Información Personal
                            </button>
                        </li>
                    </ul>
                    <hr class="divider">
                    <ul>
                        <li>
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-analytics">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><!--Crea un rectangulo para definir el limite de espacio-->
                                <path d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" /><!--Crea un rectangulo como pantalla del icono-->
                                <path d="M7 20l10 0" /><!--Crea una linea horzontal. Parte inferior del icono-->
                                <path d="M9 16l0 4" /><!--Crea una linea vertical-->
                                <path d="M15 16l0 4" /><!--Crea una segunda linea vertical-->
                                <path d="M8 12l3 -3l2 2l3 -3" /><!--Crea la forma de un rayo-->
                            </svg> 
                            ROL (Campo_Cargo)
                        </li>
                        <hr class="divider">
                        <li>
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                <path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" />
                            </svg>
                            <a id="CERRAR_SESION" data-name="Campo_Nombre">Cerrar sesión</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--------------------------------------------------------------------- 🏁 USUARIO-PERFIL -------------------------------------------------------------------------->
    </header>
<!--------------------------------------------------------------------- 🏁 BARRA NAVEGACIÓN SUPERIOR --------------------------------------------------------------------------->