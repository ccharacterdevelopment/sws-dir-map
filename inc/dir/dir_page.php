<?php

session_start();

error_log(print_r($_SESSION['sws'],true),0);

include "assets/Db.php";
include "assets/functions_sws.php";
include "assets/dir_functions.php";

if (isset($_GET['u'])) {$union=urldecode($_GET['u']);} else {$union="ANB";}

$group=$_SESSION['sws']['list_shortname'];

sws_iframe_head();

?>
<div class='dirlist_holder'>
<p><a href='dir_unions.php'>BACK TO UNION LIST</a></p>
<?php

sws_list_dir_by_union($union,$group);

?>
<br>
<a href='dir_unions.php'>BACK TO UNION LIST</a></p>
</div><script type="text/javascript" src="../custom/javascript/iframeResizer.contentWindow.min.js"></script>
</body></HTML>