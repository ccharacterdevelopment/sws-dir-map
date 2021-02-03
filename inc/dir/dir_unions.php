<?php

session_start();

include "assets/Db.php";
include "assets/functions_sws.php";
include "assets/dir_functions.php";


//$_SESSION['sew']['which']="fam";

if (isset($_GET['m'])) {$min=$_GET['m']; $_SESSION['sew']['min']=$_GET['m'];} else {$min='fam'; $_SESSION['sew']['min']="fam";}

if (isset($_GET['vars'])) { // process url vars
	$tmp=urldecode(base64_decode(json_decode($vars,true)));
	print_r($tmp);
} else {

	
}

sws_iframe_head($themedir,$themedir2);
?>
<div style='width:100%'>
<?php

 sew_list_unions($min);

?></div>
</body></html>