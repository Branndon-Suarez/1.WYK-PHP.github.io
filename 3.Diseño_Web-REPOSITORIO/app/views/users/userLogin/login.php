<?php
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <main>
        <div class="container">
            <div class="forms-container">
                <div class="container-login">
                    <form action="<?php echo \Config\APP_URL; ?>app/controllers/LoginUser/LoginController.php" class="sign-in-form" method="post">
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
                            <input type="password" name="password" placeholder="Digite su contraseña" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
                        </div>

                        <div class="input-field">
                            <lord-icon
                                src="https://cdn.lordicon.com/zbbefawl.json"
                                trigger="hover"
                                style="width:50px;height:50px"
                                id="icon_2-candado">
                            </lord-icon>
                            <input type="password" name="confirm_password" placeholder="Verificar contraseña" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
                        </div>
                        <button type="submit" name="boton_login" class="btn solid">Iniciar Sesión</button>
                    </form>
                </div>

                <div class="container-register">
                    <div class="form-container active" id="register-form">
                        <h1 class="form-title">Registrarse</h1>

                        <form id="register-form-submit" onsubmit="return false;">
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
                                <input type="password" name="password" placeholder="Digite su contraseña" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
                            </div>

                            <div class="input-field">
                                <lord-icon
                                    src="https://cdn.lordicon.com/zbbefawl.json"
                                    trigger="hover"
                                    style="width:50px;height:50px"
                                    id="icon_2-candado">
                                </lord-icon>
                                <input type="password" name="confirm_password" placeholder="Verificar contraseña" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
                            </div>

                            <button type="submit" class="btn-primary" onclick="showSignup()">
                                <i class="fas fa-spinner loading"></i>
                                <span class="btn-text">Sign In</span>
                            </button>
                        </form>
                    </div>

                    <div class="form-container" id="info-personal-form">
                        <h1 class="form-title">Información personal</h1>
                        <p class="form-subtitle">Join thousands of users and start your journey today</p>

                        <form id="info-personal-form-submit" action="<?php echo \Config\APP_URL; ?>app/controllers/LoginUser/RegisterController.php" method="POST">
                            <input type="hidden" name="name_usuario" id="name_usuario">
                            <input type="hidden" name="password" id="password">
                            <input type="hidden" name="confirm_password" id="confirm_password">
                            <div class="input-field">
                                <lord-icon
                                    src="https://cdn.lordicon.com/fmasbomy.json"
                                    trigger="hover"
                                    stroke="bold"
                                    colors="primary:#000000,secondary:#a63754,tertiary:#eeca66"
                                    style="width:50px;height:50px"
                                    id="icon_2-candado">
                                </lord-icon>
                                <input type="number" name="num_documento" placeholder="Digite su número de documento" required>
                            </div>

                            <div class="input-field">
                                <lord-icon
                                    src="https://cdn.lordicon.com/fmasbomy.json"
                                    trigger="hover"
                                    stroke="bold"
                                    colors="primary:#000000,secondary:#a63754,tertiary:#eeca66"
                                    style="width:50px;height:50px"
                                    id="icon_2-candado">
                                </lord-icon>
                                <select name="tipo_documento" id="tipo_documento">
                                    <option value="cc">Cédula de Ciudadanía</option>
                                    <option value="ce">Cédula de Extranjería</option>
                                </select>
                            </div>

                            <div class="input-field">
                                <lord-icon
                                    src="https://cdn.lordicon.com/fmasbomy.json"
                                    trigger="hover"
                                    stroke="bold"
                                    colors="primary:#000000,secondary:#a63754,tertiary:#eeca66"
                                    style="width:50px;height:50px"
                                    id="icon_2-candado">
                                </lord-icon>
                                <input type="text" name="nombre_completo" placeholder="Digite su nombre completo" required>
                            </div>

                            <div class="input-field">
                                <lord-icon
                                    src="https://cdn.lordicon.com/fmasbomy.json"
                                    trigger="hover"
                                    stroke="bold"
                                    colors="primary:#000000,secondary:#a63754,tertiary:#eeca66"
                                    style="width:50px;height:50px"
                                    id="icon_2-candado">
                                </lord-icon>
                                <input type="number" name="telefono" placeholder="Digite su teléfono" required>
                            </div>

                            <div class="input-field">
                                <lord-icon
                                    src="https://cdn.lordicon.com/fmasbomy.json"
                                    trigger="hover"
                                    stroke="bold"
                                    colors="primary:#000000,secondary:#a63754,tertiary:#eeca66"
                                    style="width:50px;height:50px"
                                    id="icon_2-candado">
                                </lord-icon>
                                <input type="email" name="email" class="form-control" placeholder="Digite su correo electrónico" required>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-spinner loading"></i>
                                <span class="btn-text">Crear cuenta</span>
                            </button>
                        </form>

                        <div class="form-switch">
                            <a href="#" onclick="showLogin()">Devolver</a>
                        </div>
                    </div>

                    <!-- Forgot Password Form -->
                    <div class="form-container" id="forgotForm">
                        <h1 class="form-title">Reset Password</h1>
                        <p class="form-subtitle">Enter your email address and we'll send you instructions to reset your password</p>

                        <form id="forgotFormSubmit">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email Address" required>
                                <i class="fas fa-envelope"></i>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-spinner loading"></i>
                                <span class="btn-text">Send Reset Instructions</span>
                            </button>
                        </form>

                        <div class="form-switch">
                            Remember your password? <a href="#" onclick="showLogin()">Sign in</a>
                        </div>
                    </div>
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
                    <img src="<?php echo \Config\APP_URL; ?>public/images/imgLogin/login-1.svg" class="image" alt="">
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
                    <img src="<?php echo \Config\APP_URL; ?>public/images/imgLogin/login-2.svg" class="image" alt="">
                </div>
            </div>
        </div>
    </main>

    <script src="<?php echo \Config\APP_URL; ?>public/js/register.js"></script>
    <script src="<?php echo \Config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \Config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js" integrity="sha256-1C3IZn03j9193YxLyK8PoFh0a0rfXzXk5KhS3OiN53s=" crossorigin="anonymous"></script>
    <script>
        const successMessage = "<?php echo $success_message; ?>";
        const errorMessage = "<?php echo $error_message; ?>";
    </script>
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
