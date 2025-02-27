<section class="container-fluid py-3">
    <h2 class="text-center mt-1 mb-3 py-2 lead">Lista de Tareas</h2>
    <ul class="nav nav-pills nav-justified mb-2">
       
            <?php if (isset($_GET['subfolder']) && $_GET['subfolder'] == 'unassignedTask') : ?>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?pages=manageTasks&subfolder=unassignedTask">Tareas sin Asignar</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pages=manageTasks&subfolder=unassignedTask">Tareas sin Asignar</a>
                </li>
            <?php endif ?>

            <?php if (isset($_GET['subfolder']) && $_GET['subfolder'] == 'progressTask') : ?>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?pages=manageTasks&subfolder=progressTask">Tareas en Progreso</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pages=manageTasks&subfolder=progressTask">Tareas en Progreso</a>
                </li>
            <?php endif ?>

            <?php if (isset($_GET['subfolder']) && $_GET['subfolder'] == 'completedTask') : ?>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?pages=manageTasks&subfolder=completedTask">Tareas Completadas</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pages=manageTasks&subfolder=completedTask">Tareas Completadas</a>
                </li>
            <?php endif ?>
      
    </ul>

 
    <?php
    if (isset($_GET['subfolder'])) {
        if ($_GET['subfolder'] == "unassignedTask" || $_GET['subfolder'] == "progressTask" || $_GET['subfolder'] == "completedTask") {
            include "views/subfolder/" . $_GET['subfolder'] . ".php";
        }
    } else {
        include "views/subfolder/unassignedTask.php"; // Si no se pasa subfolder, carga la tarea sin asignar por defecto
    }
    ?>
</section>
