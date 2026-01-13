<?php
include("../conecta.php");
require('fpdf.php');

$hj=date("Y-m-d"); 

$pdf=new FPDF();  // nova função pdf dinâmica
$pdf->AddPage();  // funçao adiciona uma página

$pdf->SetFont('Arial','B',10);   // (fonte,tipo,tamanho)
$pdf->SetXY(5,10); // posiciona os próximos comandos, entre eles multicell 
$pdf->MultiCell(200,260,"",1);  // desenha uma caixa (w,h,texto,borda,alinhamento texto), neste caso a borda lateral da página inteira
$pdf->Image('logo.png',6,11,17,15); // imagem ('endereço', w1, h1, w2, h2)
$pdf->Line(24,10,24,27); // linha (x,y,x2,y2)
//$pdf->Line(24,19,205,19);

$pdf->SetXY(5,4);
$pdf->MultiCell(205,7,"QualityManager");

    // Título
	$sql=mysql_query("SELECT * FROM metrologia_cad WHERE metr_cad_id='$id'"); //
	$res=mysql_fetch_array($sql);
	$ano=banco2data($res["metr_cad_emit"]);
	$ano_res=substr("$ano", 8);
	$pdf->SetXY(5,15);
	$pdf->MultiCell(205,7,"LAUDO DE CALIBRAÇÃO NO. $res[metr_cad_id]/$ano_res",0,"C");
	
	// número de página
	$pag=1;
	$pdf->SetFont('Arial','B',5);
	$pdf->SetXY(165,16);
	$pdf->MultiCell(35,7,"Página: $pag",0,"R");
	
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

	
// 2ª linha ////////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',10);  

$data2=date ('d/m/Y', mktime (0, 0, 0, date('m'), date('d')+$res["metr_cad_vali"], date('Y')));

		// data do dia no canto direito
		$datahj=banco2data($hj);
		$pdf->SetFont('Arial','B',5);  
		$pdf->SetXY(165,17);
		$pdf->MultiCell(20,5,"$datahj",0,"R");

$pdf->Line(5,27,205,27);

// 3ª linha  ////////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,27);
$pdf->MultiCell(200,5,"Instrumento: $res[metr_tipo_apelido]		Validade: $data2");

// Bloco 1 ////////////////////////////////////////////////////////
$pdf->Line(5,32,205,32);
$pdf->Line(5,64.5,205,64.5);
$pdf->Line(5,89.5,205,89.5);  

// tabela 1
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,32);
$pdf->MultiCell(50,5,"Tipo");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,32);
$pdf->MultiCell(150,5,"$res[metr_tipi_apelido] - $res[metr_tipi_nome]");

// tabela 2
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,37);
$pdf->MultiCell(50,5,"Instrução");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,37);
$pdf->MultiCell(150,5,"$res[metr_inst]");

// tabela 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,42);
$pdf->MultiCell(50,5,"Departamento");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,42);
$pdf->MultiCell(150,5,"$res[metr_seto_sigla] - $res[metr_seto_nome]");
					
// tabela 4
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,47);
$pdf->MultiCell(50,5,"Localização");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,47);
$pdf->MultiCell(150,5,"$res[metr_seto_sigla]");

// tabela 5
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,52);
$pdf->MultiCell(50,5,"Usuário");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,52);
$pdf->MultiCell(150,5,"$res[metr_func_nome] - $res[metr_seto_sigla]");

// tabela 6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,57);
$pdf->MultiCell(50,5,"Orgão Calibrador");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,57);
$pdf->MultiCell(150,5,"$res[metr_orgc]");

// bloco 2  ////////////////////////////////////////////////
//coluna 1
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,67);
$pdf->MultiCell(33,5,"Desenho");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(38,67);
$pdf->MultiCell(34,5,"");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,72);
$pdf->MultiCell(33,5,"Fabricante");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(38,72);
$pdf->MultiCell(34,5,"$res[metr_fabr]");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,77);
$pdf->MultiCell(33,5,"Nº Desenho");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(38,77);
$pdf->MultiCell(34,5,"$res[metr_dese]");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,82);
$pdf->MultiCell(33,5,"Uso Inicial");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(38,82);
$data3=banco2data($res[metr_usoi]);
$pdf->MultiCell(34,5,"$data3");

//coluna 2
$val=banco2valor2($res["metr_esca1"]);
$val2=banco2valor2($res["metr_esca2"]);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(72,67);
$pdf->MultiCell(33,5,"Escala");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105,67);
$pdf->MultiCell(34,5,"$val - $val2");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(72,72);
$pdf->MultiCell(33,5,"Tensão Aliment.");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105,72);
$pdf->MultiCell(34,5,"$res[metr_tena]");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(72,77);
$pdf->MultiCell(33,5,"Potência");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105,77);
$pdf->MultiCell(34,5,"$res[metr_pote]");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(72,82);
$pdf->MultiCell(33,5,"Freq. Calibração");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(105,82);
$pdf->MultiCell(34,5,"$res[metr_cad_vali] dias");

//coluna 3
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(139,67);
$pdf->MultiCell(33,5,"Precisão");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(172,67);
$pdf->MultiCell(34,5,"$res[metr_prec]");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(139,72);
$pdf->MultiCell(33,5,"Leitura");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(172,72);
$pdf->MultiCell(34,5,"$res[metr_leit]");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(139,77);
$pdf->MultiCell(33,5,"Custo");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(172,77);
$val9=banco2valor($res[metr_cust]);
$pdf->MultiCell(34,5,"R$ $val9");


// 2ª parte
$pdf->SetFont('Arial','B',10);  
$pdf->SetXY(5,94);
$pdf->MultiCell(100,5,"Padrão para Calibração");

// cota 1
$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(5,99);
$pdf->MultiCell(100,5,"Cota 1");

$pdf->SetXY(5,104);
$pdf->MultiCell(20,5,"Faixa",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5,109);
$pdf->MultiCell(20,5,"$val",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(25,104);
$pdf->MultiCell(15,5,"Rev.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(25,109);
$pdf->MultiCell(15,5,"$res[metr_rev]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(40,104);
$pdf->MultiCell(25,5,"Tolerância",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,109);
$val5=banco2valor2($res[metr_tol]);
$pdf->MultiCell(25,5,"$val5",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(65,104);
$pdf->MultiCell(25,5,"Especificado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(65,109);
$val3=banco2valor2($res[metr_esp1]);
$pdf->MultiCell(25,5,"$val3",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(90,104);
$pdf->MultiCell(25,5,"Unid. Med.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(90,109);
$pdf->MultiCell(25,5,"$res[metr_unid_nome]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(115,104);
$pdf->MultiCell(25,5,"Certificado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(115,109);
$pdf->MultiCell(25,5,"$res[metr_cert2]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(140,104);
$pdf->MultiCell(30,5,"Padrão Utilizado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140,109);
$pdf->MultiCell(30,5,"$res[metr_padrao1]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(170,104);
$pdf->MultiCell(20,5,"Val. Cal.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(170,109);
$pdf->MultiCell(20,5,"$data2",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(190,104);
$pdf->MultiCell(15,5,"Incerteza",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(190,109);
$pdf->MultiCell(15,5,"$res[metr_incert1]",1,"C");

// cota 2
$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(5,114);
$pdf->MultiCell(100,5,"Cota 2");

$pdf->SetXY(5,119);
$pdf->MultiCell(20,5,"Faixa",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5,124);
$pdf->MultiCell(20,5,"$val2",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(25,119);
$pdf->MultiCell(15,5,"Rev.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(25,124);
$pdf->MultiCell(15,5,"$res[metr_rev]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(40,119);
$pdf->MultiCell(25,5,"Tolerância",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,124);
$val6=banco2valor2($res[metr_tol2]);
$pdf->MultiCell(25,5,"$val6",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(65,119);
$pdf->MultiCell(25,5,"Especificado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(65,124);
$val4=banco2valor2($res[metr_esp2]);
$pdf->MultiCell(25,5,"$val4",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(90,119);
$pdf->MultiCell(25,5,"Unid. Med.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(90,124);
$pdf->MultiCell(25,5,"$res[metr_unid_nome]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(115,119);
$pdf->MultiCell(25,5,"Certificado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(115,124);
$pdf->MultiCell(25,5,"$res[metr_cert2]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(140,119);
$pdf->MultiCell(30,5,"Padrão Utilizado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140,124);
$pdf->MultiCell(30,5,"$res[metr_padrao2]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(170,119);
$pdf->MultiCell(20,5,"Val. Cal.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(170,124);
$pdf->MultiCell(20,5,"$data2",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(190,119);
$pdf->MultiCell(15,5,"Incerteza",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(190,124);
$pdf->MultiCell(15,5,"$res[metr_incert2]",1,"C");


//bloco 3
$login=$_SESSION['login_nome'];
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(5,134);
$pdf->MultiCell(50,5,"Medições");
$data3=banco2data($res["metr_data_aprov"]);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5,139);
$pdf->MultiCell(50,5,"Data: $data3");
$pdf->SetXY(105,139);
$pdf->MultiCell(50,5,"Metrolog.: $login");

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5,144);
$pdf->MultiCell(100,5,"Cota 1");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(5,149);
$pdf->MultiCell(25,5,"Padrão/Pto Ref.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5,154);
$pdf->MultiCell(25,5,"$val",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(30,149);
$pdf->MultiCell(15,5,"Rev.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(30,154);
$pdf->MultiCell(15,5,"$res[metr_rev]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(45,149);
$pdf->MultiCell(25,5,"Encontrado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(45,154);
$pdf->MultiCell(25,5,"$res[metr_enc1]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(70,149);
$pdf->MultiCell(25,5,"Erro(%)",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(70,154);
$val7=banco2valor2($res[metr_erro1]);
$pdf->MultiCell(25,5,"$val7",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5,159);
$pdf->MultiCell(100,5,"Cota 2");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(5,164);
$pdf->MultiCell(25,5,"Padrão/Pto Ref.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5,169);
$pdf->MultiCell(25,5,"$val2",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(30,164);
$pdf->MultiCell(15,5,"Rev.",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(30,169);
$pdf->MultiCell(15,5,"$res[metr_rev]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(45,164);
$pdf->MultiCell(25,5,"Encontrado",1,"C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(45,169);
$pdf->MultiCell(25,5,"$res[metr_enc2]",1,"C");

$pdf->SetFont('Arial','B',8);  
$pdf->SetXY(70,164);
$pdf->MultiCell(25,5,"Erro(%)",1,"C");
$pdf->SetFont('Arial','',8);  
$pdf->SetXY(70,169);
$val8=banco2valor2($res[metr_erro2]);
$pdf->MultiCell(25,5,"$val8",1,"C");

// laudo
if (($res["metr_stat_a"]=="Reprovado")||($res["metr_stat_e"]=="Reprovado")) { 
$laudo="Reprovado"; 
} else if(($res["metr_stat_a"]=="Aguardando Aprovação")||($res["metr_stat_e"]=="Aguardando Aprovação")) {
$laudo= "Aguardando Aprovação"; 
} else if(($res["metr_stat_a"]=="Aprovado")&&($res["metr_stat_e"]=="Aprovado")){
$laudo="Aprovado"; 
}
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(5,179);
$pdf->MultiCell(100,5,"Laudo: $laudo");

// condição de recebimento
$pdf->SetXY(5,189);
$pdf->MultiCell(100,5,"Condição do Recebimento: $res[metr_condrec]");

$pdf->SetFont('Arial','',9);
$pdf->SetXY(5,194);
$pdf->MultiCell(200,5,"PROCEDIMENTO DO EXAME: O instrumento foi calibrado por leitura direta a um instrumento de características padrão.");

$pdf->SetXY(5,204);
$pdf->MultiCell(200,5,"OBSERVAÇÕES/RESTRIÇÕES: O prazo de validade estimado deste certificado está estabelecido acima e se condiciona a situações aceitáveis de transporte, uso, manuseio e acondicionamento.");

// ASSINATURA
$pdf->SetXY(15,229);
$pdf->MultiCell(50,5,"$res[metr_audi_nome]",0,"C");
$pdf->Line(15,234,65,234);
$pdf->SetXY(15,234);
$pdf->MultiCell(50,5,"$res[metr_audi_nome]",0,"C");
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(15,241.5);
$pdf->MultiCell(50,5,"Auditor",0,"C");

$pdf->SetFont('Arial','',9);
$pdf->SetXY(145,229);
$pdf->MultiCell(50,5,"$res[metr_encg_nome]",0,"C");
$pdf->Line(145,234,195,234);
$pdf->SetXY(145,234);
$pdf->MultiCell(50,5,"$res[metr_encg_nome]",0,"C");
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(145,241.5);
$pdf->MultiCell(50,5,"Enc. Garantia da Qualidade",0,"C");


$pdf->Output('apqp_sub_imp.pdf','I');
?>