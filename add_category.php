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

	<script type="text/javascript">
		jQuery().ready(function()
		{	
		  $("#list").jqGrid(
		  {
			url:'AjaxCateDetsGrid.php',
			datatype: 'xml',
			mtype: 'GET',
			colNames:['Category Id','Category Name','Description','Reservation(%)','Waiting List','Student Ratio(F:M)'],
			colModel :[ 
			  {name:'cate_id', index:'cate_id',editable:true,editoptions:{readonly:true},fixed:true},
			  {name:'cate_name', index:'cate_name',editable:true,fixed:true},
			  {name:'cate_desc', index:'cate_desc',align:'center',editable:true,fixed:true},
			  {name:'resrv', index:'resrv',align:'center',editable:true,fixed:true},
			  {name:'tot_wait_lst', index:'tot_wait_lst',align:'center',editable:true,fixed:true},
			  {name:'ratio', index:'ratio',align:'center',editable:true,fixed:true}
			     	  ],
			pager: '#pager',
			rowNum:100,
			height:300,
			rowList:[10,20,30,100],
			loadonce:true,
			gridview: true,
			sortname: 'cate_id',
			sortorder: 'asc',
			viewrecords: true,
			caption: 'Category Details',
			editurl:'ajax_edit_catdets.php'
		  });
		  jQuery("#list").navGrid('#pager',{view:true,edit:true,add:false,del:false},{},{},{},{multipleSearch:true});
		});
	</script>
	<script>
	  $(document).ready(function() 
	  {
	    $("input:submit").button();
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
		var cate_name = $( "#txt_cate_name" ),
			desc = $("#txt_desc"),
			resrv=$("#txt_resrv"),
			tot_wait_lst=$("#txt_tot_wait_lst"),
			ratio=$("#txt_ratio"),
			allFields = $( [] ).add( cate_name ).add( desc ).add( resrv ).add( tot_wait_lst ).add( ratio ),
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
		  height: 350,
		  width: 450,
		  modal: true,
		  buttons: 
		  {
			"Add": function() 
			{
			  var bValid = true;
			  tips.text( "All form fields are required" );
			  allFields.removeClass( "ui-state-error" );
			  bValid = bValid && checkLength( cate_name, "Category Name", 2,50 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( cate_name, /^[a-z0-9A-Z_]{2,50}$/, "Category Name may consist of a-z, 0-9, underscores, begin with a letter.");
				
			  if ( bValid )
			  bValid = bValid && checkLength( desc, "Description", 5,100 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( desc, /^[a-z0-9A-Z._ -]{5,100}$/, "School Name may consist of a-z, 0-9, underscores, begin with a letter." );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( resrv, /^[0-9]{1,3}$/, "Reservation should be in numeric(0-9) format." );
			  
			  if ( bValid )
			  bValid = bValid && checkRegexp( tot_wait_lst, /^[0-9]{1,3}$/, "Waiting List should be in numeric(0-9) format." );
			  
			  if ( bValid )
			  bValid = bValid && checkRegexp( ratio, /^[0-9]|[0-9][0-9]:[0-9]|[0-9][0-9]$/, "Ration should be in the format of (A:B),where A and B are numeric." );
			  
			  if ( bValid ) 
			  {
				var Desc=$("#txt_desc").val().replace(/ /g, ".");
				var source='AjaxAddCateDets.php?cate_name='+cate_name.val()+'&desc='+Desc+'&resrv='+$("#txt_resrv").val();
				source+='&tot_wait_lst='+tot_wait_lst.val()+'&ratio='+ratio.val()+'';
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
			
		$( "#btn_add_cate" ).button().click(function()
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
		  </div>			  
		</td>
		<td rowspan="2">&nbsp;</td>
		<td></td>
	  </tr>
	  <tr>
		<td>
		  <br />
		  <table id="list">
		  </table>
		  <div id="pager"></div>
		  <div class="demo">
			<div id="dialog-form" title="Add Category">
			  <p class="validateTips">All form fields are required.</p>
			    <form name="form1" action="" method="post">
				  <table cellpadding="5">
				  <tr>
					<td align="right" nowrap="nowrap"><label>Category Name:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_cate_name" id="txt_cate_name" class="ui-widget-content ui-corner-all" value="" />
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Description:</label></td>
					<td align="left" nowrap="nowrap">
					  <textarea name="txt_desc" id="txt_desc" class="ui-widget-content ui-corner-all"></textarea>
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Reservation:</label></td>
					<td align="left" nowrap="nowrap">
					  <input name="txt_resrv" type="text" class="ui-widget-content ui-corner-all" id="txt_resrv" value="" />
					  %
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Total Waiting List:</label></td>
					<td align="left" nowrap="nowrap">
					  <input name="txt_tot_wait_lst" type="text" class="ui-widget-content ui-corner-all" id="txt_tot_wait_lst" value="" />
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Student Ratio(Girls:Boys):</label></td>
					<td align="left" nowrap="nowrap">
					  <input name="txt_ratio" type="text" class="ui-widget-content ui-corner-all" id="txt_ratio" value="" />
					</td>
				  </tr>
				</table>
			  </form>
			</div>
		    <button id="btn_add_cate">Add Category</button>
		  </div>
		  <div id="alert"></div>
		</td>
	  </tr>
	</table>
  </body>
</html>