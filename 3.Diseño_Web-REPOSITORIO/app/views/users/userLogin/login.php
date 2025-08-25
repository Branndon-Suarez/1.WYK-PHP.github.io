<?php
session_start();

$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>
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
    <main>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form action="../../../controllers/LoginUser/LoginController.php" class="sign-in-form" method="post">
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
                            <input type="text" name="name_usuario" placeholder="Digite su nombre de usuario" required>
                        </div>

                        <div class="input-field">
                            <lord-icon
                                src="https://cdn.lordicon.com/zbbefawl.json"
                                trigger="hover"
                                style="width:50px;height:50px"
                                id="icon_2-candado">
                            </lord-icon>
                            <input type="password" name="password" placeholder="Digite su contraseña" required>
                        </div>
                        <button type="submit" name="boton_login" class="btn solid">Iniciar Sesión</button>

                        <tr>
                            <td colspan="2"></td>
                            <?php if (!empty($error_message)): ?>
                                <span id="Mensaje-Login-error"><b><?php echo $error_message; ?></b></span>
                            <?php endif; ?>
                            </td><br>
                        </tr><br>
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
                    <img src="../../../../public/images/imgLogin/login-1.svg" class="image" alt="">
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
                    <img src="../../../../public/images/imgLogin/login-2.svg" class="image" alt="">
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });
    </script>
</body>
</html>
