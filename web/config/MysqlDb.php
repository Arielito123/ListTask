<?php

class MysqlDb {
    
       static  public function connectToDatabase()
        {
            $hostname = getenv("MYSQLSERVER");
            $database = getenv("DB_NAME_LIST");
            $username = getenv("MYSQL_USER");
            $password = getenv("MYSQL_PASSWORD");
            $charset = "utf8";
          
            try {
                $connection = "mysql:host=" . $hostname . ";dbname=" . $database . ";charset=" . $charset;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
    
                $pdo = new PDO($connection, $username, $password, $options);
                return $pdo;
            } catch (PDOException $e) {
                echo 'Error de conexión: ' . $e->getMessage();
                exit;
            }
        }
      
    static public function test(){
        $pdo = self::connectToDatabase();

        if ($pdo) {
            echo "Conexión exitosa";
        }else{
            echo "Conexión fallida";
        }

    }
}

?>