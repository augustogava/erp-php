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
$sql=mysql_query("SELECT * FROM apqp_chk WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

if(empty($tira)){$pdf=new FPDF();}

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'Lista de Verificação de Material a Granel ');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(80,5,"Cliente \n $res[nomecli]",1);
$pdf->SetXY(85, 18);
$pdf->MultiCell(120,5,"Nome da Peça \n  $res[nome]",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(80,5,"Fornecedor \n $rese[razao]",1);
$pdf->SetXY(85, 28);
$pdf->MultiCell(60,5,"Rev. / Data do Desenho \n $res[rev] -  ".banco2data($res["dtrev"])."",1);
$pdf->SetXY(145, 28);
$pdf->MultiCell(60,5,"Número/Rev. Peça (fornecedor) \n $res[numero] - $res[rev]",1);
//linha 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 40);
$pdf->MultiCell(70,10,"",1);
$pdf->SetXY(75, 40);
$pdf->MultiCell(15,10,"Prazo",1,'C');
$pdf->SetXY(90, 40);
$pdf->MultiCell(40,5,"Responsabilidade Principal",1,'C');
$pdf->SetXY(90, 45);
$pdf->MultiCell(20,5,"Cliente",1,'C');
$pdf->SetXY(110, 45);
$pdf->MultiCell(20,5,"Fornecedor",1,'C');
$pdf->SetXY(130, 40);
$pdf->MultiCell(40,10,"Comentários",1,'C');
$pdf->SetXY(170, 40);
$pdf->MultiCell(35,10,"Aprovado por / Data",1,'C');
//linha 4

//linha 5
$y=50;
$sql=mysql_query("SELECT * FROM apqp_granel2 WHERE peca='$pc' ORDER BY id ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		$tam[0]=flinha($res["nome"],48);
		if($tam[0]==0){$tam[0]=1;}
		$tam[1]=flinha($res["rcli"],10);
		if($tam[1]==0){$tam[1]=1;}
		$tam[2]=flinha($res["rfor"],10);
		if($tam[2]==0){$tam[2]=1;}
		$tam[3]=flinha($res["coments"],25);
		if($tam[3]==0){$tam[3]=1;}
		$tam[4]=flinha($res["por"]." / ".$res["dtpor"],25);
		if($tam[4]==0){$tam[4]=1;}
		$max=max($tam);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$max - $tam[$i];
		}
		if($y>=245){
		
		}
		if($res["titulo"]){
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, $y);
			$pdf->MultiCell(200,5,$res["nome"],1);
			$y=$y+5;
		}else{
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(5, $y);
			$pdf->MultiCell(70,5,$res["nome"],0);
			$pdf->SetXY(75, $y);
			$pdf->MultiCell(15,5,$res["prazo"],0,'C');
			$pdf->SetXY(90, $y);
			$pdf->MultiCell(20,5,$res["rcli"],0,'C');
			$pdf->SetXY(110, $y);
			$pdf->MultiCell(20,5,$res["rfor"],0,'C');
			$pdf->SetXY(130, $y);
			$pdf->MultiCell(40,5,$res["coments"],0,'C');
			$pdf->SetXY(170, $y);
			$pdf->MultiCell(35,5,$res["por"],0,'C');
			$yi=$y;
			$y=$y+($max*5);
			$pdf->Line(5,$y,205,$y);
			$pdf->Line(5,$yi,5,$y);
			$pdf->Line(75,$yi,75,$y);
			$pdf->Line(90,$yi,90,$y);
			$pdf->Line(110,$yi,110,$y);
			$pdf->Line(130,$yi,130,$y);
			$pdf->Line(170,$yi,170,$y);
			$pdf->Line(205,$yi,205,$y);
		}
	}
}
$y+=2;
$sql=mysql_query("SELECT * FROM apqp_granel WHERE peca='$pc'");
$res=mysql_fetch_array($sql);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, $y);
$pdf->MultiCell(35,15,"Aprovado por - Data",1,'C');
$pdf->SetXY(40, $y);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(165,5,$res["ap1"]." - ".banco2data($res["dap1"])." \n".$res["ap2"]." - ".banco2data($res["dap2"])." \n".$res["ap3"]." - ".banco2data($res["dap3"]),1);
//linha6
//fim

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
	
if(empty($tira)){
$pdf->Output('apqp_granel.pdf','I');
}
?>
