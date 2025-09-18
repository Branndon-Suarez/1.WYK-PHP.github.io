<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
</head>

<body>
    <h1>Actualizar Cliente</h1>
    <form id="update-cliente-form" action="<?php echo \config\APP_URL . 'clientes/update'; ?>" method="POST">
        <div>
            <input hidden="" type="number" id="Id_Cliente" name="Id_Cliente" value="<?php echo $cliente['ID_CLIENTE']; ?>" required>
        </div>
        <div>
            <label for="Num_Doc_Cliente">N° Doc.</label>
            <input type="number" id="Num_Doc_Cliente" name="Num_Doc_Cliente" value="<?php echo htmlspecialchars($cliente['NUM_DOCUMENTO_CLIENTE']); ?>" required>
        </div>
        <div>
            <label for="Tipo_Doc_Cliente">Tipo Doc.</label>
            <input type="text" id="Tipo_Doc_Cliente" name="Tipo_Doc_Cliente" value="<?php echo htmlspecialchars($cliente['TIPO_DOCUMENTO_CLIENTE']); ?>" required>
        </div>
        <div>
            <label for="Nom_Cliente">Nombre</label>
            <input type="text" id="Nom_Cliente" name="Nom_Cliente" value="<?php echo htmlspecialchars($cliente['NOMBRE_CLIENTE']); ?>" required>
        </div>
        <div>
            <label for="Telefono_Cliente">Telefono</label>
            <input type="tel" id="Telefono_Cliente" name="Telefono_Cliente" value="<?php echo htmlspecialchars($cliente['TEL_CLIENTE']); ?>" required>
        </div>
        <div>
            <label for="Email_Cliente">Email</label>
            <input type="email" id="Email_Cliente" name="Email_Cliente" value="<?php echo htmlspecialchars($cliente['EMAIL_CLIENTE']); ?>" required>
        </div>
        <div>
            <label for="Usuario_Cliente">Usuario</label>
            <input type="number" id="Usuario_Cliente" name="Usuario_Cliente" value="<?php echo htmlspecialchars($cliente['ID_USUARIO_FK_CLIENTE']); ?>" required>
        </div>
        <div>
            <label for="Estado_Cliente">Estado</label>
            <select id="Estado_Cliente" name="Estado_Cliente" required>
                <option value="1" <?php echo $cliente['ESTADO_CLIENTE'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $cliente['ESTADO_CLIENTE'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>
        <div>
            <button type="submit">Actualizar</button>
        </div>
    </form>

    <script>const APP_URL = '<?php echo \config\APP_URL; ?>';</script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\cliente\confirmUpdate.js"></script>
</body>

</html>
