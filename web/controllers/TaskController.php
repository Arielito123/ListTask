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
    
            
            $today = new DateTime();
            $due_date_obj = new DateTime($reminder_date);
            
            if($due_date_obj < $today) {
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

    static public function viewTask()
    {
        $dataTask = TaskModel::dataTask();
        return $dataTask;
    }
    
}