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
$pdf->Cell(40);
$pdf->Cell(0, 18, 'Untersuchungen Zur Kurzzeitfahigkeit des Prozesses');
$pdf->SetFont('Arial','',8);
$pg=1;
$pdf->SetXY(180, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP Nr. $numero \n Blatt: $pg");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 18);
$pdf->MultiCell(100,4,"Kundennamme \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 22);
$pdf->MultiCell(100,4,$cliente,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,4,"Kundenteilenummer \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105, 22);
$pdf->MultiCell(100,4,$peca,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,4,"Technisher Anderungsstand/Datum \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 22);
$pdf->MultiCell(100,4,$rev,0);
//linha 2
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 26);
$pdf->MultiCell(100,4,"Names des Lieferanten \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 30);
$pdf->MultiCell(100,4,$razao,0);
$pdf->SetXY(105, 26);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(50,4,"Lieferantenteilenummer \n ",1);
$pdf->SetXY(105, 30);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,4,$numero,0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 26);
$pdf->MultiCell(50,4,"Teile E/A Stand (Lieferanten) \n ",1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155, 30);
$pdf->MultiCell(100,4,$rev1,0);
//linha 3
$pdf->SetXY(5, 34);
$pdf->MultiCell(100,4,"Teilename \n ",1);
$pdf->SetXY(5, 38);
$pdf->MultiCell(100,4,$nome,0);
$pdf->SetXY(105, 34);
$pdf->MultiCell(100,4,"Betrieb Nr. / Beschreibung / Arbeitsgangs \n ",1);
$pdf->SetXY(105, 38);
$pdf->MultiCell(100,4,$ope,0);
//linha 4
$pdf->SetXY(5, 42);
$pdf->MultiCell(20,4,"Merkmals Nr.\n ",1);
$pdf->SetXY(5, 46);
$pdf->MultiCell(20,4,$num,0);
$pdf->SetXY(25, 42);
$pdf->MultiCell(40,4,"Merkmals Beschreibung\n ",1);
$pdf->SetXY(25, 46);
$pdf->MultiCell(40,4,$desc,0);
$pdf->SetXY(65, 42);
$pdf->MultiCell(90,4,"Form,Nest,Produktionsprozess \n ",1);
$pdf->SetXY(65, 46);
$pdf->MultiCell(90,4,$espec,0);
$pdf->SetXY(155, 42);
$pdf->MultiCell(25.3,4,"Unterer Grenzwert\n ",1);
$pdf->SetXY(155, 46);
$pdf->MultiCell(25.3,4,$lie,0);
$pdf->SetXY(180.3, 42);
$pdf->MultiCell(24.7,4,"Oberer Grenzwert\n ",1);
$pdf->SetXY(180.3, 46);
$pdf->MultiCell(24.7,4,$lse,0);
//linha 5
$pdf->SetXY(5, 50);
$pdf->MultiCell(100,4,"Vorbereitet Von \n ",1);
$pdf->SetXY(5, 54);
$pdf->MultiCell(100,4,$por,0);
$pdf->SetXY(105, 50);
$pdf->MultiCell(30,4,"Datum \n ",1);
$pdf->SetXY(105, 54);
$pdf->MultiCell(100,4,$dtpor,0);
$pdf->SetXY(135, 50);
$pdf->MultiCell(40,4,"Untergruppe Grobe \n ",1);
$pdf->SetXY(135, 54);
$pdf->MultiCell(100,4,$tam,0);
$pdf->SetXY(175, 50);
$pdf->MultiCell(30,4,"Untergruppe Quantitat\n ",1);
$pdf->SetXY(175, 54);
$pdf->MultiCell(100,4,$qtd,0);
//linha 6
$pdf->SetXY(5, 58);
$pdf->MultiCell(200,4,"Bemerkungen \n ",1);
$pdf->SetXY(5, 62);
$pdf->MultiCell(100,4,$obs,0);
//linha 6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 68);
$pdf->MultiCell(10,4,"",1,'C');
$pdf->SetXY(15, 68);
$pdf->MultiCell(20,4,"Muester 1",1,'C');
$pdf->SetXY(35, 68);
$pdf->MultiCell(25,4,"Muester 2",1,'C');
$pdf->SetXY(60, 68);
$pdf->MultiCell(25,4,"Muester 3",1,'C');
$pdf->SetXY(85, 68);
$pdf->MultiCell(25,4,"Muester 4",1,'C');
$pdf->SetXY(110, 68);
$pdf->MultiCell(25,4,"Muester 5",1,'C');
$pdf->SetXY(135, 68);
$pdf->MultiCell(30,4,"Mittelwert",1,'C');
$pdf->SetXY(165, 68);
$pdf->MultiCell(40,4,"Spannweite",1,'C');
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
		$pdf->MultiCell(40,5,"PPAP Nr. $numero \n Blatt: $pg");
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 1);
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(40);
		$pdf->Cell(0, 18, 'Untersuchungen Zur Kurzzeitfahigkeit des Prozesses');
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 18);
		$pdf->MultiCell(100,4,"Kundennamme \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 22);
		$pdf->MultiCell(100,4,$cliente,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(105, 18);
		$pdf->MultiCell(50,4,"Kundenteilenummer \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(105, 22);
		$pdf->MultiCell(100,4,$peca,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 18);
		$pdf->MultiCell(50,4,"Technisher Anderungsstand/Datum \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 22);
		$pdf->MultiCell(100,4,$rev,0);
		//linha 2
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 26);
		$pdf->MultiCell(100,4,"Names des Lieferanten \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, 30);
		$pdf->MultiCell(100,4,$razao,0);
		$pdf->SetXY(105, 26);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(50,4,"Lieferantenteilenummer \n ",1);
		$pdf->SetXY(105, 30);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(100,4,$numero,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 26);
		$pdf->MultiCell(50,4,"Teile E/A Stand (Lieferanten) \n ",1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(155, 30);
		$pdf->MultiCell(100,4,$rev1,0);
		//linha 3
		$pdf->SetXY(5, 34);
		$pdf->MultiCell(100,4,"Teilename \n ",1);
		$pdf->SetXY(5, 38);
		$pdf->MultiCell(100,4,$nome,0);
		$pdf->SetXY(105, 34);
		$pdf->MultiCell(100,4,"Betrieb Nr. / Beschreibung / Arbeitsgangs \n ",1);
		$pdf->SetXY(105, 38);
		$pdf->MultiCell(100,4,$ope,0);
		//linha 4
		$pdf->SetXY(5, 42);
		$pdf->MultiCell(20,4,"Merkmals Nr.\n ",1);
		$pdf->SetXY(5, 46);
		$pdf->MultiCell(20,4,$num,0);
		$pdf->SetXY(25, 42);
		$pdf->MultiCell(40,4,"Merkmals Beschreibung\n ",1);
		$pdf->SetXY(25, 46);
		$pdf->MultiCell(40,4,$desc,0);
		$pdf->SetXY(65, 42);
		$pdf->MultiCell(90,4,"Form,Nest,Produktionsprozess \n ",1);
		$pdf->SetXY(65, 46);
		$pdf->MultiCell(90,4,$espec,0);
		$pdf->SetXY(155, 42);
		$pdf->MultiCell(25.3,4,"Unterer Grenzwert\n ",1);
		$pdf->SetXY(155, 46);
		$pdf->MultiCell(25.3,4,$lie,0);
		$pdf->SetXY(180.3, 42);
		$pdf->MultiCell(24.7,4,"Oberer Grenzwert\n ",1);
		$pdf->SetXY(180.3, 46);
		$pdf->MultiCell(24.7,4,$lse,0);
		//linha 5
		$pdf->SetXY(5, 50);
		$pdf->MultiCell(100,4,"Vorbereitet Von \n ",1);
		$pdf->SetXY(5, 54);
		$pdf->MultiCell(100,4,$por,0);
		$pdf->SetXY(105, 50);
		$pdf->MultiCell(30,4,"Datum \n ",1);
		$pdf->SetXY(105, 54);
		$pdf->MultiCell(100,4,$dtpor,0);
		$pdf->SetXY(135, 50);
		$pdf->MultiCell(40,4,"Untergruppe Grobe \n ",1);
		$pdf->SetXY(135, 54);
		$pdf->MultiCell(100,4,$tam,0);
		$pdf->SetXY(175, 50);
		$pdf->MultiCell(30,4,"Untergruppe Quantitat\n ",1);
		$pdf->SetXY(175, 54);
		$pdf->MultiCell(100,4,$qtd,0);
		//linha 6
		$pdf->SetXY(5, 58);
		$pdf->MultiCell(200,4,"Bemerkungen \n ",1);
		$pdf->SetXY(5, 62);
		$pdf->MultiCell(100,4,$obs,0);
	}
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, $x);
	$pdf->MultiCell(10,4,completa($i,2),1,'C');
	$pdf->SetXY(15, $x);
	$pdf->MultiCell(20,4,banco2valor3($resp["a".($i*5-4)]),1,'C');
	$pdf->SetXY(35, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5-3)]),1,'C');
	$pdf->SetXY(60, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5-2)]),1,'C');
	$pdf->SetXY(85, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5-1)]),1,'C');
	$pdf->SetXY(110, $x);
	$pdf->MultiCell(25,4,banco2valor3($resp["a".($i*5)]),1,'C');
	$pdf->SetXY(135, $x);
	$pdf->MultiCell(30,4,banco2valor3($resp["x".($i)]),1,'C');
	$pdf->SetXY(165, $x);
	$pdf->MultiCell(40,4,banco2valor3($resp["r".($i)]),1,'C');
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
	$pdf->Cell(40);
	$pdf->Cell(0, 18, 'Untersuchungen Zur Kurzzeitfahigkeit des Prozesses');
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(180, 8);
	$pg=$pdf->PageNo();
	$pdf->MultiCell(65,5,"Blatt: $pg");
	$pdf->SetXY(5, 18);
	$pdf->MultiCell(100,4,"Kundennamme \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 22);
	$pdf->MultiCell(100,4,$cliente,0);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(105, 18);
	$pdf->MultiCell(50,4,"Kundenteilenummer \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(105, 22);
	$pdf->MultiCell(100,4,$peca,0);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 18);
	$pdf->MultiCell(50,4,"Technisher Anderungsstand/Datum \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 22);
	$pdf->MultiCell(100,4,$rev,0);
	//linha 2
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 26);
	$pdf->MultiCell(100,4,"Names des Lieferanten \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 30);
	$pdf->MultiCell(100,4,$razao,0);
	$pdf->SetXY(105, 26);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(50,4,"Lieferantenteilenummer \n ",1);
	$pdf->SetXY(105, 30);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(100,4,$numero,0);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 26);
	$pdf->MultiCell(50,4,"Teile E/A Stand (Lieferanten) \n ",1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(155, 30);
	$pdf->MultiCell(100,4,$rev1,0);
	//linha 3
	$pdf->SetXY(5, 34);
	$pdf->MultiCell(100,4,"Teilename \n ",1);
	$pdf->SetXY(5, 38);
	$pdf->MultiCell(100,4,$nome,0);
	$pdf->SetXY(105, 34);
	$pdf->MultiCell(100,4,"Betrieb Nr. / Beschreibung / Arbeitsgangs \n ",1);
	$pdf->SetXY(105, 38);
	$pdf->MultiCell(100,4,$ope,0);
	//linha 4
	$pdf->SetXY(5, 42);
	$pdf->MultiCell(20,4,"Merkmals Nr.\n ",1);
	$pdf->SetXY(5, 46);
	$pdf->MultiCell(20,4,$num,0);
	$pdf->SetXY(25, 42);
	$pdf->MultiCell(40,4,"Merkmals Beschreibung\n ",1);
	$pdf->SetXY(25, 46);
	$pdf->MultiCell(40,4,$desc,0);
	$pdf->SetXY(65, 42);
	$pdf->MultiCell(90,4,"Form,Nest,Produktionsprozess \n ",1);
	$pdf->SetXY(65, 46);
	$pdf->MultiCell(90,4,$espec,0);
	$pdf->SetXY(155, 42);
	$pdf->MultiCell(25.3,4,"Unterer Grenzwert\n ",1);
	$pdf->SetXY(155, 46);
	$pdf->MultiCell(25.3,4,$lie,0);
	$pdf->SetXY(180.3, 42);
	$pdf->MultiCell(24.7,4,"Oberer Grenzwert\n ",1);
	$pdf->SetXY(180.3, 46);
	$pdf->MultiCell(24.7,4,$lse,0);
	//linha 5
	$pdf->SetXY(5, 50);
	$pdf->MultiCell(100,4,"Vorbereitet Von \n ",1);
	$pdf->SetXY(5, 54);
	$pdf->MultiCell(100,4,$por,0);
	$pdf->SetXY(105, 50);
	$pdf->MultiCell(30,4,"Datum \n ",1);
	$pdf->SetXY(105, 54);
	$pdf->MultiCell(100,4,$dtpor,0);
	$pdf->SetXY(135, 50);
	$pdf->MultiCell(40,4,"Untergruppe Grobe \n ",1);
	$pdf->SetXY(135, 54);
	$pdf->MultiCell(100,4,$tam,0);
	$pdf->SetXY(175, 50);
	$pdf->MultiCell(30,4,"Untergruppe Quantitat\n ",1);
	$pdf->SetXY(175, 54);
	$pdf->MultiCell(100,4,$qtd,0);
	//linha 6
	$pdf->SetXY(5, 58);
	$pdf->MultiCell(200,4,"Bemerkungen \n ",1);
	$pdf->SetXY(5, 62);
	$pdf->MultiCell(100,4,$obs,0);
}
$pdf->SetXY(5, $x);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(200,5,"Ergebnis des Prozeb-Kapazitat Studiun",0,'C');
$x=$x+10;
//linha 7
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Probe Daten",1,'C');
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"",1);
//linha 8
$pdf->SetXY(5, $x);
$pdf->MultiCell(40,5,"Unterer Grenzwert: ".banco2valor3($resc["lie"])."",0,'C');
$pdf->SetXY(50, $x);
$pdf->MultiCell(40,5,"Oberer Grenzwert:".banco2valor3($resc["lse"])."",0,'C');
$pdf->SetXY(83, $x);
$pdf->MultiCell(35,5,"X:".banco2valor3($resp["xbar"])."",0,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(30,5,"R:".banco2valor3($resp["rbar"])."",0,'C');
$pdf->SetXY(130, $x);
$pdf->MultiCell(35,5,"Mindestwert:".banco2valor3($resp["min"])."",0,'C');
$pdf->SetXY(165, $x);
$pdf->MultiCell(40,5,"Maximaler Wert:".banco2valor3($resp["max"])."",0,'C');
//linha nova
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Punkte Aus Die Grenze: ".$resp["pf"]."",1,'L');
$pdf->SetXY(131, $x);
$pdf->MultiCell(30,5,"Min Strecke:".banco2valor3($resp["rmin"])."",0,'C');
$pdf->SetXY(167, $x);
$pdf->MultiCell(30,5,"Max Strecke:".banco2valor3($resp["rmax"])."",0,'C');
//linha 9
$x=$x+10;
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Grenzwert Kurves",1,'C');
//linha 10
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"X Kurve",1,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"R Kurve",1,'C');
//linha 11
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Unterer Grenzwert: ".banco2valor3($resp["lcl"])."",1);
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Unterer Grenzwert: ".banco2valor3(0)."",1);
//linha 12
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Oberer Grenzwert: ".banco2valor3($resp["uclx"])."",1);
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Oberer Grenzwert: ".banco2valor3($resp["uclr"])."",1);
//linha nova P_F media e amp
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Punkte Aus Die Grenze: ".$resp["mpf"]."",1);
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Punkte Aus Die Grenze: ".$resp["apf"]."",1);
//linha 13
$x=$x+10;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,5,"Kapazitat des Prozeb",1,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,5,"Leistung des Prozeb",1,'C');
//linha 14
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(100,10,"",1,'C');
$pdf->SetXY(105, $x);
$pdf->MultiCell(100,10,"",1,'C');
$pdf->SetXY(7, $x);
$pdf->MultiCell(60,5,"Normale Abweichung: ".banco2valor3($resp["sigma"])."",0,'C');
$pdf->SetXY(107, $x);
$pdf->MultiCell(60,5,"Normale Abweichung: ".banco2valor3($resp["sigma"])."",0,'C');
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
$pdf->MultiCell(65,5,"CPK: ".banco2valor3($resp["cpk"])."",0,'C');
$pdf->SetXY(157, $x);
$pdf->MultiCell(65,5,"PPK: ".banco2valor3($resp["ppk"])."",0,'C');
//linha 15
//linha 16
//linha 17
$x=$x+10;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"Entscheidung",1,'C');
//linha 18
$x=$x+5;
$pdf->SetXY(5, $x);
$pdf->MultiCell(200,5,"",1,'C');
$pdf->SetXY(5, $x);
if($resp["sit"]==0){ $show="pendente"; }elseif($resp["sit"]==1){ $show="aprovado"; }else{ $show="reprovado"; }
$pdf->MultiCell(65,5,"Entscheidung: ".$show."",0,'C');
$pdf->SetXY(70, $x);
$pdf->MultiCell(65,5,"Veranwortilich: ".$resp["quem"]."",0,'C');
$pdf->SetXY(135,$x);
$pdf->MultiCell(65,5,"Datum: ".banco2data($resp["dtquem"])."",0,'C');
//em baixo rodape
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
//fim
//$pdf->Output('apqo_cap3.pdf','I');
?>
