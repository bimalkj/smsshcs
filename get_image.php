<?php
	include 'dbconnect.php';
	session_start();
	
	$row=mysql_fetch_array(mysql_query("select * from members_det where s_id=".$_SESSION['sid'].""))
	if(!empty($row['logo_path']))
		echo $row['logo_path'];
	else
		echo "";
?>