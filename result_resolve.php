<?php
ob_start();
session_start();
require 'connect.inc.php';
if(!empty($_SESSION['user_id'])){
		if(isset($_POST['results'])){
				$mids = $_POST['results'];
				//$user_id = $_SESSION['rid'];
				$count = count($mids);
				$uid = $_SESSION['user_id'];
				echo $count;
				for($i = 0;$i<$count;$i++){
						echo $mids[$i];
						$mid = $mids[$i];					
						$q = "UPDATE  `REQUESTMESSAGE` SET  `accepted` =  '1' WHERE  `mid` ='$mid' ";
						$qr = mysql_query($q);
						$q1 = "SELECT `sharingtable_id`,`request_table_id`,`requester_id` FROM `REQUESTMESSAGE` WHERE `mid` = '$mid' ";
						$qr1 = mysql_query($q1);
						$sid = mysql_result($qr1,0,'sharingtable_id');
						$rid = mysql_result($qr1,0,'request_table_id');
						$requester_id = mysql_result($qr1,0,'requester_id');
						$q2 = "SELECT * FROM `SHARING_INFORMATION` WHERE `sid` = '$sid'" ;
						$qr2 = mysql_query($q2);
						$sharing_cost = mysql_result($qr2,0,'sharing_cost');
						$allowable_passenger = mysql_result($qr2,0,'allowable_passenger');
						$remaining_cap = mysql_result($qr2,0,'remaining_cap');
						$vid = mysql_result($qr2,0,'vid');
						$source = mysql_result($qr2,0,'source');
						$destination = mysql_result($qr2,0,'destination');
						$start_time = mysql_result($qr2,0,'start_time');
						$reaching_time = mysql_result($qr2,0,'reaching_time');
						$is_available_daily = mysql_result($qr2,0,'is_available_daily');
						$date_of_travel = mysql_result($qr2,0,'date_of_travel');
						
						$remaining_cap = $remaining_cap - 1;
						$sharing_cost = $sharing_cost * $remaining_cap / $allowable_passenger;
						
						if($remaining_cap == 0 && $is_available_daily == 1) //handling if available daily and remaining cap is 0 for a single day
						{
							$q4 = "UPDATE `SHARING_INFORMATION` SET `is_available_daily` = '0' WHERE `uid` = '$uid', `vid` = '$vid' ,`source` = '$source' ,`destination` = '$destination' , `start_time` = '$start_time' , `reaching_time` = '$reaching_time'" ; 
							$qr4 = mysql_query($q4);
						}
						
						$q5 = "SELECT `is_daily` FROM `REQUEST_TABLE` WHERE `rid` = '$rid' ";
						$qr5 = mysql_query($q5);
						$is_daily = mysql_result($qr5,0,'is_daily');
						if($is_daily == 1)			//handling if the requester requests for daily basis
						{		
							$q6 = "UPDATE  `SHARING_INFORMATION` SET `remaining_cap` =  '$remaining_cap' , `sharing_cost` = '$sharing_cost'  WHERE `uid` = '$uid', `vid` = '$vid' ,`source` = '$source' ,`destination` = '$destination' , `start_time` = '$start_time' , `reaching_time` = '$reaching_time' ";
							$qr6 = mysql_query($q6);
							$q8 = "INSERT INTO `BOOKING` (`id`, `rq_id`, `sh_id`, `date`, `source`, `destination`, `is_daily`, `cost`, `starttime`, `reachtime`) VALUES (NULL, '$requester_id', '$uid', '', '$source', '$destination', '1', '$sharing_cost', '$start_time', '$reaching_time')";
							$qr8 = mysql_query($q8);
						}
						else
						{
							$q3 = "UPDATE  `SHARING_INFORMATION` SET `remaining_cap` =  '$remaining_cap' , `sharing_cost` = '$sharing_cost'  WHERE `sid` = '$sid' ";
							$qr3 = mysql_query($q3);
							$q7 = "INSERT INTO `BOOKING` (`id`, `rq_id`, `sh_id`, `date`, `source`, `destination`, `is_daily`, `cost`, `starttime`, `reachtime`) VALUES (NULL, '$requester_id', '$uid', '$date_of_travel', '$source', '$destination', '0', '$sharing_cost', '$start_time', '$reaching_time')";
							$qr7 = mysql_query($q7);
						}
				}
				header('Location:index.php');
		}
		//else header('Location:discard_req.php');
}
else header('Location:index.php');
?>
rid
