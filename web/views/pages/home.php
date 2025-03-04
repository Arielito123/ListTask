<?php
$dataTaskUnnasigned=TaskModel::dataCountTaskUnnasigned($_SESSION['id_user']);
$dataTaskProgress=TaskModel::dataCountTaskProgress($_SESSION['id_user']);
$dataTaskComplete=TaskModel::dataCountTaskComplete($_SESSION['id_user']);
?>
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Bienvenido a Listify</h1>
            <p class="lead">Aca mismo podras ver un registro de cuantas tareas sin asignar, en progreso o completadas tienes, junto con su fecha de vencimiento y más.</p>
        </div>
    </header>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">¿Qué Puedes Hacer con Listify?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-light shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-tasks fa-2x text-warning mb-3"></i>
                            <h3 class="card-title">Tareas Sin Asignar</h3>
                            <p class="card-text">Cantidad de tareas sin asignar <?php echo $dataTaskUnnasigned['state_unnasigned']; ?></p>
                            <p class="card-text">Prioridad Baja: <?php echo $dataTaskUnnasigned['priority_low']; ?></p>
                            <p class="card-text">Prioridad Media: <?php echo $dataTaskUnnasigned['priority_average']; ?></p>
                            <p class="card-text">Prioridad Alta: <?php echo $dataTaskUnnasigned['priority_high']; ?></p>
                            <p class="card-text">Consulta qué tareas aún no tienen un responsable y asígnalas rápidamente para evitar atrasos.</p>
                        </div>
                        <a href="index.php?pages=manageTasks&subfolder=unassignedTask" class="btn btn-primary">Ver tareas sin asignar</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-light shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-spinner fa-2x text-primary mb-3"></i>
                            <h3 class="card-title">Tareas en Progreso</h3>
                            <p class="card-text">Cantidad de tareas en progreso <?php echo $dataTaskProgress['state_progress']; ?></p>
                            <p class="card-text">Prioridad Baja: <?php echo $dataTaskProgress['priority_low']; ?></p>
                            <p class="card-text">Prioridad Media: <?php echo $dataTaskProgress['priority_average']; ?></p>
                            <p class="card-text">Prioridad Alta: <?php echo $dataTaskProgress['priority_high']; ?></p>
                            <p class="card-text">Visualiza qué tareas están actualmente en desarrollo y gestiona sus avances.</p>
                        </div>
                        <a href="index.php?pages=manageTasks&subfolder=progressTask" class="btn btn-primary">Ver tareas en progreso</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-light shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                            <h3 class="card-title">Tareas Completadas</h3>
                            <p class="card-text">Cantidad de tareas completadas <?php echo $dataTaskComplete['state_complete']; ?></p>
                            <p class="card-text">Prioridad Baja: <?php echo $dataTaskComplete['priority_low']; ?></p>
                            <p class="card-text">Prioridad Media: <?php echo $dataTaskComplete['priority_average']; ?></p>
                            <p class="card-text">Prioridad Alta: <?php echo $dataTaskComplete['priority_high']; ?></p>
                            <p class="card-text">Revisa las tareas finalizadas y asegúrate de que todo esté en orden antes de cerrarlas.</p>
                        </div>
                        <a href="index.php?pages=manageTasks&subfolder=completedTask" class="btn btn-primary">Ver tareas completadas</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

