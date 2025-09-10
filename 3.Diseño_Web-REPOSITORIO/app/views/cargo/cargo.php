<!DOCTYPE html>
<html lang="es">

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">🥐</div>
    <div class="nav-btn" title="Inicio"><i data-feather="home"></i></div>
    <div class="nav-btn" title="Formularios"><i data-feather="file-text"></i></div>
    <div class="nav-btn" title="Ventas"><i data-feather="shopping-bag"></i></div>
    <div class="nav-btn" title="Pedidos"><i data-feather="shopping-cart"></i></div>
    <div class="nav-btn" title="Productos"><i data-feather="package"></i></div>
    <div class="nav-btn" title="Clientes"><i data-feather="users"></i></div>
    <div class="spacer"></div>
    <div class="nav-btn" title="Ajustes"><i data-feather="settings"></i></div>
  </aside>

  <!-- Main -->
  <main class="main">
    <div class="topbar">
      <strong>Factura de Venta</strong>
      <div class="search">
        <i data-feather="search" style="width:18px;height:18px;color:#94a3b8"></i>
        <input placeholder="Buscar cliente…">
      </div>
    </div>

    <!-- Formulario factura -->
    <form id="formFactura" class="formulario">

      <div class="form-grupo">
        <label for="fecha">Fecha y Hora</label>
        <input type="datetime-local" id="fecha" required>
      </div>

      <div class="form-grupo">
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" maxlength="200" required>
      </div>

      <div class="form-grupo">
        <label for="empleado">Empleado (ID):</label>
        <input type="number" id="empleado" required>
      </div>

      <div class="form-grupo">
        <label for="pedido">Pedido (ID):</label>
        <input type="number" id="pedido" required>
      </div>

      <div class="form-grupo">
        <label for="cliente">Cliente (ID):</label>
        <input type="number" id="cliente" required>
      </div>

      <div class="form-grupo">
        <label for="subtotal">Subtotal:</label>
        <input type="number" step="0.01" id="subtotal" required>
      </div>

      <!-- Muestro IVA y Total en el formulario (readonly) para ver el cálculo antes de agregar -->
      <div class="form-grupo">
        <label for="iva">IVA (19%):</label>
        <input type="number" id="iva" readonly>
      </div>

      <div class="form-grupo">
        <label for="total">Total:</label>
        <input type="number" id="total" readonly>
      </div>

      <div class="form-grupo">
        <label for="estado">Estado:</label>
        <select id="estado" required>
          <option value="PENDIENTE">Pendiente</option>
          <option value="PAGADA">Pagada</option>
          <option value="CANCELADA">Cancelada</option>
        </select>
      </div>

      <!--boton de enviar de universe (submit)-->
      <button type="submit">
        <div class="svg-wrapper-1">
          <div class="svg-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path fill="currentColor"
                d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z">
              </path>
            </svg>
          </div>
        </div>
        <span>Enviar Formulario</span>
      </button>

    </form>

    <!-- Tabla -->
    <table id="tablaFactura" class="tabla-factura" aria-live="polite">
      <thead>
        <tr>
          <th style="width:90px">Fecha Factura</th>
          <th>Descripción</th>
          <th style="width:110px">Empleado</th>
          <th style="width:110px">Pedido</th>
          <th style="width:110px">Cliente</th>
          <th style="width:110px">Estado</th>
          <th style="width:140px">Subtotal</th>
          <th style="width:200px">Acciones</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <td class="acciones" style="text-align:center">
      <button class="btn-accion btn-update" title="Actualizar">
        <i data-feather="edit-2"></i>
      </button>
      <button class="btn-accion btn-delete" title="Eliminar">
        <i data-feather="trash-2"></i>
      </button>
      <button class="btn-accion btn-toggle" title="Desactivar/activar">
        <i data-feather="slash"></i>
      </button>
    </td>


    <!-- Totales (globales) -->
    <div class="totales">
      <div class="muted">Subtotal: <span id="subtotalGlobal">$0.00</span></div>
      <div class="muted">IVA (19%): <span id="ivaGlobal">$0.00</span></div>
      <div>Total: <span id="totalGlobal">$0.00</span></div>
    </div>

  </main>

  <script src="https://unpkg.com/feather-icons"></script>
</body>

</html>