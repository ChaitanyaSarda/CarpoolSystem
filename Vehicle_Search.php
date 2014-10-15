<?php
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id'])){
	if (isset($_POST['pick'])&&isset($_POST['dest'])&&isset($_POST['day'])&&isset($_POST['pref'])&&isset($_POST['vtype'])&&isset($_POST['cost'])){
	  $pick = mysql_real_escape_string($_POST['pick']);
	  $pick = strtolower($pick);
	  $dest = mysql_real_escape_string($_POST['dest']);
	  $dest = strtolower($dest);
	  $day = mysql_real_escape_string($_POST['day']);
	  $pref = mysql_real_escape_string($_POST['pref']);
	  $vtype = mysql_real_escape_string($_POST['vtype']);
	  $cost =  mysql_real_escape_string($_POST['cost']);
	  if (!empty($pick)&&!empty($dest)&&!empty($day)&&!empty($pref)&&!empty($vtype)&&!empty($cost)){    
		  if(!empty($pos)){
				$query = "SELECT `uid` FROM `USER` WHERE `name`='$pick' OR `vtype` = '$vtype' OR `costNo` = '$cost' ";
				$query_run = @mysql_query($query);
				$query_row = @mysql_num_rows($query_run);  			
			  }  		 
		  else
			echo '<p id="error">*Please enter a valid vtype pref.</p>';    
	  } else
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
             #reg1 {position:absolute;top:155px;left:615px;height:100px;width:450px;text-align:left;padding:40px;font-size:15px;}
             #reg2 {position:absolute;top:195px;left:580px;height:100px;width:450px;text-align:right;padding:40px;font-size:13px;}
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
	<a href="VehicleRegistration.php">Vehicle Registration</a><br><br>
	<a href="logout.php">Logout</a><br><br>
	
</div>
<div id="reg1">
<p style="font-size:20px;">Search Vehicle:</p><br>
Picking Point:<br><br>
Destination Point:<br><br>
Vehicle Preference:<span>(Owner/Hire)</span><br><br>
Need it daily:<span>(if yes than day will be ignored)</span><br><br>
Day:<span>(Date)</span><br><br>
Vehicle Type:<span>(model)</span><br><br>
Maximum Affordable Cost :<br><br>
</div>
<div id="reg2">
<form action="result_retrieve.php" method="POST">
<input type="text" name=" pick" maxlength="25"><br><br>
<input type="text" name=" dest" maxlength="30"><br><br>
<select name="pref">
<option value="owner">Owner</option>
<option value="hired">Hired</option>
</select><br><br>
<input type="radio" name="req" value="yes">Yes
<input type="radio" name="req" value="no">No<br><br>
<input type="date" name="day" maxlength="30"><br><br>
<?php
	$userId = $_SESSION['user_id'];
	$flag = 0;
    $sql=mysql_query("SELECT `vehicle_type` FROM VEHICLE ");
	if(mysql_num_rows($sql) != 0){ 
		$select= '<select name="vehicle_ty">';  
		while($rs=mysql_fetch_array($sql)){ 
		
			if($rs['vehicle_type'])
			{
				$flag = 1;
			}
			$select.='<option value="'.$rs['vehicle_type'].'">'.$rs['vehicle_type'].'</option>'; 
		} 
	} 
	if($flag == 1)
	{
		$select.='</select><br><br>';
		echo $select;
	}
	else 
	{
		echo 'No Registered Vehicle';
		echo '<br><br>';
	}

?>
<input type="text" name="cost" maxlength="11" ><br><br>
<input type="submit" value="Find Shares">
</form><br>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</body>
</html>		
