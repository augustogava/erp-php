<?php
if(empty($tira)){
	include('../../conecta.php');
	require('fpdf.php');
}
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_apro WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

if(empty($tira)){
	$pdf=new FPDF('L');
}
$pdf->AddPage();
$pdf->Image('../../imagens/logo_ford.jpg',5,1,25);
$pdf->Image('../../imagens/logo_gm.jpg',45,1,10);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70);
$pdf->Cell(0, 18, 'RELATÓRIO DE APROVAÇÃO DE APARÊNCIA');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 18);
$pdf->MultiCell(60,5,"Cliente \n $res[nomecli]",1);
$pdf->SetXY(65, 18);
$pdf->MultiCell(70,5,"Número da Peça (cliente) \n $res[pecacli]",1);
$pdf->SetXY(135, 18);
$pdf->MultiCell(60,5,"Número do Desenho \n $res[desenhoc]",1);
$pdf->SetXY(195, 18);
$pdf->MultiCell(95,5,"Aplicação (Veículos) \n $res[aplicacao]",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(75,5,"Nome Da Peça \n $res[nome]",1);
$pdf->SetXY(80, 28);
$pdf->MultiCell(75,5,"Código Comprador \n $resp[comprador]",1);
$pdf->SetXY(155, 28);
$pdf->MultiCell(105,5,"Nível da Engenharia \n $res[niveleng]",1);
$pdf->SetXY(260, 28);
$pdf->MultiCell(30,5,"Data \n ".banco2data($res["dteng"])."",1);
//linha3
$pdf->SetXY(5, 38);
$pdf->MultiCell(100,5,"Fornecedor \n a$rese[razao]",1);
$pdf->SetXY(105, 38);
$pdf->MultiCell(50,5,"Número/Rev. Peça (fornecedor) \n  $res[numero] - $res[rev]",1);
$pdf->SetXY(155,38);
$pdf->MultiCell(105,5,"Localidade da Fabricação \n $resp[local]",1);
$pdf->SetXY(260, 38);
$pdf->MultiCell(30,5,"Cód. do Fornecedor \n $resp[seilaquecodigoehesse]",1);
//linha4
	//coluna 1
	$pdf->SetXY(5, 48);
	$pdf->MultiCell(180,20,"",1);
	//linha 4-1-1
		$pdf->SetXY(5, 48);
		$pdf->MultiCell(40,5,"Razão Para Submissão");
		$pdf->SetXY(45, 49);
		if($resp["razao1"]=="1"){ $show="X"; }else{ $show=" "; }
		$pdf->MultiCell(5,5,"$show",1,'C');
		$pdf->SetXY(50, 48);
		$pdf->MultiCell(40,5,"Certificado de Submissão da Peça");
		$pdf->SetXY(90, 49);
		if($resp["razao1"]=="2"){ $show="X"; }else{ $show=" "; }
		$pdf->MultiCell(5,5,"$show",1,'C');
		$pdf->SetXY(95, 48);
		$pdf->MultiCell(40,5,"Amostra especial");
		$pdf->SetXY(135, 49);
		if($resp["razao2"]=="3"){ $show="X"; }else{ $show=" "; }
		$pdf->MultiCell(5,5,"$show",1,'C');
		$pdf->SetXY(140, 48);
		$pdf->MultiCell(40,5,"Re-submissão");
	//linha 4-1-2
		$pdf->SetXY(45, 59);
		if($resp["razao2"]=="4"){ $show="X"; }else{ $show=" "; }
		$pdf->MultiCell(5,5,"$show",1,'C');
		$pdf->SetXY(50, 58);
		$pdf->MultiCell(40,5,"Pré-Textura");
		$pdf->SetXY(90, 59);
		if($resp["razao2"]=="1"){ $show="X"; }else{ $show=" "; }
		$pdf->MultiCell(5,5,"$show",1,'C');
		$pdf->SetXY(95, 58);
		$pdf->MultiCell(40,5,"Embarque da Primeira Produção");
		$pdf->SetXY(135, 59);
		if($resp["razao2"]=="2"){ $show="X"; }else{ $show=" "; }
		$pdf->MultiCell(5,5,"$show",1,'C');
		$pdf->SetXY(140, 58);
		$pdf->MultiCell(55,5,"Alteração de Engenharia");
	//coluna 2
	$pdf->SetXY(185, 48);
	$pdf->MultiCell(105,20,"",1);
	//linha 4-2-1
		$pdf->SetXY(185, 48);
		$pdf->MultiCell(40,5,"0utro");
	//linha 4-2-2
		$pdf->SetXY(185, 58);
		$pdf->MultiCell(40,5,"");
//linha 5 
	$pdf->SetXY(5, 70);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(285,5,"Avaliação de Aparência",1,'C');
	$pdf->SetXY(5, 75);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(185,5,"Informações Do Sub-Fornecedor E Textura",1,'C');
	$pdf->SetXY(5, 80);
	$pdf->MultiCell(185,30,"$resp[aval]",1);
	//tabela direta
	$pdf->SetXY(190, 75);
	$pdf->MultiCell(40,10,"Avaliação da Pre-Textura",1,'C');
	$pdf->SetXY(230, 75);
	$pdf->MultiCell(60,5,"Assinatura e data do Representante \n do Cliente ",1,'C');
	$pdf->SetXY(190, 85);
	$pdf->MultiCell(40,10,"Corrigir e Prosseguir",1,'C');
	$pdf->SetXY(230, 85);
	$pdf->MultiCell(60,10," ",1,'C');
	$pdf->SetXY(190, 95);
	$pdf->MultiCell(40,10,"Corrigir e Re-submeter",1,'C');
	$pdf->SetXY(230, 95);
	$pdf->MultiCell(60,10,"",1,'C');
	$pdf->SetXY(190, 105);
	$pdf->MultiCell(40,5,"Aprovar Textura",1,'C');
	$pdf->SetXY(230, 105);
	$pdf->MultiCell(60,5,"",1,'C');
//linha 6
	//linha 1
	$pdf->SetXY(5, 112);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(15,5,"Sufixo de \n Cor",1,'C');
	$pdf->SetXY(20, 112);
	$pdf->MultiCell(35,10,"Dados colorimétricos",1,'C');
	$pdf->SetXY(55, 112);
	$pdf->MultiCell(15,5,"Nº do \n\n Padrão",1,'C');
	$pdf->SetXY(70, 112);
	$pdf->MultiCell(20,5,"Data do \n\nPadrão",1,'C');
	$pdf->SetXY(90, 112);
	$pdf->MultiCell(25,15,"Tipo de Material",1,'C');
	$pdf->SetXY(115, 112);
	$pdf->MultiCell(30,15,"Fonte do Material",1,'C');
	$pdf->SetXY(145, 112);
	$pdf->MultiCell(35,10,"Tonalidade",1,'C');
	$pdf->SetXY(180, 112);
	$pdf->MultiCell(20,10,"Valor",1,'C');
	$pdf->SetXY(200, 112);
	$pdf->MultiCell(20,10,"Croma",1,'C');
	$pdf->SetXY(220, 112);
	$pdf->MultiCell(20,10,"Brilho",1,'C');
	$pdf->SetXY(240, 112);
	$pdf->MultiCell(20,5,"Brilho \n Metálico",1,'C');
	$pdf->SetXY(260, 112);
	$pdf->MultiCell(15,5,"Sufixo \n da Cor de Ent.",1,'C');
	$pdf->SetXY(275, 112);
	$pdf->MultiCell(15,5,"Disposição \n da Peça",1,'C');
	//linha 2
	$pdf->SetXY(20, 122);
	$pdf->SetFont('Arial','',7);
	$pdf->MultiCell(6,5,"DL",1,'C');
	$pdf->SetXY(26, 122);
	$pdf->MultiCell(6,5,"Da",1,'C');
	$pdf->SetXY(32, 122);
	$pdf->MultiCell(7,5,"Db",1,'C');
	$pdf->SetXY(39, 122);
	$pdf->MultiCell(7,5,"De",1,'C');
	$pdf->SetXY(46, 122);
	$pdf->MultiCell(9,5,"CMC",1,'C');
	$pdf->SetXY(145, 122);
	$pdf->MultiCell(10,5,"Verm",1,'C');
	$pdf->SetXY(155, 122);
	$pdf->MultiCell(8,5,"Ama",1,'C');
	$pdf->SetXY(163, 122);
	$pdf->MultiCell(8,5,"Vde",1,'C');
	$pdf->SetXY(171, 122);
	$pdf->MultiCell(9,5,"Azul",1,'C');
	$pdf->SetXY(180, 122);
	$pdf->MultiCell(10,5,"Claro",1,'C');
	$pdf->SetXY(190, 122);
	$pdf->MultiCell(10,5,"Escuro",1,'C');
	$pdf->SetXY(200, 122);
	$pdf->MultiCell(10,5,"Cinza",1,'C');
	$pdf->SetXY(210, 122);
	$pdf->MultiCell(10,5,"_impc",1,'C');
	$pdf->SetXY(220, 122);
	$pdf->MultiCell(10,5,"Alto",1,'C');
	$pdf->SetXY(230, 122);
	$pdf->MultiCell(10,5,"Baixo",1,'C');
	$pdf->SetXY(240, 122);
	$pdf->MultiCell(10,5,"Alto",1,'C');
	$pdf->SetXY(250, 122);
	$pdf->MultiCell(10,5,"Baixo",1,'C');
//linha 7
$sql=mysql_query("SELECT * FROM apqp_aprol,apqp_apro WHERE apqp_apro.peca='$pc' AND apqp_aprol.apro=apqp_apro.id");
if(mysql_num_rows($sql)){
	$y=127;
	while($res=mysql_fetch_array($sql)){
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(15,5,"$res[suf]",1);
		$pdf->SetXY(20, $y);
		$pdf->MultiCell(6,5,"$res[dl]",1);
		$pdf->SetXY(26, $y);
		$pdf->MultiCell(6,5,"$res[da]",1);
		$pdf->SetXY(32, $y);
		$pdf->MultiCell(7,5,"$res[db]",1);
		$pdf->SetXY(39, $y);
		$pdf->MultiCell(7,5,"$res[de]",1);
		$pdf->SetXY(46, $y);
		$pdf->MultiCell(9,5,"$res[cmc]",1);
		$pdf->SetXY(55, $y);
		$pdf->MultiCell(15,5,"$res[num]",1,'C');
		$pdf->SetXY(70, $y);
		$pdf->MultiCell(20,5,"$res[data]",1,'C');
		$pdf->SetXY(90, $y);
		$pdf->MultiCell(25,5,"$res[tipo]",1,'C');
		$pdf->SetXY(115, $y);
		$pdf->MultiCell(30,5,"$res[fonte]",1,'C');
		$pdf->SetXY(145, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(155, $y);
		$pdf->MultiCell(8,5,"",1,'C');
		$pdf->SetXY(163, $y);
		$pdf->MultiCell(8,5,"",1,'C');
		$pdf->SetXY(171, $y);
		$pdf->MultiCell(9,5,"",1,'C');
		$pdf->SetXY(180, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(190, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(200, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(210, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(220, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(230, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(240, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(250, $y);
		$pdf->MultiCell(10,5,"",1,'C');
		$pdf->SetXY(260, $y);
		$pdf->MultiCell(15,5,"$res[ent]",1,'C');
		$pdf->SetXY(275, $y);
		$pdf->MultiCell(15,5,"",1,'C');
		$y=$y+5;
	}
}
//fim
if(empty($tira)){
$pdf->Output('apqo_apro.pdf','I');
}
?>
