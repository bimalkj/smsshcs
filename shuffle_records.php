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
	   window.color_arr=new Array("#3C0000","#5A0000","#780000","#960000","#B40000","#D20000","#F00000","#003C00","#005A00","#007800","#009600","#00B400","#00D200","#00F000","#00003C","#00005A","#000078","#000096","#0000B4","#0000D2","#0000F0","#3C3C00","#5A5A00","#787800","#969600","#B4B400","#D2D200","#F0F000","#3C003C","#5A005A","#780078","#960096","#B400B4","#D200D2","#F000F0","#003C3C","#005A5A","#007878","#009696","#00B4B4","#00D2D2","#00F0F0");
		var firstClick=true;
		function stud_grid(cate_id)	
		{
		  $("#alert").load('testing.php');
		  var shuffle_count=$.ajax({url:'get_shuffle_count.php?cate_id='+$("#lst_category").val()+'',async:false}).responseText;
		  document.getElementById("btn_shuffle").value="Shuffle("+shuffle_count+")";
		  var grid_url='AjaxStudDetsGrid.php?cate_id='+cate_id+'';
		  if(!firstClick)
		  {
		  	jQuery("#list").jqGrid('setGridParam',{url:grid_url}).trigger("reloadGrid")
		  }
		  firstClick = false;
		  var grid = $("#list");
		  $("#list").jqGrid(
		  {
			url:grid_url,
			datatype: 'xml',
			mtype: 'GET',
			colNames:['Student Name','Regs No.','Seq No.','Color Code'],
			colModel :[ 
			  {name:'s_name', index:'s_name',align:'left',editable:true,width:100},
			  {name:'regs_no', index:'regs_no',editable:true,editoptions:{readonly:true},width:65},
			  {name:'rank', index:'rank',editable:true,editoptions:{readonly:true},width:60},
			  {name:'color_code', index:'color_code',editable:true,editoptions:{readonly:true},hidden:true}
			    	  ],
			/*loadComplete: function() {
				var rows=grid.jqGrid('getRowData');
				for(i=0; i<grid.jqGrid('getRowData').length; i++)
				{
					var row=rows[i];
					var bg_color=window.color_arr[row['color_code']];
					//grid.jqGrid('setCell',i+1,"s_name","",{'background-color':bg_color,'color':'white'});
					grid.jqGrid('setCell',i+1,"regs_no","",{'background-color':bg_color,'color':'white'});
					grid.jqGrid('setCell',i+1,"rank","",{'background-color':bg_color,'color':'white'});
					grid.jqGrid('setCell',i+1,"nseq","",{'background-color':bg_color,'color':'white'});
				}
				}, */
			afterInsertRow: function(rowid, aData) {
					var bg_color=window.color_arr[aData.color_code]; 
					grid.setCell(rowid, 's_name', '', { 'background-color': bg_color,'color':'white' });
					grid.setCell(rowid, 'regs_no','', { 'background-color': bg_color,'color':'white' });
					grid.setCell(rowid, 'rank','', { 'background-color': bg_color,'color':'white' });
					grid.setCell(rowid, 'nseq','', { 'background-color': bg_color,'color':'white' });
				 
				},
			pager: '#pager',
			rowNum:100,
			height:300,
			rowList:[10,20,30,100],
			loadonce:false,
			gridview: false,
			sortname: 'regs_no',
			sortorder: 'asc',
			viewrecords: true,
			caption: 'Original List'
		  });
		  jQuery("#list").navGrid('#pager',{view:true,edit:false,add:false,del:false},{},{},{},{multipleSearch:true});
		}
		
	</script>
	<script>
	  $(document).ready(function() 
	  {
	    var secondClick=true;
		var thirdClick=true;
	  	$("#btn_shuffle").click(function()
		{
			var source='shuffled_status.php?cate_id='+$("#lst_category").val()+'';
			var status=$.ajax({url:source,async:false}).responseText;
			status_arr=status.split(",");
			
			document.getElementById("btn_shuffle").value="Shuffle("+status_arr[1]+")";
			if(status_arr[0]=="no")
			  $("#alert").load('show_alert.php');
			  
				var source='AjaxShuffleRecords.php?cate_id='+$("#lst_category").val()+'&shuffle='+status_arr[0]+'';
							
				var retVal=$.ajax({url:source,async:false}).responseText;
				
				document.getElementById("hdn_retVal").value=retVal;
				var GridUrl='AjaxShuffleStudGrid.php?cate_id='+$("#lst_category").val();
				
				 if(!secondClick)
				  {
					jQuery("#shuffle_list").jqGrid('setGridParam',{url:GridUrl}).trigger("reloadGrid")
				  }
				  secondClick=false;
				  var s_grid=$("#shuffle_list");
				  $("#shuffle_list").jqGrid(
				  {
					url:GridUrl,
					datatype: 'xml',
					mtype: 'GET',
					colNames:['Regs No.','Student Name','Seq No.','NSeq','Selected','Color Code'],
					colModel :[ 
					{name:'regs_no', index:'regs_no',editable:true,editoptions:{readonly:true},width:50},
					{name:'s_name', index:'s_name',align:'left',editable:true,width:100},
					{name:'rank', index:'rank',editable:true,editoptions:{readonly:true},width:60},
					{name:'nseq', index:'nseq',editable:true,editoptions:{readonly:true},width:60},
					{name:'status', index:'status',editable:true,editoptions:{readonly:true},width:60},
					{name:'color_code', index:'color_code',editable:true,editoptions:{readonly:true},hidden:true}
							  ],
					/*loadComplete: function() {
						var rows=s_grid.jqGrid('getRowData');
						for(i=0; i<s_grid.jqGrid('getRowData').length; i++)
						{
							var row=rows[i];
							var bg_color=window.color_arr[i%42];
							s_grid.jqGrid('setCell',i+1,"s_name","",{'background-color':bg_color,'color':'white'});
							s_grid.jqGrid('setCell',i+1,"regs_no","",{'background-color':bg_color,'color':'white'});
							s_grid.jqGrid('setCell',i+1,"rank","",{'background-color':bg_color,'color':'white'});
							s_grid.jqGrid('setCell',i+1,"nseq","",{'background-color':bg_color,'color':'white'});
							s_grid.jqGrid('setCell',i+1,"status","",{'background-color':bg_color,'color':'white'});
						}
					},*/
					afterInsertRow: function(rowid, aData) {
						var tclr='white';
						var bg_color=window.color_arr[aData.color_code]; 
						if (status_arr[1]<5) tclr=bg_color;
						s_grid.setCell(rowid, 's_name', '', { 'background-color': bg_color,'color':tclr });
						s_grid.setCell(rowid, 'regs_no','', { 'background-color': bg_color,'color':tclr });
						s_grid.setCell(rowid, 'rank','', { 'background-color': bg_color,'color':tclr });
						s_grid.setCell(rowid, 'nseq','', { 'background-color': bg_color,'color':tclr });
						s_grid.setCell(rowid, 'status','', { 'background-color': bg_color,'color':tclr });
				 
					},
					pager: '#shuffle_pager',
					rowNum:100,
					height:300,
					rowList:[10,20,30,100],
					loadonce:false,
					gridview: false,
					viewrecords: true,
					caption: 'Shuffled List'
				  });
				jQuery("#shuffle_list").navGrid('#shuffle_pager',{view:true,edit:false,add:false,del:false},{},{},{},{multipleSearch:true});
			/*});
			
			$("#btn_eligible").click(function()
			{*/
			 var retMsg=$.ajax({url:'AjaxCalcSeats.php?cate_id='+$("#lst_category").val()+'',async:false}).responseText;
			 var retMsg_arr=retMsg.split(",");
			 var rec_arr=document.getElementById("hdn_retVal").value;
			 
			 var Grid_Url='AjaxShuffleStudGrid.php?cate_id='+$("#lst_category").val()+'&final=yes';
			 
			 if(!thirdClick)
			  {
				jQuery("#eligible_list").jqGrid('setGridParam',{url:Grid_Url}).trigger("reloadGrid")
			  }
			  thirdClick=false;
			var egrid=$("#eligible_list")
			$("#eligible_list").jqGrid(
			{
				url:Grid_Url,
				datatype: 'xml',
				mtype: 'GET',
				colNames:['Regs No.','Student Name','Seq No.','NSeq','Selected','Color code'],
					colModel :[ 
					{name:'regs_no', index:'regs_no',editable:true,editoptions:{readonly:true},width:65},
					{name:'s_name', index:'s_name',align:'left',editable:true,width:100},
					{name:'rank', index:'rank',editable:true,editoptions:{readonly:true},width:60},
					{name:'nseq', index:'nseq',editable:true,editoptions:{readonly:true},width:60},
					{name:'status', index:'status',editable:true,editoptions:{readonly:true},width:60},
					{name:'color_code', index:'color_code',editable:true,editoptions:{readonly:true},hidden:true}
							  ],
				afterInsertRow: function(rowid, aData) {
					var bg_color=window.color_arr[aData.color_code];
					var tclr='white';
					var bg_color=window.color_arr[aData.color_code]; 
						if (status_arr[1]<5) tclr=bg_color;					
					egrid.setCell(rowid, 's_name', '', { 'background-color': bg_color,'color':tclr });
					egrid.setCell(rowid, 'regs_no','', { 'background-color': bg_color,'color':tclr });
					egrid.setCell(rowid, 'rank','', { 'background-color': bg_color,'color':tclr });
					egrid.setCell(rowid, 'nseq','', { 'background-color': bg_color,'color':tclr });
					egrid.setCell(rowid, 'status','', { 'background-color': bg_color,'color':tclr });
				 
				},
				pager: '#eligible_pager',
				rowNum:100,
				height:300,
				rowList:[10,20,30,100],
				loadonce:false,
				gridview: false,
				sortname: 'regs_no',
				sortorder: 'asc',
				viewrecords: true,
				caption: 'Final Selection'
			  });
			jQuery("#eligible_list").navGrid('#eligible_pager',{view:true,edit:false,add:false,del:false},{},{},{},{multipleSearch:true});
		});
	  	
	    $("input:submit").button();
		$("input:button").button();
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
		var usr_name = $( "#txt_usr_name" ),
			psw = $("#txt_psw"),
			s_name = $("#txt_sname"),
			loc = $("#txt_loc"),
			contact = $("#txt_contact_no"),
			EmailId = $("#txt_email_id"),
			allFields = $( [] ).add( usr_name ).add( psw ).add( s_name ).add( loc ).add( contact ).add( EmailId ),
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
		  height: 350,
		  width: 370,
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
			  bValid = bValid && checkRegexp( psw, /^[a-z0-9A-Z_]{2,60}$/, "Password may consist of a-z, 0-9, underscores, begin with a letter." );
				
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
			  {
				var sname=$("#txt_sname").val().replace(/ /g, ".");
				var	Loc=$("#txt_loc").val().replace(/ /g, ".");
				var source='AjaxInsSchoolDets.php?usrname='+usr_name.val()+'&psw='+psw.val()+'&s_name='+sname+'&loc='+Loc;
				source=source+'&contact_no='+contact.val()+'&email_id='+EmailId.val()+'';
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
			
		$( "#btn_add_school" ).button().click(function()
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
		<td rowspan="2">&nbsp;</td>
		<td></td>
	  </tr>
	  <tr>
		<td>
		  <br /><br />
		  <label>Select Category</label>:&nbsp;
		  <select name="lst_category" id="lst_category" class="ui-widget-content ui-corner-all" onchange="stud_grid(this.value)">
		    <?php
				echo "<option value='select'";
				if(isset($_REQUEST['lst_category']))
					if($_REQUEST['lst_category']=="select")
						echo ' selected="selected" ';
				echo ">Select</option>";
			    
				$qry="select * from cate_dets where s_id=".$_SESSION['sid']."";
				$rslt=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
				while($row=mysql_fetch_array($rslt,MYSQL_BOTH))
				{
					$cate_id=$row['cate_id'];
					$cate_name=$row['cate_name'];
					echo "<option value=$cate_id";
					if(isset($_REQUEST['lst_category']))
						if($_REQUEST['lst_category']==$cate_id)
							echo ' selected="selected" ';
					echo ">$cate_name</option>";
				}
			?>
		  </select>
		  &nbsp;
		  <input type="button" name="btn_shuffle" id="btn_shuffle" value="Shuffle"  />
		  <br /><br />
		  <table id="list"></table>		
		  <div id="pager"></div>
		</td>
		<td>&nbsp;</td>
		<td>
			<br /><br />
			<input type="hidden" name="hdn_retVal" id="hdn_retVal" value="" />
			<bR /><br /><br />
			<table id="shuffle_list"></table>
			<div id="shuffle_pager"></div>
			<br />
		</td>
		<td>&nbsp;</td>
		<td>
		  <br /><br /><br /><br /><br />
		  <table id="eligible_list"></table>
		  <div id="eligible_pager"></div>
		</td>
	  </tr>
	</table>
	<div align="center">
	<div id="alert" align="left"></div>
	</div>
  </body>
</html>
