function showSignup() {
    document.getElementById('register-form').classList.remove('active');
    document.getElementById('info-personal-form').classList.add('active');
    document.getElementById('forgotForm').classList.remove('active');
}

function showLogin() {
    document.getElementById('register-form').classList.add('active');
    document.getElementById('info-personal-form').classList.remove('active');
    document.getElementById('forgotForm').classList.remove('active');
}

function showForgotPassword() {
    document.getElementById('register-form').classList.remove('active');
    document.getElementById('info-personal-form').classList.remove('active');
    document.getElementById('forgotForm').classList.add('active');
}

// Unir los datos de los dos formularios
document.getElementById('register-form-submit').addEventListener('submit', function (e) {
    e.preventDefault();

    const password = this.querySelector('input[name="password"]').value;
    const confirmPassword = this.querySelector('input[name="confirm_password"]').value;

    if (password !== confirmPassword) {
        showToast('error', 'Las contraseñas no coinciden.');
        return;
    }

    if (password.length < 8) {
        showToast('error', 'La contraseña debe tener al menos 8 caracteres.');
        return;
    }

    // Capturar valores del primer form
    const nameUsuario = this.querySelector('input[name="name_usuario"]').value;

    // Pasarlos como hidden al segundo form
    document.getElementById('name_usuario').value = nameUsuario;
    document.getElementById('password').value = password;
    document.getElementById('confirm_password').value = confirmPassword;

    // Mostrar el segundo formulario
    showSignup();
});

document.getElementById('info-personal-form-submit').addEventListener('submit', function (e) {
    // La validación se hace en el primer formulario ahora.
    // Aquí solo se podría agregar una validación adicional si es necesario.
});

document.getElementById('forgotFormSubmit').addEventListener('submit', function (e) {
    e.preventDefault();
    // Lógica para enviar el formulario de recuperación de contraseña
    this.submit();
});

// Función para mostrar los mensajes de Toast
function showToast(icon, title) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    Toast.fire({
        icon: icon,
        title: title
    });
}

// Código para efectos e interacciones de la UI (sin cambios)
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function () {
        this.parentNode.querySelector('i').style.color = '#3b82f6';
        this.classList.add('focused');
    });

    input.addEventListener('blur', function () {
        if (!this.value) {
            this.parentNode.querySelector('i').style.color = '#94a3b8';
        }
        this.classList.remove('focused');
    });

    input.addEventListener('input', function () {
        if (this.type === 'email') {
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
            this.classList.toggle('success', isValid && this.value.length > 0);
            this.classList.toggle('error', !isValid && this.value.length > 0);
        }
    });
});

document.querySelectorAll('.social-btn').forEach(btn => {
    btn.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-3px) scale(1.02)';
    });

    btn.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

window.addEventListener('load', function () {
    document.querySelector('.container-register').style.animation = 'fadeIn 1s ease';
});

document.addEventListener('keydown', function (e) {
    if (e.altKey && e.key === 's') {
        e.preventDefault();
        showSignup();
    } else if (e.altKey && e.key === 'l') {
        e.preventDefault();
        showLogin();
    }
});