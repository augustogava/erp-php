<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_enma WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage();
$pg=1;
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(25, 0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35);
$pdf->Cell(0, 18,'HOMOLOGATION DE PIÉCES DE PRODUCTION');
$pdf->SetXY(75, 5);
$pdf->Cell(0, 18,'RÉSULTATS ESSAIS MATIÉRE');
$pdf->SetFont('Arial','B',8);
$numero=$res["numero"];
$pdf->SetXY(175, 8);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
$pdf->SetXY(185, 8);
$ppap=$res["numero"];
$razao=$rese["razao"];
$peca=$res["pecacli"];
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,5,"Fournisseur \n $razao",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,5,"Numéro Piéce (Client) \n $peca",1);
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,5,"Numéro de Plan / Rev. / Date \n $rev",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(50,5,"Lieu de la Verification \n $local",1);
$pdf->SetXY(55, 28);
$pdf->MultiCell(50,5,"Numéro de Piéce / Rév. (Fournisseur) $num",1);
$pdf->SetXY(105, 28);
$pdf->MultiCell(100,5,"Designation de la Piéce \n $nome",1);
//linha 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 40);
$pdf->MultiCell(15,10,"Car. Nº",1,'C');
$pdf->SetXY(20, 40);
$pdf->MultiCell(15,5,"Type d´essai",1,'C');
$pdf->SetXY(35, 40);
$pdf->MultiCell(70,10,"Numéro de specification Matiére / Date",1,'C');
$pdf->SetXY(105, 40);
$pdf->MultiCell(12,5,"Caract. Esp.",1,'C');
$pdf->SetXY(117, 40);
$pdf->MultiCell(70,10,"Resultats d´essais du Fournisseur ",1,'C');
$pdf->SetXY(187, 40);
$pdf->MultiCell(8,10,"Con",1,'C');
$pdf->SetXY(195, 40);
$pdf->MultiCell(10,5,"Non Conf",1,'C');
//linha 4
$y=50;
$sql=mysql_query("SELECT ensaio1.*,ensaio1.tipo AS tp,car.numero,car.descricao,car.simbolo,car.espec,car.tipo FROM apqp_car AS car, apqp_enma AS ensaio, apqp_enmal AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER BY car.numero");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($y>=250){
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

				$pdf->Line(5,255,205,255);
				$pdf->Line(5,50,5,255);
				$pdf->Line(20,50,20,255);
				$pdf->Line(35,50,35,255);
				$pdf->Line(105,50,105,255);
				$pdf->Line(117,50,117,255);
				$pdf->Line(187,50,187,255);
				$pdf->Line(195,50,195,255);
				$pdf->Line(205,50,205,255);

			$y=50;
			$pg++;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(25, 0);
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(35);
			$pdf->Cell(0, 18,'HOMOLOGATION DE PIÉCES DE PRODUCTION');
			$pdf->SetXY(75, 5);
			$pdf->Cell(0, 18,'RÉSULTATS ESSAIS MATIÉRE');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(175, 8);
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(100,5,"Fournisseur \n $razao",1);
			$pdf->SetXY(105, 18);
			$pdf->MultiCell(50,5,"Numéro Piéce (Client) \n $peca",1);
			$pdf->SetXY(155, 18);
			$pdf->MultiCell(50,5,"Numéro de Plan / Rev. / Date \n $rev",1);
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(50,5,"Lieu de la Verification \n $local",1);
			$pdf->SetXY(55, 28);
			$pdf->MultiCell(50,5,"Numéro de Piéce / Rév. (Fournisseur) $num",1);
			$pdf->SetXY(105, 28);
			$pdf->MultiCell(100,5,"Designation de la Piéce \n $nome",1);
			//linha 3
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, 40);
			$pdf->MultiCell(15,10,"Car. Nº",1,'C');
			$pdf->SetXY(20, 40);
			$pdf->MultiCell(15,5,"Type d´essai",1,'C');
			$pdf->SetXY(35, 40);
			$pdf->MultiCell(70,10,"Numéro de specification Matiére / Date",1,'C');
			$pdf->SetXY(105, 40);
			$pdf->MultiCell(12,5,"Caract. Esp.",1,'C');
			$pdf->SetXY(117, 40);
			$pdf->MultiCell(70,10,"Resultats d´essais du Fournisseur ",1,'C');
			$pdf->SetXY(187, 40);
			$pdf->MultiCell(8,10,"Con",1,'C');
			$pdf->SetXY(195, 40);
			$pdf->MultiCell(10,5,"Non Conf",1,'C');
		}
		$maxi=$maxu*5;
		$total=$y + $maxi;
		if($total>=255){
		 $y=255;
		}
		$tam1[0]=flinha($res["numero"],15);
		$tam1[1]=flinha($res["tp"],15);
		if($tam1[1]==0){$tam1[1]=1;}
		$tam1[2]=flinha("$res[descricao] - $res[espec]",70);
		$tam1[3]=1;
		$tam1[4]=flinha($res["forn"],70);
		if($tam1[4]==0){$tam1[4]=1;}
		$tam1[5]=1;
		$maxu=max($tam1);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxu - $tam1[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(15,$w,$res["numero"],0,'C');
		$pdf->SetXY(20, $y);
		$pdf->MultiCell(15,$w,$res["tp"],0,'C');
		$pdf->SetXY(35, $y);
		$pdf->MultiCell(70,$w,"$res[descricao] - $res[espec]",0);
		$pdf->SetXY(105, $y);
		if(!empty($res["simbolo"])){
		$ym=$y+2;
		$fig="apqp_fluxo/$res[simbolo].jpg";
		$pdf->Image($fig,108,$ym,5,5);
		}
		$pdf->MultiCell(12,$w,"",0,'C');
		$pdf->SetXY(117, $y);
		$pdf->MultiCell(70,$w,$res["forn"],0);
		if($res["ok"]=="S"){$ok="X";}else{$ok=" ";}
		$pdf->SetXY(187, $y);
		$pdf->MultiCell(8,$w,$ok,0,'C');
		if($res["ok"]=="N"){$ok="X";}else{$ok=" ";}
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok,0,'C');
		$y=($maxu*5)+$y;
		$pdf->Line(5,$y,205,$y);
	}
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
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
$pdf->MultiCell(82,5,"Approuvé Près \n $resp[quem]",1,'');
$pdf->SetXY(87, $y);
$pdf->MultiCell(20,5,"Date \n ".banco2data($resp["dtquem"])."",1);
$pdf->SetXY(107, $y);
$pdf->MultiCell(80,5,"Signature De Fournisseur \n $resp[rep]",1,'');
$pdf->SetXY(187, $y);
$pdf->MultiCell(18,5,"Date \n ".banco2data($resp["dtrep"])."",1);

//fim
?>
