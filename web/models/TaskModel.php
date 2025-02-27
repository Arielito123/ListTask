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
    
    static public function dataTask()
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
                    tasks.created_at AS created_at
                    FROM tasks
                    JOIN users ON tasks.fk_id_user = users.id
                    JOIN priority ON tasks.fk_priority_id = priority.id_priority
                    join task_state ON tasks.fk_task_state_id= task_state.id_task_state
                    where fk_task_state_id=1;";
        $stmt = MysqlDb::connectToDatabase()->prepare($sql);
        $stmt->bindParam(':id_user', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

}
?>
