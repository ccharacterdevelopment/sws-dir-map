<?php require_once("assets/functions_map.php"); ?>
	<div style='width: 70%; text-align:center; margin-left: 15%; margin-right:auto; display: flex; justify-content: space-evenly; align-items: center'>
	  <div class="dropdown">
  <select onChange="showOne(this.value,'sws_dir');">		
  <option selected>CHOOSE Union/Conference</option>
<?php $unionArr=sws_union_arr(); 

foreach ($unionArr as $row) { 

	echo "<option class='u-dropdown' value='".$row[0]."'>".strtoupper($row[1])."</option>";

	foreach ($row[2] as $conf) {
		echo "<option class='c-dropdown' value='".$conf[0]."'>&nbsp;&nbsp;&nbsp;".$conf[1]."</option>";
	}
}

	echo "<option class='u-dropdown' value='GU'>Guam-Micronesia Mission</option>";
	
?> </select>
  </div>
  <div class="dropdown">
  <select onChange="showOne(this.value,'country');">
  <option selected>CHOOSE State/Province</option>
<?php $stateArr=sws_state_arr();

foreach ($stateArr as $row) {
	echo "<option value='".$row[0]."|".$row[1]."'>".$row[2]."</option>";
}
?>
</select>
  </div>
       <div id='chooseCountry' class='flex country'>
          Displaying 
            <input name="radio" type="radio" id="showUS" value="us-map" onclick="showOne('us-map','country');" <?php if ((!isset($_GET['id'])) || (!$_GET['id']=="AN6")) { echo 'checked="checked"'; } ?> />
          <label for="radio">United States</label>
      <input type="radio" name="radio" id="showCAN" value="can-map" onclick="showOne('AN6','country');" <?php if ((isset($_GET['id'])) && ($_GET['id']=="AN6")) { echo 'checked="checked"'; } ?>/>
      <label for="radio2">Canada</label>
	</div>
    <div id='returnNAD' class='country hideClass'>
    	<button class='btn btn-primary' onClick="showOne('us-map','country');">Back to NAD</button>
    </div>
</div>
<?php 
include ("AN6.php"); 
include ("USA.php"); 
include ("AN4.php");
include ("ANB.php");
include ("ANF.php");
include ("ANG.php");
include ("ANI.php");
include ("ANP.php");
include ("ANT.php");
include ("ANW.php");


//print_r($unionArr);
?>	
