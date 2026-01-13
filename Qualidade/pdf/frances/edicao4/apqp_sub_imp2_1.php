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
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
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
$pdf->Cell(0, 10, 'Certificat de Soumission de Piéce');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(40,5,"Désignation de Piéce:");
$pdf->SetXY(34, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(34,16,104,16);
$pdf->SetXY(107, 11);
$pdf->MultiCell(50,5,"Numéro de Piéce (Client):");
$pdf->SetXY(138, 11);
$pdf->MultiCell(70,5,$res["pecacli"]);
$pdf->Line(138,16,200,16);
// linha 2
$pdf->SetXY(6, 16);
$pdf->MultiCell(40,5,"Figure sur plan Nº:");
$pdf->SetXY(29, 16);
$pdf->MultiCell(80,5,$res["desenhoc"]);
$pdf->Line(29,21,104,21);
$pdf->SetXY(107, 16);
$pdf->MultiCell(50,5,"Numéro de Piéce (Organisation):");
$pdf->SetXY(144, 16);
$pdf->MultiCell(70,5,"$numero"); // buscar do banco
$pdf->Line(144,21,200,21);
// linha 3
$pdf->SetXY(6, 21);
$pdf->MultiCell(50,5,"Modification Technique:");
$pdf->SetXY(36, 21);
$pdf->MultiCell(25,5,$res["niveleng"]);
$pdf->Line(36,26,104,26);
$pdf->SetXY(120, 21);
$pdf->MultiCell(20,5,"Daté:");
$pdf->SetXY(130, 21);
$pdf->MultiCell(30,5,banco2data($res["dteng"])); // buscar do banco
$pdf->Line(130,26,200,26);
//linha 4
$pdf->SetXY(6, 26);
$pdf->MultiCell(50,5,"Modifications techniques supplémentaires:");
$pdf->SetXY(56, 26);
$pdf->MultiCell(90,5,$res["alteng"]);
$pdf->Line(56,31,104,31);
$pdf->SetXY(120, 26);
$pdf->MultiCell(10,5,"Daté:");
$pdf->SetXY(130, 26);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(130,31,200,31);
//linha 5
$pdf->SetXY(6, 31);
$pdf->MultiCell(60,5,"Règlement de sûreté ou de Gouvernement:");

if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; }
$pdf->SetXY(57,32);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(57.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(62,31);
$pdf->MultiCell(10,5,"Oui");

if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(72,32);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(72.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(77,31);
$pdf->MultiCell(10,5,"Non");

$pdf->SetXY(90, 31);
$pdf->MultiCell(30,5,"Numéro de commande:");
$pdf->SetXY(117, 31);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(117,36,153,36);
$pdf->SetXY(154, 31);
$pdf->MultiCell(20,5,"Poids(Kg):");
$pdf->SetXY(170, 31);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(170,36,200,36); 
//linha 6
$pdf->SetXY(6, 36);
$pdf->MultiCell(35,5,"Aide pour la vérification Nº:");
$pdf->SetXY(36, 36);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(36,41,60,41);
$pdf->SetXY(60, 36);
$pdf->MultiCell(80,5,"Vérification Du Niveau De Changement D'Enginnering D'Aide:");
$pdf->SetXY(129, 36);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(129,41,153,41);
$pdf->SetXY(160, 36);
$pdf->MultiCell(10,5,"Daté:");
$pdf->SetXY(170, 36);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,41,200,41);
//linha 7
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 45);
$pdf->MultiCell(94,5,"L'Information De Fabrication D'Organisation",0,'');
$pdf->SetXY(105, 45);
$pdf->MultiCell(94,5,"L'Information De Submittal De Client",0,'');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 50);
	$pdf->MultiCell(94,5,"$rese[razao] \n Code de nom de fournisseur",0);
	$pdf->Line(6,55,100,55);
	$pdf->SetXY(6, 60);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Adresse",0);
	$pdf->Line(6,65,100,65);
	$pdf->SetXY(6, 70);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep] / $rese[pais]\n Ville   /   Région   /   Code postal  /  Pays",0);
	$pdf->Line(6,75,100,75);
	//coluna 2
	$pdf->Line(106,55,200,55);
	$pdf->SetXY(106, 50);
	$pdf->MultiCell(40,5,"$res[nomecli] \n Nom De Client/Division:",0);
	$pdf->Line(106,65,200,65);	
	$pdf->SetXY(106, 60);
	$pdf->MultiCell(60,5,"$res[comprador] \n Nom/Code D'Acheteur:",0);
	$pdf->Line(106,75,200,75);
	$pdf->SetXY(106, 70);
	$pdf->MultiCell(20,5,"$res[aplicacao] \n Application:",0);

//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(94,5,"REPORTAGE DE MATÉRIAUX",0,'');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6, 85);
$pdf->MultiCell(100,5,"Est-ce que des substances client-exigées d'information de souci a été rapportées?",0,'');
if($resp["rela1"]=="2"){ $msg="X"; }else{ $msg=" "; }
if($resp["rela1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["rela1"]=="0"){ $msg2="X"; }else{ $msg2=" "; }

$pdf->SetXY(109.3,85);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,84.5);
$pdf->MultiCell(10,5,"Oui");

$pdf->SetXY(124.3,85);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,84.5);
$pdf->MultiCell(10,5,"Non");

$pdf->SetXY(138.3,85);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(138.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(142,84.5);
$pdf->MultiCell(10,5,"p/a");

$pdf->SetXY(45, 90);
$pdf->MultiCell(80,5,"Soumis par IMDS ou tout autre format de client:",0,'');
$pdf->SetXY(106, 90);
$pdf->MultiCell(94,5,$resp["imds"],0,'');
$pdf->Line(106,95,200,95);
$pdf->Line(106,100,200,100);
$pdf->SetXY(6, 100);
$pdf->MultiCell(105,2.5,"Les piéces en matiére plastic sont-elles identifiées par les codes de marquage ISO appropriés?",0,'');

if($resp["rela2"]=="2"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(109.3,101);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,100.5);
$pdf->MultiCell(10,5,"Oui");

if($resp["rela2"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(124.3,101);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,101);
$pdf->MultiCell(10,5,"Non");

if($resp["rela2"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(138.3,101);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(138.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(142,100.5);
$pdf->MultiCell(10,5,"p/a");

//linha 9
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 106);
$pdf->MultiCell(100,5,"RAISON DE LA SOUMISSION",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,111);
	$pdf->MultiCell(3,3," ",1,'C');
	$pdf->SetXY(12,110);
	$pdf->MultiCell(116,5,"Soumission Initiale");

	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->SetXY(6.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,114);
	$pdf->MultiCell(100,5,"Modification(s) Techniques(s)");

	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,118);
	$pdf->MultiCell(100,5,"Outllage: Transfet, remplacement, reconditionnement ou supplémentaire");

	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,122);
	$pdf->MultiCell(100,5,"Correction de deviation");

	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,126);
	$pdf->MultiCell(100,5,"Outillages Inactifs > 1 an");    
	
	//coluna 2
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,111);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,110);
	$pdf->MultiCell(100,5,"Changement d´option de construction ou matiére");

	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,114);
	$pdf->MultiCell(100,5,"Changement sous-contractant ou origine matiére");

	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,118);
	$pdf->MultiCell(100,5,"Modification du processus de fabrication des piéces");

	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,122);
	$pdf->MultiCell(100,5,"Piéces produites sur un autre site");

	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,126);
	$pdf->MultiCell(100,5,"Autre - Merci de Spécifier:");
	$pdf->SetXY(105,131);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
	$pdf->Line(107,135,162,135);

//linha 12 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,135);
$pdf->MultiCell(150,5,"NIVEAU SE SOUMISSION REQUIS");
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
$pdf->MultiCell(200,5,"Niveau 1 - Certificat seulement soumis au client (et pour les élements désignés éléments d´aspect, un Rapport d´Homologation d´aspect.");

$pdf->SetXY(6.8,144.3);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(7,144);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,143);
$pdf->MultiCell(200,5,"Niveau 2 - Certificat soumis au client avec les échantillons produit et un dossier limité de donées supportant la soumission.");

$pdf->SetXY(6.8,148.3);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(7,148);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,147);
$pdf->MultiCell(200,5,"Niveau 3 - Certificat Soumis au client avec les échantillons produit et un dossier complet de données supportant la soumission.");

$pdf->SetXY(6.8,152.3);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(7,152);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,151);
$pdf->MultiCell(200,5,"Niveau 4 - Certificat et autres exigences définiés par le client.");

$pdf->SetFont('Arial','',7);
$pdf->SetXY(6.8,156.3);
$pdf->MultiCell(3,3,$msg5,'C');
$pdf->SetXY(7,156);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,155);
$pdf->MultiCell(200,5,"Niveau 5 - Certificat avec les échantillons produit et un dossier complet de données supoortant la soumission, exminés sur site fournisseur.");	
//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,161);
$pdf->MultiCell(50,5,"RÉSULTATS DE LA SOUMISSION");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(30,5,"Les resultats de");
if($resp["res1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["res2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["res3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["res4"]=="1"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->SetXY(33,167);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(33.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(38,167);
$pdf->MultiCell(50,5,"Measures dimensionnel");
$pdf->SetXY(71,167);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(71.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(76,167);
$pdf->MultiCell(50,5,"essais matiére et fonctionnels");
$pdf->SetXY(116,167);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(116.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(121,167);
$pdf->MultiCell(50,5,"critéres d´aspect");
$pdf->SetXY(150,167);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(150.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(155,167);
$pdf->MultiCell(50,5,"processus statistique");
//linha 14
$pdf->SetXY(6,173);
$pdf->MultiCell(100,5,"Ces résultats répondent à toules les exigences des plans et spécification:");
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(100, 173.1);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(100.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 173);
$pdf->MultiCell(10,5,"Oui");
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(115, 173.1);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(115.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(120, 173);
$pdf->MultiCell(10,5,"Non");
$pdf->SetXY(135, 173);
$pdf->MultiCell(40,5,"(Si 'Non' - Explications Exigées)");
//linha 15
$pdf->SetXY(6,178);
$pdf->MultiCell(70,5,"Moule / Cavité / Processus de Production:");
$pdf->SetXY(54,178);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(54,183,117,183);
//linha 16
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,184);
$pdf->MultiCell(50,5,"DECLARATION / ATTESTATION");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,189);
$pdf->MultiCell(195,3,"J'affirme que les échantillons représentés par ce warrent sont représentant à nous partie, qui ont été faits par un processus qui répond à toutes les exigences d'édition de manuel de processus d'approbation de pièce de production 4èmes.  J'affirme plus loin que ces échantillons ont été produits au taux de production de $resp[taxa] / $resp[horas] heures.  Également le certity I qui a documenté l'évidence d'une telle conformité est sur le dossier et disponible pour la revue.  J'ai noté toutes les déviations de cette déclaration ci-dessous."); 
$pdf->SetXY(6,200);
$pdf->MultiCell(40,5,"EXPLICATION/COMMENTAIRES:");
$pdf->SetXY(45,200);
$pdf->MultiCell(160,5,$resp["coments"]);
$pdf->Line(45,205,200,205);
$pdf->Line(45,210,200,210);
// linha 17
$pdf->SetXY(6,210);
$pdf->MultiCell(100,5,"Est-ce que chaque outil de client est correctement étiqueté et numéroté?");
if($resp["ferram"]=="1"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(100, 211);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(100.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 210);
$pdf->MultiCell(10,5,"Oui");
if($resp["ferram"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(120, 211);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(120.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(125, 210);
$pdf->MultiCell(10,5,"Non");
//linha 18
$pdf->SetXY(6,215);
$pdf->MultiCell(55,5,"Signature du Responsable Autorisé");
$pdf->SetXY(55,215);
if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,60,200,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(55,215);
	$pdf->MultiCell(100,5,"*Le document électronique a émis. Signature non nécessaire*");
	$pdf->SetXY(50,218.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(47,220,150,220);
$pdf->SetXY(152,215);
$pdf->MultiCell(10,5,"Date");
$pdf->SetXY(162,215);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,220,200,220);

$pdf->SetXY(6,220);
$pdf->MultiCell(25,5,"Nom");
$pdf->SetXY(17,220);
$pdf->MultiCell(55,5,$resp["quem"]);
$pdf->Line(17,225,85,225);
$pdf->SetXY(90,220);
$pdf->MultiCell(20,5,"Téléphone");
$pdf->SetXY(105,220);
$pdf->MultiCell(30,5,$rescli["tel"]);
$pdf->Line(105,225,150,225);
$pdf->SetXY(153,220);
$pdf->MultiCell(20,5,"Fax");
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
$pdf->MultiCell(200,5,"RESERVE AU CLIENT SEULEMENT (si applicable)",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,238);
$pdf->MultiCell(50,5,"Statut de la soumission:");

if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,238);
$pdf->MultiCell(20,5,"Accepté");

if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(75,238);
$pdf->MultiCell(20,5,"Refusé");

if($resp["disp"]=="4"){ $msg3="X"; }else{ $msg3=" "; }
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(95,238);
$pdf->MultiCell(20,5,"Autre");
$pdf->SetXY(105,238);
$pdf->MultiCell(20,5,"$resp[disp_pq]");
$pdf->Line(105,243,200,243);

//linha 22
$pdf->SetXY(6,243);
$pdf->MultiCell(30,5,"Signature du Client");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(32,243);
	$pdf->MultiCell(100,5,"*Le document électronique a émis. Signature non nécessaire*");
	$pdf->SetXY(30,246.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(32,248,156,248);
$pdf->SetXY(160,243);
$pdf->MultiCell(15,5,"Date:");
$pdf->SetXY(171,243);
$pdf->MultiCell(30,5,banco2data($resp["aprocli_dt"]));
$pdf->Line(171,248,200,248);

// linha 22
$pdf->SetXY(6,248);
$pdf->MultiCell(30,5,"Non");
$pdf->SetXY(14,248);
$pdf->MultiCell(64,5,"$res[nomecli]");
$pdf->Line(14,253,82,253);

$pdf->SetXY(83,248);
$pdf->MultiCell(64,5,"Nombre de cheminement de client (facultatif)");
$pdf->SetXY(135,248);
$pdf->MultiCell(65,5,"$res[desenhoi]");
$pdf->Line(135,253,200,253);
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
