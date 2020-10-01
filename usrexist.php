<?php
	session_start();
	include 'dbconnect.php';
	
	$usrname=$_REQUEST['usrname'];
	
	$qry="select * from members_det where usrname='$usrname'";
	$rslt=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	$num=mysql_num_rows($rslt);
	if($num==0)
		$exist=false;
	else
		$exist=true;
	echo $exist;
?>