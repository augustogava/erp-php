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
	$pdf->Cell(65);
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 10, 'Certificado de Presentación de Piezas');
$pdf->SetFont('Arial','',7);
//linha 1
$pdf->SetXY(5, 10);
$pdf->MultiCell(200,245,"",1);
$pdf->SetXY(6, 11);
$pdf->MultiCell(30,5,"Nombre de la Pieza:");
$pdf->SetXY(30, 11);
$pdf->MultiCell(80,5,$res["nome"]);
$pdf->Line(30,16,104,16);
$pdf->SetXY(107, 11);
$pdf->MultiCell(35,5,"Número de la Pieza (Cliente):");
$pdf->SetXY(142, 11);
$pdf->MultiCell(70,5,$res["pecacli"]);
$pdf->Line(142,16,200,16);
// linha 2
$pdf->SetXY(6, 16);
$pdf->MultiCell(40,5,"Mostrado en Plano No.");
$pdf->SetXY(32, 16);
$pdf->MultiCell(80,5,$res["desenhoc"]);
$pdf->Line(32,21,104,21);
$pdf->SetXY(107, 16);
$pdf->MultiCell(45,5,"Número de la Pieza (Organización):");
$pdf->SetXY(147, 16);
$pdf->MultiCell(70,5,"$numero"); // buscar do banco
$pdf->Line(147,21,200,21);
// linha 3
$pdf->SetXY(6, 21);
$pdf->MultiCell(60,5,"Nivel de Revision de los Planos de Ingenieria:");
$pdf->SetXY(58, 21);
$pdf->MultiCell(25,5,$res["niveleng"]);
$pdf->Line(58,26,104,26);
$pdf->SetXY(120, 21);
$pdf->MultiCell(20,5,"Fecha:");
$pdf->SetXY(130, 21);
$pdf->MultiCell(30,5,banco2data($res["dteng"])); // buscar do banco
$pdf->Line(130,26,200,26);
//linha 4
$pdf->SetXY(6, 26);
$pdf->MultiCell(50,5,"Revisiones Adicionales de Ingeniería:");
$pdf->SetXY(50, 26);
$pdf->MultiCell(90,5,$res["alteng"]);
$pdf->Line(50,31,104,31);
$pdf->SetXY(120, 26);
$pdf->MultiCell(10,5,"Fecha:");
$pdf->SetXY(130, 26);
$pdf->MultiCell(30,5,banco2data($res["dtalteng"]));
$pdf->Line(130,31,200,31);
//linha 5
$pdf->SetXY(6, 31);
$pdf->MultiCell(60,5,"Regulación de Seguridad y/o Gubernamental:");

if($res["isrg"]=="S"){ $msg="X"; }else{ $msg=" "; }
$pdf->SetXY(62,32);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(72.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(77,31);
$pdf->MultiCell(10,5,"Si");

if($res["isrg"]=="N"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(87,32);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(87.3,32);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(92,31);
$pdf->MultiCell(10,5,"No");

$pdf->SetXY(104, 31);
$pdf->MultiCell(30,5,"Orden de Compra No.");
$pdf->SetXY(130, 31);
$pdf->MultiCell(40,5,$res["ncompra"]);
$pdf->Line(130,36,153,36);
$pdf->SetXY(154, 31);
$pdf->MultiCell(20,5,"Peso(KG):");
$pdf->SetXY(170, 31);
$pdf->MultiCell(30,5,$res["peso"]);
$pdf->Line(170,36,200,36); 
//linha 6
$pdf->SetXY(6, 36);
$pdf->MultiCell(35,5,"Ayuda de Comprabación Nº");
$pdf->SetXY(36, 36);
$pdf->MultiCell(30,5,$res["aux_num"]);
$pdf->Line(36,41,70,41);
$pdf->SetXY(77, 36);
$pdf->MultiCell(50,5,"Nivel de Revisión de Ingeniería:");
$pdf->SetXY(117, 36);
$pdf->MultiCell(35,5,$res["aux_nivel"]);
$pdf->Line(117,41,153,41);
$pdf->SetXY(160, 36);
$pdf->MultiCell(10,5,"Fecha:");
$pdf->SetXY(170, 36);
$pdf->MultiCell(30,5,banco2data($res["aux_data"]));
$pdf->Line(170,41,200,41);
//linha 7
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 45);
$pdf->MultiCell(94,5,"INFORMACIÓN DE FABRICACIÓN DEL ORGANIZACIÓN",0,'');
$pdf->SetXY(105, 45);
$pdf->MultiCell(94,5,"INFORMACIÓN DE ENVIO AL CLIENTE",0,'');
//linha 7
	//coluna 1
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(6, 50);
	$pdf->MultiCell(94,5,"$rese[razao] \n Nombre del surtidor y código del surtidor/vendedor",0);
	$pdf->Line(6,55,100,55);
	$pdf->SetXY(6, 60);
	$pdf->MultiCell(94,5,"$rese[endereco] \n Calle Dirección",0);
	$pdf->Line(6,65,100,65);
	$pdf->SetXY(6, 70);
	$pdf->MultiCell(94,5,"$rese[cidade] / $rese[estado] / $rese[cep] / $rese[pais]\n Ciudad   /   Región   /   Código Postal  /  Estado",0);
	$pdf->Line(6,75,100,75);
	//coluna 2
	$pdf->Line(106,55,200,55);
	$pdf->SetXY(106, 50);
	$pdf->MultiCell(40,5,"$res[nomecli] \n Nombre del división/cliente:",0);
	$pdf->Line(106,65,200,65);	
	$pdf->SetXY(106, 60);
	$pdf->MultiCell(60,5,"$res[comprador] \n Comprador/Código Del Comprador:",0);
	$pdf->Line(106,75,200,75);
	$pdf->SetXY(106, 70);
	$pdf->MultiCell(20,5,"$res[aplicacao] \n Uso:",0);

//linha 8
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 80);
$pdf->MultiCell(94,5,"DIVULGACIÓN DE LOS MATERIALES",0,'');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6, 85);
$pdf->MultiCell(120,5,"¿Las sustancias requeridas cliente de la información de la preocupación se han divulgado?",0,'');
if($resp["rela1"]=="2"){ $msg="X"; }else{ $msg=" "; }
if($resp["rela1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["rela1"]=="0"){ $msg2="X"; }else{ $msg2=" "; }

$pdf->SetXY(109.3,85);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,84.5);
$pdf->MultiCell(10,5,"Si");

$pdf->SetXY(124.3,85);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(128,84.5);
$pdf->MultiCell(10,5,"No");

$pdf->SetXY(135.3,85);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(135.5,85);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(139,84.5);
$pdf->MultiCell(10,5,"n/a");

$pdf->SetXY(45, 90);
$pdf->MultiCell(80,5,"Sometido por el IMDS o el otro formato del cliente:",0,'');
$pdf->SetXY(106, 90);
$pdf->MultiCell(94,5,$resp["imds"],0,'');
$pdf->Line(106,95,200,95);
$pdf->Line(106,100,200,100);
$pdf->SetXY(6, 100);
$pdf->MultiCell(105,5,"¿Las piezas poliméricas se identifican con códigos apropiados de la marca de la ISO?",0,'');

if($resp["rela2"]=="2"){ $msg="X"; }else{ $msg=" "; } 
$pdf->SetXY(109.3,101);
$pdf->MultiCell(3,3,$msg,'C');
$pdf->SetXY(109.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(113,100.5);
$pdf->MultiCell(10,5,"Si");

if($resp["rela2"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(124.3,101);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(124.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(129,101);
$pdf->MultiCell(10,5,"No");

if($resp["rela2"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(135.3,101);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(135.5,101);
$pdf->MultiCell(3,3," ",1,'C');
$pdf->SetXY(139,100.5);
$pdf->MultiCell(10,5,"n/a");

//linha 9
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6, 106);
$pdf->MultiCell(100,5,"RAZON PARA EL ENVIO",0);
//linha 11
$pdf->SetFont('Arial','',7);
	//coluna 1
	if($resp["razao"]=="1"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,111);
	$pdf->MultiCell(3,3," ",1,'C');
	$pdf->SetXY(12,110);
	$pdf->MultiCell(116,5,"Envio Inicial");

	if($resp["razao"]=="2"){ $msg="X"; }else{ $msg=" "; } 
	$pdf->SetXY(6.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,114);
	$pdf->MultiCell(100,5,"Revisión(es) de Ingenieria");

	if($resp["razao"]=="3"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,118);
	$pdf->MultiCell(100,5,"Utillaje: Transferencia, Sustitución, Restauración, o adicional");

	if($resp["razao"]=="4"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,122);
	$pdf->MultiCell(100,5,"Corrección de una Discrepancia");

	if($resp["razao"]=="5"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(6.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(7,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(12,126);
	$pdf->MultiCell(100,5,"Utillaje Inactivo por un periodo superior a 1 año");    
	
	//coluna 2
	if($resp["razao"]=="7"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,111.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,111);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,110);
	$pdf->MultiCell(100,5,"Cambio en Materiales o Sistemas Constructivos Opcionales");

	if($resp["razao"]=="8"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,115.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,115);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,114);
	$pdf->MultiCell(100,5,"Cambio en un Sub-Suministrador o Procedencia de Material");

	if($resp["razao"]=="9"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,119.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,119);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,118);
	$pdf->MultiCell(100,5,"Cambio en el Proceso de la Pieza");

	if($resp["razao"]=="10"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,123.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,123);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,122);
	$pdf->MultiCell(100,5,"Piezas Producidas en Instalaciones Adicionales");

	if($resp["razao"]=="6"){ $msg="X"; }else{ $msg=" "; }
	$pdf->SetXY(106.8,127.3);
	$pdf->MultiCell(3,3,$msg,'C');
	$pdf->SetXY(107,127);
	$pdf->MultiCell(3,3," ",1);
	$pdf->SetXY(112,126);
	$pdf->MultiCell(100,5,"Otro - especifique por favor abajo");
	$pdf->SetXY(105,131);
	$pdf->MultiCell(50,5,$resp["razao_esp"]);
	$pdf->Line(107,135,162,135);

//linha 12 
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,135);
$pdf->MultiCell(150,5,"NIVEL DE PRESENTACIÓN REQUERIDO");
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
$pdf->MultiCell(200,5,"Nível 1 - Sólo se envia al cliente el Certificado (y para los elementos designados como de Apariencia, un informe de Aprobación de Apariencia).");

$pdf->SetXY(6.8,144.3);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(7,144);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,143);
$pdf->MultiCell(200,5,"Nível 2 - Se envia al cliente el Certificado junto con muestras de producto y algunos datos de respaldo.");

$pdf->SetXY(6.8,148.3);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(7,148);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,147);
$pdf->MultiCell(200,5,"Nível 3 - Se envia al cliente el Certificado junto con muestras de producto y todos datos de respaldo.");

$pdf->SetXY(6.8,152.3);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(7,152);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,151);
$pdf->MultiCell(200,5,"Nível 4 - Se ebvua ak cliente el Cert. y los otros req. definidos por el cliente.");

$pdf->SetFont('Arial','',7);
$pdf->SetXY(6.8,156.3);
$pdf->MultiCell(3,3,$msg5,'C');
$pdf->SetXY(7,156);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(12,155);
$pdf->MultiCell(200,5,"Nível 5 - Tanto el certificado, como las muestras de las piezas, y todos los datos de respaldo son revisados en la planta del suministrador.");	
//linha 13
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,161);
$pdf->MultiCell(50,5,"RESULTADOS DEL ENVIO");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,167);
$pdf->MultiCell(30,5,"Los resultados para");
if($resp["res1"]=="1"){ $msg1="X"; }else{ $msg1=" "; }
if($resp["res2"]=="1"){ $msg2="X"; }else{ $msg2=" "; }
if($resp["res3"]=="1"){ $msg3="X"; }else{ $msg3=" "; }
if($resp["res4"]=="1"){ $msg4="X"; }else{ $msg4=" "; }
$pdf->SetXY(33,167);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(33.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(38,167);
$pdf->MultiCell(50,5,"medidas dimensionais");
$pdf->SetXY(71,167);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(71.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(76,167);
$pdf->MultiCell(50,5,"pruebas funcionales y de material");
$pdf->SetXY(116,167);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(116.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(121,167);
$pdf->MultiCell(50,5,"criterios de apariencia");
$pdf->SetXY(150,167);
$pdf->MultiCell(3,3,$msg4,'C');
$pdf->SetXY(150.3,167);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(155,167);
$pdf->MultiCell(50,5,"datos estadísticos de proceso");
//linha 14
$pdf->SetXY(6,173);
$pdf->MultiCell(100,5,"Estos resultados cumplen con todos los planos y requisitos especificados:");
if($resp["atende"]=="S"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(95, 173.1);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(95.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(100, 173);
$pdf->MultiCell(10,5,"Si");
if($resp["atende"]=="N"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(110, 173.1);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(110.3, 173);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(115, 173);
$pdf->MultiCell(10,5,"No");
$pdf->SetXY(135, 173);
$pdf->MultiCell(90,5,"(Si la respuesta es 'NO' - se requiera una explicación)");
//linha 15
$pdf->SetXY(6,178);
$pdf->MultiCell(70,5,"Molde / Cavidad / Proceso de producción:");
$pdf->SetXY(52,178);
$pdf->MultiCell(70,5,$resp["atende_pq"]);
$pdf->Line(52,183,117,183);
//linha 16
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,184);
$pdf->MultiCell(50,5,"DECLARACION");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,189);
$pdf->MultiCell(195,3,"Afirmo que las muestras representadas por este garantiá son representante el nuestros parte, que fueron hechas por un proceso que resuelve todos los requisitos de la edición del manual del proceso de la aprobación de la pieza de la producción 4tos.  Afirmo más lejos que estas muestras fueron producidas en el índice de la producción de $resp[taxa] / $resp[horas] horas.  También el certity I que documentó evidencia de tal conformidad está en archivo y disponible para la revisión.  He observado cualquier desviación de este declaración abajo."); 
$pdf->SetXY(6,200);
$pdf->MultiCell(40,5,"EXPLICACIÓN / COMENTARIOS:");
$pdf->SetXY(46,200);
$pdf->MultiCell(152,5,$resp["coments"]);
$pdf->Line(46,205,200,205);
$pdf->Line(46,210,200,210);
// linha 17
$pdf->SetXY(6,210);
$pdf->MultiCell(100,5,"¿Cada herramienta del cliente se marca con etiqueta y se numera correctamente?");
if($resp["ferram"]=="1"){ $msg1="X"; }else{ $msg1=" "; } 
$pdf->SetXY(100, 211);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(100.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(105, 210);
$pdf->MultiCell(10,5,"Si");
if($resp["ferram"]=="0"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(120, 211);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(120.3, 211);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(125, 210);
$pdf->MultiCell(10,5,"No");
//linha 18
$pdf->SetXY(6,215);
$pdf->MultiCell(55,5,"Firma Autorizada del Organización");
$pdf->SetXY(55,215);
if($resp["assi_for"]=="D"){
	//Assinatura - - 
	$end="assinaturas/".$resf["assinatura"].".png";
	$pdf->Image($end,60,200,'',30);
}else if($resp["assi_for"]=="E"){
	$pdf->SetXY(55,215);
	$pdf->MultiCell(100,5,"*Documento electrónico emitido. Firma no necesaria*");
	$pdf->SetXY(50,218.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(47,220,150,220);
$pdf->SetXY(152,215);
$pdf->MultiCell(10,5,"Fecha");
$pdf->SetXY(162,215);
$pdf->MultiCell(35,5,banco2data($resp["dtquem"]));
$pdf->Line(162,220,200,220);

$pdf->SetXY(6,220);
$pdf->MultiCell(25,5,"Nome Completo");
$pdf->SetXY(30,220);
$pdf->MultiCell(55,5,$resp["quem"]);
$pdf->Line(25,225,85,225);
$pdf->SetXY(90,220);
$pdf->MultiCell(20,5,"Teléfono");
$pdf->SetXY(105,220);
$pdf->MultiCell(30,5,$rescli["tel"]);
$pdf->Line(105,225,145,225);
$pdf->SetXY(150,220);
$pdf->MultiCell(20,5,"Fax");
$pdf->SetXY(162,220);
$pdf->MultiCell(30,5,$rescli["fax"]);
$pdf->Line(162,225,200,225); 
//linha 18
$pdf->SetXY(6,225);
$pdf->MultiCell(20,5,"Posición");
$pdf->SetXY(18,225);
$pdf->MultiCell(30,5,$resf["nome"]);
$pdf->Line(18,230,85,230);
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
$pdf->MultiCell(200,5,"PARA USO ÚNICO DEL CLIENTE (SI ES APLICABLE)",0,'C');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,238);
$pdf->MultiCell(50,5,"Disposición del Certificado de Piezas");

if($resp["disp"]=="2"){ $msg1="X"; }else{ $msg1=" "; }
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3,$msg1,'C');
$pdf->SetXY(50,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(55,238);
$pdf->MultiCell(20,5,"Aprobado");

if($resp["disp"]=="3"){ $msg2="X"; }else{ $msg2=" "; }
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3,$msg2,'C');
$pdf->SetXY(70,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(75,238);
$pdf->MultiCell(20,5,"Rechazado");

if($resp["disp"]=="4"){ $msg3="X"; }else{ $msg3=" "; }
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3,$msg3,'C');
$pdf->SetXY(90,238);
$pdf->MultiCell(3,3," ",1);
$pdf->SetXY(95,238);
$pdf->MultiCell(20,5,"Otro");
$pdf->SetXY(105,238);
$pdf->MultiCell(20,5,"$resp[disp_pq]");
$pdf->Line(105,243,200,243);

//linha 22
$pdf->SetXY(6,243);
$pdf->MultiCell(30,5,"Firma del Cliente");
//assinatura
if($resp["assi_cli"]=="E"){
	$pdf->SetXY(29,243);
	$pdf->MultiCell(124,5,"*Documento electrónico emitido. Firma no necesaria*");
	$pdf->SetXY(30,246.5);
	$pdf->SetFont('Arial','B',6);
}
$pdf->SetFont('Arial','',7);
$pdf->Line(29,248,156,248);
$pdf->SetXY(160,243);
$pdf->MultiCell(15,5,"Fecha:");
$pdf->SetXY(171,243);
$pdf->MultiCell(30,5,banco2data($resp["aprocli_dt"]));
$pdf->Line(171,248,200,248);

// linha 22
$pdf->SetXY(6,248);
$pdf->MultiCell(30,5,"Nome Completo");
$pdf->SetXY(25,248);
$pdf->MultiCell(64,5,"$res[nomecli]");
$pdf->Line(25,253,86,253);

$pdf->SetXY(87,248);
$pdf->MultiCell(64,5,"Número de seguimiento del Cliente (opcional)");
$pdf->SetXY(139,248);
$pdf->MultiCell(65,5,"$res[desenhoi]");
$pdf->Line(139,253,200,253);
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
