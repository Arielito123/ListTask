<?php
if(isset($_POST['new_task'])){
    $task = new TaskController();
    $task->newTask($_SESSION['id_user']);
 }

 $viewTask = new TaskController();
 $data = $viewTask->viewTask($_SESSION['id_user']);

 if(isset($_POST['saveEdit'])){
    $task = new TaskController();
    $task->editTask();
 }

 if(isset($_POST['deleteButton'])){
     $delete = new TaskController();
     $delete->deleteTask($_POST['id_task']);
 }

 if(isset($_POST['progressButton'])){
    $progress = new TaskController();
    $progress-> editTaskState();
 }

 if(isset($_POST['notificationButton'])){
    $notification = new TaskController();
    $notification->notificationTask();
 }

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
                                            data-target="#modal_edit_<?php echo $value['id_task'] ?>" title="Editar">
                                            <i class="fas fa-edit"></i>
                                            </button>
                                           
                                            <button type="button" class="btn btn-danger btn-sm flex-grow-1 mx-1" data-toggle="modal"
                                            data-target="#confirmDeleteModal_<?php echo $value['id_task'] ?>" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                            </button>
                                        
                                            <button type="button" class="btn btn-info btn-sm flex-grow-1 mx-1" data-toggle="modal"
                                            data-target="#confirmProgressModal_<?php echo $value['id_task'] ?>" title="pasar a progreso">
                                            <i class="fas fa-spinner"></i>
                                            </button>

                                        <?php if($value['notification_state'] == 0): ?> 
                                            <button type="button" class="btn btn-secondary btn-sm flex-grow-1 mx-1" data-toggle="modal"
                                                    data-target="#confirmNotificationModal_<?php echo $value['id_task'];?>" title="Activar Notificación">
                                                    <i class="fas fa-bell"></i>
                                            </button>    
                                    <?php endif; ?>
                           </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>


<?php foreach ($data as $value): ?>
        <div class="modal fade cierreModal" id="modal_edit_<?php echo $value['id_task'] ?>" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Tarea</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editTask" method="post">
                            <input type="hidden" name="id_task" value="<?php echo $value['id_task'] ?>">
                            <div class="form-group">
                                <label for="subject_name">Nombre de la tarea:</label>
                                <input type="text" class="form-control mb-3" id="task_name" name="task_name"
                                    value="<?php echo $value['name_task'] ?>" maxlength="30" required>
                                <label for="detail">Descripcion:</label>
                                <input type="text" class="form-control" id="description" name="description"
                                    value="<?php echo $value['description_task'] ?>" maxlength="100"
                                    required>
                            </div>
                            <div class="form-group">
                        <label for="due_date">Fecha y hora de finalización <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="reminder_date"   value="<?php echo $value['reminder_date'] ?>" name="reminder_date" required>
                    </div>
                    <?php
                    MessageController::show_messages_error('void','no pueden haber campos vacios');
                    MessageController::show_messages_error('date_error','la fecha debe ser posterior a la actual');
                    MessageController::show_messages_error('letter_name','el nombre de la tarea debe tener menos de 30 caracteres');
                    MessageController::show_messages_error('description_letter','la descripcion de la tarea debe tener menos de 100 caracteres');
                    MessageController::showMessageVerify('edit_task','tarea editada exitosamente');
                    MessageController::show_messages_error('edit_task','no se pudo editar la tarea');
                    ?>
                            <div class="text-center">
                                <button  class="btn btn-primary text-white" name="saveEdit">Guardar Cambios</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                            <div class="response-message text-center"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>


    <?php foreach ($data as $value): ?>
        <div class="modal fade cierreModal" id="confirmDeleteModal_<?php echo $value['id_task'] ?>" tabindex="-1"
            role="dialog" aria-labelledby="confirmDeleteModalLabel_<?php echo $value['id_task'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteModalLabel_<?php echo $value['id_task'] ?>">Confirmar
                            Eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p>¿Estás seguro de que deseas eliminar la siguiente Tarea?</p>
                        <h5 class="mt-4 mb-4 font-weight-bold"><?php echo $value['name_task'] ?></h5>
                        <p>Esta acción no se puede deshacer.</p>
                    </div>
                    <?php
                    MessageController::show_messages_error('delete_task','no se pudo eliminar la tarea');
                    ?>
                    <div class="modal-footer">
                        <form method="post">
                            <input type="hidden" name="id_task" value="<?php echo $value['id_task'] ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger" name="deleteButton">Eliminar</button>
                        </form>
                        <div class="response-message text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <?php foreach ($data as $value): ?>
        <div class="modal fade cierreModal" id="confirmProgressModal_<?php echo $value['id_task'] ?>" tabindex="-1"
            role="dialog" aria-labelledby="confirmDeleteModalLabel_<?php echo $value['id_task'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="confirmDeleteModalLabel_<?php echo $value['id_task'] ?>">Confirmar
                            Pasar a progreso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p>¿Estás seguro de que deseas Pasar esta tarea a progreso?</p>
                        <h5 class="mt-4 mb-4 font-weight-bold"><?php echo $value['name_task'] ?></h5>
                        
                    </div>
                    <div class="modal-footer">
                        <form method="post">
                            <input type="hidden" name="id_task" value="<?php echo $value['id_task'] ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary text-white" name="progressButton">Guardar</button>
                        </form>
                        <div class="response-message text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <?php foreach ($data as $value): ?>
        <div class="modal fade cierreModal" id="confirmNotificationModal_<?php echo $value['id_task'] ?>" tabindex="-1"
            role="dialog" aria-labelledby="confirmNotificationModalLabel_<?php echo $value['id_task'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="confirmNotificationModalLabel_<?php echo $value['id_task'] ?>">Confirmar
                            notificacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p>¿quieres activar la notificacion para esta tarea? <?php echo $value['name_task'] ?></p>
                        
                    </div>
                    <div class="modal-footer">
                        <form method="post">
                            <input type="hidden" name="id_task" value="<?php echo $value['id_task'] ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary text-white" name="notificationButton">Activar Notificación</button>
                        </form>
                        <div class="response-message text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>


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
                               placeholder="Ingrese el nombre de la tarea" maxlength="30" required>
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
