<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cargo</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
    <style>
        .formulario {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 30px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-grupo {
        display: flex;
        flex-direction: column;
        }

        .form-grupo label {
        margin-bottom: 5px;
        font-weight: bold;
        }

        .form-grupo input,
        .form-grupo select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        }

        .form-grupo input:focus,
        .form-grupo input:hover {
        outline: none;
        border-color: rgba(108, 46, 5, 0.4);
        background-color: #fff;
        box-shadow: 0 0 0 6px rgba(59, 26, 2, 0.1);
        }
    </style>
</head>

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