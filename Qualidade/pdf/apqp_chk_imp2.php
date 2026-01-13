<?php
if($email=="sim"){
include("../conecta.php");
require('fpdf.php');
}
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
switch($anexo){
	case 1: $anexo2="FMEA de Projeto"; break;
	case 2: $anexo2="Informações do Projeto"; break;
	case 3: $anexo2="Novos Equipamentos, Ferramental e Equipamentos de Teste"; break;
	case 4: $anexo2="Qualidade do Produto / Processo"; break;
	case 5: $anexo2="Instalações"; break;
	case 6: $anexo2="Fluxograma de Processo"; break;
	case 7: $anexo2="FMEA de Processo"; break;
	case 8: $anexo2="Plano de Controle"; break;
}
$y=50;
$pecacli=$res["pecacli"];
$rev=$res["rev"];
$nome=$res["nome"];
$nomecli=$res["nomecli"];
$razao=$rese["razao"];
$num=$res["numero"]." - ".$res["rev"];
$quem=$resp["quem"];
$numero=$res["numero"];
$dtquem=banco2data($resp["dtquem"]);
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$pg=1;
$pdf->AddPage('L');
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(50, 7);
$pdf->MultiCell(200,5,"Lista de Verificação do APQP - A$anexo - $anexo2",0,'C');
$pdf->SetXY(260, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(60,5,"Número da Peça (cliente) \n $pecacli",1);
$pdf->SetXY(65, 18);
$pdf->MultiCell(60,5,"Rev. / Data do Desenho \n $rev",1);
$pdf->SetXY(125, 18);
$pdf->MultiCell(80,5,"Nome da Peça \n $nome",1);
$pdf->SetXY(205, 18);
$pdf->MultiCell(85,5,"Cliente \n $nomecli",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(120,5,"Fornecedor \n $razao",1);
$pdf->SetXY(125, 28);
$pdf->MultiCell(80,5,"Número/Rev. Peça (fornecedor) \n $num",1);
$pdf->SetXY(205, 28);
$pdf->MultiCell(60,5,"Aprovado por  \n $quem",1);
$pdf->SetXY(265, 28);
$pdf->MultiCell(25,5,"Data \n $dtquem",1);
//linha 3		
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 40);
$pdf->MultiCell(130,10,"Pergunta",1,'C');
$pdf->SetXY(135, 40);
$pdf->MultiCell(10,10,"Sim",1,'C');
$pdf->SetXY(145, 40);
$pdf->MultiCell(10,10,"Não",1,'C');
$pdf->SetXY(155, 40);
$pdf->MultiCell(60,10,"Comentários / Ação Requerida ",1,'C');
$pdf->SetXY(215, 40);
$pdf->MultiCell(45,10,"Responsável",1,'C');
$pdf->SetXY(260, 40);
$pdf->MultiCell(30,10,"Data Prevista ",1,'C');

//linha 4
$sql=mysql_query("SELECT * FROM apqp_chk2 WHERE peca='$pc' AND anexo='$anexo' ORDER BY id ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		$tam[0]=flinha($res["nome"],83);
		$tam[1]=flinha($res["coments"],45);
		$tam[2]=flinha($res["titulo"],40);
		$max=max($tam);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$max - $tam[$i];
		}
		$maxu=($max*5)+$y;
		if($maxu>=185){
			$y=186;
		}
		if($y>=185){
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(250,182.5);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$y=50;
			$pg++;
			$pdf->AddPage('L');
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
		$pdf->SetXY(5, 1);
		$pdf->SetFont('Arial','B',14);
		$pdf->SetXY(50, 7);
		$pdf->MultiCell(200,5,"Lista de Verificação do APQP - A$anexo - $anexo2",0,'C');
		$pdf->SetXY(260, 5);
		$pdf->SetFont('Arial','B',8);
		$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
		$pdf->SetXY(5, 18);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(60,5,"Número da Peça (cliente) \n $pecacli",1);
		$pdf->SetXY(65, 18);
		$pdf->MultiCell(60,5,"Rev. / Data do Desenho \n ",1);
		$pdf->SetXY(125, 18);
		$pdf->MultiCell(80,5,"Nome da Peça \n $nome",1);
		$pdf->SetXY(205, 18);
		$pdf->MultiCell(85,5,"Cliente \n $nomecli",1);
		//linha 2
		$pdf->SetXY(5, 28);
		$pdf->MultiCell(120,5,"Fornecedor \n $razao",1);
		$pdf->SetXY(125, 28);
		$pdf->MultiCell(80,5,"Número/Rev. Peça (fornecedor) \n $num",1);
		$pdf->SetXY(205, 28);
		$pdf->MultiCell(60,5,"Aprovado por  \n $quem",1);
		$pdf->SetXY(265, 28);
		$pdf->MultiCell(25,5,"Data \n $dtquem",1);
		//linha 3		
		$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(5, 40);
		$pdf->MultiCell(130,10,"Pergunta",1,'C');
		$pdf->SetXY(135, 40);
		$pdf->MultiCell(10,10,"Sim",1,'C');
		$pdf->SetXY(145, 40);
		$pdf->MultiCell(10,10,"Não",1,'C');
		$pdf->SetXY(155, 40);
		$pdf->MultiCell(60,10,"Comentários / Ação Requerida ",1,'C');
		$pdf->SetXY(215, 40);
		$pdf->MultiCell(45,10,"Responsável",1,'C');
		$pdf->SetXY(260, 40);
		$pdf->MultiCell(30,10,"Data Prevista ",1,'C');
		}
		if($res["titulo"]){
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, $y);
			$pdf->MultiCell(285,5,$res["nome"],0);
			$yi=$y;
			$y=$y+5;
			$pdf->Line(5,$yi,290,$yi);
			$pdf->Line(5,$y,290,$y);
			$pdf->Line(5,$yi,5,$y);
			$pdf->Line(290,$yi,290,$y);
		}else{
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(5, $y);
			$pdf->MultiCell(10,5,$res["num"],0);
			$pdf->SetXY(15, $y);
			$pdf->MultiCell(120,5,$res["nome"],0);
			if($res["ok"]==1){$ok="X"; }else{$ok=" "; }
			$pdf->SetXY(135, $y);
			$pdf->MultiCell(10,5,$ok,0);
			if($res["ok"]==2){$ok="X"; }else{$ok=" "; }
			$pdf->SetXY(145, $y);
			$pdf->MultiCell(10,5,$ok,0,'C');
			$pdf->SetXY(155, $y);
			$pdf->MultiCell(60,5,$res["coments"],0);
			$pdf->SetXY(215, $y);
			$pdf->MultiCell(45,5,$res["resp"],0);
			$pdf->SetXY(260, $y);
			$pdf->MultiCell(30,5,banco2data($res["data"]),0,'C');
			$yi=$y;
			$y=($max*5)+$y;
			$pdf->Line(5,$yi,5,$y);
			$pdf->Line(15,$yi,15,$y);
			$pdf->Line(135,$yi,135,$y);
			$pdf->Line(145,$yi,145,$y);
			$pdf->Line(155,$yi,155,$y);
			$pdf->Line(215,$yi,215,$y);
			$pdf->Line(260,$yi,260,$y);
			$pdf->Line(290,$yi,290,$y);
			$pdf->Line(5,$yi,290,$yi);
			$pdf->Line(5,$y,290,$y);
		}
	}
// desenvolvedor
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(250,182.5);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");	
}
$pdf->Line(5,$y,5,185);
$pdf->Line(15,$y,15,185);
$pdf->Line(135,$y,135,185);
$pdf->Line(145,$y,145,185);
$pdf->Line(155,$y,155,185);
$pdf->Line(215,$y,215,185);
$pdf->Line(260,$y,260,185);
$pdf->Line(290,$y,290,185);
$pdf->Line(5,185,290,185);


if($email=="sim"){
$pdf->Output('relatorio.pdf','I');
}
		
//fim
?>