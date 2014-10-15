<?php
	ob_start();
	session_start();
	require 'connect.inc.php';
	if(!empty($_SESSION['user_id'])){
			$uid = $_SESSION['user_id'];
			$q = "select `sharingtable_id`,`request_table_id` from `REQUESTMESSAGE` where `requester_id` = '$uid' and `isread` = '1' and `accepted` = '0'";
			$qr = mysql_query($q);
			$q_count = mysql_num_rows($qr);
			echo '<div id="intro2"><p style="font-size:16px;">Requests Denied:</p><br>';
			for($i = 0;$i<$q_count;$i++){
				$rid = mysql_result($qr,$i,'sharingtable_id');
				$q1 = "select * from `SHARING_INFORMATION` where `sid` = '$rid'";
				$qr1 = mysql_query($q1);
				$sh_uid = mysql_result($qr1,0,'uid');
				$source = mysql_result($qr1,0,'source');
				$dest = mysql_result($qr1,0,'destination');
				$rid = mysql_result($qr,$i,'request_table_id');
				$q1 = "select * from `REQUEST_TABLE` where `rid` = '$rid'";
				$qr1 = mysql_query($q1);
				$is_daily = @mysql_result($qr1,0,'is_daily');
				$date = @mysql_result($qr1,0,'date');
				$q1 = "select * from `USER` where `uid` = '$sh_uid'";
				$qr1 = mysql_query($q1);
				$name = mysql_result($qr1,0,'name');
				$gender = mysql_result($qr1,0,'gender');
				$mob = mysql_result($qr1,0,'mobile_no');
				$day = "";
				$i++;
				if($is_daily == 1)$day = "Daily";else $day = $date;
				echo $i.') Your request with "'.$name.' '.$gender.' '.$mob.'" SOURCE:"'.$source.'", DEST:"'.$dest.'", DAY:"'.$day.'" has been <span style="color:red">REJECTED</span><br><br>';
			}
			if($q_count == 0)
				echo 'No requests denied<br><br>';
			$q = "select `sharingtable_id`,`request_table_id` from `REQUESTMESSAGE` where `requester_id` = '$uid' and `isread` = '1' and `accepted` = '1'";
			$qr = mysql_query($q);
			$q_count = mysql_num_rows($qr);
			echo '<p style="font-size:16px;">Requests Accepted:</p><br>';
			for($i = 0;$i<$q_count;$i++){
				$rid = mysql_result($qr,$i,'sharingtable_id');
				$q1 = "select * from `SHARING_INFORMATION` where `sid` = '$rid'";
				$qr1 = mysql_query($q1);
				$sh_uid = mysql_result($qr1,0,'uid');
				$source = mysql_result($qr1,0,'source');
				$dest = mysql_result($qr1,0,'destination');
				$rid = mysql_result($qr,$i,'request_table_id');
				$q1 = "select * from `REQUEST_TABLE` where `rid` = '$rid'";
				$qr1 = mysql_query($q1);
				$is_daily = @mysql_result($qr1,0,'is_daily');
				$date = @mysql_result($qr1,0,'date');
				$q1 = "select * from `USER` where `uid` = '$sh_uid'";
				$qr1 = mysql_query($q1);
				$name = mysql_result($qr1,0,'name');
				$gender = mysql_result($qr1,0,'gender');
				$mob = mysql_result($qr1,0,'mobile_no');
				$day = "";
				$i++;
				if($is_daily == 1)$day = "Daily";else $day = $date;
				echo $i.') Your request with "'.$name.' '.$gender.' '.$mob.'" SOURCE:"'.$source.'", DEST:"'.$dest.'", DAY:"'.$day.'" has been <span style="color:green">ACCEPTED</span><br><br>';
			}
			if($q_count == 0)
				echo 'No requests accepted<br><br>';
			$q = "select `sharingtable_id`,`request_table_id` from `REQUESTMESSAGE` where `requester_id` = '$uid' and `isread` = '0'";
			$qr = mysql_query($q);
			$q_count = mysql_num_rows($qr);
			echo '<p style="font-size:16px;">Unread Requests:</p><br>';
			for($i = 0;$i<$q_count;){
				$rid = mysql_result($qr,$i,'sharingtable_id');
				$q1 = "select * from `SHARING_INFORMATION` where `sid` = '$rid'";
				$qr1 = mysql_query($q1);
				$sh_uid = mysql_result($qr1,0,'uid');
				$source = mysql_result($qr1,0,'source');
				$dest = mysql_result($qr1,0,'destination');
				$rid = mysql_result($qr,$i,'request_table_id');
				$q1 = "select * from `REQUEST_TABLE` where `rid` = '$rid'";
				$qr1 = mysql_query($q1);
				$is_daily = @mysql_result($qr1,0,'is_daily');
				$date = @mysql_result($qr1,0,'date');
				$q1 = "select * from `USER` where `uid` = '$sh_uid'";
				$qr1 = mysql_query($q1);
				$name = mysql_result($qr1,0,'name');
				$gender = mysql_result($qr1,0,'gender');
				$mob = mysql_result($qr1,0,'mobile_no');
				$day = "";
				$i++;
				if($is_daily == 1)$day = "Daily";else $day = $date;
				echo $i.') Your request with "'.$name.' '.$gender.' '.$mob.'" SOURCE:"'.$source.'", DEST:"'.$dest.'", DAY:"'.$day.'" has not been read<br><br>';
			}
			if($q_count == 0)
				echo 'No unread requests';
			echo '</div>';
	}
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
      <meta charset=utf-8 />
      <title>Carpool System</title>
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
	#intro2 {position:absolute;top:155px;left:540px;color:black;width:620px;font-size:13px;}
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


