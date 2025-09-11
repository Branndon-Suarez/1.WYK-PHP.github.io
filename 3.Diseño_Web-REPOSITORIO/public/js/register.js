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

//Unir los datos de los dos formularios a uno solo
document.getElementById('register-form-submit').addEventListener('submit', function (e) {
    e.preventDefault();

    //Capturar valores del primer form
    const nameUsuario = this.querySelector('input[name="name_usuario"]').value;
    const password = this.querySelector('input[name="password"]').value;
    const confirmPassword = this.querySelector('input[name="confirm_password"]').value;

    //Pasarlos como hidden al segundo form
    document.getElementById('name_usuario').value = nameUsuario;
    document.getElementById('password').value = password;
    document.getElementById('confirm_password').value = confirmPassword;

    showSignup();
});

document.getElementById('info-personal-form-submit').addEventListener('submit', function (e) {
    if (!validateSignupForm()) {
        e.preventDefault();
    }
});

document.getElementById('forgotFormSubmit').addEventListener('submit', function (e) {
    e.preventDefault();
    handleFormSubmit(this, 'Sending instructions...');
});

function validateSignupForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
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
            icon: "error",
            title: "Contraseñas no coinciden."
        });
        return false;
    }

    if (password.length < 8) {
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
            icon: "error",
            title: "La contraseña debe tener al menos 8 caracteres."
        });
        return false;
    }
    return true;
}

function handleFormSubmit(form, loadingText) {
    const button = form.querySelector('.btn-primary');
    const loading = button.querySelector('.loading');
    const btnText = button.querySelector('.btn-text');
    const originalText = btnText.textContent;

    // Show loading state
    loading.classList.add('show');
    btnText.textContent = loadingText;
    button.disabled = true;

    // Simulate API call
    setTimeout(() => {
        loading.classList.remove('show');
        button.disabled = false;
        btnText.textContent = originalText;

        if (form.id === 'register-form-submit') {
            showSuccessMessage('Login successful! Redirecting...');
        } else if (form.id === 'info-personal-form-submit') {
            showSuccessMessage('Account created successfully! Please check your email.');
        } else {
            showSuccessMessage('Password reset instructions sent to your email!');
        }
    }, 2000);
}

function showSuccessMessage(message) {
    // Create a temporary success notification
    const notification = document.createElement('div');
    notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #10b981;
                color: white;
                padding: 16px 24px;
                border-radius: 12px;
                font-weight: 600;
                box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
                z-index: 1000;
                animation: slideInRight 0.5s ease;
            `;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 4000);
}

// Enhanced form interactions
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

    // Real-time validation
    input.addEventListener('input', function () {
        if (this.type === 'email') {
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
            this.classList.toggle('success', isValid && this.value.length > 0);
            this.classList.toggle('error', !isValid && this.value.length > 0);
        }
    });
});

// Add interactive hover effects
document.querySelectorAll('.social-btn').forEach(btn => {
    btn.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-3px) scale(1.02)';
    });

    btn.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Smooth page load animation
window.addEventListener('load', function () {
    document.querySelector('.container-register').style.animation = 'fadeIn 1s ease';
});

// Add keyboard shortcuts
document.addEventListener('keydown', function (e) {
    if (e.altKey && e.key === 's') {
        e.preventDefault();
        showSignup();
    } else if (e.altKey && e.key === 'l') {
        e.preventDefault();
        showLogin();
    }
});