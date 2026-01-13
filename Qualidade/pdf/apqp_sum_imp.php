<?php
if(empty($tira)){
include('../conecta.php');
require('fpdf.php');}

$pc=$_GET["pc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_sum WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

if(empty($tira)){$pdf=new FPDF();}
$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'Sumário de Aprovação do Planejamento da Qualidade do Produto ');
$pdf->SetXY(5, 18);
$pdf->SetXY(100, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(15,5,"Data:");
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
$pdf->MultiCell(25,10,"Nome da peça: ");
$pdf->SetXY(125, 30);
$pdf->MultiCell(70,10,$res["nome"],0);
$pdf->Line(125,38,195,38);
//linha 3
$pdf->SetXY(5, 42);
$pdf->MultiCell(25,10,"Número da peça: ");
$pdf->SetXY(30, 42);
$pdf->MultiCell(70,10,$res["numero"],0);
$pdf->Line(30,50,100,50);
$pdf->SetXY(100, 42);
$pdf->MultiCell(25,10,"Revisão da Peça: ");
$pdf->SetXY(125, 42);
$pdf->MultiCell(70,10,$res["rev"],0);
$pdf->Line(125,50,195,50);
//linha 4
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 51);
$pdf->MultiCell(100,5,"1. ESTUDO PRELIMINAR DA CAPABILIDADE DO PROCESSO ");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 51);
$pdf->MultiCell(30,5,"QUANTIDADE");
$pdf->SetXY(105, 56);
$pdf->MultiCell(30,5,"REQUERIDA",1);
$pdf->SetXY(135, 56);
$pdf->MultiCell(30,5,"ACEITÁVEL",1);
$pdf->SetXY(165, 56);
$pdf->MultiCell(30,5,"PENDENTE*",1);
$pdf->SetXY(105, 61);
$pdf->MultiCell(30,5,$resp["ppk_req"],1);
$pdf->SetXY(135, 61);
$pdf->MultiCell(30,5,$resp["ppk_ace"],1);
$pdf->SetXY(165, 61);
$pdf->MultiCell(30,5,$resp["ppk_pen"],1);
$pdf->SetXY(6, 61);
$pdf->MultiCell(100,5,"Ppk - CARACTERÍSTICAS ESPECIAIS");
//linha 4
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 67);
$pdf->MultiCell(100,5,"2. APROVAÇÃO DO PLANO DE CONTROLE (SE REQUERIDO) ");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 67);
if($resp["pca"]=="1"){ $msg="Sim"; }else{ $msg="Não"; }
$pdf->MultiCell(15,5,"Aprovado:");
$pdf->SetXY(120, 67);
$pdf->MultiCell(20,5,$msg);
$pdf->Line(120,72,140,72);
$pdf->SetXY(140, 67);

$pdf->MultiCell(30,5,"Data Da Aprovação:");
$pdf->SetXY(170, 77);
$pdf->MultiCell(20,5,banco2data($resp["pca_dt"]));
$pdf->Line(170,72,190,72);
//linha 5
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 79);
$pdf->MultiCell(100,5,"3. CATEGORIA DAS CARACTERÍSTICAS DA AMOSTRA INICIAL DA PRODUÇÃO");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 79);
$pdf->MultiCell(30,5,"QUANTIDADE");
$pdf->SetXY(105, 84);
$pdf->MultiCell(22.5,5,"AMOSTRAS",1);
$pdf->SetXY(127.5, 84);
$pdf->MultiCell(22.5,5,"CARACT/",1);
$pdf->SetXY(150, 84);
$pdf->MultiCell(22.5,5,"ACEITÁVEL",1);
$pdf->SetXY(172.5, 84);
$pdf->MultiCell(22.5,5,"PENDENTE*",1);
	//linha 1
	$pdf->SetXY(105, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_amo"],1);
	$pdf->SetXY(127.5, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_car"],1);
	$pdf->SetXY(150, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_ace"],1);
	$pdf->SetXY(172.5, 89);
	$pdf->MultiCell(22.5,5,$resp["dim_pen"],1);
	//linha 2
	$pdf->SetXY(105, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	$pdf->SetXY(127.5, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	$pdf->SetXY(150, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	$pdf->SetXY(172.5, 94);
	$pdf->MultiCell(22.5,5,$resp["vis_amo"],1);
	//linha 3
	$pdf->SetXY(105, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	$pdf->SetXY(127.5, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	$pdf->SetXY(150, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	$pdf->SetXY(172.5, 99);
	$pdf->MultiCell(22.5,5,$resp["lab_amo"],1);
	//linha 4
	$pdf->SetXY(105, 104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(127.5, 104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(150, 104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(172.5,104);
	$pdf->MultiCell(22.5,5,$resp["des_amo"],1);
	$pdf->SetXY(6, 89);
$pdf->MultiCell(100,5,"DIMENSIONAL \n VISUAL \n LABORATÓRIO \n DESEMPENHO");
//linha 6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 111);
$pdf->MultiCell(100,5,"4. ANÁLISE DO SISTEMA DE MEDIÇÃO DE DISPOSITIVOS E INSTRUMENTOS");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 111);
$pdf->MultiCell(30,5,"QUANTIDADE");
$pdf->SetXY(105, 116);
$pdf->MultiCell(30,5,"REQUERIDA",1);
$pdf->SetXY(135, 116);
$pdf->MultiCell(30,5,"ACEITÁVEL",1);
$pdf->SetXY(165, 116);
$pdf->MultiCell(30,5,"PENDENTE*",1);
$pdf->SetXY(105, 121);
$pdf->MultiCell(30,5,$resp["care_req"],1);
$pdf->SetXY(135, 121);
$pdf->MultiCell(30,5,$resp["care_ace"],1);
$pdf->SetXY(165, 121);
$pdf->MultiCell(30,5,$resp["care_pen"],1);
$pdf->SetXY(6, 121);
$pdf->MultiCell(100,5,"CARACTERÍSTICA ESPECIAL");
//linha 7
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 128);
$pdf->MultiCell(100,5,"5. MONITORAMENTO DO PROCESSO");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 128);
$pdf->MultiCell(30,5,"QUANTIDADE");
$pdf->SetXY(105, 133);
$pdf->MultiCell(30,5,"REQUIRIDA",1);
$pdf->SetXY(135, 133);
$pdf->MultiCell(30,5,"ACEITÁVEL",1);
$pdf->SetXY(165, 133);
$pdf->MultiCell(30,5,"PENDENTE*",1);
	//linha 1
	$pdf->SetXY(105, 138);
	$pdf->MultiCell(30,5,$resp["instm_req"],1);
	$pdf->SetXY(135, 138);
	$pdf->MultiCell(30,5,$resp["instm_ace"],1);
	$pdf->SetXY(165, 138);
	$pdf->MultiCell(30,5,$resp["instm_pen"],1);
	//linha 2
	$pdf->SetXY(105, 143);
	$pdf->MultiCell(30,5,$resp["folha_req"],1);
	$pdf->SetXY(135, 143);
	$pdf->MultiCell(30,5,$resp["folha_ace"],1);
	$pdf->SetXY(165, 143);
	$pdf->MultiCell(30,5,$resp["folha_pen"],1);
	//linha 3
	$pdf->SetXY(105, 148);
	$pdf->MultiCell(30,5,$resp["instv_req"],1);
	$pdf->SetXY(135, 148);
	$pdf->MultiCell(30,5,$resp["instv_ace"],1);
	$pdf->SetXY(165, 148);
	$pdf->MultiCell(30,5,$resp["instv_pen"],1);
$pdf->SetXY(6, 138);
$pdf->MultiCell(105,5,"INSTRUÇÕES DE MONITORAMENTO \n FOLHAS DE PROCESSO \n INSTRUÇÕES VISUAIS ");
//linha 8
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 155);
$pdf->MultiCell(100,5,"6. EMBALAGEM / EXPEDIÇÃO");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140, 155);
$pdf->MultiCell(30,5,"QUANTIDADE");
$pdf->SetXY(105, 160);
$pdf->MultiCell(30,5,"REQUIRIDA",1);
$pdf->SetXY(135, 160);
$pdf->MultiCell(30,5,"ACEITÁVEL",1);
$pdf->SetXY(165, 160);
$pdf->MultiCell(30,5,"PENDENTE*",1);
	//linha 1
	$pdf->SetXY(105, 165);
	$pdf->MultiCell(30,5,$resp["apro_req"],1);
	$pdf->SetXY(135, 165);
	$pdf->MultiCell(30,5,$resp["apro_ace"],1);
	$pdf->SetXY(165, 165);
	$pdf->MultiCell(30,5,$resp["apro_pen"],1);
	//linha 2
	$pdf->SetXY(105, 170);
	$pdf->MultiCell(30,5,$resp["teste_req"],1);
	$pdf->SetXY(135, 170);
	$pdf->MultiCell(30,5,$resp["teste_ace"],1);
	$pdf->SetXY(165, 170);
	$pdf->MultiCell(30,5,$resp["teste_pen"],1);
$pdf->SetXY(6, 165);
$pdf->MultiCell(100,5,"APROVAÇÃO DA EMBALAGEM \n TESTE DE ENTREGA");
//linha 9
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6, 177);
$pdf->MultiCell(100,5,"7. APROVAÇÃO");
$pdf->SetFont('Arial','',8);
	//coluna 1
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(6, 182);
	$pdf->MultiCell(94,5,$resp["ap1"]." / ".banco2data($resp["dap1"]));
	$pdf->Line(6,187,96,187);
	$pdf->SetXY(5, 188);
	$pdf->MultiCell(100,5,"Membro da Equipe / Cargo / Data ");
	$pdf->SetXY(6, 193);
	$pdf->MultiCell(94,5,$resp["ap3"]." / ".banco2data($resp["dap3"]));
	$pdf->Line(6,198,96,198);
	$pdf->SetXY(5, 199);
	$pdf->MultiCell(100,5,"Membro da Equipe / Cargo / Data ");
	$pdf->SetXY(6, 206);
	$pdf->MultiCell(94,5,$resp["ap5"]." / ".banco2data($resp["dap5"]));
	$pdf->Line(6,211,96,211);
	$pdf->SetXY(5, 212);
	$pdf->MultiCell(100,5,"Membro da Equipe / Cargo / Data ");
	//coluna 2
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(106, 182);
	$pdf->MultiCell(94,5,$resp["ap2"]." / ".banco2data($resp["dap2"]));
	$pdf->Line(106,187,196,187);
	$pdf->SetXY(105, 188);
	$pdf->MultiCell(100,5,"Membro da Equipe / Cargo / Data ");
	$pdf->SetXY(106, 193);
	$pdf->MultiCell(94,5,$resp["ap4"]." / ".banco2data($resp["dap4"]));
	$pdf->Line(106,198,196,198);
	$pdf->SetXY(105, 199);
	$pdf->MultiCell(100,5,"Membro da Equipe / Cargo / Data ");
	$pdf->SetXY(106, 206);
	$pdf->MultiCell(94,5,$resp["ap6"]." / ".banco2data($resp["dap6"]));
	$pdf->Line(106,211,196,211);
	$pdf->SetXY(105, 212);
	$pdf->MultiCell(100,5,"Membro da Equipe / Cargo / Data ");

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

if(!empty($resp["plano"])){
	include('apqp_sum_imp2.php');
}

	
$pdf->Output('apqp_sum_imp.pdf','I');
?>
