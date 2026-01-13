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
$sql=mysql_query("SELECT * FROM apqp_ende WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

if(empty($tira)){$pdf=new FPDF();}

$pdf->AddPage();
$razao=$rese["razao"];
$peca=$res["pecacli"];
$rev=$res["rev"]." - ".banco2data($res["dtrev"]);
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];
$numero=$res["numero"];
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(35,5);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(200,5,"Aprovação de Peça de Produção Resultados dos Ensaios de Desempenho",'C');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 8);
$pg=$pdf->PageNo();
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
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
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(5, 40);
$pdf->MultiCell(10,5,"Car. Nº",1,'C');
$pdf->SetXY(15, 40);
$pdf->MultiCell(15,10,"Ref. Nº",1,'C');
$pdf->SetXY(30, 40);
$pdf->MultiCell(75,10,"Dimensão / Especificação",1,'C');
$pdf->SetXY(105, 40);
$pdf->MultiCell(15,5,"Freq. Teste",1,'C');
$pdf->SetXY(120, 40);
$pdf->MultiCell(10,5,"Qtd. Ens.",1,'C');
$pdf->SetXY(130, 40);
$pdf->MultiCell(55,5,"Resultados das Modificações pelo Fornecedor ",1,'C');
$pdf->SetXY(185, 40);
$pdf->MultiCell(10,10,"OK",1,'C');
$pdf->SetXY(195, 40);
$pdf->MultiCell(10,5,"Não OK",1,'C');
	
//linha 4
$sql2=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo FROM apqp_car AS car, apqp_ende AS ensaio, apqp_endel AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio");
$y=50;
if(mysql_num_rows($sql2)){
	while($res2=mysql_fetch_array($sql2)){
		if($y>=250){
			$y=50;
			$pdf->AddPage();
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(35,5);
			$pdf->SetFont('Arial','B',10);
			$pdf->MultiCell(200,5,"Aprovação de Peça de Produção Resultados dos Ensaios de Desempenho",'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 8);
			$pg=$pdf->PageNo();
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: 2");
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
			$pdf->SetFont('Arial','B',7);
			$pdf->SetXY(5, 40);
			$pdf->MultiCell(10,5,"Car. Nº",1,'C');
			$pdf->SetXY(15, 40);
			$pdf->MultiCell(15,10,"Ref. Nº",1,'C');
			$pdf->SetXY(30, 40);
			$pdf->MultiCell(75,10,"Dimensão / Especificação",1,'C');
			$pdf->SetXY(105, 40);
			$pdf->MultiCell(15,5,"Freq. Teste",1,'C');
			$pdf->SetXY(120, 40);
			$pdf->MultiCell(10,5,"Qtd. Ens.",1,'C');
			$pdf->SetXY(130, 40);
			$pdf->MultiCell(55,5,"Resultados das Modificações pelo Fornecedor ",1,'C');
			$pdf->SetXY(185, 40);
			$pdf->MultiCell(10,10,"OK",1,'C');
			$pdf->SetXY(195, 40);
			$pdf->MultiCell(10,5,"Não OK",1,'C');
		}
		$tam1[0]=flinha($res2["numero"],10);
		if($tam1[0]==0){$tam1[0]=1;}
		$tam1[1]=flinha($res2["ref"],15);
		if($tam[1]==0){$tam1[1]=1;}
		$tam1[2]=flinha($res2["descricao"]." - ".$res2["espec"],75);
		if($tam[2]==0){$tam1[2]=1;}
		$tam1[3]=flinha($res2["freq"],15);
		if($tam[3]==0){$tam1[3]=1;}
		$tam1[4]=flinha($res2["qtd"],10);
		if($tam[4]==0){$tam1[4]=1;}
		$tam1[5]=flinha($res2["forn"],55);
		if($tam[5]==0){$tam1[5]=1;}
		$maxu=max($tam1);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxu - $tam1[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(10,$w,"$res2[numero]",0,'C');
		$pdf->SetXY(15, $y);
		$pdf->MultiCell(15,$w,"$res2[ref]",0,'C');
		$pdf->SetXY(30, $y);
		$pdf->MultiCell(75,$w,"$res2[descricao] - $res2[espec]",0);
		$pdf->SetXY(105, $y);
		$pdf->MultiCell(15,$w,"$res2[freq]",0,'C');
		$pdf->SetXY(120, $y);
		$pdf->MultiCell(10,$w,"$res2[qtd]",0,'C');
		$pdf->SetXY(130, $y);
		$pdf->MultiCell(55,$w,"$res2[forn]",0);
		$pdf->SetXY(185, $y);
		if($res2["ok"]=="S") $ok="X";
		$pdf->MultiCell(10,$w,$ok,0,'C');
		if($res2["ok"]=="N") $ok="X";
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok,0,'C');
		$yi=$y;
		$y=$y+($maxu*5);
		$pdf->Line(5,$y,205,$y);
		$pdf->Line(5,$yi,5,$y);
		$pdf->Line(15,$yi,15,$y);
		$pdf->Line(30,$yi,30,$y);
		$pdf->Line(105,$yi,105,$y);
		$pdf->Line(120,$yi,120,$y);
		$pdf->Line(130,$yi,130,$y);
		$pdf->Line(185,$yi,185,$y);
		$pdf->Line(195,$yi,195,$y);
		$pdf->Line(205,$yi,205,$y);
	}
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
}
//ultima linha
$pdf->Line(5,255,205,255);
$pdf->Line(5,50,5,255);
$pdf->Line(15,50,15,255);
$pdf->Line(30,50,30,255);
$pdf->Line(105,50,105,255);
$pdf->Line(120,50,120,255);
$pdf->Line(130,50,130,255);
$pdf->Line(185,50,185,255);
$pdf->Line(195,50,195,255);
$pdf->Line(205,50,205,255);
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
$pdf->Output('apqp_ende.pdf','I');
}
?>
