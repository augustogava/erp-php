<?php
if(empty($tira)){
include('../conecta.php');
require('fpdf.php');}
$pc=$_GET["pc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT clientes.id,clientes.fone,clientes.fax FROM clientes,cliente_login,niveis WHERE clientes.nome='$resp[quem]' AND clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id AND niveis.tipo='F'");

if(empty($tira)){$pdf=new FPDF();}

$pdf->AddPage();
$pdf->Image('../imagens/logo_chrysler.jpg',5,5,25,5);
$pdf->Image('../imagens/logo_ford.jpg',40,2,20,5);
$pdf->Image('../imagens/logo_gm.jpg',75,1,7,7);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80);
$pdf->Cell(0, 10, 'Certificado de Submissão de Peça de Produção');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(20,5,"Nome Peça:");
$pdf->SetXY(26, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(26,16,106,16);
$pdf->SetXY(110, 11);
$pdf->MultiCell(20,5,"Numero Peça:");
$pdf->SetXY(130, 11);
$pdf->MultiCell(70,5,$res["pecacli"]);
$pdf->Line(130,16,200,16);
//linha 2
$pdf->SetXY(6, 17);
$pdf->MultiCell(40,5,"Item de Segurança e/ou Regulamentação Governamental:");
$pdf->SetXY(47, 19);
if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; }
$pdf->MultiCell(5,5,$msg,1,'C');
$pdf->SetXY(52, 19);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(62, 19);
if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->MultiCell(5,5,$msg1,1,'C');
$pdf->SetXY(67, 19);
$pdf->MultiCell(10,5,"Não");
$pdf->SetXY(77, 17);
$pdf->MultiCell(50,5,"Nível de Alteração de Desenho de Engenharia:");
$pdf->SetXY(132, 17);
$pdf->MultiCell(35,5,$res["niveleng"]);
$pdf->Line(130,22,165,22);
$pdf->SetXY(165, 17);
$pdf->MultiCell(10,5,"Data:");
$pdf->SetXY(175, 17);
$pdf->MultiCell(25,5,banco2data($res["dteng"]));
$pdf->Line(175,22,200,22);
//linha 3
$pdf->SetXY(6, 27);
$pdf->MultiCell(50,5,"Alterações Adicionais de Engenharia:");
$pdf->SetXY(50, 27);
$pdf->MultiCell(90,5,$res["alteng"]);
$pdf->Line(50,32,146,32);
$pdf->SetXY(160, 27);
$pdf->MultiCell(10,5,"Data:");
$pdf->SetXY(170, 27);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(170,32,200,32);
//linha 4
$pdf->SetXY(6, 33);
$pdf->MultiCell(35,5,"Exposto no Desenho Nº");
$pdf->SetXY(36, 33);
$pdf->MultiCell(30,5,$res["desenhoc"]);
$pdf->Line(36,38,81,38);
$pdf->SetXY(85, 33);
$pdf->MultiCell(30,5,"Nº Pedido de Compra");
$pdf->SetXY(115, 33);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(115,38,155,38);
$pdf->SetXY(155, 33);
$pdf->MultiCell(15,5,"Peso(KG):");
$pdf->SetXY(170, 33);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(170,38,200,38);
//linha 5
$pdf->SetXY(6, 39);
$pdf->MultiCell(35,5,"Auxílio para Verificação Nº");
$pdf->SetXY(36, 39);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(36,44,76,44);
$pdf->SetXY(77, 39);
$pdf->MultiCell(40,5,"Nível de Alteração de Engenharia ");
$pdf->SetXY(117, 39);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(117,44,150,44);
$pdf->SetXY(160, 39);
$pdf->MultiCell(10,5,"Data:");
$pdf->SetXY(170, 39);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,44,200,44);
//linha 6
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 45);
$pdf->MultiCell(94,5,"INFORMAÇÕES DO FORNECEDOR ",0,'C');
$pdf->SetXY(105, 45);
$pdf->MultiCell(94,5,"INFORMAÇÕES DE SUBMISSÃO",0,'C');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 50);
	$pdf->MultiCell(94,5,"$rese[razao] \n Nome do Fornecedor / Código do Fornecedor",0);
	$pdf->Line(6,55,100,55);
	$pdf->SetXY(6, 60);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Endereço",0);
	$pdf->Line(6,65,100,65);
	$pdf->SetXY(6, 70);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep] \n Cidade / Estado / CEP",0);
	$pdf->Line(6,75,100,75);
	//coluna 2
	$pdf->SetXY(106, 50);
	if($resp["req1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
	if($resp["req2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
	if($resp["req3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
	$pdf->MultiCell(5,5,$msg1,1);
	$pdf->SetXY(111, 50);
	$pdf->MultiCell(40,5,"Dimensional");
	$pdf->SetXY(130, 50);
	$pdf->MultiCell(5,5,$msg2,1);
	$pdf->SetXY(135, 50);
	$pdf->MultiCell(40,5,"Materiais / Funcional ");
	$pdf->SetXY(165, 50);
	$pdf->MultiCell(5,5,$msg3,1);
	$pdf->SetXY(170, 50);
	$pdf->MultiCell(30,5,"Aparência");
	$pdf->SetXY(106, 60);
	$pdf->MultiCell(40,5,"Nome do Cliente / Divisão:",0);
	$pdf->SetXY(140, 60);
	$pdf->MultiCell(70,5,$res["nomecli"],0);
	$pdf->Line(140,65,200,65);
	$pdf->SetXY(106, 65);
	$pdf->MultiCell(60,5,"Comprador / Código do Comprador:",0);
	$pdf->SetXY(150, 65);
	$pdf->MultiCell(50,5,$res["comprador"],0);
	$pdf->Line(150,70,200,70);
	$pdf->SetXY(106, 70);
	$pdf->MultiCell(20,5,"Aplicação:",0);
	$pdf->SetXY(120, 70);
	$pdf->MultiCell(80,5,$res["aplicacao"],0);
	$pdf->Line(120,75,200,75);
//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(10,5,"Nota",0,'C');

$pdf->SetXY(30, 80);
$pdf->MultiCell(100,5,"Esta peça contém alguma substância de uso restrito ou reportável ",0);
$pdf->SetXY(140, 80);
if($resp["nota1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nota1"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(145, 80);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(155, 80);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(160, 80);
$pdf->MultiCell(10,5,"Não");
//linha 9
$pdf->SetXY(30, 86);
$pdf->MultiCell(110,5,"As peças plásticas estão identificadas com os códigos de marcação apropriados da ISO",0);
$pdf->SetXY(140, 86);
if($resp["nota2"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nota2"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(145, 86);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(155, 86);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(160, 86);
$pdf->MultiCell(10,5,"Não");
//linha 10
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 90);
$pdf->MultiCell(100,5,"RAZÃO PARA SUBMISSÃO",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	$pdf->SetXY(6,95);
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,95);
	$pdf->MultiCell(100,5,"Submissão Inicial");
	$pdf->SetXY(6,101);
	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,101);
	$pdf->MultiCell(100,5,"Alterações de Engenharia ");
	$pdf->SetXY(6,107);
	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,107);
	$pdf->MultiCell(100,5,"Ferramental: Transferência, Reposição, Reparo ou Adicional ");
	$pdf->SetXY(6,113);
	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,113);
	$pdf->MultiCell(100,5,"Correção de Discrepância ");
	$pdf->SetXY(6,119);
	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,119);
	$pdf->MultiCell(100,5,"Ferramental Inativo por mais de 1 ano");
	//coluna 2
	$pdf->SetXY(106,95);
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,95);
	$pdf->MultiCell(100,5,"Alteração de Material ou Construção Opcional ");
	$pdf->SetXY(106,101);
	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,101);
	$pdf->MultiCell(100,5,"Alteração de sub-fornecedor ou na fonte do Material  ");
	$pdf->SetXY(106,107);
	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,107);
	$pdf->MultiCell(100,5,"Alteração no processo da Peça ");
	$pdf->SetXY(106,113);
	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,113);
	$pdf->MultiCell(100,5,"Peças produzidas em outra Localidade ");
	$pdf->SetXY(106,119);
	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,119);
	$pdf->MultiCell(100,5,"Outros - Especifique:");
	$pdf->SetXY(142,119);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
//linha 12
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,125);
$pdf->MultiCell(50,5,"NÍVEL DE SUBMISSÃO ( Marque um )");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,131);
if($resp["nivel"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nivel"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["nivel"]=="3"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["nivel"]=="4"){ $msg4="X"; }else{ $msg4=" "; }
if($resp["nivel"]=="5"){ $msg5="X"; }else{ $msg5=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(12,131);
$pdf->MultiCell(200,5,"Nível 1 - Certificado apenas (e para itens designados de aparência, um Relatório de Aprovação de Aparência) submetido ao cliente ");
$pdf->SetXY(6,137);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(12,137);
$pdf->MultiCell(200,5,"Nível 2 - Certificado com amostras do produto e dados limitados de suporte submetidos ao cliente");
$pdf->SetXY(6,143);
$pdf->MultiCell(5,5,$msg3,1);
$pdf->SetXY(12,143);
$pdf->MultiCell(200,5,"Nível 3 - Certificado com amostras do produto e todos os dados de suporte submetidos ao cliente");
$pdf->SetXY(6,149);
$pdf->MultiCell(5,5,$msg4,1);
$pdf->SetXY(12,149);
$pdf->MultiCell(200,5,"Nível 4 - Certificado e outros requisitos conforme definido pelo cliente");
$pdf->SetXY(6,155);
$pdf->MultiCell(5,5,$msg5,1);
$pdf->SetXY(12,155);
$pdf->MultiCell(200,5,"Nível 5 - Certificado com amostras do produto e todos os dados de suporte verificados na localidade de manufatura do fornecedor ");
//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,161);
$pdf->MultiCell(50,5,"RESULTADOS DA SUBMISSÃO");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(30,5,"Os resultados de ");
$pdf->SetXY(33,167);
if($resp["res1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["res2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["res3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["res4"]=="1"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(41,167);
$pdf->MultiCell(30,5,"medições dimensionais");
$pdf->SetXY(71,167);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(76,167);
$pdf->MultiCell(40,5,"ensaios de materiais e funcionais");
$pdf->SetXY(116,167);
$pdf->MultiCell(5,5,$msg3,1);
$pdf->SetXY(121,167);
$pdf->MultiCell(30,5,"critérios de aparência");
$pdf->SetXY(150,167);
$pdf->MultiCell(5,5,$msg4,1);
$pdf->SetXY(155,167);
$pdf->MultiCell(30,5,"dados estatísticos ");
//linha 14
$pdf->SetXY(6,173);
$pdf->MultiCell(100,5,"Estes resultados atendem a todos os requisitos dos desenhos e especificações:");
$pdf->SetXY(126, 173);
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(131, 173);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(141, 173);
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(147, 173);
$pdf->MultiCell(10,5,"Não");
$pdf->SetXY(160, 173);
$pdf->MultiCell(40,5,"( Se 'NÃO' - explicar abaixo)");
//linha 15
$pdf->SetXY(6,178);
$pdf->MultiCell(70,5,"Molde / Criatividade / Processo de Produção:");
$pdf->SetXY(60,178);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(70,183,166,183);
//linha 16
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,184);
$pdf->MultiCell(50,5,"DECLARAÇÃO");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,189);
$pdf->MultiCell(195,5,"Declaro que as amostras representadas por este certificado são representativas das nossas peças, que foram fabricadas conforme os requisitos aplicáveis do Manual do Processo de Aprovação de Peça de Produção, 3a. edição. Além disso, certifico que estas amostras foram produzidas a uma taxa de produção de $resp[taxa]/ 8 horas. Eu anotei abaixo qualquer desvio desta declaração.");
$pdf->SetXY(6,204);
$pdf->MultiCell(40,5,"EXPLICAÇÕES / COMENTÁRIOS ");
$pdf->SetXY(50,204);
$pdf->MultiCell(140,5,$resp["coments"]);
$pdf->Line(50,209,196,209);
//linha 17
$pdf->SetXY(6,210);
$pdf->MultiCell(25,5,"Nome Legível");
$pdf->SetXY(30,210);
$pdf->MultiCell(40,5,$resp["quem"]);
$pdf->Line(30,215,70,215);
$pdf->SetXY(71,210);
$pdf->MultiCell(15,5,"Cargo");
$pdf->SetXY(86,210);
$pdf->MultiCell(30,5,$rescli2["cargonome"]);
$pdf->Line(86,215,116,215);
$pdf->SetXY(117,210);
$pdf->MultiCell(20,5,"Telefone");
$pdf->SetXY(135,210);
$pdf->MultiCell(30,5,$rescli["fone"]);
$pdf->Line(135,215,165,215);
$pdf->SetXY(166,210);
$pdf->MultiCell(7,5,"Fax");
$pdf->SetXY(172,210);
$pdf->MultiCell(30,5,$rescli["fax"]);
$pdf->Line(172,215,200,215);
//linha 18
$pdf->SetXY(6,216);
$pdf->MultiCell(55,5,"Assinatura Autorizada do Fornecedor");
$pdf->SetXY(55,216);
$pdf->MultiCell(100,5,"");
$pdf->Line(55,221,150,221);
$pdf->SetXY(152,216);
$pdf->MultiCell(10,5,"Data");
$pdf->SetXY(162,216);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,221,197,221);
//linha 19
$pdf->Line(5,225,205,225);
//linha 20
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,228);
$pdf->MultiCell(200,5,"PARA USO SOMENTE DO CLIENTE ( SE APLICÁVEL )",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,232);
$pdf->MultiCell(50,5,"Disposição de Certificação da Peça:");
$pdf->SetXY(50,232);
if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(56,232);
$pdf->MultiCell(20,5,"Aprovada");
$pdf->SetXY(70,232);
if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(75,232);
$pdf->MultiCell(20,5,"Rejeitada");
$pdf->SetXY(115,232);
$pdf->MultiCell(45,5,"Aprovação Funcional da Peça:");
$pdf->SetXY(160,232);
if($resp["aprofunc"]=="2"){ $msg3="X"; }else{ $msg3=" "; }
$pdf->MultiCell(5,5,$msg3,1);
$pdf->SetXY(165,232);
$pdf->MultiCell(20,5,"Aprovada");
$pdf->SetXY(180,232);
if($resp["aprofunc"]=="3"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->MultiCell(5,5,$msg4,1);
$pdf->SetXY(185,232);
$pdf->MultiCell(20,5,"Derrogada");
//linha 21
$pdf->SetXY(50,238);
if($resp["disp"]=="4"){ $msg5="X"; }else{ $msg5=" "; }
$pdf->MultiCell(5,5,$msg5,1);
$pdf->SetXY(56,238);
$pdf->MultiCell(100,5,"Outra - $resp[disp_pq]");
//linha 22
$pdf->SetXY(6,243);
$pdf->MultiCell(30,5,"Nome do Cliente");
$pdf->SetXY(36,243);
$pdf->MultiCell(40,5,"");
$pdf->Line(30,248,86,248);
$pdf->SetXY(90,243);
$pdf->MultiCell(30,5,"Assinatura do Cliente");
$pdf->SetXY(116,243);
$pdf->MultiCell(40,5,"");
$pdf->Line(116,248,156,248);
$pdf->SetXY(160,243);
$pdf->MultiCell(15,5,"Data:");
$pdf->SetXY(171,243);
$pdf->MultiCell(30,5,"");
$pdf->Line(171,248,198,248);
//linha 23
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,258);
$pdf->MultiCell(20,5,"Julho 1999");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,258);
$pdf->MultiCell(25,5,"CFG-1001");
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(45,258);
$pdf->MultiCell(100,5,"A cópia original deste documento deve permanecer nas instalações do fornecedor enquanto a peça estiver ativada ");
$pdf->SetXY(150,258);
$pdf->MultiCell(50,5,"Opcional: Número de Rastreamento do Cliente: $res[desenhoi]");
//fim
if(empty($tira)){
$pdf->Output('apqp_sub_imp.pdf','I');
}
?>
