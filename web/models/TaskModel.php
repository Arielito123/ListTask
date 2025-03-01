<?php
class TaskModel {
    static public function showPriorityTask() {
        $sql = " SELECT priority.id_priority AS id_priority,
                 priority.details AS details_priority
                 FROM priority ;
		";
		$stmt = MysqlDb::connectToDatabase()->prepare($sql);

		if ($stmt->execute()) {

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {

			print_r($stmt->errorInfo());
		}

		$stmt = null;
    }

    static public function insertTask($name_task, $description, $reminder_date, $fk_user_id, $priority) {
        $query = "INSERT INTO tasks(title, description, reminder_date, fk_id_user, fk_priority_id, fk_task_state_id) 
                  VALUES(:name_task, :description, :reminder_date, :fk_user_id, :fk_priority_id, 1)";
        
        $stmt = MysqlDb::connectToDatabase()->prepare($query);
        $stmt->bindParam(':name_task', $name_task, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':reminder_date', $reminder_date, PDO::PARAM_STR);  
        $stmt->bindParam(':fk_user_id', $fk_user_id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_priority_id', $priority, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    static public function dataTask($id_user)
    {
       

        $sql = "SELECT 
        tasks.id AS id_task,
        tasks.title AS name_task,
        tasks.description AS description_task,
        tasks.reminder_date AS reminder_date,
        tasks.fk_id_user AS id_user,
        users.mail AS user_mail,
        tasks.fk_priority_id AS task_priority,
        priority.details AS detail_priority,
        tasks.fk_task_state_id AS task_state,
        task_state.details AS detail_state_task,
        tasks.notification_state AS notification_state,
        tasks.created_at AS created_at
    FROM tasks
    JOIN users ON tasks.fk_id_user = users.id
    JOIN priority ON tasks.fk_priority_id = priority.id_priority
    JOIN task_state ON tasks.fk_task_state_id = task_state.id_task_state
    WHERE fk_task_state_id = 1 AND fk_id_user = :id_user";  

$stmt = MysqlDb::connectToDatabase()->prepare($sql);
$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

if ($stmt->execute()) {
return $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
print_r($stmt->errorInfo());
}

$stmt = null;

    }

    static public function editTask($name_task, $description_task, $reminder_date, $id_task){
        $sql = "UPDATE tasks SET title=:name_task, description=:description_task, reminder_date=:reminder_date WHERE id=:id_task";
        
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':name_task', $name_task, PDO::PARAM_STR);
        $stmt->bindParam(':description_task', $description_task, PDO::PARAM_STR);
        $stmt->bindParam(':reminder_date', $reminder_date, PDO::PARAM_STR);
        $stmt->bindParam(':id_task', $id_task, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    static public function deleteTask($id_task) {
        $sql = "DELETE FROM tasks WHERE id=:id_task";
    
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_task', $id_task, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->rowCount() > 0;
    }


    static public function editTaskStateUnnasigned($id_task) {
        $sql = "UPDATE tasks SET fk_task_state_id=1 WHERE id=:id_task";
        
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_task', $id_task, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    static public function editTaskState($id_task) {
        $sql = "UPDATE tasks SET fk_task_state_id=2 WHERE id=:id_task";
        
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_task', $id_task, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    static public function editTaskStateComplete($id_task) {
        $sql = "UPDATE tasks SET fk_task_state_id=3 WHERE id=:id_task";
        
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_task', $id_task, PDO::PARAM_INT);
        
        return $stmt->execute();
    }


    static public function notificationUpdateState($id_task) {
        $sql = "UPDATE tasks SET notification_state=1 WHERE id=:id_task";
        
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_task', $id_task, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function selectTask() {
        $sql = "SELECT 
                    tasks.id AS id_task,
                    users.id AS id_user,
                    users.name AS name,
                    users.last_name AS last_name,
                    users.mail AS mail_user,
                    tasks.reminder_date AS reminder_date,
                    tasks.title AS name_task,
                    tasks.notification_state AS notification_state  -- ✅ Corrección aquí
                FROM tasks
                JOIN users ON tasks.fk_id_user = users.id
                WHERE tasks.notification_state = 1";  
        
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            print_r($stmt->errorInfo());
        }
    
        $stmt = null;
    }
    

    static public function updateNotificationState($id_task) {
        $sql = "UPDATE tasks SET notification_state=0 WHERE id=:id_task";
        
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_task', $id_task, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    
    static public function dataTaskProgress($id_user)
    {
       

        $sql = "SELECT 
        tasks.id AS id_task,
        tasks.title AS name_task,
        tasks.description AS description_task,
        tasks.reminder_date AS reminder_date,
        tasks.fk_id_user AS id_user,
        users.mail AS user_mail,
        tasks.fk_priority_id AS task_priority,
        priority.details AS detail_priority,
        tasks.fk_task_state_id AS task_state,
        task_state.details AS detail_state_task,
        tasks.notification_state AS notification_state,
        tasks.created_at AS created_at
    FROM tasks
    JOIN users ON tasks.fk_id_user = users.id
    JOIN priority ON tasks.fk_priority_id = priority.id_priority
    JOIN task_state ON tasks.fk_task_state_id = task_state.id_task_state
    WHERE fk_task_state_id = 2 AND fk_id_user = :id_user";  

$stmt = MysqlDb::connectToDatabase()->prepare($sql);
$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

if ($stmt->execute()) {
return $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
print_r($stmt->errorInfo());
}

$stmt = null;

    }

    static public function dataTaskComplete($id_user)
    {
       

        $sql = "SELECT 
        tasks.id AS id_task,
        tasks.title AS name_task,
        tasks.description AS description_task,
        tasks.reminder_date AS reminder_date,
        tasks.fk_id_user AS id_user,
        users.mail AS user_mail,
        tasks.fk_priority_id AS task_priority,
        priority.details AS detail_priority,
        tasks.fk_task_state_id AS task_state,
        task_state.details AS detail_state_task,
        tasks.notification_state AS notification_state,
        tasks.created_at AS created_at
    FROM tasks
    JOIN users ON tasks.fk_id_user = users.id
    JOIN priority ON tasks.fk_priority_id = priority.id_priority
    JOIN task_state ON tasks.fk_task_state_id = task_state.id_task_state
    WHERE fk_task_state_id = 3 AND fk_id_user = :id_user";  

$stmt = MysqlDb::connectToDatabase()->prepare($sql);
$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

if ($stmt->execute()) {
return $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
print_r($stmt->errorInfo());
}

$stmt = null;

    }

}
?>
