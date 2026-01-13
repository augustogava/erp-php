<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_viabilidade WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage();
$numero=$res["numero"];
$pg=1;
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'ENGAGEMENT COLLETIF DE FAISABILITÉ');
$pdf->SetXY(100, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(15,5,"Date:");
$pdf->SetXY(115, 18);
$pdf->MultiCell(30,5,banco2data($resp["data"]),0);
$pdf->Line(115,23,145,23);
$pdf->SetXY(180, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
$pdf->SetFont('Arial','',8);
//linha 2
$pdf->SetXY(5, 30);
$pdf->MultiCell(25,10,"Client: ");
$pdf->SetXY(30, 30);
$pdf->MultiCell(70,10,$res["pecacli"],0);
$pdf->Line(30,38,100,38);
$pdf->SetXY(100, 30);
$pdf->MultiCell(25,10,"Nom de Piéce: ");
$pdf->SetXY(125, 30);
$pdf->MultiCell(70,10,$res["nome"],0);
$pdf->Line(125,38,195,38);
//linha 3
$pdf->SetXY(5, 42);
$pdf->MultiCell(25,10,"Numéro de Piéce: ");
$pdf->SetXY(30, 42);
$pdf->MultiCell(70,10,$res["numero"],0);
$pdf->Line(30,50,100,50);
$pdf->SetXY(100, 42);
$pdf->MultiCell(25,10,"Révision Piéce: ");
$pdf->SetXY(125, 42);
$pdf->MultiCell(70,10,$res["rev"],0);
$pdf->Line(125,50,195,50);
//linha 4
$pdf->SetXY(5, 54);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(100,10,"Considérations de la faisabilité");
//linha 5
$pdf->SetXY(5, 64);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(200,5,"Notre qualité du produit qui organise I´équipe a considéré les questions suivantes, ne projetées pas d´être tout compris dans exécuter une évaluation de la faisabilité. Les dessins et/ou les spécifications fournies ont été utilisées comme une base pour analyser la capacité de rencontrer tout spécifié des exigences. Tout \"aucunes\" réponses ne sont supportées avec commentaires attachés qui identifient nos inquiétudes et/ou a proposé aux changement de nois permettre de satisfaire aux exigences spécifées. ");
//linha 6
	//inicio da tabela
	$pdf->SetXY(5, 90);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(10,5,"Qui",1);
	$pdf->SetXY(15, 90);
	$pdf->MultiCell(10,5,"Non",1);
	$pdf->SetXY(25, 90);
	$pdf->MultiCell(180,5,"Considération",1,'C');
	//linha 1 da tabela
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 95);
	if($resp["sn1"]=="S"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 95);
	if($resp["sn1"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 95);
	$pdf->MultiCell(180,5,"Iest-ce que le produit est défini suffisamment (exigences de I´application, etc.) permettre evaluation de la faisabilité?) ",1);
	//linha 2 da tabela
	$pdf->SetXY(5, 100);
	if($resp["sn2"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn2"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 100);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 100);
	$pdf->MultiCell(180,5,"Boîte les Spécifications de la Performance De I´l ingénieur soint rencontrées comme écrit? ",1);
	//linha 3 da tabela
	$pdf->SetXY(5, 105);
	if($resp["sn3"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn3"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 105);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 105);
	$pdf->MultiCell(180,5,"Est-ce que le produit peut être fabriqué a tolérances spécifiées sur les dessins? ",1);
	//linha 4 da tabela
	$pdf->SetXY(5, 110);
	if($resp["sn4"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn4"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 110);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 110);
	$pdf->MultiCell(180,5,"Est-ce que le produit peut être fabriqué avec Cpk qui rencontre des exigences? ",1);
	//linha 5 da tabela
	$pdf->SetXY(5, 115);
	if($resp["sn5"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn5"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 115);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 115);
	$pdf->MultiCell(180,5,"Is there adequate capacitu to produce product?",1);
	//linha 6 da tabela
	$pdf->SetXY(5, 120);
	if($resp["sn6"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn6"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 120);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 120);
	$pdf->MultiCell(180,5,"Does design allow the use of efficient material handling techniques? ",1);
	//linha 7 da tabela - titulo
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(5, 125);
	$pdf->MultiCell(200,5,"Conservez le produit soit fabriqué sans encourir tout exceptionnel: ",1,'C');
	//linha 8 da tabela
	if($resp["sn7"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn7"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 130);
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 130);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 130);
	$pdf->MultiCell(180,5,"- Coûts pour matérial capital? ",1);
	//linha 9 da tabela
	$pdf->SetXY(5, 135);
	if($resp["sn8"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn8"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 135);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 135);
	$pdf->MultiCell(180,5,"- Costs pour Outiller?",1);
	//linha 10 da tabela
	$pdf->SetXY(5, 140);
	if($resp["sn9"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn9"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 140);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 140);
	$pdf->MultiCell(180,5,"- Méthodes industrielles alternatives? ",1);
	//linha 11 da tabela
	$pdf->SetXY(5, 145);
	if($resp["sn10"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn10"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 145);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 145);
	$pdf->MultiCell(180,5,"Iest-ce que le contrôle du processus statistique est exigé sur produit? ",1);
	//linha 12 da tabela
	$pdf->SetXY(5, 150);
	if($resp["sn11"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn11"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 150);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 150);
	$pdf->MultiCell(180,5,"Est-ce que le contrôle du processus statistique est utilisé pour I´instant sur les produits semblables? ",1);
	//linha 13 da tabela - titulo
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(5, 155);
	$pdf->MultiCell(200,5,"Oú le contrôle du processus statistique est utilisé sur les produits semblables:  ",1,'C');
	//linha 14 da tabela
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(5, 160);
	if($resp["sn12"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn12"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 160);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 160);
	$pdf->MultiCell(180,5,"- est-ce que les processus Sont dans contrôle statistique et stable? ",1);
	//linha 15 da tabela
	$pdf->SetXY(5, 165);
	if($resp["sn13"]=="S"){ $msg="X"; }else{ $msg=" "; }
	if($resp["sn13"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
	$pdf->MultiCell(10,5,$msg,1,'C');
	$pdf->SetXY(15, 165);
	$pdf->MultiCell(10,5,$msg1,1,'C');
	$pdf->SetXY(25, 165);
	$pdf->MultiCell(180,5,"- Est-ce que sont Cpk est plus grand que 1.33? ",1);
	//fim da tabela
//linha 7
$pdf->SetXY(5, 172);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(100,5,"Conclusion");
//linha 8
$pdf->SetXY(5, 177);
if($resp["conclusao"]=="v1"){ $msg="X"; }else{ $msg=" "; }
$pdf->MultiCell(5,5,$msg,1,'C');
$pdf->SetXY(11, 177);
$pdf->MultiCell(15,5,"Faisable");
$pdf->SetXY(27, 177);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,5,"Le produit peut être produit comme spécifié sans révision. ");
//linha 9
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 182);
if($resp["conclusao"]=="v2"){ $msg="X"; }else{ $msg=" "; }
$pdf->MultiCell(5,5,$msg,1,'C');
$pdf->SetXY(11, 182);
$pdf->MultiCell(15,5,"Faisable");
$pdf->SetXY(27, 182);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,5,"Les changements ont recommandé (voyez attaché)");
//linha 10
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 187);
if($resp["conclusao"]=="v3"){ $msg="X"; }else{ $msg=" "; }
$pdf->MultiCell(5,5,$msg,1,'C');
$pdf->SetXY(11, 187);
$pdf->MultiCell(15,5,"Pas Faisable");
$pdf->SetXY(27, 187);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,5,"La révision du dessin a exigé pour produire le produit dans les exigences spécifiées ");
//linha 11
	//coluna 1
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(5, 195);
	$pdf->MultiCell(30,5,"Signature");
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(6, 200);
	
	$pdf->MultiCell(94,5,$resp["ap1"]." / ".banco2data($resp["dt1"]));
	$pdf->Line(6,205,96,205);
	$pdf->SetXY(5, 206);
	$pdf->MultiCell(100,5,"Équipier / Titre / Date ");
	$pdf->SetXY(6, 212);
	$pdf->MultiCell(94,5,$resp["ap2"]." / ".banco2data($resp["dt2"]));
	$pdf->Line(6,217,96,217);
	$pdf->SetXY(5, 218);
	$pdf->MultiCell(100,5,"Équipier / Titre / Date ");
	$pdf->SetXY(6, 224);
	$pdf->MultiCell(94,5,$resp["ap3"]." / ".banco2data($resp["dt3"]));
	$pdf->Line(6,229,96,229);
	$pdf->SetXY(5, 230);
	$pdf->MultiCell(100,5,"Équipier / Titre / Date ");
	//coluna 2
	$pdf->SetXY(106, 200);
	$pdf->MultiCell(94,5,$resp["ap4"]." / ".banco2data($resp["dt4"]));
	$pdf->Line(106,205,201,205);
	$pdf->SetXY(105, 206);
	$pdf->MultiCell(100,5,"Équipier / Titre / Date ");
	$pdf->SetXY(106, 212);
	$pdf->MultiCell(94,5,$resp["ap5"]." / ".banco2data($resp["dt5"]));
	$pdf->Line(106,217,201,217);
	$pdf->SetXY(105, 218);
	$pdf->MultiCell(100,5,"Équipier / Titre / Date ");
	$pdf->SetXY(106, 224);
	$pdf->MultiCell(94,5,$resp["ap6"]." / ".banco2data($resp["dt6"]));
	$pdf->Line(106,229,201,229);
	$pdf->SetXY(105, 230);
	$pdf->MultiCell(100,5,"Équipier / Titre / Date ");
//linha 12
include('pdf/frances/apqp_viabilidade_imp2.php');
?>
