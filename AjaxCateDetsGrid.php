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

$QRY="select count(*) from cate_dets where s_id=".$_SESSION['sid']."";
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
$start = $limit*$page - $limit;
  
// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page

// the actual query for the grid data
$SQL="select * from cate_dets where s_id=".$_SESSION['sid']."";
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
	$s .= "<row id='". $row['cate_id']."'>";
	$s .= "<cell>". $row['cate_id']."</cell>";
	$s .= "<cell>". $row['cate_name']."</cell>";
	$s .= "<cell>". $row['cate_desc']."</cell>";
	$s .= "<cell>". $row['resrv']."</cell>";
	$s .= "<cell>". $row['tot_wait_lst']."</cell>";
	$s .= "<cell>". $row['ratio']."</cell>";
	$s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>