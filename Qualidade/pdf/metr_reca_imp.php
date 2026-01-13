<?php
include("../conecta.php");
require('fpdf.php');

$hj=date("Y-m-d"); 
function fdias($datafim,$data){
			$dif = (strtotime($datafim)-strtotime($data))/86400;
			return $dif;
}
function fdias2($datafim,$data){
			$dif = (strtotime($data)-strtotime($datafim))/86400;
			$ex=substr($dif,0,2);
			return $ex;
}

$pdf=new FPDF('L');  // nova função pdf dinâmica em retrato
$pdf->AddPage();  // funçao adiciona uma página

$pdf->SetFont('Arial','B',13);   // (fonte,tipo,tamanho)
$pdf->SetXY(5,2); // posiciona os próximos comandos, entre eles multicell 
//$pdf->MultiCell(287,179,"",1);  // dimensão da página em retrato
$pdf->Image('logo.png',6,1,17,15); // imagem ('endereço', x, y, weight, hight)

    // Título
	$pdf->SetXY(5,5);
	$pdf->MultiCell(287,7,"FICHA DE RE-CALIBRAÇÃO",0,"C");
	$pg=$pdf->PageNo();   // nº da página 

	
// 1ª linha ////////////////////////////////////////////////////////
$pdf->SetFont ('Arial','B',11);

$pdf->SetXY(43,16);  
$pdf->MultiCell(30,5,"Calibrado em ");  // caixa de texto sem borda com 30 caracteres e 5 de altura
$pdf->SetXY(70,16);
$pdf->MultiCell(30,5,"01/01/0001");

$pdf->SetXY(120,16);
$pdf->MultiCell(10,5,"OS:");
$pdf->SetXY(130,16);
$pdf->MultiCell(20,5,"01/0001");

$pdf->SetXY(175,16);
$pdf->MultiCell(33,5,"CERTIFICADO:");
$pdf->SetXY(208,16);
$pdf->MultiCell(50,5,"testetestetestetesteteste");


 		// data do dia no canto direito
		$datahj=banco2data($hj);    // banco2data tabela 3
		$pdf->SetFont('Arial','B',7);  
		$pdf->SetXY(267,8);
		$pdf->MultiCell(20,5,"$datahj",0,"R");
		
		// desenvolvedor
		$pdf->SetFont('Arial','B',5);  
		$pdf->SetXY(250,182);
		$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");



 
// 2ª linha  ////////////////////////////////////////////////////////
//$sql2=mysql_query("SELECT * FROM cadb_repr WHERE repr_id='$repr'");
//$res2=mysql_fetch_array($sql2);

$pdf->SetXY(5,22);
$pdf->MultiCell(285,20,"",1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,22);
$pdf->MultiCell(20,5,"Cliente:");
$pdf->SetXY(26,22);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(200,5,"NOMENOMENOMENOMENOMENOMENOMENOME");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(110,22);
$pdf->MultiCell(20,5,"Endereço:");
$pdf->SetXY(137,22);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(200,5,"NOMENOMENOMENOMENOME");




$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,27);
$pdf->MultiCell(20,5,"Instrumento:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(26,27);
$pdf->MultiCell(140,5,"NOMENOMENOMENOMENOMENOMENOMENOMENOMENOMENOMENOMENOME");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(155,27);
$pdf->MultiCell(20,5,"CÓD.:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(165,27);
$pdf->MultiCell(25,5,"CODCODCOD");

//$pdf->Line(5,32,205,32);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,32);
$pdf->MultiCell(20,5,"Solicitante:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(26,32);
$pdf->MultiCell(45,5,"NOMENOMENOMENOMENOME");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(97,32);
$pdf->MultiCell(20,5,"DEPT.:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(112,32);
$pdf->MultiCell(32,5,"NOMENOMENOMENO");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(170,32);
$pdf->MultiCell(25,5,"Temperatura ºC:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(195,32);
$pdf->MultiCell(15,5,"XX,XX");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(230,32);
$pdf->MultiCell(20,5,"Umidade %:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(250,32);
$pdf->MultiCell(15,5,"XX,XX");

//$pdf->Line(5,37,205,42);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,37);
$pdf->MultiCell(15,5,"Setor:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(26,37);
$pdf->MultiCell(10,5,"NC");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(56,37);
$pdf->MultiCell(15,5,"Usuário:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(73,37);
$pdf->MultiCell(10,5,"NC");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(107,37);
$pdf->MultiCell(13,5,"Marca:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(120,37);
$pdf->MultiCell(10,5,"NC");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(150,37);
$pdf->MultiCell(15,5,"Modelo:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(165,37);
$pdf->MultiCell(25,5,"M4.5x0.75-6H");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(215,37);
$pdf->MultiCell(15,5,"Nº Série:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(230,37);
$pdf->MultiCell(10,5,"NC");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(260,37);
$pdf->MultiCell(10,5,"Freq.:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(270,37);
$pdf->MultiCell(20,5,"XXXXX");

//$pdf->Line(5,47,205,47);
$pdf->SetXY(5,47);
$pdf->MultiCell(285,25,"",1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,47);
$pdf->MultiCell(25,5,"Procedimento:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(28,47);
$pdf->MultiCell(100,5,"XXXXX");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(146,47);
$pdf->MultiCell(15,5,"Revisão:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(161,47);
$pdf->MultiCell(10,5,"XX");

//$pdf->Line(5,52,205,52);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,52);
$pdf->MultiCell(287,5,"Síntese de Procedimento de Calibração:",0,"C");

//$pdf->Line(5,57,205,57);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(7,57);
$pdf->MultiCell(283,5,"síntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesíntesesínt");

//$pdf->Line(5,77,205,77);
$pdf->SetXY(5,77);
$pdf->MultiCell(285,15,"",1);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,77);
$pdf->MultiCell(15,5,"Padrões:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(21,77);
$pdf->MultiCell(10,5,"XX");

//$pdf->Line(5,82,205,82);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,82);
$pdf->MultiCell(20,5,"Condições:");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(41,82);
$pdf->MultiCell(15,5,"Novo");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(56,82);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(66,82);
$pdf->MultiCell(10,5,"Não");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(101,82);
$pdf->MultiCell(25,5,"Sujo Externo");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(126,82);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(136,82);
$pdf->MultiCell(10,5,"Não");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(171,82);
$pdf->MultiCell(25,5,"Sujo Interno");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(201,82);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(211,82);
$pdf->MultiCell(10,5,"Não");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(241,82);
$pdf->MultiCell(20,5,"Danificado");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(261,82);
$pdf->MultiCell(10,5,"Sim");
$pdf->SetXY(271,82);
$pdf->MultiCell(10,5,"Não");

//$pdf->Line(5,87,205,87);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,87);
$pdf->MultiCell(40,5,"FILETES COM REBARBAS.");

//$pdf->Line(5,97,205,97);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(5,97);
$pdf->MultiCell(287,5,"Passa",0,"C");


//$pdf->Line(5,102,205,102);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,102);
$pdf->MultiCell(20,5,"Capacidade:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(25,102);
$pdf->MultiCell(30,5,"4,011 à 4,011");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(65,102);
$pdf->MultiCell(25,5,"Faixa de uso:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(90,102);
$pdf->MultiCell(30,5,"4,011 à 4,011");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(135,102);
$pdf->MultiCell(20,5,"Unidade:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(155,102);
$pdf->MultiCell(15,5,"mm");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180,102);
$pdf->MultiCell(15,5,"Tipo:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(195,102);
$pdf->MultiCell(25,5,"Analógico");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(230,102);
$pdf->MultiCell(20,5,"Estimativa:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(250,102);
$pdf->MultiCell(10,5,"2");

//$pdf->Line(5,107,205,107);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,107);
$pdf->MultiCell(20,5,"FT. Conv. SI:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(26,107);
$pdf->MultiCell(40,5,"XXXXXXXXX");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(65,107);
$pdf->MultiCell(15,5,"Fixa:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(80,107);
$pdf->MultiCell(20,5,"Leitura");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(105,107);
$pdf->MultiCell(20,5,"Referência:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(125,107);
$pdf->MultiCell(10,5,"Não");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(140,107);
$pdf->MultiCell(23,5,"Pré-Calibração:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(163,107);
$pdf->MultiCell(10,5,"Não");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(178,107);
$pdf->MultiCell(20,5,"Cálculo %:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(198,107);
$pdf->MultiCell(10,5,"Não");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(213,107);
$pdf->MultiCell(15,5,"Valor:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(228,107);
$pdf->MultiCell(10,5,"N");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(243,107);
$pdf->MultiCell(15,5,"Técnico:");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(258,107);
$pdf->MultiCell(15,5,"Aprovado");


$pdf->Output('apqp_sub_imp.pdf','I');
?>