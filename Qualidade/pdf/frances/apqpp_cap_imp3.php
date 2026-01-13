<?php

$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
if(!empty($car)){
	$s="and car='$car'";
}
/*
$sql=mysql_query("SELECT * FROM apqp_cap WHERE peca='$pc' AND sit='1'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_car WHERE id='$resp[car]'");
if(mysql_num_rows($sql)) $resc=mysql_fetch_array($sql);
*/

//$pdf=new FPDF();
$pdf->AddPage();
if($logo=="OK"){
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
}else{
$pdf->Image('../empresa_logo/logo.jpg',5,1,25);
}
//campos do cabeçario
$cliente=$res["nomecli"];
$peca=$res["pecacli"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$razao=$rese["razao"];
$nome=$res["nome"];
$quem=$resp["quem"];
$data=banco2data($resp["dtquem"]);
$num=$resc["numero"];
$desc=$resc["descricao"];
$espec=$resc["espec"];
$lie=banco2valor3($resc["lie"]);
$lse=banco2valor3($resc["lse"]);
$obs=$resp["obs"];
$tam=completa(5,2);
$qtd=completa($resp["nli"],2);
$rev1=$res["rev"];
$por=$resp["por"];
$dtpor=banco2data($resp["dtpor"]);
$numero=$res["numero"];
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(55);
$pdf->Cell(0, 18, 'ÉTUDE DE CAPABILITÉ DU PROCESSUS');
$pdf->SetFont('Arial','',8);
$pg=1;
$pdf->SetXY(180, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP No. $numero \n Page: $pg");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 18);
$pdf->MultiCell(100,4,"Client \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 22);
$pdf->MultiCell(100,4,$cliente,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,4,"Numéro Pièce (Client) \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 22);
$pdf->MultiCell(100,4,$peca,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,4,"Numéro de Plan / Rév. / Date \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 22);
$pdf->MultiCell(100,4,$rev,0);
//linha 2
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 26);
$pdf->MultiCell(100,4,"Fournisseur \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 30);
$pdf->MultiCell(100,4,$razao,0);
$pdf->SetXY(105, 26);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(50,4,"Numéro Pièce (Fournisseur) \n ",1);
$pdf->SetXY(105, 30);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,4,$numero,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 26);
$pdf->MultiCell(50,4,"Revision Pièce (Fournisseur) \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 30);
$pdf->MultiCell(100,4,$rev1,0);
//linha 3
$pdf->SetXY(5, 34);
$pdf->MultiCell(100,4,"Nom de Pièce \n ",1);
$pdf->SetXY(5, 38);
$pdf->MultiCell(100,4,$nome,0);
$pdf->SetXY(105, 34);
$pdf->MultiCell(100,4,"Numéro d'Opération / Description \n ",1);
$pdf->SetXY(105, 38);
$pdf->MultiCell(100,4,$ope,0);
//linha 4
$pdf->SetXY(5, 42);
$pdf->MultiCell(15,4,"Caract Nº \n ",1);
$pdf->SetXY(5, 46);
$pdf->MultiCell(15,4,$num,0);
$pdf->SetXY(20, 42);
$pdf->MultiCell(30,4,"Caracteristique \n ",1);
$pdf->SetXY(20, 46);
$pdf->MultiCell(30,4,$desc,0);
$pdf->SetXY(50, 42);
$pdf->MultiCell(105,4,"Indice (Cavité/Moule) \n ",1);
$pdf->SetXY(50, 46);
$pdf->MultiCell(105,4,$espec,0);
$pdf->SetXY(155, 42);
$pdf->MultiCell(25,4,"LSL \n ",1);
$pdf->SetXY(155, 46);
$pdf->MultiCell(25,4,$lie,0);
$pdf->SetXY(180, 42);
$pdf->MultiCell(25,4,"USL \n ",1);
$pdf->SetXY(180, 46);
$pdf->MultiCell(25,4,$lse,0);
//linha 5
$pdf->SetXY(5, 50);
$pdf->MultiCell(100,4,"Exécuté par \n ",1);
$pdf->SetXY(5, 54);
$pdf->MultiCell(100,4,$por,0);
$pdf->SetXY(105, 50);
$pdf->MultiCell(30,4,"Date d'Étude \n ",1);
$pdf->SetXY(105, 54);
$pdf->MultiCell(100,4,$dtpor,0);
$pdf->SetXY(135, 50);
$pdf->MultiCell(40,4,"Taille (Sous-groupe) \n ",1);
$pdf->SetXY(135, 54);
$pdf->MultiCell(100,4,$tam,0);
$pdf->SetXY(175, 50);
$pdf->MultiCell(30,4,"Quant.(Sous-groupe) \n ",1);
$pdf->SetXY(175, 54);
$pdf->MultiCell(100,4,$qtd,0);
//linha 6
$pdf->SetXY(5, 58);
$pdf->MultiCell(200,4,"Remarques \n ",1);
$pdf->SetXY(5, 62);
$pdf->MultiCell(100,4,$obs,0);
//linha 6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 68);
$pdf->MultiCell(10,4,"",1,'C');
$pdf->SetXY(15, 68);
$pdf->MultiCell(25,4,"Échantillon #1",1,'C');
$pdf->SetXY(40, 68);
$pdf->MultiCell(25,4,"Échantillon #2",1,'C');
$pdf->SetXY(65, 68);
$pdf->MultiCell(25,4,"Échantillon #3",1,'C');
$pdf->SetXY(90, 68);
$pdf->MultiCell(25,4,"Échantillon #4",1,'C');
$pdf->SetXY(115, 68);
$pdf->MultiCell(25,4,"Échantillon #5",1,'C');
$pdf->SetXY(140, 68);
$pdf->MultiCell(30,4,"Moyenne",1,'C');
$pdf->SetXY(170, 68);
$pdf->MultiCell(35,4,"Étendues",1,'C');
//linha 7
$x=72;
for($i=1;$i<=$resp["nli"];$i++){
	if($x>=250){
		$x=72;
		$pdf->AddPage();
		if($logo=="OK"){
		$pdf->Image('empresa_logo/logo.jpg',5,1,25);
		}else{
		$pdf->Image('../empresa_logo/logo.jpg',5,1,25);
		}
		$pg=$pdf->PageNo();
		$pdf->SetXY(180, 5);
		$pdf->SetFont('Arial','B',8);
		$pdf->MultiCell(40,5,"PPAP No. $numero \n Page: $pg");
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 1);
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(55);
		$pdf->Cell(0, 18, 'ÉTUDE DE CAPABILITÉ DU PROCESSUS');
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 18);
		$pdf->MultiCell(100,4,"Client \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 22);
		$pdf->MultiCell(100,4,$cliente,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(105, 18);
		$pdf->MultiCell(50,4,"Numéro Pièce (Client) \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(105, 22);
		$pdf->MultiCell(100,4,$peca,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 18);
		$pdf->MultiCell(50,4,"Numéro de Plan / Rév. / Date \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 22);
		$pdf->MultiCell(100,4,$rev,0);
		//linha 2
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 26);
		$pdf->MultiCell(100,4,"Fournisseur \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 30);
		$pdf->MultiCell(100,4,$razao,0);
		$pdf->SetXY(105, 26);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(50,4,"Numéro Pièce (Fournisseur) \n ",1);
		$pdf->SetXY(105, 30);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(100,4,$numero,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 26);
		$pdf->MultiCell(50,4,"Revision Pièce (Fournisseur) \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 30);
		$pdf->MultiCell(100,4,$rev1,0);
		//linha 3
		$pdf->SetXY(5, 34);
		$pdf->MultiCell(100,4,"Nom de Pièce \n ",1);
		$pdf->SetXY(5, 38);
		$pdf->MultiCell(100,4,$nome,0);
		$pdf->SetXY(105, 34);
		$pdf->MultiCell(100,4,"Numéro d'Opération / Description \n ",1);
		$pdf->SetXY(105, 38);
		$pdf->MultiCell(100,4,$ope,0);
		//linha 4
		$pdf->SetXY(5, 42);
		$pdf->MultiCell(15,4,"Caract Nº \n ",1);
		$pdf->SetXY(5, 46);
		$pdf->MultiCell(15,4,$num,0);
		$pdf->SetXY(20, 42);
		$pdf->MultiCell(30,4,"Caracteristique \n ",1);
		$pdf->SetXY(20, 46);
		$pdf->MultiCell(30,4,$desc,0);
		$pdf->SetXY(50, 42);
		$pdf->MultiCell(105,4,"Indice (Cavité/Moule) \n ",1);
		$pdf->SetXY(50, 46);
		$pdf->MultiCell(105,4,$espec,0);
		$pdf->SetXY(155, 42);
		$pdf->MultiCell(25,4,"LSL \n ",1);
		$pdf->SetXY(155, 46);
		$pdf->MultiCell(25,4,$lie,0);
		$pdf->SetXY(180, 42);
		$pdf->MultiCell(25,4,"USL \n ",1);
		$pdf->SetXY(180, 46);
		$pdf->MultiCell(25,4,$lse,0);
		//linha 5
		$pdf->SetXY(5, 50);
		$pdf->MultiCell(100,4,"Exécuté par \n ",1);
		$pdf->SetXY(5, 54);
		$pdf->MultiCell(100,4,$por,0);
		$pdf->SetXY(105, 50);
		$pdf->MultiCell(30,4,"Date d'Étude \n ",1);
		$pdf->SetXY(105, 54);
		$pdf->MultiCell(100,4,$dtpor,0);
		$pdf->SetXY(135, 50);
		$pdf->MultiCell(40,4,"Taille (Sous-groupe) \n ",1);
		$pdf->SetXY(135, 54);
		$pdf->MultiCell(100,4,$tam,0);
		$pdf->SetXY(175, 50);
		$pdf->MultiCell(30,4,"Quant.(Sous-groupe) \n ",1);
		$pdf->SetXY(175, 54);
		$pdf->MultiCell(100,4,$qtd,0);
		//linha 6
		$pdf->SetXY(5, 58);
		$pdf->MultiCell(200,4,"Remarques \n ",1);
		$pdf->SetXY(5, 62);
		$pdf->MultiCell(100,4,$obs,0);
	}
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, $x);
	$pdf->MultiCell(10,4,completa($i,2),1,'C');
	$pdf->SetXY(15, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5-4)]),1,'C');
	$pdf->SetXY(40, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5-3)]),1,'C');
	$pdf->SetXY(65, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5-2)]),1,'C');
	$pdf->SetXY(90, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5-1)]),1,'C');
	$pdf->SetXY(115, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5)]),1,'C');
	$pdf->SetXY(140, $x);
	$pdf->MultiCell(30,4,banco2valor3($resp["x".($i)]),1,'C');
	$pdf->SetXY(170, $x);
	$pdf->MultiCell(35,4,banco2valor3($resp["r".($i)]),1,'C');
	$x=$x+4;
}
$x=$x+2;
//linha 6
if($x>=200){
	$x=85;
	$pdf->AddPage();
	if($logo=="OK"){
		$pdf->Image('empresa_logo/logo.jpg',5,1,25);
	}else{
		$pdf->Image('../empresa_logo/logo.jpg',5,1,25);
	}
	$pg=$pdf->PageNo();
	$pdf->SetXY(5, 1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(55);
	$pdf->Cell(0, 18, 'ÉTUDE DE CAPABILITÉ DU PROCESSUS');
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(180, 8);
	$pg=$pdf->PageNo();
	$pdf->MultiCell(65,5,"Page: $pg");
	$pdf->SetXY(5, 18);
	$pdf->MultiCell(100,4,"Client \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 22);
	$pdf->MultiCell(100,4,$cliente,0);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(105, 18);
	$pdf->MultiCell(50,4,"Numéro Pièce (Client) \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(105, 22);
	$pdf->MultiCell(100,4,$peca,0);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 18);
	$pdf->MultiCell(50,4,"Numéro de Plan / Rév. / Date \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 22);
	$pdf->MultiCell(100,4,$rev,0);
	//linha 2
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 26);
	$pdf->MultiCell(100,4,"Fournisseur \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 30);
	$pdf->MultiCell(100,4,$razao,0);
	$pdf->SetXY(105, 26);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(50,4,"Numéro Pièce (Fournisseur) \n ",1);
	$pdf->SetXY(105, 30);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(100,4,$numero,0);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 26);
	$pdf->MultiCell(50,4,"Revision Pièce (Fournisseur) \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 30);
	$pdf->MultiCell(100,4,$rev1,0);
	//linha 3
	$pdf->SetXY(5, 34);
	$pdf->MultiCell(100,4,"Nom de Pièce \n ",1);
	$pdf->SetXY(5, 38);
	$pdf->MultiCell(100,4,$nome,0);
	$pdf->SetXY(105, 34);
	$pdf->MultiCell(100,4,"Numéro d'Opération / Description \n ",1);
	$pdf->SetXY(105, 38);
	$pdf->MultiCell(100,4,$ope,0);
	//linha 4
	$pdf->SetXY(5, 42);
	$pdf->MultiCell(15,4,"Caract Nº \n ",1);
	$pdf->SetXY(5, 46);
	$pdf->MultiCell(15,4,$num,0);
	$pdf->SetXY(20, 42);
	$pdf->MultiCell(30,4,"Caracteristique \n ",1);
	$pdf->SetXY(20, 46);
	$pdf->MultiCell(30,4,$desc,0);
	$pdf->SetXY(50, 42);
	$pdf->MultiCell(105,4,"Indice (Cavité/Moule) \n ",1);
	$pdf->SetXY(50, 46);
	$pdf->MultiCell(105,4,$espec,0);
	$pdf->SetXY(155, 42);
	$pdf->MultiCell(25,4,"LSL \n ",1);
	$pdf->SetXY(155, 46);
	$pdf->MultiCell(25,4,$lie,0);
	$pdf->SetXY(180, 42);
	$pdf->MultiCell(25,4,"USL \n ",1);
	$pdf->SetXY(180, 46);
	$pdf->MultiCell(25,4,$lse,0);
	//linha 5
	$pdf->SetXY(5, 50);
	$pdf->MultiCell(100,4,"Exécuté par \n ",1);
	$pdf->SetXY(5, 54);
	$pdf->MultiCell(100,4,$por,0);
	$pdf->SetXY(105, 50);
	$pdf->MultiCell(30,4,"Date d'Étude \n ",1);
	$pdf->SetXY(105, 54);
	$pdf->MultiCell(100,4,$dtpor,0);
	$pdf->SetXY(135, 50);
	$pdf->MultiCell(40,4,"Taille (Sous-groupe) \n ",1);
	$pdf->SetXY(135, 54);
	$pdf->MultiCell(100,4,$tam,0);
	$pdf->SetXY(175, 50);
	$pdf->MultiCell(30,4,"Quant.(Sous-groupe) \n ",1);
	$pdf->SetXY(175, 54);
	$pdf->MultiCell(100,4,$qtd,0);
	//linha 6
	$pdf->SetXY(5, 58);
	$pdf->MultiCell(200,4,"Remarques \n ",1);
	$pdf->SetXY(5, 62);
	$pdf->MultiCell(100,4,$obs,0);
}
$pdf->SetXY(5, $x);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(200,5,"RÉSULTATS D'ÉTUDE DE CAPABILITÉ",0,'C');
$x=$x+10;
//linha 7
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Les informations de Prélèvement d'échantillons",1,'C');
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"",1);
//linha 8
$pdf->SetXY(5, $x);
$pdf->MultiCell(35,5,"LSL: ".banco2valor3($resc["lie"])."",0,'C');
$pdf->SetXY(40, $x);
$pdf->MultiCell(35,5,"USL:".banco2valor3($resc["lse"])."",0,'C');
$pdf->SetXY(75, $x);
$pdf->MultiCell(35,5,"X:".banco2valor3($resp["xbar"])."",0,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(30,5,"R:".banco2valor3($resp["rbar"])."",0,'C');
$pdf->SetXY(135, $x);
$pdf->MultiCell(30,5,"Valeur Min.:".banco2valor3($resp["min"])."",0,'C');
$pdf->SetXY(165, $x);
$pdf->MultiCell(40,5,"Valeur Max.:".banco2valor3($resp["max"])."",0,'C');
//linha nova
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Points extérieurs de spécification: ".$resp["pf"]."",1,'L');
$pdf->SetXY(132, $x);
$pdf->MultiCell(36,5,"Min. Arrange:".banco2valor3($resp["rmin"])."",0,'C');
$pdf->SetXY(169, $x);
$pdf->MultiCell(32,5,"Max. Arrange:".banco2valor3($resp["rmax"])."",0,'C');
//linha 9
$x=$x+10;
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Limites de Contrôle",1,'C');
//linha 10
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Carte de Moyennes",1,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Carte de Étendues",1,'C');
//linha 11
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Bas Limite de Contrôle (LCL): ".banco2valor3($resp["lcl"])."",1);
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Bas Limite de Controle (LCL): ".banco2valor3(0)."",1);
//linha 12
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Limite de Contrôle Supérieure (UCL): ".banco2valor3($resp["uclx"])."",1);
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Limite de Contrôle Supérieure (UCL): ".banco2valor3($resp["uclr"])."",1);
//linha nova P_F media e amp
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Points Extérieurs des Limites de Contrôle: ".$resp["mpf"]."",1);
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Points Extérieurs des Limites de Contrôle: ".$resp["apf"]."",1);
//linha 13
$x=$x+10;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Capabilité",1,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Performance",1,'C');
//linha 14
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,10,"",1,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,10,"",1,'C');
$pdf->SetXY(7, $x);
$pdf->MultiCell(60,5,"Écart Type: ".banco2valor3($resp["sigma"])."",0,'C');
$pdf->SetXY(107, $x);
$pdf->MultiCell(60,5,"Écart Type: ".banco2valor3($resp["sigma"])."",0,'C');
$pdf->SetXY(57, $x);
$pdf->MultiCell(65,5,"Cp: ".banco2valor3($resp["cp"])."",0,'C');
$pdf->SetXY(157, $x);
$pdf->MultiCell(65,5,"Pp: ".banco2valor3($resp["pp"])."",0,'C');
$x=$x+5;
$pdf->SetXY(7, $x);
$pdf->MultiCell(65,5,"CR: ".banco2valor3($resp["cr"])."",0,'C');
$pdf->SetXY(107, $x);
$pdf->MultiCell(65,5,"PR: ".banco2valor3($resp["pr"])."",0,'C');
$pdf->SetXY(57, $x);
$pdf->MultiCell(65,5,"CpK: ".banco2valor3($resp["cpk"])."",0,'C');
$pdf->SetXY(157, $x);
$pdf->MultiCell(65,5,"PpK: ".banco2valor3($resp["ppk"])."",0,'C');
//linha 15
//linha 16
//linha 17
$x=$x+10;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Disposição",1,'C');
//linha 18
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"",1,'C');
$pdf->SetXY(5, $x);
if($resp["sit"]==0){ $show="pendente"; }elseif($resp["sit"]==1){ $show="aprovado"; }else{ $show="reprovado"; }
$pdf->MultiCell(65,5,"Disposition: ".$show."",0,'C');
$pdf->SetXY(70, $x);
$pdf->MultiCell(65,5,"Responsable: ".$resp["quem"]."",0,'C');
$pdf->SetXY(135,$x);
$pdf->MultiCell(65,5,"Date: ".banco2data($resp["dtquem"])."",0,'C');
//em baixo rodape
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
//fim
//$pdf->Output('apqo_cap3.pdf','I');
?>
