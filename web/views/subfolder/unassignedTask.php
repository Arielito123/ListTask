<?php
if(isset($_POST['new_task'])){
    $task = new TaskController();
    $task->newTask($_SESSION['id_user']);
 }

 $viewTask = new TaskController();
 $data = $viewTask->viewTask();


?>
<section class="container-fluid py-3">
    <div class="row py-4">
        <?php foreach ($data as $key => $value): ?>
            <div class="col-lg-4 col-md-6 mb-3"> 
                <div class="card shadow-sm border-0 h-100" style="max-width: 320px; margin: auto; min-height: 320px;">
                    <div class="card-header bg-primary" style="height: 3px;"></div>
                    <div class="card-body bg-white p-3 d-flex flex-column"> 
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-tasks fa-lg text-primary"></i>
                            <h4 class="ml-2 mb-0" style="font-size: 1.1rem;">Gestionar</h4>
                        </div>
                        <h6 class="mb-2 font-weight-bold"><?php echo $value['name_task'] ?></h6>
                        <p class="mb-1"><strong>Descripción:</strong> <?php echo $value['description_task'] ?></p>
                        <p class="mb-1"><strong>Prioridad:</strong> <?php echo ucfirst($value['detail_priority']) ?></p>
                        <p class="mb-1"><strong>Creación:</strong> <?php echo $fecha_creacion = date("d-m-Y H:i", strtotime($value['created_at'])); ?></p>
                        <p class="mb-1"><strong>Finalización:</strong> <?php  echo $fecha_finalizacion = date("d-m-Y H:i", strtotime($value['reminder_date']));  ?></p>
                        
                        <div class="mt-auto">
                         <?php  if(isset($_GET['pages'])&& $_GET['pages'] == 'manageTasks'):?>   
                        <div class="d-flex flex-wrap justify-content-between">
                                <button type="button" class="btn btn-primary btn-sm flex-grow-1 mx-1" data-toggle="modal"
                                            data-target="#modal_edit_<?php echo $data['id_task'] ?>" title="Editar materia">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                            <button type="button" class="btn btn-danger btn-sm flex-grow-1 mx-1" data-toggle="modal"
                                            data-target="#confirmDeleteModal_<?php echo $data['id_task'] ?>" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm flex-grow-1 mx-1" data-toggle="modal"
                                            data-target="#confirmProgressModal_<?php echo $data['id_task'] ?>" title="Pasar a en Progreso">
                                            <i class="fas fa-spinner"></i> 
                                        </button>

                                        </button>
                                            <button type="button" class="btn btn-info btn-sm flex-grow-1 mx-1" data-toggle="modal"
                                            data-target="#confirmNotificationModal_<?php echo $data['id_task'] ?>" title="Activar Notificación">
                                            <i class="fas fa-bell"></i>
                                        </button>
                           </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>





<!-- Para crear las tareas -->
<button type="button" class="btn btn-primary btn-lg btn-floating position-fixed bottom-0 end-0 m-4 shadow"
        data-toggle="modal" data-target="#createTaskModal" title="Crear tarea">
    <i class="fas fa-tasks"></i>
</button>

<div class="modal fade cierreModal" id="createTaskModal" tabindex="-1" role="dialog"
     aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createTaskModalLabel">Crear nueva tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createTaskForm" method="post">
                    <div class="form-group">
                        <label for="task_name">Nombre de la tarea</label>
                        <input type="text" class="form-control" id="task_name" name="name_task"
                               placeholder="Ingrese el nombre de la tarea" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Detalle o descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="description" name="description"
                               placeholder="Agregue una descripción" maxlength="100" required>
                    </div>

                    <div class="form-group px-2">
                                <label class="pt-1" for="id_year">Prioridad de la tarea</label>
                                <select class="form-control" id="priority_task" name="priority_task" required>
                                    <?php
                                    (new TaskController())->prioritySelect();
                                    ?>
                                </select>
                            </div>
                    <div class="form-group">
                        <label for="due_date">Fecha y hora de finalización <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="reminder_date" name="reminder_date" required>
                    </div>
                    <?php
                    MessageController::show_messages_error('void','no pueden haber campos vacios');
                    MessageController::show_messages_error('date_error','la fecha debe ser posterior a la actual');
                    MessageController::show_messages_error('letter_name','el nombre de la tarea debe tener menos de 30 caracteres');
                    MessageController::show_messages_error('description_letter','la descripcion de la tarea debe tener menos de 100 caracteres');
                    MessageController::showMessageVerify('new_task','tarea creada exitosamente');
                    MessageController::show_messages_error('new_task','no se pudo crear la tarea');
                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button  form="createTaskForm" class="btn btn-primary text-white"
                                name="new_task">Guardar</button>
                    </div>
                    <div class="response-message text-center"></div>
                </form>
            </div>
        </div>
    </div>
</div>
