<?php
	include 'dbconnect.php';
	session_start();
	if(!isset($_SESSION['usrname']))
	{
		header("location:index.php");
		exit;
	}
	$usrname=$_SESSION['usrname'];
	
	if(isset($_REQUEST['btn_change']))
	{
		$psw=$_REQUEST['txt_psw'];
		$npsw=$_REQUEST['txt_npsw'];
		$cpsw=$_REQUEST['txt_cpsw'];
		$psw=md5($psw);
		$row=mysql_fetch_row(mysql_query("select psw from members_det where psw='$psw' and usrname='$usrname'"));
		if(is_null($row[0])) $msg="Password is wrong";
		else
		{
			$psw_patt='/^[a-zA-Z0-9@._-]{1,20}$/';
		    if(!preg_match($psw_patt,$npsw)) $msg="Password may contain only a-z,A-Z,0-9 or @";
			else if($npsw==$cpsw)
			{
				$npsw=md5($npsw);
				mysql_query("update members_det set psw='$npsw' where usrname='$usrname'");
				$msg="Password changed successfully";
			}
			else $msg="Password not matched";
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
	  $(document).ready(function() 
	  {
	    $( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
	    $("input:submit").button();
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		
		
			
		
		var tot_seat = $( "#txt_tot_seat" ),
		    logo = $("#txt_logo"),
			allFields = $( [] ).add( tot_seat ).add( logo ),
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
				
			  if ( bValid ) 
			  {
				var source='AjaxAddSettings.php?tot_seat='+tot_seat.val()+'&logo='+logo+'';
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
		<td rowspan="2">
		  <div class="arrowsidemenu">
			<?php include 'main_menu.php'; ?>
		  </div>		</td>
		<td rowspan="2">&nbsp;</td>
		<td></td>
	  </tr>
	  <tr>
		<td align="center">
		<br /><br />
		  <div id="effect" class="ui-widget-content ui-corner-all" align="center">
				<h3 class="ui-widget-header ui-corner-all">Change password</h3><br />
			    <form name="form1" action="" method="post">
				  <table border="0">
                    <tr>
                      <td align="right"><label>Current Password:</label> </td>
                      <td align="left">
                      <input type="password" name="txt_psw" id="txt_psw" class="ui-widget-content ui-corner-all" />
                      </td>
                    </tr>
                    <tr>
                      <td align="right"><label>New Password:</label> </td>
                      <td align="left">
                        <input type="password" name="txt_npsw" id="txt_npsw" class="ui-widget-content ui-corner-all" />
                     </td>
                    </tr>
                    <tr>
                      <td align="right"><label>Confirm Password:</label> </td>
                      <td align="left">
                        <input type="password" name="txt_cpsw" id="txt_cpsw" class="ui-widget-content ui-corner-all" />
                      </td>
                    </tr>
					<tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right"><input name="btn_change" type="submit" value="Submit" /></td>
                    </tr>
                  </table>
			    </form>
		  </div>
		  <br />
		  <?php
		  	if(isset($msg))
			{
		  ?>
		  <div id="alert" align="left">
			  <div class='ui-widget'>
				  <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>
					  <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>
					  <strong>Alert: <?php echo $msg; ?></strong></p>
				  </div>
			  </div>
		  </div>		
		  <?php
		  	}
		  ?>
		</td>
	  </tr>
	</table>
  </body>
</html>