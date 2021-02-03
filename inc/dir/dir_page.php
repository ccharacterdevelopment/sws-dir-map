<?php

include "assets/Db.php";
include "assets/functions_sws.php";
include "assets/dir_functions.php";

if (isset($_GET['u'])) {$union=urldecode($_GET['u']);} else {$union="ANB";}
if (isset($_GET['m'])) {$min=$_GET['m'];} else {$min='fam';}

//echo sew_su_tags($min);

$_SESSION['sew']['which']="fam";
$_SESSION['sew']['fam']="fam";

include "assets/style_links.php";

?>
<div class='dirlist_holder'>
<p><a href='dir_unions.php?m=<?php echo $min; ?>'>BACK TO UNION LIST</a></p>
<?php

fm_list_dir_by_union($union,$min);

?>
<br>
<a href='dir_unions.php?m=<?php if (isset($_GET['m'])) { echo $_GET['m']; } ?>'>BACK TO UNION LIST</a></p>
</div><script type="text/javascript" src="../custom/javascript/iframeResizer.contentWindow.min.js"></script>
</body></HTML>