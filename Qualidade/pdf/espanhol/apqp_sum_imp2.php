<?php

$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_sum WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

//$pdf=new FPDF();
$pdf->AddPage();
if($logo=="OK"){
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
}else{
$pdf->Image('../empresa_logo/logo.jpg',5,1,25);
}
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'RESUMEN Y APROBACIÓN DE LA PLANIFICACIÓN DA CALIDAD DEL PRODUCTO ');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(100, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(15,5,"Fecha:");
$pdf->SetXY(115, 18);
$pdf->MultiCell(30,5,banco2data($resp["data"]),0);
$pdf->Line(115,23,145,23);
//linha 2
$pdf->SetXY(5, 30);
$pdf->MultiCell(25,10,"Cliente: ");
$pdf->SetXY(30, 30);
$pdf->MultiCell(70,10,$res["pecacli"],0);
$pdf->Line(30,38,100,38);
$pdf->SetXY(100, 30);
$pdf->MultiCell(30,10,"Nombre de la Pieza: ");
$pdf->SetXY(130, 30);
$pdf->MultiCell(70,10,$res["nome"],0);
$pdf->Line(130,38,195,38);
//linha 3
$pdf->SetXY(5, 42);
$pdf->MultiCell(30,10,"Número de la Pieza: ");
$pdf->SetXY(35, 42);
$pdf->MultiCell(70,10,$res["numero"],0);
$pdf->Line(35,50,100,50);
$pdf->SetXY(100, 42);
$pdf->MultiCell(30,10,"Revisión de la Pieza: ");
$pdf->SetXY(130, 42);
$pdf->MultiCell(70,10,$res["rev"],0);
$pdf->Line(130,50,195,50);
//linha 3
$pdf->SetXY(5, 60);
$pdf->MultiCell(200,15,"");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 60);
$pdf->MultiCell(60,5,"PLAN DE ACCIÓN");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(6, 70);

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

$pdf->MultiCell(200,5,$resp["plano"]);
//fim
//$pdf->Output('Teste.pdf','I');
?>
