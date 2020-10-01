<?php
	include 'dbconnect.php';
	session_start();
	
	$form_no=$_REQUEST['form_no'];
	$stud_name=str_replace("."," ",$_REQUEST['stud_name']);
	$gender=$_REQUEST['gender'];
	$cate_id=$_REQUEST['cate_id'];
	$guar_name=str_replace("."," ",$_REQUEST['guar_name']);
	$contact_no=$_REQUEST['contact_no'];
	$reason_reject=$_REQUEST['reason_reject'];
	$dob=$_REQUEST['dob'];
	$dob=date('Y-m-d',strtotime($dob));
	$sid=$_SESSION['sid'];
	
	$qry="insert into stud_reject_forms(form_no,stud_name,dob,gender,cate_id,guar_name,contact_no,s_id,reason_reject)";
	$qry.=" values('$form_no','$stud_name','$dob','$gender',$cate_id,'$guar_name','$contact_no',$sid,'$reason_reject')";
	mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	
	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Alert: Student has been added successfully.</strong></p>";
	echo " </div>";
	echo " </div>";
?>