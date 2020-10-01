<?php
	include 'dbconnect.php';
	session_start();
	
	$cate_name=$_REQUEST['cate_name'];
	$desc=str_replace("."," ",$_REQUEST['desc']);
	$resrv=$_REQUEST['resrv'];
	$tot_wait_lst=$_REQUEST['tot_wait_lst'];
	$s_id=$_SESSION['sid'];
	$ratio=$_REQUEST['ratio'];
	
	$qry="insert into cate_dets(cate_name,cate_desc,resrv,s_id,tot_wait_lst,ratio)";
	$qry.=" values('$cate_name','$desc','$resrv',$s_id,$tot_wait_lst,'$ratio')";
	mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	
	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Alert: Category has been added successfully.</strong></p>";
	echo " </div>";
	echo " </div>";
?>