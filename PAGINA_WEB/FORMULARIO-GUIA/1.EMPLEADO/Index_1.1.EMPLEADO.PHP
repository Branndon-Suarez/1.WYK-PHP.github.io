<?php
    require_once ('../layout/HEADER-PROYECTO.PHP');
    require_once ('Index_1.1.DETALLE-EMPLEADO.PHP');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FORMULARIO EMPLEAD</title>
    <link rel="stylesheet" type="text/css" href="../ESTILOS/ESTILOS PROYECTO-FORMULARIOS-CSS.CSS">
    <link rel="stylesheet" type="text/css" href="../ESTILOS/ESTILO-INFO-LOGIN.css">
    <!------------------------------ 🚀 CONEXIÓN SIN 📡 BOOTSTRAP CSS ------------------------------->
    <link href="../ESTILOS/css/bootstrap.min.css" rel="stylesheet">
    <!------------------------------ 🏁 CONEXIÓN SIN 📡 BOOTSTRAP CSS ------------------------------->
</head>

<body>
    <!--------------------------------------------------------------------- 🚀 BARRA NAVEGACIÓN LATERAL --------------------------------------------------------------------------->
    <div class="sidebar">
        <ul>
            <li style="--bg:#ffa117;" class="Color_Desplazar"> <!--La clase "Color_Desplazar" Rodea al icono con un circulo para indicar selecionado-->
                <div class="icon">
                    <a href="../1.1.EMPLEADO/Index_1.1.EMPLEADO.php">
                        <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-1.1.EMPLEADO.png">
                </div>
                <div class="text"><b>EMPLEADO</b></a></div>
            </li>

            <li style="--bg:#fa3636;">
                <div class="icon">
                    <a href="../no existe.html">
                        <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-2.1.CLIENTE.png">
                </div>
                <div class="text"><b>CLIENTE</b></a></div>
            </li>

            <li style="--bg:#0fc40f;">
                <div class="icon">
                    <a href="../no existe.html">
                        <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-3.1.PROVEEDOR.png">
                </div>
                <div class="text"><b>PROVEEDOR</b></a></div>
            </li>

            <li style="--bg:#A69B03 ;">
                <div class="icon">
                    <a href="../no existe.html">
                        <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-4.1.PRODUCTO.png">
                </div>
                <div class="text"><b>PRODUCTO</b></a></div>
            </li>

            <li style="--bg:#2196f3;">
                <div class="icon">
                    <a href="../no existe.html">
                        <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-5.1.FACTURA_COMPRA(1).png">
                        <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-FACTURA.png">
                </div>
                <div class="text"><b>FACTURA COMPRA</b></a></div>
            </li>

            <li style="--bg:#b145e9;">
                <div class="icon">
                    <a href="../no existe.html">
                        <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-5.2.FACTURA_COMPRA.png">
                        <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-FACTURA.png">
                </div>
                <div class="text"><b>FACTURA VENTA</b></a></div></a>
            </li>
        </ul>
    </div>
    <!-------------------------------------------------------------------  🏁  BARRA NAVEGACIÓN LATERAL --------------------------------------------------------------------------->
    <!----------------------------------------------------------------------- 🚀 CONTENIDO INTERFAZ ------------------------------------------------------------------------------->
    <main>
        <!------------------------------------------------------------------- 🚀 1.Modal Para Crear ------------------------------------------------------------------------------->
        <div id="Contenedor_Botones_Crear" class="container mt-5" style="position: relative;">
            <button type="button" id="Boton_Crear" class="boton animacion-buton" data-toggle="modal" data-target="#modalFormulario">
                <b>CREAR EMPLEADO</b>
            </button>

            <button type="submit" id="BOTON-REGISTRO-DETALLADO" class="boton animacion-buton-2 BOTON_ROL-EMPLE" data-toggle="modal" data-target="#modaldetalleFormulario">
                <b>REGISTROS DETALLADOS</b>
            </button>

            <!-- Ventana modal -->
            <div class="modal fade" id="modalFormulario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalFormularioLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 id="encabezado-modal">
                                <lord-icon
                                    src="https://cdn.lordicon.com/hqymfzvj.json"
                                    trigger="loop"
                                    delay="5000"
                                    colors="primary:#40591b"
                                    style="width:55px;height:55px">
                                </lord-icon>
                                <lord-icon
                                    src="https://cdn.lordicon.com/szoiozyr.json"
                                    trigger="loop"
                                    delay="5000"
                                    style="width:55px;height:55px">
                                </lord-icon><b>CREAR EMPLEADO</b>
                            </h2>
                            <button type="button" id="cerrar" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <!--🚀COMIENZA FORMULARIO MODAL-->
                            <form action="PROCESOS-EMPLEADO/Insertar_1.1.EMPLEADO.PHP" method="POST">

                                <!--COMIENZAN LOS INPUT DE TEXTO-->
                                <div id="Sub_Contenido_Crear">

                                    <div class="input-box">
                                        <label>Cédula</label>
                                        <input type="number" placeholder="Digite el código" name="TXT_Id_Emple" required>
                                    </div>

                                    <div class="input-box">
                                        <label>Nombre</label>
                                        <input type="text" placeholder="Digite el nombre" name="TXT_Nom_Emple" required>
                                    </div>

                                    <div class="combo-box">
                                        <label>RH</label>
                                        <select name="TXT_RH_Emple">
                                            <option select value="SELECION">SELECCIONE EL RH</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>

                                    <div class="input-box">
                                        <label>Dirección</label>
                                        <input type="text" placeholder="Digite dirección" name="TXT_Direc_Emple" required>
                                    </div>

                                    <div class="input-box">
                                        <label>Fecha de ingreso</label>
                                        <input type="date" placeholder="Digite fecha ingreso" name="TXT_Fecha_Ing_Emple" required>
                                    </div>

                                    <div class="input-box">
                                        <div id="añadir">
                                            <label>Teléfono</label>
                                            <a href="../1.2.TELEFONO_EMPLEADO/Index_1.2.TELEFONO_EMPLEADO.PHP">
                                                <lord-icon
                                                    src="https://cdn.lordicon.com/pdsourfn.json"
                                                    trigger="hover"
                                                    stroke="bold"
                                                    style="width:40px;height:40px">
                                                </lord-icon>
                                            </a>
                                        </div>
                                        <input type="number" placeholder="Digite teléfono" name="TXT_Tel_Emple" required>
                                    </div>

                                    <div class="input-box">
                                        <div id="añadir">
                                            <label>Email</label>
                                            <a href="../1.3.EMAIL_EMPLEADO/Index_1.3.EMAIL_EMPLEADO.PHP">
                                                <lord-icon
                                                    src="https://cdn.lordicon.com/pdsourfn.json"
                                                    trigger="hover"
                                                    stroke="bold"
                                                    style="width:40px;height:40px">
                                                </lord-icon>
                                            </a>
                                        </div>
                                        <input type="email" placeholder="Digite email" name="TXT_Email_Emple" required>
                                    </div>

                                    <div class="input-box">
                                        <label>Id Cargo</label>
                                        <input type="number" placeholder="Digite Id cargo" name="TXT_Id_Cargo_FK" required>
                                    </div>

                                    <div class="combo-box">
                                        <label>Estado</label>
                                        <select name="TXT_Estado_Emple">
                                            <option select value="SELECCIONE_ESTADO">SELECCIONE ESTADO</option>
                                            <option value="HABILITADO">HABILITADO</option>
                                            <option value="INHABILITADO">INHABILITADO</option>
                                        </select>
                                    </div>

                                    <div class="combo-box">
                                        <!--El "onchange" lo utilizaremos para llamar la función "redireccionar()" de JS
                                                cada vez que se seleccione una opción del combo-box-->
                                        <label>Otros</label>
                                        <select id="REDIRIGIR_COMBO-BOX" onchange="redireccionar()">
                                            <option select value="DATOS_ADICIONALES">DATOS ADICIONALES</option>
                                            <option value="CARGO">CARGO</option>
                                        </select>
                                    </div>

                                </div>
                                <!--TERMINAN LOS INPUT DE TEXTO-->

                                <!--COMIENZA BOTON INSERTAR-->
                                <div class="input-botones">
                                    <center><button class="boton animacion-buton" type="submit"><b>Insertar</b></button></center>
                                </div>
                                <!--COMIENZA BOTON INSERTAR-->

                            </form>
                            <!--🏁TERMINA FORMULARIO MODAL-->

                        </div>
                        <!--FIN MODAL-BODY-->
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------------------------------------------------- 🏁 Modal Para Crear ------------------------------------------------------------------------------->

        <!---------------------------------------------------------------------- 🚀 2.TABLA CONSULTA ------------------------------------------------------------------------------->
        <table id="TABLA_CONSULTAS" border="2">

            <thead>
                <tr id="h2_Consultas">
                    <script src="https://cdn.lordicon.com/lordicon.js"></script>
                    <th colspan="11">
                        <lord-icon
                            src="https://cdn.lordicon.com/szoiozyr.json"
                            trigger="loop"
                            delay="5000"
                            style="width:50px;height:50px">
                        </lord-icon>
                        <lord-icon
                            src="https://cdn.lordicon.com/lsrcesku.json"
                            trigger="loop"
                            delay="5000"
                            stroke="bold"
                            style="width:50px;height:50px">
                        </lord-icon><span>LISTA DE EMPLEADOS EXISTENTES</span>
                    </th>
                </tr>

                <tr id="Sub_Encabezado_Consultas">
                    <td>CÉDULA</td>
                    <td>NOMBRE</td>
                    <td>RH</td>
                    <td>DIRECCIÓN</td>
                    <td>FECHA INGRESO</td>
                    <td>TELÉFONO</td>
                    <td>EMAIL</td>
                    <td>ID CARGO</td>
                    <td>ESTADO</td>
                    <td colspan="2">ACCIONES</td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Campo_CÉDULA</td>
                    <td>Campo_NOMBRE</td>
                    <td>Campo_RH</td>
                    <td>Campo_DIRECCIÓN</td>
                    <td>Campo_FECHA INGRESO</td>
                    <td>Campo_TELÉFONO</td>
                    <td>Campo_EMAIL</td>
                    <td>Campo_ID_CARGO</td>
                    <td>Campo_ESTADO</td>

                    <td id="fila_boton-Actu_Elim" data-toggle="tooltip" data-placement="top" title="Actualizar">
                        <button class="boton animacion-buton" type="submit">
                            <a href="Editar_1.1.EMPLEADO.PHP?Id_Emple=1?>">
                                Actualizar
                            </a>
                        </button>
                    </td>

                    <td id="fila_boton-Actu_Elim">
                        <button id="ELIMINAR" class="boton animacion-buton" data-id="<?php echo $key['Id_Emple']; ?>" type="button">
                            ELIMINAR
                        </button>
                    </td>
                </tr>
        </table>
        <!--------------------------------------------------------------------- 🏁 TABLA CONSULTA ------------------------------------------------------------------------------->

    </main>
    <!------------------------------------------------------------------------- 🏁 CONTENIDO INTERFAZ --------------------------------------------------------------------------->

    <!---------------------------------------------------------------------------- 🚀 JAVA SCRIPT ------------------------------------------------------------------------------->

    <!------------------------------------------------------------------ 🚀 CONEXIÓN SIN 📡 BOOTSTRAP JS ------------------------------------------------------------------->
    <script src="../ESTILOS/js/jquery-3.5.1.min.js"></script>
    <script src="../ESTILOS/js/bootstrap.min.js"></script>
    <!------------------------------------------------------------------ 🏁 CONEXIÓN SIN 📡 BOOTSTRAP JS ------------------------------------------------------------------->

    <!---------------------------------------------------------------- 🚀 CONEXIÓN SIN 📡 "SWEET ALERT" JS ----------------------------------------------------------------->
    <script src="../ESTILOS/sweetalert2-main/sweetalert2.all.min.js"></script>
    <!---------------------------------------------------------------- 🏁 CONEXIÓN SIN 📡 "SWEET ALERT" JS ----------------------------------------------------------------->

    <!----------------------------------------------------------------------- 🚀 MENÚ DESPLEGABLE --------------------------------------------------------------------------->
    <script src="../JS/MENÚ_DESPLEGABLE.js"></script>
    <!----------------------------------------------------------------------- 🏁 MENÚ DESPLEGABLE --------------------------------------------------------------------------->

    <!---------------------------------------------------------------------- 🚀 MENU USUARIO-FOTO --------------------------------------------------------------------------->
    <script src="../JS/INFO-LOGIN.js"></script>
    <!---------------------------------------------------------------------- 🏁 MENU USUARIO-FOTO --------------------------------------------------------------------------->

    <!------------------------------------------------------------------- 🚀 CONFIRMACIÓN CERRAR SESIÓN --------------------------------------------------------------------->
    <script src="../JS/CONFIRMAR_CERRAR_SESIÓN.js"></script>
    <!------------------------------------------------------------------- 🏁 CONFIRMACIÓN CERRAR SESIÓN --------------------------------------------------------------------->

    <!----------------------------------------------------------------- 🚀 COMBO-BOX FUNCIONAL CON LINKS -------------------------------------------------------------------->
    <script src="../JS/JS-1.EMPLEADO/COMBO_BOX.js"></script>
    <!----------------------------------------------------------------- 🏁 COMBO-BOX FUNCIONAL CON LINKS -------------------------------------------------------------------->

    <!--------------------------------------------------------------------- 🚀 CONFIRMACIÓN ELIMINAR ------------------------------------------------------------------------>
    <script src="../JS/JS-1.EMPLEADO/CONFIRMAR_ELIMINAR-EMPLE.js"></script>
    <!--------------------------------------------------------------------- 🏁 CONFIRMACIÓN ELIMINAR ------------------------------------------------------------------------>

    <!---------------------------------------------------------------------------- 🏁 JAVA SCRIPT ------------------------------------------------------------------------------->

</body>

</html>