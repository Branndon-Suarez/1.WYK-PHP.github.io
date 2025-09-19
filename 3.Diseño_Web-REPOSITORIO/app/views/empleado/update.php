<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Empleado</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
</head>

<body>
    <h1>Actualizar Empleado</h1>
    <form id="update-empleado-form" action="<?php echo \config\APP_URL . 'empleados/update'; ?>" method="POST">
        <div>
            <input hidden="" type="number" id="Id_Empleado" name="Id_Empleado" value="<?php echo $empleado['ID_EMPLEADO']; ?>" required>
        </div>
        <div>
            <label for="Cedula_Empleado">Cédula</label>
            <input type="number" id="Cedula_Empleado" name="Cedula_Empleado" value="<?php echo htmlspecialchars($empleado['CC_EMPLEADO']); ?>" required>
        </div>
        <div>
            <label for="Nom_Empleado">Nombre</label>
            <input type="text" id="Nom_Empleado" name="Nom_Empleado" value="<?php echo htmlspecialchars($empleado['NOMBRE_EMPLEADO']); ?>" required>
        </div>
        <div>
            <label for="RH_Empleado">RH</label>
            <select id="RH_Empleado" name="RH_Empleado" required>
                <option value="<?php echo $empleado['RH_EMPLEADO']; ?>"><?php echo $empleado['RH_EMPLEADO']; ?></option>
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
        </div>
        <div>
            <label for="Telefono_Empleado">Telefono</label>
            <input type="tel" id="Telefono_Empleado" name="Telefono_Empleado" value="<?php echo htmlspecialchars($empleado['TEL_EMPLEADO']); ?>" required>
        </div>
        <div>
            <label for="Email_Empleado">Email</label>
            <input type="email" id="Email_Empleado" name="Email_Empleado" value="<?php echo htmlspecialchars($empleado['EMAIL_EMPLEADO']); ?>" required>
        </div>
        <div>
            <label for="Cargo_Empleado">Cargo</label>
            <input type="number" id="Cargo_Empleado" name="Cargo_Empleado" value="<?php echo htmlspecialchars($empleado['ID_CARGO_FK_EMPLEADO']); ?>" required>
        </div>
        <div>
            <label for="Usuario_Empleado">Usuario</label>
            <input type="number" id="Usuario_Empleado" name="Usuario_Empleado" value="<?php echo htmlspecialchars($empleado['ID_USUARIO_FK_EMPLEADO']); ?>" required>
        </div>
        <div>
            <label for="Estado_Empleado">Estado</label>
            <select id="Estado_Empleado" name="Estado_Empleado" required>
                <option value="1" <?php echo $empleado['ESTADO_EMPLEADO'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $empleado['ESTADO_EMPLEADO'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>
        <div>
            <button type="submit">Actualizar</button>
        </div>
    </form>

    <script>const APP_URL = '<?php echo \config\APP_URL; ?>';</script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\empleado\confirmUpdate.js"></script>
</body>

</html>
