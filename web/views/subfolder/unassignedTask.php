<?php
if(isset($_POST['new_task'])){
    $task = new TaskController();
    $task->newTask($_SESSION['id_user']);
 }
?>
<!-- Botón flotante -->
<button type="button" class="btn btn-primary btn-lg btn-floating position-fixed bottom-0 end-0 m-4 shadow"
        data-toggle="modal" data-target="#createTaskModal" title="Crear tarea">
    <i class="fas fa-tasks"></i>
</button>

<!-- Modal -->
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
