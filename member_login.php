<?php
  include 'dbconnect.php';
  session_start();
  ini_set('display_errors',1);
	
  $usrname=$_REQUEST["txt_usrname"];
  $psw=$_REQUEST["txt_psw"];
  $usrname=mysql_real_escape_string($usrname);  
  $psw=mysql_real_escape_string($psw);
  
  $usrname_patt='/^[a-zA-Z0-9._-]{1,50}$/';
  if(!preg_match($usrname_patt,$usrname))
  {
	$msg="Invalid User name or password";
	header("location:index.php?msg=$msg");
	exit;
  }
		 
  $psw_patt='/^[a-zA-Z0-9@._-]{1,20}$/';
  if(!preg_match($psw_patt,$psw))
  {
	$msg="Invalid Id or password";
	header("location:index.php?msg=$msg");
	exit;
  }
	
  $psw=md5($psw);
  $qry="select rid,s_id,logo_path,max_shuffle from members_det where usrname='$usrname' and psw='$psw'";
  $rslt=mysql_query($qry) or die("Error in select qry=".$qry);
  $count=mysql_num_rows($rslt);
			
  if($count>0)
  {
	$row=mysql_fetch_array($rslt,MYSQL_BOTH);
	$_SESSION['sid']=$row['s_id'];
	$_SESSION['rid']=$row['rid'];
	$_SESSION['logo']=$row['logo_path'];
	$_SESSION['max_shuffle']=$row['max_shuffle'];
	$_SESSION['usrname']=$usrname;
	header("location:welcome_page.php");
	exit;
  }
  else
  {
	$msg="Invalid Id or password";
	header("location:index.php?msg=$msg");
	exit;
  }
?>