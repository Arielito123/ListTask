<?php 
class UserController {
    public function register() {
      
       
        if (
            !empty($_POST["name"]) &&
            !empty($_POST["last_name"]) &&
            !empty($_POST["email"]) &&
            !empty($_POST["phone"]) &&
            !empty($_POST["password"]&& !empty($_POST["repeatPassword"]))
        ) {
            
            $name = ucwords(strtolower(trim($_POST['name'])));
            $lastname = ucwords(strtolower(trim($_POST['last_name'])));
            $mail=$_POST['email'];
            $phone=$_POST['phone'];

            
           
            if (
                !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name) ||
                !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $lastname)
            ) {
                header("Location:  register.php?letter=error");
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

            if($_POST["password"]!=$_POST["repeatPassword"]){
                header("Location: register.php?password=error");
                exit();
            }

            if (strlen($_POST["password"]) < 8) {
                header("Location: register.php?passwordLong=error");
                exit();
            }
          
            $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            
           
            $insert = UserModel::newUser($name, $lastname, $mail, $phone, $hashedPassword);
            
            if ($insert) {
                MailerController::sendNewUser($mail, $name, $lastname);
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
                $id_user = $verificar['id'];
                $id_rol = $verificar['fk_rol_id'];
                $state = $verificar['status'];
                if ($state == 1) {
                    $_SESSION['id_user'] = $id_user;
                    $_SESSION['id_rol'] = $id_rol;
                    $_SESSION['state'] = $state;
                   
                    header("Location: index.php?pages=home");
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

    public static function getSessionData($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }


    static public function sessionDataUser($id)
    {
        $dataUser = UserModel::dataUser($id);
        return $dataUser;
    }


    public function editUser() {
      
       
        if (
            !empty($_POST["name_user"]) &&
            !empty($_POST["last_name_user"]) &&
            !empty($_POST["user_mail"]) &&
            !empty($_POST["user_phone"] && !empty($_POST["id_user"]))
        ) {
            
            
            
            $name = ucwords(strtolower(trim($_POST['name_user'])));
            $lastname = ucwords(strtolower(trim($_POST['last_name_user'])));
            $mail=$_POST['user_mail'];
            $phone=$_POST['user_phone'];
            $id_user=$_POST['id_user'];
            
           
            if (
                !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name) ||
                !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $lastname)
            ) {
                header("Location: index.php?pages=myData&letter=error");
                exit();
            }
            
            
            if (strlen($name) > 70 || strlen($lastname) > 70) {
                header("Location: index.php?pages=myData?num=error");
                exit();
            }

            if (strlen($phone) > 15) {
                header("Location: index.php?pages=myData&phone=error");
                exit();
            }
            
           
           
            
            
            
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                header("Location: index.php?pages=myData&email=error");
                exit();
            }
            
                     
         
            
           
            $insert = UserModel::editUser($name, $lastname, $mail, $phone, $id_user);
            
            if ($insert) {
               
                header("Location: index.php?pages=myData&success=correcto");
                exit();
            } else {
                header("Location: index.php?pages=myData&error=error");
                exit();
            }
        } else {
             header("Location: index.php?pages=myData&void=error");
            exit();
        }
    }


}


?>