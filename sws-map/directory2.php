<?php
session_start();

require_once("../../functions/Db.php");
require_once("../../functions/functions_sew.php");
require_once("../../dbi/min_functions.php");

if (!(isset($_SESSION['sew']['which']))) { $_SESSION['sew']['which']="cm"; $my_min="cm";} else { 
	$my_min=$_SESSION['sew']['which'];}
$db = new Db();

// VALIDATE GET VAR
if (isset($_GET['id'])) {
 	$id=$_GET['id'];	
} else {$id="ANP";}

  $fileName=$id.".php";
  $u_name=sew_retrieve_itemname("full_text","common.temp_union",$id,"id");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Interactive Directory</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

     <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<link href='//fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>
<link href='assets/dir_styles.css' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
   <script src="//min-db1.nadadventist.org/javascript/sew_spamspan.js"></script>
<!--[if IE]>
<style>
	.column1 { min-height: 450px;}
</style><![endif]-->
</head>
<body style="font-family: 'Questrial', sans-serif;">
<script type="text/javascript">
function showOne(id) {
    $('.details').not(id).addClass('hideClass');
    $('#'+ id).removeClass('hideClass'); 	
}   
</script>

<div class='container' style='width:100%'>	
  <p style='padding: 8px; text-align:center; '>Hover/click a state/province to see contact information for Children's Ministries leadership.<br /><a href='directory.php'><strong>BACK TO DIVISION</strong></a></p>
  <div style='margin-top:-25px'>
<?php  include $fileName; ?>
	<div class="column2">
<?php  
if (!($_GET['s']=="GU")) {
min_list_union($u_name,$id,"N","N",4,"Y","N"); 
min_interactive_state_divs($id);
min_interactive_conf_divs($id);
} else { 
	
	echo "<h3>Guam-Micronesia Mission</h3>";
	
	$sql="select * from ".$my_min.".".$my_min."_master where conference like \"%Guam%\" and groups like '%:7:%' order by lastname";
$conf_array = $db -> select($sql); 
	if (count($conf_array)>0) {
			foreach ($conf_array as $key=>$value) {
				echo "<hr />";
				$row=$conf_array[$key];

				min_directory($row,"N","N","Y","Y","N","Y",$u_group,"N","Y"); 
// min_directory($row, $edit="Y", $show_groups="Y", $show_dir="Y", $show_conf="N", $show_union="N",$link_site="N", $u_group=4,$outerDiv="Y",$confWord="N")					
			
			} 
		} else { echo "<hr /> NONE LISTED for <strong>$conf_name</strong></hr>";}

	
}
?>
	</div>
<?php
 if (isset($_GET['s'])) { echo "<script type='text/javascript'>showOne('".$_GET['s']."');</script>"; } 
 if (isset($_GET['c'])) { echo "<script type='text/javascript'>showOne('".$_GET['c']."');</script>"; }
?>
    </div></div>
       <script src="assets/dir_script.js"></script>	
</body>

</html>