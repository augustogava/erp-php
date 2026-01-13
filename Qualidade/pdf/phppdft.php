<?php
include("../conecta.php");
require('fpdf.php');
$pdf=new FPDF();  // nova função pdf dinâmica
$pdf->AddPage();  // funçao adiciona uma página

$pdf->SetFont('Arial','B',10);   // (fonte,tipo,tamanho)
$pdf->SetXY(5,10); // posiciona os próximos comandos, entre eles multicell 
$pdf->MultiCell(200,265,"",1);  // desenha uma caixa (w,h,texto,borda,alinhamento texto), neste caso a borda lateral da página 



$pdf->AddPage('L');  // funçao adiciona uma página


$pdf->Output('apqp_sub_imp.pdf','I');
?>