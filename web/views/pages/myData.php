<?php
$dataUser=UserController::sessionDataUser($_SESSION['id_user']);

if (isset($_POST['saveEdit'])) {
    $user = new UserController();
    $user->editUser();
}

?>
<br>
<br>
<div class="container d-flex align-items-center justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Información del Usuario</h4>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <div class="col-md-8">
                        <h5 class="mb-2"><strong>Nombre:</strong> <?php echo $dataUser['name_user']; ?></h5>
                        <h5 class="mb-2"><strong>Apellido:</strong> <?php echo $dataUser['last_name_user']; ?></h5>
                        <h5 class="mb-2"><strong>Teléfono:</strong> <?php echo $dataUser['user_phone']; ?></h5>
                        <h5 class="mb-2"><strong>Email:</strong> <?php echo $dataUser['user_mail']; ?></h5>
                        <h5 class="mb-2"><strong>Rol:</strong> <?php echo $dataUser['name_rol']; ?></h5>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light p-0 d-flex">
                <button type="button" class="btn btn-primary w-100" style="height: 100%;" data-toggle="modal"
                    data-target="#modal_edit_<?php echo $dataUser['id_user'] ?>" title="Editar">
                    <i class="fas fa-edit"></i> Editar
                </button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade cierreModal" id="modal_edit_<?php echo $dataUser['id_user'] ?>" tabindex="-1" role="dialog"
    aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $dataUser['id_user'] ?>">
                    
                    <div class="form-group">
                        <label for="name_user">Nombre:</label>
                        <input type="text" class="form-control" id="name_user" name="name_user"
                            value="<?php echo $dataUser['name_user'] ?>" maxlength="30" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name_user">Apellido:</label>
                        <input type="text" class="form-control" id="last_name_user" name="last_name_user"
                            value="<?php echo $dataUser['last_name_user'] ?>" maxlength="30" required>
                    </div>


                    <div class="form-group">
                        <label for="user_mail">Email:</label>
                        <input type="email" class="form-control" id="user_mail" name="user_mail"
                            value="<?php echo $dataUser['user_mail'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_phone">Teléfono:</label>
                        <input type="text" class="form-control" id="user_phone" name="user_phone"
                            value="<?php echo $dataUser['user_phone'] ?>" maxlength="15" required>
                    </div>


                    <?php
                    MessageController::showMessageVerify("success", "Se edito correctamente");
                    MessageController::show_messages_error("letter", "El nombre o apellido debe contener solo letras");
                    MessageController::show_messages_error("num", "El nombre o apellido debe tener menos de 70 caracteres");
                    MessageController::show_messages_error("phone", "El telefono debe tener menos de 15 caracteres");
                    MessageController::show_messages_error("error", "no se pudo completar el registro");
                    MessageController::show_messages_error("void", "no pueden haber campos vacios");
                    MessageController::show_messages_error("duplicate", "El corrreo ya existe");
                    MessageController::show_messages_error("email", "debe ser un correo valido");
                    ?>

                    <div class="text-center">
                        <button class="btn btn-primary text-white" name="saveEdit">Guardar Cambios</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>

                    <div class="response-message text-center"></div>
                </form>
            </div>
        </div>
    </div>
</div>

