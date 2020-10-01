<?php
session_start();
include 'dbconnect.php';

  // Get the requested page. By default grid sets this to 1. 
$page = $_GET['page'];

// get how many rows we want to have into the grid - rowNum parameter in the grid 
$limit = $_GET['rows'];

// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel 
$sidx = $_GET['sidx'];
 
// sorting order - at first time sortorder 
$sord = $_GET['sord']; 

// if we not pass at first time index use the first column for the index or what you want
if(!$sidx) $sidx =1;

$QRY="select count(*) from stud_dets where s_id=".$_SESSION['sid']."";
if(isset($_REQUEST['cate_id']))
$QRY.=" and cate_id=".$_REQUEST['cate_id']."";
$RSLT=mysql_query($QRY) or die("Qry=".$QRY." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
$ROW=mysql_fetch_row($RSLT);
$count=$ROW[0];

if( $count > 0) {
              $total_pages = ceil($count/$limit);
} else {
              $total_pages = 0;
}
 
// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages) $page=$total_pages;
 
// calculate the starting position of the rows
$cate_id=$_REQUEST['cate_id'];
$start = $limit*$page - $limit;
  $update_qry="update stud_dets s,";
  $update_qry.="(select @rownum:=@rownum+1 osq, stud_dets.regs_no from stud_dets, (SELECT @rownum:=0) r where s_id=".$_SESSION['sid']." and cate_id=$cate_id order by stud_dets.regs_no) m ";
  $update_qry.="set color_code=mod(m.osq-1,41),oseq=m.osq ";
  $update_qry.="where s.regs_no=m.regs_no";
  mysql_query($update_qry);
// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
$start=0;
// the actual query for the grid data
$SQL="select @rownum:=@rownum+1 rank, stud_dets.* from stud_dets, (SELECT @rownum:=0) r where s_id=".$_SESSION['sid']."";
if(isset($_REQUEST['cate_id']))
$SQL.=" and cate_id=".$_REQUEST['cate_id'];
$SQL.=" ORDER BY $sidx $sord LIMIT $start,$limit";
$result=mysql_query($SQL) or die("query=".$SQL." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=utf-8");

$s =  "<?xml version='1.0' encoding='utf-8'?>";
$s .= "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
// be sure to put text data in CDATA
while($row = mysql_fetch_array($result,MYSQL_BOTH)) 
{
	
	if(empty($row['stud_name']))
	continue;
	
	$cate_name=mysql_fetch_row(mysql_query("select cate_name from cate_dets where cate_id=".$row['cate_id'].""));
	$s .= "<row id='". $row['regs_no']."'>";
	$s .= "<cell>". $row['stud_name']."</cell>";
	$s .= "<cell>". $row['regs_no']."</cell>";
	$s .= "<cell>". $row['rank']."</cell>";
	$s .= "<cell>". $row['color_code']."</cell>";
	$s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>