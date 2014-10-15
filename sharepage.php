<?php
ob_start();
session_start();
require 'connect.inc.php';

if (isset($_POST['source'])&&isset($_POST['destination'])&&isset($_POST['cost'])&&isset($_POST['no_copass'])&&isset($_POST['vehicle_ty'])&& isset($_POST['travel_date']) 
&& isset($_POST['start_time']) && isset($_POST['reach_time']) && isset($_POST['gender_pref']) && isset($_POST['is_daily']) && isset($_POST['age_pref_min'])
&& isset($_POST['age_pref_max']))
{
$source = mysql_real_escape_string($_POST['source']);
$source = strtolower($source);
$destination = mysql_real_escape_string($_POST['destination']);
$destination = strtolower($destination);
$cost = mysql_real_escape_string($_POST['cost']);
$no_copass = mysql_real_escape_string($_POST['no_copass']);
$vehicle_id = mysql_real_escape_string($_POST['vehicle_ty']);
$travel_dt = mysql_real_escape_string($_POST['travel_date']);
$start_time = mysql_real_escape_string($_POST['start_time']);
$reach_time = mysql_real_escape_string($_POST['reach_time']);
$gender_pref = mysql_real_escape_string($_POST['gender_pref']);
$is_daily = mysql_real_escape_string($_POST['is_daily']);
$age_pref_min = mysql_real_escape_string($_POST['age_pref_min']);
$age_pref_max = mysql_real_escape_string($_POST['age_pref_max']);
$usersID = $_SESSION['user_id'];
if (!empty($source)&&!empty($destination)&&!empty($cost)&&!empty($no_copass)&&!empty($vehicle_id)&&!empty($travel_dt)&&!empty($start_time)
&&!empty($reach_time)&&!empty($gender_pref)&&!empty($is_daily) && !empty($age_pref_max)&&!empty($age_pref_min))
{
if($reach_time > $start_time)
{	
if($is_daily == "no")
{
$query1 = "INSERT INTO `SHARING_INFORMATION` (`sid`, `uid`, `sharing_cost`, `allowable_passenger`,`remaining_cap`,
`source`, `destination`, `start_time`, `reaching_time`, `gender_preference`, `age_preference_min`,
`age_preference_max`, `vid`, `is_available_daily`, `date_of_travel`) 
VALUES (NULL, '$usersID', '$cost', '$no_copass', '$no_copass', '$source', '$destination', '$start_time', '$reach_time',
'$gender_pref', '$age_pref_min', '$age_pref_max', '$vehicle_id', '0', '$travel_dt')";

if($query_run1 = @mysql_query($query1)){
echo '<script>
alert("Data Added to the System");
</script>';
}
else
echo '<p id="error">*Registration Failed. Please try again.</p>';
}
else if($is_daily == "yes")
{

$currentDate = @date("Y-m-d");
$i = 0;
for($i = 0;$i <10;$i++)
{
list($y,$m,$d)=explode('-',$currentDate);
$currentDate = @Date("Y-m-d", mktime(0,0,0,$m,$d+1,$y));
//$currentDate->modify('+1 day');
$query1 = "INSERT INTO `SHARING_INFORMATION` (`sid`, `uid`, `sharing_cost`, `allowable_passenger`,`remaining_cap`,
`source`, `destination`, `start_time`, `reaching_time`, `gender_preference`, `age_preference_min`,
`age_preference_max`, `vid`, `is_available_daily`, `date_of_travel`) 
VALUES (NULL, '$usersID', '$cost', '$no_copass', '$no_copass', '$source', '$destination', '$start_time', '$reach_time',
'$gender_pref', '$age_pref_min', '$age_pref_max', '$vehicle_id', '1', '$currentDate')";

if($query_run1 = @mysql_query($query1))
{
}
else
echo '<p id="error">*Registration Failed. Please try again.</p>';
}	
}
}
else
echo '<p id="error">*Reaching time cannot be less than the starting time</p>';
} 
else
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
            #reg1 {position:absolute;top:140px;left:615px;height:100px;width:450px;text-align:left;padding:40px;font-size:15px;}
            #reg2 {position:absolute;top:180px;left:560px;height:100px;width:450px;text-align:right;padding:40px;font-size:11px;}
            a {text-decoration:none;}
	a:visited {color:blue;}
#gap {height:15px;background-color:brown;width:100%;}
            span {font-size:8px;}
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
<p id="goto">Go to <a href="loggedin.php">Home!</a><br><br>
<a href="VehicleRegistration.php">Register New Vehicle</a><br><br>
<a href="logout.php">Logout</a></p>
<div id="reg1">
<p style="font-size:20px;"}>Offer A Share:</p><br>
Select Vehicle:<br><br>
Source:<br><br>
Destination:<br><br>
Sharing cost/KM:<br><br>
No. of co-passengers:<br><br>
Date of Travel:<br><br>
Start Time:<br>
Reaching Time:<br><br>
Gender Preference:<br><br>
Age Preference:<br><br>
Daily Basis:<br><br>
</div>
<div id="reg2">
<form action="sharepage.php" method="POST">
<?php
$userId = $_SESSION['user_id'];
$flag = 0;
   $sql=mysql_query("SELECT `vid`,`vehicle_type` FROM VEHICLE WHERE `uid` = '$userId' "); 
if(mysql_num_rows($sql)){ 
$select= '<select name="vehicle_ty">';  
while($rs=mysql_fetch_array($sql)){ 
if($rs['vid'])
{
$flag = 1;
}
$select.='<option value="'.$rs['vid'].'">'.$rs['vehicle_type'].'</option>'; 
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
<input type="text" name="source" maxlength="30"><br><br>
<input type="text" name="destination" maxlength="30"><br><br>
<input type="text" name="cost" maxlength="30"><br><br>
<input type="text" name="no_copass" maxlength="30"><br><br>
<input type="date" name="travel_date"><br><br>
<input type="time" name="start_time"><br>
<input type="time" name="reach_time"><br><br>
<select name="gender_pref">
<option value ="male">Male</option>
<option value ="female">Female</option>
<option value ="both">Both</option>
</select><br><br>
<input type="text" name="age_pref_min" style="width:30px;">
-
<input type="text" name="age_pref_max" style="width:30px;"><br><br>
<select name="is_daily">
<option value ="no">No</option>
<option value ="yes">Yes</option>
</select><br><br>
<input type="submit" value="OFFER">
</form><br>
</div>
<p id="footer">Copyright 2014@CARPOOL SYSTEM. Designed and Developed </p>
</body>
</html>	
