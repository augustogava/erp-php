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
$pdf->Image('empresa_logo/logo.jpg',6,11,17,15); // imagem ('endereço', w1, h1, w2, h2)
$pdf->Line(24,10,24,27); // linha (x,y,x2,y2)
$pdf->Line(24,19,205,19);

    // Título
	$pdf->SetXY(5,12);
	$pdf->MultiCell(205,7,"Relatório de Atividades em Atraso",0,"C");
	
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

		// data do dia no canto direito
		$datahj=banco2data($hj);    // banco2data tabela 3
		$pdf->SetFont('Arial','B',5);  
		$pdf->SetXY(180,21);
		$pdf->MultiCell(20,5,"$datahj",0,"R");

$pdf->Line(5,27,205,27);

// 2ª linha  ////////////////////////////////////////////////////////
// Cliente
$pdf->SetFont('Arial','B',8); 
$pdf->SetXY(25,21);
$pdf->MultiCell(180,5,"Cliente: $cli",0,"L");

// 3ª linha ////////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',8);

// tabela 1
$pdf->SetXY(5,27);
$pdf->MultiCell(30,5,"Nº da Peça/Revisão",1,"C");

// tabela 2
$pdf->SetXY(35,27);
$pdf->MultiCell(60,5,"Atividade",1,"C");

// tabela 3
$pdf->SetXY(95,27);
$pdf->MultiCell(20,5,"Prazo",1,"C");

// tabela 4
$pdf->SetXY(115,27);
$pdf->MultiCell(20,5,"Início",1,"C");

// tabela 5
$pdf->SetXY(135,27);
$pdf->MultiCell(20,5,"Fim",1,"C");

// tabela 6
$pdf->SetXY(155,27);
$pdf->MultiCell(15,5,"Dias",1,"C");

// tabela 7
$pdf->SetXY(170,27);
$pdf->MultiCell(10,5,"%",1,"C");

// tabela 8
$pdf->SetXY(180,27);
$pdf->MultiCell(25,5,"Responsável",1,"C");
	
// linhas dinâmicas  ////////////////////////////////////////////////
$y=35;

$hj=date("Y-m-d");

$cont=0;
foreach($sit as $sit2=>$sit3){
$cont++;
		if($cont==count($sit)){
			$sit4.=" perc=$sit3";
		}else{
			$sit4.=" perc=$sit3 OR";
		}
}
$sql3=mysql_query("SELECT * FROM apqp_pc");
while($res3=mysql_fetch_array($sql3)){
$sql=mysql_query("SELECT * FROM apqp_cron WHERE prazo>$hj AND ($sit4) ORDER BY id ASC");
while($res=mysql_fetch_array($sql)){

		// - - - - -- - - - - - -  -- - - - - - - - - - - - - - - - - 
			if($y>=256){
				$y=35;
				$pag++;
				$pg++;
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',10);   // (fonte,tipo,tamanho)
				$pdf->SetXY(5,10); // posiciona os próximos comandos, entre eles multicell 
				$pdf->MultiCell(200,260,"",1);  // desenha uma caixa (w,h,texto,borda,alinhamento texto), neste caso a borda lateral da página inteira
				$pdf->Image('empresa_logo/logo.jpg',6,11,17,15); // imagem ('endereço', w1, h1, w2, h2)
				$pdf->Line(24,10,24,27); // linha (x,y,x2,y2)
				$pdf->Line(24,19,205,19);
				
				// Título
				$pdf->SetXY(5,12);
				$pdf->MultiCell(205,7,"Relatório de Atividades em Atraso",0,"C");
				
				// número de página
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(165,12);
				$pdf->MultiCell(35,7,"Página: $pag",0,"R");
				
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");

	
				// 1ª linha ////////////////////////////////////////////////////////
							
							// data do dia no canto direito
							$datahj=banco2data($hj);    // banco2data tabela 3
							$pdf->SetFont('Arial','B',5);  
							$pdf->SetXY(180,21);
							$pdf->MultiCell(20,5,"$datahj",0,"R");

				$pdf->Line(5,27,205,27);

				// 2ª linha  ////////////////////////////////////////////////////////
				$pdf->SetFont('Arial','B',8); 
				$pdf->SetXY(25,21);
				$pdf->MultiCell(180,5,"Cliente: $cli",0,"L");
				
				// 3ª linha ////////////////////////////////////////////////////////
				$pdf->SetFont('Arial','B',8);
				
				// tabela 1
				$pdf->SetXY(5,27);
				$pdf->MultiCell(30,5,"Nº da Peça/Revisão",1,"C");
				
				// tabela 2
				$pdf->SetXY(35,27);
				$pdf->MultiCell(60,5,"Atividade",1,"C");
				
				// tabela 3
				$pdf->SetXY(95,27);
				$pdf->MultiCell(20,5,"Prazo",1,"C");
				
				// tabela 4
				$pdf->SetXY(115,27);
				$pdf->MultiCell(20,5,"Início",1,"C");
				
				// tabela 5
				$pdf->SetXY(135,27);
				$pdf->MultiCell(20,5,"Fim",1,"C");
				
				// tabela 6
				$pdf->SetXY(155,27);
				$pdf->MultiCell(15,5,"Dias",1,"C");
				
				// tabela 7
				$pdf->SetXY(170,27);
				$pdf->MultiCell(10,5,"%",1,"C");
				
				// tabela 8
				$pdf->SetXY(180,27);
				$pdf->MultiCell(25,5,"Responsável",1,"C");
					
		
		    }
		// - - - - -- - - - - - -  -- - - - - - - - - - - - - - - - - 
		$pdf->SetFont('Arial','',7);
					
			// 2ª linha  ////////////////////////////////////////////////////////
			$sql2=mysql_query("SELECT * FROM apqp_pc WHERE id='$res[peca]'");
			$res2=mysql_fetch_array($sql2);
			
			// tabela 1
			$peca_ini="$res2[numero] / $res2[rev]";
			$pdf->SetXY(5,$y);
			if($peca_ini!=$peca_ant){
			$pdf->MultiCell(30,0,"$peca_ini",0,"C"); 
			}
			$peca_ant=$peca_ini;
			if($y==35 && $pag>1){
			$pdf->MultiCell(30,0,"$peca_ant",0,"C");
			}

			// tabela 2
			$pdf->SetXY(35,$y);
			$pdf->MultiCell(60,0,"$res[ativ]",0,"L");			

			// tabela 3
			$pdf->SetXY(95,$y);
			$pra=banco2data($res[prazo]);
			$pdf->MultiCell(20,0,"$pra",0,"C");	
			
			// tabela 4
			$pdf->SetXY(115,$y);
			$ini=banco2data($res[ini]);
			$pdf->MultiCell(20,0,"$ini",0,"C");
			
			// tabela 5
			$pdf->SetXY(135,$y);
			$fim=banco2data($res[fim]);
			if($res["fim"]=="0000-00-00"){ $fim='-'; }
			$pdf->MultiCell(20,0,"$fim",0,"C");
				
			// tabela 6
			$pdf->SetXY(155,$y);
			$hj=date("Y-m-d");
			if($res["fim"]=="0000-00-00"){
					if($res["prazo"]=="0000-00-00"){
						print " ";
					}
					else{
						$p=round(strtotime($hj) - strtotime($res["prazo"])) / (60 * 60 * 24);
						if($p>="0"){
							$dias_atra=round($p);
						}
					}
			  }else{
			  $val1=(strtotime($res["prazo"]) - strtotime($res["ini"])) / (60 * 60 * 24);
			  $val2= (strtotime($res["fim"]) - strtotime($res["ini"])) / (60 * 60 * 24);
			  $atrazo=$val2-$val1; 
			  if($atrazo<"0"){ $atrazo="0"; } 
			  if($atrazo>="0"){ $dias_atra=round($atrazo); }
			 }
			$pdf->MultiCell(15,0,"$dias_atra",0,"C");
			
			// tabela 7
			$pdf->SetXY(170,$y);
			$pdf->MultiCell(10,0,"$res[perc]%",0,"C");
			
			// tabela 8
			$resp=$res["responsavel"];
			$resp2=explode(" ",$resp);
 	        $respp=$resp2[0];
			$respp2=$resp2[1];
			$pdf->SetXY(180,$y);
			$pdf->MultiCell(25,0,"$respp $respp2",0,"C");
			$y+=5;
}
}
$pdf->Output('apqp_sub_imp.pdf','I');
?>