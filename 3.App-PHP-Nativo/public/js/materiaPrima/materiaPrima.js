document.addEventListener('DOMContentLoaded', function () {
  const formulario = document.querySelector('.formulario');
  const botonEnviar = document.querySelector('button[type="submit"]');

  formulario.addEventListener('submit', function () {
    formulario.classList.add('formulario-exitoso');
    botonEnviar.innerHTML = '<i data-feather="check-circle" style="margin-right: 8px; width: 20px; height: 20px;"></i>Creando...';
    feather.replace();

    setTimeout(() => {
      formulario.classList.remove('formulario-exitoso');
    }, 600);
  });

  // Efecto en inputs
  const entradas = document.querySelectorAll('input');
  entradas.forEach(entrada => {
    entrada.addEventListener('focus', function () {
      this.parentElement.parentElement.querySelector('label').style.color = 'var(--primary)';
    });

    entrada.addEventListener('blur', function () {
      this.parentElement.parentElement.querySelector('label').style.color = 'var(--primary-2)';
    });
  });

  // Cambiar color del select según el estado seleccionado
  const selectEstado = document.getElementById('estado');
  function actualizarColorEstado() {
    if (selectEstado.value == '1') {
      selectEstado.style.color = '#22c55e';
    } else {
      selectEstado.style.color = '#ef4444';
    }
  }

  // Aplicar color inicial
  actualizarColorEstado();

  // Escuchar cambios en el select
  selectEstado.addEventListener('change', actualizarColorEstado);
});

