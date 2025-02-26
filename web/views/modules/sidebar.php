<aside class="main-sidebar elevation-4" style="background-color: #007bff !important;">
    <div class="sidebar ">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="public/img/usuario.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block font-weight-bold text-white">Rol  <?php $data = UserController::sessionDataUser($_SESSION['id_user']) ?>
                    <?php echo $data['name_rol'] ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                    <li class="nav-item mb-1">
                        <a href="index.php?pages=home" class="nav-link text-white">
                            <i class="fas fa-home nav-icon"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                
                <?php

                if ($_SESSION['id_rol'] == 1) {
                    include_once "sidebarGeneral.php";
                }
                ?>
            </ul>
        </nav>
    </div>
</aside>