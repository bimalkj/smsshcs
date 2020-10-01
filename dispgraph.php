// A simple XY graph 
<html>
<head>
       
<title>XY Graph</title>
<h2>Practice XY Graph</h2>
</head>
<body>
<?php 
$left = 0;
$top = 0;
$x_size = 400;
$y_size = 400;
$char_width = 8;
$char_height = 11;
$x_start = $x_left + 100;
$y_start = $top + $char_height * 1.5;
$x_end = $x_start + $x_size;
$y_end = $y_start + $y_size;
$right = $x_start + $x_size + 40;
$bottom = $y_start + $y_size + $char_height * 1.5;
$graph_n = 100;
for($i = 0; $i < $graph_n; $i++ )
   {
   $graph_x[$i] = $i;
   $graph_y[$i] = $i;
   }
$min_x = 9e99;
$min_y = 9e99;
$max_x = -9e99;
$max_y = -9e99;
$avg_y = 0.0;

for($i = 0; $i < $graph_n; $i++ )
{
if( $graph_x[$i] < $min_x )
$min_x = $graph_x[$i];
if( $graph_x[$i] > $max_x )
$max_x = $graph_x[$i];
if( $graph_y[$i] < $min_y )
$min_y = $graph_y[$i];
if( $graph_y[$i] > $max_y )
$max_y = $graph_y[$i];
$avg_y += $graph_y[$i];
}

$avg_y = $avg_y / $graph_n;
$min_x = 0;
$min_y = 0;
$max_x += $max_x * 0.05;
$max_y += $max_y * 0.05;
$image = ImageCreate($right - $left, $bottom - $top);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 233, 14, 91);
$grey = ImageColorAllocate($image, 204, 204, 204); 
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$red = imagecolorallocate($image, 255, 0, 0);
imagerectangle($image, $left, $top, $right - 1, $bottom - 1, $black );
imagerectangle($image, $x_start, $y_start, $x_end, $y_end, $grey );
for($i = 0; $i < $graph_n; $i++ )
  {
  $pt_x = $x_start + ($x_end-$x_start)*($graph_x[$i]-$min_x)/($max_x-$min_x);
  $pt_y = $y_end - ($y_end - $y_start)*($graph_y[$i]-$min_y)/($max_y-$min_y);
  $rnd_clr=imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
  //imagesetpixel( $image, $pt_x, $pt_y, $rnd_clr);
	//imagechar($image, 2, $pt_x - 3, $pt_y - 10, '.', $rnd_clr);
	imageline($image,$pt_x,$pt_y,$pt_x,$y_end,$rnd_clr);
  }
$string = sprintf("%2.5f", $max_y);
imagestring($image, 4, $x_start - strlen($string) * $char_width, $y_start - $char_width, $string, $black);
$string = sprintf("%2.5f", $min_y);
imagestring($image, 4, $x_start - strlen($string) * $char_width, $y_end - $char_height, $string, $black);
$string = sprintf("%2.5f", $min_x);
imagestring($image, 4, $x_start - (strlen($string) * $char_width)/2, $y_end, $string, $black);

$string = sprintf("%2.5f", $max_x);
imagestring($image, 4, $x_end - (strlen($string) * $char_width) / 2, $y_end, $string, $black);
$x_title = 'x axis';
$y_title = 'y axis';
imagestring($image, 4, $x_start + ($x_end - $x_start) / 2 - strlen($x_title) * $char_width / 2, $y_end, $x_title, $black);
imagestring($image, 4, $char_width, ($y_end - $y_start) / 2, $y_title, $black);
$filename = sprintf("%d.png", time());
ImagePNG($image,$filename);
ImageDestroy($image);
printf("<img src='%s'> ", $filename);
?> 
</body>
</html>