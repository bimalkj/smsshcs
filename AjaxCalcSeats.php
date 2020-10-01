<?php
	include 'dbconnect.php';
	session_start();
	
	$cate_id=$_REQUEST['cate_id'];
	$status=mysql_fetch_array(mysql_query("select * from cate_dets where cate_id=".$_REQUEST['cate_id']." and s_id=".$_SESSION['sid'].""));
	if($status['tot_seats']==0)
	{
		$tot_seat=mysql_fetch_array(mysql_query("select seats_left from settings where s_id=".$_SESSION['sid'].""),MYSQL_BOTH);
		$row=mysql_fetch_array(mysql_query("select * from cate_dets where cate_id=$cate_id and s_id=".$_SESSION['sid'].""));
		$resrv=$row['resrv'];
		$tot_wait_lst=$row['tot_wait_lst'];
		
		$eligible=$tot_seat[0]*($resrv/100);
		$eligible=(int)$eligible;
	}
	else
	{
		$eligible=$status['tot_seats'];
		$tot_wait_lst=$status['tot_wait_lst'];
	}
	echo $eligible.",".$tot_wait_lst;
?>