<?php
class UserModel {
    static public function newUser($name, $lastname, $mail, $phone, $password) {
        $query = "INSERT INTO users(name, last_name, mail, phone, password, status) 
                  VALUES(:name, :last_name, :mail, :phone, :password, 1)";
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

}




?>