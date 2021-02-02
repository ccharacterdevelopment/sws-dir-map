<?php

function min_validate_page($roles="administrator|office") {

	//print_r($_SESSION['sew']);
	//echo $_SESSION['sew']['role']."<hr />";
	//echo $roles;
	
	if (
	((isset($_SESSION['sew']['role'])) && 
	(
		(!(strpos($_SESSION['sew']['role'],"dministrato"))===false) ||
		(!(strpos($_SESSION['sew']['role'],"office"))===false)	
		
	)) 
	|| ((isset($_SESSION['sew']['auth'])) && ($_SESSION['sew']['auth']==true)) )
	{
		//print_r($_SESSION['sew']);
		
		$test="Cowabunga"; 
	} else {
		if ((!isset($_SESSION['sew']['role'])) || (strpos($roles,$_SESSION['sew']['role'])===false)) { // redirect to login page
	header("Location: https://min-db1.nadadventist.org/dbi/blank.html");
		}
	}
}


?>