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
	$cate_id=$_REQUEST['cate_name'];
	$dob=$_REQUEST['dob'];
	$reason_reject =$_REQUEST['reason_reject'];
	if($_REQUEST['oper']=='edit'){		
		$qry="update stud_reject_forms set";
		$qry.=" form_no='$form_no',stud_name='$stud_name',gender='$gender',guar_name='$guar_name',contact_no='$contact_no',cate_id=$cate_id,dob='".$dob."',";
		$qry.="reason_reject='$reason_reject' where regs_no=$regs_no and s_id=".$_SESSION['sid'];
		mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	}
	else if($_REQUEST['oper']=='del'){
		$qry="select * from stud_reject_forms where regs_no=".$id." and s_id=".$sid."";
		$rs=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
		$row=mysql_fetch_row($rs);
		mysql_query($qry) or die("Error In Query ".$qry.mysql_error()." Path=".$_SERVER['PHP_SELF']);	  
		$sql ="INSERT INTO stud_dets(form_no,stud_name,dob,gender,cate_id,guar_name,contact_no,s_id,regs_no,nseq,color_code,`status`,oseq)";
		$sql .=" VALUES('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."','".$row[7]."','".$row[8]."','".$row[9]."','".$row[10]."','".$row[11]."','".$row[12]."')";	  
		//die($sql);
		mysql_query($sql) or die("Errror In Query ".$sql.mysql_error()." Path=".$_SERVER['PHP_SELF']);
	  	$query="delete from stud_reject_forms where regs_no=".$id." and s_id=".$sid."";
		mysql_query($query) or die("Qry=".$query." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	}
?>