<?php
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id']))
header('Location:loggedin.php');
else{
  if(isset($_POST['user_name'])&&isset($_POST['user_pass'])) {
    $user_name = mysql_real_escape_string($_POST['user_name']);
    $user_pass = mysql_real_escape_string($_POST['user_pass']);
    if(!empty($user_name)&&!empty($user_pass)) {
      $query = "SELECT `uid`, `name` FROM `USER` WHERE `name` = '$user_name' AND `password` = '".md5($user_pass)."'";
      $query_run = @mysql_query($query);
      $query_row = @mysql_num_rows($query_run);
      if ($query_row==1) {
        $first_name = mysql_result($query_run,0,'name');
        $_SESSION['name'] = $first_name;
        $_SESSION['user_id'] = mysql_result($query_run,0,'uid');
        header('Location:loggedin.php');
      }else
      echo '<p id="error">*Username or password does not match</p>';
    } else
    echo '<p id="error">*Please fill in all fields</p>';
  }
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
	#r2 {position:absolute;top:300px;left:655px;height:100px;width:320px;text-align:center;padding:40px;font-size:20px;}
	#nw {color:red;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
	#error {position:absolute;top:200px;left:250px;color:red;width:250px;font-size:18px;text-align:center;}
	#me {color:white;text-decoration:none;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
	#intro2 {position:absolute;top:230px;left:650px;color:black;width:430px;font-size:18px;font-family:comic sans MS;}
</style>
</head>
<body>
<div id="wrapper">
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="r1">
	<p style="font-size:20px;">Login:</p><br><br>
	<form action="index.php" method="POST">
		Enter Username: <br><input type= "text" name="user_name" maxlength="25"><br><br>
		Enter Password: <br><input type= "password" name="user_pass" maxlength="30"><br><br>
		<input type="submit" value="Login!">
	</form>
	<br>
	<p><a href="pass_forgot.php">Forget Password!</a></p>
</div>
<div id="r2">
	<p id="nw">New user <a href="signup.php">SIGN UP</a></p>
</div>
<p id="intro2">If you are a New user, become a member just by filling a simple form. For this go to SIGN UP link!</p>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</div>
</body>
</html>
