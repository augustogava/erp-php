<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_enma WHERE peca='$pc'");
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
$pdf->Cell(33);
$pdf->Cell(0, 8, 'Aprobación de Piezas para Produción');
$pdf->SetXY(45, 5);
$pdf->Cell(25);
$pdf->Cell(0, 8, 'Resultados de las Pruebas de Materiales');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 5);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->SetXY(5, 18);
$pdf->MultiCell(104,10,"",1);
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(110,5,"Organización: $razao");
$pdf->SetXY(5, 23);
$pdf->MultiCell(110,5,"Código del surtidor/vendedor: $cod_forn");
$pdf->SetXY(109, 18);
$pdf->MultiCell(96,25,"",1);
$pdf->SetXY(109, 18);
$pdf->MultiCell(90,5,"Número De Pieza (Cliente): $num");
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(104,15,"",1);
$pdf->SetXY(5, 28);
$pdf->MultiCell(110,5,"Surtidor Material: $resp[forn_mat]");
$pdf->SetXY(5, 33);
$pdf->MultiCell(110,5,"Código especificado cliente del Surtidor/Vendedor: $resp[forncod]");

$pdf->SetFont('Arial','',6);
$pdf->SetXY(5, 38);
$pdf->MultiCell(110,5,"* si la aprobación de la fuente es requerido, incluya el código asignado del surtidor y del cliente.");

$pdf->SetFont('Arial','',8);
$pdf->SetXY(109, 23);
$pdf->MultiCell(90,5,"Nombre de la Pieza: $nome");
$pdf->SetXY(109, 28);
$pdf->MultiCell(90,5,"Nivel de la Alteración del Proyecto: $proj");
$pdf->SetXY(109, 33);
$pdf->MultiCell(90,5,"Nivel de la Alteración de la Ing.: $eng");
$pdf->SetXY(109, 38);
$pdf->MultiCell(96,5,"Nombre del laboratorio: $local",1);

//linha 3
$pdf->SetFont('Arial','B',7.5);
$pdf->SetXY(5, 43);
$pdf->MultiCell(55,10,"Nº de Espec. Material / Rev / Fecha",1,'C');
$pdf->SetXY(60, 43);
$pdf->MultiCell(25,5,"Límites",1,'C');
$pdf->SetXY(60, 48);
$pdf->MultiCell(12.5,5,"LIE",1,'C');
$pdf->SetXY(72.5, 48);
$pdf->MultiCell(12.5,5,"LSE",1,'C');
$pdf->SetXY(85, 43);
$pdf->MultiCell(12,3.33,"Fecha de\nprueba",1,'C');
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(97, 43);
$pdf->MultiCell(12,5,"Cantid. \nprobada",1,'C');
$pdf->SetFont('Arial','B',7.5);
$pdf->SetXY(109, 43);
$pdf->MultiCell(80,5,"Resultados de la Prueba del Surtidor (Fecha)",1,'C');
$pdf->SetXY(109, 48);
$pdf->MultiCell(40,5,"Por el Surtidor",1,'C');
$pdf->SetXY(149, 48);
$pdf->MultiCell(40,5,"Por el Cliente",1,'C');
$pdf->SetXY(189, 43);
$pdf->MultiCell(8,10,"OK",1,'C');
$pdf->SetXY(197, 43);
$pdf->MultiCell(8,5,"No OK",1,'C');

//linha 4
$y=53;
$sql=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo,car.lie,car.lse FROM apqp_car AS car, apqp_enma AS ensaio, apqp_enmal AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER BY car.numero ASC");
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
			$pdf->Cell(33);
			$pdf->Cell(0, 8, 'Aprobación de Piezas para Produción');
			$pdf->SetXY(45, 5);
			$pdf->Cell(25);
			$pdf->Cell(0, 8, 'Resultados de las Pruebas de Materiales');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 5);
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
			$pdf->SetXY(5, 18);
			$pdf->MultiCell(104,10,"",1);
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(110,5,"Organización: $razao");
			$pdf->SetXY(5, 23);
			$pdf->MultiCell(110,5,"Código del surtidor/vendedor: $cod_forn");
			$pdf->SetXY(109, 18);
			$pdf->MultiCell(96,25,"",1);
			$pdf->SetXY(109, 18);
			$pdf->MultiCell(90,5,"Número De Pieza (Cliente): $num");
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(104,15,"",1);
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(110,5,"Surtidor Material: $resp[forn_mat]");
			$pdf->SetXY(5, 33);
			$pdf->MultiCell(110,5,"Código especificado cliente del Surtidor/Vendedor: $resp[forncod]");
			
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(5, 38);
			$pdf->MultiCell(110,5,"* si la aprobación de la fuente es requerido, incluya el código asignado del surtidor y del cliente.");
			
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(109, 23);
			$pdf->MultiCell(90,5,"Nombre de la Pieza: $nome");
			$pdf->SetXY(109, 28);
			$pdf->MultiCell(90,5,"Nivel de la Alteración del Proyecto: $proj");
			$pdf->SetXY(109, 33);
			$pdf->MultiCell(90,5,"Nivel de la Alteración de la Ing.: $eng");
			$pdf->SetXY(109, 38);
			$pdf->MultiCell(96,5,"Nombre del laboratorio: $local",1);
			
			//linha 3
			$pdf->SetFont('Arial','B',7.5);
			$pdf->SetXY(5, 43);
			$pdf->MultiCell(55,10,"Nº de Espec. Material / Rev / Fecha",1,'C');
			$pdf->SetXY(60, 43);
			$pdf->MultiCell(25,5,"Límites",1,'C');
			$pdf->SetXY(60, 48);
			$pdf->MultiCell(12.5,5,"LIE",1,'C');
			$pdf->SetXY(72.5, 48);
			$pdf->MultiCell(12.5,5,"LSE",1,'C');
			$pdf->SetXY(85, 43);
			$pdf->MultiCell(12,3.33,"Fecha de\nprueba",1,'C');
			$pdf->SetFont('Arial','B',7);
			$pdf->SetXY(97, 43);
			$pdf->MultiCell(12,5,"Cantid. \nprobada",1,'C');
			$pdf->SetFont('Arial','B',7.5);
			$pdf->SetXY(109, 43);
			$pdf->MultiCell(80,5,"Resultados de la Prueba del Surtidor (Fecha)",1,'C');
			$pdf->SetXY(109, 48);
			$pdf->MultiCell(40,5,"Por el Surtidor",1,'C');
			$pdf->SetXY(149, 48);
			$pdf->MultiCell(40,5,"Por el Cliente",1,'C');
			$pdf->SetXY(189, 43);
			$pdf->MultiCell(8,10,"OK",1,'C');
			$pdf->SetXY(197, 43);
			$pdf->MultiCell(8,5,"No OK",1,'C');
		}
		$tam1[0]=flinha("$res[descricao] - $res[espec]",55);	
		$tam1[1]=flinha("$res[lie] / $res[lse]",25);
		$tam1[2]=flinha("$data_teste",13);
		$tam1[3]=flinha("$res[quant_test]",12);
		$tam1[4]=1;
		$tam1[5]=flinha($res["forn"],40);
		if($tam1[5]==0){$tam1[5]=1;}
		$tam1[6]=flinha($res["cli"],40);
		if($tam1[6]==0){$tam1[6]=1;}
		$tam1[7]=1;
		$maxu=max($tam1);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxu - $tam1[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(5,$y);
		$pdf->MultiCell(55,$w,"$res[descricao] - $res[espec]",0);
		if(!empty($res["lie"])){
			$pdf->SetXY(60,$y);
			$pdf->MultiCell(12.5,$w,"$res[lie]",0,'C');
		}
		if(!empty($res["lse"])){
			$pdf->SetXY(72.5,$y);
			$pdf->MultiCell(12.5,$w,"$res[lie]",0,'C');
		}
		if(!empty($res["data_t"])){
			$data_teste=banco2data($res["data_t"]);
			$pdf->SetXY(84.5,$y);
			$pdf->MultiCell(13,$w,"$data_teste",0,'C');
		}
		if(!empty($res["quant_test"])){
			$pdf->SetXY(97,$y);
			$pdf->MultiCell(12,$w,"$res[quant_test]",0,'C');
		}
		$pdf->SetXY(109, $y);
		$pdf->MultiCell(40,$w,$res["forn"],0);
		$pdf->SetXY(149, $y);
		$pdf->MultiCell(40,$w,$res["cli"],0);
		$pdf->SetXY(189, $y);
		if($res["ok"]=="S"){$ok="X";}else{$ok="";}
		$pdf->MultiCell(8,$w,$ok,0,'C');
		if($res["ok"]=="N"){$ok="X";}else{$ok="";}
		$pdf->SetXY(197, $y);
		$pdf->MultiCell(8,$w,$ok,0,'C');
		$y=($maxu*5)+$y;
		$pdf->Line(5,$y,205,$y);
		$pdf->Line(5,253,205,253);
		// linhas das colunas
		$pdf->Line(5,53,5,253);
		$pdf->Line(60,53,60,253);
		$pdf->Line(72.5,53,72.5,253);
		$pdf->Line(85,53,85,253);
		$pdf->Line(97,53,97,253);
		$pdf->Line(109,53,109,253);
		$pdf->Line(149,53,149,253);		
		$pdf->Line(189,53,189,253);
		$pdf->Line(197,53,197,253);
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
$pdf->MultiCell(20,5,"CFG-1004",'C');

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
