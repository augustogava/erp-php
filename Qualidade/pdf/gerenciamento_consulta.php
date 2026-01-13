<?php
include("../conecta.php");
require('fpdf.php');
$hora=hora();
$hj=date("Y-m-d");
$quem=$_SESSION["login_nome"];
$user_apro=$_SESSION["login_codigo"];

$cont=0;
foreach($status as $status2=>$status3){
$cont++;
	if ($status3=="1"){
	$stano1="Em Processo,";
	}
	if ($status3=="2"){
	$stano2="Aguardando Disposição,";
	}
	if ($status3=="3"){
	$stano3="Aprovado,";
	}
	if ($status3=="4"){
	$stano4="Rejeitado,";
	}
	if ($status3=="5"){
	$stano5="Outro";
	}
}
	$sql_emp=mysql_query("SELECT fantasia FROM empresa");
	$res_emp=mysql_fetch_array($sql_emp);	
	mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Gerenciamento - Consulta','O usuário $quem efetuou uma busca. Cliente: $cli. Status: $stano1 $stano2 $stano3 $stano4 $stano5','$user_apro')");

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
	$pdf->MultiCell(205,7,"Consulta",0,"C");
	
	// número de página
	$pag=1;
	$pdf->SetFont('Arial','B',5);
	$pdf->SetXY(165,12);
	$pdf->MultiCell(35,7,"Página: $pag",0,"R");
	
	// Total Geral de Pecas
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(165,27);
	$pdf->MultiCell(40,5,"Total Geral de Peças:",0,"L");
	
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

// 1ª linha ////////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',10);  

$pdf->SetXY(5,21);  
$pdf->MultiCell(205,5,"");  // caixa de texto sem borda com 30 caracteres e 5 de altura

		// data do dia no canto direito
		$datahj=banco2data($hj);    // banco2data tabela 3
		$pdf->SetFont('Arial','B',5);  
		$pdf->SetXY(180,21);
		$pdf->MultiCell(20,5,"$datahj",0,"R");

$pdf->Line(5,27,205,27);

// 2ª linha  ////////////////////////////////////////////////////////
$sql2=mysql_query("SELECT * FROM clientes WHERE id='$cli_id'");
$res2=mysql_fetch_array($sql2);
if ($cli_id=="todos"){
$nome_cli="Todos";
}else{
$nome_cli="$res2[nome]";
}
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(6,27);
$pdf->MultiCell(200,5,"Cliente: $nome_cli");

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
	
// linhas dinâmicas  ////////////////////////////////////////////////
$y=38;
$data_i=data2banco($data_i);
$data_f=data2banco($data_f);

$cont=0;
foreach($status as $status2=>$status3){
$cont++;
	if($cont==count($status)){
		$status4.=" status=$status3";
	}else{
		$status4.=" status=$status3 OR";
	}
	if ($status3=="1"){
	$status_nomes.="'Em Processo' ";
	}
	if ($status3=="2"){
	$status_nomes.="'Aguardando Disposição' ";
	}
	if ($status3=="3"){
	$status_nomes.="'Aprovado' ";
	}
	if ($status3=="4"){
	$status_nomes.="'Rejeitado' ";
	}
	if ($status3=="5"){
	$status_nomes.="'Outro' ";
	}
}
//print "SELECT * FROM apqp_pc WHERE cliente='$cli_id' AND ($status4) ORDER BY id ASC";
if ($cli_id=="todos"){
$sql=mysql_query("SELECT * FROM apqp_pc WHERE 1 AND ($status4) ORDER BY id ASC");
}else{
$sql=mysql_query("SELECT * FROM apqp_pc WHERE cliente='$cli_id' AND ($status4) ORDER BY id ASC");
}
// alerta caso não exista registro armazenado
if(!mysql_num_rows($sql)){
	$_SESSION["mensagem"]="Não achou nenhum Registro";
	header("Location:../gerenciamento_consulta.php");
	exit;
}

while($res=mysql_fetch_array($sql)){
$geral_pecas++;
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
				$pdf->MultiCell(205,7,"Consulta",0,"C");
				
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

		    }
		// - - - - -- - - - - - -  -- - - - - - - - - - - - - - - - - 
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
			  switch($res["status"]){
						case "1":
							$status="Em processo";
							break;
						case "2":
							$status="Aguardando Disposição";
							break;
						case "3":
							$status="Aprovado";
							break;
						case "4":
							$status="Rejeitado";
							break;
						case "5":
							$status="Outro";
							break;
					}
				
			
			$pdf->SetXY(175,$y);
			$pdf->MultiCell(30,5,"$status",0,"C");			

			$y+=5;
} 
	// Total Geral de Pecas
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(195,27);
	$pdf->MultiCell(60,5,"$geral_pecas",0,"L");
		
	// Printa Status encontrados na busca
	$pdf->SetFont('Arial','',7);
	$pdf->SetXY(10,27);
	$pdf->MultiCell(200,5,"Status: $status_nomes",0,"C");

$pdf->Output('apqp_sub_imp.pdf','I');
?>