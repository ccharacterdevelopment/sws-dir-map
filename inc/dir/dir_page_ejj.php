<?php

session_start();

error_log(print_r($_SESSION['sws'],true),0);

include "assets/Db.php";
include "assets/functions_sws.php";
include "assets/dir_functions.php";

if (isset($_GET['u'])) {$union=urldecode($_GET['u']);} else {$union="ANB";}

$group=$_SESSION['sws']['group'];

sws_iframe_head();

?>
<style>
.ejj_dir_pic {
  display: grid;
  grid-template-columns: max-content;
  grid-auto-rows: 150px;
  grid-template-rows: 200px;
  max-width:70%;
  max-height: 300px;
  max-width: 200px;
  align-self: flex-end;
}

</style>
<div class='dirlist_holder'>
<a href='dir_unions_ejj.php'>BACK TO UNION LIST</a>
<?php

ejj_list_dir_by_union($union,$group);

?>
<br>
<a href='dir_unions_ejj.php'>BACK TO UNION LIST</a>
</div><!--<script type="text/javascript" src="../custom/javascript/iframeResizer.contentWindow.min.js"></script>-->
</body></HTML>
