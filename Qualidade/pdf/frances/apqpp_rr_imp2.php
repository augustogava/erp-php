<?php
//include('../conecta.php');
//require('fpdf.php');
//$pc=$_SESSION["mpc"];
//$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);

//$pdf=new FPDF();
$pdf->AddPage();
$pg=1;

	$pdf->SetXY(180, 5);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(40,5,"PPAP No. $numero \n Page: $pg");
	$pdf->SetFont('Arial','',8);
	$pdf->Image('empresa_logo/logo.jpg',5,1,25);
	$pdf->SetXY(5, 1);
	$pdf->SetFont('Arial','B',14,'C');
	$pdf->Cell(40);
	$pdf->Cell(0, 18, 'ÉTUDE DE RÉPÉTABILITÉ ET REPRODUCTIBILITÉ');
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 18);
	$pdf->MultiCell(80,5,"Client \n $cliente",1);
	$pdf->SetXY(85, 18);
	$pdf->MultiCell(60,5,"Numéro de Pièce (Client) \n $peca",1);
	$pdf->SetXY(145, 18);
	$pdf->MultiCell(60,5,"Numéro de Plan / Rév. / Date \n $rev ",1);
	//linha 2
	$pdf->SetXY(5, 28);
	$pdf->MultiCell(80,5,"Fournisseur\n $razao",1);
	$pdf->SetXY(85, 28);
	$pdf->MultiCell(60,5,"Numéro de Pièce (Fournisseur) \n $num",1);
	$pdf->SetXY(145, 28);
	$pdf->MultiCell(60,5,"Révision Pièce (Fournisseur) \n $revi",1);
	//linha 3
	$pdf->SetXY(5, 38);
	$pdf->MultiCell(80,5,"Nom de Pièce \n $nome",1);
	$pdf->SetXY(85, 38);
	$pdf->MultiCell(60,5,"Code Équipement de Mesure \n $disp",1);
	$pdf->SetXY(145, 38);
	$pdf->MultiCell(60,5,"Nom D'équipment de Mesure\n $dispo",1);
	//linha 4
	$pdf->SetXY(5, 48);
	$pdf->MultiCell(40,5,"Caract. Nº \n $num",1);
	$pdf->SetXY(45, 48);
	$pdf->MultiCell(40,5,"Caractéristique \n $carac",1);
	$pdf->SetXY(85, 48);
	$pdf->MultiCell(60,5,"Specification \n $espec",1);
	$pdf->SetXY(145, 48);
	$pdf->MultiCell(60,5,"Tolérance \n $tol",1);
	//linhs 5
	$pdf->SetXY(5,58);
	$pdf->MultiCell(80,5,"Exécuté Par \n $por",1);
	$pdf->SetXY(85, 58);
	$pdf->MultiCell(30,5,"Date d'Étude \n $data",1);
	$pdf->SetXY(115, 58);
	$pdf->MultiCell(30,5,"# Cicles \n $ens",1);
	$pdf->SetXY(145, 58);
	$pdf->MultiCell(30,5,"# Opérateurs \n $ope",1);
	$pdf->SetXY(175, 58);
	$pdf->MultiCell(30,5,"# Échantillons \n $amo",1);
	//linha 6
	$pdf->SetXY(5, 68);
	$pdf->MultiCell(200,5,"Remarques \n $obs",1);
	//linha 7
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(5, 80);
	$pdf->MultiCell(10,10,"Nº",1);
	$pdf->SetXY(15, 80);
	$pdf->MultiCell(70,5,"Opérateur A",1,'C');
	$pdf->SetXY(85, 80);
	$pdf->MultiCell(60,5,"Opérateur B",1,'C');
	$pdf->SetXY(145, 80);
	$pdf->MultiCell(60,5,"Opérateur C",1,'C');
	$pdf->SetXY(15, 85);
	$pdf->MultiCell(20,5,"Cicle 1",1,'C');
	$pdf->SetXY(35, 85);
	$pdf->MultiCell(20,5,"Cicle 2",1,'C');
	$pdf->SetXY(55, 85);
	$pdf->MultiCell(30,5,"Cicle 3",1,'C');
	$pdf->SetXY(85, 85);
	$pdf->MultiCell(20,5,"Cicle 1",1,'C');
	$pdf->SetXY(105, 85);
	$pdf->MultiCell(20,5,"Cicle 2",1,'C');
	$pdf->SetXY(125, 85);
	$pdf->MultiCell(20,5,"Média",1,'C');
	$pdf->SetXY(145, 85);
	$pdf->MultiCell(20,5,"Cicle 1",1,'C');
	$pdf->SetXY(165, 85);
	$pdf->MultiCell(20,5,"Cicle 2",1,'C');
	$pdf->SetXY(185, 85);
	$pdf->MultiCell(20,5,"Cicle 3",1,'C');
//linha 8
$pdf->SetFont('Arial','',8);
$y=90;
for($i=1;$i<=10;$i++){
	if(y>=250){
		$y=90;
		$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
		$pdf->SetXY(5, 1);
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(40);
		$pdf->Cell(0, 18, 'ÉTUDE DE RÉPÉTABILITÉ ET REPRODUCTIBILITÉ');
		$$pdf->SetFont('Arial','',8);
		$pg=$pdf->PageNo();
		$pdf->SetFont('Arial','B',8);
		$pdf->MultiCell(40,5,"PPAP No. $numero \n Page: $pg");
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 18);
		$pdf->MultiCell(80,5,"Client \n $cliente",1);
		$pdf->SetXY(85, 18);
		$pdf->MultiCell(60,5,"Numéro de Pièce (Client) \n $peca",1);
		$pdf->SetXY(145, 18);
		$pdf->MultiCell(60,5,"Numéro de Plan / Rév. / Date \n $rev ",1);
		//linha 2
		$pdf->SetXY(5, 28);
		$pdf->MultiCell(80,5,"Fournisseur\n $razao",1);
		$pdf->SetXY(85, 28);
		$pdf->MultiCell(60,5,"Numéro de Pièce (Fournisseur) \n $num",1);
		$pdf->SetXY(145, 28);
		$pdf->MultiCell(60,5,"Révision Pièce (Fournisseur) \n $revi",1);
		//linha 3
		$pdf->SetXY(5, 38);
		$pdf->MultiCell(80,5,"Nom de Pièce \n $nome",1);
		$pdf->SetXY(85, 38);
		$pdf->MultiCell(60,5,"Code Équipement de Mesure \n $disp",1);
		$pdf->SetXY(145, 38);
		$pdf->MultiCell(60,5,"Nom D'équipment de Mesure\n $dispo",1);
		//linha 4
		$pdf->SetXY(5, 48);
		$pdf->MultiCell(40,5,"Caract. Nº \n $num",1);
		$pdf->SetXY(45, 48);
		$pdf->MultiCell(40,5,"Caractéristique \n $carac",1);
		$pdf->SetXY(85, 48);
		$pdf->MultiCell(60,5,"Specification \n $espec",1);
		$pdf->SetXY(145, 48);
		$pdf->MultiCell(60,5,"Tolérance \n $tol",1);
		//linhs 5
		$pdf->SetXY(5,58);
		$pdf->MultiCell(80,5,"Exécuté Par \n $por",1);
		$pdf->SetXY(85, 58);
		$pdf->MultiCell(30,5,"Date d'Étude \n $data",1);
		$pdf->SetXY(115, 58);
		$pdf->MultiCell(30,5,"# Cicles \n $ens",1);
		$pdf->SetXY(145, 58);
		$pdf->MultiCell(30,5,"# Opérateurs \n $ope",1);
		$pdf->SetXY(175, 58);
		$pdf->MultiCell(30,5,"# Échantillons \n $amo",1);
		//linha 6
		$pdf->SetXY(5, 68);
		$pdf->MultiCell(200,5,"Remarques \n $obs",1);
		//linha 7
		$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(5, 80);
		$pdf->MultiCell(10,10,"Nº",1);
		$pdf->SetXY(15, 80);
		$pdf->MultiCell(70,5,"Opérateur A",1,'C');
		$pdf->SetXY(85, 80);
		$pdf->MultiCell(60,5,"Opérateur B",1,'C');
		$pdf->SetXY(145, 80);
		$pdf->MultiCell(60,5,"Opérateur C",1,'C');
		$pdf->SetXY(15, 85);
		$pdf->MultiCell(20,5,"Cicle 1",1,'C');
		$pdf->SetXY(35, 85);
		$pdf->MultiCell(20,5,"Cicle 2",1,'C');
		$pdf->SetXY(55, 85);
		$pdf->MultiCell(30,5,"Cicle 3",1,'C');
		$pdf->SetXY(85, 85);
		$pdf->MultiCell(20,5,"Cicle 1",1,'C');
		$pdf->SetXY(105, 85);
		$pdf->MultiCell(20,5,"Cicle 2",1,'C');
		$pdf->SetXY(125, 85);
		$pdf->MultiCell(20,5,"Média",1,'C');
		$pdf->SetXY(145, 85);
		$pdf->MultiCell(20,5,"Cicle 1",1,'C');
		$pdf->SetXY(165, 85);
		$pdf->MultiCell(20,5,"Cicle 2",1,'C');
		$pdf->SetXY(185, 85);
		$pdf->MultiCell(20,5,"Cicle 3",1,'C');
	}
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(10,5,completa($i,2),1);
	$pdf->SetXY(15, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["a1".($i)]),1);
	$pdf->SetXY(35, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["a2".($i)]),1);
	$pdf->SetXY(55, $y);
	$pdf->MultiCell(30,5,banco2valor3($resp["a3".($i)]),1);
	$pdf->SetXY(85, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["b1".($i)]),1);
	$pdf->SetXY(105, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["b2".($i)]),1);
	$pdf->SetXY(125, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["b3".($i)]),1);
	$pdf->SetXY(145, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["c1".($i)]),1);
	$pdf->SetXY(165, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["c2".($i)]),1);
	$pdf->SetXY(185, $y);
	$pdf->MultiCell(20,5,banco2valor3($resp["c3".($i)]),1);
	$y=$y+5;
}
$y = $y + 2;
//linha 9
if($y>=180){
	$y=80;
	$pdf->AddPage();
	$pdf->Image('empresa_logo/logo.jpg',5,1,25);
	$pdf->SetXY(5, 1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(40);
	$pdf->Cell(0, 18, 'ÉTUDE DE RÉPÉTABILITÉ ET REPRODUCTIBILITÉ');
	$pdf->SetXY(5, 18);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(65,5,"Client \n $cliente",1);
	$pdf->SetXY(70, 18);
	$pdf->MultiCell(70,5,"Numéro de Pièce (Client) \n $peca",1);
	$pdf->SetXY(140, 18);
	$pdf->MultiCell(65,5,"Rev. / Data do Desenho \n $rev",1);
	//linha 2
	$pdf->SetXY(5, 28);
	$pdf->MultiCell(100,5,"Fournisseur\n $razao",1);
	$pdf->SetXY(105, 28);
	$pdf->MultiCell(100,5,"Nom de Pièce \n $nome",1);
	//linha 3
	$pdf->SetXY(5, 38);
	$pdf->MultiCell(100,5,"Code Équipement de Mesure \n $disp",1);
	$pdf->SetXY(105, 38);
	$pdf->MultiCell(70,5,"Nom D'équipment de Mesure\n $dispo",1);
	$pdf->SetXY(175, 38);
	$pdf->MultiCell(30,5,"Date d'Étude \n $data",1);
	//linha 4
	$pdf->SetXY(5, 48);
	$pdf->MultiCell(60,5,"Caract. Nº \n $num",1);
	$pdf->SetXY(65, 48);
	$pdf->MultiCell(40,5,"Caractéristique \n $carac",1);
	$pdf->SetXY(105, 48);
	$pdf->MultiCell(60,5,"Specification \n $espec",1);
	$pdf->SetXY(165, 48);
	$pdf->MultiCell(40,5,"Tolérance \n $tol",1);
	//linhs 5
	$pdf->SetXY(5,58);
	$pdf->MultiCell(100,5,"Exécuté Par \n $por",1);
	$pdf->SetXY(105, 58);
	$pdf->MultiCell(35,5,"# Cicles \n $ens",1);
	$pdf->SetXY(140, 58);
	$pdf->MultiCell(35,5,"# Opérateurs \n $ope",1);
	$pdf->SetXY(175, 58);
	$pdf->MultiCell(30,5,"# Échantillons \n $amo",1);
	//linha 6
	$pdf->SetXY(5, 68);
	$pdf->MultiCell(200,5,"Remarques \n $obs",1);
}
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, $y);
$pdf->MultiCell(200,5,"Resultats de Étude",1,'C');
$tol2=valor2banco($tol);
	//linha 1
	$y=$y+5;
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(65,5,"",1);
	$pdf->SetXY(70, $y);
	$pdf->MultiCell(65,5,"Analyse D'équipement de Mesure",1,'C');
	$pdf->SetXY(135, $y);
	$pdf->MultiCell(35,5,"% Variação Total",1,'C');
	$pdf->SetXY(170, $y);
	$pdf->MultiCell(35,5,"% Tolérance",1,'C');
	//linha 2
	$y=$y+5;
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(65,5,"Répétabilité - Variation D'equipment",1);
	$pdf->SetXY(70, $y);
	$pdf->MultiCell(65,5,banco2valor3($resp["ev"]),1);
	$pdf->SetXY(135, $y);
	$pdf->MultiCell(35,5,banco2valor3($resp["pev"]),1);
	$pdf->SetXY(170, $y);
	
	if(!($tol2=="0")){
		$pdf->MultiCell(35,5,banco2valor3(($resp["ev"]/$tol2)*100),1);
	}
	//linha 3
	$y=$y+5;
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(65,5,"Reproductibilité - Variation D'opérateur",1);
	$pdf->SetXY(70, $y);
	$pdf->MultiCell(65,5,banco2valor3($resp["ov"]),1);
	$pdf->SetXY(135, $y);
	$pdf->MultiCell(35,5,banco2valor3($resp["pov"]),1);
	$pdf->SetXY(170, $y);
	if(!($tol2=="0")){
		$pdf->MultiCell(35,5,banco2valor3(($resp["ov"]/$tol2)*100),1);
	}
	//linha 4
	$y=$y+5;
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(65,5,"Répétabilité et Reproductibilité (R&R)",1);
	$pdf->SetXY(70, $y);
	$pdf->MultiCell(65,5,banco2valor3($resp["rr"]),1);
	$pdf->SetXY(135, $y);
	$pdf->MultiCell(35,5,banco2valor3($resp["prr"]),1);
	$pdf->SetXY(170, $y);
	if(!($tol2=="0")){
		$pdf->MultiCell(35,5,banco2valor3(($resp["rr"]/$tol2)*100),1);
	}
	//linha 5
	$y=$y+5;
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(65,5,"Variation de Pièces",1);
	$pdf->SetXY(70, $y);
	$pdf->MultiCell(65,5,banco2valor3($resp["pv"]),1);
	$pdf->SetXY(135, $y);
	$pdf->MultiCell(35,5,banco2valor3($resp["ppv"]),1);
	//linha 6
	$y=$y+5;
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(65,5,"Variation du Procecssus",1);
	$pdf->SetXY(70, $y);
	$pdf->MultiCell(65,5,banco2valor3($resp["tv"]),1);

//linha 10
$y=$y+7;
$pdf->SetXY(5, $y);
$pdf->MultiCell(200,5,"Dernière Disposition",1,'C');
//linha 11
$y=$y+5;
$pdf->SetXY(5, $y);
$pdf->MultiCell(200,5,"",1);
$pdf->SetXY(5, $y);
if($resp["sit"]==0){ $ok="pendente"; }elseif($resp["sit"]==1){ $ok="aprovado"; }else{ $ok="reprovado"; }
$pdf->MultiCell(65,5,"Disposition: $ok");
$pdf->SetXY(70, $y);
$pdf->MultiCell(65,5,"Responsable: $resp[quem]");
$pdf->SetXY(135, $y);
$pdf->MultiCell(70,5,"Date: ".banco2data($resp["dtquem"])."");

//linha 12 LAUDO
$y=$y+7;
$pdf->SetXY(5, $y);
$pdf->MultiCell(200,5,"Opinion",1,'C');
//linha 13
$y=$y+5;
$pdf->SetXY(5, $y);
$pdf->MultiCell(200,20,"",1);

$pdf->SetXY(30, $y);
$pdf->MultiCell(65,5,"Variation Totale");
$pdf->SetXY(60, $y);
$pdf->MultiCell(65,5,"Tolérance");
//CAIXA
$y=$y+5;
$pdf->SetXY(39, $y);
$pdf->MultiCell(4,4,"",1);
$pdf->SetXY(39, $y);
if($vart<"10"){
	$pdf->MultiCell(10,5,"X");
}
$pdf->SetXY(66, $y);
$pdf->MultiCell(4,4,"",1);
$pdf->SetXY(66, $y);
if($tole<"10"){
	$pdf->MultiCell(10,5,"X");
}
$pdf->SetXY(90, $y);
$pdf->MultiCell(65,5,"% R&R <10 %");
$pdf->SetXY(140, $y);
$pdf->MultiCell(65,5,"- Système Proportionné");
//CAIXA2
$y=$y+5;
$pdf->SetXY(39, $y);
$pdf->MultiCell(4,4,"",1);
$pdf->SetXY(39, $y);
if(($vart>"10") and ($vart<"30")){ 
	$pdf->MultiCell(10,5,"X");
}
$pdf->SetXY(66, $y);
$pdf->MultiCell(4,4,"",1);
$pdf->SetXY(66, $y);
if(($tole>"10") and ($tole<"30")){ 
	$pdf->MultiCell(10,5,"X");
}
$pdf->SetXY(90, $y);
$pdf->MultiCell(65,5,"10 % < R%R < 30 %");
$pdf->SetXY(140, $y);
$pdf->MultiCell(65,5,"- Système Acceptable (Il doit être amélioré)");
//CAIXA3
$y=$y+5;
$pdf->SetXY(39, $y);
$pdf->MultiCell(4,4,"",1);
$pdf->SetXY(39, $y);
if($vart>30){ 
	$pdf->MultiCell(10,5,"X");
}
$pdf->SetXY(66, $y);
$pdf->MultiCell(4,4,"",1);
$pdf->SetXY(66, $y);
if($tole>30){ 
	$pdf->MultiCell(10,5,"X");
}
$pdf->SetXY(90, $y);
$pdf->MultiCell(65,5,"% R&R > 30 %");
$pdf->SetXY(140, $y);
$pdf->MultiCell(65,5,"- Système Insatisfaisant (Désapprouvé)");

//em baixo rodape
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

//fim
//$pdf->Output('apqp_rr2.pdf','I');
?>
