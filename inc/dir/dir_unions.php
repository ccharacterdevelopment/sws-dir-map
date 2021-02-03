<?php

include "assets/Db.php";
include "assets/functions_sws.php";


if (isset($_GET['m'])) {$min=$_GET['m']; $_SESSION['sew']['min']=$_GET['m'];} else {$min='fam'; $_SESSION['sew']['min']="fam";}

$_SESSION['sew']['which']="fam";

sws_style_links();

?>
<div style='width:100%'>
<?php

 sew_list_unions($min);

?></div>
</body></html>