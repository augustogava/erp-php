<?php
//include("../conecta.php");
//require('fpdf.php');

$sql=mysql_query("SELECT * FROM apqp_interina WHERE peca='$pc'");
//if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql2=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
$res2=mysql_fetch_array($sql2);
$sql3=mysql_query("SELECT * FROM clientes WHERE id='$res2[cliente]'");
$res3=mysql_fetch_array($sql3);
$sql4=mysql_query("SELECT * FROM empresa");
$res4=mysql_fetch_array($sql4);

$pdf->AddPage();  // funçao adiciona uma página

$pdf->SetFont('Arial','',7);   // (fonte,tipo,tamanho)


$pdf->SetXY(3,10); // posiciona os próximos comandos, entre eles multicell 
$pdf->MultiCell(200,230,"",1);  // desenha uma caixa (w,h,texto,borda,alinhamento texto), neste caso a borda lateral da página inteira
$pdf->Image('pdf/logo_feeder.jpg',4,11,7,7); // imagem ('endereço', x, y, w, h)
$pdf->Line(12,19,12,10);
$pdf->Line(3,19,203,19);
    // Título
	$pdf->SetFont('Arial','B',10);   
	$pdf->SetXY(15,12);
	$pdf->MultiCell(120,7,"FORMULÁRIO DE APROVAÇÃO INTERINA");
	
//1ª linha col 1//////////////////////////////////////////////////
$pdf->SetFont('Arial','',7);   
$pdf->SetXY(6,19);  
$pdf->MultiCell(30,5,"Nome do Fornecedor:");  // caixa de texto sem borda com 30 caracteres e 5 de altura
$pdf->SetXY(33,19);
$pdf->MultiCell(80,5,"$res3[nome]");
$pdf->Line(33,23,106,23);   // linha (x,y,x2,y2)

//1ª linha col 2//////////////////////////////////////////////////
$pdf->SetXY(108,19);
$pdf->MultiCell(30,5,"Nome da Peça:"); 
$pdf->SetXY(127,19);
$pdf->MultiCell(80,5,"$res2[nome]");
$pdf->Line(127,23,201,23); 

//2ª linha col 1//////////////////////////////////////////////////
$pdf->SetXY(6,24);
$pdf->MultiCell(30,5,"Código do Fornecedor:"); 
$pdf->SetXY(35,24);
$pdf->MultiCell(80,5,"$res3[id]");
$pdf->Line(35,28,106,28);

//2ª linha col 2//////////////////////////////////////////////////
$pdf->SetXY(108,24);
$pdf->MultiCell(30,5,"Número da Peça:"); 
$pdf->SetXY(130,24);
$pdf->MultiCell(80,5,"$res2[numero]");
$pdf->Line(130,28,201,28);

//3ª linha ///////////////////////////////////////////////////////
$datar=banco2data($res["reesubmissao"]);
$ate=banco2data($res["ate"]);
$data=banco2data($res["data"]);

$pdf->SetXY(6,29);
$pdf->MultiCell(30,5,"Data da Ressubmissão:"); 
$pdf->SetXY(35,29);
$pdf->MultiCell(80,5,"$datar");
$pdf->Line(35,33,106,33);

//4ª linha ////////////////////////////////////////////////////////
$pdf->SetXY(6,34);
$pdf->MultiCell(50,5,"Data de Expiração Interina:"); 
$pdf->SetXY(39,34);
$pdf->MultiCell(80,5,"$data");
$pdf->Line(39,38,106,38);

//5ª linha ////////////////////////////////////////////////////////
$pdf->SetXY(6,39);
$pdf->MultiCell(30,5,"Aplicação:"); 
$pdf->SetXY(20,39);
$pdf->MultiCell(80,5,"$res[aplicacao]");
$pdf->Line(20,43,106,43);

// tabela interna col 2 ////////////////////////////////////////////
$pdf->SetXY(108,31);
$pdf->MultiCell(93,16,"",1);
	// linha 4
	$pdf->SetXY(110,34);
	$pdf->MultiCell(30,5,"EWO#:");
	$pdf->SetXY(119.5,34);
	$pdf->MultiCell(80,5,"$res[ewo]");
	$pdf->Line(119.5,38,153,38);
    // linha 5
	$pdf->SetXY(110,39);
	$pdf->MultiCell(30,5,"ECL:");
	$pdf->SetXY(117,39);
	$pdf->MultiCell(80,5,"");
	$pdf->Line(117,43,153,43);
	
	$pdf->SetXY(155,39);
	$pdf->MultiCell(30,5,"Data:");
	$pdf->SetXY(163,39);
	$pdf->MultiCell(80,5,"$ate");
	$pdf->Line(163,43,189,43);

// linha 6 //////////////////////////////////////////////////////////
$pdf->SetFont('Arial','',6);

$pdf->SetXY(6,44);
$pdf->MultiCell(30,5,"Nível de Submissão:"); 
$pdf->SetXY(27,44);
$pdf->MultiCell(80,5,"");
$pdf->Line(27,48,50,48);
	
$pdf->SetXY(52,44);
$pdf->MultiCell(30,5,"Peso (Kg):"); 
$pdf->SetXY(64,44);
$pdf->MultiCell(80,5,"$res2[peso]");
$pdf->Line(64,48,87,48);	

// linha 7 //////////////////////////////////////////////////////////
$pdf->SetXY(6,49);
$pdf->MultiCell(30,5,"Número de Amostra:"); 
$pdf->SetXY(27,49);
$pdf->MultiCell(80,5,"$res[amo_numero]");
$pdf->Line(27,53,50,53);
	
$pdf->SetXY(52,49);
$pdf->MultiCell(30,5,"Insp/EQF:"); 
$pdf->SetXY(63,49);
$pdf->MultiCell(80,5,"$res[eqf]");
$pdf->Line(63,53,87,53);		

$pdf->SetXY(89,49);
$pdf->MultiCell(30,5,"Amostra Adicional:"); 
$pdf->SetXY(109,49);
$pdf->MultiCell(80,5,"$res[amo_adicionais]");
$pdf->Line(109,53,133,53);		

$pdf->SetXY(135,49);
$pdf->MultiCell(30,5,"PKG:"); 
$pdf->SetXY(142,49);
$pdf->MultiCell(80,5,"$res[pkg]");
$pdf->Line(142,53,166,53);		

$pdf->SetXY(168,49);
$pdf->MultiCell(30,5,"Interim #:"); 
$pdf->SetXY(179,49);
$pdf->MultiCell(80,5,"$res[ra]");
$pdf->Line(179,53,201,53);		

$pdf->Line(3,55,203,55);

// Classe Interina /////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,57);
$pdf->MultiCell(30,5,"Classe Interina:"); 
	// linha 1
	$classe=$res["classe"];
	if($classe=="a"){
		$pdf->Image('pdf/certo.jpg',82,58,2,2); // imagem ('endereço', x, y, w, h)
	}else if($classe=="b"){
		$pdf->Image('pdf/certo.jpg',109,58,2,2); // imagem ('endereço', x, y, w, h)
	}else if($classe=="c"){
		$pdf->Image('pdf/certo.jpg',136,58,2,2); // imagem ('endereço', x, y, w, h)
	}else if($classe=="d"){
		$pdf->Image('pdf/certo.jpg',163,58,2,2); // imagem ('endereço', x, y, w, h)
	}else if($classe=="e"){
		$pdf->Image('pdf/certo.jpg',190,58,2,2); // imagem ('endereço', x, y, w, h)
	}
	$pdf->SetFont('Arial','',5);
	$pdf->SetXY(30,57);
	$pdf->MultiCell(32,2,"(Datilografe Classe Interina ou Circule para preenchimento Manual)"); 
	
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(66,57);
		$pdf->MultiCell(27,5,"A",1,"C"); 

		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(93,57);
		$pdf->MultiCell(27,5,"B",1,"C"); 

		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(120,57);
		$pdf->MultiCell(27,5,"C",1,"C"); 

		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(147,57);
		$pdf->MultiCell(27,5,"D",1,"C"); 

		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(174,57);
		$pdf->MultiCell(27,5,"E",1,"C"); 

// linha 2
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,62);
$pdf->MultiCell(30,5,"Status:");
	
	$pdf->SetFont('Arial','',5);
	$pdf->SetXY(20,62);
	$pdf->MultiCell(200,5,"Datilografe ou complete com Status apropriado (A = Aprovado, I = Interim, N = Não realizado)");

// linha 3
$pdf->SetFont('Arial','',7);
$pdf->SetXY(25,67);
$pdf->MultiCell(15,5,"DIM:");
$pdf->SetXY(32,67);
$pdf->MultiCell(20,5,"$res[dim]");
$pdf->Line(32,71,52,71);

$pdf->SetXY(54,67);
$pdf->MultiCell(15,5,"APAR:");
$pdf->SetXY(63,67);
$pdf->MultiCell(20,5,"$res[apa]");
$pdf->Line(63,71,83,71);

$pdf->SetXY(85,67);
$pdf->MultiCell(15,5,"LAB:");
$pdf->SetXY(92,67);
$pdf->MultiCell(20,5,"$res[lab]");
$pdf->Line(92,71,112,71);

$pdf->SetXY(114,67);
$pdf->MultiCell(17,5,"PROCESSO:");
$pdf->SetXY(130,67);
$pdf->MultiCell(20,5,"$res[pro]");
$pdf->Line(130,71,150,71);

$pdf->SetXY(152,67);
$pdf->MultiCell(15,5,"ENG:");
$pdf->SetXY(160,67);
$pdf->MultiCell(20,5,"$res[eng]");
$pdf->Line(160,71,180,71);

$pdf->Line(3,73,203,73);

/// Resumo das Razões///////////////////////////////////////////////////
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,75);
$pdf->MultiCell(30,5,"Resumo das Razões:");

	//campo
	$pdf->SetFont('Arial','',6);
	$pdf->SetXY(6,80);
	$pdf->MultiCell(193,3,"$res[resumo]");

$pdf->Line(3,98,203,98);

/// Assuntos //////////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,100);
$pdf->MultiCell(30,5,"Assuntos:");

	$pdf->SetFont('Arial','',5);
	$pdf->SetXY(20,100);
	$pdf->MultiCell(50,2,"(relacione Dim, APP, LAB, FERRAMENTAL, CAPACIDADE, ou QUESTÕES DE LANÇAMENTO)");

$pdf->Line(100,98,100,107);
	
/// Planos de Ação /////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(100,100);
$pdf->MultiCell(30,5,"Plano de Ação:");

	$pdf->SetFont('Arial','',5);
	$pdf->SetXY(120,100);
	$pdf->MultiCell(30,5,"(Fornecer com prazos)");

/// TABELA /////////////////////////////////////////////////////
// LINHA 1 COLUNA 1
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(3,107);
$pdf->MultiCell(97,28,"",1);
	$pdf->SetFont('Arial','',6);
	$pdf->SetXY(6,111);
	$pdf->MultiCell(92,3,"$res[problemas1]");
		$pdf->SetFont('Arial','',5);
		$pdf->SetXY(6,106);
		$pdf->MultiCell(30,5,"Dimensional/Laboratório/Aparência:");


// LINHA 1 COLUNA 2
$pdf->SetFont('Arial','B',7);	
$pdf->SetXY(100,107);
$pdf->MultiCell(103,28,"",1);
	$pdf->SetFont('Arial','',6);
	$pdf->SetXY(100,111);
	$pdf->MultiCell(100,3,"$res[plano1]");

// LINHA 2 COLUNA 1
$pdf->SetFont('Arial','B',7);	
$pdf->SetXY(100,135);
$pdf->MultiCell(103,28,"",1);
	$pdf->SetFont('Arial','',5);
	$pdf->SetXY(6,134);
	$pdf->MultiCell(35,5,"Ferramenta/Capacidade/Lançamento:");
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(6,140);
		$pdf->MultiCell(92,3,"$res[problemas2]");
	
// LINHA 2 COLUNA 2
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(3,135);
$pdf->MultiCell(97,28,"",1);
	$pdf->SetFont('Arial','',6);
	$pdf->SetXY(100,140);
	$pdf->MultiCell(100,3,"$res[plano2]");

	
/// Estão os assuntos referentes ....//////////////////////////////////////////////
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,165);
$pdf->MultiCell(100,5,"Estão os assuntos referentes à Interina mencionados no Plano GP-12?:");

$pdf->SetFont('Arial','',5);
$pdf->SetXY(6,168);
$pdf->MultiCell(100,3,"(Por exemplo: RETRABALHO, OPERAÇÕES TEMPORÁRIAS) Por favor explique abaixo");

	//campo
	$pdf->SetFont('Arial','',6);
	$pdf->SetXY(6,174);
	$pdf->MultiCell(193,3,"$res[assunto]");

$pdf->Line(3,192,203,192);

/// Fornecedor (Assinatura Autorizada) //////////////////////////////////////////////
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,195);
$pdf->MultiCell(60,5,"Fornecedor (Assinatura Autorizada):");
$pdf->Line(47,199,135,199);
$pdf->SetXY(47,195);
$pdf->MultiCell(90,5,"");

$pdf->SetFont('Arial','',7);
$pdf->SetXY(137,195);
$pdf->MultiCell(30,5,"Telefone:");
$pdf->Line(149,199,200,199);
$pdf->SetXY(149,195);
$pdf->MultiCell(60,5,"$res[tel]");

$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,200);
$pdf->MultiCell(60,5,"Nome e Posição:");
$pdf->Line(26,204,135,204);
$pdf->SetXY(26,200);
$pdf->MultiCell(105,5,"$res[quem]");

$pdf->SetFont('Arial','',7);
$pdf->SetXY(142,200);
$pdf->MultiCell(30,5,"Fax:");
$pdf->Line(149,204,200,204);
$pdf->SetXY(149,200);
$pdf->MultiCell(60,5,"$res[fax]");

$pdf->Line(3,207,203,207);

/// Aprovação do Cliente //////////////////////////////////////////////

// 1ª linha
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(6,208);
$pdf->MultiCell(60,5,"APROVAÇÃO DO CLIENTE:");

$pdf->SetXY(75,208);
$pdf->MultiCell(60,5,"Assinatura");

$pdf->SetXY(123,208);
$pdf->MultiCell(60,5,"Nome (Forma)");

$pdf->SetXY(162,208);
$pdf->MultiCell(60,5,"Telefone");

$pdf->SetXY(187,208);
$pdf->MultiCell(60,5,"Data");

$data_eng=banco2data($res["data_eng"]);
$data_com=banco2data($res["data_com"]);
$data_engprod=banco2data($res["data_engprod"]);
$data_coor=banco2data($res["data_coor"]);
// 2ª LINHA
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,213);
$pdf->MultiCell(80,5,"Engenheiro de Qualidade do Fornecedor:");

$pdf->SetXY(58,213);
$pdf->MultiCell(60,5,"");
$pdf->Line(58,217,108,217);

$pdf->SetXY(110,213);
$pdf->MultiCell(60,5,"$res[apro_eng]");
$pdf->Line(110,217,155,217);

$pdf->SetXY(157,213);
$pdf->MultiCell(20,5,"");
$pdf->Line(157,217,181,217);

$pdf->SetXY(183,213);
$pdf->MultiCell(20,5,"$data_eng");
$pdf->Line(183,217,200,217);

// 3ª LINHA
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,218);
$pdf->MultiCell(80,5,"Engenheiro de Produto (DRE):");

$pdf->SetXY(58,218);
$pdf->MultiCell(60,5,"");
$pdf->Line(58,222,108,222);

$pdf->SetXY(110,218);
$pdf->MultiCell(60,5,"$res[apro_com]");
$pdf->Line(110,222,155,222);

$pdf->SetXY(157,218);
$pdf->MultiCell(20,5,"");
$pdf->Line(157,222,181,222);

$pdf->SetXY(183,218);
$pdf->MultiCell(20,5,"$data_com");
$pdf->Line(183,222,200,222);

// 4ª LINHA
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,223);
$pdf->MultiCell(80,5,"Engenheiro de Materiais/Lab:");

$pdf->SetXY(58,223);
$pdf->MultiCell(60,5,"");
$pdf->Line(58,227,108,227);

$pdf->SetXY(110,223);
$pdf->MultiCell(60,5,"$res[apro_engprod]");
$pdf->Line(110,227,155,227);

$pdf->SetXY(157,223);
$pdf->MultiCell(20,5,"");
$pdf->Line(157,227,181,227);

$pdf->SetXY(183,223);
$pdf->MultiCell(20,5,"$data_engprod");
$pdf->Line(183,227,200,227);

// 5ª LINHA
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,228);
$pdf->MultiCell(80,5,"Engenheiro de Aparência/Pintura:");

$pdf->SetXY(58,228);
$pdf->MultiCell(60,5,"");
$pdf->Line(58,232,108,232);

$pdf->SetXY(110,228);
$pdf->MultiCell(60,5,"$res[apro_coor]");
$pdf->Line(110,232,155,232);

$pdf->SetXY(157,228);
$pdf->MultiCell(20,5,"");
$pdf->Line(157,232,181,232);

$pdf->SetXY(183,228);
$pdf->MultiCell(20,5,"$data_coor");
$pdf->Line(183,232,200,232);

// 6ª LINHA
$pdf->SetFont('Arial','',7);
$pdf->SetXY(6,233);
$pdf->MultiCell(80,5,"Outros (Comprador, Unidade de Montagem):");

$pdf->SetXY(58,233);
$pdf->MultiCell(60,5,"");
$pdf->Line(58,237,108,237);

$pdf->SetXY(110,233);
$pdf->MultiCell(60,5,"");
$pdf->Line(110,237,155,237);

$pdf->SetXY(157,233);
$pdf->MultiCell(20,5,"");
$pdf->Line(157,237,181,237);

$pdf->SetXY(183,233);
$pdf->MultiCell(20,5,"");
$pdf->Line(183,237,200,237);

		// desenvolvedor
		$pdf->SetFont('Arial','B',5);  
		$pdf->SetXY(168,269);
		$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
		
//$pdf->Output('apqp_sub_imp.pdf','I');

?>
