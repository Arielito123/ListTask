<?php 
class UserController {
    public function register() {
      
       
        if (
            !empty($_POST["name"]) &&
            !empty($_POST["last_name"]) &&
            !empty($_POST["email"]) &&
            !empty($_POST["phone"]) &&
            !empty($_POST["password"])
        ) {
            
            $name = ucwords(strtolower(trim($_POST['name'])));
            $lastname = ucwords(strtolower(trim($_POST['last_name'])));
            $mail=$_POST['email'];
            $phone=$_POST['phone'];

            
           
            if (
                !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name) ||
                !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $lastname)
            ) {
                header("Location: index.php?letter=error");
                exit();
            }
            
            
            if (strlen($name) > 70 || strlen($lastname) > 70) {
                header("Location: register.php?num=error");
                exit();
            }
            
            $checkMail=UserModel::checkForDuplicates($mail);

            if($checkMail!=false){
                header("Location: register.php?duplicate=error");
                exit();
                
            }

            
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                header("Location: register.php?email=error");
                exit();
            }
            
            $checkPhone=UserModel::checkForDuplicates($phone);
            if($checkPhone!=false){
                header("Location: register.php?duplicate=error");
                exit();
                
            }
          
            $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            
           
            $insert = UserModel::newUser($name, $lastname, $_POST["email"], $_POST["phone"], $hashedPassword);
            
            if ($insert) {
                header("Location: register.php?success=correcto");
                exit();
            } else {
                header("Location: register.php?error=error");
                exit();
            }
        } else {
             header("Location: register.php?void=error");
            exit();
        }
    }

    public function control_login()
    {

        if ((!empty($_POST['mail'])) && !empty($_POST['password'])) {

            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $verificar = UserModel::login($mail,$password);
            if ($verificar != false) {
                $id_user = $verificar['id_user'];
                $id_rol = $verificar['fk_rol_id'];
                $state = $verificar['status'];
                if ($state == 1) {
                    $_SESSION['state'] = $state;
                    $_SESSION['id_user'] = $id_user;
                    $_SESSION['id_rol'] = $id_rol;
                    

                    header("Location: register.php?logrado=correcto");//por el momento es de prueba
                    exit();
               
                }
            } else {
                    header("Location: index.php?verify=error");
                    exit();
            }
        } else {
            header("Location: index.php?void=error");
            exit();
        }
    }

}

?>