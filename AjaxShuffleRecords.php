<?php
	include 'dbconnect.php';
	session_start();
	
	$cate_id=$_REQUEST['cate_id'];
	$qry="select stud_dets.* from stud_dets where cate_id=$cate_id and s_id=".$_SESSION['sid']."";
	$rslt=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	$i=0;
	while($row=mysql_fetch_array($rslt,MYSQL_BOTH))
	{
		$regs_no[$i]=$row['regs_no'];
		$oseq[$i]=$row['oseq'];
		$i++;
	}
	if($_REQUEST['shuffle']=="yes") shuffle($oseq);

	$qry="select regs_no from stud_dets where cate_id=$cate_id and s_id=".$_SESSION['sid']."";
	$rslt=mysql_query($qry);
	$i=0;
	while($row=mysql_fetch_row($rslt))
	{
		mysql_query("update stud_dets set nseq=$oseq[$i] where regs_no=$row[0]");
		$i++;
	}
	$count=count($regs_no);
	$i=0;
	$regs_no_arr="";
	while($i<$count)
	{
	  $regs_no_arr=$regs_no_arr.$regs_no[$i].",";
	  $i++;
	}
	
	$qry="select * from cate_dets where cate_id=$cate_id and s_id=".$_SESSION['sid']."";
	$status=mysql_fetch_array(mysql_query($qry));
	$ratio=$status['ratio'];
	if($status['tot_seats']==0)
	{
		$tot_seat=mysql_fetch_array(mysql_query("select seats_left from settings where s_id=".$_SESSION['sid'].""),MYSQL_BOTH);
		$row=mysql_fetch_array(mysql_query("select * from cate_dets where cate_id=$cate_id and s_id=".$_SESSION['sid'].""));
		$resrv=$row['resrv'];
		$tot_wait_lst=$row['tot_wait_lst'];
		
		$eligible=$tot_seat[0]*($resrv/100);
		$eligible=(int)$eligible;
		mysql_query("update settings set seats_left=seats_left-$eligible where s_id=".$_SESSION['sid']."");
		mysql_query("update cate_dets set tot_seats=$eligible where s_id=".$_SESSION['sid']." and cate_id=$cate_id");
	}
	else
	{
		$eligible=$status['tot_seats'];
		$tot_wait_lst=$status['tot_wait_lst'];
	}

if($_REQUEST['shuffle']=="yes")
{
    mysql_query("update stud_dets set status='No' where cate_id=$cate_id and s_id=".$_SESSION['sid']) or die(mysql_error());
    $ratio_arr=explode(":",$ratio);
	$sor=$ratio_arr[0]+$ratio_arr[1];
	$tot_girls=($eligible/$sor)*$ratio_arr[0];
	$tot_girls=(int)$tot_girls;
	$tot_boys=($eligible/$sor)*$ratio_arr[1];
	$tot_boys=(int)$tot_boys;
	if(($tot_boys+$tot_girls)<$eligible)
	{
	  if($ratio_arr[0]<$ratio_arr[1]) $tot_boys=$tot_boys+($eligible-($tot_boys+$tot_girls));
	  else if($ratio_arr[0]>$ratio_arr[1]) $tot_girls=$tot_girls+($eligible-($tot_boys+$tot_girls));
	}
	
	$bcounter=0;
	$gcounter=0;
	$boys=array(0);
	$boys_wl=array();
	$girls=array();
	$girls_wl=array();
	$result=mysql_query("select gender,regs_no from stud_dets where cate_id=$cate_id and s_id='".$_SESSION['sid']."' order by nseq");
	while($row=mysql_fetch_array($result))
	{
	  if($row[0]=="Male")
	  {
	  	if($bcounter<$tot_boys) array_push($boys,$row['regs_no']);
		else if($bcounter<($tot_wait_lst+$tot_boys)) array_push($boys_wl,$row['regs_no']);
		$bcounter++;
	  }
	  else if($row[0]=="Female")
	  {
	  	if($gcounter<$tot_girls) array_push($girls,$row['regs_no']);
		else if($gcounter<($tot_wait_lst+$tot_girls)) array_push($girls_wl,$row['regs_no']);
		$gcounter++;
	  }
	}

	$slist=implode(",",$boys).",".implode(",",$girls);
	$wlist=implode(",",$boys_wl).",".implode(",",$girls_wl);
	mysql_query("update stud_dets set status='Yes' where regs_no in ($slist)");
	mysql_query("update stud_dets set status='WL' where regs_no in ($wlist)");
}
?>
