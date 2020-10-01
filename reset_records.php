<?php
	include 'dbconnect.php';
	session_start();
	
	$usrname=$_REQUEST['usrname'];
	$s_id=mysql_fetch_row(mysql_query("select s_id from members_det where usrname='$usrname'"));
	mysql_query("update cate_dets set shuffle_count=0,tot_seats=0 where s_id=$s_id[0]");
	mysql_query("update settings set seats_left=tot_seat where s_id=$s_id[0]");
	mysql_query("update stud_dets set nseq=0,color_code='',status='No',oseq=0 where s_id=$s_id[0]");
	
	
	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Alert:Reset successfully</strong></p>";
	echo " </div>";
	echo " </div>";
?>