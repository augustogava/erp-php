<?php
if(empty($tira)){
include('../../conecta.php');
require('fpdf.php');}
if(empty($tira)){$pdf=new FPDF();}
$pc=$_GET["pc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_enma WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35);
$pdf->Cell(0, 18,'Aprovação de Peça de Produção Resultados dos Ensaios de Materiais');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(175, 8);
$pg=$pdf->PageNo();
$ppap=$res["numero"];
$razao=$rese["razao"];
$peca=$res["pecacli"];
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];
$rev=$res[rev]." - ".banco2data($res["dtrev"]);
$pdf->MultiCell(30,5,"PPAP Nº $ppap \n Pagina: $pg");
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,5,"Fornecedor \n $razao",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,5,"Número da Peça (cliente) \n $peca",1);
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,5,"Rev. / Data do Desenho \n $rev",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(50,5,"Local da Inspeção \n $local",1);
$pdf->SetXY(55, 28);
$pdf->MultiCell(50,5,"Número/Rev. Peça (fornecedor) \n $num",1);
$pdf->SetXY(105, 28);
$pdf->MultiCell(100,5,"Nome da Peça \n $nome",1);
//linha 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 40);
$pdf->MultiCell(15,10,"Car. Nº",1,'C');
$pdf->SetXY(20, 40);
$pdf->MultiCell(15,5,"Tipo de Teste",1,'C');
$pdf->SetXY(35, 40);
$pdf->MultiCell(70,10,"Dimensão / Especificação",1,'C');
$pdf->SetXY(105, 40);
$pdf->MultiCell(12,5,"Caract. Esp.",1,'C');
$pdf->SetXY(117, 40);
$pdf->MultiCell(70,10,"Resultados das Modificações pelo Fornecedor ",1,'C');
$pdf->SetXY(187, 40);
$pdf->MultiCell(8,10,"OK",1,'C');
$pdf->SetXY(195, 40);
$pdf->MultiCell(10,5,"Não OK",1,'C');
//linha 4
$y=50;
$sql=mysql_query("SELECT ensaio1.*,ensaio1.tipo AS tp,car.numero,car.descricao,car.simbolo,car.espec,car.tipo FROM apqp_car AS car, apqp_enma AS ensaio, apqp_enmal AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER BY car.numero");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($y>=250){
			$y=50;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(5, 1);
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(35);
			$pdf->Cell(0, 18,'Aprovação de Peça de Produção Resultados dos Ensaios de Materiais');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(175, 8);
			$pg=$pdf->PageNo();
			$pdf->MultiCell(30,5,"PPAP Nº $ppap \n Pagina: $pg");
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(100,5,"Fornecedor \n $razao",1);
			$pdf->SetXY(105, 18);
			$pdf->MultiCell(50,5,"Número da Peça (cliente) \n $peca",1);
			$pdf->SetXY(155, 18);
			$pdf->MultiCell(50,5,"Rev. / Data do Desenho \n $rev",1);
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(50,5,"Local da Inspeção \n $local",1);
			$pdf->SetXY(55, 28);
			$pdf->MultiCell(50,5,"Número/Rev. Peça (fornecedor) \n $num",1);
			$pdf->SetXY(105, 28);
			$pdf->MultiCell(100,5,"Nome da Peça \n $nome",1);
			//linha 3
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, 40);
			$pdf->MultiCell(15,10,"Car. Nº",1,'C');
			$pdf->SetXY(20, 40);
			$pdf->MultiCell(15,5,"Tipo de Teste",1,'C');
			$pdf->SetXY(35, 40);
			$pdf->MultiCell(70,10,"Dimensão / Especificação",1,'C');
			$pdf->SetXY(105, 40);
			$pdf->MultiCell(12,5,"Caract. Esp.",1,'C');
			$pdf->SetXY(117, 40);
			$pdf->MultiCell(70,10,"Resultados das Modificações pelo Fornecedor ",1,'C');
			$pdf->SetXY(187, 40);
			$pdf->MultiCell(8,10,"OK",1,'C');
			$pdf->SetXY(195, 40);
			$pdf->MultiCell(10,5,"Não OK",1,'C');
		}
		$maxi=$maxu*5;
		$total=$y + $maxi;
		if($total>=255){
		 $y=255;
		}
		$tam1[0]=ceil(strlen($res["numero"])/2);
		$tam1[1]=ceil(strlen($res["tp"])/8);
		if($tam1[1]==0){$tam1[1]=1;}
		$tam1[2]=ceil(strlen("$res[descricao] - $res[espec]")/50);
		$tam1[3]=1;
		$tam1[4]=ceil(strlen($res["forn"])/40);
		if($tam1[4]==0){$tam1[4]=1;}
		$tam1[5]=1;
		$maxu=max($tam1);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxu - $tam1[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(15,$w,$res["numero"].qlinha($ql[0]),1,'C');
		$pdf->SetXY(20, $y);
		$pdf->MultiCell(15,$w,$res["tp"].qlinha($ql[1]),1,'C');
		$pdf->SetXY(35, $y);
		$pdf->MultiCell(70,$w,"$res[descricao] - $res[espec]".qlinha($ql[2]),1);
		$pdf->SetXY(105, $y);
		if(empty($res["simbolo"])){$fig="../../imagens/quad.gif"; }else{$fig="../../apqp_fluxo/$res[simbolo].jpg";}
		$pdf->Image($fig,108,$y,5,5);
		$pdf->MultiCell(12,$w,qlinha($ql[3]),1,'C');
		$pdf->SetXY(117, $y);
		$pdf->MultiCell(70,$w,$res["forn"].qlinha($ql[4]),1);
		if($res["ok"]=="S"){$ok="X";}else{$ok=" ";}
		$pdf->SetXY(187, $y);
		$pdf->MultiCell(8,$w,$ok.qlinha($ql[5]),1,'C');
		if($res["ok"]=="N"){$ok="X";}else{$ok=" ";}
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok.qlinha($ql[5]),1,'C');
		$y=($maxu*5)+$y;
	}
}
$pdf->Line(5,255,205,255);
$pdf->Line(5,50,5,255);
$pdf->Line(20,50,20,255);
$pdf->Line(35,50,35,255);
$pdf->Line(105,50,105,255);
$pdf->Line(117,50,117,255);
$pdf->Line(187,50,187,255);
$pdf->Line(195,50,195,255);
$pdf->Line(205,50,205,255);
//ultima linha

$y=260;
$pdf->SetFont('Arial','',7);
$pdf->SetXY(5, $y);
$pdf->MultiCell(82,5,"Aprovado Por \n $resp[quem]",1,'');
$pdf->SetXY(87, $y);
$pdf->MultiCell(20,5,"Data \n ".banco2data($resp["dtquem"])."",1);
$pdf->SetXY(107, $y);
$pdf->MultiCell(80,5,"Assinatura do Fornecedor \n $resp[rep]",1,'');
$pdf->SetXY(187, $y);
$pdf->MultiCell(18,5,"Data \n ".banco2data($resp["dtrep"])."",1);


if(empty($tira)){
$pdf->Output('apqp_enma.pdf','I');
}
?>
