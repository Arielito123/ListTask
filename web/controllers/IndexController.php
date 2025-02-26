<?php

class IndexController {
	
	public function run() {
	
        session_start();
		if(isset($_SESSION['id_rol']) && ($_SESSION['state']==1)) {
            include "views/CheckPoint.php";
        } else {
            include "views/pages/login.php";
        }
		
	}

}


?>