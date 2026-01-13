<?php
//include('../../conecta.php');
//require('fpdf.php');

//$pc=$_SESSION["mpc"];
//$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

// desenvolvedor
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

//$pdf=new FPDF();
$pdf->AddPage();
$pg++;

// desenvolvedor
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

if($logo=="OK"){
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
}else{
$pdf->Image('../empresa_logo/logo.jpg',5,1,25);
}
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'ENGAGEMENT COLLETIF DE FAISABILITÉ');
$pdf->SetXY(100, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(15,5,"DatE:");
$pdf->SetXY(115, 18);
$pdf->MultiCell(30,5,banco2data($resp["data"]),0);
$pdf->Line(115,23,145,23);
$pdf->SetXY(180, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n PAGE: $pg");
$pdf->SetFont('Arial','',8);
//linha 2
$pdf->SetXY(5, 30);
$pdf->MultiCell(25,10,"Client: ");
$pdf->SetXY(30, 30);
$pdf->MultiCell(70,10,$res["pecacli"],0);
$pdf->Line(30,38,100,38);
$pdf->SetXY(100, 30);
$pdf->MultiCell(25,10,"Nom de Piéce: ");
$pdf->SetXY(125, 30);
$pdf->MultiCell(70,10,$res["nome"],0);
$pdf->Line(125,38,195,38);
//linha 3
$pdf->SetXY(5, 42);
$pdf->MultiCell(25,10,"Numéro de Píece: ");
$pdf->SetXY(30, 42);
$pdf->MultiCell(70,10,$res["numero"],0);
$pdf->Line(30,50,145,50);
$pdf->SetXY(100, 42);
$pdf->MultiCell(25,10,"Revision Piéce: ");
$pdf->SetXY(125, 42);
$pdf->MultiCell(70,10,$res["rev"],0);
$pdf->Line(125,50,195,50);
//linha 4
$pdf->SetXY(5, 54);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(100,10,"Explications / Commentaires");
//linha 5
$pdf->SetXY(5, 60);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,10,"Conforme a solicitação de alteração em anexo");
//linha 6
$pdf->SetXY(5, 70);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(200,5,$resp["obs"]);

//fim
//$pdf->Output('apqp_viabilidade_imp2.pdf','I');;
?>
