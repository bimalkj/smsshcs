<?php
include "dbconnect.php";
//ini_set("display_errors",1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr">
<head>
<title>ADMISSION MODULE</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" media="screen" href="css/redmond/jquery-ui-1.8.14.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/demos.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/jquery.ui.all.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/form.css" />
<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="js/jquery.ui.core.js" type="text/javascript"></script>
<script src="js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="js/jquery.ui.button.js" type="text/javascript"></script>
<script language="javascript">
	  jQuery(document).ready(function()
	  {
		jQuery("input:submit").button();	
	  });
</script>
<style type="text/css">
.alert {
	width:50%;
	margin:0 auto;
}
#heading {
	font-size:20px;
}
body {
	margin-top:80px;
}
.tabhead {
	color: #FFF;
	text-align: center;
	font-size: 2em;
}
.tabcell {
	font-size: 2em;
}
.ex_info {
	font-size: x-small;
	color: #F96;
}
</style>
</head>
<body>
<center>
  <p>&nbsp;</p>
  <table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0">
    <tr>
      <!-- <td width="31%" align="center"><h2>Service offered from <br />
          &quot;Rotary Club - Midtown, Jamsehdpur&quot;<br /><img src="images/rotary.jpg"  /></h2></td> -->
      <td width="50%" align="center"><!-- 38%-->
        <p><br />
          <label id="heading">Welcome To School Admission System</label>
        </p>
        <p> <br />
        </p>
        <div id="effect" class="ui-widget-content ui-corner-all">
          <h3 class="ui-widget-header ui-corner-all">Please input your login details</h3>
          <form name="form1" action="member_login.php" method="post" >
            <label>User Name</label>
            <input type="text" name="txt_usrname" class="text ui-widget-content ui-corner-all" />
            <label>Password</label>
            <input type="password" name="txt_psw" class="text ui-widget-content ui-corner-all" />
            <input type="submit" id="btn_login" name="btn_login"  value="Login" style="margin-left:10px;"/>
          </form>
        </div>
        </br>
        </br>
      </td>
      <td width="50%" valign="top"><!-- 31%-->
<!--
        <table align="center" width="90%">
          <tr>
            <td></td>
          </tr>
          <tr>
            <td bgcolor="#70A8D2" class="tabhead">Link for parents</td>
          </tr>
          <?php
    $qry="select * from members_det where dummy=0";
	$rslt=mysql_query($qry) or die(mysql_error());
	if($rslt)
	{

	    while($row=mysql_fetch_array($rslt))
		{
		 
		 if ($row['flag']==1) 
		 {
		 
		 ?>
          <tr bgcolor="#CCCCCC">
            <td class="tabcell"><a href="index.php"><?php echo $row['s_name'];?></a></td>
          </tr>
          <?php
		
		 }
		 
		 else
		 
		 {
         
		 	?>
          <tr bgcolor="#CCCCCC">
            <td class="tabcell"><?php echo $row['s_name'];?> <span class="ex_info"> Results are yet to be announced</span></td>
          </tr>
          <?php
		 }
		 
		}
	}
	else echo "error";
    ?>
        </table>
-->
</td>
    </tr>
  </table>
  <p>&nbsp; </p>
</center>
<div>
  <?php 
	  if(isset($_REQUEST['msg']))
	  {
    ?>
  <div class="ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
      <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> <strong>Alert:</strong> <?php echo $_REQUEST['msg']; ?></p>
    </div>
  </div>
</div>
<?php 
	  }
    ?>
</div>
</body>
</html>
