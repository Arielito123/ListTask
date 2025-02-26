<nav class="fixed-top main-header navbar navbar-expand navbar-white navbar-primary">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="Ocultar Barra Lateral"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user mr-1"></i>
                <?php $data = UserController::sessionDataUser($_SESSION['id_user']) ?>
                <?php echo $data['name_user'];?>
            </a>
          
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="index.php?pages=myData">
                        <i class="fas fa-id-card"></i> Mis datos
                    </a>

                </div>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-primary" id="logout-button" href="#" role="button" title="Cerrar Sesión">
                <i class="text-white fas fa-power-off"></i>
            </a>
        </li>
    </ul>

</nav>