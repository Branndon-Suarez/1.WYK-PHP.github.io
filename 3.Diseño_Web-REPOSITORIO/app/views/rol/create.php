<!DOCTYPE html>
<html lang="es">
<title>Crear rol</title>

<body>
  <!-- Sidebar -->
  <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

  <main class="principal">
    <button type="button" class="volver" onclick="history.back()">
      <i data-feather="arrow-left"></i> Volver
    </button>

    <form id="create-rol-form" class="formulario" action="<?php echo \config\APP_URL; ?>roles/create" method="POST">
      <h1>Crear Rol</h1>

      <div class="grupo-formulario">
        <div class="campo">
          <label for="rol">Rol</label>
          <div class="contenedor-input">
            <input type="text" id="rol" name="rol" required placeholder="Ingresa el rol">
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="clasificacion_rol">Categoría</label>
          <div class="contenedor-input">
            <select id="clasificacion_rol" name="clasificacion_rol" required>
              <option value="">Seleccione una categoría</option>
              <option value="EMPLEADO">EMPLEADO</option>
              <option value="ADMINISTRADOR">ADMINISTRADOR</option>
            </select>
            <div class="resalte-input"></div>
          </div>
        </div>
      </div>

      <button type="submit">
        <i data-feather="plus-circle" style="margin-right: 8px; width: 20px; height: 20px;"></i>
        Crear Rol
      </button>
    </form>
  </main>

  <script>
    const APP_URL = '<?php echo \config\APP_URL; ?>';
  </script>
  <script src="https://cdn.lordicon.com/lordicon.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/rol/rol.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sidebar.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/rol/confirmCreate.js"></script>
</body>

</html>