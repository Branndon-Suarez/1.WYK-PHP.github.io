<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Panadería</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo \config\APP_URL; ?>public/css/dashboard-inicio.css" />
  <link rel="stylesheet" href="<?php echo \config\APP_URL; ?>public/css/createCompra.css" />
  <link rel="stylesheet" href="<?php echo \config\APP_URL; ?>public/css/sidebar.css" />
  <link rel="stylesheet" href="<?php echo \config\APP_URL; ?>public/css/floatingIcon.css" />
  <link rel="stylesheet" href="<?php echo \config\APP_URL; ?>public/css/viewTareaEmpleado.css" />
  <link rel="stylesheet" href="<?php echo \config\APP_URL; ?>public/css/toggleSwitches.css" />
  <link rel="stylesheet" href="<?php echo \config\APP_URL; ?>public/css/sweetalert2.min.css">

  <script>
    const APP_URL = '<?= rtrim(\config\APP_URL, "/") . '/' ?>';
    const USER_ID = <?= isset($_SESSION['userId']) ? (int)$_SESSION['userId'] : 'null' ?>;
  </script>
  <!-- Lord icon aquí para que se inicialice antes de llamar 'pedidosMesero.js' para que se logre poner los iconos en ese js -->
  <script src="https://cdn.lordicon.com/lordicon.js" defer></script>
</head>
