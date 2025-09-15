document.addEventListener("DOMContentLoaded", function() {
    if (successMessage) {
        Swal.fire({
            toast: true,
            icon: "success",
            title: successMessage,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    }

    if (errorMessage) {
        Swal.fire({
            toast: true,
            icon: "error",
            title: errorMessage,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    }
});