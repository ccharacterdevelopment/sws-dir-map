<?php

include "assets/Db.php";
include "assets/functions_sws.php";


if (isset($_GET['m'])) {$min=$_GET['m']; $_SESSION['sew']['min']=$_GET['m'];} else {$min='fam'; $_SESSION['sew']['min']="fam";}

// echo sew_su_tags($min);

$_SESSION['sew']['which']="fam";


include "assets/style_links.php";
?>
<div style='width:100%'>
<?php

 sew_list_unions($min);

?></div>
</body></html>