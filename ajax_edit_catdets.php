<?php
	include 'dbconnect.php';
	session_start();
	
	$cate_id=$_REQUEST['cate_id'];
	$cate_name=$_REQUEST['cate_name'];
	$desc=$_REQUEST['cate_desc'];
	$resrv=$_REQUEST['resrv'];
	$tot_wait_lst=$_REQUEST['tot_wait_lst'];
	$s_id=$_SESSION['sid'];
	$ratio=$_REQUEST['ratio'];
	
	$qry="update cate_dets set cate_name='$cate_name',cate_desc='$desc',resrv=$resrv,tot_wait_lst=$tot_wait_lst,ratio='$ratio'";
	$qry.=" where cate_id=$cate_id and s_id=$s_id";
	mysql_query("insert into testing(msg) values('$qry')");
	mysql_query($qry);
?>