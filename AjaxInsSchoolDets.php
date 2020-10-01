<?php
	include 'dbconnect.php';
	session_start();
	
	$usr_name=$_REQUEST['usrname'];
	$psw=$_REQUEST['psw'];
	$psw=md5($psw);
	$s_name=str_replace("."," ",$_REQUEST['s_name']);
	$loc=str_replace("."," ",$_REQUEST['loc']);
	$contact_no=$_REQUEST['contact_no'];
	$email_id=$_REQUEST['email_id'];
	$max_shuffle=$_REQUEST['max_shuffle'];
	
	$qry="insert into members_det(usrname,psw,rid,s_name,loc,contact_no,email_id,max_shuffle)";
	$qry.=" values('$usr_name','$psw',2,'$s_name','$loc','$contact_no','$email_id',$max_shuffle)";
	mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	
	$s_id=mysql_fetch_row(mysql_query("select s_id from members_det where usrname='$usr_name'"));
	mysql_query("insert into settings(s_id) values($s_id[0])");
	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Alert: School has been added successfully.</strong></p>";
	echo " </div>";
	echo " </div>";
?>