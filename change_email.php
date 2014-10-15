<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id'])){
	$name = $_SESSION['name'];
	echo '<p id="intro2">Change your moblie no., <strong>'.$name.'</strong>:</p>';
if(isset($_POST['email_id'])){
	if(!empty($_POST['email_id'])){
  $email= mysql_real_escape_string($_POST['email_id']);
	$id = $_SESSION['user_id'];
      $query = "UPDATE `USER` SET `mobile_no`='$email' WHERE `uid`='$id'";
      if($query_run = mysql_query($query)){
      header('Location:loggedin.php');
    }else
     echo '<p id="error">*Process Failed. Please try again.</p>';
  }
  else
	echo '<p id="error">*Please give new mobile no.</p>';
}
}
else
	header('Location:index.php');

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
      <meta charset=utf-8>
      <title>Carpool System</title>
      <style type="text/css">
	*	{margin:0px;padding:0px;}
	body {margin-left:auto;margin-right:auto;width:80%;margin-top:auto;margin-bottom:auto;height:650px;border:5px solid blue;}
	#r1 {height:320px;width:260px;text-align:center;padding:40px;padding-top:80px;border-right:2px solid black;margin-top:20px;}
	#gap {height:15px;background-color:brown;width:100%;}
	a {text-decoration:none;}
	a:visited {color:blue;}
	#r2 {position:absolute;top:280px;left:660px;height:100px;width:380px;text-align:left;padding:40px;font-size:18px;}
	#nw {color:red;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
	#error {position:absolute;top:290px;left:760px;color:red;width:250px;font-size:18px;text-align:center;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:240px;left:700px;color:black;width:430px;font-size:20px;font-family:comic sans MS;}
      </style>
</head>
<body>
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="r1">
<a href="index.php">Home</a><br><br>
<a href="logout.php">Logout</a>
</div>
<div id="r2">
<form action="change_email.php" method="POST">
Your new No.:<input type="text" name="email_id"><br><br>
<input type="submit" value="Change">
</form><br><br>
<p >By clicking on 'Change',your mobile no. will be updated.</p>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</body>
</html>
