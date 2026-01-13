<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_endi WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$eng=$res["niveleng"];
$proj=$res["nivelproj"];
$resultado=$resp["result"];
$cod_forn=$res["cod_forn"];
$pdf->AddPage();
$pg=1;
$razao=$rese["razao"];
$cliente=$res["pecacli"];
$numero=$res["numero"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];
$pdf->Image('empresa_logo/logo.jpg',5,1,20);  // logo qualitmanager
$pdf->Image('imagens/logo_chrysler.jpg',5,14,25,3);
$pdf->Image('imagens/logo_ford.jpg',30,12,13);
$pdf->Image('imagens/logo_gm.jpg',44,11,6);
$pdf->SetXY(40, 0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(35);
$pdf->Cell(0, 10, 'Homologation de Piécas de Production');
$pdf->SetXY(40, 5);
$pdf->Cell(55);
$pdf->Cell(0, 10, 'Relevé Dimensional');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 5);
$pdf->MultiCell(40,5,"PPAP Nº. $numero \n Page: $pg");
$pdf->SetXY(5, 18);
$pdf->MultiCell(110,10,"",1);
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(110,5,"Organisation: $razao");
$pdf->SetXY(5, 23);
$pdf->MultiCell(110,5,"Code De Fournisseur: $cod_forn");
$pdf->SetXY(115, 18);
$pdf->MultiCell(90,25,"",1);
$pdf->SetXY(115, 18);
$pdf->MultiCell(90,5,"Numéro Piéce (Client): $cliente");
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(110,15,"",1);
$pdf->SetXY(5, 28);
$pdf->MultiCell(110,5,"Service D'Inspection: \n $local");
$pdf->SetXY(115, 23);
$pdf->MultiCell(90,5,"Nom de Piéce: $nome");
$pdf->SetXY(115, 28);
$pdf->MultiCell(90,5,"Niveau du changement du projet: $proj");
$pdf->SetXY(115, 33);
$pdf->MultiCell(90,5,"Niveau de la technologie de changement: $eng");

//linha 3
$pdf->SetFont('Arial','B',7.5);
$pdf->SetXY(5, 43);
$pdf->MultiCell(12,10,"Item",1,'C');
$pdf->SetXY(17, 43);
$pdf->MultiCell(43,10,"Dimension/Spécifications",1,'C');
$pdf->SetXY(60, 43);
$pdf->MultiCell(31,10,"Spécifications/Limites",1,'C');
$pdf->SetXY(91, 43);
$pdf->MultiCell(12,5,"Date \nd'essai",1,'C');
$pdf->SetXY(103, 43);
$pdf->MultiCell(12,5,"Quant.\nExam.",1,'C');
$pdf->SetXY(115, 43);
$pdf->MultiCell(72,10,"Resultat des Dimensions Relevées par le Organisation",1,'C');
$pdf->SetXY(187, 43);
$pdf->MultiCell(8,10,"Con",1,'C');
$pdf->SetXY(195, 43);
$pdf->MultiCell(10,5,"Non Conf",1,'C');

//linha 4
$y=53;
$sql=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo,car.lie,car.lse FROM apqp_car AS car, apqp_endi AS ensaio, apqp_endil AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER BY car.numero ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($y>=250){
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$y=53;
			$pg++;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,20);  // logo qualitmanager
			$pdf->Image('imagens/logo_chrysler.jpg',5,14,25,3);
			$pdf->Image('imagens/logo_ford.jpg',30,12,13);
			$pdf->Image('imagens/logo_gm.jpg',44,11,6);
			$pdf->SetXY(40, 0);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(35);
			$pdf->Cell(0, 10, 'Homologation de Piécas de Production');
			$pdf->SetXY(40, 5);
			$pdf->Cell(55);
			$pdf->Cell(0, 10, 'Relevé Dimensional');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 5);
			$pdf->MultiCell(40,5,"PPAP Nº. $numero \n Page: $pg");
			$pdf->SetXY(5, 18);
			$pdf->MultiCell(110,10,"",1);
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(110,5,"Organisation: $razao");
			$pdf->SetXY(5, 23);
			$pdf->MultiCell(110,5,"Code De Fournisseur: $cod_forn");
			$pdf->SetXY(115, 18);
			$pdf->MultiCell(90,25,"",1);
			$pdf->SetXY(115, 18);
			$pdf->MultiCell(90,5,"Numéro Piéce (Client): $cliente");
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(110,15,"",1);
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(110,5,"Service D'Inspection: \n $local");
			$pdf->SetXY(115, 23);
			$pdf->MultiCell(90,5,"Nom de Piéce: $nome");
			$pdf->SetXY(115, 28);
			$pdf->MultiCell(90,5,"Niveau du changement du projet: $proj");
			$pdf->SetXY(115, 33);
			$pdf->MultiCell(90,5,"Niveau de la technologie de changement: $eng");
			
			//linha 3
			$pdf->SetFont('Arial','B',7.5);
			$pdf->SetXY(5, 43);
			$pdf->MultiCell(12,10,"Item",1,'C');
			$pdf->SetXY(17, 43);
			$pdf->MultiCell(43,10,"Dimension/Spécifications",1,'C');
			$pdf->SetXY(60, 43);
			$pdf->MultiCell(31,10,"Spécifications/Limites",1,'C');
			$pdf->SetXY(91, 43);
			$pdf->MultiCell(12,5,"Date \nd'essai ",1,'C');
			$pdf->SetXY(103, 43);
			$pdf->MultiCell(12,5,"Quant.\nExam.",1,'C');
			$pdf->SetXY(115, 43);
			$pdf->MultiCell(72,10,"Resultat des Dimensions Relevées par le Organisation",1,'C');
			$pdf->SetXY(187, 43);
			$pdf->MultiCell(8,10,"Con",1,'C');
			$pdf->SetXY(195, 43);
			$pdf->MultiCell(10,5,"Non Conf",1,'C');
		}
		$tam1[0]=flinha($res["numero"],12);
		$tam1[1]=flinha("$res[descricao] - $res[espec]",43);	
		$tam1[2]=flinha("$res[lie] / $res[lse]",31);
		$tam1[3]=flinha("$data_teste",13);
		$tam1[4]=flinha("$res[quant_test]",12);
		$tam1[5]=1;
		$tam1[6]=flinha($res["forn"],72);
		if($tam1[6]==0){$tam1[6]=1;}
		$tam1[7]=1;
		$maxu=max($tam1);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxu - $tam1[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(12,$w,$res["numero"],0,'C');
		$pdf->SetXY(17,$y);
		$pdf->MultiCell(43,$w,"$res[descricao] - $res[espec]",0);
		if(!empty($res["lie"])&&!empty($res["lse"])){
			$pdf->SetXY(60,$y);
			$pdf->MultiCell(31,$w,"$res[lie] / $res[lse]",0,'C');
		}
		if(!empty($res["data_t"])){
			$data_teste=banco2data($res["data_t"]);
			$pdf->SetXY(90.5,$y);
			$pdf->MultiCell(13,$w,"$data_teste",0,'C');
		}
		if(!empty($res["quant_test"])){
			$pdf->SetXY(103,$y);
			$pdf->MultiCell(12,$w,"$res[quant_test]",0,'C');
		}
		$pdf->SetXY(115, $y);
		$pdf->MultiCell(72,$w,$res["forn"],0);
		$pdf->SetXY(187, $y);
		if($res["ok"]=="S"){$ok="X";}else{$ok="";}
		$pdf->MultiCell(8,$w,$ok,0,'C');
		if($res["ok"]=="N"){$ok="X";}else{$ok="";}
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok,0,'C');
		$y=($maxu*5)+$y;
		$pdf->Line(5,$y,205,$y);
		$pdf->Line(5,253,205,253);
		$pdf->Line(5,53,5,253);
		$pdf->Line(17,53,17,253);
		$pdf->Line(91,53,91,253);
		$pdf->Line(60,53,60,253);
		$pdf->Line(103,53,103,253);
		$pdf->Line(115,53,115,253);
		$pdf->Line(187,53,187,253);
		$pdf->Line(195,53,195,253);
		$pdf->Line(205,53,205,253);
	}
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
}
//ultima linha

		$pdf->Line(5,253,205,253);
		$pdf->Line(5,53,5,253);
		$pdf->Line(17,53,17,253);
		$pdf->Line(91,53,91,253);
		$pdf->Line(60,53,60,253);
		$pdf->Line(103,53,103,253);
		$pdf->Line(115,53,115,253);
		$pdf->Line(187,53,187,253);
		$pdf->Line(195,53,195,253);
		$pdf->Line(205,53,205,253);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(15, 253.5);
$pdf->MultiCell(8,3,"March  2006",'C');

$pdf->SetFont('Arial','B',7);
$pdf->SetXY(30, 254);
$pdf->MultiCell(20,5,"CFG-1003",'C');

$pdf->SetFont('Arial','',7);
$pdf->SetXY(105, 254);
$pdf->MultiCell(100,5,"Les informations générales de même qu'inacceptable pour tout le résultat des essais.",1);

$y=260;
$pdf->SetFont('Arial','',7);
$pdf->SetXY(5, $y);
$pdf->MultiCell(82,5,"Approved \n $resp[quem]",1,'');
$pdf->SetXY(87, $y);
$pdf->MultiCell(20,5,"Date \n ".banco2data($resp["dtquem"])."",1);
$pdf->SetXY(107, $y);
$pdf->MultiCell(80,5,"Signature du Fournisseur \n $resp[rep]",1,'');
$pdf->SetXY(187, $y);
$pdf->MultiCell(18,5,"Date \n ".banco2data($resp["dtrep"])."",1);


//fim
?>
