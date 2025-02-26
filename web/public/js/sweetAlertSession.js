/*JavaScript para manejar el evento click y mostrar la alerta de SweetAlert*/

document.getElementById('logout-button').addEventListener('click', function(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del enlace
    // Mostrar la alerta de SweetAlert para confirmar el cierre de sesión
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres cerrar la sesión?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        // Si el usuario confirma la acción, redirige al index.html después de cerrar sesión
        if (result.isConfirmed) {
            window.location.href = 'index.php?pages=logout';
            // Puedes agregar un mensaje de éxito si lo deseas
              Swal.fire(
                  '¡Sesión cerrada!',
                  'Tu sesión ha sido cerrada correctamente.',
                  'success'
             );
        }
    });
});