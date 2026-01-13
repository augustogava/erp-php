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
	$pdf->MultiCell(205,7,"RELATÓRIO DE ACESSO POR USUÁRIO, DATA E HORA",0,"C");
	
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
			$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$usuario'");
			$res2=mysql_fetch_array($sql2);
			$pdf->SetXY(5,27);
			$pdf->MultiCell(100,5,"Usuário: $res2[nome]");
			$pdf->Line(170,32,170,27);
			$pdf->SetXY(170,27);
			$pdf->MultiCell(50,5,"Data: $data");

// 3ª linha  ////////////////////////////////////////////////////////
// tabela 1
$pdf->SetXY(5,32);
$pdf->MultiCell(14,5,"Hora",1,"C");

// tabela 2
$pdf->SetXY(19,32);
$pdf->MultiCell(16,5,"Ação",1,"C");

// tabela 3
$pdf->SetXY(35,32);
$pdf->MultiCell(18,5,"Documento",1,"C");
				
// tabela 4
$pdf->SetXY(53,32);
$pdf->MultiCell(35,5,"Local da Página",1,"C");
		
// tabela 5
$pdf->SetXY(88,32);
$pdf->MultiCell(92,5,"Página",1,"C");
					
// tabela 6
$pdf->SetXY(180,32);
$pdf->MultiCell(25,5,"IP",1,"C");

// linhas dinâmicas  ////////////////////////////////////////////////
$y=38;

$data=data2banco($data);

$sql=mysql_query("SELECT * FROM log WHERE hora>='$hora_i' AND hora<='$hora_f' AND data='$data' AND user='$usuario' ORDER BY data ASC");

// alerta caso não exista registro armazenado
if(!mysql_num_rows($sql)){
	$_SESSION["mensagem"]="Não achou nenhum Registro";
	header("Location:../moni_esta_raudh.php");
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
				$pdf->MultiCell(205,7,"RELATÓRIO DE ACESSO POR USUÁRIO, DATA E HORA",0,"C");
				
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

				$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$usuario'");
				$res2=mysql_fetch_array($sql2);
				$pdf->SetXY(5,27);
				$pdf->MultiCell(100,5,"Usuário: $res2[nome]");
				$pdf->Line(170,32,170,27);
				$pdf->SetXY(170,27);
				$data=banco2data($res[data]);
				$pdf->MultiCell(50,5,"Data: $data");


				// 3ª linha ////////////////////////////////////////////////////////
				// tabela 1
				$pdf->SetXY(5,32);
				$pdf->MultiCell(14,5,"Hora",1,"C");
				
				// tabela 2
				$pdf->SetXY(19,32);
				$pdf->MultiCell(16,5,"Ação",1,"C");
				
				// tabela 3
				$pdf->SetXY(35,32);
				$pdf->MultiCell(18,5,"Documento",1,"C");
								
				// tabela 4
				$pdf->SetXY(53,32);
				$pdf->MultiCell(35,5,"Local da Página",1,"C");
						
				// tabela 5
				$pdf->SetXY(88,32);
				$pdf->MultiCell(92,5,"Página",1,"C");
									
				// tabela 6
				$pdf->SetXY(180,32);
				$pdf->MultiCell(25,5,"IP",1,"C");
		}
		// - - - - -- - - - - - -  -- - - - - - - - - - - - - - - - - 
		$pdf->SetFont('Arial','',6);	
			
			// tabela 1   
			$pdf->SetXY(5,$y);
			$pdf->MultiCell(14,5,"$res[hora]",0,"C");

			// tabela 2 
						$nome_acao=$res[acao];
			
						if ($nome_acao='inc' or $nome_acao='prop' or $nome_acao='ok' or $nome_acao='add' or $nome_acao='incluir' or $nome_acao='espessura'){
						$nome_acao="incluir"; }
						else if ($nome_acao='exc' or $nome_acao='exco' or $nome_acao='remover'){
						$nome_acao="excluir"; }
						else if ($nome_acao=="add"){
						$nome_acao="adicionar"; }
						if ($nome_acao=="busc"){
						$nome_acao="buscar"; }
						else if ($nome_acao=="cont"){
						$nome_acao="continuar"; }
						if ($nome_acao=="canc"){
						$nome_acao="cancelar"; }
						if ($nome_acao=="confirmar"){
						$nome_acao="confirmar"; }
						if ($nome_acao=="copiar"){
						$nome_acao="copiar"; }						
						else if ($nome_acao=="imp"){
						$nome_acao="imprimir"; }
						else if ($nome_acao=="marcar"){
						$nome_acao="perm menu"; }
						else if ($nome_acao=="vis" or $nome_acao=="ir"){
						$nome_acao="visualizar"; }
						else if ($nome_acao=="externo"){
						$nome_acao="bloq ext"; }
						else if ($nome_acao=="des"){
						$nome_acao="desb ext"; }
						else if ($nome_acao=="rr2"){
						$nome_acao="salv R&R";}
						else if ($nome_acao='g2' or $nome_acao='rr3' or $nome_acao='aprovar'){
						$nome_acao="aprov R&R"; }
						if ($nome_acao=="entrar"){
						$nome_acao="acess pág"; }						
						if ($nome_acao=="fim"){
						$nome_acao="finalizar"; }						
						if ($nome_acao=="blok"){
						$nome_acao="bloq int"; }						
						if ($nome_acao=="muda"){
						$nome_acao="alt ext"; }						
						if ($nome_acao=="group"){
						$nome_acao="agrup orç"; }						
						if ($nome_acao=="mostrar"){
						$nome_acao="exibir"; }						
						else if ($nome_acao=="cap2"){
						$nome_acao="salv cap"; }
						else if ($nome_acao=="g2"){
						$nome_acao="apro check"; }
						else if ($nome_acao=="email"){
						$nome_acao="env email"; }
						else if ($nome_acao=="i0" or $nome_acao=="i2" or $nome_acao=="altp"){
						$nome_acao="salv instr"; }
						else if ($nome_acao='alt' or $nome_acao='linha' or $nome_acao='alterar' or $nome_acao='auto' or $nome_acao='cap3'){
						$nome_acao="alterar"; }
						else {
						$nome_acao="salvar";
						}
						
			$pdf->SetXY(19,$y);
			$pdf->MultiCell(16,5,"$nome_acao",0,"L");    
	
			// tabela 3
			$pdf->SetXY(35,$y);
			$pdf->MultiCell(18,5,"$res[peca_nome]",0,"C");
				
			// tabela 4
			$pdf->SetXY(53,$y);
			$pdf->MultiCell(35,5,"$res[local]",0,"L");			
	
			// tabela 5   
			$pdf->SetXY(88,$y);
			$pdf->MultiCell(92,5,"$res[pagina]",0,"L");			
			
			// tabela 6
			$pdf->SetXY(180,$y);
			$pdf->MultiCell(25,5,"$res[ip]",0,"C");			
			
			$y+=5;
} 

$pdf->Output('apqp_sub_imp.pdf','I');
?>