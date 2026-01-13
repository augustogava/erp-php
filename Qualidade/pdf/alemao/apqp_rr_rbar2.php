<?php
$sql_r=mysql_query("SELECT * FROM apqp_rr WHERE id='$resp[id]'");
$res_r=mysql_fetch_array($sql_r);
// Some data
for($i=1;$i<=$res_r["nop"];$i++){
	for($j=1;$j<=$res_r["npc"];$j++){
		$datay_r[]=$res_r["uclr"];
		$data3y_r[]=$res_r["rbar"];
		if($i==1) $lbl="a";
		if($i==2) $lbl="b";
		if($i==3) $lbl="c";
		$databarx_r[]=$lbl.$j;
		$data2y_r[]=$res_r["r".$lbl.$j];
	}
	$datay_r[]=$res_r["uclr"];
	$data3y_r[]=$res_r["rbar"];
	$databarx[_r]="";
	$data2y_r[]="";
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

$graph->xaxis->SetTickLabels($databarx_r);

// Use built in font
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Slightly adjust the legend from it's default position in the
// top right corner. 
//$graph->legend->Pos(0.05,0.5,"right","center");

// Create the first line
$p1 = new LinePlot($datay_r);
$p1->SetColor("blue");
$p1->SetCenter();
$graph->Add($p1);

// ... and the second
$p2 = new LinePlot($data2y_r);
$p2->mark->SetType(MARK_FILLEDCIRCLE);
$p2->mark->SetFillColor("red");
$p2->mark->SetWidth(3);
$p2->SetColor("black");
$p2->SetCenter();
$graph->Add($p2);

// Create the 3 line
$p3 = new LinePlot($data3y_r);
$p3->SetColor("red");
$p3->SetCenter();
$graph->Add($p3);


// Output line
$graph->Stroke("imagens_fotos/rr_rgraf$num_graf.png");
?>