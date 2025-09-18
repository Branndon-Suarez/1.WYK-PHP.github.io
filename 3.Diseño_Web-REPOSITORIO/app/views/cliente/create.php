<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
</head>

<body>
    <h1>Crear Cliente</h1>
    <form id="create-cliente-form" method="POST">
        <div>
            <label for="Num_Doc_Cliente">N° Documento</label>
            <input type="number" id="Num_Doc_Cliente" name="Num_Doc_Cliente" required>
        </div>
        <div>
            <label for="Tipo_Doc_Cliente">Tipo de documento</label>
            <input type="text" id="Tipo_Doc_Cliente" name="Tipo_Doc_Cliente" required>
        </div>
        <div>
            <label for="Nom_Cliente">Nombre</label>
            <input type="text" id="Nom_Cliente" name="Nom_Cliente" required>
        </div>
        <div>
            <label for="Telefono_Cliente">Teléfono</label>
            <input type="number" id="Telefono_Cliente" name="Telefono_Cliente" required>
        </div>
        <div>
            <label for="Email_Cliente">Email</label>
            <input type="email" id="Email_Cliente" name="Email_Cliente" required>
        </div>
        <div>
            <label for="Usuario_Cliente">Usuario</label>
            <input type="number" id="Usuario_Cliente" name="Usuario_Cliente" required>
        </div>
        <div>
            <button type="submit">Insertar</button>
        </div>
    </form>

    <script>
        const APP_URL = '<?php echo \config\APP_URL; ?>';
    </script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\cliente\confirmCreate.js"></script>
</body>

</html>
