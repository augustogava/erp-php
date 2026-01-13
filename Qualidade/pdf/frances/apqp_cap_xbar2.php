<?php
$sql=mysql_query("SELECT * FROM apqp_cap WHERE id='$num_graf'");
$res=mysql_fetch_array($sql);
// Some data
for($i=1;$i<=$res["nli"];$i++){
	$datay_x[]=$res["xbar"];
	$data2y_x[]=$res["x".$i];
	$data3y_x[]=$res["lcl"];
	$data4y_x[]=$res["uclx"];
	$databarx_x[]=$i;
}
//$datay = array($res["average"],$res["average"],$res["average"],$res["average"],$res["average"],$res["average"],$res["average"],$res["average"],$res["average"],$res["average"]);
//$data2y = array(9.317,9.683,9.350,9.297,'','',9.597,9.333,9.669,9.557);
//$data3y = array($res["lcl"],$res["lcl"],$res["lcl"],$res["lcl"],$res["lcl"],$res["lcl"],$res["lcl"],$res["lcl"],$res["lcl"],$res["lcl"]);
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

$graph->xaxis->SetTickLabels($databarx_x);

// Use built in font
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Slightly adjust the legend from it's default position in the
// top right corner. 
//$graph->legend->Pos(0.05,0.5,"right","center");

// Create the first line
$p1 = new LinePlot($datay_x);
$p1->SetColor("green");
$p1->SetCenter();
$graph->Add($p1);

// ... and the second
$p2 = new LinePlot($data2y_x);
$p2->mark->SetType(MARK_FILLEDCIRCLE);
$p2->mark->SetFillColor("red");
$p2->mark->SetWidth(3);
$p2->SetColor("black");
$p2->SetCenter();
$graph->Add($p2);

// Create the 3 line
$p3 = new LinePlot($data3y_x);
$p3->SetColor("red");
$p3->SetCenter();
$graph->Add($p3);

// Create the 4 line
$p4 = new LinePlot($data4y_x);
$p4->SetColor("blue");
$p4->SetCenter();
$graph->Add($p4);
// Output line
$graph->Stroke("imagens_fotos/xgraf$num_graf.png");
?>