<!DOCTYPE HTML>
<html lang="en">
<head>
	<link href="stylesheet.css" rel="stylesheet">
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.9.1/jquery.tablesorter.min.js"></script>	
	<script type="text/javascript">
	$(function(){
		$("#myTable").tablesorter();
	  });
	</script>
      <meta charset=utf-8 />
      <title>Carpool System</title>
<style type="text/css">
	*	{margin:0px;padding:0px;}
	#wrapper {margin-left:auto;margin-right:auto;width:80%;margin-top:auto;margin-bottom:auto;height:650px;border:5px solid blue;}
	#r1 {height:320px;width:260px;text-align:center;padding:40px;padding-top:80px;border-right:2px solid black;margin-top:20px;}
	#gap {height:15px;background-color:brown;width:100%;}
	a {text-decoration:none;}
	a:visited {color:blue;}
	#r2 {position:absolute;top:260px;left:460px;height:100px;width:450px;text-align:left;padding:40px;font-size:12px;}
	#nw {color:red;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
	#error {position:absolute;top:5px;left:840px;color:red;width:250px;font-size:18px;text-align:center;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:200px;left:515px;color:black;width:430px;font-size:18px;font-family:comic sans MS;}
	span {font-size:15px;}
	td {width:50px;padding-bottom:10px;text-align:center;padding-right:13px;font-size:14px;}
</style>
</head>
<body>
<div id="wrapper">
<?php
	ob_start();
	session_start();
	require 'connect.inc.php';
	if(!empty($_SESSION['user_id'])){
		if(isset($_POST['pick'])&&isset($_POST['dest'])&&isset($_POST['day'])&&isset($_POST['pref'])&&isset($_POST['vehicle_ty'])&&isset($_POST['cost'])&&isset($_POST['req'])){
			if(!empty($_POST['pick'])&&!empty($_POST['dest'])&&!empty($_POST['day'])&&!empty($_POST['pref'])&&!empty($_POST['vehicle_ty'])&&!empty($_POST['cost'])){
				$source = strtolower($_POST['pick']);
				$dest = strtolower($_POST['dest']);
				$day = strtolower($_POST['day']);
				$pref = $_POST['pref'];
				$vtype = strtolower($_POST['vehicle_ty']);
				$cost = $_POST['cost'];
				$day = trim($day);
				$day_req = $_POST['req'];
				$is_owned = 0;$is_daily = 0;
				if($pref == "owner")$is_owned = 1;
				if($day_req == "yes")$is_daily = 1;
				$user_id = $_SESSION['user_id'];
				$q = "INSERT INTO `REQUEST_TABLE` VALUES('','$source','$dest','$is_owned','$day','$vtype','$cost','$is_daily','$user_id')";
				$qr = mysql_query($q);
				$q = "SELECT `rid` FROM `REQUEST_TABLE` WHERE `source` = '$source' AND `destination` = '$dest' AND `is_owned` = '$is_owned' AND `date` = '$day' AND `vtype` = '$vtype' AND `max_cost` = '$cost' AND `is_daily` = '$is_daily'";
				$qr = mysql_query($q);
				$_SESSION['rid'] = mysql_result($qr,0,'rid');
				if($day_req == "yes"){
						$query = "SELECT DISTINCT `sid`,`start_time`,`reaching_time`,`sharing_cost`,`gender_preference`,`age_preference_min`,
						`age_preference_max`,`vid`,`uid` FROM `SHARING_INFORMATION` WHERE `source` = '$source' AND `destination` = '$dest' 
						AND `is_available_daily` = 1 AND `sharing_cost` <= '$cost'";
						$query_run = mysql_query($query);
						$query_num = mysql_num_rows($query_run);
						if($query_num > 0){
							echo '<div id="r2"><form action="result_proc.php" method="POST"><table id="myTable" class="tablesorter"><thead>';
							echo '<tr><td>Select</td><td>Start Time</td><td>Reaching Time</td><td>Cost</td><td>Vehicle Type</td><td>Purchase Year</td>';
							echo '<td>Owned</td><td>Gender Preference</td><td>Age Preference</td><td>Name</td><td>Gender</td><td>Mobile No.</td></tr></thead><tbody>';
							$prev_st = "";$prev_rt = "";$prev_vid = 0;$prev_uid = 0;
							for($i = 0;$i < $query_num;$i++){
								$sid = mysql_result($query_run,$i,'sid');
								$starttime = mysql_result($query_run,$i,'start_time');
								$reachtime = mysql_result($query_run,$i,'reaching_time');
								$cost = mysql_result($query_run,$i,'sharing_cost');
								$gp = mysql_result($query_run,$i,'gender_preference');
								$ap_min = mysql_result($query_run,$i,'age_preference_min');
								$ap_max = mysql_result($query_run,$i,'age_preference_max');
								$vid = mysql_result($query_run,$i,'vid');
								$uid = mysql_result($query_run,$i,'uid');
								$query1 = "SELECT * FROM `VEHICLE` WHERE `vid`='".$vid."'";
								$query1_run = mysql_query($query1);
								$vehicle_type = mysql_result($query1_run,0,'vehicle_type');
								$year_pur = mysql_result($query1_run,0,'year_of_pur');
								$owner = mysql_result($query1_run,0,'is_owned');
								$query1 = "SELECT * FROM `USER` WHERE `uid`='".$uid."'";
								$query1_run = mysql_query($query1);
								$name = mysql_result($query1_run,0,'name');
								$gender = mysql_result($query1_run,0,'gender');
								$mob = mysql_result($query1_run,0,'mobile_no');
								if(/*$owner == $is_owned && */!($prev_st == $starttime && $prev_rt == $reachtime && $prev_vid == $vid && $prev_uid = $uid)){
									$otype = "";
									if($owner == 1)$otype = "Privately";else $otype = "Hired";
									echo '<tr><td><input type="radio" name="results" value="'.$sid.'"></td><td>'.$starttime.'</td><td>'.$reachtime.'</td>';
									echo '<td>'.$cost.'</td><td>'.$vehicle_type.'</td><td>'.$year_pur.'</td><td>'.$otype.'</td><td>'.$gp.'</td><td>'.$ap_min.'-'.$ap_max.'</td>
											<td>'.$name.'</td><td>'.$gender.'</td><td>'.$mob.'</td>';
									echo '</tr>';
									$prev_st = $starttime;$prev_rt = $reachtime;$prev_vid = $vid;$prev_uid = $uid;
								}
							}
							echo '</tbody></table><br><br><input type="submit" value="Send Notifications"></form></div>';
						}
				}	
				else{
					$query = "SELECT DISTINCT `sid`,`start_time`,`reaching_time`,`sharing_cost`,`gender_preference`,";
					$query = $query."`age_preference_min`,`age_preference_max`,`vid`,`uid` FROM `SHARING_INFORMATION`";
					$query = $query." WHERE `source` = '$source' AND `destination` = '$dest' AND `sharing_cost` <= '$cost' AND `date_of_travel` = '$day'";
					$query = $query." and `remaining_cap` > 0";
					$query_run = mysql_query($query);
					$query_num = mysql_num_rows($query_run);
					if($query_num > 0){
						echo '<div id="r2"><form action="result_proc.php" method="POST"><table id="myTable" class="tablesorter"><thead>';
						echo '<tr style="border-bottom:1px solid black;"><td>Select</td><td>Start Time</td><td>Reaching Time</td><td>Cost</td><td>Vehicle Type</td><td>Purchase Year</td>';
						echo '<td>Owned</td><td>Gender Preference</td><td>Age Preference</td><td>Name</td><td>Gender</td><td>Mobile No.</td></tr></thead><tbody>';
						for($i = 0;$i < $query_num;$i++){
							$sid = mysql_result($query_run,$i,'sid');
							$starttime = mysql_result($query_run,$i,'start_time');
							$reachtime = mysql_result($query_run,$i,'reaching_time');
							$cost = mysql_result($query_run,$i,'sharing_cost');
							$gp = mysql_result($query_run,$i,'gender_preference');
							$ap_min = mysql_result($query_run,$i,'age_preference_min');
							$ap_max = mysql_result($query_run,$i,'age_preference_max');
							$vid = mysql_result($query_run,$i,'vid');
							$uid = mysql_result($query_run,$i,'uid');
							$query1 = "SELECT * FROM `VEHICLE` WHERE `vid`='".$vid."'";
							$query1_run = mysql_query($query1);
							$vehicle_type = mysql_result($query1_run,0,'vehicle_type');
							$year_pur = mysql_result($query1_run,0,'year_of_pur');
							$owner = mysql_result($query1_run,0,'is_owned');
								$query1 = "SELECT * FROM `USER` WHERE `uid`='".$uid."'";
								$query1_run = mysql_query($query1);
								$name = mysql_result($query1_run,0,'name');
								$gender = mysql_result($query1_run,0,'gender');
								$mob = mysql_result($query1_run,0,'mobile_no');
							//if($owner == $is_owned){
								$otype = "";
								if($owner == 1)$otype = "Privately";else $otype = "Hired";
								echo '<tr><td><input type="radio" name="results" value="'.$sid.'"></td><td>'.$starttime.'</td><td>'.$reachtime.'</td>';
								echo '<td>'.$cost.'</td><td>'.$vehicle_type.'</td><td>'.$year_pur.'</td><td>'.$otype.'</td><td>'.$gp.'</td><td>'.$ap_min.'-'.$ap_max.'</td>
											<td>'.$name.'</td><td>'.$gender.'</td><td>'.$mob.'</td>';
								echo '</tr>';
							//}
						}
						echo '</tbody></table><br><br><input type="submit" value="Send Notifications"></form></div>';
					}else{
						$query = "SELECT DISTINCT r1.sid as fsid, r1.start_time as fst,r1.reaching_time as frt,r1.sharing_cost as fsc,
									r1.gender_preference as fgp,
						r1.vid as fvid,r1.uid as fuid,r1.source as fsource,r1.destination as fdest
						,r2.sid as ssid,r2.start_time as sst,r2.reaching_time as srt,r2.sharing_cost as ssc,r2.gender_preference as sgp,
						r2.vid as svid,r2.uid as suid,r2.source as ssource,r2.destination as sdest
						 FROM `SHARING_INFORMATION` as r1, `SHARING_INFORMATION` as r2
						 WHERE r1.source = '$source' AND r2.destination = '$dest' AND r1.sharing_cost <= '$cost' AND r1.date_of_travel = '$day'
						and r2.sharing_cost <='$cost' and r2.date_of_travel = '$day' and r1.remaining_cap > 0 and r2.remaining_cap > 0 and
						r1.destination = r2.source and r2.start_time >= r1.reaching_time";
						$query_run = mysql_query($query);
						$query_num = mysql_num_rows($query_run);
						if($query_num > 0){
							echo '<div id="r2">
									No single sharing option found so combination of two shared vehicle is shown below:<br><br>
									<form action="result_proc_d.php" method="POST"><table id="myTable" class="tablesorter"><thead>';
							echo '<tr style="border-bottom:1px solid black;"><td>Select</td><td>Source</td><td>Destination</td><td>Start Time</td><td>Reaching Time</td><td>Cost</td>';
							echo '<td>Owned</td><td>Gender Preference</td><td>Vehicle Type</td><td>Name</td><td>Gender</td><td>Mobile No.</td></tr></thead><tbody>';
							for($i = 0;$i < $query_num;$i++){
								$fsid = mysql_result($query_run,$i,'fsid');
								$ssid = mysql_result($query_run,$i,'ssid');
								$fstarttime = mysql_result($query_run,$i,'fst');
								$freachtime = mysql_result($query_run,$i,'frt');
								$fcost = mysql_result($query_run,$i,'fsc');
								$fgp = mysql_result($query_run,$i,'fgp');
								$fvid = mysql_result($query_run,$i,'fvid');
								$fuid = mysql_result($query_run,$i,'fuid');
								$fsource = mysql_result($query_run,$i,'fsource');
								$fdest = mysql_result($query_run,$i,'fdest');
								$query1 = "SELECT * FROM `VEHICLE` WHERE `vid`='".$fvid."'";
								$query1_run = mysql_query($query1);
								$fvehicle_type = mysql_result($query1_run,0,'vehicle_type');
								$fowner = mysql_result($query1_run,0,'is_owned');
								$query1 = "SELECT * FROM `USER` WHERE `uid`='".$fuid."'";
								$query1_run = mysql_query($query1);
								$fname = mysql_result($query1_run,0,'name');
								$fgender = mysql_result($query1_run,0,'gender');
								$fmob = mysql_result($query1_run,0,'mobile_no');
								
								$sstarttime = mysql_result($query_run,$i,'sst');
								$sreachtime = mysql_result($query_run,$i,'srt');
								$scost = mysql_result($query_run,$i,'ssc');
								$sgp = mysql_result($query_run,$i,'sgp');
								$svid = mysql_result($query_run,$i,'svid');
								$suid = mysql_result($query_run,$i,'suid');
								$ssource = mysql_result($query_run,$i,'ssource');
								$sdest = mysql_result($query_run,$i,'sdest');
								$query1 = "SELECT * FROM `VEHICLE` WHERE `vid`='".$svid."'";
								$query1_run = mysql_query($query1);
								$svehicle_type = mysql_result($query1_run,0,'vehicle_type');
								$sowner = mysql_result($query1_run,0,'is_owned');
								$query1 = "SELECT * FROM `USER` WHERE `uid`='".$suid."'";
								$query1_run = mysql_query($query1);
								$sname = mysql_result($query1_run,0,'name');
								$sgender = mysql_result($query1_run,0,'gender');
								$smob = mysql_result($query1_run,0,'mobile_no');
								//if($fowner == $is_owned && $sowner == $is_owned){
									$otype = "";
									if($fowner == 1)$otype = "Privately";else $otype = "Hired";
									echo '<tr><td><input type="radio" name="results" value="'.$fsid.'-'.$ssid.'"></td><td>'.$fsource.'</td><td>'.$fdest.'</td>';
									echo '<td>'.$fstarttime.'</td><td>'.$freachtime.'</td><td>'.$fcost.'</td><td>'.$otype.'</td><td>'.$fgp.'</td>
											<td>'.$fvehicle_type.'</td>
											<td>'.$fname.'</td><td>'.$fgender.'</td><td>'.$fmob.'</td>';
									echo '</tr>';
									echo '<tr><td></td><td>'.$ssource.'</td><td>'.$sdest.'</td>';
									echo '<td>'.$sstarttime.'</td><td>'.$sreachtime.'</td><td>'.$scost.'</td><td>'.$otype.'</td>
											<td>'.$sgp.'</td><td>'.$svehicle_type.'</td>
											<td>'.$sname.'</td><td>'.$sgender.'</td><td>'.$smob.'</td>';
									echo '</tr>';
								//}
							}
							echo '</tbody></table><br><br><input type="submit" value="Send Notifications"></form></div>';								
						}
						else echo '<div id="r2">No sharing option found...<br><br></div>';
					}
				}
			}else header('Location:Vehicle_Search.php');
		}
	}else header('Location:index.php');
?>

<h1>Carpool System</h1>
<p id="gap"></p>
<div id="r1">
	<p><a href="loggedin.php">Home</a></p><br>
	<p><a href="discard_req.php">Discard this request</a></p><br>
	<p><a href="Vehicle_Search.php">Back</a></p><br>
	<p><a href="logout.php">Logout</a></p><br>
</div>
<p id="intro2">Results Retrieved:<br><span>(check those results you find suitable so that owner can be notified of your request)</span></p>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</div>
</body>
</html>

