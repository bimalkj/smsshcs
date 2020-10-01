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
$qry="select count(*) from stud_dets where cate_id=".$_REQUEST['cate_id']." and s_id=".$_SESSION['sid']." and status='Yes' or status='WL' order by gender,nseq";
$rslt=mysql_query($qry);
$row=mysql_fetch_row($rslt);
$count=$row[0];
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

// be sure to put text data in CDATA


header("Content-type: text/xml;charset=utf-8");

$s =  "<?xml version='1.0' encoding='utf-8'?>";
$s .= "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
$qry="select * from stud_dets where cate_id=".$_REQUEST['cate_id']." and s_id=".$_SESSION['sid'];
if(isset($_REQUEST['final']))
$qry.=" and status='Yes' or status='WL' order by gender,nseq";
else
$qry.=" order by nseq";
$rslt=mysql_query($qry);
while($row=mysql_fetch_array($rslt))
{
	$s .= "<row id='". $row['regs_no']."'>";
	$s .= "<cell>". $row['regs_no']."</cell>";
	$s .= "<cell>". $row['stud_name']."(".$row['gender'][0].")"."</cell>";
	$s .= "<cell>". $row['oseq']."</cell>";
	$s .= "<cell>". $row['nseq']."</cell>";
	$s .= "<cell>". $row['status']."</cell>";
	$s .= "<cell>". $row['color_code']."</cell>";
	$s .= "</row>";

}
$s .= "</rows>";
echo $s;
?>