document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function () {
                const icon = this.parentNode.querySelector('lord-icon');
                if (icon) {
                    icon.style.color = '#3b82f6';
                }
                this.classList.add('focused');
            });

            input.addEventListener('blur', function () {
                if (!this.value) {
                    const icon = this.parentNode.querySelector('lord-icon');
                    if (icon) {
                        icon.style.color = '#94a3b8';
                    }
                }
                this.classList.remove('focused');
            });

            input.addEventListener('input', function () {
                this.classList.remove('success', 'error');

                if (this.type === 'email' && this.value.length > 0) {
                    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
                    if (isValid) {
                        this.classList.add('success');
                    } else {
                        this.classList.add('error');
                    }
                }
            });
        });
    }

    function showLogin() {
        const loginContainer = document.querySelector('.container-login');
        const forgotContainer = document.getElementById('forgotForm');
        if (loginContainer && forgotContainer) {
            loginContainer.classList.add('active');
            forgotContainer.classList.remove('active');
        }
    }

    function showForgotPassword() {
        const loginContainer = document.querySelector('.container-login');
        const forgotContainer = document.getElementById('forgotForm');
        if (loginContainer && forgotContainer) {
            loginContainer.classList.remove('active');
            forgotContainer.classList.add('active');
        }
    }

    const forgotFormSubmit = document.getElementById('forgotFormSubmit');
    if (forgotFormSubmit) {
        forgotFormSubmit.addEventListener('submit', function (e) {
            e.preventDefault();
            this.submit();
        });
    }

    const showLoginBtn = document.querySelector('.form-switch a');
    if (showLoginBtn) {
        showLoginBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showLogin();
        });
    }
});