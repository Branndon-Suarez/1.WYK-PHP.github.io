<?php
    require_once ('../layout/HEADER-PROYECTO-EDITAR.PHP');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACTUALIZAR EMPLEADO</title>
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
                    <a href="../1.EMPLEADO/Index_1.1.EMPLEADO.php">
                    <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-1.1.EMPLEADO.png" alt="Logo_panaderia"> 
                </div>
                <div class="text"><b>EMPLEADO</b></a></div>
            </li>
            
            <li style="--bg:#fa3636;">
                <div class="icon">
                    <a href="../2.1.CLIENTE/Index_2.1.CLIENTE.PHP">
                    <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-2.1.CLIENTE.png">
                </div>
                <div class="text"><b>CLIENTE</b></a></div>
            </li>

            <li style="--bg:#0fc40f;">
                <div class="icon">
                    <a href="../3.1.PROVEEDOR/Index_3.1.PROVEEDOR.php">
                    <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-3.1.PROVEEDOR.png">
                </div>
                <div class="text"><b>PROVEEDOR</b></a></div>
            </li>

            <li style="--bg:#A69B03 ;">
                <div class="icon">
                    <a href="../4.1.PRODUCTO/Index_4.1.PRODUCTO.php">
                    <img class="icon_img" src="../IMG/IMAGENES-ICONOS/IMG-4.1.PRODUCTO.png">
                </div>
                <div class="text"><b>PRODUCTO</b></a></div>
            </li>

            <li style="--bg:#2196f3;">
                <div class="icon">
                    <a href="../5.1.FACTURA_COMPRA/Index_5.1.FACTURA_COMPRA.PHP">
                    <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-5.1.FACTURA_COMPRA(1).png">
                    <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-FACTURA.png">
                    </div>
                <div class="text"><b>FACTURA COMPRA</b></a></div>
            </li>

            <li style="--bg:#b145e9;">
                <div class="icon">
                    <a href="../6.1.FACTURA_VENTA/Index_6.1.FACTURA_VENTA.php">
                    <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-5.2.FACTURA_COMPRA.png">
                    <img class="icon_img fac_compra_img" src="../IMG/IMAGENES-ICONOS/IMG-FACTURA.png">
                </div>
                <div class="text"><b>FACTURA VENTA</b></a></div></a>
            </li>

            <li style="--bg:#A69B03;">
                <div class="icon">
                    <a href="../7.1.ENTRADA_INVENTARIO/Index_7.1.ENTRADA_INVENTARIO.php">
                    <img class="icon_img entrada_img" src="../IMG/IMAGENES-ICONOS/IMG-7.1.ENRADA_INVENTARIO.png">
                </div>
                <div class="text"><b>ENTRADA INVENTARIO</b></a></div>
            </li>

            <li style="--bg:#b96c06;">
                <div class="icon">
                    <a href="../8.1.SALIDA_INVENTARIO/Index_8.1.SALIDA_INVENTARIO.php">
                    <img class="icon_img salida_img" src="../IMG/IMAGENES-ICONOS/IMG-8.1.SALIDA_INVENTARIO.png">
                </div>
                <div class="text"><b>SALIDA INVENTARIO</b></a></div>
            </li>

        </ul>

    </div>
<!-------------------------------------------------------------------  🏁  BARRA NAVEGACIÓN LATERAL --------------------------------------------------------------------------->
<!----------------------------------------------------------------------- 🚀 CONTENIDO INTERFAZ ------------------------------------------------------------------------------->
    <main>
    <!------------------------------------------------------------------- 🚀 1.Formulario Actualizar -------------------------------------------------------------------------->
        <div id="Contenido_Actualizar">
            <form data-actu="form_actu" action="PROCESOS-EMPLEADO/Actualizar_1.1.EMPLEADO.PHP" method="POST">

                <h2 id="h2_Actualizar"><script src="https://cdn.lordicon.com/lordicon.js"></script>
                    <lord-icon
                        src="https://cdn.lordicon.com/szoiozyr.json"
                        trigger="loop"
                        delay="5000"
                        style="width:50px;height:50px">
                    </lord-icon>
                    <lord-icon
                        src="https://cdn.lordicon.com/lsrcesku.json"
                        trigger="loop"
                        delay="4000"
                        stroke="bold"
                        style="width:50px;height:50px">
                    </lord-icon>ACTUALIZAR EMPLEADO</h2>

                <!--COMIENZAN LOS INPUT DE TEXTO-->
                <input type="number" hidden="" value="1" name="Id_Emple">

                <div id="Sub_Contenido_Actualizar">

                    <div class="input-box">
                        <b><label>Nombre del Empleado</label></b>
                        <input type="text" name="txt_nom_emple" value="Campo_NOMBRE"><br><br>
                    </div>

                    <div class="combo-box">
                        <b><label>RH del Empleado</label></b><br>
                        <select name="txt_rh_emple">
                            <option select>Campo_RH</option>
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
                        <b><label>Dirección del Empleado</label></b>
                        <input type="text" name="txt_direc_emple" value="Campo_DIRECCIÓN"><br><br>
                    </div>

                    <div class="input-box">
                        <b><label>Fecha de ingreso</label></b>
                        <input type="date" name="txt_fecha_ing_emple" value="Campo_FECHA INGRESO"><br><br>
                    </div>

                    <div class="input-box">
                        <b><label>Teléfono</label></b>
                        <input type="number" name="txt_tel_emple" value="Campo_TELÉFONO"><br><br>
                    </div>

                    <div class="input-box">
                        <b><label>Email</label></b>
                        <input type="email" name="txt_email_emple" value="Campo_EMAIL"><br><br>
                    </div>

                    <div class="input-box">
                        <b><label>Id del Cargo</label></b>
                        <input type="number" name="txt_id_cargo_fk" value="Campo_ID_CARGO"><br><br>
                    </div>

                    <div class="combo-box">
                        <b><label>Estado Empleado</label></b><br>
                        <select name="txt_estado_emple">
                            <option select>Campo_ESTADO</option>
                            <option value="HABILITADO">Activo</option>
                            <option value="INHABILITADO">Inactivo</option>
                        </select><br><br>
                    </div>

                </div>
                <!--TERMINAN LOS INPUT DE TEXTO-->

                <!--COMIENZAN LOS BOTONES-CRUD-->
                <center><button id="ACTUALIZAR" class="boton animacion-buton" type="submit"><b>Actualizar</b></button></center>
                <!--TERMINAN LOS BOTONES-CRUD-->

            </form>
        </div>
    <!------------------------------------------------------------------- 🏁 1.Formulario Actualizar ------------------------------------------------------------------------>
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

    <!---------------------------------------------------------------------- 🚀 MENU USUARIO-FOTO --------------------------------------------------------------------------->
    <script src="../JS/INFO-LOGIN.js"></script>
    <!---------------------------------------------------------------------- 🏁 MENU USUARIO-FOTO --------------------------------------------------------------------------->

    <!----------------------------------------------------------------------- 🚀 MENÚ DESPLEGABLE --------------------------------------------------------------------------->
    <script src="../JS/MENÚ_DESPLEGABLE.js"></script>
    <!----------------------------------------------------------------------- 🏁 MENÚ DESPLEGABLE --------------------------------------------------------------------------->

    <!------------------------------------------------------------------- 🚀 CONFIRMACIÓN CERRAR SESIÓN --------------------------------------------------------------------->
    <script src="../JS/CONFIRMAR_CERRAR_SESIÓN.js"></script>
    <!------------------------------------------------------------------- 🏁 CONFIRMACIÓN CERRAR SESIÓN --------------------------------------------------------------------->

    <!--------------------------------------------------------------------- 🚀 CONFIRMACIÓN ACTUALIZAR ---------------------------------------------------------------------->
    <script src="../JS/JS-1.EMPLEADO/CONFIRMAR_ACTU-EMPLE.js"></script>
    <!--------------------------------------------------------------------- 🏁 CONFIRMACIÓN ACTUALIZAR ---------------------------------------------------------------------->

<!---------------------------------------------------------------------------- 🏁 JAVA SCRIPT ------------------------------------------------------------------------------->

</body>
</html>