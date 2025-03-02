<?php
$viewTask = new TaskController();
$data = $viewTask->viewTaskComplete($_SESSION['id_user']);

if(isset($_POST['unassignedButton'])){
    $progress = new TaskController();
    $progress-> editTaskStateUnnassigned();
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
                                            <?php
                                             date_default_timezone_set('America/Argentina/Buenos_Aires');
                                             $today = new DateTime();
                                             $due_date_obj = new DateTime($value['reminder_date']);
                                             
                                             
                                             $today_formatted = $today->format('Y-m-d H:i:s');
                                             $due_date_formatted = $due_date_obj->format('Y-m-d H:i:s');
                                             
                                             if($due_date_formatted > $today_formatted):
                                             
                                             ?>       
                                            <button type="button" class="btn btn-warning btn-sm flex-grow-1 mx-1 text-white" 
                                                    data-toggle="modal"
                                                    data-target="#confirmUnassignedModal_<?php echo $value['id_task'] ?>" 
                                                    title="Pasar a sin asignar">
                                                <i class="fas fa-minus-circle"></i>
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
        <div class="modal fade cierreModal" id="confirmUnassignedModal_<?php echo $value['id_task'] ?>" tabindex="-1"
            role="dialog" aria-labelledby="confirmDeleteModalLabel_<?php echo $value['id_task'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="confirmDeleteModalLabel_<?php echo $value['id_task'] ?>">Confirmar pasar a sin asignar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p>¿Estás seguro de que deseas Pasar esta tarea a sin asignar?</p>
                        <h5 class="mt-4 mb-4 font-weight-bold"><?php echo $value['name_task'] ?></h5>
                        
                    </div>
                    <div class="modal-footer">
                        <form method="post">
                            <input type="hidden" name="id_task" value="<?php echo $value['id_task'] ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary text-white" name="unassignedButton">Guardar</button>
                        </form>
                        <div class="response-message text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
