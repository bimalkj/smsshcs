<?php
	include 'dbconnect.php';
	session_start();
	$value="";
	$rslt=mysql_query("select cate_id,cate_name from cate_dets where s_id=".$_SESSION['sid']);
	while($row=mysql_fetch_row($rslt))
	{
		$value=$value.$row[0].":".$row[1].";";
	}
	$len=strlen($value);
	echo substr($value,0,$len-1);
?>