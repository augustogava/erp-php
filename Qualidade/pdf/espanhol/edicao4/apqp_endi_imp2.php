<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_endi WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$eng=$res["niveleng"];
$proj=$res["nivelproj"];
$resultado=$resp["result"];
$cod_forn=$res["cod_forn"];
$pdf->AddPage();
$pg=1;
$razao=$rese["razao"];
$cliente=$res["pecacli"];
$numero=$res["numero"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];
$pdf->Image('empresa_logo/logo.jpg',5,1,20);  // logo qualitmanager
$pdf->Image('imagens/logo_chrysler.jpg',25,15,25,3);
$pdf->Image('imagens/logo_ford.jpg',50,12.5,13);
$pdf->Image('imagens/logo_gm.jpg',64,11.5,6);
$pdf->SetXY(40, 0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30);
$pdf->Cell(0, 8, 'Aprobación de Piezas para Producción');
$pdf->SetXY(40, 5);
$pdf->Cell(45);
$pdf->Cell(0, 8, 'Resultados Dimensionales');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 5);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->SetXY(5, 18);
$pdf->MultiCell(110,10,"",1);
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(110,5,"Organización: $razao");
$pdf->SetXY(5, 23);
$pdf->MultiCell(110,5,"Código del surtidor/vendedor: $cod_forn");
$pdf->SetXY(115, 18);
$pdf->MultiCell(90,25,"",1);
$pdf->SetXY(115, 18);
$pdf->MultiCell(90,5,"Número De Pieza (Cliente): $cliente");
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(110,15,"",1);
$pdf->SetXY(5, 28);
$pdf->MultiCell(110,5,"Facilidad De la Inspección: \n $local");
$pdf->SetXY(115, 23);
$pdf->MultiCell(90,5,"Nombre de la Pieza: $nome");
$pdf->SetXY(115, 28);
$pdf->MultiCell(90,5,"Nivel de la Alteración del Proyecto: $proj");
$pdf->SetXY(115, 33);
$pdf->MultiCell(90,5,"Nivel de la Alteración de la Ing.: $eng");

//linha 3
$pdf->SetFont('Arial','B',7.5);
$pdf->SetXY(5, 43);
$pdf->MultiCell(12,10,"Item",1,'C');
$pdf->SetXY(17, 43);
$pdf->MultiCell(49,10,"Dimension/Especificación",1,'C');
$pdf->SetXY(66, 43);
$pdf->MultiCell(25,5,"Límites",1,'C');
$pdf->SetXY(66, 48);
$pdf->MultiCell(12.5,5,"LIE",1,'C');
$pdf->SetXY(78.5, 48);
$pdf->MultiCell(12.5,5,"LSE",1,'C');
$pdf->SetXY(91, 43);
$pdf->MultiCell(12,3.33,"Fecha de\nprueba",1,'C');
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(103, 43);
$pdf->MultiCell(12,5,"Cantid. \nprobada",1,'C');
$pdf->SetFont('Arial','B',7.5);
$pdf->SetXY(115, 43);
$pdf->MultiCell(72,10,"Resultados das Mediciones del Organización (fecha)",1,'C');
$pdf->SetXY(187, 43);
$pdf->MultiCell(8,10,"OK",1,'C');
$pdf->SetXY(195, 43);
$pdf->MultiCell(10,5,"No \nOK",1,'C');

//linha 4
$y=53;
$sql=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo,car.lie,car.lse FROM apqp_car AS car, apqp_endi AS ensaio, apqp_endil AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER BY car.numero ASC");
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		if($y>=250){
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$y=53;
			$pg++;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,20);  // logo qualitmanager
			$pdf->Image('imagens/logo_chrysler.jpg',25,15,25,3);
			$pdf->Image('imagens/logo_ford.jpg',50,12.5,13);
			$pdf->Image('imagens/logo_gm.jpg',64,11.5,6);
			$pdf->SetXY(40, 0);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(30);
			$pdf->Cell(0, 8, 'Aprobación de Piezas para Producción');
			$pdf->SetXY(40, 5);
			$pdf->Cell(45);
			$pdf->Cell(0, 8, 'Resultados Dimensionales');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 5);
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
			$pdf->SetXY(5, 18);
			$pdf->MultiCell(110,10,"",1);
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(110,5,"Organización: $razao");
			$pdf->SetXY(5, 23);
			$pdf->MultiCell(110,5,"Código del surtidor/vendedor: $cod_forn");
			$pdf->SetXY(115, 18);
			$pdf->MultiCell(90,25,"",1);
			$pdf->SetXY(115, 18);
			$pdf->MultiCell(90,5,"Número De Pieza (Cliente): $cliente");
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(110,15,"",1);
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(110,5,"Facilidad De la Inspección: \n $local");
			$pdf->SetXY(115, 23);
			$pdf->MultiCell(90,5,"Nombre de la Pieza: $nome");
			$pdf->SetXY(115, 28);
			$pdf->MultiCell(90,5,"Nivel de la Alteración del Proyecto: $proj");
			$pdf->SetXY(115, 33);
			$pdf->MultiCell(90,5,"Nivel de la Alteración de la Ing.: $eng");
			
			//linha 3
			$pdf->SetFont('Arial','B',7.5);
			$pdf->SetXY(5, 43);
			$pdf->MultiCell(12,10,"Item",1,'C');
			$pdf->SetXY(17, 43);
			$pdf->MultiCell(49,10,"Dimension/Especificación",1,'C');
			$pdf->SetXY(66, 43);
			$pdf->MultiCell(25,5,"Límites",1,'C');
			$pdf->SetXY(66, 48);
			$pdf->MultiCell(12.5,5,"LIE",1,'C');
			$pdf->SetXY(78.5, 48);
			$pdf->MultiCell(12.5,5,"LSE",1,'C');
			$pdf->SetXY(91, 43);
			$pdf->MultiCell(12,3.33,"Fecha de\nprueba",1,'C');
			$pdf->SetFont('Arial','B',7);
			$pdf->SetXY(103, 43);
			$pdf->MultiCell(12,5,"Cantid. \nprobada",1,'C');
			$pdf->SetFont('Arial','B',7.5);
			$pdf->SetXY(115, 43);
			$pdf->MultiCell(72,10,"Resultados das Mediciones del Organización (fecha)",1,'C');
			$pdf->SetXY(187, 43);
			$pdf->MultiCell(8,10,"OK",1,'C');
			$pdf->SetXY(195, 43);
			$pdf->MultiCell(10,5,"No \nOK",1,'C');
		}
		$tam1[0]=flinha($res["numero"],12);
		$tam1[1]=flinha("$res[descricao] - $res[espec]",43);	
		$tam1[2]=flinha("$res[lie] / $res[lse]",31);
		$tam1[3]=flinha("$data_teste",13);
		$tam1[4]=flinha("$res[quant_test]",12);
		$tam1[5]=1;
		$tam1[6]=flinha($res["forn"],72);
		if($tam1[6]==0){$tam1[6]=1;}
		$tam1[7]=1;
		$maxu=max($tam1);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxu - $tam1[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(12,$w,$res["numero"],0,'C');
		$pdf->SetXY(17,$y);
		$pdf->MultiCell(49,$w,"$res[descricao] - $res[espec]",0);
		if(!empty($res["lie"])){
			$pdf->SetXY(66,$y);
			$pdf->MultiCell(12.5,$w,"$res[lie]",0,'C');
		}
		if(!empty($res["lse"])){
			$pdf->SetXY(78.5,$y);
			$pdf->MultiCell(12.5,$w,"$res[lie]",0,'C');
		}
		if(!empty($res["data_t"])){
			$data_teste=banco2data($res["data_t"]);
			$pdf->SetXY(90.5,$y);
			$pdf->MultiCell(13,$w,"$data_teste",0,'C');
		}
		if(!empty($res["quant_test"])){
			$pdf->SetXY(103,$y);
			$pdf->MultiCell(12,$w,"$res[quant_test]",0,'C');
		}
		$pdf->SetXY(115, $y);
		$pdf->MultiCell(72,$w,$res["forn"],0);
		$pdf->SetXY(187, $y);
		if($res["ok"]=="S"){$ok="X";}else{$ok="";}
		$pdf->MultiCell(8,$w,$ok,0,'C');
		if($res["ok"]=="N"){$ok="X";}else{$ok="";}
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok,0,'C');
		$y=($maxu*5)+$y;
		$pdf->Line(5,$y,205,$y);
		$pdf->Line(5,253,205,253);
		$pdf->Line(5,53,5,253);
		$pdf->Line(17,53,17,253);
		$pdf->Line(91,53,91,253);
		$pdf->Line(66,53,66,253);
		$pdf->Line(78.5,53,78.5,253);		
		$pdf->Line(103,53,103,253);
		$pdf->Line(115,53,115,253);
		$pdf->Line(187,53,187,253);
		$pdf->Line(195,53,195,253);
		$pdf->Line(205,53,205,253);
	}
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
}
//ultima linha

$pdf->SetFont('Arial','',6);
$pdf->SetXY(15, 253.5);
$pdf->MultiCell(8,3,"March  2006",'C');

$pdf->SetFont('Arial','B',7);
$pdf->SetXY(30, 254);
$pdf->MultiCell(20,5,"CFG-1003",'C');

$pdf->SetFont('Arial','',7);
$pdf->SetXY(95, 254);
$pdf->MultiCell(110,5,"La información de carácter general al igual que inaceptable para todo el resultado de las pruebas.",1);

$y=260;
$pdf->SetFont('Arial','',7);
$pdf->SetXY(5, $y);
$pdf->MultiCell(82,5,"Aprobado Por \n $resp[quem]",1,'');
$pdf->SetXY(87, $y);
$pdf->MultiCell(20,5,"Fecha \n ".banco2data($resp["dtquem"])."",1);
$pdf->SetXY(107, $y);
$pdf->MultiCell(80,5,"Firma del Surtidor \n $resp[rep]",1,'');
$pdf->SetXY(187, $y);
$pdf->MultiCell(18,5,"Fecha \n ".banco2data($resp["dtrep"])."",1);


//fim
?>
