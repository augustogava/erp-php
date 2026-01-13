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
$sql=mysql_query("SELECT * FROM apqp_endi WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage();
$razao=$rese["razao"];
$cliente=$res["pecacli"];
$rev=$res[rev]." - ".banco2data($res["dtrev"]);
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'Aprovação de Peça de Produção Resultados Dimensionais ');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 5);
$pg=$pdf->PageNo();
$pdf->MultiCell(40,5,"PPAP Nº $res[numero] \n Página: $pg");
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(110,5,"Fornecedor \n $razao",1);
$pdf->SetXY(115, 18);
$pdf->MultiCell(45,5,"Número da Peça (cliente) \n $cliente",1);
$pdf->SetXY(160, 18);
$pdf->MultiCell(45,5,"Rev. / Data do Desenho \n $rev",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(50,5,"Local da Inspeção \n $local",1);
$pdf->SetXY(55, 28);
$pdf->MultiCell(60,5,"Número/Rev. Peça (fornecedor) \n $num",1);
$pdf->SetXY(115, 28);
$pdf->MultiCell(90,5,"Nome da Peça \n $nome",1);
//linha 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 40);
$pdf->MultiCell(10,10,"Item",1,'C');
$pdf->SetXY(15, 40);
$pdf->MultiCell(80,10,"Dimensão / Especificação",1,'C');
$pdf->SetXY(95, 40);
$pdf->MultiCell(12,5,"Caract. Esp.",1,'C');
$pdf->SetXY(107, 40);
$pdf->MultiCell(80,10,"Resultados das Modificações pelo Fornecedor ",1,'C');
$pdf->SetXY(187, 40);
$pdf->MultiCell(8,10,"OK",1,'C');
$pdf->SetXY(195, 40);
$pdf->MultiCell(10,5,"Não OK",1,'C');
//linha 4
$y=50;
$sql=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo FROM apqp_car AS car, apqp_endi AS ensaio, apqp_endil AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER BY car.numero ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($y>=250){
			$y=50;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(5, 1);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(35);
			$pdf->Cell(0, 18, 'Aprovação de Peça de Produção Resultados Dimensionais ');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 5);
			$pg=$pdf->PageNo();
			$pdf->MultiCell(40,5,"PPAP Nº $res[numero] \n Página: $pg");
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(85,5,"Fornecedor \n $razao",1);
			$pdf->SetXY(90, 18);
			$pdf->MultiCell(65,5,"Número da Peça (cliente) \n $cliente",1);
			$pdf->SetXY(155, 18);
			$pdf->MultiCell(50,5,"Rev. / Data do Desenho \n $rev",1);
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(75,5,"Local da Inspeção \n $local",1);
			$pdf->SetXY(80, 28);
			$pdf->MultiCell(55,5,"Número/Rev. Peça (fornecedor) \n $num",1);
			$pdf->SetXY(135, 28);
			$pdf->MultiCell(70,5,"Nome da Peça \n $nome",1);
			//linha 3
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, 40);
			$pdf->MultiCell(10,10,"Item",1,'C');
			$pdf->SetXY(15, 40);
			$pdf->MultiCell(80,10,"Dimensão / Especificação",1,'C');
			$pdf->SetXY(95, 40);
			$pdf->MultiCell(12,5,"Caract. Esp.",1,'C');
			$pdf->SetXY(107, 40);
			$pdf->MultiCell(80,10,"Resultados das Modificações pelo Fornecedor ",1,'C');
			$pdf->SetXY(187, 40);
			$pdf->MultiCell(8,10,"OK",1,'C');
			$pdf->SetXY(195, 40);
			$pdf->MultiCell(10,5,"Não OK",1,'C');
		}
		$tam[0]=ceil(strlen($res["numero"])/2);
		$tam[2]=ceil(strlen("$res[descricao] - $res[espec]")/50);
		$tam[3]=1;
		$tam[4]=ceil(strlen($res["forn"])/40);
		if($tam[4]==0){$tam[4]=1;}
		$tam[5]=1;
		$max=max($tam);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$max - $tam[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(10,$w,$res["numero"].qlinha($ql[0]),1,'C');
		$pdf->SetXY(15, $y);
		$pdf->MultiCell(80,$w,"$res[descricao] - $res[espec]",1);
		$pdf->SetXY(95, $y);
		if(empty($res["simbolo"])){$fig="../../imagens/quad.jpg"; }else{$fig="../../apqp_fluxo/$res[simbolo].jpg"; }
		$pdf->Image($fig,99,$y,5,5);
		$pdf->MultiCell(12,$w," ".qlinha($ql[3]),1);
		$pdf->SetXY(107, $y);
		$pdf->MultiCell(80,$w,$res["forn"].qlinha($ql[4]),1);
		$pdf->SetXY(187, $y);
		if($res["ok"]=="S"){$ok="X";}else{$ok="";}
		$pdf->MultiCell(8,$w,$ok.qlinha($ql[5]),1,'C');
		if($res["ok"]=="N"){$ok="X";}else{$ok="";}
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok.qlinha($ql[5]),1,'C');
		$y=($max*5)+$y;
	}
}
//ultima linha
$pdf->Line(5,255,205,255);
$pdf->Line(5,50,5,255);
$pdf->Line(15,50,15,255);
$pdf->Line(95,50,95,255);
$pdf->Line(107,50,107,255);
$pdf->Line(187,50,187,255);
$pdf->Line(195,50,195,255);
$pdf->Line(205,50,205,255);

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
$pdf->Output('apqp_endi.pdf','I');
}
?>
