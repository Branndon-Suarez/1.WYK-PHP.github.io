// public/js/usuario/selectRolModal.js

const tablaProductosModalBody = document.querySelector('#tablaProductosModal tbody');
let productosData = [];

// Función para cargar prod cuando el modal se muestre
const modalProductos = document.getElementById('modalProductos');
if (modalProductos) {
    modalProductos.addEventListener('show.bs.modal', async () => {
        // Cargar los prod si aún no se han cargado
        if (productosData.length === 0) {
            await cargarProductos();
        }
    });
}

async function cargarProductos() {
    try {
        const url = APP_URL + 'productos/getProductosAjax';
        const res = await fetch(url, { cache: "no-store" });
        if (!res.ok) throw new Error('Error al cargar los roles');

        const data = await res.json();
        if (data.success) {
            productosData = data.data;
            renderizarProductos();
        } else {
            console.error("Error del servidor:", data.message);
            tablaProductosModalBody.innerHTML = `<tr><td colspan="4">${data.message}</td></tr>`;
        }
    } catch (err) {
        console.error("Error de red:", err);
        tablaProductosModalBody.innerHTML = `<tr><td colspan="4">Error al cargar productos.</td></tr>`;
    }
}

function renderizarProductos() {
    tablaProductosModalBody.innerHTML = ''; // Limpiar la tabla

    if (productosData.length === 0) {
        tablaProductosModalBody.innerHTML = `<tr><td colspan="4">No hay productos disponibles.</td></tr>`;
        return;
    }

    productosData.forEach(rol => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${rol.ID_PRODUCTO}</td>
            <td>${rol.NOMBRE_PRODUCTO}</td>
            <td>${rol.CANT_EXIST_PRODUCTO}</td>
            <td>
                <button type="button" class="btn btn-success btn-sm btn-select-rol"
                        data-id="${rol.ID_PRODUCTO}"
                        data-nombre="${rol.NOMBRE_PRODUCTO}"
                        data-cantExist="${rol.CANT_EXIST_PRODUCTO}"
                        data-bs-dismiss="modal">Seleccionar</button>
            </td>
        `;
        tablaProductosModalBody.appendChild(tr);
    });

    // Añadir event listeners a los botones de selección
    document.querySelectorAll('.btn-select-rol').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.target.dataset.id;
            const nombre = e.target.dataset.nombre;
            const cantExist = e.target.dataset.cantExist;
            document.getElementById('productoFK').value = id; 
            document.getElementById('producto_display').value = nombre; 
        });
    });
}