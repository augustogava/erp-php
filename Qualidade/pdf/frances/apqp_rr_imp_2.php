<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id") or erp_db_fail();
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
if(!empty($car)){
	$s="and car='$car'";
}
$sql=mysql_query("SELECT * FROM apqp_rr WHERE peca='$pc' $s");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_car WHERE id='$resp[car]'");
if(mysql_num_rows($sql)) $resc=mysql_fetch_array($sql);
//pro 2 -
$vart=$resp["prr"];
$tole=@($resp["rr"]/$resc["tol"])*10;
//- - - - 
$cliente=$res["nomecli"];
$peca=$res["pecacli"];
$revi=$res[rev];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$razao=$rese["razao"];
$nome=$res["nome"];
$disp=$resp["dispnu"];
$dispo=$resp["dispno"];
$data=banco2data($resp["dtpor"]);
$num=$res["numero"];
$carac=$resc["descricao"];
$espec=$resc["espec"];
$tol=banco2valor3($resc["tol"]);
$por=$resp["por"];
$ens=completa($resp["ncic"],2);
$ope=completa($resp["nop"],2);
$amo=completa($resp["npc"],2);
$obs=$resp["obs"];
$numero=$res["numero"];

include('pdf/apqp_rr_imp2.php');


$pdf->AddPage();
$pg=2;
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 18, 'Estudo de R&R');
$pdf->SetFont('Arial','',8);
	$pdf->SetXY(180, 5);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 18);
	$pdf->MultiCell(80,5,"Cliente \n $cliente",1);
	$pdf->SetXY(85, 18);
	$pdf->MultiCell(60,5,"Número da Peça (cliente) \n $peca",1);
	$pdf->SetXY(145, 18);
	$pdf->MultiCell(60,5,"Rev. / Data do Desenho \n $rev ",1);
	//linha 2
	$pdf->SetXY(5, 28);
	$pdf->MultiCell(80,5,"Fornecedor\n $razao",1);
	$pdf->SetXY(85, 28);
	$pdf->MultiCell(60,5,"Numero da Peça \n $num",1);
	$pdf->SetXY(145, 28);
	$pdf->MultiCell(60,5,"Revisão da Peça(Fornecedor) \n $revi",1);
	//linha 3
	$pdf->SetXY(5, 38);
	$pdf->MultiCell(80,5,"Nome da Peça \n $nome",1);
	$pdf->SetXY(85, 38);
	$pdf->MultiCell(60,5,"Código do Meio de Medição \n $disp",1);
	$pdf->SetXY(145, 38);
	$pdf->MultiCell(60,5,"Nome do Meio de Medição\n $dispo",1);
	//linha 4
	$pdf->SetXY(5, 48);
	$pdf->MultiCell(40,5,"Caract. Nº \n $num",1);
	$pdf->SetXY(45, 48);
	$pdf->MultiCell(40,5,"Característica \n $carac",1);
	$pdf->SetXY(85, 48);
	$pdf->MultiCell(60,5,"Especificação \n $espec",1);
	$pdf->SetXY(145, 48);
	$pdf->MultiCell(60,5,"Tolerância \n $tol",1);
	//linhs 5
	$pdf->SetXY(5,58);
	$pdf->MultiCell(80,5,"Realizado por \n $por",1);
	$pdf->SetXY(85, 58);
	$pdf->MultiCell(30,5,"Data \n $data",1);
	$pdf->SetXY(115, 58);
	$pdf->MultiCell(30,5,"Nº Ensaios \n $ens",1);
	$pdf->SetXY(145, 58);
	$pdf->MultiCell(30,5,"Nº Operadores \n $ope",1);
	$pdf->SetXY(175, 58);
	$pdf->MultiCell(30,5,"Nº Amostras \n $amo",1);
	//linha 6
	$pdf->SetXY(5, 68);
	$pdf->MultiCell(200,5,"Observações \n $obs",1);
//linha 7
$pdf->SetXY(5, 80);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(205,5,"Médias",0,'C');
$pdf->SetXY(5, 150);
$pdf->MultiCell(205,5,"Amplitudes",0,'C');
//linha 8
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 140);
$num_graf=$resp["id"];
include('pdf/apqp_rr_xbar2.php');
$pdf->Image("imagens_fotos/rr_xgraf$num_graf.png",60,90,100,50);
$pdf->MultiCell(205,5,"% Fora dos limites de controle: ".$resp["mpf"]." X: ".banco2valor3($resp["average"])." LICX: ".banco2valor3($resp["lcl"])." LSCX: ".banco2valor3($resp["uclx"])."",0,'C');
$pdf->SetXY(5, 210);
include('pdf/apqp_rr_rbar2.php');
$pdf->Image("imagens_fotos/rr_rgraf$num_graf.png",60,160,100,50);
$pdf->MultiCell(205,5,"Pontos fora dos limites de controle: ".$resp["apf"]." R: ".banco2valor3($resp["rbar"])." LSCR: ".banco2valor3($resp["uclr"])."",0,'C');
//fim
?>
