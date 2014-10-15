<?php
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id'])){
	if (isset($_POST['vehicle_type'])&&isset($_POST['year_of_pur'])&&isset($_POST['model'])&&isset($_POST['make'])&&isset($_POST['sitting_capacity'])&&isset($_POST['is_owned'])&&isset($_POST['driver_type'])){
	$vehicle_type = mysql_real_escape_string($_POST['vehicle_type']);
	$year_of_pur = mysql_real_escape_string($_POST['year_of_pur']);
	$model = mysql_real_escape_string($_POST['model']);
	$make = mysql_real_escape_string($_POST['make']);
	$sitting_capacity = mysql_real_escape_string($_POST['sitting_capacity']);
	$driver_name = mysql_real_escape_string($_POST['driver_name']);
	$license_number =  mysql_real_escape_string($_POST['license_number']);
	$ta_name = mysql_real_escape_string($_POST['ta_name']);
	$ta_address = mysql_real_escape_string($_POST['ta_address']);
	$date_license =mysql_real_escape_string($_POST['date_license']);
	$is_owned = $_POST['is_owned'];
	$driver_type = $_POST['driver_type'];
	 $myVar = $_SESSION['user_id'];
	 $myName = $_SESSION['name'];
	 if (!empty($vehicle_type)&&!empty($year_of_pur)&&!empty($model)&&!empty($make)&&!empty($sitting_capacity)&&!empty($is_owned)&&!empty($driver_type)){    
	 if( $is_owned == "yes")
		{
			if($driver_type == "hired")
				$query1 = "INSERT INTO `VEHICLE` VALUES('','$vehicle_type','$myVar','$year_of_pur','$model','$make','$sitting_capacity','1','$driver_name','$license_number','','','$driver_type','$date_license')";
			else
				$query1 = "INSERT INTO `VEHICLE` VALUES('','$vehicle_type','$myVar','$year_of_pur','$model','$make','$sitting_capacity','1','$myName','$license_number','','','$driver_type','$date_license')";
		}	
	else
			$query1 = "INSERT INTO `VEHICLE` VALUES('','$vehicle_type','$myVar','$year_of_pur','$model','$make','$sitting_capacity','0','$driver_name','$license_number','$ta_name','$ta_address','$driver_type','$date_license')";
		
		if($query_run = @mysql_query($query1))
			 echo '<script>
					alert("Data Added to the System");
				</script>';
			 else
			 echo '<p id="error">*Registration Failed. Please try again.</p>';
	 }
	else
		echo '<p id="error">*Please fill in all details.</p>';
	}
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
            * {padding:0px;margin:0px;}
            body {margin-left:auto;margin-right:auto;width:80%;margin-top:auto;margin-bottom:auto;height:650px;border:5px solid blue;}
            #reg1 {position:absolute;top:115px;left:615px;height:100px;width:450px;text-align:left;padding:40px;font-size:13px;}
            #reg2 {position:absolute;top:150px;left:580px;height:100px;width:450px;text-align:right;padding:40px;font-size:11px;}
            a {text-decoration:none;}
	a:visited {color:blue;}
#gap {height:15px;background-color:brown;width:100%;}
            span {font-size:10px;}
#goto {height:320px;width:260px;text-align:center;padding:40px;padding-top:80px;border-right:2px solid black;margin-top:20px;}
h1 {color:grey;text-align:left;font-size:50px;font-family:jokerman;padding-left:40px;height:90px;padding-top:30px;width:96.5%;background-color:blue;}
            #me {color:white;text-decoration:none;}
#footer {position:absolute;top:625px;left:430px;color:black;font-size:17px;text-align:center;}
            #error {position:absolute;top:160px;left:840px;color:red;width:250px;font-size:18px;text-align:center;}
     </style>
</head>
<body>
<h1>Carpool System</h1>
<p id="gap"></p>
<div id="goto">
	<a href="index.php">Home</a><br><br>
	<a href="sharepage.php">Share the vehicle</a><br><br>
	<a href="logout.php">Logout</a>
</div>
<div id="reg1">
<p style="font-size:20px;"}>Vehicle Registration Form:</p><br>
Vehicle Type: <br><br>
Year of Purchase<br><br>
Made By:<br><br>
Model:<br><br>
Sitting Capacity:<br><br>
Ownership:<br><br> 
Driver type:<br><br>                                                
Driver Name<span>(if hired)</span>:<br><br>
License Number:<br><br>
Travel Agency Name<span>(if not owned)</span>:<br><br>
Travel Agency Address <span>(if not owned)</span>:<br><br>

Date of expiry of License:<br><br>
</div>
<div id="reg2">
<form action="VehicleRegistration.php" method="POST">
<p></p><input type="text" name="vehicle_type" maxlength="25"><br><br>
<p></p><input type="text" name="year_of_pur" maxlength="30"><br><br>

<p></p><input type="text" name="make" maxlength="30"><br><br>
<p></p><input type="text" name="model" maxlength="30"><br><br>
<p></p><input type="text" name="sitting_capacity" maxlength="30" ><br><br>
<p>
 <input type="radio" name="is_owned" value="yes">Is Owned
 <input type="radio" name="is_owned" value="no">Not Owned
 </p><br>
 <p>
 <input type="radio" name="driver_type" value="self">Self
 <input type="radio" name="driver_type" value="hired">Hired
 </p>
<p></p><input type="text" name="driver_name" maxlength="25"><br><br>
<p></p><input type="text" name="license_number" maxlength="30"><br><br>

<p></p><input type="text" name="ta_name" maxlength="30"><br><br>
<p></p><input type="text" name="ta_address" maxlength="30"><br><br>

<p></p><input type="date" name="date_license" maxlength="30" ><br><br>


<input type="submit" value="Register Vehicle">
</form><br>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</body>
</html> 
