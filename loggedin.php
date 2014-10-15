<?php
ob_start();
session_start();
if(!empty($_SESSION['user_id'])){
  $name = $_SESSION['name'];
  echo '<p id="intro2">Welcome, <strong>'.$name.'</strong></p>';

}
else
header('Location:index.php');
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
	#r2 {position:absolute;top:300px;left:660px;height:100px;width:450px;text-align:left;padding:40px;font-size:18px;}
	#nw {color:red;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
	#error {position:absolute;top:5px;left:840px;color:red;width:250px;font-size:18px;text-align:center;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:240px;left:700px;color:black;width:430px;font-size:20px;font-family:comic sans MS;}
</style>
</head>
<body>
<div id="wrapper">
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="r1">
	<p><a href="VehicleRegistration.php">Register a Vehicle</a></p><br>
	<p><a href="sharepage.php">Offer a Sharing Vehicle</a></p><br>
	<p><a href="Vehicle_Search.php">Find a sharing vehicle</a></p><br>
	<p><a href="viewmessage.php">Recieved Request Messages</a></p><br>
	<p><a href="req_status.php">Check Request Status</a></p><br>
	<p><a href="yourshares.php">Your Shares</a></p><br>
	<p><a href="book_history.php">Booking History</a></p><br>
	<p><a href="logout.php">Logout</a></p><br>
</div>
<p id="r2">
	To change the various details of your account:<br><br>
	<a href="pass_change.php">Change Profile Password</a><br><br>
	<a href="change_email.php">Change Mobile No.</a>
</p>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</div>
</body>
</html>
