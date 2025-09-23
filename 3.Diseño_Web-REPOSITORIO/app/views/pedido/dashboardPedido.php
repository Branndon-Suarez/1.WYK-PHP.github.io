<?php

// Protege la vista (ajusta la condición según tu login)
if (!isset($_SESSION['userId'])) {
    header("Location: " . \config\APP_URL . "login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Nuevo Pedido - WYK Panadería</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?= \config\APP_URL ?>public/css/pedidosMesero.css">

  <!-- Variables para el JS externo -->
  <script>
    const APP_URL = '<?= rtrim(\config\APP_URL, "/") . '/' ?>';
    const USER_ID = <?= isset($_SESSION['userId']) ? (int)$_SESSION['userId'] : 'null' ?>;
  </script>
</head>
<body>
  <main class="pedido-container">
    <h2 class="titulo-pedido">🧾 Nuevo Pedido</h2>

    <!-- Datos de la venta -->
    <section class="form-grid">
      <div class="form-group">
        <label for="fechaVenta">Fecha y Hora</label>
        <input type="datetime-local" id="fechaVenta" name="fechaVenta"
               value="<?= date('Y-m-d\TH:i') ?>">
      </div>

      <div class="form-group">
        <label for="numeroMesa">Número de Mesa</label>
        <input type="number" id="numeroMesa" name="numeroMesa" placeholder="Ej: 5">
      </div>

      <div class="form-group">
        <label for="estadoVenta">Estado del Pedido</label>
        <select id="estadoVenta" name="estadoVenta">
          <option value="PENDIENTE" selected>PENDIENTE</option>
          <option value="ENTREGADA">ENTREGADA</option>
          <option value="PAGADA">PAGADA</option>
          <option value="CANCELADA">CANCELADA</option>
        </select>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label for="descripcion">Descripción (opcional)</label>
        <input id="descripcion" name="descripcion" type="text" placeholder="Notas del pedido">
      </div>
    </section>

    <!-- Productos -->
    <section class="productos-card">
      <div class="productos-header">
        <h3>Productos del Pedido</h3>
        <div>
          <button type="button" id="btnAddProducto" class="btn-azul">➕ Añadir Producto</button>
        </div>
      </div>

      <div class="table-wrap">
        <table class="tabla-productos">
          <thead>
            <tr>
              <th>Producto</th>
              <th style="width:120px">Cantidad</th>
              <th style="width:140px">Precio Unitario</th>
              <th style="width:140px">Subtotal</th>
              <th style="width:90px">Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaProductos">
            <!-- filas dinámicas -->
          </tbody>
        </table>
      </div>

      <div class="total-container">
        <span class="total-label">TOTAL:</span>
        <span id="totalGeneral" class="total-valor">0.00</span>
      </div>
    </section>

    <!-- Botón aceptar -->
    <div class="btn-guardar-container">
      <button id="btnGuardarPedido" class="btn-verde">✅ Aceptar Pedido</button>
    </div>
  </main>

  <!-- Modal productos (inicialmente hidden) -->
  <div id="modalProductos" class="modal hidden" aria-hidden="true">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Seleccionar Producto</h3>
        <button id="btnCerrarModal" class="btn-cerrar" aria-label="Cerrar">✖</button>
      </div>

      <div class="modal-body">
        <input type="text" id="buscarProducto" placeholder="Buscar producto..." class="input-busqueda">

        <div class="table-wrap">
          <table class="tabla-productos">
            <thead>
              <tr>
                <th>Nombre</th>
                <th style="width:120px">Precio</th>
                <th style="width:90px">Acción</th>
              </tr>
            </thead>
            <tbody id="listaProductos">
              <!-- se llenará con JS al abrir modal -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="<?= \config\APP_URL ?>public/js/pedido/pedidosMesero.js" defer></script>
</body>
</html>
