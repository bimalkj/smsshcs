<?php
	include 'dbconnect.php';
	session_start();
	
	$usr_name=$_REQUEST['usrname'];
	$s_name=$_REQUEST['s_name'];
	$loc=$_REQUEST['loc'];
	$contact_no=$_REQUEST['cont_no'];
	$email_id=$_REQUEST['email_id'];
	$max_shuffle=$_REQUEST['max_shuffle'];
	
	/*$row=mysql_fetch_array(mysql_query("select * from members_det where usrname='$usr_name'"));
	
	if($max_shuffle==$row['max_shuffle']) $shuffle_left=$row['shuffle_left'];
	else if($max_shuffle>$row['max_shuffle'])
	{
	 $shuffle_left=$max_shuffle-$row['max_shuffle'];
	 $shuffle_left=$shuffle_left+$row['shuffle_left'];
	}
	else */

		
	$qry="update members_det set s_name='$s_name',loc='$loc',contact_no='$contact_no',email_id='$email_id',max_shuffle=$max_shuffle";
	$qry.=" where usrname='$usr_name'";
	mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
?>