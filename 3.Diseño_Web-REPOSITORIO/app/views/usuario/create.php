<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
</head>

<body>
    <h1>Crear Usuario</h1>
    <form id="create-usuario-form" method="POST">
        <div>
            <label for="Nom_Usuario">Nombre de Usuario</label>
            <input type="text" id="Nom_Usuario" name="Nom_Usuario" required>
        </div>
        <div>
            <label for="Password_Usuario">Contraseña</label>
            <input type="password" id="Password_Usuario" name="Password_Usuario" required>
        </div>
        <div>
            <label for="Rol_Usuario">Rol</label>
            <select name="Rol_Usuario" id="Rol_Usuario">
                <option value="ADMINISTRADOR">Administrador</option>
                <option value="EMPLEADO">Empleado</option>
                <option value="CLIENTE">Cliente</option>
            </select>
        </div>
        <div>
            <button type="submit">Insertar</button>
        </div>
    </form>

    <script>const APP_URL = '<?php echo \config\APP_URL; ?>';</script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\usuario\confirmCreate.js"></script>
</body>

</html>
