<?php
	include 'dbconnect.php';
	session_start();
	if(!isset($_SESSION['usrname']))
	{
		header("location:index.php");
		exit;
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>ADMISSION MODULE</title>
	<link rel="stylesheet" type="text/css" media="screen" href="css/form.css" />
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/ddaccordion.js"></script>
	<script type="text/javascript" src="js/main_menu.js"></script>
	<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/demos.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/redmond/jquery-ui-1.8.14.custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
	<script language="javascript">
		/*$(document).ready(function(){
			$("#list").jqGrid({
				url:'ajax_welcome_table.php',
				datatype: 'XML',
				mtype:'GET',
				colNames:['Catergory','Total Seats','Total Accepted Forms','Total Rejected Forms','Selected','Waiting List','Not Selected'],
				colModel:[
							{name:'cate_id',index:'cate_id',align:'left',width:100},
							{name:'tot_seat',index:'tot_seat',align:'left',width:85},
							{name:'tot_accept_forms',index:'tot_accept_forms',align:'left',width:150},
							{name:'tot_reject_forms',index:'tot_reject_forms',align:'left',width:150},
							{name:'slctd',index:'slctd',align:'left',width:100},
							{name:'wl',index:'wl',align:'left',width:100},
							{name:'nslctd',index:'nslctd',align:'left',width:100}
						 ],
				pager:'#list_pager',
				rowNum:100,
				rowList:[10,20,100],
				loadonce:false,
				gridview:false,
				viewrecords:true,
				caption:'Categories Details'
			});
			jQuery("#list").navGrid('#list_pager',{view:true,edit:false,add:false,del:false},{},{},{},{multipleSearch:true});
		});*/
	</script>
    <style type="text/css">
	#th_bold {
	font-weight: bold;
	font-size:14px;
	color:#fff;
	background-color:#0086C6;
	text-align: center;
	height: 14px;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 10px;
	}
	
	#td_01 {
		align:center;
		padding: 2px;
		height: 14px;
		background-color:#CCC;
		font-size:13px;
		text-align:center;
	}
	
	#td_02 {

		padding: 2px;
		height: 14px;
		background-color:#EAEAEA;
		font-size:13px;
		text-align:center;
	}
	</style>
  </head>
  <body background="<?php echo "images/".$_SESSION['logo'];?>">
    <table cellpadding="0" cellspacing="0" width="90%">
    <tr height="80px">
	  <td colspan="2"><center><h2 class="my_header">Welcome To School Admission System</h2></center></td>
    </tr>
    <tr>
	  <td>
          <div class="arrowsidemenu"><?php include 'main_menu.php'; ?></div>			
	      <input type="hidden" name="hdn_rid" id="hdn_rid" value="<?php echo $_SESSION['rid']; ?>" />	  </td>
      <td>
	  		<!--<table id="list"></table>
			<div id="list_pager"></div>-->
        <table width="60%" border="1"  bordercolor="#CCCCCC" cellspacing="0">
	          <tr>
	            <th rowspan="2" nowrap id="th_bold">Category</th>
	            <th colspan="3" nowrap id="th_bold">Total Seats</th>
	            <th align="center" rowspan="2" nowrap id="th_bold">Accepted<br />&nbsp;Forms</th>
	            <th rowspan="2" nowrap id="th_bold">Rejected<br />&nbsp;Forms</th>
	            <th colspan="3" nowrap id="th_bold">Selected</th>
	            <th colspan="3" nowrap id="th_bold">Waiting List</th>
	            <th colspan="3" nowrap id="th_bold">Not Selected</th>
          </tr>
	          <tr>
	          
	            <td id="th_bold">T</td>
	            <td id="th_bold">M</td>
	            <td id="th_bold">F</td>
	            <td id="th_bold">T</td>
	            <td id="th_bold">M</td>
	            <td id="th_bold">F</td>
	            <td id="th_bold">T</td>
	            <td id="th_bold">M</td>
	            <td id="th_bold">F</td>
	            <td id="th_bold">T</td>
	            <td id="th_bold">M</td>
	            <td id="th_bold">F</td>
             </tr>
             <?php
			 $sid=$_SESSION['sid'];
             mysql_query("create temporary table temp_summary SELECT cate_id,gender,STATUS,count(*) cnt FROM stud_dets WHERE s_id=$sid GROUP BY cate_id,gender,status");

			$SQL = "SELECT cate_id,cate_name,tot_seats,ratio FROM cate_dets where s_id=$sid"; 
			$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
			$counter=0;
			$total_seats=0;
			$total_accep_forms=0;
			$total_rej_forms=0;
			$total_sel=0;
			$totla_wl=0;
			$total_not_sel=0;
			
			while($row = mysql_fetch_row($result)) 
			{
			  $tot_forms=mysql_fetch_row(mysql_query("select count(*) from stud_dets where cate_id=$row[0] and s_id=".$_SESSION['sid']));
			  $tot_reject=mysql_fetch_row(mysql_query("select count(*) from stud_reject_forms where cate_id=$row[0] and s_id=".$_SESSION['sid']));
				  
			  $rslt=mysql_query("select * from temp_summary where cate_id=$row[0]");
				  $msel=0;$fsel=0;$fwl=0;$mwl=0;$fns=0;$mns=0;
				  while($rows=mysql_fetch_array($rslt,MYSQL_BOTH))
				  {
					  if($rows[1]=="Female")
					  {
						  if($rows[2]=="Yes") $fsel=$rows[3];
						  else if($rows[2]=="WL") $fwl=$rows[3];
						  else $fns=$rows[3];
					  }
					  else
					  {
						  if($rows[2]=="Yes") $msel=$rows[3];
						  else if($rows[2]=="WL") $mwl=$rows[3];
						  else $mns=$rows[3];
					  }
				  }
		  
				  $rarr=explode(":",$row[3]);
				  $den=$rarr[0]+$rarr[1];
				  $girls=round(($row[2]/$den)*$rarr[0]);
				  $boys=round(($row[2]/$den)*$rarr[1]);
				  
				  if($counter%2==0) $id="td_02";
				  else $id="td_01";
			  ?>
	          <tr>
	            <td id="<?php echo $id; ?>"><?php echo $row[1]; ?></td>
	            <td id="<?php echo $id; ?>"><?php echo $row[2]; ?></td>
	            <td id="<?php echo $id; ?>"><?php echo $boys; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $girls; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $tot_forms[0]; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $tot_reject[0]; ?></td>
                <td id="<?php echo $id; ?>"><?php echo ($fsel+$msel); ?></td>
                <td id="<?php echo $id; ?>"><?php echo $msel; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $fsel; ?></td>
                <td id="<?php echo $id; ?>"><?php echo ($fwl+$mwl); ?></td>
                <td id="<?php echo $id; ?>"><?php echo $mwl; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $fwl; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $fns+$mns; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $mns; ?></td>
                <td id="<?php echo $id; ?>"><?php echo $fns; ?></td>
             </tr>
             <?php
			 
			 $counter++;
			 $total_seats=$total_seats+$row[2];
			 //$total_seats=$total_seats+$fsel+$msel;
			 $total_accep_forms=$total_accep_forms+$tot_forms[0];
			 $total_rej_forms=$total_rej_forms+$tot_reject[0];
			 $total_sel=$total_sel+$fsel+$msel;
			 $totla_wl=$totla_wl+$fwl+$mwl;
			 $total_not_sel=$total_not_sel+$fns+$mns;
			 
			 }
			 ?>
	          <tr>
	            <th id="th_bold">Total</th>
	            <th colspan="3" id="th_bold"><?php echo $total_seats;?></th>
	            <th id="th_bold"><?php echo $total_accep_forms;?></th>
	            <th id="th_bold"><?php echo $total_rej_forms;?></th>
	            <th colspan="3" id="th_bold"><?php echo $total_sel;?></th>
	            <th colspan="3" id="th_bold"><?php echo $totla_wl;?></th>
	            <th colspan="3" id="th_bold"><?php echo $total_not_sel;?></th>
          </tr>
      </table></td>
    </tr>
    </table>
  </body>
</html>