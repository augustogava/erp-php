<?php

$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_ende WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage();
$pg=1;
$razao=$rese["razao"];
$peca=$res["pecacli"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$local=$resp["local"];
$num=$res["numero"]." - ".$res["rev"];
$nome=$res["nome"];

$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(35,5);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(200,5,"Aprobación de Piezas para Produción Resultado de las Pruebas de Funcionamento",'C');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 8);
$pdf->MultiCell(40,5,"PPAP Nº $res[numero] \n Página: $pg");
$pdf->SetXY(180, 8);
$pdf->MultiCell(40,5,"");
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,5,"Proveedor \n $razao",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,5,"Número de la Pieza (cliente) \n $peca",1);
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,5,"Revision/Fecha del Plano \n $rev",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(50,5,"Nombre del Laboratorio \n $local",1);
$pdf->SetXY(55, 28);
$pdf->MultiCell(50,5,"Número/Rev. Pieza(Proveedor) \n $num",1);
$pdf->SetXY(105, 28);
$pdf->MultiCell(100,5,"Nombre de la Pieza \n $nome",1);
//linha 3
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(5, 40);
$pdf->MultiCell(10,5,"Car. Nº",1,'C');
$pdf->SetXY(15, 40);
$pdf->MultiCell(15,10,"Ref. Nº",1,'C');
$pdf->SetXY(30, 40);
$pdf->MultiCell(75,10,"Requisitos",1,'C');
$pdf->SetXY(105, 40);
$pdf->MultiCell(15,5,"Frec. Pruebas",1,'C');
$pdf->SetXY(120, 40);
$pdf->MultiCell(10,5,"Cant. Prob.",1,'C');
$pdf->SetXY(130, 40);
$pdf->MultiCell(55,5,"Resultados Y Condiciones de las Pruebas del Proveedor ",1,'C');
$pdf->SetXY(185, 40);
$pdf->MultiCell(10,10,"OK",1,'C');
$pdf->SetXY(195, 40);
$pdf->MultiCell(10,5,"No\nOK",1,'C');

//linha 4
$sql2=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo FROM apqp_car AS car, apqp_ende AS ensaio, apqp_endel AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio");
$y=50;
if(mysql_num_rows($sql2)){
	while($res2=mysql_fetch_array($sql2)){
		if($y>=250){
			$y=50;
			$pg++;
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(35,5);
			$pdf->SetFont('Arial','B',10);
			$pdf->MultiCell(200,5,"Aprobación de Piezas para Produción Resultado de las Pruebas de Funcionamento",'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 8);
			$pdf->SetXY(180, 8);
			$pdf->MultiCell(40,5,"PPAP Nº $res[numero] \n Página: $pg");			
			$pdf->MultiCell(40,5,"");
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(100,5,"Proveedor \n $razao",1);
			$pdf->SetXY(105, 18);
			$pdf->MultiCell(50,5,"Número de la Pieza (cliente) \n $peca",1);
			$pdf->SetXY(155, 18);
			$pdf->MultiCell(50,5,"Revision/Fecha del Plano \n $rev",1);
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(50,5,"Nombre del Laboratorio \n $local",1);
			$pdf->SetXY(55, 28);
			$pdf->MultiCell(50,5,"Número/Rev. Pieza(Proveedor) \n $num",1);
			$pdf->SetXY(105, 28);
			$pdf->MultiCell(100,5,"Nombre de la Pieza \n $nome",1);
			//linha 3
			$pdf->SetFont('Arial','B',7);
			$pdf->SetXY(5, 40);
			$pdf->MultiCell(10,5,"Car. Nº",1,'C');
			$pdf->SetXY(15, 40);
			$pdf->MultiCell(15,10,"Ref. Nº",1,'C');
			$pdf->SetXY(30, 40);
			$pdf->MultiCell(75,10,"Requisitos",1,'C');
			$pdf->SetXY(105, 40);
			$pdf->MultiCell(15,5,"Freq. Pruebas",1,'C');
			$pdf->SetXY(120, 40);
			$pdf->MultiCell(10,5,"Cant. Prob.",1,'C');
			$pdf->SetXY(130, 40);
			$pdf->MultiCell(55,5,"Resultados Y Condiciones de las Pruebas del Proveedor ",1,'C');
			$pdf->SetXY(185, 40);
			$pdf->MultiCell(10,10,"OK",1,'C');
			$pdf->SetXY(195, 40);
			$pdf->MultiCell(10,5,"No\nOK",1,'C');
		}
		$tama[0]=flinha($res2["numero"],10);
		if($tama[0]==0){$tama[0]=1;}
		$tam1[1]=flinha($res2["ref"],15);
		if($tama[1]==0){$tama[1]=1;}
		$tama[2]=flinha($res2["descricao"]." - ".$res2["espec"],75);
		if($tama[2]==0){$tama[2]=1;}
		$tama[3]=flinha($res2["freq"],15);
		if($tama[3]==0){$tama[3]=1;}
		$tama[4]=flinha($res2["qtd"],10);
		if($tam[4]==0){$tama[4]=1;}
		$tama[5]=flinha($res2["forn"],55);
		if($tama[5]==0){$tama[5]=1;}
		$maxu=max($tama);
		for($i=0;$i<=5;$i++){
			$ql[$i]=$maxu - $tama[$i];
		}
		$w=5;
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(10,$w,"$res2[numero]",0,'C');
		$pdf->SetXY(15, $y);
		$pdf->MultiCell(15,$w,"$res2[ref]",0,'C');
		$pdf->SetXY(30, $y);
		$pdf->MultiCell(75,$w,"$res2[descricao] - $res2[espec]",0);
		$pdf->SetXY(105, $y);
		$pdf->MultiCell(15,$w,"$res2[freq]",0,'C');
		$pdf->SetXY(120, $y);
		$pdf->MultiCell(10,$w,"$res2[qtd]",0,'C');
		$pdf->SetXY(130, $y);
		$pdf->MultiCell(55,$w,"$res2[forn]",0);
		$pdf->SetXY(185, $y);
		if($res2["ok"]=="S"){$ok="X";}else{$ok=" ";}
		$pdf->MultiCell(10,$w,$ok,0,'C');
		if($res2["ok"]=="N"){$ok="X";}else{$ok=" ";}
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(10,$w,$ok,0,'C');
		$yi=$y;
		$y=($maxu*5)+$y;
		$pdf->Line(5,$y,205,$y);
		$pdf->Line(5,255,205,255);
		$pdf->Line(5,50,5,255);
		$pdf->Line(15,50,15,255);
		$pdf->Line(30,50,30,255);
		$pdf->Line(105,50,105,255);
		$pdf->Line(120,50,120,255);
		$pdf->Line(130,50,130,255);
		$pdf->Line(185,50,185,255);
		$pdf->Line(195,50,195,255);
		$pdf->Line(205,50,205,255);
		$pdf->Line(205,50,205,255);
	}
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
}
//ultima linha
$pdf->Line(5,255,205,255);
$pdf->Line(5,50,5,255);
$pdf->Line(15,50,15,255);
$pdf->Line(30,50,30,255);
$pdf->Line(105,50,105,255);
$pdf->Line(120,50,120,255);
$pdf->Line(130,50,130,255);
$pdf->Line(185,50,185,255);
$pdf->Line(195,50,195,255);
$pdf->Line(205,50,205,255);
$pdf->Line(205,50,205,255);
$y=260;
$pdf->SetFont('Arial','',7);
$pdf->SetXY(5, $y);
$pdf->MultiCell(82,5,"Aprobado Por \n $resp[quem]",1,'');
$pdf->SetXY(87, $y);
$pdf->MultiCell(20,5,"Fecha \n ".banco2data($resp["dtquem"])."",1);
$pdf->SetXY(107, $y);
$pdf->MultiCell(80,5,"Firma \n $resp[rep]",1,'');
$pdf->SetXY(187, $y);
$pdf->MultiCell(18,5,"Fecha \n ".banco2data($resp["dtrep"])."",1);

if($email=="sim"){
$pdf->Output('relatorio.pdf','I');
}
//fim
?>
