<?php

class UserModel{

static public function newUser($name, $lastname, $mail, $phone, $password) {

    $query = "INSERT INTO users(name, lastname, mail, phone, password) VALUES(':name', ':lastname', ':mail', ':phone', ':password')";
    $stmt=MysqlDb::connectToDatabase()->prepare($query);
    $stmt->bindParam(':name', $name,PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname,PDO::PARAM_STR);
    $stmt->bindParam(':mail', $mail,PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone,PDO::PARAM_STR);
    $stmt->bindParam(':password', $password,PDO::PARAM_STR);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }


}
}


?>