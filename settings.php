 <?php
	include 'dbconnect.php';
	session_start();
	if(!isset($_SESSION['usrname']))
	{
		header("location:index.php");
		exit;
	}
	
	if(isset($_REQUEST['btn_edit']))
	{
		$sid=$_SESSION['sid'];
		$tot_seat=$_REQUEST['txt_tot_seat'];
		$dob1=$_REQUEST['txt_dob1'];
		
		if($dob1!='')
		$dob1=date('Y-m-d',strtotime($dob1));
		$dob2=$_REQUEST['txt_dob2'];
		if($dob2!='')
		$dob2=date('Y-m-d',strtotime($dob2));
		
		$row=mysql_fetch_array(mysql_query("select * from settings where s_id=$sid"));
		$AddToLeft=$tot_seat-$row['tot_seat'];
		$row['seats_left']=$row['seats_left']+$AddToLeft;
		
		if($tot_seat!='' && $dob1=='' && $dob2=='')
		$qry="update settings set tot_seat=$tot_seat,seats_left=".$row['seats_left']." where s_id=$sid";	
		else if($tot_seat!='' && $dob1!='' && $dob2!='')
		$qry="update settings set tot_seat=$tot_seat,dob_start='".$dob1."',dob_end='".$dob2."',seats_left=".$row['seats_left']." where s_id=$sid";	
		else if($tot_seat=='' && $dob1!='' && $dob2!='')
		$qry="update settings set dob_start='".$dob1."',dob_end='".$dob2."',seats_left=".$row['seats_left']." where s_id=$sid";	
		
		//die($qry);
			
		mysql_query($qry) or die(mysql_error()." Path=".$_SERVER['PHP_SELF']);
	}
	if(isset($_REQUEST['btn_upload']))
	{		
		if(isset($_FILES["txt_logo"]["name"]))
		{
			if($_FILES["txt_logo"]["error"]>0)
				$msg="File size is too big";
			else
			{
				$_FILES["txt_logo"]["name"]=$_SESSION['sid'].$_FILES["txt_logo"]["name"];
				
				/*if($_FILES["txt_logo"]["type"]=="image/jpeg")
				{*/
					$target="images/";
					$target=$target.basename($_FILES["txt_logo"]["name"]);
					if(move_uploaded_file($_FILES["txt_logo"]["tmp_name"],$target))
					{
						$name=$_FILES["txt_logo"]["name"];
						$sid=$_SESSION['sid'];
						$qry="update members_det set logo_path='$name' where s_id=$sid";
						mysql_query($qry) or die(mysql_error()." Path=".$_SERVER['PHP_SELF']);
					}
					else
						$msg="Error in Uploading";
				/*}
				else
					$msg="Only JPEG files can be uploaded";*/
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>ADMISSION MODULE</title>
	<link rel="stylesheet" type="text/css" media="screen" href="css/redmond/jquery-ui-1.8.14.custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/demos.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/form.css" />
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script src="js/jquery.ui.core.js" type="text/javascript"></script>
	<script src="js/jquery.ui.widget.js" type="text/javascript"></script>
	<script src="js/jquery.ui.button.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/ddaccordion.js"></script>
	<script type="text/javascript" src="js/main_menu.js"></script>
	<script language="javascript" src="js/jquery-ui-1.8.14.custom.js"></script>
	<script language="javascript" src="js/grid.formedit.js"></script>
	<script language="javascript" src="js/grid.common.js"></script>
	<script language="javascript" src="js/jqModal.js"></script>
	<script language="javascript" src="js/jqDnR.js"></script>
	<script language="javascript" src="js/jquery.form.js"></script>
	<script language="javascript" src="js/grid.inlinedit.js"></script>
	<script language="javascript" src="js/jquery.ui.sortable.js"></script>
    <script>
	$(function() {
		var d=new Date();
		var year=d.getFullYear();
		var Byear=year-50;

		$( "#datepicker" ).datepicker({
			constrainInput:false,
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy',
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true,
			maxDate: '0',
			yearRange: ''+Byear+':'+year+''
		});
	});
</script>
<script>
	$(function() {
		var d=new Date();
		var year=d.getFullYear();
		var Byear=year-50;

		$( "#datepicker1" ).datepicker({
			constrainInput:false,
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy',
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true,
			maxDate: '0',
			yearRange: ''+Byear+':'+year+''
		});
	});
</script>
	<script>
	  $(document).ready(function() 
	  {
	    $( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
	    $("input:submit").button();
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		var tot_seat = $( "#txt_tot_seat" ),
		    dob1=$("#datepicker"),
			dob2=$("#datepicker1"),
		    logo = $("#txt_logo"),
			allFields = $( [] ).add( tot_seat ).add( dob1 ).add( dob2 ).add( logo ),
			tips = $( ".validateTips" );
        
		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}

		function checkLength( o, n, min, max ) {
			
				if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Length of " + n + " must be between " +
					min + " and " + max + "." );
				return false;
			} else {
				return true;
			}
		}

		function checkRegexp( o, regexp, n ) {
			if ( !o.val().match(regexp))
			{
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}
				
		$( "#dialog-form" ).dialog(
		{
		  autoOpen: false,
		  height: 250,
		  width: 430,
		  modal: true,
		  resizable:false,
		  buttons: 
		  {
			"Add": function() 
			{
			  var bValid = true;
			  allFields.removeClass( "ui-state-error" );
			  
			  bValid = bValid && checkLength( tot_seat, "Total Seats", 1,10 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( tot_seat, /^[0-9]{1,10}$/, "Total Seat should be numeric(0-9)" );
			  
			  if( bValid )
			  bValid = bValid && checkRegexp( dob1,/^(0[0-9]|1[0-9]|2[0-9]|3[01])\-(0[1-9]|1[0-2])\-(19[0-9][0-9]|20[0-9][0-9])$/, "Date  format is dd-mm-yyyy");
			  
			  if( bValid )
			  bValid = bValid && checkRegexp( dob2,/^(0[0-9]|1[0-9]|2[0-9]|3[01])\-(0[1-9]|1[0-2])\-(19[0-9][0-9]|20[0-9][0-9])$/, "Date  format is dd-mm-yyyy");
				
			  if ( bValid ) 
			  {
				var source='AjaxAddSettings.php?tot_seat='+tot_seat.val()+'&dob1'+$("#datepicker").val()+'&dob2='+$("#datepicker1").val()+'&logo='+logo+'';				
				$("#alert").load(source);
				$( this ).dialog( "close" );
			  }
			},
			Cancel: function() 
			{
				$( this ).dialog( "close" );
			}
		  },
		  close: function() 
		  {
		    allFields.val( "" ).removeClass( "ui-state-error" );
		  }
		});
			
		$( "#btn_setting" ).button().click(function()
		{
		  $( "#dialog-form" ).dialog( "open" );
		});
	  });
	</script>
 </head>
 
   <body background="<?php echo "images/".$_SESSION['logo'];?>">
  
	    <table cellpadding="0" cellspacing="0" width="90%">
    <tr height="80px"><td colspan="3"><center><h2 class="my_header">Welcome To School Admission System</h2></center></td></tr>

	  <tr>
		<td width="16%" rowspan="2">
		  <div class="arrowsidemenu">
			<?php include 'main_menu.php'; ?>
		  </div>		</td>
		<td width="1%" rowspan="2">&nbsp;</td>
		<td width="83%"></td>
	  </tr>
	  <tr>
		<td align="center">
		  <br /><br />
		  <ul id="sortable">
		    <li class="ui-state-default">
			  <table border="1" cellspacing="0" cellpadding="0" width="80%">
				<tr>
				  <td ><label>Seats</label></td>
				  <?php
				  $rslt=mysql_query("select * from cate_dets where s_id=".$_SESSION['sid']." order by cate_id");
				  while($row=mysql_fetch_array($rslt))
				  {
				    echo "<td align='center' nowrap='nowrap'><label>Waiting List<br>";
				  	echo "(".$row['cate_name'].")";
					echo "</label></td>";
				  }
				  ?>
				  <td><label>Seats Left</label></td>
                  <td><label>Dob From</label></td>
                  <td><label>Dob To</label></td>
				</tr>
				<?php
					$row=mysql_fetch_array(mysql_query("select * from settings where s_id=".$_SESSION['sid'].""));
					
				?>
				<tr>
				  <td align="center"><label><?php echo $row['tot_seat']; ?></label></td>
<?php
				  $rslt=mysql_query("select * from cate_dets where s_id=".$_SESSION['sid']." order by cate_id");
				  while($rec=mysql_fetch_array($rslt))
				  {
				  	echo " <td align='left'><label>";
				  	echo "".$rec['tot_wait_lst']."";
					echo "</label></td>";
				  }
?>
				  <td align="center"><label><?php echo $row['seats_left']; ?></label></td>
                  <td><label><?php echo $row['dob_start']; ?></label></td>
                  <td><label><?php echo $row['dob_end']; ?></label></td>
				</tr>
			  </table>
			</li>
		  </ul>
		  <br />
		  <div id="effect" class="ui-widget-content ui-corner-all" align="center">
				<h3 class="ui-widget-header ui-corner-all">Preferences</h3><br />
			    <form name="form1" action="" method="post">
				  <table cellpadding="5" width="40%">
				  <tr>
					<td align="right" nowrap="nowrap"><label>Total Seats:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_tot_seat" id="txt_tot_seat" class="ui-widget-content ui-corner-all" value="<?php echo $row['tot_seat']; ?>" />					
					</td>
				  </tr>
                   <tr>
					<td align="right" nowrap="nowrap"><label>Date of birth From:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_dob1" id="datepicker" class="ui-widget-content ui-corner-all" value="<?php echo $row['dob_start']; ?>" />					
					</td>
				  </tr>
                   <tr>
					<td align="right" nowrap="nowrap"><label>to:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_dob2" id="datepicker1" class="ui-widget-content ui-corner-all" value="<?php echo $row['dob_end']; ?>" />					
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap">&nbsp;</td>
					<td align="right" nowrap="nowrap">
					  <input name="btn_edit" id="btn_edit" value="Submit" type="submit" />
					</td>
				  </tr>
			  </form>
			  <form name="form2" action="" method="post" enctype="multipart/form-data">
				  <tr>
					<td align="right" nowrap="nowrap"><label>Upload Logo:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="file" name="txt_logo" id="txt_logo" class="ui-widget-content ui-corner-all" value="" />					
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap">&nbsp;</td>
					<td align="right" nowrap="nowrap">
					  <input name="btn_upload" id="btn_upload" value="Submit" type="submit" />
					</td>
				  </tr>
			  </form>
		  </div>
		  <div id="alert"></div>		
		</td>
	  </tr>
	</table>
  </body>
</html>