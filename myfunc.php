<style>
.color_tab {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	background-color: #2eb6e3;
	background-image: url(../images/tab_head_bg.gif);
	background-repeat: repeat-x;
	background-position: top;
	padding: 2px;
}
.color_tab .inner_head {
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #04456d;
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
	padding: 4px;
	height: 20px;
}
.color_tab .inner_body {
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #04456d;
	background-color: #CDDCF1;
	padding-right: 2px;
	padding-left: 2px;
	height: 22px;
}
.color_tab .color_tab .inner_body td {
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #04456d;
}

</style>
<?php
function mydisp($query,
$head='xx,xx,xx,xx,xx,xx,xx,xx,xx,xx,xx,xx,xx,xx,,,,,',
$colw='')
{
$editing=False;
// Query database and display guestbook entries
$rslt=mysql_query( $query);// Make sure rows were returned before outputting
$firsttime=true;
while ($rows = mysql_fetch_row($rslt)) 
	{
	if ($firsttime)
	{
		$firsttime=false;
		$imdir='';
		echo '<table id="table_results" cellspacing="1" cellpadding="1" class="color_tab">';
		echo '<tr><td><table cellspacing="1" cellpadding="1" class="color_tab">';
		printf('<tr class="inner_head">');
		$col_head=explode(',',$head);$ind=0;
		if ($colw=='')
			foreach($rows as $col) printf('<td><div align="center">' .$col_head[$ind++]. "</div></td>");
			else
				{
				$cw=explode(',',$colw);
				foreach($rows as $col) printf('<td width="'.$cw[$ind].'"><div align="center">' .$col_head[$ind++]. '</div></td>');
				}
			printf('</tr>');
	}
		printf("<tr class='inner_body'>\n");
		//if ($clr=='') $clr=" bgcolor='#dbe6f1'"; else $clr='';
		if ($editing)
			{
			printf("<td><img title='Delete' src='./".$imdir."/b_drop.png'></td>\n");
			printf("<td><img title='Edit' src='./".$imdir."/b_edit.png'></td>\n");
			}
		// Encode text to HTML formatting
		for($i=0;$i<$ind-3;$i++) printf("<td>" . $rows[$i] . "</td>\n");
		if ($rows[$ind-3]=='') echo("<td></td>\n");
		else {
		$docnm=$rows[$ind-1].$rows[$ind-3];
		echo("<td><a href=\"docdnld.php?id=$docnm\">".
		"<div align=\"center\"><img src='./".$imdir.
		"/dnld1.png' width=\"16\" height=\"16\" /></div></td>\n");
		};
		if ($rows[$ind-2]=='') echo("<td></td>\n");
		else {
		$docnm=$rows[$ind-1].$rows[$ind-2];
		echo("<td><a href=\"docdnld.php?id=$docnm\">".
		"<div align=\"center\"><img src='./".$imdir.
		"/dnld2.png' width=\"16\" height=\"16\" /></div></td>\n");
		};
		printf("</tr>\n");
		}	
	echo '</table></td></tr>';
	echo '  </table>';
	}
?>