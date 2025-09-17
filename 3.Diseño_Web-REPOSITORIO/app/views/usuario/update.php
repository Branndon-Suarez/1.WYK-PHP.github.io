<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
</head>

<body>
    <h1>Actualizar Usuario</h1>
    <form id="update-usuario-form" action="<?php echo \config\APP_URL . 'usuario/update'; ?>" method="POST">
        <div>
            <input hidden="" type="number" id="id_usuario" name="id_usuario" value="<?php echo $usuario['ID_USUARIO']; ?>" required>
        </div>
        <div>
            <label for="nombre_usuario">Nombre de usuario</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario['NOMBRE_USUARIO']); ?>" required>
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="fecha_registro">Fecha de registro</label>
            <input type="datetime-local" id="fecha_registro" name="fecha_registro" value="<?php echo htmlspecialchars($usuario['FECHA_REGISTRO']); ?>" required>
        </div>
        <div>
            <label for="fecha_ultima_sesion">Fecha de ultima sesión</label>
            <input type="datetime-local" id="fecha_ultima_sesion" name="fecha_ultima_sesion" value="<?php echo htmlspecialchars($usuario['FECHA_ULTIMA_SESION']); ?>" required>
        </div>
        <div>
            <label for="rol_usuario">Rol</label>
            <select id="rol_usuario" name="rol_usuario" required>
                <option selected value="<?php echo $usuario['ROL']; ?>"><?php echo $usuario['ROL']; ?></option>
                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                <option value="EMPLEADO">EMPLEADO</option>
                <option value="CLIENTE">CLIENTE</option>
            </select>
        </div>
        <div>
            <label for="estado_usuario">Estado</label>
            <select id="estado_usuario" name="estado_usuario" required>
                <option value="1" <?php echo $usuario['ESTADO_USUARIO'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $usuario['ESTADO_USUARIO'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>
        <div>
            <button type="submit">Actualizar</button>
        </div>
    </form>

    <script>const APP_URL = '<?php echo \config\APP_URL; ?>';</script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\usuario\confirmUpdate.js"></script>
</body>

</html>
