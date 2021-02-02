<?php

session_start();

foreach ($_GET as $key=>$value) {
	$value=base64_decode($value);
    ${$key}=$value;
}
unset($_SESSION['sew']);

$_SESSION['sew']['login']=$a;
$_SESSION['sew']['role']=$b;
$_SESSION['sew']['user_id']=$c;
$_SESSION['sew']['firstname']=$d;
$_SESSION['sew']['which']="cm";
$_SESSION['sew']['cm']="cm";
$_SESSION['sew']['function_path']="/var/www/html/cm/db/assets/cm_functions.php";

 header("Location: https://min-db1.nadadventist.org/dbi/index.php");

?>