<?php
include "dbconnect.php";
session_start();
$sid=$_SESSION['sid'];
$reason=$_REQUEST['reason'];
$regs_no=$_REQUEST['regs_no'];
$qry="SELECT * from stud_dets where s_id=".$sid." and regs_no=".$regs_no."";
$rs=$rs=mysql_query($qry) or die("Error In Query ".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
$row=mysql_fetch_row($rs);

$sql ="INSERT INTO stud_reject_forms(form_no,stud_name,dob,gender,cate_id,guar_name,contact_no,s_id,regs_no,nseq,color_code,`status`,oseq,reason_reject)";
$sql .=" VALUES('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."'";
$sql .=",'".$row[6]."','".$row[7]."','".$row[8]."','".$row[9]."','".$row[10]."','".$row[11]."','".$row[12]."','".$reason."')";

mysql_query($sql) or die("Errror In Query ".$sql.mysql_error()." Path=".$_SERVER['PHP_SELF']);

$query="delete from stud_dets where s_id=".$sid." and regs_no=".$regs_no."";
mysql_query($query) or die("Error In Query ".$query.mysql_error()." Path=".$_SERVER['PHP_SELF']);

	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Information: Student Rejected Successfully.</strong></p>";
	echo " </div>";
	echo " </div>";
	
?>
