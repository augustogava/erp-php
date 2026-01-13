<?php
$pc=7;
include('../../cybermanager/conecta.php');
require('fpdf.php');

$pdf=new FPDF('L');
$pdf->AddPage();
$pdf->Image('logo.png',5,1,25);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 0, 'CRONOGRAMA DO PLANEJAMENTO AVANÇADO DA QUALIDADE');
$pdf->Ln(10);
// $pdf->Line(X1,Y1,X2,Y2)

//linha horizontal Cima
$pdf->Line(10,20,280,20);
//LInha esquerda
$pdf->Line(10,20,10,40);
//linha horizontal meio
$pdf->Line(10,30,280,30);
//linha direita
$pdf->Line(280,20,280,40);
//linha horizontal baixo
$pdf->Line(10,40,280,40);

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,5,'Número da peça (cliente)');
//linha 1
$pdf->Line(60,20,60,30);
$pdf->Cell(50,5,'Rev. / Data do Desenho');
//linha 2
$pdf->Line(110,20,110,40);
$pdf->Cell(80,5,'Nome da Peça ');
//linha 3
$pdf->Line(190,20,190,40);
$pdf->Cell(60,5,'Cliente ');
//linha 4
$pdf->Line(250,20,250,40);
$pdf->Cell(30,5,'Página ');
$pdf->Ln();
$pdf->Cell(50,5,'145/32');
$pdf->Cell(50,5,'0 - 21/03/2005');
$pdf->Cell(80,5,'Tampa p/ Conj Embal ');
$pdf->Cell(60,5,'Industria ABC ');
$pdf->Cell(30,5,'1 de 1 ');
$pdf->Ln();
$pdf->Cell(100,5,'Fornecedor');
$pdf->Cell(80,5,'Número/Rev. Peça (fornecedor)');
$pdf->Cell(60,5,'Aprovado por');
$pdf->Cell(30,5,'Data');
$pdf->Ln();
$pdf->Cell(100,5,'Feeder SA');
$pdf->Cell(80,5,'0703 - 0');
$pdf->Cell(60,5,'');
$pdf->Cell(30,5,'');

$pdf->Ln(10);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(80,5,'Atividade',1,'','C');
$pdf->Cell(50,5,'Responsável',1,'','C');
$pdf->Cell(20,5,'Início',1,'','C');
$pdf->Cell(20,5,"Prazo",1,'','C');
$pdf->Cell(20,5,'Fim',1,'','C');
$pdf->Cell(30,5,'% Completo',1,'','C');
$pdf->Cell(50,5,'Observações',1,'','C');
$pdf->Ln();

$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
$pdf->SetFont('Arial','','8');
$pdf->Cell(80,5,$res["ativ"],1,'');
$pdf->Cell(50,5,$res["resp"],1,'');
$pdf->Cell(20,5,banco2data($res["ini"]),1,'','C');
$pdf->Cell(20,5,banco2data($res["prazo"]),1,'','C');
$pdf->Cell(20,5,banco2data($res["fim"]),1,'','C');
$pdf->Cell(30,5,banco2valor($res["perc"]),1,'','R');
$pdf->Cell(50,5,$res["obs"],1,'');
$pdf->Ln();
	}
}
$pdf->Output();
?>
