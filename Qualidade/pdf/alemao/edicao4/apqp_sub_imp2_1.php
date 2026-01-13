<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
// funcionario
$sql=mysql_query("SELECT clientes.id,clientes.fone,clientes.fax FROM clientes,cliente_login,niveis WHERE clientes.nome='$resp[quem]' AND clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id AND niveis.tipo='F'");
//
// cargo
$sqlf=mysql_query("SELECT cargos.nome,cliente_login.assinatura FROM funcionarios,cargos,cliente_login  WHERE funcionarios.nome='$resp[quem]' and funcionarios.cargo=cargos.id and cliente_login.funcionario=funcionarios.id");
//
$resf=mysql_fetch_array($sqlf);

$sqlg=mysql_query("SELECT * FROM funcionarios WHERE nome='$resp[quem]'");
$resg=mysql_fetch_array($sqlg);

$numero=$res["numero"];
$pdf->AddPage();
$pg=1;
$pdf->SetXY(180, 1);
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(40,5,"PPAP Nr. $numero \n Blatt: $pg");
$pdf->SetFont('Arial','',8);
if($res["logo"]!="S"){
	$pdf->Image('imagens/logo_chrysler.jpg',5,5,25,5);
	$pdf->Image('imagens/logo_ford.jpg',40,2,20,5);
	$pdf->Image('imagens/logo_gm.jpg',75,1,7,7);
	$pdf->SetXY(5, 1);
	$pdf->Cell(80);
} else{
	$pdf->SetXY(5, 1);
	$pdf->Cell(65);
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 10, 'TeilcUnterordnungcErmächtigung ');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(20,5,"Names Teiles:");
$pdf->SetXY(26, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(26,16,104,16);
$pdf->SetXY(107, 11);
$pdf->MultiCell(25,5,"Teilenummer:");
$pdf->SetXY(127, 11);
$pdf->MultiCell(70,5,$res["pecacli"]);
$pdf->Line(127,16,200,16);
// linha 2
$pdf->SetXY(6, 16);
$pdf->MultiCell(40,5,"Zeichnungsnummer:");
$pdf->SetXY(32, 16);
$pdf->MultiCell(80,5,$res["desenhoc"]);
$pdf->Line(32,21,104,21);
$pdf->SetXY(107, 16);
$pdf->MultiCell(50,5,"OrganisationscTeilnummer:");
$pdf->SetXY(140, 16);
$pdf->MultiCell(70,5,"$numero"); // buscar do banco
$pdf->Line(140,21,200,21);
// linha 3
$pdf->SetXY(6, 21);
$pdf->MultiCell(50,5,"TechnikcÄnderungscNiveau:");
$pdf->SetXY(38, 21);
$pdf->MultiCell(25,5,$res["niveleng"]);
$pdf->Line(38,26,104,26);
$pdf->SetXY(120, 21);
$pdf->MultiCell(20,5,"Datiert:");
$pdf->SetXY(130, 21);
$pdf->MultiCell(30,5,banco2data($res["dteng"])); // buscar do banco
$pdf->Line(130,26,200,26);
//linha 4
$pdf->SetXY(6, 26);
$pdf->MultiCell(50,5,"Zusätzliche technische Änderungen:");
$pdf->SetXY(49, 26);
$pdf->MultiCell(90,5,$res["alteng"]);
$pdf->Line(49,31,104,31);
$pdf->SetXY(120, 26);
$pdf->MultiCell(10,5,"Datiert:");
$pdf->SetXY(130, 26);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(130,31,200,31);
//linha 5
$pdf->SetXY(6, 31);
$pdf->MultiCell(100,5,"Sicherheits- und / oder esetzl. Vorschrift:");

if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; }
$pdf->SetXY(67,32);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(67.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(72,31);
$pdf->MultiCell(10,5,"Ya");

if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(82,32);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(82.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(87,31);
$pdf->MultiCell(10,5,"Nein");

$pdf->SetXY(100, 31);
$pdf->MultiCell(30,5,"Bestellnummer:");
$pdf->SetXY(118, 31);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(118,36,153,36);
$pdf->SetXY(154, 31);
$pdf->MultiCell(20,5,"Gewicht Kg:");
$pdf->SetXY(170, 31);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(170,36,200,36); 
//linha 6
$pdf->SetXY(6, 36);
$pdf->MultiCell(50,5,"Nr. spezifisches Prüfmittel:");
$pdf->SetXY(36, 36);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(36,41,60,41);
$pdf->SetXY(60, 36);
$pdf->MultiCell(100,5,"Überprüfung Des ÄnderungscNiveaus HilfsmittelEnginnering:");
$pdf->SetXY(129, 36);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(129,41,153,41);
$pdf->SetXY(160, 36);
$pdf->MultiCell(10,5,"Datiert:");
$pdf->SetXY(170, 36);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,41,200,41);
//linha 7
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 45);
$pdf->MultiCell(94,5,"PRODUKTIONSAUSKUNFT DES LIEFERANTEN",0,'');
$pdf->SetXY(105, 45);
$pdf->MultiCell(94,5,"INFORMATIONEN DES KUNDEN SUBMITTAL",0,'');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 50);
	$pdf->MultiCell(94,5,"$rese[razao] \n LieferantencName & LieferantencCode",0);
	$pdf->Line(6,55,100,55);
	$pdf->SetXY(6, 60);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Street Adresse",0);
	$pdf->Line(6,65,100,65);
	$pdf->SetXY(6, 70);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep] / $rese[pais]\n Stadt   /   Region   /   PostcCode  /  Land",0);
	$pdf->Line(6,75,100,75);
	//coluna 2
	$pdf->Line(106,55,200,55);
	$pdf->SetXY(106, 50);
	$pdf->MultiCell(40,5,"$res[nomecli] \n KundencName/Abteilung:",0);
	$pdf->Line(106,65,200,65);	
	$pdf->SetXY(106, 60);
	$pdf->MultiCell(60,5,"$res[comprador] \n Kunde/KundencCode:",0);
	$pdf->Line(106,75,200,75);
	$pdf->SetXY(106, 70);
	$pdf->MultiCell(20,5,"$res[aplicacao] \n Anwendung:",0);

//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(94,5,"MATERIAL-BERICHT",0,'');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6, 85);
$pdf->MultiCell(100,5,"Ist Kunde-erforderliche Substanzen der Interesseninformationen berichtet worden?",0,'');
if($resp["rela1"]=="2"){ $msg="X"; }else{ $msg=" "; }
if($resp["rela1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["rela1"]=="0"){ $msg2="X"; }else{ $msg2=" "; }

$pdf->SetXY(109.3,85);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,84.5);
$pdf->MultiCell(10,5,"Ya");

$pdf->SetXY(124.3,85);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,84.5);
$pdf->MultiCell(10,5,"Nein");

$pdf->SetXY(145.3,85);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(145.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(149,84.5);
$pdf->MultiCell(10,5,"n/a");

$pdf->SetXY(40, 90);
$pdf->MultiCell(80,5,"Eingereicht durch IMDS oder anderes Kundenformat:",0,'');
$pdf->SetXY(106, 90);
$pdf->MultiCell(94,5,$resp["imds"],0,'');
$pdf->Line(106,95,200,95);
$pdf->Line(106,100,200,100);
$pdf->SetXY(6, 100);
$pdf->MultiCell(105,5,"Werden polymerische Teile mit passenden ISO-Markierungscodes gekennzeichnet?",0,'');

if($resp["rela2"]=="2"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(109.3,101);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,100.5);
$pdf->MultiCell(10,5,"Ya");

if($resp["rela2"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(124.3,101);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(129,101);
$pdf->MultiCell(10,5,"Nein");

if($resp["rela2"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(145.3,101);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(145.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(149,100.5);
$pdf->MultiCell(10,5,"n/a");

//linha 9
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 106);
$pdf->MultiCell(100,5,"GRUND FÜR UNTERORDNUNG",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,111);
	$pdf->MultiCell(3,3," ",1,'C');
	$pdf->SetXY(12,110);
	$pdf->MultiCell(116,5,"Erstmalige Vorlage");

	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->SetXY(6.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,114);
	$pdf->MultiCell(100,5,"Technische 6Anderung(en)");

	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,118);
	$pdf->MultiCell(100,5,"Werkzeg: Verlagerung, Ersatz, Überholung oder sonstiges");

	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,122);
	$pdf->MultiCell(100,5,"Korrektur eines Fehlers");

	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,126);
	$pdf->MultiCell(100,5,"Werkzeug für ehr als ein Jahr inaktiv");    
	
	//coluna 2
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,111);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,110);
	$pdf->MultiCell(100,5,"Änderung zur optionalen Kostruktion oder Werkstoff");

	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,114);
	$pdf->MultiCell(100,5,"Änderung von Unterlieferant oder Lieferquelle des Werkstoffes");

	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,118);
	$pdf->MultiCell(100,5,"Änderung Berbeitungsprozess");

	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,122);
	$pdf->MultiCell(100,5,"Teile werden an einem zweiten Srandort Hergestellt");

	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,126);
	$pdf->MultiCell(100,5,"Anderes - Bitte geben sie Einzelheiten an:");
	$pdf->SetXY(105,131);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
	$pdf->Line(107,135,162,135);

//linha 12 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,135);
$pdf->MultiCell(150,5,"ERBETENE UNTERORDNUNG NIVEAU");
$pdf->SetFont('Arial','',7);
if($resp["nivel"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nivel"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["nivel"]=="3"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["nivel"]=="4"){ $msg4="X"; }else{ $msg4=" "; }
if($resp["nivel"]=="5"){ $msg5="X"; }else{ $msg5=" "; }

$pdf->SetXY(6.8,140.3);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(7,140);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,139);
$pdf->MultiCell(200,5,"1. Stufe - Bestätigung (warrant) und fur ausgewiesene Aussehensteile Bericht zur Freigabe des Aussehens");

$pdf->SetXY(6.8,144.3);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(7,144);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,143);
$pdf->MultiCell(200,5,"2. Stufe - Bestätigung (warrant) mit Musterteilen und eingeschränkte untertützende Daten werden dem Kunden vorgelegt");

$pdf->SetXY(6.8,148.3);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(7,148);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,147);
$pdf->MultiCell(200,5,"3. Stufe - Bestätigung (warrant) mit Musterteilen und umfassende untertützende Daten werden dem Kunden vorgelegt");

$pdf->SetXY(6.8,152.3);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(7,152);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,151);
$pdf->MultiCell(200,5,"4. Stufe - Best. und andere Forderungen wie sie vom Kunden festgelegt wurden");

$pdf->SetFont('Arial','',7);
$pdf->SetXY(6.8,156.3);
$pdf->MultiCell(3,3,$msg5,'C');
$pdf->SetXY(7,156);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,155);
$pdf->MultiCell(200,5,"5. Stufe - Best6atigung (warrant) mit Musterteilen und vollständige unterstützende Daten, die am Produktionsstandort des Lieferanten bewertet werden");	
//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,161);
$pdf->MultiCell(50,5,"ERGEBNISSE DER VORLAGE");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(30,5,"Ergebnisse stammen:");
if($resp["res1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["res2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["res3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["res4"]=="1"){ $msg4="X"; }else{ $msg4=" "; }

$pdf->SetXY(33,167);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(33.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(38,167);
$pdf->MultiCell(50,5,"MaBprüfungen");

$pdf->SetXY(61,167);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(61.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(66,167);
$pdf->MultiCell(50,5,"Material- und Frunktionsprüfungen");

$pdf->SetXY(111,167);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(111.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(116,167);
$pdf->MultiCell(50,5,"Aussehens- beurteilungen");

$pdf->SetXY(150,167);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(150.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(155,167);
$pdf->MultiCell(50,5,"Statistischen Prozessdaten");
//linha 14
$pdf->SetXY(6,173);
$pdf->MultiCell(100,5,"Diese Ergebnisse erfüllen alle Zeichnungs- und Spezifikationsforderugen:");
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(100, 173.1);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(100.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 173);
$pdf->MultiCell(10,5,"Ya");
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(120, 173.1);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(120.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(125, 173);
$pdf->MultiCell(10,5,"Nein");
$pdf->SetXY(140, 173);
$pdf->MultiCell(40,5,"(Falls 'Nein' bitte Erklärung)");
//linha 15
$pdf->SetXY(6,178);
$pdf->MultiCell(70,5,"Form, Nest, Produktionsprozess:");
$pdf->SetXY(47,178);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(47,183,117,183);
//linha 16
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,184);
$pdf->MultiCell(50,5,"ERKLÄRUNG");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,189);
$pdf->MultiCell(195,3,"Ich bestätige, daß die Proben, die durch dieses warrent dargestellt werden, Repräsentant von unseren zerteilt sind, die durch einen Prozeß gebildet wurden, der allen 4. Ausgabeanforderungen des Produktionsteilzustimmungsprozeßhandbuches entspricht. Ich bestätige weiter, daß diese Proben mit der Produktionsrate von $resp[taxa] / $resp[horas] Stunden produziert wurden.  Auch certity I, das Beweis solcher Befolgung dokumentierte, ist auf Akte und vorhanden für Bericht. Ich habe alle mögliche Abweichungen von dieser Erklärung unten gemerkt."); 
$pdf->SetXY(6,202);
$pdf->MultiCell(40,5,"Erklärung/Bemerkungen:");
$pdf->SetXY(43,200);
$pdf->MultiCell(155,5,$resp["coments"]);
$pdf->Line(43,205,200,205);
$pdf->Line(43,210,200,210);
// linha 17
$pdf->SetXY(6,210);
$pdf->MultiCell(70,5,"Wird jedes Kundenwerkzeug richtig etikettiert und numeriert?");
if($resp["ferram"]=="1"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(80, 211);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(80.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(85, 210);
$pdf->MultiCell(10,5,"Ya");
if($resp["ferram"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(100, 211);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(100.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 210);
$pdf->MultiCell(10,5,"Nein");
//linha 18
$pdf->SetXY(6,215);
$pdf->MultiCell(55,5,"Organisation Autorisierte Unterzeichnung:");
$pdf->SetXY(53,215);
if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,60,200,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(55,215);
	$pdf->MultiCell(100,5,"*Elektronisches Dokument ausgestrahlt.  Unterschrift nicht notwendig*");
	$pdf->SetXY(50,218.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(53,220,150,220);
$pdf->SetXY(152,215);
$pdf->MultiCell(10,5,"Datum");
$pdf->SetXY(162,215);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,220,200,220);

$pdf->SetXY(6,220);
$pdf->MultiCell(25,5,"DruckcName");
$pdf->SetXY(30,220);
$pdf->MultiCell(55,5,$resp["quem"]);
$pdf->Line(25,225,85,225);
$pdf->SetXY(86,220);
$pdf->MultiCell(20,5,"Telefonnummer");
$pdf->SetXY(105,220);
$pdf->MultiCell(30,5,$rescli["tel"]);
$pdf->Line(105,225,145,225);
$pdf->SetXY(146,220);
$pdf->MultiCell(20,5,"TelefaxcZahl");
$pdf->SetXY(162,220);
$pdf->MultiCell(30,5,$rescli["fax"]);
$pdf->Line(162,225,200,225); 
//linha 18
$pdf->SetXY(6,225);
$pdf->MultiCell(20,5,"Position");
$pdf->SetXY(17,225);
$pdf->MultiCell(30,5,$resf["nome"]);
$pdf->Line(17,230,85,230);
$pdf->SetXY(95,225);
$pdf->MultiCell(20,5,"E-mail");
$pdf->SetXY(105,225);
$pdf->MultiCell(50,5,$resg["email"]);
$pdf->Line(105,230,200,230);

// FIM - - - - -
//linha 19
$pdf->Line(5,233,205,233);
//linha 20 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,233);
$pdf->MultiCell(200,5,"FÜR NUR KUNDENCGebrauch (WENN ANWENDBAR)",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,238);
$pdf->MultiCell(50,5,"PPAP-ErmächtigungscEinteilung:");

if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,238);
$pdf->MultiCell(20,5,"Anerkannt");

if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(75,238);
$pdf->MultiCell(20,5,"Zurückgewiesen");

if($resp["disp"]=="4"){ $msg3="X"; }else{ $msg3=" "; }
$pdf->SetXY(100,238);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(100,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105,238);
$pdf->MultiCell(20,5,"Anderes");
$pdf->SetXY(115,238);
$pdf->MultiCell(20,5,"$resp[disp_pq]");
$pdf->Line(115,243,200,243);

//linha 22
$pdf->SetXY(6,243);
$pdf->MultiCell(30,5,"KundencUnterzeichnung");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(34,243);
	$pdf->MultiCell(100,5,"*Elektronisches Dokument ausgestrahlt.  Unterschrift nicht notwendig*");
	$pdf->SetXY(30,246.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(34,248,156,248);
$pdf->SetXY(160,243);
$pdf->MultiCell(15,5,"Datum:");
$pdf->SetXY(171,243);
$pdf->MultiCell(30,5,banco2data($resp["aprocli_dt"]));
$pdf->Line(171,248,200,248);

// linha 22
$pdf->SetXY(6,248);
$pdf->MultiCell(30,5,"DruckcName");
$pdf->SetXY(22,248);
$pdf->MultiCell(64,5,"$res[nomecli]");
$pdf->Line(22,253,86,253);

$pdf->SetXY(88,248);
$pdf->MultiCell(64,5,"Aufspürenzahl des Kunden (wahlweise freigestellt)");
$pdf->SetXY(145,248);
$pdf->MultiCell(65,5,"$res[desenhoi]");
$pdf->Line(145,253,200,253);
//linha 23
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,255);
$pdf->MultiCell(10,2.5,"March   2006");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,255);
$pdf->MultiCell(25,5,"CFG-1001");

// desenvolvedor
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
	
//fim
?>
