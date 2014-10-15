<?php
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id'])){
	$name = $_SESSION['name'];
	echo '<p id="intro2">Change your password, <strong>'.$name.'</strong>:</p>';
	if(isset($_POST['email_id'])&&isset($_POST['re_email'])){
		if(!empty($_POST['email_id'])&&!empty($_POST['re_email'])){
	  $email= mysql_real_escape_string($_POST['email_id']);
	  $re_email = mysql_real_escape_string($_POST['re_email']);
		  if($email == $re_email){
			  $temp = $_SESSION['user_id'];
			  echo $temp;
			  $re_email = md5($email);
			$query = "UPDATE `USER` SET `password`='$re_email' WHERE `uid`='$temp'";
			if($query_run = mysql_query($query))
				header('Location:loggedin.php');
			else
				echo '<p id="error">*Process Failed. Please try again.</p>';
		  }
		else
			echo '<p id="error">*Password do not match.</p>';
	}
	else
		echo '<p id="error">*Please fill in all details.</p>';
	}else
		echo ''; 
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
             #reg1 {position:absolute;top:265px;left:655px;height:100px;width:450px;text-align:left;padding:40px;font-size:18px;}
             #reg2 {position:absolute;top:265px;left:620px;height:100px;width:450px;text-align:right;padding:40px;font-size:18px;}
	#nw {color:red;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
	#error {position:absolute;top:275px;left:900px;color:red;width:250px;font-size:18px;text-align:center;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:235px;left:700px;color:black;width:430px;font-size:20px;font-family:comic sans MS;}
      </style>
</head>
<body>
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="r1">
<a href="index.php">Home</a><br><br>
<a href="logout.php">Logout</a>
</div>
<div id="reg1">
Type Password:<br><br>
Re-type Password:<br><br><br><br><br>
<p >By clicking on 'Reset Password',your account password will be changed.</p>
</div>
<div id="reg2">
<form action="pass_change.php" method="POST">
<input type="password" name="email_id"><br><br>
<input type="password" name="re_email"><br><br>
<input type="submit" value="Reset Password">
</form><br><br>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</body>
</html>
