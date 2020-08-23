<?php
	session_unset();
	require_once  'controller/tasksController.php';		
    $controller = new tasksController();	
    $controller->mvcHandler();
?>