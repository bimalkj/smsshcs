<?php
	include 'dbconnect.php';
	session_start();
	
	$max_shuffle=$_REQUEST['max_shuffle'];
	$sid=$_SESSION['sid'];
	
	$qry="update settings set tot_seat=$tot_seat,seats_left=".$row['seats_left']." where s_id=$sid";
	mysql_query($qry) or die(mysql_error()." Path=".$_SERVER['PHP_SELF']);
	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Alert: Settings saved successfully.</strong></p>";
	echo " </div>";
	echo " </div>";
?>