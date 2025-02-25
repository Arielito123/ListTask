
    document.addEventListener("DOMContentLoaded", function() {
        // Cerrar alerta de éxito
        const alertSuccess = document.getElementById('alert-success');
        if (alertSuccess) {
            alertSuccess.querySelector('.close').addEventListener('click', function() {
                alertSuccess.style.display = 'none';
            });
        }

        // Cerrar alerta de error
        const alertError = document.getElementById('alert-error');
        if (alertError) {
            alertError.querySelector('.close').addEventListener('click', function() {
                alertError.style.display = 'none';
            });
        }
    });