		<style type="text/css">
			body{
				margin:0 auto;
				padding:0;
				font-family:Verdana, Arial, Helvetica, sans-serif;
			}
			
			#txtStyle:{
				font-family:Verdana, Arial, Helvetica, sans-serif;
				font-size:36px;
				color:#3399CC;
			}
			
			#instruct{
				margin:0 auto;
			}
			
			td{
				vertical-align:top;
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
				text-shadow:black 0.1em 0.1em 0.2em;
			}
		
			.arrowsidemenu div a:link, .arrowsidemenu div a:visited{
				color: white;
			}
			.arrowsidemenu div a:hover{
				background-position: 100% -32px;
				text-shadow:none;
			}
			
			.arrowsidemenu div.unselected a{ /*header that's currently not selected*/
				color: white;
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
			
		  .my_header {
			color: #3399CC;
			font-family: Verdana, Geneva, sans-serif;
			font-size: x-large;
			}	
			
		#effect {
			width: 70%;
		}
		</style>
<?php 
	$qry="select name,sub_id,url from main_menu where rid=".$_SESSION['rid']." order by sub_id";
	$rslt=mysql_query($qry) or die("Error in main_qry=".$qry);
	while($row=mysql_fetch_array($rslt))
	{
	  $name=$row['name'];
	  $sub_id=$row['sub_id'];
	  $url=$row['url'];
?>
	<div class="menuheaders"><a href="<?php echo $url; ?>" title="<?php echo $name; ?>"><?php echo $name;?></a></div>
 	<ul class="menucontents">
<?php
		$sub_menu_qry="select name,url from sub_menu where sub_id=$sub_id";
		$sub_menu_rslt=mysql_query($sub_menu_qry) or die("Error in sub menu qry=".$sub_menu_qry);
		while($sub_menu_row=mysql_fetch_array($sub_menu_rslt))
		{
			$sub_menu_name=$sub_menu_row['name'];
			$sub_menu_url=$sub_menu_row['url'];
?>
		<li><a href='<?php echo $sub_menu_url; ?>'>&nbsp;<?php echo "$sub_menu_name"; ?></a></li>
<?php
		}
?>
		</ul>
<?php 
	}
?>
<div><a href="logout.php" title="Logout">Logout</a></div>