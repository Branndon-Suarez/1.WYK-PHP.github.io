<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cargo</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
</head>

<body>
    <h1>Actualizar Cargo</h1>
    <form id="update-cargo-form" action="<?php echo \config\APP_URL . 'cargos/update'; ?>" method="POST">
        <div>
            <input hidden="" type="number" id="Id_Cargo" name="Id_Cargo" value="<?php echo $cargo['ID_CARGO']; ?>" required>
        </div>
        <div>
            <label for="Nom_Cargo">Cargo</label>
            <input type="text" id="Nom_Cargo" name="Nom_Cargo" value="<?php echo htmlspecialchars($cargo['NOMBRE_CARGO']); ?>" required>
        </div>
        <div>
            <label for="Estado_Cargo">Estado</label>
            <select id="Estado_Cargo" name="Estado_Cargo" required>
                <option value="1" <?php echo $cargo['ESTADO_CARGO'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $cargo['ESTADO_CARGO'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>
        <div>
            <button type="submit">Actualizar</button>
        </div>
    </form>

    <script>const APP_URL = '<?php echo \config\APP_URL; ?>';</script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\cargo\confirmUpdate.js"></script>
</body>

</html>
