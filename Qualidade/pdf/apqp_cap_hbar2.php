<?php
if($tipo=="msa"){
	$sql=mysql_query("SELECT * FROM msa_cap WHERE id='$num_graf'");
}else{
	$sql=mysql_query("SELECT * FROM apqp_cap WHERE id='$num_graf'");
}
$res=mysql_fetch_array($sql);
$datay_h="";
$data2y_h="";
for($i=1;$i<=7;$i++){
//barra
	$datay_h[]=$res["h".$i];
//linha
	$data2y_h[]=$res["hp".$i];
}

// Create the graph. These two calls are always required
$graph = new Graph(571,250,"auto");
$graph->img->SetMargin(40,30,20,40);
$graph->SetScale("textlin");
$graph->SetY2Scale("lin");

// Create a bar pot
$bplot = new BarPlot($datay_h);
$bplot->SetWidth(1.0);
$bplot->SetFillColor('green');

// Create the 3 line
$p3 = new LinePlot($data2y_h);
$p3->mark->SetType(MARK_FILLEDCIRCLE);
$p3->mark->SetFillColor("red");
$p3->mark->SetWidth(3);
$p3->SetColor("red");
$graph->AddY2($bplot);
$graph->Add($p3);

$graph->yaxis->SetColor("red");
$graph->y2axis->SetColor("black");

// Display the graph
$graph->Stroke("imagens_fotos/hgraf$num_graf.png");
?>
