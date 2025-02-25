<?php

class IndexController {
	
	public function run() {
	
        session_start();
		if (isset($_SESSION['status']) && $_SESSION['status'] == 1) {
            include "views/";
        } else {
            include "views/pages/Register.php";
        }
		
	}

}


?>