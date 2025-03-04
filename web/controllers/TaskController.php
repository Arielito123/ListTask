<?php
class TaskController {
    public function prioritySelect() {
        $showPriority = TaskModel::showPriorityTask();

		foreach ($showPriority as $key => $value) {
			echo '<option value="' . $value['id_priority'] . '">' . $value['details_priority'] .'</option>';
		}
    }
    public function newTask($id_user) {
        if(!empty($_POST['name_task']) && !empty($_POST['description']) && !empty($_POST['priority_task']) && !empty($_POST['reminder_date'])) {
            $name_task = $_POST['name_task'];
            $description_task = $_POST['description'];
            $priority_task = $_POST['priority_task'];
            $reminder_date = $_POST['reminder_date'];
            
           
            if(strlen($name_task) > 30) {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&letter_name=error");
                exit();
            }
    
          
            if(strlen($description_task) > 100) {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&description_letter=error");
                exit();
            }
    
            
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $today = new DateTime();
            $due_date_obj = new DateTime($reminder_date);
            
            
            $today_formatted = $today->format('Y-m-d H:i');
            $due_date_formatted = $due_date_obj->format('Y-m-d H:i');
    
            if ($due_date_formatted <= $today_formatted) {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&date_error=error");
                exit();
            }
            
            
    
            
            $insertTask = TaskModel::insertTask($name_task, $description_task, $reminder_date, $id_user,$priority_task);
    
            
            if($insertTask) {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&new_task=correcto");
                exit();
            } else {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&new_task=error");
                exit();
            }
        } else {
            
            header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&void=error");
            exit();
        }
    }

    static public function viewTask($id_user)
    {
        $dataTask = TaskModel::dataTask($id_user);
        return $dataTask;
    }

    static public function viewTaskProgress($id_user)
    {
        $dataTask = TaskModel::dataTaskProgress($id_user);
        return $dataTask;
    }

    static public function viewTaskComplete($id_user)
    {
        $dataTask = TaskModel::dataTaskComplete($id_user);
        return $dataTask;
    }

    public function editTask() {
        if (!empty($_POST['task_name']) && !empty($_POST['description']) && !empty($_POST['reminder_date']) && !empty($_POST['id_task'])) {
            $name_task = $_POST['task_name'];
            $description_task = $_POST['description'];
            $reminder_date = $_POST['reminder_date'];
            $id_task = $_POST['id_task'];
    
            if (strlen($name_task) > 70) { // Antes estaba validando 30
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&letter_name=error");
                exit();
            }
    
            if (strlen($description_task) > 100) {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&description_letter=error");
                exit();
            }
    
           

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $today = new DateTime();
            $due_date_obj = new DateTime($reminder_date);
            
            
            $today_formatted = $today->format('Y-m-d H:i');
            $due_date_formatted = $due_date_obj->format('Y-m-d H:i');
    
            if ($due_date_formatted <= $today_formatted) {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&date_error=error");
                exit();
            }
    
            // Llamada correcta al modelo
            $updateTask = TaskModel::editTask($name_task, $description_task, $reminder_date, $id_task);
    
            if ($updateTask) {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&edit_task=correcto");
                exit();
            } else {
                header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&edit_task=error");
                exit();
            }
        } else {
            header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&void=error");
            exit();
        }
    }

    public function deleteTask($id_task) {
        
     
        $deleteTask = TaskModel::deleteTask($id_task);
    
        if ($deleteTask) {
            header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&delete_task=correcto");
            exit();
        } else {
            header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&delete_task=error");
            exit();
        }
    }

    public function deleteTaskProgress($id_task) {
        
     
        $deleteTask = TaskModel::deleteTask($id_task);
    
        if ($deleteTask) {
            header("Location: index.php?pages=manageTasks&subfolder=progressTask&delete_task=correcto");
            exit();
        } else {
            header("Location: index.php?pages=manageTasks&subfolder=progressTask&delete_task=error");
            exit();
        }
    }

    public function deleteTaskCompleted($id_task) {
        
     
        $deleteTask = TaskModel::deleteTask($id_task);
    
        if ($deleteTask) {
            header("Location: index.php?pages=manageTasks&subfolder=completedTask&delete_task=correcto");
            exit();
        } else {
            header("Location: index.php?pages=manageTasks&subfolder=completedTask&delete_task=error");
            exit();
        }
    }

    public function editTaskStateUnnassigned() {
        $id_task = $_POST['id_task'];
        $editTaskState = TaskModel::editTaskStateUnnasigned($id_task);
    
        if ($editTaskState) {
            header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&edit_task_state=correcto");
            exit();
        } else {
            header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&edit_task_state=error");
            exit();
        }
    }

    public function editTaskState() {
        $id_task = $_POST['id_task'];
        $editTaskState = TaskModel::editTaskState($id_task);
    
        if ($editTaskState) {
            header("Location: index.php?pages=manageTasks&subfolder=progressTask&edit_task_state=correcto");
            exit();
        } else {
            header("Location: index.php?pages=manageTasks&subfolder=progressTask&edit_task_state=error");
            exit();
        }
    }

    public function editTaskStateComplete() {
        $id_task = $_POST['id_task'];
        $editTaskState = TaskModel::editTaskStateComplete($id_task);
    
        if ($editTaskState) {
            header("Location: index.php?pages=manageTasks&subfolder=completedTask&edit_task_state=correcto");
            exit();
        } else {
            header("Location: index.php?pages=manageTasks&subfolder=completedTask&edit_task_state=error");
            exit();
        }
    }
    
    public function notificationTask(){
       $id_task = $_POST['id_task'];
      
       $updateTask = TaskModel::notificationUpdateState($id_task);

       if ($updateTask) {
        header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&edit_task_state=correcto");
        exit();
    } else {
        header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&edit_task_state=error");
        exit();
    }
    
}
}