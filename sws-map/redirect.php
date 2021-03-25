<?php
session_start();
error_log(session_id());

foreach ($_GET as $key=>$value) {
	$value=base64_decode($value);
    ${$key}=$value;
	error_log($key."|".$value."",0);
}


//unset($_SESSION['sew']);

$_SESSION['sew']['login']=$a;
$_SESSION['sew']['role']=$b;
$_SESSION['sew']['user_id']=$c;
$_SESSION['sew']['firstname']=$d;
$_SESSION['sew']['which']="cm";
$_SESSION['sew']['cm']="cm";
$_SESSION['sew']['function_path']="/var/www/html/cm/db/assets/cm_functions.php";


//error_log(print_r($_SESSION,true),0);
//error_log("/cm/db/redirect.php",0);

//session_write_close();
header("Location: ../../dbi/index.php");
exit;
?>
