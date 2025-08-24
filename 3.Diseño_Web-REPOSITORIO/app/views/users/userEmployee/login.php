<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  
  <link rel="stylesheet" href="../../../../public/css/login.css">
  <title>Login Empleado</title>
</head>

<body>
    <header id="SELECCIONAR-LOGIN-ROL">
        <div class="empleado-seleccionado">
            <lord-icon
                src="https://cdn.lordicon.com/pbihtexz.json"
                trigger="hover"
                colors="primary:#000000,secondary:#b26836,tertiary:#eeca66,quaternary:#ebe6ef"
                style="width:50px;height:50px">
            </lord-icon>
            <span>Estas ingresando como un empleado</span>
            <button class="btn transparent">EMPLEADO</button>
        </div>

        <div class="cliente">
            <button class="btn transparent">
                <a href="LOGIN_CLIENTE/Index-LOGIN_CLIENTE.php">CLIENTE</a>
            </button>
            <span>¿Quieres ingresar como cliente?</span>
            <lord-icon
                src="https://cdn.lordicon.com/kiynvdns.json"
                trigger="hover"
                colors="primary:#0000,secondary:#a63754,tertiary:#eeca66,quaternary:#3080e8,quinary:#ebe6ef"
                style="width:50px;height:50px">
            </lord-icon>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form action="../../../controllers/UserController.php" class="sign-in-form" method="post">
                        <h2 class="title">Iniciar Sesión</h2>

                        <div class="input-field">
                            <lord-icon
                                src="https://cdn.lordicon.com/fmasbomy.json"
                                trigger="hover"
                                stroke="bold"
                                colors="primary:#000000,secondary:#a63754,tertiary:#eeca66"
                                style="width:50px;height:50px"
                                id="icon_2-candado">
                            </lord-icon>
                            <input type="text" name="Cedula_fk" placeholder="Digite su cédula" required>
                        </div>

                        <div class="input-field">
                            <lord-icon
                                src="https://cdn.lordicon.com/zbbefawl.json"
                                trigger="hover"
                                style="width:50px;height:50px"
                                id="icon_2-candado">
                            </lord-icon>
                            <input type="password" name="contrasena" placeholder="Digite su contraseña" required>
                        </div>
                        <button type="submit" name="boton_login" class="btn solid">Iniciar Sesión</button>

                        <tr>
                            <td colspan="2" align="center"
                                <?php if(isset($_GET['errorusuario_empleado']) && $_GET['errorusuario_empleado']=="existe_error"){?>>
                                    <span id="Mensaje-Login-error"><b>⚠️ Datos incorrectos. <br> Los datos del empleado no coinciden o no se encuentran registrados.</b></span>
                                <?php }else{?>
                                <?php }?>
                            </td>
                        </tr>

                    </form>

                    <form action="<!-- registrar_datos.php -->" id="formulario-registrarse" class="sign-up-form" method="post">

                        <h2 class="title">Registrarse</h2>
                        <div class="input-field">
                            <lord-icon
                                src="https://cdn.lordicon.com/fmasbomy.json"
                                trigger="hover"
                                stroke="bold"
                                colors="primary:#000000,secondary:#a63754,tertiary:#eeca66"
                                style="width:50px;height:50px"
                                id="icon_2-candado">
                            </lord-icon>
                            <input type="text" name="id_emple_fk" placeholder="Digite su cédula" required>
                        </div>

                        <div class="input-field">
                            <lord-icon
                                src="https://cdn.lordicon.com/zbbefawl.json"
                                trigger="hover"
                                style="width:50px;height:50px"
                                id="icon_2-candado">
                            </lord-icon>
                            <input type="password" name="password" placeholder="Cree una contraseña" required>
                        </div>
                        <input type="submit" class="btn" value="Registrarse">

                        <span id="mensaje-resultado"></span>

                    </form>
                </div>
            </div>

            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>¿No estás registrado?</h3>
                        <p>
                            !Si eres nuevo y aún no tienes un registro crea uno!
                        </p>
                        <button class="btn transparent" id="sign-up-btn">
                            Registrarse
                        </button>
                    </div>
                    <img src="../IMG/ilustraciones_login/iniciar_sesion_ilustracion.svg" class="image" alt="">
                </div>

                <div class="panel right-panel">
                    <div class="content">
                        <h3>¡Inicia Sesion!</h3>
                        <p>
                            Si ya verificaste que estás registrado, ahora inicia sesión a continuación.
                        </p>
                        <button class="btn transparent" id="sign-in-btn">
                            Iniciar Sesión
                        </button>
                    </div>
                    <img src="../IMG/ilustraciones_login/registrarse_ilustracion.svg" class="image" alt="">
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="JS/JS-INTERFAZ-LOGIN_REGISTRO.js"></script>
    <script>
        document.getElementById('formulario-registrarse').addEventListener('submit', function(event) {
            event.preventDefault();

            const obtener_datos = new FormData(this);
                fetch('registrar_datos.php', {
                method: 'POST',
                body: obtener_datos
            })
            .then(objeto_respuesta => objeto_respuesta.json())
            .then(data => {

                const obtener_mensaje_del_span = document.getElementById('mensaje-resultado');
                if (data.estado_fk === 'Confirmado') {
                    obtener_mensaje_del_span.textContent = data.mensaje;
                    obtener_mensaje_del_span.style.color = '#d2c8c8'; // Mensaje de éxito
                    obtener_mensaje_del_span.style.background = 'rgba(59, 187, 59, 0.449)';
                    document.getElementById('formulario-registrarse').reset(); // Limpiar formulario
                } else {
                    obtener_mensaje_del_span.textContent = data.mensaje;
                    obtener_mensaje_del_span.style.color = '#d2c8c8'; // Mensaje de error
                    obtener_mensaje_del_span.style.background = '#893048b2';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>