<?php

class IndexController {
	
	public function run() {
	
        session_start();
		if (isset($_SESSION['status']) && $_SESSION['status'] == 'activo') {
            include "views/";
        } else {
            include "views/pages/LoginRegister.php";
        }
		
	}

}


?>