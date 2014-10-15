<?php
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id'])){
		if(isset($_POST['results'])){
				$sid = $_POST['results'];
				$rid = $_SESSION['rid'];
				$uid = $_SESSION['user_id'];
				$exploded = explode("-",$sid);
				$q = "select `uid` from `SHARING_INFORMATION` where `sid` = '$exploded[0]'";
				$qr = mysql_query($q);
				$sharer_id = mysql_result($qr,0,'uid');
				$q = "insert into `REQUESTMESSAGE` values ('','$uid','$sharer_id','$exploded[0]','$rid','0','0')";
				$qr = mysql_query($q);
				$q = "select `uid` from `SHARING_INFORMATION` where `sid` = '$exploded[1]'";
				$qr = mysql_query($q);
				$sharer_id = mysql_result($qr,0,'uid');
				$q = "insert into `REQUESTMESSAGE` values ('','$uid','$sharer_id','$exploded[1]','$rid','0','0')";
				$qr = mysql_query($q);
				header('Location:Vehicle_Search.php');
		}
		else header('Location:discard_req.php');
}
else header('Location:index.php');
?>
rid

