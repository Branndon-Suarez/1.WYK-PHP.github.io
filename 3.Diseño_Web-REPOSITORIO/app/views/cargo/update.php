<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cargo</title>
</head>

<body>
    <h1>Actualizar Cargo</h1>
    <form action="<?php echo \config\APP_URL; ?>cargos/update" method="POST">
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
</body>

</html>
