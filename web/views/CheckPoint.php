<?php ob_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php 
    include_once "modules/head.php";
?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
<?php 
include_once "modules/navbar.php";
?>        
<?php 

    include_once "modules/sidebar.php";
?>
<div class="py-4 mb-2"></div>
<div class="content-wrapper">
<?php

    if( (isset($_GET['pages'])) && (isset($_SESSION['id_rol'])) ) {

        switch ($_SESSION['id_rol']) {
            case 1:
                include_once "getroles/getNormal.php";
                break;
           
        }
    } else {
        include "pages/home.php";     
    }       
?>    
</div>
<?php  

include_once "modules/footer.php";
?>
</div>
<?php 
include_once "modules/scripts.php";
?>
</body>
</html>
