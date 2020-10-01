<?php
	include 'dbconnect.php';
	session_start();
	if(!isset($_SESSION['usrname']))
	{
		header("location:index.php");
		exit;
	}
	
	if(isset($_REQUEST['btn_back']))
	{
		header("location:welcome_page.php");
		exit;
	}
$selarr=array('Final selection','Shuffled list','Original list','Waiting list');
$pdfopt=isset($_REQUEST['btn_pdf']);
$repind=0;$catinfo="";
if (isset($_REQUEST['rep_type'])) $repind=$_REQUEST['rep_type'];
		$qry="select * from cate_dets where s_id=".$_SESSION['sid']."";
	$rslt=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	$catarr=array();
	$catarr[0][0]='All';$catarr[0][1]='All';
	while($row=mysql_fetch_array($rslt,MYSQL_BOTH))
	{
	$cate_id=$row['cate_id'];
		$catarr[$cate_id][0]=$row['cate_name'];
		$catarr[$cate_id][1]=$row['cate_desc'];
		
	}
if (!$pdfopt)
{
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
<script language="javascript">
	$(document).ready(function() 
	  {
		$("input:submit").button();
	});	
</script>
<style type="text/css">
	label{
		color:#000000;
	}
	
	
</style>
</head>
<body background="<?php echo "images/".$_SESSION['logo'];?>">
<form name="form1" action="" method="post">
<label>Select Category</label>:&nbsp;
<select name="lst_category" id="lst_category" class="ui-widget-content ui-corner-all" onchange="stud_grid(this.value)">
<?php
	echo "<option value='select'";
	if(isset($_REQUEST['lst_category']))
		if($_REQUEST['lst_category']=="select")
			echo ' selected="selected" ';
	echo ">Select</option>";

	//$qry="select * from cate_dets where s_id=".$_SESSION['sid']."";
	//$rslt=mysql_query($qry) or die("Qry=".$qry." Error=".mysql_error()." Path=".$_SERVER['PHP_SELF']);
	//$catarr=array();
	//while($row=mysql_fetch_array($rslt,MYSQL_BOTH))
	foreach($catarr as $id => $cate)
	{
		$cate_id=$id;
		$cate_name=$cate[0];//$row['cate_name'];
		//$catarr[$cate_id]=$row['cate_desc'];
		echo "<option value=$cate_id";
		if(isset($_REQUEST['lst_category']))
			if($_REQUEST['lst_category']==$cate_id)
				echo ' selected="selected" ';
		echo ">$cate_name</option>";
	}
?>
</select>&nbsp;
<select name="rep_type" id="rep_type">
	<?php
	for($i=0;$i<4;$i++)
	{
			echo "<option value=$i";
			if($repind==$i)
				echo ' selected="selected" ';
		echo ">$selarr[$i]</option>";
	}
	?>
</select>
<select name="shflind">
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option selected="selected">5</option>
</select>
<input type="submit" name="btn_submit" id="btn_submit" value="Show" />&nbsp;
<input type="submit" name="btn_pdf" id="btn_pdf" value="PDF" />&nbsp;
<input type="submit" name="btn_back" id="btn_back" value="Back" />
</form>
 <?php
 } else {
 //---------------
 	require_once('tcpdf_config_alt.php');
	require_once('../tcpdf/tcpdf.php');
	// extend TCPF with custom functions
class MYPDF extends TCPDF {

	
	public $catinfo="*";
	
	public function setCat($cinfo)
	{
	$this->catinfo=$cinfo;
	}
	
	public function Header()
	{
	parent::Header();
	$style = array(
	'border' => false,
	'padding' => 0,
	'fgcolor' => array(0,0,0),
	'bgcolor' => false
	);
	$this->write2DBarcode('SHCS OAS', 'QRCODE,H', 180, 1, 14, 14, $style, 'T');
	$this->Text(15, 20, $this->catinfo);
	}
	// Load table data from file
	public function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}

	// Colored table
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->SetFillColor(55, 110, 254);
		$this->SetTextColor(255);
		$this->SetDrawColor(95, 150, 254);
		$this->SetLineWidth(0.1);
		$this->SetFont('', 'B');
		// Header
		$w = array(15, 20, 75, 70);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
			$this->Cell($w[0], 6, $row[0], 1, 0, 'R', $fill);
			$this->Cell($w[1], 6, $row[1], 1, 0, 'C', $fill);
			$this->Cell($w[2], 6, $row[2], 1, 0, 'L', $fill);
			$this->Cell($w[3], 6, $row[3], 1, 0, 'L', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}
}
 //---------------
 $submit=(isset($_REQUEST['btn_submit']) || $pdfopt );
 
	if( $submit && $repind==2)
	{
	$catid=$_REQUEST['lst_category'];
	$qry="select * from stud_dets where s_id=".$_SESSION['sid'];
	if ($catid<>0)
		$qry.=" and cate_id=".$catid;
	$rslt=mysql_query($qry);
	$i=1;$catinfo=$selarr[$repind].' '.$catarr[$catid][1];
	if (!$pdfopt)
	{
	?>
	<table  border="1"  cellspacing="0">
	<tr><td colspan=3><label><?php echo $catinfo; ?></label></td></tr>
	<tr>
    <th nowrap="nowrap"><label>Sl.</label> </th>
	<th nowrap="nowrap"><label>Form No.</label> </th>
    <th nowrap="nowrap"><label>Student Name</label> </th>
	</tr>
	<?php
	}
	$data=array();
	while($row=mysql_fetch_array($rslt))
	{
		$data[$i][0]=$i;
		$data[$i][1]=$row['form_no'];
		$data[$i][2]=$row['stud_name']."(".$row['gender'][0].")";
		$data[$i][3]=$row['guar_name'];
		if (!$pdfopt)
		{
		echo "<tr>";
		 echo"<td align='center' nowrap='nowrap'><label>$i</label></td>";
		 echo"<td align='center' nowrap='nowrap'><label>".$row['form_no']."</label></td>";
		 echo"<td align='center' nowrap='nowrap'><label>".$row['stud_name']."(".$row['gender'][0].")"."</label></td>";
		echo "<tr>";
		}
		$i++;
	}
	if (!$pdfopt) {
	?>
	</table>
	<?php
	}
	}
	if($submit && $repind==1)
	{
	$catid=$_REQUEST['lst_category'];$shflind=$_REQUEST['shflind'];
	$qry="select * from stud_dets s ";
	$qry.= " inner join shfl_det d on s.s_id=d.s_id and s.form_no=d.form and d.sind=$shflind-1 ";
	$qry.=" where s.s_id=".$_SESSION['sid'];
	if ($catid<>0)
		$qry.=" and cate_id=".$catid;
	$qry.=" order by d.seq";
	$rslt=mysql_query($qry);
	$i=1;$catinfo=$selarr[$repind]." $shflind ".$catarr[$catid][1];
	if (!$pdfopt)
	{
	?>
	<table border="1"  cellspacing="0">
	<tr><td colspan=3><label><?php echo $catinfo; ?></label></td></tr>
	<tr>
    <th nowrap="nowrap"><label>Sl. No.</label> </th>
	<th nowrap="nowrap"><label>Form No.</label> </th>
    <th nowrap="nowrap"><label>Student Name</label> </th>
	<!--<th nowrap="nowrap"><label>Selected</label> </th>-->
	</tr>
	<?php
	}
	$data=array();
	while($row=mysql_fetch_array($rslt))
	{
		$data[$i][0]=$i;
		$data[$i][1]=$row['form_no'];
		$data[$i][2]=$row['stud_name']."(".$row['gender'][0].")";
		$data[$i][3]=$row['guar_name'];
		if (!$pdfopt)
		{
		echo "<tr>";
		 echo"<td align='center'><label>$i</label></td>";
		 echo"<td align='center'><label>".$row['form_no']."</label></td>";
		 echo"<td align='center'><label>".$row['stud_name']."(".$row['gender'][0].")"."</label></td>";
		 //echo"<td align='center'><label>".$row['status']."</label></td>";
		echo "<tr>";}
		$i++;
	}
	if (!$pdfopt)
	{
	?>
	</table>
	<?php
	}
	}
	if($submit && $repind==0)
	{
		$catid=$_REQUEST['lst_category'];
		//$rec=mysql_fetch_array(mysql_query("select * from cate_dets where s_id=".$_SESSION['sid']." and cate_id=".$catid.""));
		//$wait_lst=$rec['tot_wait_lst'];
		//$tot_seat=$rec['tot_seats'];
		//$limit_rec=$wait_lst+$tot_seat;
		$qry="select * from stud_dets where s_id=".$_SESSION['sid'];
		if ($catid<>0)
			$qry.=" and cate_id=".$_REQUEST['lst_category'];
		//$qry.=" and status='Yes' or status='WL' order by regs_no";
		$qry.=" and status='Yes' order by regs_no";
		$rslt=mysql_query($qry);
		$i=1;$catinfo=$selarr[$repind].' '.$catarr[$catid][1];
		if (!$pdfopt)
		{
		?>
		<table border="1" cellspacing="0">
		<tr><td colspan=3><label><?php echo $catinfo; ?></label></td></tr>
		<tr>
		<th nowrap="nowrap"><label>Sl. No.</label> </th>
		<th nowrap="nowrap"><label>Form No.</label> </th>
		<th nowrap="nowrap"><label>Student Name</label> </th>
		<th nowrap="nowrap"><label>Selected</label> </th>
		</tr>
		<?php
		}
		$data=array();
		while($row=mysql_fetch_array($rslt))
		{
		$data[$i][0]=$i;
		$data[$i][1]=$row['form_no'];
		$data[$i][2]=$row['stud_name'];//."(".$row['gender'][0].")";
		$data[$i][3]=$row['guar_name'];
		if (!$pdfopt)
		{
		echo "<tr style='background-color:#fff'>";
		 echo"<td align='center'><label>$i</label></td>";
		 echo"<td align='center'><label>".$row['form_no']."</label></td>";
		 echo"<td align='center'><label>".$row['stud_name']."(".$row['gender'][0].")</label></td>";
		 echo"<td align='center'><label>".$row['status']."</label></td>";
		echo "<tr>";}
			$i++;
		}
		if (!$pdfopt)
		{
		?>
		</table>
		<?php
		}
	}
	
	if($submit && $repind==3)
	{
		$catid=$_REQUEST['lst_category'];
		$rec=mysql_fetch_array(mysql_query("select * from cate_dets where s_id=".$_SESSION['sid']." and cate_id=".$catid.""));
		$ratio=$rec['ratio'];
		$eligible=$rec['tot_wait_lst'];
		$ratio_arr=explode(":",$ratio);
		if (count($ratio_arr)>1)
		{
		$sor=$ratio_arr[0]+$ratio_arr[1];
		$tot_girls=($eligible/$sor)*$ratio_arr[0];
		$tot_girls=(int)$tot_girls;
		$tot_boys=($eligible/$sor)*$ratio_arr[1];
		$tot_boys=(int)$tot_boys;
		} else {
			$tot_girls=$eligible;
			$tot_boys=$eligible;
			}
		
		//$wait_lst=$rec['tot_wait_lst'];
		//$tot_seat=$rec['tot_seats'];
		//$limit_rec=$wait_lst+$tot_seat;
	
		$qry="select s.* from stud_dets s ";//inner join shfl_det d on s. where s_id=".$_SESSION['sid'];
		//$qry.= " inner join shfl_det d on s.s_id=d.s_id and s.form_no=d.form and d.sind=4 ";
		$qry.=" where s.s_id=".$_SESSION['sid'];
		if ($catid<>0)
			$qry.=" and cate_id=".$_REQUEST['lst_category'];
		$qry.=" and status='WL' order by nseq";
		//echo $qry;
		$rslt=mysql_query($qry);
		$i=1;$catinfo="";
		$catinfo=$selarr[$repind].' '.$catarr[$catid][1];
		if (!$pdfopt)
		{
		$catinfo=$selarr[$repind].' '.$catarr[$catid][1];
		?>
		<table border="1" cellspacing="0">
		<tr><td colspan=3><label><?php echo "$catinfo"; ?></label></td></tr>
		<tr>
		<th nowrap="nowrap"><label>Sl. No.</label> </th>
		<th nowrap="nowrap"><label>Form No.</label> </th>
		<th nowrap="nowrap"><label>Student Name</label> </th>
		<!--<th nowrap="nowrap"><label>Waiting list</label> </th>--> 
		</tr>
		<?php
		}
		$data=array();$gc=0;$bc=0;
		while (($row=mysql_fetch_array($rslt)) && ($i<=$eligible))
			{
			if (($row['gender']=='Male') && ($bc<=$tot_boys))
				{
				$bc++;$data[$i][0]=$i;
				$data[$i][1]=$row['form_no'];
				$data[$i][2]=$row['stud_name'];
				$data[$i][3]=$row['guar_name'];
				if (!$pdfopt)
					{
					echo "<tr style='background-color:#fff'>";
					echo"<td align='center'><label>$i</label></td>";
					echo"<td align='center'><label>".$row['form_no']."</label></td>";
					echo"<td align='center'><label>".$row['stud_name']."(".$row['gender'][0].")</label></td>";
					//echo"<td align='center'><label>".$row['status']."</label></td>";
					echo "<tr>";
					}
				$i++;
				} else if (($row['gender']=='Female') && ($gc<=$tot_girls))
				{
				$gc++;$data[$i][0]=$i;
				$data[$i][1]=$row['form_no'];
				$data[$i][2]=$row['stud_name']."(".$row['gender'][0].")";
				$data[$i][3]=$row['guar_name'];
				if (!$pdfopt)
					{
					echo "<tr style='background-color:#fff'>";
					echo"<td align='center'><label>$i</label></td>";
					echo"<td align='center'><label>".$row['form_no']."</label></td>";
					echo"<td align='center'><label>".$row['stud_name']."(".$row['gender'][0].")</label></td>";
					//echo"<td align='center'><label>".$row['status']."</label></td>";
					echo "<tr>";
					}
				$i++;
				}
			
			}
		if (!$pdfopt)
		{
		?>
		</table>
		<?php
		}
	}
	
	if ($pdfopt)
	{

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('OAS');
$pdf->SetTitle('TCPDF Example 011');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);
$pdf->catinfo=$catinfo;
$pdf->AddPage();
$header = array('Sl. No.', 'Form No.', 'Student Name', 'Father\'s Name');
$pdf->ColoredTable($header, $data);
$pdf->Output('example_011.pdf', 'I');

	}
	
?>

</body>
</html>
