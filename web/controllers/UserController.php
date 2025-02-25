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
                header("Location: ..index.php?num=error");
                exit();
            }
            
            $checkMail=UserModel::checkForDuplicates($mail);

            if($checkMail!=false){
                header("Location: index.php?duplicate=error");
                exit();
                
            }

            
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                header("Location: index.php?email=error");
                exit();
            }
            
            $checkPhone=UserModel::checkForDuplicates($phone);
            if($checkPhone!=false){
                header("Location: index.php?duplicate=error");
                exit();
                
            }
          
            $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            
           
            $insert = UserModel::newUser($name, $lastname, $_POST["email"], $_POST["phone"], $hashedPassword);
            
            if ($insert) {
                header("Location: index.php?success=correcto");
                exit();
            } else {
                header("Location: index.php?error=error");
                exit();
            }
        } else {
             header("Location: index.php?void=error");
            exit();
        }
    }
}

?>