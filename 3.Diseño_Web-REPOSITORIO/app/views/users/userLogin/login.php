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
                    <form action="<?php echo \config\APP_URL; ?>controllers" id="login-form" class="sign-in-form" method="post" autocomplete="on">
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
                            <input type="number" name="num_doc_login" class="form-control" placeholder="N° documento" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
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
                            <input type="email" name="email_login" class="form-control" placeholder="Correo electrónico" autocomplete="email" required>
                        </div>

                        <div class="input-field">
                            <lord-icon
                                src="https://cdn.lordicon.com/zbbefawl.json"
                                trigger="hover"
                                style="width:50px;height:50px"
                                id="icon_2-candado">
                            </lord-icon>
                            <input type="password" name="password_login" class="form-control" placeholder="Contraseña" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
                        </div>
                        <button type="submit" name="boton_login" class="btn solid">Iniciar Sesión</button>
                    </form>
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
                            !Comunicate con el administrador del sistema!
                        </p>
                    </div>
                    <img src="<?php echo \config\APP_URL; ?>public/images/imgLogin/login-1.svg" class="image" alt="">
                </div>
            </div>
        </div>
    </main>

    <script src="<?php echo \config\APP_URL; ?>public/js/register.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js" integrity="sha256-1C3IZn03j9193YxLyK8PoFh0a0rfXzXk5KhS3OiN53s=" crossorigin="anonymous"></script>
    <script>
        const successMessage = "<?php echo $success_message; ?>";
        const errorMessage = "<?php echo $error_message; ?>";
    </script>
    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const container = document.querySelector(".container");
    </script>
</body>

</html>
