<?php
include 'dbconnect.php';
	session_start();	
	
	$sid=$_REQUEST['sid'];
	
	$sql="SELECT dob_start,dob_end FROM settings WHERE s_id=".$sid."";
	$res=mysql_query($sql) or die("Errror In Query ".$sql.mysql_error()." Path=".$_SERVER['PHP_SELF']);
	$dob=mysql_fetch_array($res);
	
	
	
	$qry="SELECT stud_dets.*,DATEDIFF('".$dob[0]."',dob) uage,DATEDIFF(dob,'".$dob[1]."') oage FROM stud_dets WHERE s_id=".$sid." AND dob < '".$dob[0]."' OR  dob > '".$dob[1]."'";	
	$rs=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	
	while($row=mysql_fetch_array($rs)){
	  if($row['uage']>0){
	  $reason='Under age by '.$row['uage'].' days';
	  $qry="delete from stud_dets where s_id=".$sid." and regs_no=".$row[8]."";	 	  
	  mysql_query($qry) or die("Error In Query ".$qry.mysql_error()." Path=".$_SERVER['PHP_SELF']);	
	  $sql ="INSERT INTO stud_reject_forms(form_no,stud_name,dob,gender,cate_id,guar_name,contact_no,s_id,regs_no,nseq,color_code,`status`,oseq,reason_reject)";
	  $sql .=" VALUES('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."','".$row[7]."','".$row[8]."','".$row[9]."','".$row[10]."','".$row[11]."','".$row[12]."','".$reason."')";
	  // die($sql);  
	  mysql_query($sql) or die("Errror In Query ".$sql.mysql_error()." Path=".$_SERVER['PHP_SELF']);
	  }	  
	  else if($row['oage']>0){
	  $reason='Over age by '.$row['oage'].' days';
	  $qry="delete from stud_dets where s_id=".$sid." and regs_no=".$row[8]."";	 	  
	  mysql_query($qry) or die("Error In Query ".$qry.mysql_error()." Path=".$_SERVER['PHP_SELF']);	
	  $sql ="INSERT INTO stud_reject_forms(form_no,stud_name,dob,gender,cate_id,guar_name,contact_no,s_id,regs_no,nseq,color_code,`status`,oseq,reason_reject)";
	  $sql .=" VALUES('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."','".$row[7]."','".$row[8]."','".$row[9]."','".$row[10]."','".$row[11]."','".$row[12]."','".$reason."')";
	  // die($sql);  
	  mysql_query($sql) or die("Errror In Query ".$sql.mysql_error()." Path=".$_SERVER['PHP_SELF']);
	  }
	
	  
	}
	
	echo " <div class='ui-widget'>";
	echo " <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
	echo " <p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>";
	echo " <strong>Information:  Rejected Successfully. $sid</strong></p>";
	echo " </div>";
	echo " </div>";
	
?>