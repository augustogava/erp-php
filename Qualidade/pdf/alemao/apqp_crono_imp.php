<?php
if(empty($tira)){
include('../../conecta.php');
require('fpdf.php');}
if(empty($tira)){$pdf=new FPDF('L');}
$pc=$_GET["pc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)){
	$rese=mysql_fetch_array($sql);
}
$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 18, 'CRONOGRAMA DO PLANEJAMENTO AVANÇADO DA QUALIDADE');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(50,5,"Número da peça (cliente)\n $res[pecacli]",1);
$pdf->SetXY(55, 18);
$pdf->MultiCell(50,5,"Rev. / Data do Desenho\n $res[rev] - ".banco2data($res["dtrev"])."",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(80,5,"Nome da Peça \n $res[nome]",1);
$pdf->SetXY(185, 18);
$pdf->MultiCell(75,5,"Cliente\n $res[nomecli]",1);
$pdf->SetXY(260, 18);
$pdf->MultiCell(30,5,"Página\n1 de 1",1);
$pdf->SetXY(5, 28);
$pdf->MultiCell(100,5,"Fornecedor\n $rese[razao]",1);
$pdf->SetXY(105, 28);
$pdf->MultiCell(80,5,"Número/Rev. Peça (fornecedor) \n $res[numero] - $res[rev]",1);
$pdf->SetXY(185, 28);
$pdf->MultiCell(75,5,"Aprovado por  \n $res[crono_quem]",1);
$pdf->SetXY(260, 28);
$pdf->MultiCell(30,5,"Data \n ".banco2data($res["crono_dtquem"])."",1);
$pdf->SetXY(5, 45);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(90,5,'Atividade',1,1,'C');
$pdf->SetXY(95, 45);
$pdf->Cell(45,5,'Responsável',1,1,'C');
$pdf->SetXY(140, 45);
$pdf->Cell(20,5,'Início',1,1,'C');
$pdf->SetXY(160, 45);
$pdf->Cell(20,5,'Prazo',1,1,'C');
$pdf->SetXY(180, 45);
$pdf->Cell(20,5,'Fim',1,1,'C');
$pdf->SetXY(200, 45);
$pdf->Cell(25,5,'% Completo',1,1,'C');
$pdf->SetXY(225, 45);
$pdf->Cell(65,5,'Observações',1,1,'C');
$pdf->SetFont('Arial','',8);
$i=50;
$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($i>=180){
			$i=5;
			$pdf->AddPage();
		}
		$pdf->SetXY(5, $i);
		$pdf->Cell(90,5,$res["ativ"],1,1);
		$pdf->SetXY(95, $i);
		$pdf->Cell(45,5,$res["resp"],1,1);
		$pdf->SetXY(140, $i);
		$pdf->Cell(20,5,banco2data($res["ini"]),1,1,'C');
		$pdf->SetXY(160, $i);
		$pdf->Cell(20,5,banco2data($res["prazo"]),1,1,'C');
		$pdf->SetXY(180, $i);
		$pdf->Cell(20,5,banco2data($res["fim"]),1,1,'C');
		$pdf->SetXY(200, $i);
		$pdf->Cell(25,5,$res["perc"],1,1,'C');
		$pdf->SetXY(225, $i);
		$pdf->Cell(65,5,$res["obs"],1,1);
		$i=$i+5;
	}
}
$pdf->Line(5,185,290,185);
$pdf->Line(5,50,5,185);
$pdf->Line(95,50,95,185);
$pdf->Line(140,50,140,185);
$pdf->Line(160,50,160,185);
$pdf->Line(180,50,180,185);
$pdf->Line(200,50,200,185);
$pdf->Line(225,50,225,185);
$pdf->Line(290,50,290,185);

if(empty($tira)){
$pdf->Output('apqp_crono_imp.pdf','I');
}

?>
