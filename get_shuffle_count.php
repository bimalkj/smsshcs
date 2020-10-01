<?php
	include 'dbconnect.php';
	session_start();
	
	$cate_id=$_REQUEST['cate_id'];
	$row=mysql_fetch_row(mysql_query("select shuffle_count from cate_dets where s_id=".$_SESSION['sid']." and cate_id=$cate_id"));
	echo $row[0];
?>