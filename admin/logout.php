<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/mvmshop/includes/init.php';
	unset($_SESSION['SBUser']);
	header('Location: login.php');
?>