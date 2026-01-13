<?php
include('../../conecta.php');
require('fpdf.php');
include ("../../classes/jpgraph/jpgraph.php");
include ("../../classes/jpgraph/jpgraph_line.php");
include ("../../classes/jpgraph/jpgraph_bar.php");
$pdf=new FPDF();

if(!empty($car)){
	$s="and car='$car'";
}
$pc=$_GET["pc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_cap WHERE peca='$pc' $s");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_car WHERE id='$resp[car]'");
if(mysql_num_rows($sql)) $resc=mysql_fetch_array($sql);
$ops=mysql_query("SELECT * FROM apqp_op WHERE id='$resp[ope]'");
$rops=mysql_fetch_array($ops);
$ope=htmlspecialchars($rops["numero"], ENT_QUOTES)." - ".htmlspecialchars($rops["descricao"], ENT_QUOTES);
include("apqp_cap_imp3.php");

$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 18, 'ESTUDO DE CAPABILIDADE');
$pdf->SetXY(180, 8);
$pdf->SetFont('Arial','',8);
/*$cliente=$res["nomecli"];
$peca=$res["pecacli"];
$rev=$res[rev]." - ".banco2data($res["dtrev"]);
$razao=$rese["razao"];
$nome=$res["nome"];
$quem=$resp["quem"];
$data=banco2data($resp["dtquem"]);
$num=$resc["numero"];
$desc=$resc["descricao"];
$espec=$resc["espec"];
$lie=banco2valor3($resc["lie"]);
$lse=banco2valor3($resc["lse"]);
$obs=$resp["obs"];
$tam=completa(5,2);
$qtd=completa($resp["nli"],2);*/

$pdf->SetXY(180, 8);
$pg=$pdf->PageNo();
$pdf->MultiCell(65,5,"Página: $pg");
$pdf->SetXY(5, 18);
$pdf->MultiCell(100,4,"Cliente \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 22);
$pdf->MultiCell(100,4,$cliente,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,4,"Número da Peça (cliente) \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 22);
$pdf->MultiCell(100,4,$peca,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,4,"Rev. / Data do Desenho \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 22);
$pdf->MultiCell(100,4,$rev,0);
//linha 2
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 26);
$pdf->MultiCell(100,4,"Fornecedor \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 30);
$pdf->MultiCell(100,4,$razao,0);
$pdf->SetXY(105, 26);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(50,4,"Número da Peça \n ",1);
$pdf->SetXY(105, 30);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,4,$numero,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 26);
$pdf->MultiCell(50,4,"Revisão da Peça \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 30);
$pdf->MultiCell(100,4,$rev1,0);
//linha 3
$pdf->SetXY(5, 34);
$pdf->MultiCell(100,4,"Nome da Peça \n ",1);
$pdf->SetXY(5, 38);
$pdf->MultiCell(100,4,$nome,0);
$pdf->SetXY(105, 34);
$pdf->MultiCell(100,4,"Número / Descrição da Operação \n ",1);
$pdf->SetXY(105, 38);
$pdf->MultiCell(100,4,$ope,0);
//linha 4
$pdf->SetXY(5, 42);
$pdf->MultiCell(15,4,"Caract Nº \n ",1);
$pdf->SetXY(5, 46);
$pdf->MultiCell(15,4,$num,0);
$pdf->SetXY(20, 42);
$pdf->MultiCell(30,4,"Característica \n ",1);
$pdf->SetXY(20, 46);
$pdf->MultiCell(30,4,$desc,0);
$pdf->SetXY(50, 42);
$pdf->MultiCell(105,4,"Especificação \n ",1);
$pdf->SetXY(50, 46);
$pdf->MultiCell(105,4,$espec,0);
$pdf->SetXY(155, 42);
$pdf->MultiCell(25,4,"LIE \n ",1);
$pdf->SetXY(155, 46);
$pdf->MultiCell(25,4,$lie,0);
$pdf->SetXY(180, 42);
$pdf->MultiCell(25,4,"LSE \n ",1);
$pdf->SetXY(180, 46);
$pdf->MultiCell(25,4,$lse,0);
//linha 5
$pdf->SetXY(5, 50);
$pdf->MultiCell(100,4,"Realizado por \n ",1);
$pdf->SetXY(5, 54);
$pdf->MultiCell(100,4,$por,0);
$pdf->SetXY(105, 50);
$pdf->MultiCell(30,4,"Data \n ",1);
$pdf->SetXY(105, 54);
$pdf->MultiCell(100,4,$dtpor,0);
$pdf->SetXY(135, 50);
$pdf->MultiCell(40,4,"Tamanho do Subgrupo \n ",1);
$pdf->SetXY(135, 54);
$pdf->MultiCell(100,4,$tam,0);
$pdf->SetXY(175, 50);
$pdf->MultiCell(30,4,"Qtd. de Grupos \n ",1);
$pdf->SetXY(175, 54);
$pdf->MultiCell(100,4,$qtd,0);
//linha 6
$pdf->SetXY(5, 58);
$pdf->MultiCell(200,4,"Observações \n ",1);
$pdf->SetXY(5, 62);
$pdf->MultiCell(100,4,$obs,0);
//linha 6
$pdf->SetXY(5, 70);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(205,5,"Médias",0,'C');
$pdf->SetXY(5, 145);
$pdf->MultiCell(205,5,"Amplitudes",0,'C');
$pdf->SetXY(5, 215);
$pdf->MultiCell(205,5,"Histograma",0,'C');
//linha 7
$pdf->SetFont('Arial','B',8);
//gerando os graficos
$num_graf=$resp["id"];
include('apqp_cap_xbar.php');
$pdf->Image("../../imagens_fotos/xgraf$num_graf.png",60,75,100,60);
$pdf->SetXY(5, 135);
$pdf->MultiCell(205,5,"X:".banco2valor3($resp["xbar"])."  LICX:".banco2valor3($resp["lcl"])."   LSCX:".banco2valor3($resp["uclx"])."",0,'C');
include('apqp_cap_rbar.php');
$pdf->Image("../../imagens_fotos/rgraf$num_graf.png",60,150,100,60);
$pdf->SetXY(5, 210);
$pdf->MultiCell(205,5,"R:".banco2valor3($resp["rmax"]-$resp["rmin"])."  LSCR:".banco2valor3($resp["uclr"])."",0,'C');
include('apqp_cap_hbar.php');
$pdf->Image("../../imagens_fotos/hgraf$num_graf.png",60,220,100,60);


if(empty($tira)){
$pdf->Output('apqp_cap.pdf','I');
}
?>
