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
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->SetFont('Arial','',8);
if($res["logo"]!="S"){
	$pdf->Image('imagens/logo_chrysler.jpg',5,5,25,5);
	$pdf->Image('imagens/logo_ford.jpg',40,2,20,5);
	$pdf->Image('imagens/logo_gm.jpg',75,1,7,7);
	$pdf->SetXY(5, 1);
	$pdf->Cell(80);
} else{
	$pdf->SetXY(5, 1);
	$pdf->Cell(55);
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 10, 'Certificado de Submissão de Peça de Produção');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(20,5,"Nome da peça:");
$pdf->SetXY(26, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(26,16,104,16);
$pdf->SetXY(112, 11);
$pdf->MultiCell(35,5,"Número da peça (Cliente):");
$pdf->SetXY(145, 11);
$pdf->MultiCell(70,5,$res["pecacli"]);
$pdf->Line(145,16,200,16);
// linha 2
$pdf->SetXY(6, 16);
$pdf->MultiCell(40,5,"Exposto no Desenho Nº:");
$pdf->SetXY(35, 16);
$pdf->MultiCell(80,5,$res["desenhoc"]);
$pdf->Line(35,21,104,21);
$pdf->SetXY(107, 16);
$pdf->MultiCell(45,5,"Número da peça (Fornecedor):");
$pdf->SetXY(145, 16);
$pdf->MultiCell(70,5,"$numero"); // buscar do banco
$pdf->Line(145,21,200,21);
// linha 3
$pdf->SetXY(6, 21);
$pdf->MultiCell(70,5,"Nível de Alteração Engenharia:");
$pdf->SetXY(43, 21);
$pdf->MultiCell(25,5,$res["niveleng"]);
$pdf->Line(43,26,104,26);
$pdf->SetXY(135, 21);
$pdf->MultiCell(20,5,"Data:");
$pdf->SetXY(145, 21);
$pdf->MultiCell(30,5,banco2data($res["dteng"]));
$pdf->Line(145,26,200,26);
//linha 4
$pdf->SetXY(6, 26);
$pdf->MultiCell(50,5,"Alterações Adicionais de Engenharia:");
$pdf->SetXY(50, 26);
$pdf->MultiCell(90,5,$res["alteng"]);
$pdf->Line(50,31,104,31);
$pdf->SetXY(135, 26);
$pdf->MultiCell(10,5,"Data:");
$pdf->SetXY(145, 26);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(145,31,200,31);
//linha 5
$pdf->SetXY(6, 31);
$pdf->MultiCell(70,5,"Item de Segurança e/ou Regulamentação Governamental:");

if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; }
$pdf->SetXY(77,32);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(77.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(82,31);
$pdf->MultiCell(10,5,"Sim");

if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(92,32);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(92.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(97,31);
$pdf->MultiCell(10,5,"Não");

$pdf->SetXY(108, 31);
$pdf->MultiCell(30,5,"Nº Pedido de Compra:");
$pdf->SetXY(135, 31);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(135,36,162,36);
$pdf->SetXY(164, 31);
$pdf->MultiCell(20,5,"Peso(Kg):");
$pdf->SetXY(180, 31);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(180,36,200,36); 
//linha 6
$pdf->SetXY(6, 36);
$pdf->MultiCell(35,5,"Auxílio para Verificação Nº:");
$pdf->SetXY(38, 36);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(38,41,70,41);
$pdf->SetXY(77, 36);
$pdf->MultiCell(50,5,"Nível de Alteração de Engenharia:");
$pdf->SetXY(117, 36);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(117,41,162,41);
$pdf->SetXY(170, 36);
$pdf->MultiCell(10,5,"Data:");
$pdf->SetXY(180, 36);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(180,41,200,41);
//linha 7
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 45);
$pdf->MultiCell(94,5,"INFORMAÇÕES DO FORNECEDOR",0,'');
$pdf->SetXY(105, 45);
$pdf->MultiCell(94,5,"INFORMAÇÕES DE SUBMISSÃO DO CLIENTE",0,'');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 50);
	$pdf->MultiCell(94,5,"$rese[razao] \n Nome do Fornecedor e Código do Fornecedor/Vendedor",0);
	$pdf->Line(6,55,100,55);
	$pdf->SetXY(6, 60);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Endereço",0);
	$pdf->Line(6,65,100,65);
	$pdf->SetXY(6, 70);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep] / $rese[pais]\n Cidade   /   Estado   /   Cep  /  País",0);
	$pdf->Line(6,75,100,75);
	//coluna 2
	$pdf->Line(106,55,200,55);
	$pdf->SetXY(106, 50);
	$pdf->MultiCell(40,5,"$res[nomecli] / \n Nome do Cliente / Divisão:",0);
	$pdf->Line(106,65,200,65);	
	$pdf->SetXY(106, 60);
	$pdf->MultiCell(60,5,"$res[comprador] /  \n Comprador / Código do Comprador:",0);
	$pdf->Line(106,75,200,75);
	$pdf->SetXY(106, 70);
	$pdf->MultiCell(20,5,"$res[aplicacao] \n Aplicação:",0);

//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(94,5,"RELATÓRIO DE MATERIAIS",0,'');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6, 85);
$pdf->MultiCell(100,5,"Cliente requisitou relatório de substâncias restritas?",0,'');


if($resp["rela1"]=="2"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(109.3,85);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,84.5);
$pdf->MultiCell(10,5,"Sim");

if($resp["rela1"]=="1"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(124.3,85);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,84.5);
$pdf->MultiCell(10,5,"Não");

if($resp["rela1"]=="0"){ $msg2="X"; }else{ $msg1=" "; }
$pdf->SetXY(139.3,85);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(139.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(144,84.5);
$pdf->MultiCell(10,5,"n/a");

$pdf->SetXY(40, 90);
$pdf->MultiCell(80,5,"Submetido por IMDS ou formato do cliente:",0,'');
$pdf->SetXY(106, 90);
$pdf->MultiCell(94,5,$resp["imds"],0,'');
$pdf->Line(106,95,200,95);
$pdf->Line(106,100,200,100);
$pdf->SetXY(15, 100);
$pdf->MultiCell(105,5,"Peças Polímeros, identificadas com códigos ISO apropriados?",0,'');

if($resp["rela2"]=="2"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(109.3,101);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,100.5);
$pdf->MultiCell(10,5,"Sim");

if($resp["rela2"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(124.3,101);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,100.5);
$pdf->MultiCell(10,5,"Não");

if($resp["rela2"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(139.3,101);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(139.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(144,100.5);
$pdf->MultiCell(10,5,"n/a");

//linha 9
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 106);
$pdf->MultiCell(100,5,"RAZÃO PARA SUBMISSÃO",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,111);
	$pdf->MultiCell(3,3," ",1,'C');
	$pdf->SetXY(12,110);
	$pdf->MultiCell(116,5,"Submissão inicial.");

	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->SetXY(6.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,114);
	$pdf->MultiCell(100,5,"Alterações de Engenharia.");

	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,118);
	$pdf->MultiCell(100,5,"Ferramental: Transferência, Reposição, Reparo ou Adicional.");

	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,122);
	$pdf->MultiCell(100,5,"Correção de Discrepância.");

	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,126);
	$pdf->MultiCell(100,5,"Ferramental Inativo por mais de 1 ano.");    
	
	//coluna 2
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,111);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,110);
	$pdf->MultiCell(100,5,"Alteração de Material ou Construção Opcional.");

	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,114);
	$pdf->MultiCell(100,5,"Alteração de sub-fornecedor ou na fonte do Material.");

	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,118);
	$pdf->MultiCell(100,5,"Alteração no processo da Peça.");

	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,122);
	$pdf->MultiCell(100,5,"Peças produzidas em outra Localidade.");

	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,126);
	$pdf->MultiCell(100,5,"Outros - Especifique:");
	$pdf->SetXY(105,131);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
	$pdf->Line(107,135,162,135);

//linha 12 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,135);
$pdf->MultiCell(150,5,"NÍVEL DE SUBMISSÃO");
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
$pdf->MultiCell(200,5,"Nível 1 - Certificado apenas (e para itens designados de aparência, um Relatório de Aprovação de Aparência) submetido ao cliente.");

$pdf->SetXY(6.8,144.3);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(7,144);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,143);
$pdf->MultiCell(200,5,"Nível 2 - Certificado com amostras do produto e dados limitados de suporte submetidos ao cliente.");

$pdf->SetXY(6.8,148.3);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(7,148);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,147);
$pdf->MultiCell(200,5,"Nível 3 - Certificado com amostras do produto e todos os dados de suporte submetidos ao cliente.");

$pdf->SetXY(6.8,152.3);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(7,152);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,151);
$pdf->MultiCell(200,5,"Nível 4 - Certificado e outros requisitos conforme definido pelo cliente.");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6.8,156.3);
$pdf->MultiCell(3,3,$msg5,'C');
$pdf->SetXY(7,156);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,155);
$pdf->MultiCell(200,5,"Nível 5 - Certificado com amostras do produto e todos os dados de suporte verificados na localidade de manufatura do fornecedor.");	
//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,161);
$pdf->MultiCell(50,5,"RESULTADOS DA SUBMISSÃO");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(30,5,"Os resultados de ");
if($resp["res1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["res2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["res3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["res4"]=="1"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->SetXY(33,167);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(33.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(38,167);
$pdf->MultiCell(50,5,"medições dimensionais");
$pdf->SetXY(71,167);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(71.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(76,167);
$pdf->MultiCell(50,5,"ensaios de materiais e funcionais");
$pdf->SetXY(116,167);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(116.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(121,167);
$pdf->MultiCell(50,5,"critérios de aparência");
$pdf->SetXY(150,167);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(150.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(155,167);
$pdf->MultiCell(50,5,"dados estatísticos");
//linha 14
$pdf->SetXY(6,173);
$pdf->MultiCell(100,5,"Estes resultados atendem a todos os requisitos dos desenhos e especificações:");
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(100, 173.1);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(100.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 173);
$pdf->MultiCell(10,5,"Sim");
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(120, 173.1);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(120.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(125, 173);
$pdf->MultiCell(10,5,"Não");
$pdf->SetXY(140, 173);
$pdf->MultiCell(40,5,"( Se 'Não' - Especificar abaixo)");
//linha 15
$pdf->SetXY(6,178);
$pdf->MultiCell(70,5,"Molde / Cavidade / Processo de Produção:");
$pdf->SetXY(57,178);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(57,183,117,183);
//linha 16
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,184);
$pdf->MultiCell(50,5,"DECLARAÇÃO");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,189);
$pdf->MultiCell(195,3,"Eu afirmo que as amostras apresentadas nesse certificado são representações de nossas peças, que foram fabricadas segundo os requisitos do Manual do Processo de Aprovação de Peças de Produção, 4ª Edição. Eu afirmo ainda que estas amostras estiveram produzidas na taxa da produção de $resp[taxa]/$resp[horas] horas. Eu certifico também que evidências documentadas de tal conformidade estão disponíveis para revisão. Eu anotei abaixo qualquer desvio desta declaração."); 
$pdf->SetXY(6,200);
$pdf->MultiCell(50,5,"EXPLICAÇÕES / COMENTÁRIOS:");
$pdf->SetXY(46,200);
$pdf->MultiCell(154,5,$resp["coments"]);
$pdf->Line(46,205,200,205);
$pdf->Line(46,210,200,210);
// linha 17
$pdf->SetXY(6,210);
$pdf->MultiCell(80,5,"Ferramental do cliente está etiquetado e numerado corretamente?");
if($resp["ferram"]=="1"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(90, 211);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(90.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(95, 210);
$pdf->MultiCell(10,5,"Sim");
if($resp["ferram"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(110, 211);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(110.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(115, 210);
$pdf->MultiCell(10,5,"Não");
//linha 18
$pdf->SetXY(6,215);
$pdf->MultiCell(55,5,"Assinatura Autorizada do Fornecedor");

if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,60,200,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(50,215);
	$pdf->MultiCell(100,5,"*Documento emetido Eletronicamente, assinatura não é necessária.*");
	$pdf->SetXY(50,218.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(50,220,150,220);
$pdf->SetXY(152,215);
$pdf->MultiCell(10,5,"Data");
$pdf->SetXY(162,215);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,220,200,220);

$pdf->SetXY(6,220);
$pdf->MultiCell(25,5,"Nome");
$pdf->SetXY(15,220);
$pdf->MultiCell(55,5,$resp["quem"]);
$pdf->Line(15,225,85,225);
$pdf->SetXY(84,220);
$pdf->MultiCell(30,5,"Núm. do telefone");
$pdf->SetXY(105,220);
$pdf->MultiCell(30,5,$rese["tel"]);
$pdf->Line(105,225,145,225);
$pdf->SetXY(145,220);
$pdf->MultiCell(20,5,"Núm. do FAX");
$pdf->SetXY(162,220);
$pdf->MultiCell(30,5,$rese["fax"]);
$pdf->Line(162,225,200,225); 
//linha 18
$pdf->SetXY(6,225);
$pdf->MultiCell(20,5,"Cargo");
$pdf->SetXY(15,225);
$pdf->MultiCell(30,5,$resf["nome"]);
$pdf->Line(15,230,85,230);
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
$pdf->MultiCell(200,5,"SOMENTE PARA USO DO CLIENTE (SE APLICÁVEL)",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,238);
$pdf->MultiCell(50,5,"Disposição de Certificação da Peça:");

if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,238);
$pdf->MultiCell(20,5,"Aprovada");

if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(75,238);
$pdf->MultiCell(20,5,"Derrogada");

if($resp["disp"]=="4"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(95,238);
$pdf->MultiCell(20,5,"Outra");
$pdf->SetXY(105,238);
$pdf->MultiCell(20,5,"$resp[disp_pq]");
$pdf->Line(105,243,200,243);

$pdf->SetXY(6,243);
$pdf->MultiCell(30,5,"Assinatura do Cliente");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(32,243);
	$pdf->MultiCell(100,5,"*Documento emetido Eletronicamente, assinatura não é necessária.*");
	$pdf->SetXY(30,246.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(32,248,156,248);
$pdf->SetXY(160,243);
$pdf->MultiCell(15,5,"Data:");
$pdf->SetXY(171,243);
$pdf->MultiCell(30,5,banco2data($resp["aprocli_dt"]));
$pdf->Line(171,248,200,248);

// linha 22
$pdf->SetXY(6,248);
$pdf->MultiCell(30,5,"Nome");
$pdf->SetXY(15,248);
$pdf->MultiCell(64,5,"");
$pdf->Line(15,253,86,253);

$pdf->SetXY(90,248);
$pdf->MultiCell(64,5,"Número de Rastreamento do Cliente (opicional)");
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
