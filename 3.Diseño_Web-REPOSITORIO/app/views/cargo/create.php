<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cargo</title>
</head>

<body>
    <h1>Crear Cargo</h1>
    <!-- Nota: ¿Cómo funciona? -->
    <!-- 1. METODO GET = mostrar solamente el create.php de cargo.
            1.1. Desde el dashboard de cargos, el boton de "+ Nuevo cargo" redirige a esta página.
            1.2. Se pone en la URL al final el "cargos/create" para que el index.php y el autoload haga su proceso
            1.3. Esto carga el controlador de cargo y en este precesa si fue por metodo GET o POST
            1.4. Como fue por GET se salta la validación del formulario y solo redirige nuevamente al create.php-->
    <!-- 1. METODO POST = validar el formulario.
            1.1. Luego que el controlador alla mostrado el create.php mediante "require_once __DIR__ . '/../views/cargo/create.php';" ahora se llena el formulario y se da click en "Insertar".
            1.2. Como ahora se inserto en el formulario, entonces ahora el controlador de cargo ejecutara la parte con POST.
            1.3. El controlador de cargo hace uso del modelo de cargo para crear el nuevo cargo en la base de datos.
            1.4. Finalmente el controlador genera el mensaje de éxito y redirige al usuario al dashboard de cargos.-->
    <form action="<?php echo \config\APP_URL; ?>cargos/create" method="POST">
        <div>
            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="Nom_Cargo" required>
        </div>
        <div>
            <button type="submit">Insertar</button>
        </div>
    </form>
</body>

</html>