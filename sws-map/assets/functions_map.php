<?php

$u_group=4;
$c_group=7;
$my_min="fm";
$ministry="Family Ministries";
$myArr=array('prefix','firstname','lastname','title','address1','address2','city','state','zip','country','work_phone','fax','email','website','conference','union_conf');

require_once("Db.php");

function sws_fromBig($id,$bigArr) { 
	foreach($bigArr as $array) {
		if ($array[0]==$id) { return $array[2];}	
	}
	return false;
}

function sew_spamSpan($email) {

	/**if (filter_var($email, FILTER_VALIDATE_EMAIL)) {	
		$at_pos=strpos($email,"@");
		$last_dot=strrpos($email,".");

		$user=substr($email,0,$at_pos);
		$domain=substr($email,$at_pos+1,$last_dot-1-$at_pos);
		$ext=substr($email,$last_dot+1,strlen($email));	

		$mytext="<span class=\"sew_spamspan\">
		<span class=\"sew_u\">$user</span>
		[at]
		<span class=\"sew_d\">$domain [dot] $ext</span>
		</span>";
		return $mytext;

	 } else { return $email; }*/
	 
	 // RE-ENABLE AFTER PLUGIN CHECK IF NEEDED
	 return $email;
}


function sws_show_entity($arr,$group="X") {
	
	if (!($group=="X")) { $class=" ".$group." ".$arr['orgID'];  } else 
		{  $class="2";}
	$retStr="<div class='sws_dir".$class."'><span class='sws_dir_title'>".$arr['conference']."</span><br />";
	if ((strpos($arr['lastname'],'Conference')===false) && (strpos($arr['lastname'],'Union')===false)) {
		$retStr.=$arr['prefix']." ".$arr['firstname']." ".$arr['lastname']."<br />";}
	if (strlen($arr['title'])>0) { $retStr.=$arr['title']."<br />";}
	$retStr.=$arr['address1']."<br />";
	if (strlen($arr['address2'])>0) { $retStr.=$arr['address2']."<br />";}
	$retStr.=$arr['city']." ".$arr['state']." ".$arr['zip']."<br />";
	if ((!(strtolower($arr['country'])=="usa")) && (strlen($arr['country'])>0)) { $retStr.=strtoupper($arr['country'])."<br />";}
	if (strlen($arr['work_phone'])>0) { $retStr.="PHONE: ".$arr['work_phone']."<br />";}
	if (strlen($arr['fax'])>0) { $retStr.="FAX: ".$arr['fax']."<br />";}
	if (strlen($arr['email'])>0) { $retStr.="EMAIL: <a href='mailto:".$arr['email']."'>".sew_spamSpan($arr['email'])."</a><br />";}
	if (strlen($arr['website'])>0) { $retStr.="<a href='".$arr['website']."' target='_blank'>".$arr['website']."</a><br />";}
	$retStr.="</div>";
	return $retStr;
}

function sws_entity_personnel($id) {
	$db = new Db(); global $my_min; global $u_group; global $c_group; global $myArr; global $ministry;
	$retArr=array();
	
	
	$entity_name="North American Division";


	if (strlen($id)==3) { // it's a Union
		if (!($id=="ANN")) {
			$entity_name= $db->query("select full_text from common.temp_union where id='$id' ")->fetch_object()->full_text;  
		} 	
		// get union office if it exists
		$sql="select * from ".$my_min.".".$my_min."_master where union_conf like '".$entity_name."%' and groups like '%:1:%'"; // echo $sql;
		$union_array = $db -> select($sql); 

		if (count($union_array)>0) { $tmp=array();
			foreach ($myArr as $item) { $tmp[$item]='';} // initialize all values to empty
			$tmp['name']=$entity_name." Office"; $tmp['orgID']=$id;
			foreach ($union_array as $key=>$value) {
				$row=$union_array[$key];
				foreach ($myArr as $item) { $tmp[$item]=$row[$item];}	
			}
			$retArr[]=$tmp;
		}
		
		$sql="select * from ".$my_min.".".$my_min."_master where conference like '".$entity_name."%' and union_conf like '".$entity_name."%' and  `groups` like '%:".$u_group.":%' order by lastname"; // echo $sql;
		$union_array = $db -> select($sql); 

		if (count($union_array)>0) {
			foreach ($union_array as $key=>$value) { $tmp2=array();
				foreach ($myArr as $item) { $tmp2[$item]='';} // initialize all values to empty
				$row=$union_array[$key]; $tmp2['orgID']=$id;
				foreach ($myArr as $item) { $tmp2[$item]=$row[$item];}	
				$retArr[]=$tmp2;
			}
		} else { // no results
			foreach ($myArr as $item) { $tmp2[$item]='';} // initialize all values to empty
			$tmp2['orgID']=$id;
			$tmp2['conference']=$entity_name;
			$tmp2['firstname']="No $ministry personnel listed at the Union level. Click one of the conferences for local information.";
			$retArr[]=$tmp2;
		}
	} else {
		$entity_name= $db->query("select full_text from common.temp_conf where id='$id' ")->fetch_object()->full_text;  
	
	// IT'S A CONFERENCE
		$sql2="select * from ".$my_min.".".$my_min."_master where conference=\"".$entity_name."\" and `groups` like '%:".$c_group.":%' order by lastname";  //echo $sql2;
		$conf_array = $db -> select($sql2); 
		if (count($conf_array)>0) {
			foreach ($conf_array as $key=>$value) {  $tmp2=array();
				foreach ($myArr as $item) { $tmp2[$item]=''; } // initialize all values to empty
				$row=$conf_array[$key]; $tmp2['orgID']=$id;
				foreach ($myArr as $item) { $tmp2[$item]=$row[$item];}	
				$retArr[]=$tmp2;
			}
		} else { // no results
			$tmp2=array();
			foreach ($myArr as $item) { $tmp2[$item]=''; } // initialize all values to empty
			$tmp2['orgID']=$id;
			$tmp2['conference']=$entity_name;
			$tmp2['firstname']="No $ministry personnel listed";
			$retArr[]=$tmp2;
		}
	}
	return $retArr;
}

function sws_union_arr($withConf="Yes") {
	$db = new Db();
	$retArr=array();
	
	$sql = "select * from common.temp_union order by full_text";  
	$result=$db->select($sql);
	$numrows=count($result);
	foreach ($result as $key=>$value) {
		 $row=$result[$key];
		 $name=$row['full_text']; $code=$row['id'];
		 $name=str_replace("Union Conference","",$name);
		 $name=str_replace("Seventh-day Adventist","SDA",$name);
		 
		 $tmp[0]=$code; $tmp[1]=$name;
		 
		 if ($withConf=="Yes") { 
			$tmp[2]=sws_conf_arr($code);
		 }
		 $retArr[]=$tmp;
	}
	return $retArr;
}

function sws_conf_arr($unionID) {
	$db = new Db();
	
	$retArr=array(); 
	
	$sql2 = "select * from common.temp_conf where id like '".$unionID."%' order by full_text";  
	$result2=$db->select($sql2);
	$numrows2=count($result2);
	foreach ($result2 as $key2=>$value2) {
		 $row2=$result2[$key2];
		 $name2=$row2['full_text']; $code2=$row2['id'];
		 $name2=str_replace("Union Conference","",$name2);
		 $name2=str_replace("Seventh-day Adventist","SDA",$name2);
	
		$tmp[0]=$code2; $tmp[1]=$name2;
		$retArr[]=$tmp;
	}
	return $retArr;
}


function sws_state_arr() {
	$db = new Db();
	
	$retArr=array(); 
	
	$sql = "select a.name, b.state_abbr, c.id  from common.states_provinces a, common.state_conf b, common.temp_conf c where a.abbr=b.state_abbr and b.state_conf=c.full_text group by a.name order by a.name";  
	$result=$db->select($sql);
	foreach ($result as $key=>$value) {
			 $row=$result[$key];
			 $name=$row['name']; $state=$row['state_abbr']; $union=strtoupper(substr($row['id'],0,3));

		$tmp[0]=$union; $tmp[1]=$state; $tmp[2]=$name;
		$retArr[]=$tmp;
	}
	return $retArr;
}

// OLD FUNCTIONS

// DIRECTORY FUNCTIONS


function min_list_union($union_name, $union, $expand="N",$edit="Y", $u_group=4, $link_site="N",$outerDiv="Y") {
	
	$db = new Db(); $my_min=$_SESSION['sew']['which'];	$k=0;

if ($outerDiv=="N") { echo "<div id='$union' style='clear:both; background-color: lavender; padding: 6px; max-height: 120px; overflow: auto'>"; } 
	else { echo "<div id='$union' style='clear:both'>"; }
	
	// first get office and any Union personnel
	$sql="select * from ".$my_min.".".$my_min."_master where union_conf like '".$union_name."%' and lastname='UNION'"; // echo $sql;
	$union_array = $db -> select($sql); 

	if (count($union_array)>0) {
		foreach ($union_array as $key=>$value) {
			$row=$union_array[$key];
			if (($k>0) && ($outerDiv=="N")) { echo "<hr />";}
			min_directory($row,$edit, "N","N","N","N",$link_site,$u_group, "Y");
			// min_directory($row,$edit,$show_groups,$show_dire,$show_conf,$show_union,$link_site,$u_group,$outerDiv,$confWord)
			$k++;
		}
	}

	$sql="select * from ".$my_min.".".$my_min."_master where union_conf like '".$union_name."%' and not lastname='UNION' and (conference like '%".$union_name."%' or conference='' or conference like '%Union%' or conference is null or `groups` like '%:".$u_group.":%') order by lastname"; // echo $sql;
	$union_array = $db -> select($sql); 

	if (count($union_array)>0) {
		foreach ($union_array as $key=>$value) {
			$row=$union_array[$key];
					if ($outerDiv=="N") { echo "<hr />";}
			min_directory($row,$edit, "N","N","N","N",$link_site,$u_group, "Y");

		}
	}
	echo "</div>";	
	
}

function min_list_conf($union,$expand="N",$edit="Y", $u_group=0,$show_groups="N",$show_dir="N",$show_conf="N",$show_union="N",$link_site="N") {
	$db = new Db(); $my_min=$_SESSION['sew']['which'];
	
	if (!($u_group==0)) { $u_txt= " and  `groups` like '%:".$u_group.":%'";} else {$u_txt="";}
	
if ($expand=="N") { $exp_txt=" style='display:none' ";} else {$exp_txt="";}
	// cycle through conference personnel
	$sqlC="select full_text from common.temp_conf where `id` like '%$union%' order by full_text"; //echo $sqlC;
	$conf_arrayC = $db -> select($sqlC); $k=0;
	foreach ($conf_arrayC as $keyC=>$valueC) {
		$myconf=$conf_arrayC[$keyC]['full_text']; 
		echo "<div style='clear: both;'></div><div style='position: relative; page-break-inside:avoid;'><br /><h3><a href=\"javascript: toggle('".$union."_".$k."')\">$myconf</a>";	
		$sql2="select * from ".$my_min.".".$my_min."_master where conference=\"".$myconf."\" $u_txt order by lastname";  //echo $sql2;
		$conf_array = $db -> select($sql2); 
		if (count($conf_array)>0) {
			echo "</h3><div id='".$union."_".$k."' $exp_txt>";
			foreach ($conf_array as $key=>$value) {
				$row=$conf_array[$key];
				min_directory($row,$edit,$show_groups,$show_dir,$show_conf,$show_union,$link_site); 
			} 
		} else { echo " -- NONE LISTED</h3><div>";}
		echo "</div></div>";
		$k++;
	}
	
}

function min_list_dir_by_union($union,$expand="N",$edit="Y", $u_group=4,$show_groups="Y",$show_dir="N",$show_conf="N",$show_union="N",$link_site="N",$outerDiv="Y") {

	$db = new Db(); $my_min=$_SESSION['sew']['which'];
	if ($union=="ANN") { $union_name="North American Division";} else {
	$union_name= $db->query("select full_text from common.temp_union where id='$union' ")->fetch_object()->full_text;  }
	echo "<h2>Ministry Personnel for the $union_name</h2><p class='no-print'>Click a heading to expand or contract it.";
	if ($expand=="N") { echo " Click a name to edit that person's record.";}
	echo "</p>";
	
	
	echo "<h3><a href=\"javascript: toggle('$union')\">$union_name</a></h3>";
	
min_list_union($union_name,$union, $expand,$edit,4,$link_site,$outerDiv);	
//	min_list_union($union_name,$union,$expand,$edit,$u_group,$link_site,$outerDiv);
min_list_conf($union,$expand,$edit,7,$show_groups,$show_dir,$show_conf,$show_union,$link_site);	
// 	min_list_conf($union,$expand,$edit,$u_group,$show_groups,$show_dir,$show_conf,$show_union,$link_site);
}

function min_list_names($index="X", $prefix="N", $mi="N") {
	$name="";
	if (is_null($index)) { return $name; } else {
		if (!($index=="X")) { 
			$db = new Db(); $my_min=$_SESSION['sew']['which'];
			$sql="select * from ".$my_min.".".$my_min."_master where id='$index'";
			$query = $db->select($sql);
			foreach ($query as $key=>$value) { 	$row=$query[$key];	}
		}

		if (($prefix=="Y") && (strlen($row['prefix'])>0)) { $name=$row['prefix']." "; }
		if ($mi=="Y") {		$name.=$row['firstname']." ".$row['mi']." ".$row['lastname']; }
			else { $name= $row['firstname']." ".$row['lastname']; }
		if ($row['lastname']=="UNION") {$name.=" OFFICE";}
	return $name;
	}
}


function min_directory($row, $edit="Y", $show_groups="Y", $show_dir="Y", $show_conf="N", $show_union="N",$link_site="N", $u_group=4,$outerDiv="Y",$confWord="N") {

if ($outerDiv=="Y") {	echo "<div style='min-width: 20em; display: inline-block; vertical-align: top; padding-bottom:1em' class='dir_listing'>"; };
if ($confWord=="Y") { $confText=" Conference";} else {$confText="";}
	
	echo "<div style='margin-left:1.5em; display: inline-block;'><strong>";
	if (($link_site=="Y") && (strlen($row['website'])>0)) {	
			echo "<a href='".$row['website']."' target='_blank'>";
			echo min_list_names($row['id']);
			echo "</a>";	
	} else {
	if ($edit=="Y") {
	 	echo "<a href='redirect.php?target=1&lookup=".$row['id']."'>";
		echo min_list_names($row['id']);
		echo "</a>";
	}   else {
			echo min_list_names($row['id']); 
	}}
			
	echo "</strong><br />";
	if ($show_conf=="Y") {
		if (strlen($row['conference'])>0) { 
			if ((strpos($row['conference'],"Union")===false) && (strpos($row['groups'],":".$u_group.":")===false) && (strpos($row['conference'],"Canada")===false)) { 	echo $row['conference']."$confText <br />";}
			else { echo "<strong>".$row['conference']."$confText </strong></br />";}
			if (strlen($row['conference_subgroup'])>0) { echo $row['conference_subgroup']."<br />";}
		}
	}
	if ($show_union=="Y") {
		if (strlen($row['union_conf'])>0) { echo $row['union_conf']."<br />";}
	}
	if (strlen($row['title'])>0) { echo $row['title']."<br />"; }
	if (strlen($row['address1'])>0) { echo $row['address1']."<br />"; }
	if (strlen($row['address2'])>0) { echo $row['address2']."<br />"; }
	if (strlen($row['city'].$row['state'].$row['zip'])>0) { echo $row['city']." ".$row['state']." ".$row['zip']."<br />"; }
	else { // HOME ADDRESS
		if (strlen($row['h_address1'])>0) { echo $row['h_address1']."<br />"; }
		if (strlen($row['h_address2'])>0) { echo $row['h_address2']."<br />"; }
		if (strlen($row['h_city'].$row['h_state'].$row['h_zip'])>0) { echo $row['h_city']." ".$row['h_state']." ".$row['h_zip']."<br />"; }	
	}
	if (!($row['country']=="USA")) {
		if (strlen($row['country'])>0) { echo $row['country']."<br />";}
	}
	if (strlen($row['work_phone'])>0) {
		$temp=strval(preg_replace("/[^0-9]+/","",$row['work_phone']));
		if (strlen($temp)==10) { $phone=sew_display_formatted_phone($row['work_phone']);} else {$phone=$row['work_phone'];}
		 echo "<strong>Phone:</strong> $phone<br />"; }
	if ((strlen($row['email'])>0) && (strpos($row['email'],"BAD")==false)) { 
		echo "<span style='font-weight:bold'>E-mail:</span> ".sew_spamSpan($row['email'])."<br />"; 
	}
	if ($show_groups=="Y") {
		$group_array=min_list_groups($row['id']); $mytext="";
		foreach ($group_array as $key=>$value) {
			$value=str_replace(" ","&nbsp;",$value);
			if ($show_dir=="Y") { $mytext.="&#8226; $value<br />";}
				else {
				if (strpos($value,"Director")===false)	{ $mytext.= "&#8226; $value<br />";}
			}
		}
		if (!($mytext=="")) { echo "<div class='sws-groups' style='display: inline-block; margin-left: 10px;  font-size:11px'>$mytext</div>";}	
	}
	echo "</div>";
if ($outerDiv=="Y") { echo "</div>";}	
	
}


function min_interactive_conf_divs($union_code="ANP",$u_group=7) {
	
	$my_min=$_SESSION['sew']['which'];
	$db = new Db();	

	$conf_array=array(); $k=0;
	$sql2="select `id` from common.temp_conf where `id` like '".$union_code."%'"; // echo $sql2;
	$group_array = $db -> select($sql2); 
	foreach ($group_array as $key=>$value) {
		$row=$group_array[$k]['id']; 
		array_push($conf_array,$row);
		$k++;
	}	
	
	
	foreach ($conf_array as $mytemp) {

echo "<div id='$mytemp' class='details hideClass' style='max-height: 360px;  overflow-y: auto;'>";

$sql="select full_text as mytemp from common.temp_conf where `id`='$mytemp'";
$conf_name=$db->query($sql)->fetch_object()->mytemp;

$sql="select * from ".$my_min.".".$my_min."_master where conference=\"".$conf_name."\" and groups like '%:$u_group:%' order by lastname";
$conf_array = $db -> select($sql); 
	if (count($conf_array)>0) {
			foreach ($conf_array as $key=>$value) {
				echo "<hr />";
				$row=$conf_array[$key];

				min_directory($row,"N","N","Y","Y","N","Y",$u_group,"N","Y"); 
// min_directory($row, $edit="Y", $show_groups="Y", $show_dir="Y", $show_conf="N", $show_union="N",$link_site="N", $u_group=4,$outerDiv="Y",$confWord="N")					
			
			} 
		} else { echo "<hr /> NONE LISTED for <strong>$conf_name</strong></hr>";}


echo "</div>";
}

}


function min_interactive_state_divs($u_code,$u_group=7) {
	
	
	$my_min=$_SESSION['sew']['which'];
	$db = new Db();

	$state_array=array(); $k=0;
	$sql2="SELECT * FROM common.state_conf where state_union=(select full_text from common.temp_union where id='".$u_code."') group by state_abbr order by state_conf"; 
	if ($u_code=="AN6") { $sql2="SELECT * FROM common.state_conf where state_union='SDA Church in Canada' group by state_abbr order by state_conf"; }
	$group_array = $db -> select($sql2); 
	foreach ($group_array as $key=>$value) {
		$row=$group_array[$k]['state_abbr']; 
		array_push($state_array,$row);
		$k++;
	}	
	
	//print_r($state_array);
	foreach ($state_array as $mystate) {

echo "<div id='$mystate' class='details hideClass' style='max-height: 360px;  overflow-y: auto;'>";

$sql="select `state_conf` as mytemp from common.state_conf where state_abbr like '$mystate'"; // echo $sql;
//$sql="select a.name as mytemp from common.states_provinces a, common.state_conf b, common.temp_conf c  where a.abbr=b.state_abbr and b.state_conf=c.full_text and b.state_abbr like '$mystate'";  echo $sql;
$state_name=$db->query($sql)->fetch_object()->mytemp;

$conf_array=array();
$sql="select d.* from common.states_provinces a, common.state_conf b, common.temp_conf c, cm.cm_master d where a.abbr=b.state_abbr and b.state_conf=c.full_text and b.state_abbr like '$mystate' and d.conference=c.full_text and d.groups like '%:$u_group:%' order by c.full_text, d.lastname"; //echo $sql;
$conf_array = $db -> select($sql); 
	if (count($conf_array)>0) {
			foreach ($conf_array as $key=>$value) {
				echo "<hr />";
				$row=$conf_array[$key];

				min_directory($row,"N","N","Y","Y","N","Y",$u_group,"N","Y"); 
// min_directory($row, $edit="Y", $show_groups="Y", $show_dir="Y", $show_conf="N", $show_union="N",$link_site="N", $u_group=4,$outerDiv="Y",$confWord="N")					
			
			} 
		} else { echo "<hr /> NONE LISTED for <strong>$state_name Conference</strong></hr>";}


echo "</div>";
}

}



?>