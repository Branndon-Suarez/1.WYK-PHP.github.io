// public/js/usuario/selectRolModal.js

const tablaRolesModalBody = document.querySelector('#tablaRolesModal tbody');
let rolesData = [];

// Función para cargar roles cuando el modal se muestre
const modalRoles = document.getElementById('modalRoles');
if (modalRoles) {
    modalRoles.addEventListener('show.bs.modal', async () => {
        // Cargar los roles si aún no se han cargado
        if (rolesData.length === 0) {
            await cargarRoles();
        }
    });
}

// Cargar roles desde el servidor
async function cargarRoles() {
    try {
        const url = APP_URL + 'roles/getRolesAjax';
        const res = await fetch(url, { cache: "no-store" });
        if (!res.ok) throw new Error('Error al cargar los roles');

        const data = await res.json();
        if (data.success) {
            rolesData = data.data;
            renderizarRoles();
        } else {
            console.error("Error del servidor:", data.message);
            tablaRolesModalBody.innerHTML = `<tr><td colspan="4">${data.message}</td></tr>`;
        }
    } catch (err) {
        console.error("Error de red:", err);
        tablaRolesModalBody.innerHTML = `<tr><td colspan="4">Error al cargar roles.</td></tr>`;
    }
}

// Renderizar roles en la tabla del modal
function renderizarRoles() {
    tablaRolesModalBody.innerHTML = ''; // Limpiar la tabla

    if (rolesData.length === 0) {
        tablaRolesModalBody.innerHTML = `<tr><td colspan="4">No hay roles disponibles.</td></tr>`;
        return;
    }

    rolesData.forEach(rol => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${rol.ID_ROL}</td>
            <td>${rol.ROL}</td>
            <td>${rol.CLASIFICACION}</td>
            <td>
                <button type="button" class="btn btn-success btn-sm btn-select-rol"
                        data-id="${rol.ID_ROL}"
                        data-nombre="${rol.ROL}"
                        data-bs-dismiss="modal">Seleccionar</button>
            </td>
        `;
        tablaRolesModalBody.appendChild(tr);
    });

    // Añadir event listeners a los botones de selección
    document.querySelectorAll('.btn-select-rol').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.target.dataset.id;
            const nombre = e.target.dataset.nombre;
            document.getElementById('rol_fk').value = id;
            document.getElementById('rol_display').value = nombre;
        });
    });
}