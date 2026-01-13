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
$pdf->Image('imagens/logo_chrysler.jpg',5,5,25,5);
$pdf->Image('imagens/logo_ford.jpg',40,2,20,5);
$pdf->Image('imagens/logo_gm.jpg',75,1,7,7);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80);
$pdf->Cell(0, 10, 'Certificado de Presentación de Piezas');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(26,5,"Nombre de la Pieza:");
$pdf->SetXY(30, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(30,16,106,16);
$pdf->SetXY(110, 11);
$pdf->MultiCell(30,5,"Número de la Pieza:");
$pdf->SetXY(135, 11);
$pdf->MultiCell(80,5,$res["pecacli"]);
$pdf->Line(135,16,200,16);
//linha 2
$pdf->SetXY(6, 17);
$pdf->MultiCell(40,5,"Regulación de Seguridad y/o Gubernamental:");
$pdf->SetXY(47, 19);
if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; }
$pdf->MultiCell(5,5,$msg,1,'C');
$pdf->SetXY(52, 19);
$pdf->MultiCell(10,5,"Si");
$pdf->SetXY(62, 19);
if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->MultiCell(5,5,$msg1,1,'C');
$pdf->SetXY(67, 19);
$pdf->MultiCell(10,5,"No");
$pdf->SetXY(77, 17);
$pdf->MultiCell(50,5,"Nivel de Revision de los Planos de Ingenieria:");
$pdf->SetXY(132, 17);
$pdf->MultiCell(35,5,$res["niveleng"]);
$pdf->Line(130,22,165,22);
$pdf->SetXY(165, 17);
$pdf->MultiCell(10,5,"Fecha:");
$pdf->SetXY(175, 17);
$pdf->MultiCell(25,5,banco2data($res["dteng"]));
$pdf->Line(175,22,200,22);
//linha 3
$pdf->SetXY(6, 27);
$pdf->MultiCell(50,5,"Revisiones Adicionales de Ingeniería:");
$pdf->SetXY(50, 27);
$pdf->MultiCell(90,5,$res["alteng"]);
$pdf->Line(50,32,146,32);
$pdf->SetXY(160, 27);
$pdf->MultiCell(10,5,"Fecha:");
$pdf->SetXY(170, 27);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(170,32,200,32);
//linha 4
$pdf->SetXY(6, 33);
$pdf->MultiCell(35,5,"Mostrado en Plano No.");
$pdf->SetXY(36, 33);
$pdf->MultiCell(30,5,$res["desenhoc"]);
$pdf->Line(36,38,81,38);
$pdf->SetXY(85, 33);
$pdf->MultiCell(30,5,"Orden de Compra No.");
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
$pdf->MultiCell(35,5,"Ayuda de Comprabación Nº");
$pdf->SetXY(36, 39);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(36,44,76,44);
$pdf->SetXY(77, 39);
$pdf->MultiCell(40,5,"Nivel de Revisión de Ingeniería ");
$pdf->SetXY(117, 39);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(117,44,150,44);
$pdf->SetXY(160, 39);
$pdf->MultiCell(10,5,"Fecha:");
$pdf->SetXY(170, 39);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,44,200,44);
//linha 6
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 45);
$pdf->MultiCell(94,5,"INFORMACIÓN DE FABRICACIÓN DEL SUBMINISTRADOR ",0,'C');
$pdf->SetXY(105, 45);
$pdf->MultiCell(94,5,"INFORMACIÓN DE ENVIO",0,'C');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 50);
	$pdf->MultiCell(94,5,"$rese[razao] \n Nombre del Subministrador / Código del Subministrador",0);
	$pdf->Line(6,55,100,55);
	$pdf->SetXY(6, 60);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Calle Dirección",0);
	$pdf->Line(6,65,100,65);
	$pdf->SetXY(6, 70);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep] \n Ciudade / Provincia / Código Postal",0);
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
	$pdf->MultiCell(40,5,"Materiales/Funcional ");
	$pdf->SetXY(165, 50);
	$pdf->MultiCell(5,5,$msg3,1);
	$pdf->SetXY(170, 50);
	$pdf->MultiCell(30,5,"Apariencia");
	$pdf->SetXY(106, 60);
	$pdf->MultiCell(40,5,"Nombre Cliente / División:",0);
	$pdf->SetXY(140, 60);
	$pdf->MultiCell(70,5,$res["nomecli"],0);
	$pdf->Line(140,65,200,65);
	$pdf->SetXY(106, 65);
	$pdf->MultiCell(60,5,"Comprador/Código Comprador:",0);
	$pdf->SetXY(150, 65);
	$pdf->MultiCell(50,5,$res["comprador"],0);
	$pdf->Line(150,70,200,70);
	$pdf->SetXY(106, 70);
	$pdf->MultiCell(20,5,"Aplicación:",0);
	$pdf->SetXY(120, 70);
	$pdf->MultiCell(80,5,$res["aplicacao"],0);
	$pdf->Line(120,75,200,75);
//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(10,5,"Nota",0,'C');

$pdf->SetXY(30, 80);
$pdf->MultiCell(100,5,"Contiene esta pieza cualquir substancia restringida o de la que se debe informar? ",0);
$pdf->SetXY(140, 80);
if($resp["nota1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nota1"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(145, 80);
$pdf->MultiCell(10,5,"Si");
$pdf->SetXY(155, 80);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(160, 80);
$pdf->MultiCell(10,5,"No");
//linha 9
$pdf->SetXY(30, 86);
$pdf->MultiCell(110,5,"Están las piezas de plástico identificadas con los códigos de marcación ISO apropriados?",0);
$pdf->SetXY(140, 86);
if($resp["nota2"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nota2"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(145, 86);
$pdf->MultiCell(10,5,"Si");
$pdf->SetXY(155, 86);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(160, 86);
$pdf->MultiCell(10,5,"No");
//linha 10
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 90);
$pdf->MultiCell(100,5,"RAZON PARA EL ENVIO",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	$pdf->SetXY(6,95);
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,95);
	$pdf->MultiCell(100,5,"Envio Inicial");
	$pdf->SetXY(6,101);
	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,101);
	$pdf->MultiCell(100,5,"Revisión(es) de Ingenieria");
	$pdf->SetXY(6,107);
	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,107);
	$pdf->MultiCell(100,5,"Utillaje: Transferencia, Sustitución, Restauración, o adicional ");
	$pdf->SetXY(6,113);
	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,113);
	$pdf->MultiCell(100,5,"Corrección de una Discrepancia ");
	$pdf->SetXY(6,119);
	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(12,119);
	$pdf->MultiCell(100,5,"Utillaje Inactivo por un periodo superior a 1 año");
	//coluna 2
	$pdf->SetXY(106,95);
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,95);
	$pdf->MultiCell(100,5,"Cambio en Materiales o Sistemas Constructivos Opcionales ");
	$pdf->SetXY(106,101);
	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,101);
	$pdf->MultiCell(100,5,"Cambio en un Sub-Suministrador o Procedencia de Material  ");
	$pdf->SetXY(106,107);
	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,107);
	$pdf->MultiCell(100,5,"Cambio en el Proceso de la Pieza ");
	$pdf->SetXY(106,113);
	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,113);
	$pdf->MultiCell(100,5,"Piezas Producidas en Instalaciones Adicionales ");
	$pdf->SetXY(106,119);
	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->MultiCell(5,5,$msg,1);
	$pdf->SetXY(112,119);
	$pdf->MultiCell(100,5,"Outros - Por favor especifique:");
	$pdf->SetXY(142,119);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
//linha 12
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,125);
$pdf->MultiCell(70,5,"NIVEL DE PRESENTACIÓN REQUERIDO (Marque uno)");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,131);
if($resp["nivel"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["nivel"]=="2"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["nivel"]=="3"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["nivel"]=="4"){ $msg4="X"; }else{ $msg4=" "; }
if($resp["nivel"]=="5"){ $msg5="X"; }else{ $msg5=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(12,131);
$pdf->MultiCell(200,5,"Nível 1 - Sólo se envia al cliente el Certificado (y para los elementos designados como de Apariencia, un informe de Aprobación de Apariencia) ");
$pdf->SetXY(6,137);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(12,137);
$pdf->MultiCell(200,5,"Nível 2 - Se envia al cliente el Certificado junto con muestras de producto y algunos datos de respaldo");
$pdf->SetXY(6,143);
$pdf->MultiCell(5,5,$msg3,1);
$pdf->SetXY(12,143);
$pdf->MultiCell(200,5,"Nível 3 - Se envia al cliente el Certificado junto con muestras de producto y todos datos de respaldo");
$pdf->SetXY(6,149);
$pdf->MultiCell(5,5,$msg4,1);
$pdf->SetXY(12,149);
$pdf->MultiCell(200,5,"Nível 4 - Se ebvua ak cliente el Cert. y los otros req. definidos por el cliente");
//nivel 4 contagem
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
//
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,155);
$pdf->MultiCell(5,5,$msg5,1);
$pdf->SetXY(12,155);
$pdf->MultiCell(200,5,"Nível 5 - Tanto el certificado, como las muestras de las piezas, y todos los datos de respaldo son revisados en la planta del suministrador ");
//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,161);
$pdf->MultiCell(50,5,"RESULTADOS DEL ENVIO");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(30,5,"Los resultados para ");
$pdf->SetXY(33,167);
if($resp["res1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["res2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["res3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["res4"]=="1"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(41,167);
$pdf->MultiCell(30,5,"medidas dimensionais");
$pdf->SetXY(71,167);
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(76,167);
$pdf->MultiCell(40,5,"pruebas funcionales y de material");
$pdf->SetXY(116,167);
$pdf->MultiCell(5,5,$msg3,1);
$pdf->SetXY(121,167);
$pdf->MultiCell(30,5,"criterios de apariencia");
$pdf->SetXY(150,167);
$pdf->MultiCell(5,5,$msg4,1);
$pdf->SetXY(155,167);
$pdf->MultiCell(40,5,"datos estadísticos de proceso ");
//linha 14
$pdf->SetXY(6,173);
$pdf->MultiCell(100,5,"Estos resultados cumplen con todos los planos y requisitos especificados:");
$pdf->SetXY(126, 173);
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(131, 173);
$pdf->MultiCell(10,5,"Si");
$pdf->SetXY(141, 173);
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(147, 173);
$pdf->MultiCell(10,5,"No");
$pdf->SetXY(160, 173);
$pdf->MultiCell(40,5,"( Si la respuesta es 'NO' - se requiera una explicación)");
//linha 15
$pdf->SetXY(6,178);
$pdf->MultiCell(70,5,"Molde / Cavidad / Proceso de producción:");
$pdf->SetXY(60,178);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(70,183,166,183);
//linha 16
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,184);
$pdf->MultiCell(50,5,"DECLARACION");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,189);
$pdf->MultiCell(195,5,"Afirmo que las muestras representadas en este Certificado son representativas de nuestras piezas y han sido fabricadas de acuerdo con los requisitos aplicables del Manual Proceso de Aprobación Tercera Edición. Además, certifico que estas muestras fueron producidas a la velocidad de producción de /8 horas. A continuación indico todas las desciaciones de esta declaracion.");
$pdf->SetXY(6,204);
$pdf->MultiCell(40,5,"EXPLICACIÓN/COMENTARIOS: ");
$pdf->SetXY(50,204);
$pdf->MultiCell(140,5,$resp["coments"]);
$pdf->Line(50,209,196,209);
//linha 17
$pdf->SetXY(6,210);
$pdf->MultiCell(25,5,"Nome Completo");
$pdf->SetXY(30,210);
$pdf->MultiCell(40,5,$resp["quem"]);
$pdf->Line(30,215,70,215);
$pdf->SetXY(71,210);
$pdf->MultiCell(15,5,"Puesto");
$pdf->SetXY(86,210);
$pdf->MultiCell(30,5,$rescli2["cargonome"]);
$pdf->Line(86,215,116,215);
$pdf->SetXY(117,210);
$pdf->MultiCell(20,5,"Teléfono");
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
$pdf->MultiCell(55,5,"Firma Autorizada del Suministrador");
$pdf->SetXY(55,216);
if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,55,200,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(55,216);
	$pdf->MultiCell(60,5,$resp["quem"]);
	$pdf->SetXY(60,221);
	$pdf->SetFont('Arial','B',6);
	$pdf->MultiCell(100,5,"*Documento emetido Eletronicamente Dispensando Assinatura*");
}
// FIM - - - - -
$pdf->SetFont('Arial','B',7);
$pdf->Line(55,221,150,221);
$pdf->SetXY(152,216);
$pdf->MultiCell(10,5,"Fecha");
$pdf->SetXY(162,216);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,221,197,221);
//linha 19
$pdf->Line(5,225,205,225);
//linha 20
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,228);
$pdf->MultiCell(200,5,"PARA USO ÚNICO DEL CLIENTE (SI ES APLICABLE)",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,232);
$pdf->MultiCell(50,5,"Disposición del Certificado de Piezas:");
$pdf->SetXY(50,232);
if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->MultiCell(5,5,$msg1,1);
$pdf->SetXY(56,232);
$pdf->MultiCell(20,5,"Aprobado");
$pdf->SetXY(70,232);
if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->MultiCell(5,5,$msg2,1);
$pdf->SetXY(75,232);
$pdf->MultiCell(20,5,"Rechazado");
$pdf->SetXY(115,232);
$pdf->MultiCell(45,5,"Aprobación Funcional de Pieza:");
$pdf->SetXY(160,232);
if($resp["aprofunc"]=="2"){ $msg3="X"; }else{ $msg3=" "; }
$pdf->MultiCell(5,5,$msg3,1);
$pdf->SetXY(165,232);
$pdf->MultiCell(20,5,"Aprobada");
$pdf->SetXY(180,232);
if($resp["aprofunc"]=="3"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->MultiCell(5,5,$msg4,1);
$pdf->SetXY(185,232);
$pdf->MultiCell(20,5,"Dispensada");
//linha 21
$pdf->SetXY(50,238);
if($resp["disp"]=="4"){ $msg5="X"; }else{ $msg5=" "; }
$pdf->MultiCell(5,5,$msg5,1);
$pdf->SetXY(56,238);
$pdf->MultiCell(100,5,"Outra - $resp[disp_pq]");
//linha 22
$pdf->SetXY(6,243);
$pdf->MultiCell(30,5,"Nombre del Cliente");
$pdf->SetXY(36,243);
$pdf->MultiCell(40,5,"$res[nomecli]");
$pdf->Line(30,248,86,248);
$pdf->SetXY(90,243);
$pdf->MultiCell(30,5,"Firma del Cliente");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(116,243);
	$pdf->MultiCell(40,5,"$res[nomecli]");
	$pdf->SetXY(60,250);
	$pdf->SetFont('Arial','B',6);
	$pdf->MultiCell(100,5,"*Documento emetido Eletronicamente Dispensando Assinatura*");
}
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(116,243);
$pdf->Line(116,248,156,248);
$pdf->SetXY(160,243);
$pdf->MultiCell(15,5,"Fecha:");
$pdf->SetXY(171,243);
$pdf->MultiCell(30,5,banco2data($resp["aprocli_dt"]));
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
$pdf->MultiCell(100,5,"La copia original de este documento deberá permanecer en las instalaciones del suministrador mientras la pieza esté activa(ver Glosario) ");
$pdf->SetXY(150,258);
$pdf->MultiCell(50,5,"Opcional: Número de seguimiento del Cliente: $res[desenhoi]");

// desenvolvedor
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(168,269);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
	
//fim
?>
