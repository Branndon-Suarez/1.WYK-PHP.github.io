<?php
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="es">
<body>
  <aside class="menu_lateral" id="menuLateral">
    <nav class="opciones_menu">
      <div class="opcion activa"><i class="fas fa-home"></i><span class="texto">Inicio</span></div>
      <div class="opcion"><i class="fas fa-user"></i><span class="texto">Usuarios</span></div>
      <div class="opcion"><i class="fas fa-comment-alt"></i><span class="texto">Mensajes</span></div>
      <div class="opcion"><i class="fas fa-question"></i><span class="texto">Ayuda</span></div>
      <div class="opcion"><i class="fas fa-cog"></i><span class="texto">Configuración</span></div>
      <div class="opcion"><i class="fas fa-lock"></i><span class="texto">Seguridad</span></div>
      <div class="opcion"><i class="fas fa-sign-out-alt"></i><span class="texto">
        <a href="<?php echo \Config\APP_URL . 'logout'; ?>">Salir</a>
      </span></div>
    </nav>
  </aside>

  <main class="contenido_panel">
    <section class="tarjetas_resumen">
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Total Ventas</h4>
            <p>$5,200.000</p>
          </div>
          <i class="fas fa-dollar-sign" style="font-size: 40px; color: #2563eb;"></i>
        </div>
      </div>
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Pedidos Postres personalizados (Hoy)</h4>
            <p>132</p>
          </div>
          <i class="fas fa-receipt" style="font-size: 40px; color: #059669;"></i>
        </div>
      </div>
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Clientes</h4>
            <p>54</p>
          </div>
          <i class="fas fa-users" style="font-size: 40px; color: #d97706;"></i>
        </div>
      </div>
      <div class="tarjeta">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h4>Productos en stock</h4>
            <p>328</p>
          </div>
          <i class="fas fa-boxes" style="font-size: 40px; color: #6b21a8;"></i>
        </div>
      </div>
    </section>

    <section class="graficas_panel">
      <div class="grafico" id="grafico_ventas">
        <h3>Ventas Semanales</h3>
        <canvas id="ventasChart"></canvas>
      </div>
      <div class="grafico" id="grafico_productos">
        <h3>Productos Más Vendidos</h3>
        <canvas id="productosChart"></canvas>
      </div>
    </section>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"
    integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
    crossorigin="anonymous">
  </script>
  <script src="<?php echo \Config\APP_URL; ?>public/js/dashboard.js"></script>
  <script src="<?php echo \Config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script>
    const successMessage = "<?php echo $success_message; ?>";
    const errorMessage = "<?php echo $error_message; ?>";
  </script>
  <script src="<?php echo \Config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>
</body>
</html>
