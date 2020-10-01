<?php
    error_reporting(E_ALL ^ E_NOTICE);

    $f = new SWFFont(dirname(__FILE__).'/Vera.ttf');
	$mxw=905;$mxh=300;
    $m = new SWFMovie();
    $m->setRate(24.0);
    $m->setDimension($mxw, $mxh);
    $m->setBackground(251, 121, 34);

    // This functions was based on the example from
    // http://ming.sourceforge.net/examples/animation.html

    function text($r, $g, $b, $a, $rot, $x, $y, $scale, $string) {
        global $f, $m;

        $t = new SWFText();
        $t->setFont($f);
        $t->setColor($r, $g, $b, $a);
        $t->setHeight(96);
        $t->moveTo(-($t->getWidth($string)) / 2, 32);
        $t->addString($string);

        $i = $m->add($t);
        $i->rotateTo($rot);
        $i->moveTo($x, $y);
        $i->scale($scale, $scale);

        return $i;
    }

    $colorr[1] = 255 * 0.85;
    $colorg[1] = 255 * 0.85;
    $colorb[1] = 255 * 0.85;

    $colorr[2] = 255 * 0.9;
    $colorg[2] = 255 * 0.9;
    $colorb[2] = 255 * 0.9;

    $colorr[3] = 255 * 0.95;
    $colorg[3] = 255 * 0.95;
    $colorb[3] = 255 * 0.95;

    $colorr[4] = 255;
    $colorg[4] = 255;
    $colorb[4] = 255;

    $c = 1;
    $anz = 4;
    $step = 4 / $anz;

    for ($i = 0; $i < $anz; $i += 1) {
        $x = 1040;
        $y = 50 + $i * 30;
        $size = ($i / 5 + 0.2);
        $t[$i] = text($colorr[$c], $colorg[$c], $colorb[$c], 0xff, 0, $x, $y, $size, 'Hello');
        $c += $step;
    }
	$s=new SWFShape();
 // bug: have to declare all line styles before you use them
 //$s->setLine(40, 0x7f, 0, 0);
 //$s->setLine(40, 0x7f, 0x3f, 0);
 //$s->setLine(40, 0x7f, 0x7f, 0);
 //$s->setLine(40, 0, 0x7f, 0);
 //$s->setLine(40, 0, 0, 0x7f);
 //$s->setRightFill($f1);
	$s->setLine(1, rand(0,255), rand(0,255), rand(0,255));
	$cx=5;
	for($i=0;$i<=$mxh;$i++)
	{
	//$s->setLine(1, rand(0,255), rand(0,255), rand(0,255));	
	$s->movePenTo($cx,$mxh);
   	$s->drawLineTo($cx,$mxh-$i);
	$cx=$cx+3;
	}
	$circle = new SWFShape();
	$circle->movePenTo(50,50);
    $circle->setRightFill(00,66,00);
    $circle->drawCircle(20);
	        $t = new SWFText();
        $t->setFont($f);
        $t->setColor(rand(0,255), rand(0,255), rand(0,255), 0xff);
        $t->setHeight(14);
        $t->moveTo(50-19,50+4);
        $t->addString('8888');
		$m->add($circle);
		$m->add($t);
		$m->add($s);		
    $frames = 300;
 //   for ($j = 0; $j < $frames; $j++) {
  //      for ($i = 0; $i < $anz; $i++) {
  //          $t[$i]->moveTo(260 + round(sin($j / $frames * 2 * pi() + $i) * (50 + 50 * ($i + 1))), 160 + round(sin($j / $frames * 4 * pi() + $i) * (20 + 20 * ($i + 1))));
  //          $t[$i]->rotateTo(round(sin($j / $frames * 2 * pi() + $i / 10) * 360));
   //     }
   //     $m->nextFrame();
    //}

    header('Content-Type: application/x-shockwave-flash');
    $m->output(0);
    exit;
?>
