<?php
$sql=mysql_query("SELECT * FROM apqp_cap WHERE id='$num_graf'");
$resrbar=mysql_fetch_array($sql);
// Some data
for($i=1;$i<=$resrbar["nli"];$i++){
	$datay_y[]=$resrbar["uclr"];
	$data2y_y[]=$resrbar["r".$i];
	$data3y_y[]=$resrbar["rbar"];
	$databarx_y[]=$i;
}
//$datay = array($resrbar["average"],$resrbar["average"],$resrbar["average"],$resrbar["average"],$resrbar["average"],$resrbar["average"],$resrbar["average"],$resrbar["average"],$resrbar["average"],$resrbar["average"]);
//$data2y = array(9.317,9.683,9.350,9.297,'','',9.597,9.333,9.669,9.557);
//$data3y = array($resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"],$resrbar["lcl"]);
//$databarx=array("$j","a2","a3","a4","a5","a6","a7","a8","a9","a10");
// A nice graph with anti-aliasing
$graph = new Graph(571,250,"auto");
$graph->img->SetMargin(50,20,10,30);	
//$graph->SetBackgroundImage("tiger_bkg.png",BGIMG_FILLPLOT);

// Adjust brightness and contrast for background image
// must be between -1 <= x <= 1, (0,0)=original image
$graph->AdjBackgroundImage(0,0);

$graph->img->SetAntiAliasing("white");

$graph->SetScale("textlin");
//$graph->SetShadow();
//$graph->title->Set("Background image");

$graph->xaxis->SetTickLabels($databarx_y);

// Use built in font
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Slightly adjust the legend from it's default position in the
// top right corner. 
//$graph->legend->Pos(0.05,0.5,"right","center");

// Create the first line
$p1 = new LinePlot($datay_y);
$p1->SetColor("blue");
$p1->SetCenter();
$graph->Add($p1);

// ... and the second
$p2 = new LinePlot($data2y_y);
$p2->mark->SetType(MARK_FILLEDCIRCLE);
$p2->mark->SetFillColor("red");
$p2->mark->SetWidth(3);
$p2->SetColor("black");
$p2->SetCenter();
$graph->Add($p2);

// Create the 3 line
$p3 = new LinePlot($data3y_y);
$p3->SetColor("red");
$p3->SetCenter();
$graph->Add($p3);


// Output line
$graph->Stroke("../../imagens_fotos/rgraf$num_graf.png");
?>