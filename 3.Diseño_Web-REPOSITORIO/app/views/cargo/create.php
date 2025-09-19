<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cargo</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">

<body>
    <h1>Crear Cargo</h1>
    <form id="create-cargo-form" class="formulario" method="POST">
        <div>
            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="Nom_Cargo" required>
        </div>
        <div>
            <button type="submit">Insertar</button>
        </div>
    </form>

    <script>const APP_URL = '<?php echo \config\APP_URL; ?>';</script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\cargo\confirmCreate.js"></script>
</body>

</html>
