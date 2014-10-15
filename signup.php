<?php
ob_start();
session_start();
require 'connect.inc.php';
if (isset($_POST['user_name'])&&isset($_POST['pass'])&&isset($_POST['re_pass'])&&isset($_POST['address'])&&isset($_POST['email'])&&isset($_POST['mobile'])){
  $user_name = mysql_real_escape_string($_POST['user_name']);
  $pass = mysql_real_escape_string($_POST['pass']);
  $re_pass = mysql_real_escape_string($_POST['re_pass']);
  $address = mysql_real_escape_string($_POST['address']);
 
  $email = mysql_real_escape_string($_POST['email']);
  $mobile =  mysql_real_escape_string($_POST['mobile']);
  $pass_hatch = md5($pass);
  $user_name_ln = strlen($user_name);
  $pass_ln = strlen($pass);
  $re_pass_ln = strlen($re_pass);
  $address_ln = strlen($address);

  $email_ln = strlen($email);
  $mobile_ln = strlen($mobile);
  $pos = strpos($email,"@");
  $gender = strtolower($_POST['gender']);
  if (!empty($user_name)&&!empty($pass)&&!empty($re_pass)&&!empty($address)&&!empty($email)&&!empty($mobile)&&!empty($gender)){
    if($user_name_ln<26&&$pass_ln<31&&$re_pass_ln<31&&$address_ln<31&&$email_ln<41 && $mobile_ln <= 10)
    {
  	  if($email_ln>10&&!empty($pos)){
  		  if($pass==$re_pass){
  			$query = "SELECT `uid` FROM `USER` WHERE `name`='$user_name' OR `email` = '$email'";
  			$query_run = @mysql_query($query);
  			$query_row = @mysql_num_rows($query_run);
  			if($query_row==0){
  			  $query1 = "INSERT INTO `USER` VALUES('','$user_name','$address','$email','$mobile','$pass_hatch','$gender')";
                           /* $rand = rand(1000,5000);
                            $rand_hatch = md5($rand);
                            $_SESSION['hatch'] = $rand_hatch;
                            $query2 = "INSERT INTO `registration` VALUES('$user_name','$rand_hatch')";
                            $query_run2 = @mysql_query($query2);*/
  			  if($query_run1 = @mysql_query($query1))
  			  	echo '';
  			  else
  			  echo '<p id="error">*Registration Failed. Please try again.</p>';
  			}else
  			echo '<p id="error">*Username or Email already exists.</p>';
  		  }else
  		  echo '<p id="error">*Passwords don`t match.</p>';
  	  }else
  	  echo '<p id="error">*Please enter a valid email address.</p>';
    }else
    echo '<p id="error">*Dude you messed up with the code.</p>';
  } else
  echo '<p id="error">*Please fill in all details.</p>';
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
      <meta charset=utf-8 />
      <title>Carpool System</title>
      <style type="text/css">
             * {padding:0px;margin:0px;}
             body {margin-left:auto;margin-right:auto;width:80%;margin-top:auto;margin-bottom:auto;height:650px;border:5px solid blue;}
             #reg1 {position:absolute;top:150px;left:615px;height:100px;width:450px;text-align:left;padding:40px;font-size:18px;}
             #reg2 {position:absolute;top:195px;left:620px;height:100px;width:450px;text-align:right;padding:40px;font-size:18px;}
             a {text-decoration:none;}
	a:visited {color:blue;}
	#gap {height:15px;background-color:brown;width:100%;}
             span {font-size:10px;}
	#goto {height:320px;width:260px;text-align:center;padding:40px;padding-top:80px;border-right:2px solid black;margin-top:20px;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
             #me {color:white;text-decoration:none;}
	#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
             #error {position:absolute;top:15px;left:840px;color:red;width:250px;font-size:18px;text-align:center;}
      </style>
</head>
<body>
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="goto">
	<a href="index.php">Home</a><br><br>
</div>
<div id="reg1">
<p style="font-size:20px;"}>Registration Form:</p><br>
Username:<span>(upto 25 characters.)</span><br><br>
Password:<span>(more than 8 characters.)</span><br><br>
Re-type Password:<br><br>
Address:<span>(upto 30 characters.)</span><br><br>
Email-id:<span>(upto 40 characters.)</span><br><br>
Mobile No. :<span>(10 or 11 digits)</span><br><br>
Gender:<br><br>
</div>
<div id="reg2">
<form action="signup.php" method="POST">
<input type="text" name="user_name" maxlength="25"><br><br>
<input type="password" name="pass" maxlength="30"><br><br>
<input type="password" name="re_pass" maxlength="30"><br><br>
<input type="text" name="address" maxlength="30"><br><br>
<input type="text" name="email" maxlength="40"><br><br>
<input type="text" name="mobile" maxlength="10"><br><br>
<input type="text" name="gender" maxlength="6"><br><br>
<input type="submit" value="Register">
</form><br>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</body>
</html>		
