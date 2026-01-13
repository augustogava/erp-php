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
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60);
$pdf->Cell(0, 10, 'Certificado de Submissão de Peça de Produção');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(20,5,"Nome da Peça:");
$pdf->SetXY(26, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(26,16,100,16);
$pdf->SetXY(102, 11);
$pdf->MultiCell(35,5,"Núm. da Peça (Cliente):");
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
$pdf->MultiCell(70,5,"Núm. do Pedido de Compra da Ferramenta:");
$pdf->SetXY(55, 16);
$pdf->MultiCell(20,5,$res["num_ferram"]);
$pdf->Line(55,21,93,21);
$pdf->SetXY(94, 16);
$pdf->MultiCell(70,5,"Nível de Alteração Engenharia:");
$pdf->SetXY(130, 16);
$pdf->MultiCell(20,5,$res["niveleng"]);
$pdf->Line(130,21,153,21);
$pdf->SetXY(160, 16);
$pdf->MultiCell(20,5,"Data:");
$pdf->SetXY(170, 16);
$pdf->MultiCell(30,5,banco2data($res["dteng"]));
$pdf->Line(170,21,200,21);
//linha 3
$pdf->SetXY(6, 21);
$pdf->MultiCell(50,5,"Alterações Adicionais de Engenharia:");
$pdf->SetXY(49, 21);
$pdf->MultiCell(110,5,$res["alteng"]);
$pdf->Line(49,26,153,26);
$pdf->SetXY(160, 21);
$pdf->MultiCell(10,5,"Data:");
$pdf->SetXY(170, 21);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(170,26,200,26);
//linha 4
$pdf->SetXY(6, 26);
$pdf->MultiCell(40,5,"Exposto no Desenho Nº");
$pdf->SetXY(35, 26);
$pdf->MultiCell(48,5,$res["desenhoc"]);
$pdf->Line(35,31,80,31);
$pdf->SetXY(80, 26);
$pdf->MultiCell(30,5,"Nº Pedido de Compra:");
$pdf->SetXY(108, 26);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(108,31,153,31);
$pdf->SetXY(154, 26);
$pdf->MultiCell(20,5,"Peso (Kg):");
$pdf->SetXY(170, 26);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(170,31,200,31); 
//linha 5
$pdf->SetXY(6, 31);
$pdf->MultiCell(35,5,"Auxílio para Verificação Nº");
$pdf->SetXY(36, 31);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(36,36,70,36);
$pdf->SetXY(75, 31);
$pdf->MultiCell(50,5,"Nível de Alteração de Engenharia:");
$pdf->SetXY(117, 31);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(117,36,153,36);
$pdf->SetXY(160, 31);
$pdf->MultiCell(10,5,"Data:");
$pdf->SetXY(170, 31);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,36,200,36);
//linha 6
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 40);
$pdf->MultiCell(94,5,"INFORMAÇÕES DO FORNECEDOR",0,'');
$pdf->SetXY(105, 40);
$pdf->MultiCell(94,5,"INFORMAÇÕES DE SUBMISSÃO",0,'');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 45);
	$pdf->MultiCell(94,5,"$rese[razao] \n Código e nome da Organização",0);
	$pdf->Line(6,50,100,50);
	$pdf->SetXY(6, 55);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Endereço",0);
	$pdf->Line(6,60,100,60);
	$pdf->SetXY(6, 65);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep]\n Cidade   /   Estado   /   CEP",0);
	$pdf->Line(6,70,100,70);
	$pdf->SetXY(106, 45);
	$pdf->MultiCell(40,5,"$res[nomecli] \n Nome/Divisão do Cliente",0);
	$pdf->Line(106,50,200,50);
	$pdf->SetXY(106, 55);
	$pdf->MultiCell(60,5,"$res[comprador] \n Contato do Cliente",0);
	$pdf->Line(106,60,200,60);	
	$pdf->SetXY(106, 65);
	$pdf->MultiCell(20,5,"$res[aplicacao] \n Aplicação",0);
	$pdf->Line(106,70,200,70);
//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(100,5,"Nota:",0,'');
$pdf->SetXY(26, 80);
$pdf->MultiCell(100,5,"Esta peça contém alguma substância de uso restrito ou reportável?",0,'');

if($resp["nota1"]=="1"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(149.3,80);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(149.5,80);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(153,79.5);
$pdf->MultiCell(10,5,"Sim");

if($resp["nota1"]=="2"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(164.3,80);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(164.5,80);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(168,79.5);
$pdf->MultiCell(10,5,"Não");

$pdf->SetXY(26, 90);
$pdf->MultiCell(130,5,"As peças plásticas estão identificadas com os códigos de marcação apropriados da ISO?",0,'');

if($resp["nota2"]=="1"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(149.3,90);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(149.5,90);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(153,89.5);
$pdf->MultiCell(10,5,"Sim");

if($resp["nota2"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(164.3,90);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(164.5,90);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(168,89.5);
$pdf->MultiCell(10,5,"Não");

//linha 9
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 100);
$pdf->MultiCell(100,5,"RAZÃO PARA SUBMISSÃO",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,106.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,106);
	$pdf->MultiCell(3,3," ",1,'C');
	$pdf->SetXY(12,105);
	$pdf->MultiCell(116,5,"Submissão Inicial");

	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->SetXY(6.8,110.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,110);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,109);
	$pdf->MultiCell(100,5,"Alterações de Engenharia");

	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,114.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,114);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,113);
	$pdf->MultiCell(100,5,"Ferramental: Transferência, Reposição, Reparo ou Adicional");

	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,118.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,118);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,117);
	$pdf->MultiCell(100,5,"Correção de Discrepância");

	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,122.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,122);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,121);
	$pdf->MultiCell(100,5,"Ferramental Inativo por mais de 1 ano");    
	
	//coluna 2
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,106.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,106);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,105);
	$pdf->MultiCell(100,5,"Alteração de Material ou Construção Opcional");

	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,110.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,110);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,109);
	$pdf->MultiCell(100,5,"Alteração de sub-fornecedor ou na fonte do Material");

	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,114.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,114);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,113);
	$pdf->MultiCell(100,5,"Alteração no processo da Peça");

	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,118.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,118);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,117);
	$pdf->MultiCell(100,5,"Peças produzidas em outra Localidade ");

	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,122.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,122);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,121);
	$pdf->MultiCell(100,5,"Outros - Especifique");
	$pdf->SetXY(105,126);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
	$pdf->Line(107,131,162,131);

//linha 12 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,130);
$pdf->MultiCell(150,5,"NÍVEL DE SUBMISSÃO");
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
$pdf->MultiCell(200,5,"Nível 1 - Certificado apenas (e para itens designados de aparência, um Relatório de Aprovação de Aparência) submetido ao cliente.");

$pdf->SetXY(6.8,139.3);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(7,139);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,138);
$pdf->MultiCell(200,5,"Nível 2 - Certificado com amostras do produto e dados limitados de suporte submetidos ao cliente.");

$pdf->SetXY(6.8,143.3);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(7,143);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,142);
$pdf->MultiCell(200,5,"Nível 3 - Certificado com amostras do produto e todos os dados de suporte submetidos ao cliente.");

$pdf->SetXY(6.8,147.3);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(7,147);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,146);
$pdf->MultiCell(200,5,"Nível 4 - Certificado e outros requisitos conforme definido pelo cliente.");
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
$pdf->MultiCell(200,5,"Nível 5 - Certificado com amostras do produto e todos os dados de suporte verificados na localidade de manufatura do fornecedor.");	

//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(50,5,"DECLARAÇÃO");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,172);
$pdf->MultiCell(195,4," Eu afirmo que as amostras apresentadas nesse certificado são representações de nossas peças, feito sob a especificação aplicável dos desenhos do nosso cliente e foram fabricadas a partir de matérias primas especificadas em uma produção com ferramentais e operações não diferentes do processo regular de produção. Eu certifico também que evidências documentadas de tal conformidade estão disponíveis para revisão. Eu anotei abaixo qualquer desvio desta declaração.");
$pdf->SetXY(6,185);
$pdf->MultiCell(60,5,"EXPLICAÇÕES / COMENTÁRIOS:");
$pdf->SetXY(47,185);
$pdf->MultiCell(153,5,$resp["coments"]);
$pdf->Line(47,190,200,190);
$pdf->Line(47,195,200,195);
// linha 17
$pdf->SetXY(6,197);
$pdf->MultiCell(70,5,"Molde / Cavidade / Processo de Produção");
$pdf->SetXY(57,197);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(57,202,200,202);

//linha 18
$pdf->SetXY(6,202);
$pdf->MultiCell(55,5,"Assinatura Autorizada do Fornecedor");
if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,60,185,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(52,202);
	$pdf->MultiCell(100,5,"*Documento emetido Eletronicamente, assinatura não é necessária.*");
	$pdf->SetXY(52,207);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(52,207,150,207);
$pdf->SetXY(152,202);
$pdf->MultiCell(10,5,"Data");
$pdf->SetXY(162,202);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,207,200,207);

$pdf->SetXY(6,207);
$pdf->MultiCell(25,5,"Nome");
$pdf->SetXY(15,207);
$pdf->MultiCell(55,5,$resp["quem"]); 
$pdf->Line(15,212,85,212);
$pdf->SetXY(87,207);
$pdf->MultiCell(20,5,"Núm. Telefone");
$pdf->SetXY(105,207);
$pdf->MultiCell(30,5,$rese["tel"]); // empresa
$pdf->Line(105,212,145,212);
$pdf->SetXY(148,207);
$pdf->MultiCell(20,5,"Núm. Fax");
$pdf->SetXY(162,207);
$pdf->MultiCell(30,5,$rese["fax"]); // empresa
$pdf->Line(162,212,200,212); 
//linha 18
$pdf->SetXY(6,212);
$pdf->MultiCell(20,5,"Cargo");
$pdf->SetXY(15,212);
$pdf->MultiCell(30,5,$resf["nome"]); // o que é isso?
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
$pdf->MultiCell(200,5,"SOMENTE PARA USO DO CLIENTE",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,224);
$pdf->MultiCell(50,5,"Disposição de Certificação da Peça:");

if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(50,224);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(50,224);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,224);
$pdf->MultiCell(20,5,"Aprovada");

if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(70,224);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(70,224);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(75,224);
$pdf->MultiCell(20,5,"Derrogada");

if($resp["disp"]=="4"){ $msg2="X"; }else{ $msg2=" "; }  // rever aprovação interina dados vem de lá
$pdf->SetXY(50,229);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(50,229);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,229);
$pdf->MultiCell(30,5,"Aprovação Interina");

$pdf->SetXY(6,234);
$pdf->MultiCell(30,5,"Assinatura do Cliente");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(33,234);
	$pdf->MultiCell(100,5,"*Documento emetido Eletronicamente, assinatura não é necessária.*");
	$pdf->SetXY(33,239);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(33,239,65,239);
$pdf->SetXY(70,234);
$pdf->MultiCell(15,5,"Data");
$pdf->SetXY(77,234);
$pdf->MultiCell(20,5,banco2data($resp["aprocli_dt"]));
$pdf->Line(77,239,95,239);

$pdf->SetXY(6,239);
$pdf->MultiCell(30,5,"Nome");
$pdf->SetXY(16,239);
$pdf->MultiCell(64,5,"");
$pdf->Line(16,244,65,244);

$pdf->Line(100,224,100,255); // divide coluna

$pdf->SetXY(105,224);
$pdf->MultiCell(60,5,"Comentários:");
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
