const ctxVentas = document.getElementById('ventasChart').getContext('2d');
const myChartVentas = new Chart(ctxVentas, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
        datasets: [{
            label: 'Ventas ($)',
            data: [1200, 1900, 3000, 2500, 2200, 2800, 3200],
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.2)',
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: 'white' } }
        },
        scales: {
            x: { ticks: { color: 'white' } },
            y: { ticks: { color: 'white' } }
        }
    }
});

const ctxProductos = document.getElementById('productosChart').getContext('2d');
const myChartProductos = new Chart(ctxProductos, {
    type: 'bar',
    data: {
        labels: ['Pan', 'Torta', 'Galletas', 'Croissant', 'Bollo'],
        datasets: [{
            label: 'Unidades Vendidas',
            data: [65, 59, 80, 81, 56],
            backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#8b5cf6', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: 'white' } }
        },
        scales: {
            x: { ticks: { color: 'white' } },
            y: { ticks: { color: 'white' } }
        }
    }
});

// Toggle menú
const btnMenu = document.getElementById('btnMenu');
const menuLateral = document.getElementById('menuLateral');

btnMenu.addEventListener('click', () => {
    menuLateral.classList.toggle('expandido');
    btnMenu.classList.toggle('abierto');
});

// Activar opción del menú
document.querySelectorAll('.opcion').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.opcion').forEach(el => el.classList.remove('activa'));
        btn.classList.add('activa');
    });
});