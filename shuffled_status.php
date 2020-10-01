<?php
	include 'dbconnect.php';
	session_start();
	
	$cate_id=$_REQUEST['cate_id'];	
    $qry="select * from cate_dets where s_id=".$_SESSION['sid']." and cate_id=$cate_id";
	$row=mysql_fetch_array(mysql_query($qry));

	if($row['shuffle_count']==$_SESSION['max_shuffle'])
		echo "no,".$row['shuffle_count'];
	else
	{
		$row['shuffle_count']=$row['shuffle_count']+1;
		mysql_query("update cate_dets set shuffle_count=shuffle_count+1 where cate_id=$cate_id and s_id=".$_SESSION['sid']."");
		echo "yes,".$row['shuffle_count'];
	}
?>