<?php

session_start();

include "assets/Db.php";
include "assets/functions_sws.php";
include "assets/dir_functions.php";


$_SESSION['sew']['which']="fam";

if (isset($_GET['m'])) {$min=$_GET['m']; $_SESSION['sew']['min']=$_GET['m'];} else {$min='fam'; $_SESSION['sew']['min']="fam";}

if (isset($_GET['t'])) { // get stylesheet directories from URL initially
	$_SESSION['sew']['themedir']=urldecode($_GET['t']); $themedir=urldecode($_GET['t']); 
	$_SESSION['sew']['themedir2']=urldecode($_GET['t2']); $themedir2=urldecode($_GET['t2']); 
} else {
	$themedir=$_SESSION['sew']['themedir'];
	$themedir2=$_SESSION['sew']['themedir2'];
}

sws_iframe_head($themedir,$themedir2);
?>
<div style='width:100%'>
<?php

 sew_list_unions($min);

?></div>
</body></html>