<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cargo</title>
</head>

<body>
    <h1>Crear Cargo</h1>
    <form id="create-cargo-form" method="POST">
        <div>
            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="Nom_Cargo" required>
        </div>
        <div>
            <button type="submit">Insertar</button>
        </div>
    </form>

    <script>const APP_URL = '<?php echo \config\APP_URL; ?>';</script>
    <script src="<?php echo \config\APP_URL; ?>public\js\cargo\confirmCreate.js"></script>

</body>

</html>