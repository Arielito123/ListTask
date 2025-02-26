document.addEventListener("DOMContentLoaded", function() {
    const toggleSidebarBtn = document.getElementById('toggle-sidebar-btn');
    
    toggleSidebarBtn.addEventListener('click', function() {
        // Utiliza AdminLTE para alternar el sidebar
        $('body').toggleClass('sidebar-collapse');
    });
});