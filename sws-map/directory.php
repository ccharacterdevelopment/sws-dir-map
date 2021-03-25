<?php
session_start();

require_once("../../functions/Db.php");
require_once("../../functions/functions_sew.php");
require_once("../../dbi/min_functions.php");

echo $wpdb->prefix;

$_SESSION['sew']['which']="cm";
$db = new Db();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Interactive Directory</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	var count = 0;
	var depth = 8;
	$('document').ready(function(){
	while (count < depth){
    	$('#southwestern-union:hover').first().clone().appendTo('#southwestern-union:hover').css({"top" : count , "left" : count});
	count++;
  	}
	});
	
</script>
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

   <script src="//min-db1.nadadventist.org/javascript/sew_spamspan.js"></script>
</head>

<body style="font-family: 'Questrial', sans-serif;">
<script type="text/javascript">
function showOne(id) {
    $('.details').not(id).addClass('hideClass');
    $('#'+ id).removeClass('hideClass'); 	
}   
</script>
<script type="text/javascript">
        $(document).ready(function() {
		            
         $("#showUS").click(function () {
          $('#can-map').addClass('hideClass');
          $('#us-map').removeClass('hideClass');
            });
         
            $("#showCAN").click(function () {
          $('#us-map').addClass('hideClass');
          $('#can-map').removeClass('hideClass'); 
            });
         
        });     
    </script>
<div class='container' style='width:100%'>
	<div style='width: 70%; text-align:center; margin-left: 15%; margin-right:auto;'>
	  <table align="center">
      <tr><td colspan='2'><p style='padding: 8px'>Hover/click a region on the map for more information, or choose from the lists below.</p></td></tr>
    <tr>
    <td><div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">CHOOSE Union/Conference
        <span class="caret"></span></button>
        <ul class="dropdown-menu">    

<?php // LOOP UNIONS

$sql = "select * from common.temp_union order by full_text";  
$result=$db->select($sql);
$numrows=count($result);
foreach ($result as $key=>$value) {
	 $row=$result[$key];
	 $name=$row['full_text']; $code=$row['id'];
	 $name=str_replace("Union Conference","",$name);
	 $name=strtoupper(str_replace("Seventh-day Adventist","SDA",$name));
	echo "<li><strong><a href='directory2.php?id=$code'>$name</a></strong></li>";
	
	// LOOP CONFERENCES


$sql2 = "select * from common.temp_conf where id like '".$code."%' order by full_text";  
$result2=$db->select($sql2);
$numrows2=count($result2);
foreach ($result2 as $key2=>$value2) {
	 $row2=$result2[$key2];
	 $name2=$row2['full_text']; $code2=$row2['id'];
	 $name2=str_replace("Union Conference","",$name2);
	 $name2=str_replace("Seventh-day Adventist","SDA",$name2);
	echo "<li><a href='directory2.php?id=$code&c=$code2'>$name2</a></li>";

	}
}

	echo "<li><strong><a href='directory2.php?id=ANN&s=GU'>Guam-Micronesia Mission</a></strong></li>";
	
?> </ul>
  </div></td><td><div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">CHOOSE State/Province
        <span class="caret"></span></button>
        <ul class="dropdown-menu">   
      <?php // LOOP UNIONS

$sql = "select a.name, b.state_abbr, c.id  from common.states_provinces a, common.state_conf b, common.temp_conf c where a.abbr=b.state_abbr and b.state_conf=c.full_text group by a.name order by a.name";  
$result=$db->select($sql);
$numrows=count($result);
foreach ($result as $key=>$value) {
	 $row=$result[$key];
	 $name=$row['name']; $state=$row['state_abbr']; $union=strtoupper(substr($row['id'],0,3));
	echo "<li><a href='directory2.php?id=$union&s=$state'>$name</a></li>";
}
?>
</ul>
  </div></td></tr>
    <tr>
      <td colspan="2" align="center">
        <form id="form1" name="form1" method="post" action="" style='padding: 8px'>
          Displaying 
            <input name="radio" type="radio" id="showUS" value="us-map" checked="checked" />
          <label for="radio"></label>
      United States 
      <input type="radio" name="radio" id="showCAN" value="can-map" />
      <label for="radio2"></label>
Canada
        </form></td>
      </tr>
	  </table>
</div>
<?php include ("AN6.php"); ?>
<?php include ("USA.php"); ?>	
	</div>
</body>

</html>