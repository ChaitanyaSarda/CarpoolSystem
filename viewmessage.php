<?php
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
	$query1=mysql_query("SELECT * FROM `REQUESTMESSAGE` WHERE `sharer_id` =  '$userId' AND `isread` = '0'");
	$query1_num = mysql_num_rows($query1);
	if($query1_num == 0)
	{
		echo '<div id = "r2">You do not have any Messages!!</div>';
	}
	else
	{
		echo '<div id="r2"><form action="result_resolve.php" method="POST"><table id="myTable" class="tablesorter"><thead>';
		echo '<tr><td>Select</td><td>Name</td><td>Gender</td><td>Mobile No.</td>
				<td>Source</td><td>Destination</td><td>Date</td><td>Daily</td><td>Start Time</td><td>Reaching Time</td></tr></thead><tbody>';
		for($i = 0;$i < $query1_num;$i++){
			$j = 0;
			$mid = mysql_result($query1,$i,'mid');
			$requester_id = mysql_result($query1,$i,'requester_id');
			$sharingtable_id = mysql_result($query1,$i,'sharingtable_id');
			$sharer_id = mysql_result($query1,$i,'sharer_id');
			$request_table_id = mysql_result($query1,$i,'request_table_id');
			$isread = mysql_result($query1,$i,'isread');
			$query2=mysql_query("SELECT `source`,`destination`,`date_of_travel`,`start_time`,`reaching_time` FROM `SHARING_INFORMATION` WHERE `sid` = '$sharingtable_id'");
			$source = mysql_result($query2,$j,'source');
			$destination = mysql_result($query2,$j,'destination');
			$date_of_travel = mysql_result($query2,$j,'date_of_travel');
			$starttime = mysql_result($query2,$j,'start_time');
			$reachingtime = mysql_result($query2,$j,'reaching_time');
			$query3 = mysql_query("SELECT `is_daily` FROM REQUEST_TABLE WHERE `rid` = '$request_table_id'");
			$is_daily = mysql_result($query3,$j,'is_daily');
			if($sharer_id == $userId && $isread == 0){
				$query4 = mysql_query("UPDATE `REQUESTMESSAGE` SET  `isread` =  '1' WHERE  `REQUESTMESSAGE`.`mid` ='$mid'");
				$daily = '';
				if($is_daily)
					$daily = 'yes';
				else
					$daily = 'no';
				$q = "select * from USER where uid = $requester_id";
				$qrun = mysql_query($q);
			$name = mysql_result($qrun,0,'name');
			$gender = mysql_result($qrun,0,'gender');
			$mob = mysql_result($qrun,0,'mobile_no');
				echo '<tr><td><input type="checkbox" name="results[]" value="'.$mid.'"></td><td>'.$name.'</td><td>'.$gender.'</td>
				<td>'.$mob.'</td><td>'.$source.'</td>';
				echo '<td>'.$destination.'</td><td>'.$date_of_travel.'</td><td>'.$daily.'</td><td>'.$starttime.'</td><td>'.$reachingtime.'</td>';
				echo '</tr>';
			}
		}
		echo '</tbody></table><br><br><input type="submit" value="ACCEPT"></form></div>';
	}
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
	#r2 {position:absolute;top:260px;left:540px;height:100px;width:450px;text-align:left;padding:40px;font-size:12px;}
	#nw {color:red;}
	h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96%;background-color:blue;}
	#error {position:absolute;top:5px;left:840px;color:red;width:250px;font-size:18px;text-align:center;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:200px;left:580px;color:black;width:430px;font-size:18px;font-family:comic sans MS;}
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
	<p><a href="logout.php">Logout</a></p><br>
</div>
<p id="intro2">Your Messages:<span>(unchecked will be automatically removed)</span><br></p>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</div>
</body>
</html>


