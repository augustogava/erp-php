<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)){
	$rese=mysql_fetch_array($sql);
}
$numero=$res["numero"];
$pg=1;
$pdf->AddPage('L');
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 18, 'FORTGESTCHRITTENE QUALITÄTSPLANUNG');
$pdf->SetXY(260, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP Nr. $numero \n Blatt $pg");
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(50,5,"Teilenummer(Kunde)\n $res[pecacli]",1);
$pdf->SetXY(55, 18);
$pdf->MultiCell(50,5,"Zeichnungs-Nr\n $res[niveleng] - ".banco2data($res["dteng"])."",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(80,5,"Teilename \n $res[nome]",1);
$pdf->SetXY(185, 18);
$pdf->MultiCell(105,5,"Kundenname\n $res[nomecli]",1);
$pdf->SetXY(5, 28);
$pdf->MultiCell(100,5,"Lieferantenname\n $rese[razao]",1);
$pdf->SetXY(105, 28);
$pdf->MultiCell(80,5,"Teilenummer/Rev(Lieferant) \n $res[numero] - $res[rev]",1);
$pdf->SetXY(185, 28);
$pdf->MultiCell(75,5,"Freigabe von  \n $res[crono_quem]",1);
$pdf->SetXY(260, 28);
$pdf->MultiCell(30,5,"Datum \n ".banco2data($res["crono_dtquem"])."",1);
$pdf->SetXY(5, 45);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(90,5,"Ergriffene \n ",1,'C');
$pdf->SetXY(95, 45);
$pdf->MultiCell(45,5,"Verantwortung \n ",1,'C');
$pdf->SetXY(140, 45);
$pdf->MultiCell(20,5,"Anfang \n ",1,'C');
$pdf->SetXY(160, 45);
$pdf->MultiCell(20,5,"Angegebene\n Periode",1,'C');
$pdf->SetXY(180, 45);
$pdf->MultiCell(20,5,"Ende \n ",1,'C');
$pdf->SetXY(200, 45);
$pdf->MultiCell(25,5,"% Vollenden \n ",1,'C');
$pdf->SetXY(225, 45);
$pdf->MultiCell(65,5,"Bemerkungen \n ",1,'C');
$pdf->SetFont('Arial','',8);
$i=55;
$sql=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' ORDER BY pos ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($i>=180){
			$i=5;
			$pdf->AddPage('L');
		}
		$pdf->SetXY(5, $i);
		$pdf->Cell(90,15,$res["ativ"],1,1);
		$pdf->SetXY(95, $i);
		$pdf->Cell(45,15,$res["resp"],1,1);
		$pdf->SetXY(140, $i);
		$pdf->Cell(20,15,banco2data($res["ini"]),1,1,'C');
		$pdf->SetXY(160, $i);
		$pdf->Cell(20,15,banco2data($res["prazo"]),1,1,'C');
		$pdf->SetXY(180, $i);
		$pdf->Cell(20,15,banco2data($res["fim"]),1,1,'C');
		$pdf->SetXY(200, $i);
		$pdf->Cell(25,15,$res["perc"],1,1,'C');
		$pdf->SetXY(225, $i);
		$pdf->Cell(65,15,$res["obs"],1,1);
		$i=$i+5;
	}
}
$pdf->Line(5,185,290,185);
$pdf->Line(5,50,5,185);
$pdf->Line(95,50,95,185);
$pdf->Line(140,50,140,185);
$pdf->Line(160,50,160,185);
$pdf->Line(180,50,180,185);
$pdf->Line(200,50,200,185);
$pdf->Line(225,50,225,185);
$pdf->Line(290,50,290,185);

//em baixo rodape
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(252,182.90);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
?>
