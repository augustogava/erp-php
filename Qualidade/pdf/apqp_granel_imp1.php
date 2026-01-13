<?php
include('../conecta.php');
require('fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(35);
$pdf->Cell(0, 18, 'Lista de Verificação de Material a Granel ');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(120,5,"Cliente \n alguma coisa",1);
$pdf->SetXY(125, 18);
$pdf->MultiCell(80,5,"Nome da Peça \n alguma coisa",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(80,5,"Fornecedor \n alguma coisa",1);
$pdf->SetXY(85, 28);
$pdf->MultiCell(60,5,"Rev. / Data do Desenho \n alguma coisa",1);
$pdf->SetXY(145, 28);
$pdf->MultiCell(60,5,"Número/Rev. Peça (fornecedor) \n alguma coisa",1);
//linha 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 40);
$pdf->MultiCell(70,10,"",1);
$pdf->SetXY(75, 40);
$pdf->MultiCell(15,10,"Prazo",1,'C');
$pdf->SetXY(90, 40);
$pdf->MultiCell(40,5,"Responsabilidade Principal",1,'C');
$pdf->SetXY(90, 45);
$pdf->MultiCell(20,5,"Cliente",1,'C');
$pdf->SetXY(110, 45);
$pdf->MultiCell(20,5,"Fornecedor",1,'C');
$pdf->SetXY(130, 40);
$pdf->MultiCell(40,10,"Comentários",1,'C');
$pdf->SetXY(170, 40);
$pdf->MultiCell(35,10,"Aprovado por / Data",1,'C');
//linha 4
$pdf->SetXY(5, 50);
$pdf->MultiCell(200,5,"Verificação de Projeto e Desenvolvimento do Produto",1);
//linha 5
$plano[0]="Matriz de Projeto";
$plano[1]="FMEA de Projeto"; 
$plano[2]="Características Especiais do Produto";
$plano[3]="Registros de Projeto";
$plano[4]="Plano de Controle do Projeto";
$plano[5]="Relatório de Aprovação de Aparência";
$plano[6]="Amostra Padrão";
$plano[7]="Resultados dos Ensaios";
$plano[8]="Resultados Dimensionais";
$plano[9]="Auxílios para Verificação";
$plano[10]="Aprovação da Engenharia";
	$y=0;
	for($x=55;$x<=105;$x=$x+5){
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $x);
		$pdf->MultiCell(70,5,"$plano[$y]",1);
		$pdf->SetXY(75, $x);
		$pdf->MultiCell(15,5,"",1,'C');
		$pdf->SetXY(90, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(110, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(130, $x);
		$pdf->MultiCell(40,5,"",1,'C');
		$pdf->SetXY(170, $x);
		$pdf->MultiCell(35,5,"",1,'C');
		$y++;
	}
//linha6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 110);
$pdf->MultiCell(200,5,"Verificação de Projeto e Desenvolvimento do Produto",1);
$pdf->SetFont('Arial','',8);
//linha 7
$plano[0]="Fluxograma do Processo";
$plano[1]="FMEA de Processo"; 
$plano[2]="Características Especiais do Processo";
$plano[3]="Plano de Controle de Pré-Lançamento";
$plano[4]="Plano de Controle de Produção";
$plano[5]="Estudos do Sistema de Medição";
$plano[6]="Aprovação Interina";
	$y=0;
	for($x=115;$x<=145;$x=$x+5){
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $x);
		$pdf->MultiCell(70,5,"$plano[$y]",1);
		$pdf->SetXY(75, $x);
		$pdf->MultiCell(15,5,"",1,'C');
		$pdf->SetXY(90, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(110, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(130, $x);
		$pdf->MultiCell(40,5,"",1,'C');
		$pdf->SetXY(170, $x);
		$pdf->MultiCell(35,5,"",1,'C');
		$y++;
	}
//linha 8
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 150);
$pdf->MultiCell(200,5,"Validação do Produto e do Processo",1);
$pdf->SetFont('Arial','',8);
//linha 9
$plano[0]="Estudos Iniciais do Processo";
$plano[1]="Certificado de Submissão da Peça (CFG-1001)"; 
	$y=0;
	for($x=155;$x<=165;$x=$x+5){
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $x);
		$pdf->MultiCell(70,5,"$plano[$y]",1);
		$pdf->SetXY(75, $x);
		$pdf->MultiCell(15,5,"",1,'C');
		$pdf->SetXY(90, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(110, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(130, $x);
		$pdf->MultiCell(40,5,"",1,'C');
		$pdf->SetXY(170, $x);
		$pdf->MultiCell(35,5,"",1,'C');
		$y++;
	}
//linha 10
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 150);
$pdf->MultiCell(200,5,"Validação do Produto e do Processo",1);
$pdf->SetFont('Arial','',8);
//linha 11
$plano[0]="Estudos Iniciais do Processo";
$plano[1]="Certificado de Submissão da Peça (CFG-1001)"; 
	$y=0;
	for($x=155;$x<=165;$x=$x+5){
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $x);
		$pdf->MultiCell(70,5,"$plano[$y]",1);
		$pdf->SetXY(75, $x);
		$pdf->MultiCell(15,5,"",1,'C');
		$pdf->SetXY(90, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(110, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(130, $x);
		$pdf->MultiCell(40,5,"",1,'C');
		$pdf->SetXY(170, $x);
		$pdf->MultiCell(35,5,"",1,'C');
		$y++;
	}
//linha 12
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 170);
$pdf->MultiCell(200,5,"Elementos a serem completados se necessário",1);
$pdf->SetFont('Arial','',8);
//linha 13
$plano[0]="Contato na Empresa Cliente";
$plano[1]="Mudar Documentação";
$plano[2]="Considerações do Subcontratante";
	$y=0;
	for($x=175;$x<=190;$x=$x+5){
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $x);
		$pdf->MultiCell(70,5,"$plano[$y]",1);
		$pdf->SetXY(75, $x);
		$pdf->MultiCell(15,5,"",1,'C');
		$pdf->SetXY(90, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(110, $x);
		$pdf->MultiCell(20,5,"",1,'C');
		$pdf->SetXY(130, $x);
		$pdf->MultiCell(40,5,"",1,'C');
		$pdf->SetXY(170, $x);
		$pdf->MultiCell(35,5,"",1,'C');
		$y++;
	}
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
	
//fim
$pdf->Output('Teste.pdf','I');
?>
