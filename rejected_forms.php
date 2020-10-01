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
	<script type="text/javascript">
		jQuery().ready(function()
		{	
		  var retVal=$.ajax({url:'ajax_list_cate.php',async:false}).responseText;
		  $("#list").jqGrid(
		  {
			url:'rejected_forms_dets_grid.php',
			datatype: 'xml',
			mtype: 'GET',
			colNames:['Student Name','Dob','Form Number','Regs. No.','Category','Gender','Guardian\'s Name','Contact No.','Rejection Reason'],
			colModel :[ 
			  {name:'stud_name', index:'stud_name',editable:true,width:120},
			  {name:'dob', index:'dob',editable:true,align:'center',width:100},
			  {name:'form_no', index:'form_no',editable:true,width:100},
			  {name:'regs_no', index:'regs_no',editable:true,editoptions:{readonly:true},width:80},
			  {name:'cate_name', index:'cate_name',editable:true,edittype:"select",editoptions:{value:retVal},width:80},
			  {name:'gender', index:'gender',align:'center',editable:true,width:80,edittype:"select",editoptions:{value:"Male:Male;Female:Female"}},
			  {name:'guar_name', index:'guar_name',align:'left',editable:true,width:120},
			  {name:'cont_no', index:'cont_no',align:'center',editable:true,width:100},
			  {name:'reason_reject', index:'reason_reject',align:'left',editable:true,width:150}
			  
			    	  ],
			pager: '#pager',
			rowNum:1000,
			height:300,
			rowList:[10,20,30,100],
			loadonce:true,
			gridview: true,
			sortname: 'regs_no',
			sortorder: 'asc',
			viewrecords: true,
			caption: 'Student Details',
			editurl:'AjaxEditRejectedForms.php'
		  });
		  jQuery("#list").navGrid('#pager',{view:true,edit:true,add:false,del:true},{},{},{},{multipleSearch:true});
		});
		
	</script>
	<script>
	  $(document).ready(function() 
	  {
	    $("input:submit").button();
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
		var form_no = $( "#txt_form_no" ),
			stud_name = $("#txt_stud_name"),
			dob =$("#datepicker"),
			guar_name = $("#txt_guar_name"),
			contact = $("#txt_contact_no"),
			reason_reject = $("#txt_reason_reject"),
			allFields = $( [] ).add( form_no ).add( stud_name ).add( dob ).add( guar_name ).add( contact ).add( reason_reject ),
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
		
		function FormExist(o,n)
		{
			var RetMsg=$.ajax({url:'reject_form_exist.php?form_no='+o.val()+'',async:false}).responseText;
			o.addClass( "ui-state-error" );
			if(RetMsg=='false')
				return true;
			else if(RetMsg=='true')
			{
				updateTips( n+' '+RetMsg );
				return false;
			}
		}
				
		$( "#dialog-form" ).dialog(
		{
		  autoOpen: false,
		  height: 400,
		  width: 420,
		  modal: true,
		  buttons: 
		  {
			"Add": function() 
			{
			  var bValid = true;
			 
			  allFields.removeClass( "ui-state-error" );
			  bValid = bValid && checkLength( form_no, "Form Number", 1,20 );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( form_no, /^[a-zA-Z0-9]{1,20}$/, "Form Number may consist of a-z, 0-9" );
			 
			  if( bValid )			
			  bValid = bValid && FormExist(form_no,"Form Number already exists");
			 
			  if ( bValid )
			  bValid = bValid && checkLength( stud_name, "Student Name", 1,100 );
			  
			  if( bValid )
			  bValid = bValid && checkRegexp( dob,/^(0[0-9]|1[0-9]|2[0-9]|3[01])\-(0[1-9]|1[0-2])\-(19[0-9][0-9]|20[0-9][0-9])$/, "Date of birth format is dd-mm-yyyy");
			  
			  if ( bValid )
			  bValid = bValid && checkRegexp( stud_name, /^[a-z0-9A-Z._ -]{1,100}$/, "Student Name may consist of a-z, 0-9, underscores, begin with a letter." );
			
			  if ( bValid )
			  bValid = bValid && checkRegexp( guar_name, /^[a-z0-9A-Z._ -]{1,100}$/, "Guardian's Name may consist of a-z, 0-9, underscores, begin with a letter." );
				
			  if ((contact.val()!="") && (bValid) )
			  bValid = bValid && checkRegexp( contact, /^[0-9 ]{10,20}$/, "Contact no should be integer and length must be between 10 and 20." );
				
			  if ( bValid )
			  bValid = bValid && checkRegexp( reason_reject, /^[a-z0-9A-Z._ -]{1,100}$/, "Reason for rejection may consist of a-z, 0-9, underscores, begin with a letter." );

			
			
			
			  if ( bValid ) 
			  {
				var s_name=$("#txt_stud_name").val().replace(/ /g, ".");
				var Guar_name=$("#txt_guar_name").val().replace(/ /g, ".");
				var source='AjaxAddRejectForms.php?form_no='+form_no.val()+'&stud_name='+s_name+'&gender='+$("#lst_gender").val();
                source=source+'&cate_id='+$("#lst_category").val()+'&guar_name='+Guar_name+'&contact_no='+contact.val()+'&reason_reject='+reason_reject.val()                 +'';
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
			
		$( "#btn_add_stud" ).button().click(function()
		{
		  $( "#dialog-form" ).dialog( "open" );
		});
		$( "#btn_restore" ).button().click(function()
		{
		  //$( "#dialog-form" ).dialog( "open" );
		 // alert('hello');		
		 var gr = jQuery("#list").jqGrid('getGridParam','selrow');
		  if( gr != null ) jQuery("#list").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		   else alert("Please Select Row to Resotre!");
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
		  <br />		  <table id="list">
		  </table>
		  <div id="pager"></div>         
		  <div class="demo">           
			<div id="dialog-form" title="Add new student">
			  <p class="validateTips">All form fields are required.</p>
			    <form name="form1" action="" method="post">
				  <table cellpadding="5">
				  <tr>
					<td align="right" nowrap="nowrap"><label>Form No.:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_form_no" id="txt_form_no" class="ui-widget-content ui-corner-all" value="" /></td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Student Name:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_stud_name" id="txt_stud_name" class="ui-widget-content ui-corner-all" value="" /></td>
				  </tr>
                  <tr>
					<td align="right" nowrap="nowrap"><label>DOB:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_stud_dob" id="datepicker" class="ui-widget-content ui-corner-all" value="" /></td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Gender:</label></td>
					<td align="left" nowrap="nowrap">
					  <select name="lst_gender" id="lst_gender" class="ui-widget-content ui-corner-all"/>
					  	<option value="Male">Male</option>
						<option value="Female">Female</option>
					  </select>
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Category:</label></td>
					<td align="left" nowrap="nowrap">
						<select name="lst_category" id="lst_category" class="ui-widget-content ui-corner-all">
						<?php
							$qry="select * from cate_dets where s_id=".$_SESSION['sid']."";
							$rslt=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
							while($row=mysql_fetch_array($rslt,MYSQL_BOTH))
							{
								$cate_id=$row['cate_id'];
								$cate_name=$row['cate_name'];
								echo "<option value=$cate_id";
								if(isset($_REQUEST['lst_category']))
									if($_REQUEST['lst_category']==$cate_id)
									echo ' "selected"=selected ';
								echo ">$cate_name</option>";
							}
						?>
						</select> 
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Guardian's Name:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_guar_name" id="txt_guar_name" class="ui-widget-content ui-corner-all" value="" />
					</td>
				  </tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Contact No.:</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_contact_no" id="txt_contact_no" class="ui-widget-content ui-corner-all" value="" />
					</td>
				  </tr>
                  	  </tr>
				  <tr>
				  <tr>
					<td align="right" nowrap="nowrap"><label>Reason for Rejection</label></td>
					<td align="left" nowrap="nowrap">
					  <input type="text" name="txt_reason_reject" id="txt_reason_reject" class="ui-widget-content ui-corner-all" value="" />
					</td>
				  </tr>
 				</table>
			  </form>
			</div>
            <div id="dialog" title="Upload Image">
     
		    <button id="btn_add_stud">Add Student</button>
            <button id="btn_restore">Restore Student</button>           
		  </div>
		  <div id="alert"></div>
		</td>
	  </tr>
	</table>
  </body>
</html>