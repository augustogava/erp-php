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

$coment=$resp["comentario"];
$numero=$res["numero"];
$pdf->AddPage();
$pg=1;
$pdf->SetFont('Arial','',6);
$pdf->SetXY(6, 5);
$pdf->MultiCell(20,5,"Truck Industry");
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(180, 1);
$pdf->MultiCell(40,5,"PPAP No. $numero \n Page: $pg");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(70);
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
$pdf->MultiCell(23,5,$res["pecacli"]);
$pdf->Line(130,16,153,16);
$pdf->SetXY(161, 11);
$pdf->MultiCell(25,5,"Rev.");
$pdf->SetXY(170, 11);
$pdf->MultiCell(70,5,$res["rev"]);
$pdf->Line(170,16,200,16);
// linha 2
$pdf->SetXY(6, 16);
$pdf->MultiCell(50,5,"Tool PO Number:");
$pdf->SetXY(27, 16);
$pdf->MultiCell(50,5,$res["num_ferram"]); 
$pdf->Line(27,21,83,21);
$pdf->SetXY(88, 16);
$pdf->MultiCell(50,5,"Engineering Drawing Change Level:");
$pdf->SetXY(130, 16);
$pdf->MultiCell(20,5,$res["niveleng"]);
$pdf->Line(130,21,153,21);
$pdf->SetXY(160, 16);
$pdf->MultiCell(20,5,"Dated:");
$pdf->SetXY(170, 16);
$pdf->MultiCell(30,5,banco2data($res["dteng"])); 
$pdf->Line(170,21,200,21);
//linha 3
$pdf->SetXY(6, 21);
$pdf->MultiCell(50,5,"Additional Engineering Changes:");
$pdf->SetXY(44, 21);
$pdf->MultiCell(110,5,$res["alteng"]);
$pdf->Line(44,26,153,26);
$pdf->SetXY(160, 21);
$pdf->MultiCell(10,5,"Dated:");
$pdf->SetXY(170, 21);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(170,26,200,26);
//linha 4
$pdf->SetXY(6, 26);
$pdf->MultiCell(40,5,"Show on Drawing No.");
$pdf->SetXY(32, 26);
$pdf->MultiCell(48,5,$res["desenhoc"]);
$pdf->Line(32,31,80,31);
$pdf->SetXY(85, 26);
$pdf->MultiCell(30,5,"Purchase Order No.");
$pdf->SetXY(108, 26);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(108,31,153,31);
$pdf->SetXY(154, 26);
$pdf->MultiCell(20,5,"Weight(Kg):");
$pdf->SetXY(170, 26);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(170,31,200,31); 
//linha 5
$pdf->SetXY(6, 31);
$pdf->MultiCell(35,5,"Checking Aid No.");
$pdf->SetXY(36, 31);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(27,36,70,36);
$pdf->SetXY(70, 31);
$pdf->MultiCell(50,5,"Checking Aid Enginnering Change Level:");
$pdf->SetXY(117, 31);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(117,36,153,36);
$pdf->SetXY(160, 31);
$pdf->MultiCell(10,5,"Dated:");
$pdf->SetXY(170, 31);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,36,200,36);
//linha 6
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 40);
$pdf->MultiCell(94,5,"ORGANIZATION MANUFACTURING INFORMATION ",0,'');
$pdf->SetXY(105, 40);
$pdf->MultiCell(94,5,"SUBMISSION INFORMATION",0,'');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 45);
	$pdf->MultiCell(94,5,"$rese[razao] \n Organization Name and Code",0);
	$pdf->Line(6,50,100,50);
	$pdf->SetXY(6, 55);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Street Address",0);
	$pdf->Line(6,60,100,60);
	$pdf->SetXY(6, 65);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep]\n City   /   State   /   Zip",0);
	$pdf->Line(6,70,100,70);
	$pdf->SetXY(106, 45);
	$pdf->MultiCell(40,5,"$res[nomecli] \n Customer Name/Division",0);
	$pdf->Line(106,50,200,50);
	$pdf->SetXY(106, 55);
	$pdf->MultiCell(60,5,"$res[comprador] \n Customer Contact",0);
	$pdf->Line(106,60,200,60);	
	$pdf->SetXY(106, 65);
	$pdf->MultiCell(20,5,"$res[aplicacao] \n Application",0);
	$pdf->Line(106,70,200,70);
//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(100,5,"Note:",0,'');
$pdf->SetXY(26, 80);
$pdf->MultiCell(100,5,"Does this part contain any restricted or reportable substances?",0,'');

if($resp["nota1"]=="1"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(109.3,80);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,80);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,79.5);
$pdf->MultiCell(10,5,"Yes");

if($resp["nota1"]=="2"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(124.3,80);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,80);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,79.5);
$pdf->MultiCell(10,5,"No");

$pdf->SetXY(26, 90);
$pdf->MultiCell(105,5,"Are plastic parts identified with appropriate ISO marking codes?",0,'');

if($resp["nota2"]=="1"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(109.3,90);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,90);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,89.5);
$pdf->MultiCell(10,5,"Yes");

if($resp["nota2"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(124.3,90);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,90);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(129,90);
$pdf->MultiCell(10,5,"No");

//linha 9
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 100);
$pdf->MultiCell(100,5,"REASON FOR SUBMISSION",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,106.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,106);
	$pdf->MultiCell(3,3," ",1,'C');
	$pdf->SetXY(12,105);
	$pdf->MultiCell(116,5,"Initial Submission");

	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->SetXY(6.8,110.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,110);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,109);
	$pdf->MultiCell(100,5,"Engineering Change(s) ");

	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,114.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,114);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,113);
	$pdf->MultiCell(100,5,"Tooling: Transfer, Replacement, Refurbishment, or additional ");

	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,118.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,118);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,117);
	$pdf->MultiCell(100,5,"Correction of Discrepancy");

	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,122.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,122);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,121);
	$pdf->MultiCell(100,5,"Tooling Inactive > than 1 year");    
	
	//coluna 2
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,106.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,106);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,105);
	$pdf->MultiCell(100,5,"Change to Optional Construction or Material ");

	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,110.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,110);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,109);
	$pdf->MultiCell(100,5,"Sub-Supplier or Material Source Change  ");

	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,114.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,114);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,113);
	$pdf->MultiCell(100,5,"Change in Part Processing");

	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,118.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,118);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,117);
	$pdf->MultiCell(100,5,"Parts Produced At Additional Location ");

	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,122.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,122);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,121);
	$pdf->MultiCell(100,5,"Other - please Specify below");
	$pdf->SetXY(105,126);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
	$pdf->Line(107,131,162,131);

//linha 12 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,130);
$pdf->MultiCell(150,5,"REQUESTED SUBMISSION LEVEL");
$pdf->SetFont('Arial','',7);
if($resp["nivel"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nivel"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["nivel"]=="3"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["nivel"]=="4"){ $msg4="X"; }else{ $msg4=" "; }
if($resp["nivel"]=="5"){ $msg5="X"; }else{ $msg5=" "; }

$pdf->SetXY(6.8,135.3);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(7,135);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,134);
$pdf->MultiCell(200,5,"Level 1 - Warrant only (and for designated appearance items, an Appearance Approval Report) Submitted to customer.");

$pdf->SetXY(6.8,139.3);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(7,139);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,138);
$pdf->MultiCell(200,5,"Level 2 - Warrant with product samples and limited supporting data submitted to customer.");

$pdf->SetXY(6.8,143.3);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(7,143);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,142);
$pdf->MultiCell(200,5,"Level 3 - Warrant with product samples and complete supporting data submitted to customer.");

$pdf->SetXY(6.8,147.3);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(7,147);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,146);
$pdf->MultiCell(200,5,"Level 4 - Warrant and other requirements as defined by Customer.");
//nivel 4 contagem
$pdf->SetXY(6.8,135.3);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(7,135);
$pdf->MultiCell(3,3," ",1);

$ar= explode(",",$resp["nivel4"]);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(100,149);
if(in_array("1",$ar)){ $check1="X"; }else{ $check1=" "; }
if(in_array("2",$ar)){ $check2="X"; }else{ $check2=" "; }
if(in_array("3",$ar)){ $check3="X"; }else{ $check3=" "; }
if(in_array("4",$ar)){ $check4="X"; }else{ $check4=" "; }
if(in_array("5",$ar)){ $check5="X"; }else{ $check5=" "; }
if(in_array("6",$ar)){ $check6="X"; }else{ $check6=" "; }
if(in_array("7",$ar)){ $check7="X"; }else{ $check7=" "; }
if(in_array("8",$ar)){ $check8="X"; }else{ $check8=" "; }
if(in_array("9",$ar)){ $check9="X"; }else{ $check9=" "; }
if(in_array("10",$ar)){ $check10="X"; }else{ $check10=" "; }
if(in_array("11",$ar)){ $check11="X"; }else{ $check11=" "; }
if(in_array("12",$ar)){ $check12="X"; }else{ $check12=" "; }
if(in_array("13",$ar)){ $check13="X"; }else{ $check13=" "; }
if(in_array("14",$ar)){ $check14="X"; }else{ $check14=" "; }
if(in_array("15",$ar)){ $check15="X"; }else{ $check15=" "; }
if(in_array("16",$ar)){ $check16="X"; }else{ $check16=" "; }
if(in_array("17",$ar)){ $check17="X"; }else{ $check17=" "; }
if(in_array("18",$ar)){ $check18="X"; }else{ $check18=" "; }
if(in_array("19",$ar)){ $check19="X"; }else{ $check19=" "; }
$pdf->SetXY(22,151);
$pdf->MultiCell(100,5,"   1    2    3    4    5    6    7    8    9    10   11   12   13   14   15   16   17   18   19");

$pdf->SetFont('Arial','',8);
$pdf->SetXY(24.5,156.3);
$pdf->MultiCell(3,3,$check1,'C');
$pdf->SetXY(25,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(29.1,156.3);
$pdf->MultiCell(3,3,$check2,'C');
$pdf->SetXY(29.6,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(33.5,156.3);
$pdf->MultiCell(3,3,$check3,'C');
$pdf->SetXY(34,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(38.5,156.3);
$pdf->MultiCell(3,3,$check4,'C');
$pdf->SetXY(39,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(42,156.3);
$pdf->MultiCell(3,3,$check5,'C');
$pdf->SetXY(43.5,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(47.5,156.3);
$pdf->MultiCell(3,3,$check6,'C');
$pdf->SetXY(48,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(52.5,156.3);
$pdf->MultiCell(3,3,$check7,'C');
$pdf->SetXY(53,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(57.5,156.3);
$pdf->MultiCell(3,3,$check8,'C');
$pdf->SetXY(58,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(62.5,156.3);
$pdf->MultiCell(3,3,$check9,'C');
$pdf->SetXY(63,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(67.5,156.3);
$pdf->MultiCell(3,3,$check10,'C');
$pdf->SetXY(68,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(73,156.3);
$pdf->MultiCell(3,3,$check11,'C');
$pdf->SetXY(73.5,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(78.5,156.3);
$pdf->MultiCell(3,3,$check12,'C');
$pdf->SetXY(79,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(84,156.3);
$pdf->MultiCell(3,3,$check13,'C');
$pdf->SetXY(84.5,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(89.5,156.3);
$pdf->MultiCell(3,3,$check14,'C');
$pdf->SetXY(90,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(95,156.3);
$pdf->MultiCell(3,3,$check15,'C');
$pdf->SetXY(95.5,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(100.5,156.3);
$pdf->MultiCell(3,3,$check16,'C');
$pdf->SetXY(101,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(106,156.3);
$pdf->MultiCell(3,3,$check17,'C');
$pdf->SetXY(106.5,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(111.5,156.3);
$pdf->MultiCell(3,3,$check18,'C');
$pdf->SetXY(112,156.3);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(117,156.3);
$pdf->MultiCell(3,3,$check19,'C');
$pdf->SetXY(117.5,156.3);
$pdf->MultiCell(3,3," ",1);

$pdf->SetFont('Arial','',7);
$pdf->SetXY(6.8,161.3);
$pdf->MultiCell(3,3,$msg5,'C');
$pdf->SetXY(7,161);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,160);
$pdf->MultiCell(200,5,"Level 5 - Warrant with product samples and complete supporting data reviewd at supplier´s manufacturing location.");	

//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(50,5,"DECLARATION");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,172);
$pdf->MultiCell(195,4,"I affirm that the samples represented by this warrant are representative of our parts and have been made to the applicable customer drawings and specifications and are made from specified materials on regular production tooling with no operations other than the regular production process. I also certify that documented evidence of such compliance is on file and available for review. I have noted any deviations from this declaration below.");
$pdf->SetXY(6,187);
$pdf->MultiCell(40,5,"EXPLANATION / COMMENTS:");
$pdf->SetXY(43,187);
$pdf->MultiCell(155,5,$resp["coments"]);
$pdf->Line(43,192,200,192);
$pdf->Line(43,197,200,197);
// linha 17
$pdf->SetXY(6,197);
$pdf->MultiCell(70,5,"List Mold / Cavities / Production Processes");
$pdf->SetXY(57,197);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(57,202,200,202);

//linha 18
$pdf->SetXY(6,202);
$pdf->MultiCell(55,5,"Organization Authorized Signature");
$pdf->SetXY(55,202);
if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,60,185,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(55,202);
	$pdf->MultiCell(100,5,"*Electronic document emitted. Signature not necessary*");
	$pdf->SetXY(60,207);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(47,207,150,207);
$pdf->SetXY(152,202);
$pdf->MultiCell(10,5,"Date");
$pdf->SetXY(162,202);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,207,200,207);

$pdf->SetXY(6,207);
$pdf->MultiCell(25,5,"Print Name");
$pdf->SetXY(30,207);
$pdf->MultiCell(55,5,$resp["quem"]);
$pdf->Line(25,212,85,212);
$pdf->SetXY(90,207);
$pdf->MultiCell(20,5,"Phone No.");
$pdf->SetXY(105,207);
$pdf->MultiCell(30,5,$rese["tel"]);
$pdf->Line(105,212,145,212);
$pdf->SetXY(150,207);
$pdf->MultiCell(20,5,"Fax No.");
$pdf->SetXY(162,207);
$pdf->MultiCell(30,5,$rese["fax"]);
$pdf->Line(162,212,200,212); 
//linha 18
$pdf->SetXY(6,212);
$pdf->MultiCell(20,5,"Title");
$pdf->SetXY(15,212);
$pdf->MultiCell(30,5,$resf["nome"]);
$pdf->Line(15,217,85,217);
$pdf->SetXY(95,212);
$pdf->MultiCell(20,5,"E-mail");
$pdf->SetXY(105,212);
$pdf->MultiCell(50,5,$resg["email"]);
$pdf->Line(105,217,200,217);

// FIM - - - - -
//linha 19
$pdf->Line(5,219,205,219);
//linha 20 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(0,219);
$pdf->MultiCell(200,5,"FOR CUSTOMER USE ONLY",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,224);
$pdf->MultiCell(50,5,"PPAP Warrant Disposition:");

if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(50,224);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(50,224);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,224);
$pdf->MultiCell(20,5,"Approved");

if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(70,224);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(70,224);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(75,224);
$pdf->MultiCell(20,5,"Rejected");

if($resp["disp"]=="4"){ $msg2="X"; }else{ $msg2=" "; }  // rever aprovação interina dados vem de lá
$pdf->SetXY(50,229);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(50,229);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,229);
$pdf->MultiCell(20,5,"Interim Approval");

$pdf->SetXY(6,234);
$pdf->MultiCell(30,5,"Customer Signature");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(30,234);
	$pdf->MultiCell(100,5,"*Electronic document emitted. Signature not necessary*");
	$pdf->SetXY(32,239);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(30,239,65,239);
$pdf->SetXY(70,234);
$pdf->MultiCell(15,5,"Date");
$pdf->SetXY(77,234);
$pdf->MultiCell(20,5,banco2data($resp["aprocli_dt"]));
$pdf->Line(77,239,95,239);

$pdf->SetXY(6,239);
$pdf->MultiCell(30,5,"Print Name");
$pdf->SetXY(22,239);
$pdf->MultiCell(64,5,"$res[nomecli]");
$pdf->Line(22,244,65,244);

$pdf->Line(100,224,100,255); // divide coluna

$pdf->SetXY(105,224);
$pdf->MultiCell(60,5,"Comment:");
$pdf->SetXY(110,230);
$pdf->MultiCell(90,4,"$coment");
$pdf->Line(110,234,200,234);
$pdf->Line(110,238,200,238);
$pdf->Line(110,242,200,242);
$pdf->Line(110,246,200,246);
$pdf->Line(110,250,200,250);


//linha 23
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,255);
$pdf->MultiCell(10,2.5,"March   2006");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,255);
$pdf->MultiCell(25,5,"THE-1001");

// desenvolvedor
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
	
//fim
?>
