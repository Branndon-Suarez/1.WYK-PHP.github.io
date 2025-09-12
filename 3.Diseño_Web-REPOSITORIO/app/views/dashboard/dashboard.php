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
  <div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">🥐</div>
      <div class="nav-btn" title="Inicio"><i data-feather="home"><a href="<?php echo \config\APP_URL . 'dashboard'; ?>"></a></i></div>
      <div class="nav-btn" title="Cargos"><a href="<?php echo \config\APP_URL . 'cargos'; ?>"><i data-feather="file-text">Cargos</a></i></div>
      <div class="nav-btn" title="Ventas"><a href="<?php echo \config\APP_URL . 'ventas'; ?>"><i data-feather="shopping-bag"></i>Ventas</a></div>
      <div class="nav-btn" title="Pedidos"><a href="<?php echo \config\APP_URL . 'pedidos'; ?>"><i data-feather="shopping-cart"></i>Pedidos</a></div>
      <div class="nav-btn" title="Productos"><a href="<?php echo \config\APP_URL . 'productos'; ?>"><i data-feather="package"></i>Productos</a></div>
      <div class="nav-btn" title="Clientes"><a href="<?php echo \config\APP_URL . 'clientes'; ?>"><i data-feather="users"></i>Clientes</a></div>
      <div class="spacer"></div>
      <div class="nav-btn" title="Ajustes"><i data-feather="settings"></i></div>
      <div class="nav-btn"><i class="fas fa-sign-out-alt"></i><span class="texto">
        </span></div>
    </aside>

    <main class="main">
      <!-- Topbar -->
      <div class="topbar card">
        <strong>PANADERIA WYK— Panel Control <a href="<?php echo \config\APP_URL . 'logout'; ?>">Salir</a></strong>
        <div class="search">
          <i data-feather="search" style="width:18px;height:18px;color:#94a3b8"></i>
          <input placeholder="Buscar productos, clientes, pedidos…" />
        </div>
        <button id="openModal" class="btn btn-primary">+ Nuevo pedido</button>
      </div>

      <div class="layout">
        <section class="left">
          <!-- Hero -->
          <div class="hero card">
            <div>
              <div class="hero-note">¡Buen día!</div>
              <h2>Bienvenido, <span style="color:var(--primary)">Panadero</span></h2>
              <div class="hero-note">Que el aroma del pan recién horneado te acompañe hoy 🍞</div>
              <div style="margin-top:12px; display:flex; gap:10px;">
                <button class="btn btn-primary">Agregar producto</button>
                <button class="btn btn-ghost">Ver agenda</button>
              </div>
            </div>
            <div class="illus">
              <div class="floaty"></div>
              <div class="bread">🥖</div>
              <div class="croissant">🥐</div>
            </div>
          </div>

          <!-- KPIs -->
          <div class="stats">
            <div class="stat">
              <div>
                <div class="muted">Ventas hoy</div>
                <div class="kpi">$ 2.580</div>
              </div>
              <div class="icon"><i data-feather="bar-chart-2"></i></div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Pedidos</div>
                <div class="kpi">145</div>
              </div>
              <div class="icon"><i data-feather="shopping-cart"></i></div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Productos</div>
                <div class="kpi">38</div>
              </div>
              <div class="icon"><i data-feather="package"></i></div>
            </div>
            <div class="stat">
              <div>
                <div class="muted">Clientes</div>
                <div class="kpi">120</div>
              </div>
              <div class="icon"><i data-feather="users"></i></div>
            </div>
          </div>

          <!-- Tabla de pedidos -->
          <table>
            <caption style="text-align:left; font-weight:600; margin-bottom:8px;">Pedidos recientes</caption>
            <thead>
              <tr>
                <th>Cargo</th>
                <th style="text-align:right">Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Ana López</td>
                <td>Pan francés ×12</td>
                <td>26 Jun 2025</td>
                <td>09:30 AM</td>
                <td style="text-align:right"><span class="pill ok">Entregado</span></td>
              </tr>
              <tr>
                <td>Carlos Pérez</td>
                <td>Croissant ×6</td>
                <td>26 Jun 2025</td>
                <td>10:15 AM</td>
                <td style="text-align:right"><span class="pill info">En proceso</span></td>
              </tr>
              <tr>
                <td>María Gómez</td>
                <td>Torta vainilla ×1</td>
                <td>26 Jun 2025</td>
                <td>11:00 AM</td>
                <td style="text-align:right"><span class="pill warn">Pendiente</span></td>
              </tr>
              <tr>
                <td>Juan Ruiz</td>
                <td>Buñuelo ×24</td>
                <td>26 Jun 2025</td>
                <td>11:45 AM</td>
                <td style="text-align:right"><span class="pill bad">Cancelado</span></td>
              </tr>
            </tbody>
          </table>
          <div class="table card">
            <header>
              <strong>Mis pedidos</strong>
              <div style="display:flex; gap:8px;">
                <button class="btn btn-ghost">Hoy</button>
                <button class="btn btn-ghost">Esta semana</button>
              </div>
            </header>
            <div class="row" style="color:#94a3b8; font-weight:600;">
              <div>Cliente</div>
              <div>Producto</div>
              <div>Fecha</div>
              <div>Hora</div>
              <div style="text-align:right">Estado</div>
            </div>
            <div class="row">
              <div>Ana López</div>
              <div>Pan francés ×12</div>
              <div>26 Jun 2025</div>
              <div>09:30 AM</div>
              <div style="text-align:right"><span class="pill ok">Entregado</span></div>
            </div>
            <div class="row">
              <div>Carlos Pérez</div>
              <div>Croissant ×6</div>
              <div>26 Jun 2025</div>
              <div>10:15 AM</div>
              <div style="text-align:right"><span class="pill info">En proceso</span></div>
            </div>
            <div class="row">
              <div>María Gómez</div>
              <div>Torta vainilla ×1</div>
              <div>26 Jun 2025</div>
              <div>11:00 AM</div>
              <div style="text-align:right"><span class="pill warn">Pendiente</span></div>
            </div>
            <div class="row">
              <div>Juan Ruiz</div>
              <div>Buñuelo ×24</div>
              <div>26 Jun 2025</div>
              <div>11:45 AM</div>
              <div style="text-align:right"><span class="pill bad">Cancelado</span></div>
            </div>
          </div>

          <!-- Charts -->
          <div class="grid grid-col-12">
            <div class="card p-20" style="grid-column: span 12; height: 800px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                <strong>Ventas vs. Pedidos (semana)</strong>
                <span class="pill" style="background:#eef2ff; color:#3730a3;">Última semana</span>
              </div>
              <canvas id="barChart" style="width:100%; height:100%"></canvas>
            </div>
          </div>
        </section>

        <!-- Columna derecha -->
        <aside class="right grid">
          <div class="card p-20">
            <div style="display:flex; align-items:center; gap:8px;">
              <i data-feather="calendar" style="color:var(--primary)"></i>
              <strong>Agenda</strong>
              <span class="pill" style="margin-left:auto;background:#eef2ff;color:#3730a3;">Jun</span>
            </div>
            <div class="calendar">
              <div class="d">L</div>
              <div class="d">M</div>
              <div class="d">M</div>
              <div class="d">J</div>
              <div class="d">V</div>
              <div class="d">S</div>
              <div class="d">D</div>
              <!-- simple 30 days -->
              <script>
                for (let i = 1; i <= 30; i++) document.write(`<button class="${i===26?'today':''}">${i}</button>`)
              </script>
            </div>
            <div class="list">
              <div class="li"><i data-feather="check-circle" style="color:#16a34a"></i>
                <div>
                  <div style="font-weight:600;">Entrega mayorista</div>
                  <div class="hero-note">26 Jun · 5:00 AM</div>
                </div>
              </div>
              <div class="li"><i data-feather="clock" style="color:#f59e0b"></i>
                <div>
                  <div style="font-weight:600;">Horneado de pandebono</div>
                  <div class="hero-note">26 Jun · 9:00 AM</div>
                </div>
              </div>
              <div class="li"><i data-feather="x-circle" style="color:#f43f5e"></i>
                <div>
                  <div style="font-weight:600;">Pedido cancelado</div>
                  <div class="hero-note">26 Jun · 11:45 AM</div>
                </div>
              </div>
            </div>
          </div>

          <div class="card p-20">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
              <strong>Top productos (mes)</strong>
            </div>
            <canvas id="pieChart" height="160"></canvas>
          </div>

          <div class="card p-20">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
              <strong>Tendencia de ventas (30 días)</strong>
            </div>
            <canvas id="lineChart" height="110"></canvas>
          </div>
        </aside>
      </div>

      <footer style="text-align:center; color:#64748b; font-size:13px; margin-top: 18px;">
        © <span id="year"></span> PANADERIA WYK-PROYECTO SENA
      </footer>
    </main>
  </div>

  <!-- Modal Nuevo Pedido -->
  <div class="modal-backdrop" id="modal">
    <div class="modal">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
        <strong>Nuevo pedido</strong>
        <button class="btn btn-ghost" id="closeModal">✕</button>
      </div>
      <form class="form">
        <div>
          <label>Cliente</label>
          <input placeholder="Nombre" required />
        </div>
        <div>
          <label>Producto</label>
          <input placeholder="Ej. Pan francés" required />
        </div>
        <div>
          <label>Cantidad</label>
          <input type="number" value="1" min="1" />
        </div>
        <div>
          <label>Fecha</label>
          <input type="date" />
        </div>
        <div style="grid-column:1/-1;">
          <label>Observaciones</label>
          <textarea rows="3" placeholder="Notas para la cocina"></textarea>
        </div>
        <div style="grid-column:1/-1; display:flex; gap:8px; justify-content:flex-end; margin-top:6px;">
          <button type="button" class="btn btn-ghost" id="closeModal2">Cancelar</button>
          <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <script src=""></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"
    integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA="
    crossorigin="anonymous">
  </script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/dashboard.js"></script>
  <script src="<?php echo \config\APP_URL; ?>public/js/sweetalert2.all.min.js"></script>
  <script>
    const successMessage = "<?php echo $success_message; ?>";
    const errorMessage = "<?php echo $error_message; ?>";
  </script>
  <script src="<?php echo \config\APP_URL; ?>public/js/toads-sweetalert2.js"></script>
</body>

</html>