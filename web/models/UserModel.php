<?php
class UserModel {
    static public function newUser($name, $lastname, $mail, $phone, $password) {
        $query = "INSERT INTO users(name, last_name, mail, phone, password,fk_rol_id, status) 
                  VALUES(:name, :last_name, :mail, :phone, :password,1,1)";
        $stmt = MysqlDb::connectToDatabase()->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        
        return $stmt->execute();
    }


    static  public function checkForDuplicates($value1)
    {
        try {
        
            $checkQuery = "SELECT COUNT(*) FROM users WHERE  mail = :mail ";
            $checkStatement = MysqlDb::connectToDatabase()->prepare($checkQuery);
            $checkStatement->bindParam(':mail', $value1, PDO::PARAM_STR);
            $checkStatement->execute();

            $count = $checkStatement->fetchColumn();

            if ($count > 0) {


                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo "Error en la validación de duplicados: " . $e->getMessage();
            return false;
        }
    }

    static public function login($user, $password)
    {
        $query = "SELECT id, mail, name, last_name, password, fk_rol_id, status
                  FROM users WHERE mail = :mail";
    
        $statement = MysqlDb::connectToDatabase()->prepare($query);
        $statement->bindParam(':mail', $user, PDO::PARAM_STR); // Corregido: sin espacio extra
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($row && password_verify($password, $row['password'])) {
            return $row;
        }
    
        return false;
    }
    static public function getFirstValidCredential()
    {
        $sql = "SELECT id_contact, host, email, token, port_email, certificatedSSL
                FROM credential_email
                WHERE id_contact = 1";
    
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
    
        try {
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Error al ejecutar la consulta: " . implode(" ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
    static public function dataUser($id)
    {
       

        $sql = "SELECT users.id AS id_user, 
        users.name AS name_user,
        users.last_name AS last_name_user,
        users.mail AS user_mail,
        users.phone AS user_phone,
        Roles.details as name_rol 
        FROM users join Roles on users.fk_rol_id=Roles.id_rol 
        WHERE users.id = :id_user";
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_user', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }


    static public function editUser($name_user, $last_name_user, $user_mail, $user_phone, $id_user){
        $sql = "UPDATE users SET name = :name_user, last_name = :last_name_user, phone = :phone_user, mail = :mail_user WHERE id = :id_user";
    
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':name_user', $name_user, PDO::PARAM_STR);
        $stmt->bindParam(':last_name_user', $last_name_user, PDO::PARAM_STR);
        $stmt->bindParam(':phone_user', $user_phone, PDO::PARAM_STR);
        $stmt->bindParam(':mail_user', $user_mail, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    


}




?>