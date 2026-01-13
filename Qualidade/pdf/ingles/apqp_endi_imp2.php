<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_endi WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage();
$pg=1;
$razao=$rese["razao"];
$cliente=$res["pecacli"];
$numero=$res["numero"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'Production Part Approval Dimensional Results ');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 5);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(110,5,"Supplier \n $razao",1);
$pdf->SetXY(115, 18);
$pdf->MultiCell(45,5,"Part Number (Customer)  \n $cliente",1);
$pdf->SetXY(160, 18);
$pdf->MultiCell(45,5,"Drawing Revision/Date \n $rev",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(50,5,"Inspection Facility \n $local",1);
$pdf->SetXY(55, 28);
$pdf->MultiCell(60,5,"Part number/Revision (Supplier) \n $num",1);
$pdf->SetXY(115, 28);
$pdf->MultiCell(90,5,"Part Name \n $nome",1);
//linha 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 40);
$pdf->MultiCell(10,10,"Char.",1,'C');
$pdf->SetXY(15, 40);
$pdf->MultiCell(80,10,"Dimension / Specification",1,'C');
$pdf->SetXY(95, 40);
$pdf->MultiCell(12,5,"Char. \n ",1,'C');
$pdf->SetXY(107, 40);
$pdf->MultiCell(80,10,"Supplier Measurement Results ",1,'C');
$pdf->SetXY(187, 40);
$pdf->MultiCell(8,10,"OK",1,'C');
$pdf->SetXY(195, 40);
$pdf->MultiCell(10,5,"Not OK",1,'C');

//linha 4
$y=50;
$sql=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo FROM apqp_car AS car, apqp_endi AS ensaio, apqp_endil AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER BY car.numero ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($y>=250){
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$y=50;
			$pg++;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(5, 1);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(35);
			$pdf->Cell(0, 18, 'Production Part Approval Dimensinal Results');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 5);
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(85,5,"Supplier \n $razao",1);
			$pdf->SetXY(90, 18);
			$pdf->MultiCell(65,5,"Part Number (Customer) \n $cliente",1);
			$pdf->SetXY(155, 18);
			$pdf->MultiCell(50,5,"Drawing Revision/Date \n $rev",1);
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(75,5,"Inspection Facility \n $local",1);
			$pdf->SetXY(80, 28);
			$pdf->MultiCell(55,5,"Part Number / Revision (Supplier) \n $num",1);
			$pdf->SetXY(135, 28);
			$pdf->MultiCell(70,5,"Part Name \n $nome",1);
			//linha 3
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, 40);
			$pdf->MultiCell(10,10,"Char.",1,'C');
			$pdf->SetXY(15, 40);
			$pdf->MultiCell(80,10,"Dimension / Specification",1,'C');
			$pdf->SetXY(95, 40);
			$pdf->MultiCell(12,5,"Char. \n ",1,'C');
			$pdf->SetXY(107, 40);
			$pdf->MultiCell(80,10,"Supplier Measurement Results ",1,'C');
			$pdf->SetXY(187, 40);
			$pdf->MultiCell(8,10,"OK",1,'C');
			$pdf->SetXY(195, 40);
			$pdf->MultiCell(10,5,"Not OK",1,'C');
		}
		$tam1[0]=flinha($res["numero"],10);
		$tam1[2]=flinha("$res[descricao] - $res[espec]",80);
		$tam1[3]=1;
		$tam1[4]=flinha($res["forn"],80);
		if($tam1[4]==0){$tam1[4]=1;}
		$tam1[5]=1;
		$maxu=max($tam1);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxu - $tam1[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(10,$w,$res["numero"],0,'C');
		$pdf->SetXY(15, $y);
		$pdf->MultiCell(80,$w,"$res[descricao] - $res[espec]",0);
		$pdf->SetXY(95, $y);
		if(!empty($res["simbolo"])){
		$ym=$y+1;
		$fig="apqp_fluxo/$res[simbolo].jpg"; 
		$pdf->Image($fig,99,$ym,4,4);
		}
		$pdf->MultiCell(12,$w," ",0);
		$pdf->SetXY(107, $y);
		$pdf->MultiCell(80,$w,$res["forn"],0);
		$pdf->SetXY(187, $y);
		if($res["ok"]=="S"){$ok="X";}else{$ok="";}
		$pdf->MultiCell(8,$w,$ok,0,'C');
		if($res["ok"]=="N"){$ok="X";}else{$ok="";}
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok,0,'C');
		$y=($maxu*5)+$y;
		$pdf->Line(5,$y,205,$y);
		$pdf->Line(5,255,205,255);
		$pdf->Line(5,50,5,255);
		$pdf->Line(15,50,15,255);
		$pdf->Line(95,50,95,255);
		$pdf->Line(107,50,107,255);
		$pdf->Line(187,50,187,255);
		$pdf->Line(195,50,195,255);
		$pdf->Line(205,50,205,255);
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
$pdf->Line(95,50,95,255);
$pdf->Line(107,50,107,255);
$pdf->Line(187,50,187,255);
$pdf->Line(195,50,195,255);
$pdf->Line(205,50,205,255);

$y=260;
$pdf->SetFont('Arial','',7);
$pdf->SetXY(5, $y);
$pdf->MultiCell(82,5,"Approved By \n $resp[quem]",1,'');
$pdf->SetXY(87, $y);
$pdf->MultiCell(20,5,"Date \n ".banco2data($resp["dtquem"])."",1);
$pdf->SetXY(107, $y);
$pdf->MultiCell(80,5,"Supplier Signature \n $resp[rep]",1,'');
$pdf->SetXY(187, $y);
$pdf->MultiCell(18,5,"Date \n ".banco2data($resp["dtrep"])."",1);


//fim
?>
