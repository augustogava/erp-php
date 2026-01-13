<?php
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_apro WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$numero=$res["numero"];
$pg=1;
$pdf->AddPage('L');
$tam="";
$max="";
$pdf->Image('imagens/logo_ford.jpg',5,1,25);
$pdf->Image('imagens/logo_gm.jpg',45,1,10);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 18, 'RAPPORT D´HOMOLOGATION D´ASPECT');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 18);
$pdf->MultiCell(60,5,"Client \n $res[nomecli]",1);
$pdf->SetXY(65, 18);
$pdf->MultiCell(70,5,"Numéro de Piéce (Client) \n $res[pecacli]",1);
$pdf->SetXY(135, 18);
$pdf->MultiCell(60,5,"Numéro de Plan \n $res[desenhoc]",1);
$pdf->SetXY(195, 18);
$pdf->MultiCell(95,5,"Application (Vehicules) \n $res[aplicacao]",1);
$pdf->SetXY(260, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
$pdf->SetFont('Arial','',8);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(75,5,"Nom de la Piéce \n $res[nome]",1);
$pdf->SetXY(80, 28);
$pdf->MultiCell(75,5,"Code Acheteur \n $resp[comprador]",1);
$pdf->SetXY(155, 28);
$pdf->MultiCell(105,5,"Indice de Révision \n $res[niveleng]",1);
$pdf->SetXY(260, 28);
$pdf->MultiCell(30,5,"Date \n ".banco2data($res["dteng"])."",1);
//linha3
$pdf->SetXY(5, 38);
$pdf->MultiCell(100,5,"Nom du Fournisseur \n a$rese[razao]",1);
$pdf->SetXY(105, 38);
$pdf->MultiCell(50,5,"Numéro de Piéce (Fournisseur) \n  $res[numero] - $res[rev]",1);
$pdf->SetXY(155,38);
$pdf->MultiCell(105,5,"Site de Production \n $resp[local]",1);
$pdf->SetXY(260, 38);
$pdf->MultiCell(30,5,"Code Fournisseur \n $resp[seilaquecodigoehesse]",1);
//linha4
	//coluna 1
	$pdf->SetXY(5, 48);
	$pdf->MultiCell(180,20,"",1);
	//linha 4-1-1
		$pdf->SetXY(5, 48);
		$pdf->MultiCell(40,5,"Motif de la Soumission");
		$pdf->SetXY(45, 49);
		if($resp["razao1"]=="1"){ $show1="X"; }else{ $show1=" "; }
		$pdf->MultiCell(5,5,"$show1",1,'C');
		$pdf->SetXY(50, 48);
		$pdf->MultiCell(40,5,"PSQ Certification Piéce");
		$pdf->SetXY(90, 49);
		if($resp["razao1"]=="2"){ $show2="X"; }else{ $show2=" "; }
		$pdf->MultiCell(5,5,"$show2",1,'C');
		$pdf->SetXY(95, 48);
		$pdf->MultiCell(40,5,"Eclaton Special");
		$pdf->SetXY(135, 49);
		if($resp["razao2"]=="3"){ $show3="X"; }else{ $show3=" "; }
		$pdf->MultiCell(5,5,"$show3",1,'C');
		$pdf->SetXY(140, 48);
		$pdf->MultiCell(40,5,"Re-Soumission");
	//linha 4-1-2
		$pdf->SetXY(45, 59);
		if($resp["razao2"]=="4"){ $show4="X"; }else{ $show4=" "; }
		$pdf->MultiCell(5,5,"$show4",1,'C');
		$pdf->SetXY(50, 58);
		$pdf->MultiCell(40,5,"Pré-Structure");
		$pdf->SetXY(90, 59);
		if($resp["razao2"]=="1"){ $show5="X"; }else{ $show5=" "; }
		$pdf->MultiCell(5,5,"$show5",1,'C');
		$pdf->SetXY(95, 58);
		$pdf->MultiCell(40,5,"Exped. Premlére Production");
		$pdf->SetXY(135, 59);
		if($resp["razao2"]=="2"){ $show6="X"; }else{ $show6=" "; }
		$pdf->MultiCell(5,5,"$show6",1,'C');
		$pdf->SetXY(140, 58);
		$pdf->MultiCell(55,5,"Modifications Techniques");
	//coluna 2
	$pdf->SetXY(185, 48);
	$pdf->MultiCell(105,20,"",1);
	//linha 4-2-1
		$pdf->SetXY(185, 48);
		$pdf->MultiCell(40,5,"Autre");
	//linha 4-2-2
		$pdf->SetXY(185, 58);
		$pdf->MultiCell(40,5,"");
//linha 5 
	$pdf->SetXY(5, 70);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(285,5,"EVALUATION D´ASPECT",1,'C');
	$pdf->SetXY(5, 75);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(185,5,"SOURCE FOURNISSEUR ET INFORMATION SURLA STRUCTURE GRANULAIRE",1,'C');
	$pdf->SetXY(5, 80);
	$pdf->MultiCell(185,30,"",1);
	$pdf->SetXY(5, 80);
	$pdf->MultiCell(185,5,"$resp[aval]",0);
	//tabela direta
	$pdf->SetXY(190, 75);
	$pdf->MultiCell(40,10,"Evaluation Pré-Structure",1,'C');
	$pdf->SetXY(230, 75);
	$pdf->MultiCell(60,5,"Representant du Client \n Signature et Date ",1,'C');
	$pdf->SetXY(190, 85);
	$pdf->MultiCell(40,10,"Corriger Et Continuer",1,'C');
	$pdf->SetXY(230, 85);
	$pdf->MultiCell(60,10," ",1,'C');
	$pdf->SetXY(190, 95);
	$pdf->MultiCell(40,10,"Corrigez et Resoumettez",1,'C');
	$pdf->SetXY(230, 95);
	$pdf->MultiCell(60,10,"",1,'C');
	$pdf->SetXY(190, 105);
	$pdf->MultiCell(40,5,"Homologuer Structure",1,'C');
	$pdf->SetXY(230, 105);
	$pdf->MultiCell(60,5,"",1,'C');
//linha 6
	//linha 1
	$pdf->SetXY(5, 112);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(15,5,"Suffixe de \n Couleur",1,'C');
	$pdf->SetXY(20, 112);
	$pdf->MultiCell(35,10,"Données De Tristimulus",1,'C');
	$pdf->SetXY(55, 112);
	$pdf->MultiCell(15,5,"Nombre \n\n Principal",1,'C');
	$pdf->SetXY(70, 112);
	$pdf->MultiCell(20,5,"Date \n\n Principale",1,'C');
	$pdf->SetXY(90, 112);
	$pdf->MultiCell(25,15,"Type Matériel",1,'C');
	$pdf->SetXY(115, 112);
	$pdf->MultiCell(30,15,"Source Matérielle",1,'C');
	$pdf->SetXY(145, 112);
	$pdf->MultiCell(35,10,"Tonalité",1,'C');
	$pdf->SetXY(180, 112);
	$pdf->MultiCell(20,10,"Valeur",1,'C');
	$pdf->SetXY(200, 112);
	$pdf->MultiCell(20,10,"Chroma",1,'C');
	$pdf->SetXY(220, 112);
	$pdf->MultiCell(20,10,"Lustre",1,'C');
	$pdf->SetXY(240, 112);
	$pdf->MultiCell(20,5,"Brilhance \n Métallique",1,'C');
	$pdf->SetXY(260, 112);
	$pdf->MultiCell(15,5,"Suffixe \n de la couleur",1,'C');
	$pdf->SetXY(275, 112);
	$pdf->MultiCell(15,5,"Dispos. \n De Partie",1,'C');
	//linha 2
	$pdf->SetXY(20, 122);
	$pdf->SetFont('Arial','',7);
	$pdf->MultiCell(6,5,"DL",1,'C');
	$pdf->SetXY(26, 122);
	$pdf->MultiCell(6,5,"Da",1,'C');
	$pdf->SetXY(32, 122);
	$pdf->MultiCell(7,5,"Db",1,'C');
	$pdf->SetXY(39, 122);
	$pdf->MultiCell(7,5,"De",1,'C');
	$pdf->SetXY(46, 122);
	$pdf->MultiCell(9,5,"CMC",1,'C');
	$pdf->SetXY(145, 122);
	$pdf->MultiCell(10,5,"Roug",1,'C');
	$pdf->SetXY(155, 122);
	$pdf->MultiCell(8,5,"Jau",1,'C');
	$pdf->SetXY(163, 122);
	$pdf->MultiCell(8,5,"Ver",1,'C');
	$pdf->SetXY(171, 122);
	$pdf->MultiCell(9,5,"Bleu",1,'C');
	$pdf->SetXY(180, 122);
	$pdf->MultiCell(10,5,"Lumiè",1,'C');
	$pdf->SetXY(190, 122);
	$pdf->MultiCell(10,5,"Foncé",1,'C');
	$pdf->SetXY(200, 122);
	$pdf->MultiCell(10,5,"Gris",1,'C');
	$pdf->SetXY(210, 122);
	$pdf->MultiCell(10,5,"_impc",1,'C');
	$pdf->SetXY(220, 122);
	$pdf->MultiCell(10,5,"Haut",1,'C');
	$pdf->SetXY(230, 122);
	$pdf->MultiCell(10,5,"Bas",1,'C');
	$pdf->SetXY(240, 122);
	$pdf->MultiCell(10,5,"Haut",1,'C');
	$pdf->SetXY(250, 122);
	$pdf->MultiCell(10,5,"Bas",1,'C');

//linha 7
$sql=mysql_query("SELECT apqp_aprol.* FROM apqp_aprol,apqp_apro WHERE apqp_apro.peca='$pc' AND apqp_aprol.apro=apqp_apro.id");
if(mysql_num_rows($sql)){
	$y=127;
	$p=1;
	while($res=mysql_fetch_array($sql)){
		if($y>=185){
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(250,182.5);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$y=75;
			$p++;
			$pg++;
			$pdf->AddPage('L');
			$pdf->Image('imagens/logo_ford.jpg',5,1,25);
			$pdf->Image('imagens/logo_gm.jpg',45,1,10);
			$pdf->SetXY(5, 1);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(70);
			$pdf->Cell(0, 18, 'RAPPORT D´HOMOLOGATION D´ASPECT');
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(260, 5);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
			$pdf->SetFont('Arial','',8);
			//linha 5 
				$pdf->SetXY(5, 18);
				$pdf->SetFont('Arial','B',8);
				$pdf->MultiCell(285,5,"EVALUATION D´ASPECT",1,'C');
				$pdf->SetXY(5, 23);
				$pdf->SetFont('Arial','',8);
				$pdf->MultiCell(185,5,"SOURCE FOURNISSEUR ET INFORMATION SURLA STRUCTURE GRANULAIRE",1,'C');
				$pdf->SetXY(5, 28);
				$pdf->MultiCell(185,30,"",1);
				$pdf->SetXY(5, 28);
				$pdf->MultiCell(185,5,"$resp[aval]",0);
				//tabela direta
				$pdf->SetXY(190, 23);
				$pdf->MultiCell(40,10,"Evaluation Pré-Structure",1,'C');
				$pdf->SetXY(230, 23);
				$pdf->MultiCell(60,5,"Representant du Client \n Signature et Date ",1,'C');
				$pdf->SetXY(190, 33);
				$pdf->MultiCell(40,10,"Corriger Et Continuer",1,'C');
				$pdf->SetXY(230, 33);
				$pdf->MultiCell(60,10," ",1,'C');
				$pdf->SetXY(190, 43);
				$pdf->MultiCell(40,10,"Corrigez et Resoumettez",1,'C');
				$pdf->SetXY(230, 43);
				$pdf->MultiCell(60,10,"",1,'C');
				$pdf->SetXY(190, 53);
				$pdf->MultiCell(40,5,"Homologuer Structure",1,'C');
				$pdf->SetXY(230, 53);
				$pdf->MultiCell(60,5,"",1,'C');
			//linha 6
				//linha 1
				$pdf->SetXY(5, 60);
				$pdf->SetFont('Arial','B',8);
				$pdf->MultiCell(15,5,"Suffixe de \n Couleur",1,'C');
				$pdf->SetXY(20, 60);
				$pdf->MultiCell(35,10,"Données De Tristimulus",1,'C');
				$pdf->SetXY(55, 60);
				$pdf->MultiCell(15,5,"Nombre \n\n Principal",1,'C');
				$pdf->SetXY(70, 60);
				$pdf->MultiCell(20,5,"Date \n\n Principale",1,'C');
				$pdf->SetXY(90, 60);
				$pdf->MultiCell(25,15,"Type Matériel",1,'C');
				$pdf->SetXY(115, 60);
				$pdf->MultiCell(30,15,"Source Matérielle",1,'C');
				$pdf->SetXY(145, 60);
				$pdf->MultiCell(35,10,"Tonalité",1,'C');
				$pdf->SetXY(180, 60);
				$pdf->MultiCell(20,10,"Valeur",1,'C');
				$pdf->SetXY(200, 60);
				$pdf->MultiCell(20,10,"Chroma",1,'C');
				$pdf->SetXY(220, 60);
				$pdf->MultiCell(20,10,"Lustre",1,'C');
				$pdf->SetXY(240, 60);
				$pdf->MultiCell(20,5,"Brilhance \n Métallique",1,'C');
				$pdf->SetXY(260, 60);
				$pdf->MultiCell(15,5,"Suffixe \n de la couleur",1,'C');
				$pdf->SetXY(275, 60);
				$pdf->MultiCell(15,5,"Dispos. \n De Partie",1,'C');
				//linha 2
				$pdf->SetXY(20, 70);
				$pdf->SetFont('Arial','',7);
				$pdf->MultiCell(6,5,"DL",1,'C');
				$pdf->SetXY(26, 70);
				$pdf->MultiCell(6,5,"Da",1,'C');
				$pdf->SetXY(32, 70);
				$pdf->MultiCell(7,5,"Db",1,'C');
				$pdf->SetXY(39, 70);
				$pdf->MultiCell(7,5,"De",1,'C');
				$pdf->SetXY(46, 70);
				$pdf->MultiCell(9,5,"CMC",1,'C');
				$pdf->SetXY(145, 70);
				$pdf->MultiCell(10,5,"Roug",1,'C');
				$pdf->SetXY(155, 70);
				$pdf->MultiCell(8,5,"Jau",1,'C');
				$pdf->SetXY(163, 70);
				$pdf->MultiCell(8,5,"Ver",1,'C');
				$pdf->SetXY(171, 70);
				$pdf->MultiCell(9,5,"Bleu",1,'C');
				$pdf->SetXY(180, 70);
				$pdf->MultiCell(10,5,"Lumiè",1,'C');
				$pdf->SetXY(190, 70);
				$pdf->MultiCell(10,5,"Foncé",1,'C');
				$pdf->SetXY(200, 70);
				$pdf->MultiCell(10,5,"Gris",1,'C');
				$pdf->SetXY(210, 70);
				$pdf->MultiCell(10,5,"_impc",1,'C');
				$pdf->SetXY(220, 70);
				$pdf->MultiCell(10,5,"Haut",1,'C');
				$pdf->SetXY(230, 70);
				$pdf->MultiCell(10,5,"Bas",1,'C');
				$pdf->SetXY(240, 70);
				$pdf->MultiCell(10,5,"Haut",1,'C');
				$pdf->SetXY(250, 70);
				$pdf->MultiCell(10,5,"Bas",1,'C');
		}
		$tam[0]=flinha($res["suf"],10);
		if($tam[0]==0){$tam[0]=1;}
		$tam[1]=flinha($res["dl"],2);
		if($tam[1]==0){$tam[1]=1;}
		$tam[2]=flinha($res["da"],2);
		if($tam[2]==0){$tam[2]=1;}
		$tam[3]=flinha($res["db"],2);
		if($tam[3]==0){$tam[3]=1;}
		$tam[4]=flinha($res["de"],2);
		if($tam[4]==0){$tam[4]=1;}
		$tam[5]=flinha($res["cmc"],3);
		if($tam[5]==0){$tam[5]=1;}
		$tam[6]=flinha($res["num"],8);
		if($tam[6]==0){$tam[6]=1;}
		$tam[7]=flinha($res["det"],1);
		if($tam[7]==0){$tam[7]=1;}
		$tam[8]=flinha($res["data"],10);
		if($tam[8]==0){$tam[8]=1;}
		$tam[9]=flinha($res["tipo"],16);
		if($tam[9]==0){$tam[9]=1;}
		$tam[10]=flinha($res["fonte"],20);
		if($tam[10]==0){$tam[10]=1;}
		$tam[11]=flinha($res["ent"],8);
		if($tam[11]==0){$tam[11]=1;}
		$max=max($tam);
		for($i=0;$i<=17;$i++){
			$ql[$i]=$max - $tam[$i];
		}
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(15,5,"$res[suf]",0);
		$pdf->SetXY(20, $y);
		$pdf->MultiCell(6,5,"$res[dl]",0);
		$pdf->SetXY(26, $y);
		$pdf->MultiCell(6,5,"$res[da]",0);
		$pdf->SetXY(32, $y);
		$pdf->MultiCell(7,5,"$res[db]",0);
		$pdf->SetXY(39, $y);
		$pdf->MultiCell(7,5,"$res[de]",0);
		$pdf->SetXY(46, $y);
		$pdf->MultiCell(9,5,"$res[cmc]",0);
		$pdf->SetXY(55, $y);
		$pdf->MultiCell(15,5,"$res[num]",0,'C');
		$pdf->SetXY(70, $y);
		$pdf->MultiCell(20,5,"$res[data]",0,'C');
		$pdf->SetXY(90, $y);
		$pdf->MultiCell(25,5,"$res[tipo]",0,'C');
		$pdf->SetXY(115, $y);
		$pdf->MultiCell(30,5,"$res[fonte]",0,'C');
		$pdf->SetXY(145, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(155, $y);
		$pdf->MultiCell(8,5,"",0,'C');
		$pdf->SetXY(163, $y);
		$pdf->MultiCell(8,5,"",0,'C');
		$pdf->SetXY(171, $y);
		$pdf->MultiCell(9,5,"",0,'C');
		$pdf->SetXY(180, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(190, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(200, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(210, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(220, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(230, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(240, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(250, $y);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(260, $y);
		$pdf->MultiCell(15,5,"$res[ent]",0,'C');
		$pdf->SetXY(275, $y);
		$pdf->MultiCell(15,5,"",0,'C');
		$yi=$y;
		$y=($max*5)+$y;
		$yf=$y;

		if($p==1){
			$pdf->Line(5,127,5,185);
			$pdf->Line(20,127,20,185);
			$pdf->Line(26,127,26,185);
			$pdf->Line(32,127,32,185);
			$pdf->Line(39,127,39,185);
			$pdf->Line(46,127,46,185);
			$pdf->Line(55,127,55,185);
			$pdf->Line(70,127,70,185);
			$pdf->Line(90,127,90,185);
			$pdf->Line(115,127,115,185);
			$pdf->Line(145,127,145,185);
			$pdf->Line(155,127,155,185);
			$pdf->Line(163,127,163,185);
			$pdf->Line(171,127,171,185);
			$pdf->Line(180,127,180,185);
			$pdf->Line(190,127,190,185);
			$pdf->Line(200,127,200,185);
			$pdf->Line(210,127,210,185);
			$pdf->Line(220,127,220,185);
			$pdf->Line(230,127,230,185);
			$pdf->Line(240,127,240,185);
			$pdf->Line(250,127,250,185);
			$pdf->Line(260,127,260,185);
			$pdf->Line(275,127,275,185);
			$pdf->Line(290,127,290,185);
			$pdf->Line(5,185,290,185);
		}else{
			$pdf->Line(5,75,5,185);
			$pdf->Line(20,75,20,185);
			$pdf->Line(26,75,26,185);
			$pdf->Line(32,75,32,185);
			$pdf->Line(39,75,39,185);
			$pdf->Line(46,75,46,185);
			$pdf->Line(55,75,55,185);
			$pdf->Line(70,75,70,185);
			$pdf->Line(90,75,90,185);
			$pdf->Line(115,75,115,185);
			$pdf->Line(145,75,145,185);
			$pdf->Line(155,75,155,185);
			$pdf->Line(163,75,163,185);
			$pdf->Line(171,75,171,185);
			$pdf->Line(180,75,180,185);
			$pdf->Line(190,75,190,185);
			$pdf->Line(200,75,200,185);
			$pdf->Line(210,75,210,185);
			$pdf->Line(220,75,220,185);
			$pdf->Line(230,75,230,185);
			$pdf->Line(240,75,240,185);
			$pdf->Line(250,75,250,185);
			$pdf->Line(260,75,260,185);
			$pdf->Line(275,75,275,185);
			$pdf->Line(290,75,290,185);
			$pdf->Line(5,185,290,185);
		}
	}
}
if($p==1){
	$pdf->Line(5,127,5,185);
	$pdf->Line(20,127,20,185);
	$pdf->Line(26,127,26,185);
	$pdf->Line(32,127,32,185);
	$pdf->Line(39,127,39,185);
	$pdf->Line(46,127,46,185);
	$pdf->Line(55,127,55,185);
	$pdf->Line(70,127,70,185);
	$pdf->Line(90,127,90,185);
	$pdf->Line(115,127,115,185);
	$pdf->Line(145,127,145,185);
	$pdf->Line(155,127,155,185);
	$pdf->Line(163,127,163,185);
	$pdf->Line(171,127,171,185);
	$pdf->Line(180,127,180,185);
	$pdf->Line(190,127,190,185);
	$pdf->Line(200,127,200,185);
	$pdf->Line(210,127,210,185);
	$pdf->Line(220,127,220,185);
	$pdf->Line(230,127,230,185);
	$pdf->Line(240,127,240,185);
	$pdf->Line(250,127,250,185);
	$pdf->Line(260,127,260,185);
	$pdf->Line(275,127,275,185);
	$pdf->Line(290,127,290,185);
	$pdf->Line(5,185,290,185);
}else{
	$pdf->Line(5,75,5,185);
	$pdf->Line(20,75,20,185);
	$pdf->Line(26,75,26,185);
	$pdf->Line(32,75,32,185);
	$pdf->Line(39,75,39,185);
	$pdf->Line(46,75,46,185);
	$pdf->Line(55,75,55,185);
	$pdf->Line(70,75,70,185);
	$pdf->Line(90,75,90,185);
	$pdf->Line(115,75,115,185);
 	$pdf->Line(145,75,145,185);
	$pdf->Line(155,75,155,185);
	$pdf->Line(163,75,163,185);
	$pdf->Line(171,75,171,185);
	$pdf->Line(180,75,180,185);
	$pdf->Line(190,75,190,185);
	$pdf->Line(200,75,200,185);
	$pdf->Line(210,75,210,185);
	$pdf->Line(220,75,220,185);
	$pdf->Line(230,75,230,185);
	$pdf->Line(240,75,240,185);
	$pdf->Line(250,75,250,185);
	$pdf->Line(260,75,260,185);
	$pdf->Line(275,75,275,185);
	$pdf->Line(290,75,290,185);
	$pdf->Line(5,185,290,185);
// desenvolvedor
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(250,182.5);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
}

//fim
?>
