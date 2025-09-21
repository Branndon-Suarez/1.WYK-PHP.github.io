<!DOCTYPE html>
<html lang="es">
<title>Actualizar Rol</title>

<body>
  <!-- Sidebar -->
  <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

  <main class="principal">
    <button type="button" class="volver" onclick="history.back()">
      <i data-feather="arrow-left"></i> Volver
    </button>

    <form id="update-rol-form" class="formulario" action="<?php echo \config\APP_URL; ?>roles/update" method="POST">
      <h1>Actualizar Rol</h1>

      <div class="grupo-formulario">
        <input type="hidden" id="Id_Rol" name="Id_Rol" value="<?php echo $rol['ID_ROL']; ?>" required>

        <div class="campo">
          <label for="Nom_Cargo">Rol</label>
          <div class="contenedor-input">
            <input type="text" id="Rol" name="Rol" value="<?php echo htmlspecialchars($rol['ROL']); ?>" required placeholder="Rol">
            <div class="resalte-input"></div>
          </div>
        </div>

        <div class="campo">
          <label for="Clasificacion_Rol">Clasificación</label>
          <div class="contenedor-input">
            <select id="Clasificacion_Rol" name="Clasificacion_Rol" required>
              <option selected value="<?php echo htmlspecialchars($rol['CLASIFICACION']); ?>"><?php echo htmlspecialchars($rol['CLASIFICACION']); ?></option>
              <option value="ADMINISTRADOR">ADMINISTRADOR</option>
              <option value="EMPLEADO">EMPLEADO</option>
            </select>
          </div>
        </div>

        <div class="campo">
          <label for="Estado_Rol">Estado</label>
          <div class="contenedor-input">
            <select id="Estado_Rol" name="Estado_Rol" required>
              <option value="1" <?php echo $rol['ESTADO_ROL'] == 1 ? 'selected' : ''; ?> class="estado-activo">✓ Activo</option>
              <option value="0" <?php echo $rol['ESTADO_ROL'] == 0 ? 'selected' : ''; ?> class="estado-inactivo">✗ Inactivo</option>
            </select>
          </div>
        </div>
      </div>

      <button type="submit">
        <i data-feather="refresh-cw" style="margin-right: 8px; width: 20px; height: 20px;"></i>
        Actualizar Cargo
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
  <script src="<?php echo \config\APP_URL; ?>public/js/rol/confirmUpdate.js"></script>
</body>

</html>