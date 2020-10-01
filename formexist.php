<?php
	session_start();
	include 'dbconnect.php';
	
	$form_no=$_REQUEST['form_no'];
	
	$qry="select * from stud_dets where form_no='$form_no'";
	$rslt=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	$num=mysql_num_rows($rslt);
	if($num==0)
		$exist='false';
	else
		$exist='true';
	echo $exist;
?>