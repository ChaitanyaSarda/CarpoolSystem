<?php
	ob_start();
	session_start();
	require 'connect.inc.php';
	if(!empty($_SESSION['user_id'])){
			$rid = $_SESSION['rid'];
			$q = "delete from `REQUEST_TABLE` where `rid` = '$rid'";
			if(($qr = mysql_query($q))){
					header('Location:Vehicle_Search.php');
			}			
	}
	else
		header('Location:index.php');
?>
