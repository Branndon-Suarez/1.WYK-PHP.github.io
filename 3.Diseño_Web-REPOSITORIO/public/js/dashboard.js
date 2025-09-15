document.addEventListener('DOMContentLoaded', function() {
  // Year
  var yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // Modal logic
  var modal = document.getElementById('modal');
  var openModal = document.getElementById('openModal');
  var closeModal = document.getElementById('closeModal');
  var closeModal2 = document.getElementById('closeModal2');
  if (openModal && modal && closeModal && closeModal2) {
    openModal.addEventListener('click', () => modal.style.display = 'grid');
    closeModal.addEventListener('click', () => modal.style.display = 'none');
    closeModal2.addEventListener('click', () => modal.style.display = 'none');
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });
  }

  // Charts data
  var barChart = document.getElementById('barChart');
  if (barChart && typeof Chart !== 'undefined') {
    const ventasSemana = {
      labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'], datasets: [
        { label: 'Ventas ($)', data: [420, 560, 610, 380, 780, 920, 690], backgroundColor: '#6366f1', borderRadius: 14 },
        { label: 'Pedidos', data: [18, 24, 26, 16, 32, 40, 29], backgroundColor: '#f59e0b', borderRadius: 14 }
      ]
    };
    new Chart(barChart, { type: 'bar', data: ventasSemana, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } } });
  }

  var pieChart = document.getElementById('pieChart');
  if (pieChart && typeof Chart !== 'undefined') {
    new Chart(pieChart, { type: 'doughnut', data: { labels: ['Pan francés', 'Croissant', 'Buñuelo', 'Pan aliñado', 'Rosca'], datasets: [{ data: [32, 22, 18, 15, 13], backgroundColor: ['#6366f1', '#a78bfa', '#22c55e', '#f59e0b', '#0ea5e9'] }] }, options: { plugins: { legend: { position: 'bottom' } }, cutout: '58%' } });
  }

  var lineChart = document.getElementById('lineChart');
  if (lineChart && typeof Chart !== 'undefined') {
    new Chart(lineChart, { type: 'line', data: { labels: ['1', '5', '10', '15', '20', '25', '30'], datasets: [{ label: 'Ventas', data: [200, 240, 190, 310, 290, 360, 330], borderColor: '#6366f1', borderWidth: 3, fill: false, tension: .35, pointRadius: 0 }] }, options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: false } } } });
  }
});