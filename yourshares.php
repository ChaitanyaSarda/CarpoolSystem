<?php
	ob_start();
	session_start();
	require 'connect.inc.php';
	if(!empty($_SESSION['user_id'])){
			$uid = $_SESSION['user_id'];
			$name = $_SESSION['name'];
			$q = "select * from `SHARING_INFORMATION` where `uid` = '$uid' and `remaining_cap` >= '1'";
			$qr = mysql_query($q);
			$q_count = mysql_num_rows($qr);
			echo '<div id="intro2"><p style="font-size:17px;">Your Shares, <strong>'.$name.'</strong></p><br><table id="myTable" class="tablesorter"><thead>';
			echo '<tr><td>Source</td><td>Destination</td><td>Start Time</td><td>Reaching Time</td><td>Cost</td>';
			echo '<td>Gender Preference</td><td>Age Preference</td><td>Capacity</td><td>Remaining Capacity</td><td>Daily</td></tr></thead><tbody>';
			$prev_st = "";$prev_rt = "";$prev_vid = 0;$prev_source = "";$prev_dest = "";
			for($i = 0;$i<$q_count;$i++){
				$source = mysql_result($qr,$i,'source');
				$dest = mysql_result($qr,$i,'destination');
				$is_daily = mysql_result($qr,$i,'is_available_daily');
				$date = mysql_result($qr,$i,'date_of_travel');
				$starttime = mysql_result($qr,$i,'start_time');
				$reachtime = mysql_result($qr,$i,'reaching_time');
				$cost = mysql_result($qr,$i,'sharing_cost');
				$gp = mysql_result($qr,$i,'gender_preference');
				$ap_min = mysql_result($qr,$i,'age_preference_min');
				$ap_max = mysql_result($qr,$i,'age_preference_max');
				$capacity = mysql_result($qr,$i,'allowable_passenger');
				$rem_cap = mysql_result($qr,$i,'remaining_cap');
				$vid = mysql_result($qr,$i,'vid');
				$day = "";				
				if($is_daily == 1)$day = "Daily";else $day = $date;
				if(!($prev_st == $starttime && $prev_rt == $reachtime && $prev_vid == $vid && $prev_source = $source && $prev_dest == $dest)){
					echo '<tr><td>'.$source.'</td><td>'.$dest.'</td><td>'.$starttime.'</td><td>'.$reachtime.'</td>';
					echo '<td>'.$cost.'</td><td>'.$gp.'</td><td>'.$ap_min.'-'.$ap_max.'</td><td>'.$capacity.'</td><td>'.$rem_cap.'</td><td>'.$day.'</td>';
					echo '</tr>';
					$prev_st = $starttime;$prev_rt = $reachtime;$prev_vid = $vid;$prev_source = $source;$prev_dest = $dest;
				}
			}
			if($q_count == 0)
				echo '<p><strong style="color:brown;font-size:17px;">No shares!</strong></p>';
			echo '</tbody></table></div>';
	}
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
      <meta charset=utf-8 />
      <title>Carpool System</title>
	<link href="stylesheet.css" rel="stylesheet">
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.9.1/jquery.tablesorter.min.js"></script>	
	<script type="text/javascript">
	$(function(){
		$("#myTable").tablesorter();
	  });
	</script>
<style type="text/css">
	*	{margin:0px;padding:0px;}
	#wrapper {margin-left:auto;margin-right:auto;width:80%;margin-top:auto;margin-bottom:auto;height:650px;border:5px solid blue;}
	#r1 {height:320px;width:260px;text-align:center;padding:40px;padding-top:80px;border-right:2px solid black;margin-top:20px;}
	#gap {height:15px;background-color:brown;width:100%;}
	a {text-decoration:none;}
	a:visited {color:blue;}
	#r2 {position:absolute;top:270px;left:540px;height:100px;width:560px;text-align:left;padding:40px;font-size:13px;}
	#r3 {position:absolute;top:420px;left:540px;height:100px;width:560px;text-align:left;padding:40px;font-size:13px;}
	#nw {color:red;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
	#error {position:absolute;top:5px;left:840px;color:red;width:250px;font-size:18px;text-align:center;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:155px;left:570px;color:black;width:540px;font-size:13px;}
	span {font-size:15px;}
	td {width:50px;padding-bottom:10px;text-align:center;padding-right:10px;font-size:14px;}
</style>
</head>
<body>
<div id="wrapper">
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="r1">
	<p><a href="loggedin.php">Home</a></p><br>
	<p><a href="VehicleRegistration.php">Vehicle Registration</a></p><br>
	<p><a href="sharepage.php">Offer a Share</a></p><br>
	<p><a href="logout.php">Logout</a></p><br>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</div>
</body>
</html>


