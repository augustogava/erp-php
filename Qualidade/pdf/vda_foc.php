<?php
include("../conecta.php");
require('fpdf.php');
$hj=date("Y-m-d");
function fdias($datafim,$data){
			$dif = (strtotime($datafim)-strtotime($data))/86400;
			return $dif;
}
//TOPO
$pdf=new FPDF();  // nova função pdf dinâmica
$pdf->AddPage();  // funçao adiciona uma página

$pdf->SetFont('Arial','B',10);   // (fonte,tipo,tamanho)
$pdf->SetXY(5,1); // posiciona os próximos comandos, entre eles multicell 
$pdf->MultiCell(200,270,"",1);  // desenha uma caixa (w,h,texto,borda,alinhamento texto), neste caso a borda lateral da página inteira
$pdf->Image('logo.png',6,2,17,10); // imagem ('endereço', w1, h1, w2, h2)

//CABEÇALHO
    // Título
	$pdf->SetXY(5,5);
	$pdf->MultiCell(205,5,"VDA - FOLHA CAPA",0,"C");
		// número de página
	$pag=1;
	$pdf->SetFont('Arial','B',5);
	$pdf->SetXY(165,2);
	$pdf->MultiCell(35,7,"Página: $pag",0,"R");	
	// desenvolvedor fim da pagina
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
//CABEÇALHO FIM
	// 1ª linha
	$pdf->Line(5,13,205,13);
			// data do dia no canto direito
			$pdf->SetFont('Arial','B',10);  
			$datahj=banco2data($hj);    // banco2data tabela 3
			$pdf->SetFont('Arial','B',5);  
			$pdf->SetXY(180,8);
			$pdf->MultiCell(20,5,"$datahj",0,"R");
	// Remetente
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(9,15);
	$pdf->MultiCell(50,0,"Remetente",0,"L");
		//Linha Separando Remetente / Destinatario
		$pdf->SetLineWidth(0.7);
		$pdf->Line(10,45,100,45);
			//QUADRADOS
			$pdf->SetFont('Arial','B',7);
			$pdf->SetLineWidth(0.4);
			//////////////////////////
			$pdf->SetXY(120,15);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,15);
				$pdf->MultiCell(60,4,"Relatório de Inspeção de Amostra Inicial",0);
			//////////////////////////
			$pdf->SetXY(120,20);
			$pdf->MultiCell(4,4,"",1);
			$pdf->SetXY(125,20);
			$pdf->MultiCell(60,4,"Primeira Apresentação de Amostra",0);
			//////////////////////////
			$pdf->SetXY(120,25);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,25);
				$pdf->MultiCell(60,4,"Reapresentação de Amostra",0);
			//////////////////////////
			$pdf->SetXY(120,30);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,30);
				$pdf->MultiCell(60,4,"Peça Nova",0);
			//////////////////////////
			$pdf->SetXY(120,35);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,35);
				$pdf->MultiCell(60,4,"Produto Modificado",0);
			//////////////////////////
			$pdf->SetXY(120,40);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,40);
				$pdf->MultiCell(60,4,"Transferência de Produção",0);
			//////////////////////////
			$pdf->SetXY(120,45);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,45);
				$pdf->MultiCell(60,4,"Procedimentos de Produção Modificados",0);
			//////////////////////////
			$pdf->SetXY(120,50);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,50);
				$pdf->MultiCell(60,4,"Interrupção Prolongada de Produção",0);
			//////////////////////////
			$pdf->SetXY(120,55);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,55);
				$pdf->MultiCell(60,4,"Novo Subfornecedor",0);
			//////////////////////////
			$pdf->SetXY(120,60);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,60);
				$pdf->MultiCell(70,4,"Produto com Documento com aplicações Especiais",0);
			//////////////////////////
			$pdf->SetXY(120,65);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,65);
				$pdf->MultiCell(60,4,"Plano de Produção/Inspeção e Ensaio Preparado",0);
			//////////////////////////
			$pdf->SetXY(120,70);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,70);
				$pdf->MultiCell(60,4,"FMEA Realizadol",0);
			//////////////////////////
			$pdf->SetXY(120,75);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(125,75);
				$pdf->MultiCell(60,4,"Relatório de Inspeção de Outras Amostras",0);
			//QUADRADOS FIM
	// Destinatário
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(9,50);
	$pdf->MultiCell(50,0,"Destinaratio",0,"L");	
	
	//CAIXA ANEXOS
	$pdf->SetLineWidth(0.1);
	$pdf->SetXY(10,80);
	$pdf->MultiCell(190,35,"",1);
	$pdf->SetXY(10,80);
	$pdf->MultiCell(190,5,"Anexos",1,"C");
	
	$pdf->SetLineWidth(0.4);
	$pdf->SetFont('Arial','',7);
	//////////////////////////1 COLUNA
			$pdf->SetXY(15,87);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(20,87);
				$pdf->MultiCell(50,4,"01 Teste Funcional",0,"L");
	//////////////////////////1 COLUNA
			$pdf->SetXY(15,92);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(20,92);
				$pdf->MultiCell(50,4,"02 Teste Dimensional",0,"L");
	//////////////////////////1 COLUNA
			$pdf->SetXY(15,97);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(20,97);
				$pdf->MultiCell(50,4,"03 Teste de Materiais",0,"L");
	//////////////////////////1 COLUNA
			$pdf->SetXY(15,102);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(20,102);
				$pdf->MultiCell(50,4,"04 Teste de Confiabilidade",0,"L");
	//////////////////////////1 COLUNA
			$pdf->SetXY(15,107);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(20,107);
				$pdf->MultiCell(50,4,"05 Prova de Capabilidade do Processo",0,"L");
				
	//////////////////////////2 COLUNA
			$pdf->SetXY(70,87);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(75,87);
				$pdf->MultiCell(50,4,"06 Fluxograma do Processo",0,"L");
	//////////////////////////2 COLUNA
			$pdf->SetXY(70,92);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(75,92);
				$pdf->MultiCell(50,4,"07 Prova Capabilidade de Equip. de Teste",0,"L");
	//////////////////////////2 COLUNA
			$pdf->SetXY(70,97);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(75,97);
				$pdf->MultiCell(50,4,"08 Lista de Equip. Teste/Inspeção",0,"L");
	//////////////////////////2 COLUNA
			$pdf->SetXY(70,102);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(75,102);
				$pdf->MultiCell(50,4,"09 Folha de Dados de Segurança",0,"L");
	//////////////////////////2 COLUNA
			$pdf->SetXY(70,107);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(75,107);
				$pdf->MultiCell(50,4,"10 Rugosidade",0,"L");
				
				
	//////////////////////////3 COLUNA
			$pdf->SetXY(125,87);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(130,87);
				$pdf->MultiCell(50,4,"11 Acústica",0,"L");
	//////////////////////////3 COLUNA
			$pdf->SetXY(125,92);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(130,92);
				$pdf->MultiCell(50,4,"12 Odor",0,"L");
	//////////////////////////3 COLUNA
			$pdf->SetXY(125,97);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(130,97);
				$pdf->MultiCell(50,4,"13 Aparência",0,"L");
	//////////////////////////3 COLUNA
			$pdf->SetXY(125,102);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(130,102);
				$pdf->MultiCell(50,4,"14 Certificado",0,"L");
	//////////////////////////3 COLUNA
			$pdf->SetXY(125,107);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(130,107);
				$pdf->MultiCell(50,4,"15 Aprocação do Projeto",0,"L");
				
				
	//////////////////////////4 COLUNA
			$pdf->SetXY(160,87);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(165,87);
				$pdf->MultiCell(35,4,"16 Componentes de Peças Pedidas",0,"L");
	//////////////////////////4 COLUNA
			$pdf->SetXY(160,97);
			$pdf->MultiCell(4,4,"",1);
				$pdf->SetXY(165,97);
				$pdf->MultiCell(50,4,"17 Outros",0,"L");
				
				
		//CAIXA Identificação Fornecedor
		$pdf->SetFont('Arial','B',7);
		$pdf->SetLineWidth(0.1);
		$pdf->SetXY(10,120);
		$pdf->MultiCell(95,62,"",1);
		$pdf->SetXY(10,120);
		$pdf->MultiCell(95,5,"Nº de Identificação, Fornecedor:",1,"L");
		$pdf->SetXY(10,125);
		$pdf->MultiCell(95,5,"Nº Relatório Inspeçao:",1,"L");
		$pdf->SetXY(70,125);
		$pdf->MultiCell(95,5,"Revisão:",0,"L");
			//////////////////CONTEUDO
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY(10,132);
			$pdf->MultiCell(95,5,"Nº da Peça:",0,"L");
			$pdf->SetXY(10,137);
			$pdf->MultiCell(95,5,"Nº de Desenho:",0,"L");
			$pdf->SetXY(10,142);
			$pdf->MultiCell(95,5,"Status/Data de Engenharia:",0,"L");
			$pdf->SetXY(10,147);
			$pdf->MultiCell(95,5,"Nº Revisão",0,"L");
			$pdf->SetXY(10,152);
			$pdf->MultiCell(95,5,"Descrição:",0,"L");
			$pdf->SetXY(10,157);
			$pdf->MultiCell(95,5,"nº / Data de Pedido:",0,"L");
		//CAIXA Identificação Fornecedor
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(10,162);
		$pdf->MultiCell(95,5,"Nº / Data de Nota Fiscal:",1,"L");
			//////////////////CONTEUDO
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY(10,167);
			$pdf->MultiCell(95,5,"Quantidade Entregue:",0,"L");	
			$pdf->SetXY(10,172);
			$pdf->MultiCell(95,5,"Nº Cobrança:",0,"L");	
			$pdf->SetXY(10,177);
			$pdf->MultiCell(95,5,"Peso da Amostra:",0,"L");	
		
		
		//CAIXA Identificação Cliente
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(105,120);
		$pdf->MultiCell(95,62,"",1);
		$pdf->SetXY(105,120);
		$pdf->MultiCell(95,5,"Nº de Identificação, Cliente:",1,"L");
		$pdf->SetXY(105,125);
		$pdf->MultiCell(95,5,"Nº Relatório Inspeçao:",1,"L");
		$pdf->SetXY(165,125);
		$pdf->MultiCell(95,5,"Revisão:",0,"L");
			//////////////////CONTEUDO
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY(105,132);
			$pdf->MultiCell(95,5,"Nº da Peça:",0,"L");
			$pdf->SetXY(105,137);
			$pdf->MultiCell(95,5,"Nº de Desenho:",0,"L");
			$pdf->SetXY(105,142);
			$pdf->MultiCell(95,5,"Status/Data de Engenharia:",0,"L");
			$pdf->SetXY(105,147);
			$pdf->MultiCell(95,5,"Nº Revisão",0,"L");
			$pdf->SetXY(105,152);
			$pdf->MultiCell(95,5,"Descrição:",0,"L");
		//CAIXA Identificação Cliente
		$pdf->SetFont('Arial','B',7);
		$pdf->SetXY(105,162);
		$pdf->MultiCell(95,5,"Nº / Data de Nota Fiscal:",1,"L");
			//////////////////CONTEUDO
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY(105,167);
			$pdf->MultiCell(95,5,"Destinação da Entrega:",0,"L");	
			
	
		//CAIXA CONFIRMACAO DO FRONECEDOR
			$pdf->SetFont('Arial','B',7);
			$pdf->SetXY(10,185);
			$pdf->MultiCell(190,30,"",1);
			$pdf->SetXY(10,185);
			$pdf->MultiCell(190,8,"Confirmação do Fornecedor: ",1,"L");
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(10,188);
			$pdf->MultiCell(190,7,"Por meio deste está confirmado que a amostragem foi realizada de acordo com VDA volume 2, Capítulo 4.",0,"L");
				//////////////////CONTEUDO
				$pdf->SetFont('Arial','',7);
				$pdf->SetXY(10,193);
				$pdf->MultiCell(95,22,"",1);
				$pdf->SetXY(10,193);
				$pdf->MultiCell(95,7,"Nome:",0,"L");	
				$pdf->SetXY(10,198);
				$pdf->MultiCell(95,7,"Departamento:",0,"L");
				$pdf->SetXY(10,203);
				$pdf->MultiCell(95,7,"Telefone/ax/E-mail:",0,"L");
				$pdf->SetXY(10,208);
				$pdf->MultiCell(95,7,"Data:",0,"L");
				$pdf->SetXY(60,208);
				$pdf->MultiCell(95,7,"Assinatura:",0,"L");
				$pdf->SetXY(105,193);
				$pdf->MultiCell(95,7,"Observações:",0,"L");
				
				
		//CAIXA DECISAO DO CLIENTE
			$pdf->SetFont('Arial','B',7);
			$pdf->SetXY(10,220);
			$pdf->MultiCell(190,45,"",1);
			$pdf->SetXY(10,220);
			$pdf->MultiCell(190,8,"Decisão do Cliente",1,"L");
				//CAIXA TOTAL
					$pdf->SetXY(95,220);
					$pdf->MultiCell(20,16,"",1,"C");
					$pdf->SetXY(95,220);
					$pdf->MultiCell(20,8,"Total",0,"C");
				//CAIXA DE ACORDO COM ANEXO
					$pdf->SetXY(115,220);
					$pdf->MultiCell(85,4,"De acordo com Anexo:",1,"C");
					//01
					$pdf->SetXY(115,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(115,224);
					$pdf->MultiCell(5,4,"01",0,"C");
					//02
					$pdf->SetXY(120,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(120,224);
					$pdf->MultiCell(5,4,"02",0,"C");
					//03
					$pdf->SetXY(125,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(125,224);
					$pdf->MultiCell(5,4,"03",0,"C");
					//04
					$pdf->SetXY(130,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(130,224);
					$pdf->MultiCell(5,4,"04",0,"C");
					//05
					$pdf->SetXY(135,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(135,224);
					$pdf->MultiCell(5,4,"05",0,"C");
					//06
					$pdf->SetXY(140,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(140,224);
					$pdf->MultiCell(5,4,"06",0,"C");
					//07
					$pdf->SetXY(145,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(145,224);
					$pdf->MultiCell(5,4,"07",0,"C");
					//08
					$pdf->SetXY(150,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(150,224);
					$pdf->MultiCell(5,4,"08",0,"C");
					//09
					$pdf->SetXY(155,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(155,224);
					$pdf->MultiCell(5,4,"09",0,"C");
					//10
					$pdf->SetXY(160,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(160,224);
					$pdf->MultiCell(5,4,"10",0,"C");
					//11
					$pdf->SetXY(165,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(165,224);
					$pdf->MultiCell(5,4,"11",0,"C");
					//12
					$pdf->SetXY(170,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(170,224);
					$pdf->MultiCell(5,4,"12",0,"C");
					//13
					$pdf->SetXY(175,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(175,224);
					$pdf->MultiCell(5,4,"13",0,"C");
					//14
					$pdf->SetXY(180,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(180,224);
					$pdf->MultiCell(5,4,"14",0,"C");
					//15
					$pdf->SetXY(185,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(185,224);
					$pdf->MultiCell(5,4,"15",0,"C");
					//16
					$pdf->SetXY(190,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(190,224);
					$pdf->MultiCell(5,4,"16",0,"C");
					//17
					$pdf->SetXY(195,224);
					$pdf->MultiCell(5,12,"",1,"C");
					$pdf->SetXY(195,224);
					$pdf->MultiCell(5,4,"17",0,"C");	
				
			//CAIXA DECISAO DO CLIENTE - Lista abaixo
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY(10,228);
			$pdf->MultiCell(190,4,"Aprovado",1,"L");
			$pdf->SetXY(10,232);
			$pdf->MultiCell(190,4,"Aprovado com condições",1,"L");
			$pdf->SetXY(10,236);
			$pdf->MultiCell(190,4,"Rejeitado, Nova amostra é necessária",1,"L");
			$pdf->SetXY(10,240);
			$pdf->MultiCell(190,4,"Nº Concessão do Desvio:",1,"L");
			$pdf->SetXY(10,244);
			$pdf->MultiCell(190,4,"Em caso de Retorno, Nº/Data da Nota Fiscal:",1,"L");
			//////
			$pdf->SetXY(10,248);
			$pdf->MultiCell(95,17,"",1);
			$pdf->SetXY(10,248);
			$pdf->MultiCell(95,4,"Nome:",0,"L");
			$pdf->SetXY(10,252);
			$pdf->MultiCell(95,4,"Departamento:",0,"L");
			$pdf->SetXY(10,256);
			$pdf->MultiCell(95,4,"Telefone/Fax/E-mail:",0,"L");
			$pdf->SetXY(15,260);
			$pdf->MultiCell(95,4,"Data:",0,"L");
			$pdf->SetXY(60,260);
			$pdf->MultiCell(95,4,"Assinatura:",0,"L");
			$pdf->SetXY(105,248);
			$pdf->MultiCell(95,4,"Observações:",0,"L");
				

	
	

// linhas dinâmicas  ////////////////////////////////////////////////
$y=38;
$data_i=data2banco($data_i);
$data_f=data2banco($data_f);

$sql=mysql_query("SELECT * FROM apqp_pc WHERE cliente='$cli_id' AND ($status4) ORDER BY id ASC");
// alerta caso não exista registro armazenado
//if(!mysql_num_rows($sql)){
//	$_SESSION["mensagem"]="Não achou nenhum Registro";
//	header("Location:../gerenciamento_consulta.php");
//	exit;
//}

while($res=mysql_fetch_array($sql)){
		// Valores Dinamicos
			if($y>=265){
				$y=38;
				$pag++;
				$pg++;
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',10);   // (fonte,tipo,tamanho)
				$pdf->SetXY(5,10); // posiciona os próximos comandos, entre eles multicell 
				$pdf->MultiCell(200,260,"",1);  // desenha uma caixa (w,h,texto,borda,alinhamento texto), neste caso a borda lateral da página inteira
				$pdf->Image('logo.png',6,11,17,15); // imagem ('endereço', w1, h1, w2, h2)
				$pdf->Line(24,10,24,27); // linha (x,y,x2,y2)
				$pdf->Line(24,19,205,19);
				
				// Título
				$pdf->SetXY(5,12);
				$pdf->MultiCell(205,7,"Consulta",0,"C");
				
				// número de página
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(165,12);
				$pdf->MultiCell(35,7,"Página: $pag",0,"R");
				
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

			//Resultado de paginas seguintes
				// 1ª linha ////////////////////////////////////////////////////////
				$pdf->SetFont('Arial','B',10);  
				
				$pdf->SetXY(5,21);  
				$data_ini=banco2data($data_i);
				$data_fin=banco2data($data_f);
				$pdf->MultiCell(205,5,"Período de $data_ini à $data_fin",0,"C");
							// data do dia no canto direito
							$datahj=banco2data($hj);    // banco2data tabela 3
							$pdf->SetFont('Arial','B',5);  
							$pdf->SetXY(180,21);
							$pdf->MultiCell(20,5,"$datahj",0,"R");

				$pdf->Line(5,27,205,27);

				// 2ª linha  ////////////////////////////////////////////////////////
				$sql2=mysql_query("SELECT * FROM clientes WHERE id='$cli_id'");
				$res2=mysql_fetch_array($sql2);
				
				$pdf->SetFont('Arial','B',8);
				$pdf->SetXY(6,27);
				$pdf->MultiCell(200,5,"Cliente: $res2[nome] - Status:$status1");

				// 3ª linha ////////////////////////////////////////////////////////
				$pdf->SetFont('Arial','B',8);
				// tabela 1
				$pdf->SetXY(5,32);
				$pdf->MultiCell(50,5,"Numero de Peças/Revisão(Interno)",1,"C");
				
				// tabela 2
				$pdf->SetXY(55,32);
				$pdf->MultiCell(55,5,"Numero da Peça/Revisão(Cliente)",1,"C");
				
				// tabela 3
				$pdf->SetXY(110,32);
				$pdf->MultiCell(65,5,"Nome da Peça",1,"C");
				
				// tabela 4
				$pdf->SetXY(175,32);
				$pdf->MultiCell(30,5,"Situação do PPAP",1,"C");
			//Resultado de paginas seguintes FIM
		    }
		// Valores Dinamicos FIM
			//Resultados Primeira pagina
			$pdf->SetFont('Arial','',6);			
				
			// tabela 1  
			$pdf->SetXY(5,$y);
			$pdf->MultiCell(50,5,"$res[numero] / $res[rev]",0,"C");

			// tabela 3
			$pdf->SetXY(55,$y);
			$pdf->MultiCell(55,5,"$res[pecacli]",0,"C");  			
	
			// tabela 5
			$pdf->SetXY(110,$y);
			$pdf->MultiCell(65,5,"$res[nome]",0,"C");			
					
			
			// tabela 6
			$pdf->SetXY(175,$y);
			$pdf->MultiCell(30,5,"$status",0,"C");			

			$y+=5;
			//Resultados Primeira pagina FIM
} 
$pdf->Output('apqp_sub_imp.pdf','I');
?>