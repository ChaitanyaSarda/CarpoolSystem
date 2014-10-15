<?php
	ob_start();
	session_start();
	require 'connect.inc.php';
	if(!empty($_SESSION['user_id'])){
		$uid = $_SESSION['user_id'];
		$q = "select * from BOOKING where rq_id = '$uid' or sh_id = '$uid'";
		$qr = mysql_query($q);
		$count = mysql_num_rows($qr);
		echo '<div id="intro2"><p style="font-size:17px;">Booking History:</p><br><table id="myTable" class="tablesorter"><thead>';
		echo '<tr><td>Name</td><td>Gender</td><td>Mob.</td><td>Source</td><td>Destination</td><td>Day</td>
				<td>Cost</td><td>Start Time</td><td>Reaching Time</tr></thead><tbody>';
		for($i = 0;$i<$count;$i++){
			$sh_id = mysql_result($qr,$i,'sh_id');
			$rq_id = mysql_result($qr,$i,'rq_id');
			$book_id = 0;
			if($rq_id == $uid)$book_id = $sh_id;else $book_id = $rq_id;
			$q1 = "select name,gender,mobile_no from `USER` where uid = '$book_id'";
			$qr1 = mysql_query($q1);
			$source = mysql_result($qr,$i,'source');
			$dest = mysql_result($qr,$i,'destination');
			$cost = mysql_result($qr,$i,'cost');
			$is_daily = @mysql_result($qr,$i,'is_daily');
			$date = @mysql_result($qr,$i,'date');
			$name = mysql_result($qr1,0,'name');
			$gender = mysql_result($qr1,0,'gender');
			$mob = mysql_result($qr1,0,'mobile_no');
			$start = @mysql_result($qr,$i,'starttime');
			$reach = @mysql_result($qr,$i,'reachtime');
			$day = "";
			$i++;
			if($is_daily == 1)$day = "Daily";else $day = $date;
			echo '<tr><td>'.$name.'</td><td>'.$gender.'</td><td>'.$mob.'</td><td>'.$source.'</td><td>'.$dest.'</td><td>'.$day.'</td>
				<td>'.$cost.'</td><td>'.$start.'</td><td>'.$reach.'</tr>';
		}
		if($count == 0)
			echo '<p><strong style="color:brown;font-size:17px;">No Booked History!</strong></p>';
		echo '</tbody></table></div>';
	}else header('Location:index.php');
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
	#intro2 {position:absolute;top:155px;left:580px;color:black;width:540px;font-size:13px;}
	span {font-size:15px;}
	td {width:50px;padding-bottom:10px;text-align:center;padding-right:13px;font-size:14px;}
</style>
</head>
<body>
<div id="wrapper">
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="r1">
	<p><a href="loggedin.php">Home</a></p><br>
	<p><a href="VehicleRegistration.php">Vehicle Registration</a></p><br>
	<p><a href="Vehicle_Search.php">Find a Share</a></p><br>
	<p><a href="logout.php">Logout</a></p><br>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</div>
</body>
</html>


