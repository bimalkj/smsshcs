<?php
	include 'dbconnect.php';
	session_start();
	
	$tot_seat=$_REQUEST['tot_seat'];
	
	$dob1=$_REQUEST['dob1'];
	$dob1=date('Y-m-d',strtotime($dob1));
	$dob2=$_REQUEST['dob2'];;
	$dob2=date('Y-m-d',strtotime($dob2));
	$sid=$_SESSION['sid'];
	
	$sql="select * from settings where s_id=$sid";	
	$res=mysql_query($sql) or die("Error In Query ".$sql.mysql_error()."Path=".$_SERVER['PHP_SELF']);
	//$row=mysql_fetch_array(mysql_query("select * from settings where s_id=$sid"));
	$row=mysql_fetch_array($res);	
	$AddToLeft=$tot_seat-$row['tot_seat'];
	$row['seats_left']=$row['seats_left']+$AddToLeft;
	
	$qry="update settings set tot_seat=$tot_seat,dob_start='".$dob1."',dob_end='".$dob2."',seats_left=".$row['seats_left']." where s_id=$sid";
	
	mysql_query($qry) or die("Error In Query ".$qry.mysql_error()." Path=".$_SERVER['PHP_SELF']);
	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Alert: Settings saved successfully.</strong></p>";
	echo " </div>";
	echo " </div>";
?>