<?php
include("../conecta.php");
require('fpdf.php');

$hj=date("Y-m-d"); 
function fdias($datafim,$data){
			$dif = (strtotime($datafim)-strtotime($data))/86400;
			return $dif;
}

$pdf=new FPDF();  // nova função pdf dinâmica
$pdf->AddPage();  // funçao adiciona uma página

$pdf->SetFont('Arial','B',10);   // (fonte,tipo,tamanho)
$pdf->SetXY(5,10); // posiciona os próximos comandos, entre eles multicell 
$pdf->MultiCell(200,260,"",1);  // desenha uma caixa (w,h,texto,borda,alinhamento texto), neste caso a borda lateral da página inteira
$pdf->Image('logo.png',6,11,17,15); // imagem ('endereço', w1, h1, w2, h2)
$pdf->Line(24,10,24,27); // linha (x,y,x2,y2)
$pdf->Line(24,19,205,19);

    // Título
	$pdf->SetXY(5,12);
	$pdf->MultiCell(205,7,"RELATÓRIO DE ACESSO POR AÇÃO",0,"C");
	
	// número de página
	$pag=1;
	$pdf->SetFont('Arial','B',5);
	$pdf->SetXY(165,12);
	$pdf->MultiCell(35,7,"Página: $pag",0,"R");
	
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

	
// 1ª linha ////////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',10);  

$pdf->SetXY(5,21);  
$pdf->MultiCell(205,5,"Horário das $hora_i às $hora_f",0,"C");  // caixa de texto sem borda com 30 caracteres e 5 de altura

		// data do dia no canto direito
		$datahj=banco2data($hj);    // banco2data tabela 3
		$pdf->SetFont('Arial','B',5);  
		$pdf->SetXY(180,21);
		$pdf->MultiCell(20,5,"$datahj",0,"R");

$pdf->Line(5,27,205,27);


$pdf->SetFont('Arial','B',8);
// 2ª linha  ////////////////////////////////////////////////////////

			$nome_acao=$acao2;
			if ($nome_acao=="1"){
			$nome_acao="Incluir"; }
			else if ($nome_acao=="2"){
			$nome_acao="Excluir"; }
			else if ($nome_acao=="3"){
			$nome_acao="Alterar"; }
			else if ($nome_acao=="4"){
			$nome_acao="Salvar"; }
			else if ($nome_acao=="5"){
			$nome_acao="Imprimir"; }
			else if ($nome_acao=="6"){
			$nome_acao="Aprovar"; }
			else if ($nome_acao=="7"){
			$nome_acao="Enviar"; }
			else if ($nome_acao=="8"){
			$nome_acao="Continuar"; }
			else if ($nome_acao=="9"){
			$nome_acao="Permissão de menu"; }
			else if ($nome_acao=="10"){
			$nome_acao="Bloq acesso externo"; }
			else if ($nome_acao=="11"){
			$nome_acao="Desb acesso int/ext"; }
			else if ($nome_acao=="12"){
			$nome_acao="Visualizar"; }
			else if ($nome_acao=="13"){
			$nome_acao="Buscar"; }
			else if ($nome_acao=="14"){
			$nome_acao="Cancelar"; }
			else if ($nome_acao=="15"){
			$nome_acao="Confirmar"; }
			else if ($nome_acao=="16"){
			$nome_acao="Copiar"; }
			else if ($nome_acao=="17"){
			$nome_acao="Acessar página"; }
			else if ($nome_acao=="18"){
			$nome_acao="Finalizar"; }
			else if ($nome_acao=="19"){
			$nome_acao="Exibir"; }
			else if ($nome_acao=="20"){
			$nome_acao="Mudar acesso externo"; }
			else if ($nome_acao=="21"){
			$nome_acao="Agrupar orçamentos"; }
			else if ($nome_acao=="22"){
			$nome_acao="Bloq acesso interno"; }

			$pdf->SetXY(5,27);
			$pdf->MultiCell(100,5,"Ação: $nome_acao");
			$pdf->Line(170,32,170,27);
			$pdf->SetXY(170,27);
			$pdf->MultiCell(50,5,"Data: $data");

// 3ª linha  ////////////////////////////////////////////////////////
// tabela 1
$pdf->SetXY(5,32);
$pdf->MultiCell(30,5,"Usuário",1,"C");

// tabela 2
$pdf->SetXY(35,32);
$pdf->MultiCell(11,5,"Hora",1,"C");

// tabela 3
$pdf->SetXY(46,32);
$pdf->MultiCell(18,5,"Documento",1,"C");

// tabela 4
$pdf->SetXY(64,32);
$pdf->MultiCell(35,5,"Local da Página",1,"C");

// tabela 5
$pdf->SetXY(99,32);
$pdf->MultiCell(82,5,"Página",1,"C");
					
// tabela 6
$pdf->SetXY(181,32);
$pdf->MultiCell(24,5,"IP",1,"C");

// linhas dinâmicas  ////////////////////////////////////////////////
$y=38;

$data=data2banco($data);

if($acao2=="5"){
$busca="WHERE acao='imp' ";
}
else if($acao2=="7"){
$busca="WHERE acao='email' ";
}
else if($acao2=="8"){
$busca="WHERE acao='cont' ";
}
else if($acao2=="9"){
$busca="WHERE acao='marcar' ";
}
else if($acao2=="10"){
$busca="WHERE acao='externo' ";
}
else if($acao2=="11"){
$busca="WHERE acao='des' ";
}
else if($acao2=="13"){
$busca="WHERE acao='busca' ";
}
else if($acao2=="14"){
$busca="WHERE acao='canc' ";
}
else if($acao2=="15"){
$busca="WHERE acao='confirmar' ";
}
else if($acao2=="16"){
$busca="WHERE acao='copiar' ";
}
else if($acao2=="17"){
$busca="WHERE acao='entrar' ";
}
else if($acao2=="18"){
$busca="WHERE acao='fim' ";
}
else if($acao2=="19"){
$busca="WHERE acao='mostrar' ";
}
else if($acao2=="20"){
$busca="WHERE acao='muda' ";
}
else if($acao2=="21"){
$busca="WHERE acao='group' ";
}
else if($acao2=="22"){
$busca="WHERE acao='blok' ";
}
else if($acao2=="12"){
$busca="WHERE (acao='vis' or acao='ir')";
}
else if($acao2=="6"){
$busca="WHERE (acao='g2' or acao='rr3' or acao='aprovar')";
}
else if($acao2=="2"){
$busca="WHERE (acao='exc' or acao='exco' or acao='remover')";
}
else if($acao2=="3"){
$busca="WHERE (acao='alt' or acao='linha' or acao='alterar' or acao='auto' or acao='cap3')";
}
else if($acao2=="1"){
$busca="WHERE (acao='inc' or acao='prop' or acao='ok' or acao='add' or acao='incluir' or acao='espessura')";
}
else if($acao2=="4"){
$busca="WHERE (acao='altt' or acao='altc' or acao='s1' or acao='s2' or acao='s3' or acao='s4' or acao='s5' or acao='v1' or acao='v2' or acao='v3' or acao='v4' or acao='cap2' or acao='i0' or acao='i2' or acao='altp' or acao='rr2' or acao='salvar') ";
}

$sql=mysql_query("SELECT * FROM log $busca AND hora>='$hora_i' AND hora<='$hora_f' AND data='$data' ORDER BY user ASC");

// alerta caso não exista registro armazenado
if(!mysql_num_rows($sql)){
	$_SESSION["mensagem"]="Não achou nenhum Registro";
	header("Location:../moni_esta_raac.php");
	exit;
}

while($res=mysql_fetch_array($sql)){
		// - - - - -- - - - - - -  -- - - - - - - - - - - - - - - - - 
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
				$pdf->MultiCell(205,7,"RELATÓRIO DE ACESSO POR AÇÃO",0,"C");
				
				// número de página
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(165,12);
				$pdf->MultiCell(35,7,"Página: $pag",0,"R");
				
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

	
				// 1ª linha ////////////////////////////////////////////////////////
				$pdf->SetFont('Arial','B',10);  
				
				$pdf->SetXY(5,21);  
				$pdf->MultiCell(205,5,"Horário das $hora_i às $hora_f",0,"C");
							// data do dia no canto direito
							$datahj=banco2data($hj);    // banco2data tabela 3
							$pdf->SetFont('Arial','B',5);  
							$pdf->SetXY(180,21);
							$pdf->MultiCell(20,5,"$datahj",0,"R");

				$pdf->Line(5,27,205,27);
				
				// 2ª linha  ////////////////////////////////////////////////////////
				$pdf->SetFont('Arial','B',8);

				$pdf->SetXY(5,27);
				$pdf->MultiCell(100,5,"Ação: $nome_acao");
				$pdf->Line(170,32,170,27);
				$pdf->SetXY(170,27);
				$data=banco2data($res[data]);
				$pdf->MultiCell(50,5,"Data: $data");

				// 3ª linha ////////////////////////////////////////////////////////
				// tabela 1
				$pdf->SetXY(5,32);
				$pdf->MultiCell(30,5,"Usuário",1,"C");
				
				// tabela 2
				$pdf->SetXY(35,32);
				$pdf->MultiCell(11,5,"Hora",1,"C");
				
				// tabela 3
				$pdf->SetXY(46,32);
				$pdf->MultiCell(18,5,"Documento",1,"C");
				
				// tabela 4
				$pdf->SetXY(64,32);
				$pdf->MultiCell(35,5,"Local da Página",1,"C");
				
				// tabela 5
				$pdf->SetXY(99,32);
				$pdf->MultiCell(82,5,"Página",1,"C");
									
				// tabela 6
				$pdf->SetXY(181,32);
				$pdf->MultiCell(24,5,"IP",1,"C");
		}
		// - - - - -- - - - - - -  -- - - - - - - - - - - - - - - - - 
		$pdf->SetFont('Arial','',6);	

			// tabela 1
			$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$res[user]'");
			$res2=mysql_fetch_array($sql2);
			
			$pdf->SetXY(5,$y);
			if($res2[nome]!=$nome_ant){
			$pdf->MultiCell(30,5,"$res2[nome]");
			}
			$nome_ant=$res2[nome];
			if($y==38 && $pag>1){
			$pdf->MultiCell(30,5,"$nome_ant");
			}
			
			// tabela 2   
			$pdf->SetXY(35,$y);
			$pdf->MultiCell(11,5,"$res[hora]",0,"C");
			
			// tabela 3
			$pdf->SetXY(46,$y);
			$pdf->MultiCell(18,5,"$res[peca_nome]",0,"C");
			
			// tabela 4
			$pdf->SetXY(64,$y);
			$pdf->MultiCell(35,5,"$res[local]",0,"L");
			
			// tabela 5   
			$pdf->SetXY(99,$y);
			$pdf->MultiCell(82,5,"$res[pagina]",0,"L");
			
			// tabela 6
			$pdf->SetXY(181,$y);
			$pdf->MultiCell(24,5,"$res[ip]",0,"C");
			
			$y+=5;
} 

$pdf->Output('apqp_sub_imp.pdf','I');
?>