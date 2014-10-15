<?php
require 'connect.inc.php';
if(isset($_POST['email_id'])&&!empty($_POST['email_id'])){
  $email= mysql_real_escape_string($_POST['email_id']);
  $query = "SELECT `uid` FROM `USERS` WHERE `email`='$email'";
  $query_run = @mysql_query($query);
  $query_row = @mysql_num_rows($query_run);
  if($query_row==1){
    $id = mysql_result($query_run,0,'uid');
    $new_password = rand(100000,999999);
    $subject = 'New Password.';
    $body = 'Your New Password is '.$new_password;
    $headers = 'From: noreply@divanshu.hostzi.com';
    if(@mail($email,$subject,$body,$headers)){
      $pass_h = md5($new_password);
      $query = "UPDATE `USERS` SET `password`='$pass_h' WHERE `uid`='$id'";
      if($query_run = @mysql_query($query))
      header('Location:reset_pass.php');
      else
      echo '<p id="error">*Process Failed. Please try again.</p>';
    }else
     echo '<p id="error">*Process Failed. Please try again.</p>';
  }else
  echo '<p id="error">*Email address provided is Incorrect. Please resubmit the address.</p>';
}


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
	#error {position:absolute;top:5px;left:840px;color:red;width:250px;font-size:18px;text-align:center;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:240px;left:700px;color:black;width:430px;font-size:20px;font-family:comic sans MS;}
      </style>
</head>
<body>
<h1><span style="color:white">C</span>arpool <span style="color:white">S</span>ystem</h1>
<p id="gap"></p>
<div id="r1">
<a href="index.php">Home</a><br><br>
<a href="signup.php">New User Registration</a>
</div>
<div id="r2">
<form action="pass_forgot.php" method="POST">
Your email address:<input type="text" name="email_id"><br>
<input type="submit" value="Reset Password">
</form><br><br>
<p >By clicking on 'Reset Password',your account password will be changed and will be sent to your email address provided.</p>
</div>
<p id="intro2">Reset Password</p>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</body>
</html>
