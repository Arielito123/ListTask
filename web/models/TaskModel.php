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
    
}
?>
