<?php

session_start();

// this page is a redirect that sets session variables
	$_SESSION['sew']['which']='cm'; 
	$_SESSION['sew']['function_path']='../cm/db/assets/cm_functions.php';
	$_SESSION['sew']['style_path']='../cm/db/assets/styles.css';

// print_r($_SESSION);

header("Location: ../../dbi/index.php");

?>