<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT clientes.id,clientes.fone,clientes.fax FROM clientes,cliente_login,niveis WHERE clientes.nome='$resp[quem]' AND clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id AND niveis.tipo='F'");

$sqlf=mysql_query("SELECT cargos.nome,cliente_login.assinatura FROM funcionarios,cargos,cliente_login  WHERE funcionarios.nome='$resp[quem]' and funcionarios.cargo=cargos.id and cliente_login.funcionario=funcionarios.id");

$resf=mysql_fetch_array($sqlf);

$numero=$res["numero"];
$pdf->AddPage();
$pg=1;
$pdf->SetXY(180, 1);
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80);
$pdf->Cell(0, 10, 'PART SUBMISSION WARRANT');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(20,5,"Part Name:");
$pdf->SetXY(26, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(26,16,104,16);
$pdf->SetXY(107, 11);
$pdf->MultiCell(25,5,"Cust. Part Number:");
$pdf->SetXY(130, 11);
$pdf->MultiCell(70,5,$res["pecacli"]);
$pdf->Line(130,16,200,16);
// linha 2
$pdf->SetXY(6, 16);
$pdf->MultiCell(40,5,"Show on Drawing No.");
$pdf->SetXY(32, 16);
$pdf->MultiCell(80,5,$res["desenhoc"]);
$pdf->Line(32,21,104,21);
$pdf->SetXY(107, 16);
$pdf->MultiCell(25,5,"Org. Part Number:");
$pdf->SetXY(130, 16);
$pdf->MultiCell(70,5,"pegar"); // buscar do banco
$pdf->Line(130,21,200,21);
// linha 3
$pdf->SetXY(6, 21);
$pdf->MultiCell(50,5,"Engineering Change Level:");
$pdf->SetXY(38, 21);
$pdf->MultiCell(25,5,$res["niveleng"]);
$pdf->Line(38,26,104,26);
$pdf->SetXY(120, 21);
$pdf->MultiCell(20,5,"Dated:");
$pdf->SetXY(130, 21);
$pdf->MultiCell(30,5,"pegar"); // buscar do banco
$pdf->Line(130,26,200,26);
//linha 4
$pdf->SetXY(6, 26);
$pdf->MultiCell(50,5,"Additional Engineering Changes:");
$pdf->SetXY(44, 26);
$pdf->MultiCell(90,5,$res["alteng"]);
$pdf->Line(44,31,104,31);
$pdf->SetXY(120, 26);
$pdf->MultiCell(10,5,"Dated:");
$pdf->SetXY(130, 26);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(130,31,200,31);
//linha 5
$pdf->SetXY(6, 31);
$pdf->MultiCell(40,5,"Safety or Government Regulation:");

if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; }
$pdf->SetXY(47,32);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(47.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(52,31);
$pdf->MultiCell(10,5,"Yes");

if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(62,32);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(62.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(67,31);
$pdf->MultiCell(10,5,"No");

$pdf->SetXY(85, 31);
$pdf->MultiCell(30,5,"Purchse Order No.");
$pdf->SetXY(108, 31);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(108,36,153,36);
$pdf->SetXY(154, 31);
$pdf->MultiCell(20,5,"Weight(Kg):");
$pdf->SetXY(170, 31);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(170,36,200,36); 
//linha 6
$pdf->SetXY(6, 36);
$pdf->MultiCell(35,5,"Checking Aid No.");
$pdf->SetXY(36, 36);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(27,41,70,41);
$pdf->SetXY(70, 36);
$pdf->MultiCell(50,5,"Checking Aid Enginnering Change Level:");
$pdf->SetXY(117, 36);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(117,41,153,41);
$pdf->SetXY(160, 36);
$pdf->MultiCell(10,5,"Dated:");
$pdf->SetXY(170, 36);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,41,200,41);
//linha 7
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 45);
$pdf->MultiCell(94,5,"ORGANIZATION MANUFACTURING INFORMATION ",0,'');
$pdf->SetXY(105, 45);
$pdf->MultiCell(94,5,"CUSTOMER SUBMITTAL INFORMATION",0,'');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 50);
	$pdf->MultiCell(94,5,"$rese[razao] \n Supplier Name & Supplier/Vendor Code",0);
	$pdf->Line(6,55,100,55);
	$pdf->SetXY(6, 60);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Street Address",0);
	$pdf->Line(6,65,100,65);
	$pdf->SetXY(6, 70);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep] / pegar\n City   /   Region   /   Postal Code  /  Country",0);
	$pdf->Line(6,75,100,75);
	//coluna 2
/*	$pdf->SetXY(106, 50);
	if($resp["req1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
	if($resp["req2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
	if($resp["req3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
	$pdf->MultiCell(3,3,$msg1,1);
	$pdf->SetXY(111, 50);
	$pdf->MultiCell(40,5,"Dimensional");
	$pdf->SetXY(130, 50);
	$pdf->MultiCell(3,3,$msg2,1);
	$pdf->SetXY(135, 50);
	$pdf->MultiCell(40,5,"Materials/Function ");
	$pdf->SetXY(165, 50);
	$pdf->MultiCell(3,3,$msg3,1);
	$pdf->SetXY(170, 50);
	$pdf->MultiCell(30,5,"Appearance");  */
	$pdf->Line(106,55,200,55);
	$pdf->SetXY(106, 50);
	$pdf->MultiCell(40,5,"$res[nomecli] \n Customer Name/Division:",0);
//	$pdf->SetXY(136, 57);
//	$pdf->MultiCell(70,5,,0);
	$pdf->Line(106,65,200,65);	
	$pdf->SetXY(106, 60);
	$pdf->MultiCell(60,5,"$res[comprador] \n Buyer/Buyer Code:",0);
//	$pdf->SetXY(136, 60);
//	$pdf->MultiCell(50,5,,0);
	$pdf->Line(106,75,200,75);
	$pdf->SetXY(106, 70);
	$pdf->MultiCell(20,5,"$res[aplicacao] \n Application:",0);
//	$pdf->SetXY(136, 70);
//	$pdf->MultiCell(80,5,,0);

//linha 8
/*$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(10,5,"Note",0,'C');

$pdf->SetXY(30, 80);
$pdf->MultiCell(100,5,"Does this part contain any restricted or reportable substances ",0);
$pdf->SetXY(140, 80);
if($resp["nota1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nota1"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(145, 80);
$pdf->MultiCell(10,5,"Yes");
$pdf->SetXY(155, 80);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(160, 80);
$pdf->MultiCell(10,5,"No"); */

//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(94,5,"MATERIALS REPORTING",0,'');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6, 85);
$pdf->MultiCell(100,5,"Has customer-required Substances of Concern information been reported?",0,'');


if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; } // "pegar" chamar valor do banco (correto) - esse campo deve ser implementado
$pdf->SetXY(109.3,85);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,84.5);
$pdf->MultiCell(10,5,"Yes");

if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; } // "pegar" chamar valor do banco (correto) - esse campo deve ser implementado
$pdf->SetXY(124.3,85);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,84.5);
$pdf->MultiCell(10,5,"No");

if($res["isrg"]==" "){ $msg1="X"; }else{ $msg1=" "; } // "pegar" chamar valor do banco (correto) - esse campo deve ser implementado
$pdf->SetXY(135.3,85);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(135.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(139,84.5);
$pdf->MultiCell(10,5,"n/a");

$pdf->SetXY(40, 90);
$pdf->MultiCell(80,5,"Submitted by IMDS or other customer format:",0,'');
$pdf->Line(106,95,200,95);
$pdf->Line(106,100,200,100);
$pdf->SetXY(15, 100);
$pdf->MultiCell(105,5,"Are polymeric parts identified with appropriate ISO marking codes?",0,'');

if($res["nota2"]=="1"){ $msg="X"; }else{ $msg=" "; } // "pegar" chamar valor do banco (correto) - esse campo deve ser implementado
$pdf->SetXY(109.3,101);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,100.5);
$pdf->MultiCell(10,5,"Yes");

if($res["nota2"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(124.3,101);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(129,101);
$pdf->MultiCell(10,5,"No");

if($res["isrg"]==" "){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(135.3,101);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(135.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(139,100.5);
$pdf->MultiCell(10,5,"n/a");

//linha 9
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 106);
$pdf->MultiCell(100,5,"REASON FOR SUBMISSION (Check at least one)",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,111);
	$pdf->MultiCell(3,3," ",1,'C');
	$pdf->SetXY(12,110);
	$pdf->MultiCell(116,5,"Initial Submission");

	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->SetXY(6.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,114);
	$pdf->MultiCell(100,5,"Engineering Change(s) ");

	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,118);
	$pdf->MultiCell(100,5,"Tooling: Transfer, Replacement, Refurbishment, or additional ");

	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,122);
	$pdf->MultiCell(100,5,"Correction of Discrepancy");

	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,126);
	$pdf->MultiCell(100,5,"Tooling Inactive > than 1 year");    
	
	//coluna 2
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,111);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,110);
	$pdf->MultiCell(100,5,"Change to Optional Construction or Material ");

	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,114);
	$pdf->MultiCell(100,5,"Sub-Supplier or Material Source Change  ");

	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,118);
	$pdf->MultiCell(100,5,"Change in Part Processing");

	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,122);
	$pdf->MultiCell(100,5,"Parts Produced At Additional Location ");

	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,126);
	$pdf->MultiCell(100,5,"Other - please Specify:");
	$pdf->SetXY(105,131);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
	$pdf->Line(107,135,162,135);

//linha 12 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,135);
$pdf->MultiCell(150,5,"REQUESTED SUBMISSION LEVEL (Check one)");
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
$pdf->MultiCell(200,5,"Level 1 - Warrant only (and for designated appearance items, an Appearance Approval Report) Submitted to customer) ");

$pdf->SetXY(6.8,144.3);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(7,144);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,143);
$pdf->MultiCell(200,5,"Level 2 - Warrant with product samples and limited supporting data submitted to customer");

$pdf->SetXY(6.8,148.3);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(7,148);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,147);
$pdf->MultiCell(200,5,"Level 3 - Warrant with product samples and complete supporting data submitted to customer");

$pdf->SetXY(6.8,152.3);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(7,152);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,151);
$pdf->MultiCell(200,5,"Level 4 - Warrant and other requirements as defined by Customer.");
/*//nivel 4 contagem
$ar=explode(",",$resp["nivel4"]);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(100,149);
$pdf->MultiCell(95,7,"  1   2   3   4   5   6   7   8   9   10   11   12   13   14   15   16   17   18   19  ",1);
	$enda="pdf/circulo.png";
	if(in_array("1",$ar)) $pdf->Image($enda,101.3,150); 
	if(in_array("2",$ar)) $pdf->Image($enda,105.1,150); 
	if(in_array("3",$ar)) $pdf->Image($enda,108.9,150);
	if(in_array("4",$ar)) $pdf->Image($enda,113.1,150);
	if(in_array("5",$ar)) $pdf->Image($enda,116.9,150);
	if(in_array("6",$ar)) $pdf->Image($enda,120.9,150);
	if(in_array("7",$ar))$pdf->Image($enda,124.7,150);
	if(in_array("8",$ar)) $pdf->Image($enda,128.6,150);
	if(in_array("9",$ar)) $pdf->Image($enda,132.6,150);
	if(in_array("10",$ar)) $pdf->Image($enda,137.4,150);
	if(in_array("11",$ar)) $pdf->Image($enda,142.8,150);
	if(in_array("12",$ar)) $pdf->Image($enda,148.5,150);
	if(in_array("13",$ar)) $pdf->Image($enda,154,150);
	if(in_array("14",$ar)) $pdf->Image($enda,159.6,150);
	if(in_array("15",$ar)) $pdf->Image($enda,164.8,150);
	if(in_array("16",$ar)) $pdf->Image($enda,170.5,150);
	if(in_array("17",$ar)) $pdf->Image($enda,175.8,150);
	if(in_array("18",$ar)) $pdf->Image($enda,181.3,150);
	if(in_array("19",$ar)) $pdf->Image($enda,187,150);
//*/
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6.8,156.3);
$pdf->MultiCell(3,3,$msg5,'C');
$pdf->SetXY(7,156);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,155);
$pdf->MultiCell(200,5,"Level 5 - Warrant with product samples and complete supporting data reviewd at supplier´s manufacturing location.");	
//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,161);
$pdf->MultiCell(50,5,"SUBMISSION RESULTS");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(30,5,"The results for ");
if($resp["res1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["res2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["res3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["res4"]=="1"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->SetXY(33,167);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(33.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(38,167);
$pdf->MultiCell(50,5,"dimensional measurements");
$pdf->SetXY(71,167);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(71.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(76,167);
$pdf->MultiCell(50,5,"material and functional tests");
$pdf->SetXY(116,167);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(116.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(121,167);
$pdf->MultiCell(50,5,"appearence criteria");
$pdf->SetXY(150,167);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(150.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(155,167);
$pdf->MultiCell(50,5,"statistical process package");
//linha 14
$pdf->SetXY(6,173);
$pdf->MultiCell(100,5,"These results meet all design record requirements:");
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(80, 173.1);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(80.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(85, 173);
$pdf->MultiCell(10,5,"Yes");
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(100, 173.1);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(100.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 173);
$pdf->MultiCell(10,5,"No");
$pdf->SetXY(120, 173);
$pdf->MultiCell(40,5,"( If 'NO' - Explanation Required)");
//linha 15
$pdf->SetXY(6,178);
$pdf->MultiCell(70,5,"Mold / Cavity / Production Process:");
$pdf->SetXY(47,178);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(47,183,117,183);
//linha 16
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,184);
$pdf->MultiCell(50,5,"DECLARATION");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,189);
$pdf->MultiCell(195,3,"I affirm that the samples represented by this warrent are representative of ours parts, which were made by a process that meets all Production Part Approval Process Manual 4th Edition Requirements. I further affirm that these samples were produced at the production rate of __**pegar**__/__**pegar**__ hours. I also certity that documented evidence of such compliance is on file and available for review. I have noted any deviations from this declaration below."); // atenção, incluir a variável correta em "**pegar**".
$pdf->SetXY(6,200);
$pdf->MultiCell(40,5,"EXPLANATION / COMMENTS:");
$pdf->SetXY(43,200);
$pdf->MultiCell(155,5,$resp["coments"]);
$pdf->Line(43,205,200,205);
$pdf->Line(43,210,200,210);
// linha 17
$pdf->SetXY(6,210);
$pdf->MultiCell(70,5,"Is each Customer Tool properly tagged and numbered?");
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } // "pegar" chamar valor do banco (correto) - esse campo deve ser implementado
$pdf->SetXY(80, 211);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(80.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(85, 210);
$pdf->MultiCell(10,5,"Yes");
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(100, 211);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(100.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 210);
$pdf->MultiCell(10,5,"No");
//linha 18
$pdf->SetXY(6,215);
$pdf->MultiCell(55,5,"Organization Authorized Signature");
$pdf->SetXY(55,215);
if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,55,200,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(55,215);
	$pdf->MultiCell(60,5,$resp["quem"]);
	$pdf->SetXY(60,221);
	$pdf->SetFont('Arial','B',6);
	$pdf->MultiCell(100,5,"*Documento emetido Eletronicamente Dispensando Assinatura*");
}
$pdf->SetFont('Arial','',7);
$pdf->Line(47,220,150,220);
$pdf->SetXY(152,215);
$pdf->MultiCell(10,5,"Date");
$pdf->SetXY(162,215);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,220,200,220);

$pdf->SetXY(6,220);
$pdf->MultiCell(25,5,"Print Name");
$pdf->SetXY(30,220);
$pdf->MultiCell(55,5,$resp["quem"]);
$pdf->Line(25,225,85,225);
$pdf->SetXY(90,220);
$pdf->MultiCell(20,5,"Phone No.");
$pdf->SetXY(105,220);
$pdf->MultiCell(30,5,$rescli["fone"]);
$pdf->Line(105,225,145,225);
$pdf->SetXY(150,220);
$pdf->MultiCell(20,5,"Fax No.");
$pdf->SetXY(162,220);
$pdf->MultiCell(30,5,$rescli["fax"]);
$pdf->Line(162,225,200,225); 
//linha 18
$pdf->SetXY(6,225);
$pdf->MultiCell(20,5,"Title");
$pdf->SetXY(15,225);
$pdf->MultiCell(30,5,$rescli2["cargonome"]);
$pdf->Line(15,230,85,230);
$pdf->SetXY(95,225);
$pdf->MultiCell(20,5,"E-mail");
$pdf->SetXY(105,225);
$pdf->MultiCell(30,5,"pegar");
$pdf->Line(105,230,200,230);

// FIM - - - - -
//linha 19
$pdf->Line(5,233,205,233);
//linha 20 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,233);
$pdf->MultiCell(200,5,"FOR CUSTOMER USE ONLY (IF APPLICABLE)",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,238);
$pdf->MultiCell(50,5,"PPAP Warrant Disposition:");

if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,238);
$pdf->MultiCell(20,5,"Approved");

if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(75,238);
$pdf->MultiCell(20,5,"Rejected");

if($resp["disp"]=="4"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(95,238);
$pdf->MultiCell(20,5,"Other");
$pdf->SetXY(105,238);
$pdf->MultiCell(20,5,"$resp[disp_pq]");
$pdf->Line(105,243,200,243);
/*$pdf->SetXY(115,243);
$pdf->MultiCell(45,5,"Part Functional Approval:");
$pdf->SetXY(160,243);
if($resp["aprofunc"]=="2"){ $msg3="X"; }else{ $msg3=" "; }
$pdf->MultiCell(5,5,$msg3,1);
$pdf->SetXY(165,243);
$pdf->MultiCell(20,5,"Aproved");
$pdf->SetXY(180,243);
if($resp["aprofunc"]=="3"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->MultiCell(5,5,$msg4,1);
$pdf->SetXY(185,232);
$pdf->MultiCell(20,5,"Waived"); 
//linha 21
$pdf->SetXY(50,238);
if($resp["disp"]=="4"){ $msg5="X"; }else{ $msg5=" "; }
$pdf->MultiCell(5,5,$msg5,1);
$pdf->SetXY(56,238);
$pdf->MultiCell(100,5,"Other - $resp[disp_pq]"); 
//linha 22
*/
$pdf->SetXY(6,243);
$pdf->MultiCell(30,5,"Customer Signature");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(32,243);
	$pdf->MultiCell(124,5,"$res[nomecli]");
	$pdf->SetXY(60,250);
	$pdf->SetFont('Arial','B',6);
	$pdf->MultiCell(32,5,"*Documento emetido Eletronicamente Dispensando Assinatura*");
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
$pdf->MultiCell(30,5,"Print Name");
$pdf->SetXY(22,248);
$pdf->MultiCell(64,5,"$res[nomecli]");
$pdf->Line(22,253,86,253);

$pdf->SetXY(90,248);
$pdf->MultiCell(64,5,"Customer Tracing Number (optional)");
$pdf->SetXY(135,248);
$pdf->MultiCell(65,5,"pegar");
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
