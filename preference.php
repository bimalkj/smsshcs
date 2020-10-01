<?php
	include 'dbconnect.php';
	session_start();
	if(!isset($_SESSION['usrname']))
	{
		header("location:index.php");
		exit;
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
			
		var max_shuffle = $( "#txt_max_shuffle" ),
			allFields = $( [] ).add( max_shuffle ),
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
			  bValid = bValid && checkLength( max_shuffle, "Maximum Shuffle", 1,5 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( max_shuffle, /^[0-9]{1,5}$/, "'Maximum Shuffle' Option should be numeric(0-9)" );
				
			  if ( bValid ) 
			  {
				var source='AjaxAddPreference.php?=max_shuffle'+max_shuffle.val()+'';
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
	<style type="text/css">
		body{
			margin:0 auto;
			padding:0;
			font-family:Verdana, Arial, Helvetica, sans-serif;
		}
		
		#instruct{
			margin:0 auto;
		}
		
		td{
			vertical-align:top;
		}
		
		pre{
			font-family:Verdana, Arial, Helvetica, sans-serif;
			font-size:13px;
		}
		
		/* Main menu css */
		
		.arrowsidemenu{
		width: 180px; /*width of menu*/
		border-style: solid solid none solid;
		border-color:#0082BF;
		border-size: 1px;
		border-width: 1px;
		}
		
		.arrowsidemenu div a{ /*header bar links*/
			font: bold 12px Verdana, Arial, Helvetica, sans-serif;
			display: block;
			background: transparent url(images/arrowgreen.gif) 100% 0;
			height: 24px; /*Set to height of bg image-padding within link (ie: 32px - 4px - 4px)*/
			padding: 4px 0 4px 10px;
			line-height: 24px; /*Set line-height of bg image-padding within link (ie: 32px - 4px - 4px)*/
			text-decoration: none;
		}
			
		.arrowsidemenu div a:link, .arrowsidemenu div a:visited{
			color: #26370A;
		}
		
		.arrowsidemenu div a:hover{
			background-position: 100% -32px;
		}
		
		.arrowsidemenu div.unselected a{ /*header that's currently not selected*/
			color: #6F3700;
		}
		
			
		.arrowsidemenu div.selected a{ /*header that's currently selected*/
			color: orange;
			background-position: 100% -64px !important;
		}
		
		.arrowsidemenu ul{
			list-style-type: none;

			margin: 0;
			padding: 0;
		}
		
		.arrowsidemenu ul li{
			border-bottom: 1px solid  #006595;
		}
		
		
		.arrowsidemenu ul li a{ /*sub menu links*/
			display: block;
			font: normal 12px Verdana, Arial, Helvetica, sans-serif;
			text-decoration: none;
			color: black;
			padding: 5px 0;
			padding-left: 10px;
			border-left: 10px double #006595;
		}
		
		.arrowsidemenu ul li a:hover{
			background: url(images/background.bmp);
		}
	
		label{
			margin-left:30px;
		}
		
		#lbl_prg{
			font-size:12px;
			margin-left:-7px;
		}
		
		#lbl_batch{
			font-size:12px;
			margin-left:-6px;
		}
		
		#sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 100%; }
	#sortable li span { position: absolute; margin-left: -1.3em; }
	</style>
  </head>
  <body>
	<table cellpadding="0" cellspacing="0">
	  <tr>
		<td rowspan="2">
		  <div class="arrowsidemenu">
			<?php include 'main_menu.php'; ?>
		  </div>		</td>
		<td rowspan="2">&nbsp;</td>
		<td rowspan="2">&nbsp;</td>
		<td><center><label id="heading">Welcome To School Admission System</label></center></td>
	  </tr>
	  <tr>
		<td align="center">
		  <br /><br />
		  <ul id="sortable">
		    <li class="ui-state-default">
			  <table border="1" cellspacing="0" cellpadding="0">
				<tr>
				  <td ><label>Seats</label></td>
				  <?php
				  $rslt=mysql_query("select * from cate_dets where s_id=".$_SESSION['sid']." order by cate_id");
				  while($row=mysql_fetch_array($rslt))
				  {
				    echo "<td align='left' nowrap='nowrap'><label>Waiting List<br>";
				  	echo "(".$row['cate_name'].")";
					echo "</label></td>";
				  }
				  ?>
				  <td><label>Seats Left</label></td>
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
				</tr>
			  </table>
			</li>
		  </ul>
		  <br />
		  <div class="demo">
			<div id="dialog-form" title="Settings">
			  <p class="validateTips">All form fields are required.</p>
			    <form name="form1" action="" method="post">
				  <table cellpadding="5">
				  <tr>
					<td align="right" nowrap="nowrap"><label>Maximum Shuffle:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_max_shuffle" id="txt_max_shuffle" class="ui-widget-content ui-corner-all" value="" />					
					</td>
				  </tr>
				</table>
			  </form>
			</div>
		    <button id="btn_setting">Set</button>
		  </div>
		  <div id="alert"></div>		
		</td>
	  </tr>
	</table>
  </body>
</html>