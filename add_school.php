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
			url:'AjaxSchoolDetsGrid.php',
			datatype: 'xml',
			mtype: 'GET',
			colNames:['User Name','School Id','School Name','Location','Contact No.','Email ID','Maximum Shuffling'],
			colModel :[ 
			  {name:'usrname', index:'usrname',editable:true,editoptions:{readonly:true},fixed:true},
			  {name:'s_id', index:'s_id',editable:true,editoptions:{readonly:true},fixed:true},
			  {name:'s_name', index:'s_name',align:'center',editable:true,fixed:true},
			  {name:'loc', index:'loc',align:'center',editable:true,fixed:true},
			  {name:'cont_no', index:'cont_no',align:'center',editable:true,fixed:true},
			  {name:'email_id', index:'email_id',align:'center',fixed:true,editable:true},
			  {name:'max_shuffle', index:'max_shuffle',align:'center',fixed:true,editable:true},
			    	  ],
			pager: '#pager',
			rowNum:100,
			height:300,
			width:750,
			rowList:[10,20,30,100],
			loadonce:true,
			gridview: true,
			sortname: 'usrname',
			sortorder: 'asc',
			viewrecords: true,
			caption: 'School Details',
			editurl:'AjaxEditSchoolDets.php'
		  });
		  jQuery("#list").navGrid('#pager',{view:true,edit:true,add:false,del:false},{},{},{},{multipleSearch:true});
		});
	</script>
<script>
	  $(document).ready(function() 
	  {
	    $("input:submit").button();
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
		var usr_name = $( "#txt_usr_name" ),
			psw = $("#txt_psw"),
			s_name = $("#txt_sname"),
			loc = $("#txt_loc"),
			contact = $("#txt_contact_no"),
			EmailId = $("#txt_email_id"),
			MaxShuffle = $("#txt_max_shuffle"),
			allFields = $( [] ).add( usr_name ).add( psw ).add( s_name ).add( loc ).add( contact ).add( EmailId ).add( MaxShuffle ),
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
		
		function UsrExist(o,n)
		{
			var RetMsg=$.ajax({url:'usrexist.php?usrname='+o.val()+'',async:false}).responseText;
			o.addClass( "ui-state-error" );
			updateTips( n );
			if(!RetMsg)
				return true;
			else if(RetMsg)
				return false;
		}
				
		$( "#dialog-form" ).dialog(
		{
		  autoOpen: false,
		  height: 370,
		  width: 420,
		  modal: true,
		  buttons: 
		  {
			"Add": function() 
			{
			  var bValid = true;
			  allFields.removeClass( "ui-state-error" );
			  bValid = bValid && checkLength( usr_name, "User Name", 2,60 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( usr_name, /^[a-z0-9A-Z_]{2,60}$/, "User Name may consist of a-z, 0-9, underscores, begin with a letter." );
				
			  if( bValid )			
			  bValid = bValid && UsrExist(usr_name,"User name already exists");
			  
			  if ( bValid )
			  bValid = bValid && checkLength( psw, "Password", 2,60 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( psw, /^[a-z0-9A-Z@_]{2,60}$/, "Password may consist of a-z, 0-9, underscores, begin with a letter." );
				
			  if ( bValid )
			  bValid = bValid && checkLength( s_name, "School Name", 2,60 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( s_name, /^[a-z0-9A-Z._ -]{3,50}$/, "School Name may consist of a-z, 0-9, underscores, begin with a letter." );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( loc, /^[a-z0-9A-Z._ -]{3,150}$/, "Location may consist of a-z, 0-9, underscores, begin with a letter." );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( contact, /^[0-9]{10,20}$/, "Contact no should be integer and length must be between 10 and 20." );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( EmailId, /^[a-z0-9A-Z._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/, "eg. abc@gmail.com" );
			  
			   if ( bValid )
			  bValid = bValid && checkRegexp( MaxShuffle, /^[0-9]{1,5}$/, "'Maximum Shuffling' option should be numeric(0-9) format" );
			  		
			  if ( bValid ) 
			  {
				var sname=$("#txt_sname").val().replace(/ /g, ".");
				var	Loc=$("#txt_loc").val().replace(/ /g, ".");
				var source='AjaxInsSchoolDets.php?usrname='+usr_name.val()+'&psw='+psw.val()+'&s_name='+sname+'&loc='+Loc;
				source=source+'&contact_no='+contact.val()+'&email_id='+EmailId.val()+'&max_shuffle='+MaxShuffle.val()+'';
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
			
		$( "#btn_reset" ).button().click(function()
		{
		  var usrname=jQuery("#list").jqGrid('getGridParam','selrow');
		  if(usrname==null) alert("Please select a school");
		  else
		  {
			  var status=confirm("This operation will reset your shuffle counter and list. Are you sure?");
			  if(status) $("#alert").load('reset_records.php?usrname='+usrname+'');
		  }
		});
		
		$( "#btn_add_school" ).button().click(function()
		{
		  $( "#dialog-form" ).dialog( "open" );
		});
	  });
	</script>
<style type="text/css">
body {
	margin:0 auto;
	padding:0;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
#instruct {
	margin:0 auto;
}
td {
	vertical-align:top;
}
pre {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:13px;
}
label {
	margin-left:30px;
}
#lbl_prg {
	font-size:12px;
	margin-left:-7px;
}
#lbl_batch {
	font-size:12px;
	margin-left:-6px;
}
.my_header {
	color: #3399cc;
	font-family: Verdana, Geneva, sans-serif;
	font-size: x-large;
}
</style>
</head>
<body>
<table cellpadding="0" cellspacing="0" width="90%">
  <tr height="80px">
  	<td colspan="2">
    	<center><h2 class="my_header">Welcome To School Admission System</h2></center>
    </td>
  </tr>
  <tr>
  	<td>
    	<div class="arrowsidemenu">
        <?php include 'main_menu.php'; ?>
      </div>
      <input type="hidden" name="hdn_rid" id="hdn_rid" value="<?php echo $_SESSION['rid']; ?>" />
    </td>
    <td>
    	<table id="list">
      </table>
      <div id="pager"></div>
      <div class="demo">
        <div id="dialog-form" title="Create new school">
          <p class="validateTips">All form fields are required.</p>
          <form name="form1" action="" method="post">
            <table cellpadding="5">
              <tr>
                <td align="right" nowrap="nowrap"><label>User Name:</label></td>
                <td align="left" nowrap="nowrap"><input type="text" name="txt_usr_name" id="txt_usr_name" class="ui-widget-content ui-corner-all" value="" />
                </td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label>Password:</label></td>
                <td align="left" nowrap="nowrap"><input type="password" name="txt_psw" id="txt_psw" class="ui-widget-content ui-corner-all" value="" /></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label>School Name:</label></td>
                <td align="left" nowrap="nowrap"><input type="text" name="txt_sname" id="txt_sname" class="ui-widget-content ui-corner-all" value="" /></td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label>Location:</label></td>
                <td align="left" nowrap="nowrap"><input type="text" name="txt_loc" id="txt_loc" class="ui-widget-content ui-corner-all" value="" />
                </td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label>Contact No.:</label></td>
                <td align="left" nowrap="nowrap"><input type="text" name="txt_contact_no" id="txt_contact_no" class="ui-widget-content ui-corner-all" value="" />
                </td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label>Email Id:</label></td>
                <td align="left" nowrap="nowrap"><input type="text" name="txt_email_id" id="txt_email_id" class="ui-widget-content ui-corner-all" value="" />
                </td>
              </tr>
              <tr>
                <td align="right" nowrap="nowrap"><label>Maximum Shuffling:</label></td>
                <td align="left" nowrap="nowrap"><input type="text" name="txt_max_shuffle" id="txt_max_shuffle" class="ui-widget-content ui-corner-all" value="" />
                </td>
              </tr>
            </table>
          </form>
        </div>
        <button id="btn_add_school">Add School</button>
         
        <button id="btn_reset">Reset</button>
          </div>
      <div id="alert"></div>
    </td>
  </tr>
</table>
</body>
</html>
