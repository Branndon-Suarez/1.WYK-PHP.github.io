<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empleado</title>
    <link rel="stylesheet" href="<?php \config\APP_URL; ?>public/css/sweetalert2.min.css">
</head>

<body>
    <h1>Crear Empleado</h1>
    <form id="create-empleado-form" method="POST">
        <div>
            <label for="Cedula_Empleado">Cédula</label>
            <input type="number" id="Cedula_Empleado" name="Cedula_Empleado" required>
        </div>
        <div>
            <label for="Nom_Empleado">Nombre</label>
            <input type="text" id="Nom_Empleado" name="Nom_Empleado" required>
        </div>
        <div>
            <label for="RH_Empleado">RH</label>
            <select  id="RH_Empleado" name="RH_Empleado" required>
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
        <div>
            <label for="Telefono_Empleado">Teléfono</label>
            <input type="number" id="Telefono_Empleado" name="Telefono_Empleado" required>
        </div>
        <div>
            <label for="Email_Empleado">Email</label>
            <input type="email" id="Email_Empleado" name="Email_Empleado" required>
        </div>
        <div>
            <label for="Cargo_Empleado">Cargo</label>
            <input type="number" id="Cargo_Empleado" name="Cargo_Empleado" required>
        </div>
        <div>
            <label for="Usuario_Empleado">Usuario</label>
            <input type="number" id="Usuario_Empleado" name="Usuario_Empleado" required>
        </div>
        <div>
            <button type="submit">Insertar</button>
        </div>
    </form>

    <script>
        const APP_URL = '<?php echo \config\APP_URL; ?>';
    </script>
    <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo \config\APP_URL; ?>public\js\empleado\confirmCreate.js"></script>
</body>

</html>
