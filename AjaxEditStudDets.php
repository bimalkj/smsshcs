<?php
	include 'dbconnect.php';
	session_start();
	$sid=$_SESSION['sid'];
	$id=$_REQUEST['id'];
	$regs_no=$_REQUEST['regs_no'];
	$form_no=$_REQUEST['form_no'];
	$stud_name=$_REQUEST['stud_name'];
	$gender=$_REQUEST['gender'];
	$guar_name=$_REQUEST['guar_name'];
	$contact_no=$_REQUEST['cont_no'];
	$dob=$_REQUEST['dob'];	
	$cate_id=$_REQUEST['cate_name'];
if($_REQUEST['oper']=='edit'){		
	$qry="update stud_dets set form_no='$form_no',stud_name='$stud_name',gender='$gender',guar_name='$guar_name',contact_no='$contact_no',cate_id=$cate_id,dob='".$dob."'";
	$qry.=" where regs_no=$regs_no and s_id=".$_SESSION['sid']."";
	mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
}
else if($_REQUEST['oper']=='del'){
	$qry="delete from stud_dets where regs_no=".$id." and s_id=".$sid."";
	mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
}
?>