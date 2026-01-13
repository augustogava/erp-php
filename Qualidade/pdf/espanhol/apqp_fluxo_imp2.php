<?php
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(60);
$pdf->Cell(0, 18, 'DIAGRAMA DE FLUJO DEL PROCESO');

$pdf->SetFont('Arial','',8);

$cliente=$res["nomecli"];
$peca=$res["pecacli"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$razao=$rese["razao"];
$nome=$res["nome"];
$data=banco2data($res["crono_dtquem"]);
$num2=$res[numero]." - ".$res[rev];
$crono=$res["crono_quem"];
$numero=$res["numero"];

$sel=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' AND ativ='Diagrama de Fluxo'"); $sele=mysql_fetch_array($sel); if(!empty($sele["resp"])){  $quem=$sele["resp"]; }else{ } 
$quem=$sele["resp"];
$dtquem=banco2data($sele["fim"]);
$pdf->SetXY(180, 5);
$pg=1;
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->SetXY(5, 18);
$pdf->MultiCell(100,5,"Cliente \n ",1);
$pdf->SetXY(5, 23);
$pdf->MultiCell(100,5,"$cliente");
$pdf->SetXY(105, 18);
$pdf->MultiCell(50,5,"Número de la Pieza (cliente) \n ",1);
$pdf->SetXY(105, 23);
$pdf->MultiCell(50,5,"$peca");
$pdf->SetXY(155, 18);
$pdf->MultiCell(50,5,"Revision/Fecha del Plano \n ",1);
$pdf->SetXY(155, 23);
$pdf->MultiCell(50,5,"$rev");
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(100,5,"Proveedor\n $razao",1);
$pdf->SetXY(105, 28);
$pdf->MultiCell(100,5,"Nombre de la Pieza \n $nome",1);
//linha 3
$pdf->SetXY(5, 38);
$pdf->MultiCell(100,5,"Aprobado por \n $quem",1);
$pdf->SetXY(105, 38);
$pdf->MultiCell(50,5,"Fecha \n $dtquem",1);
$pdf->SetXY(155, 38);
$pdf->MultiCell(50,5,"Número / Rev. Pieza(Proveedor) \n $num2",1);
//linha 4
$pdf->Image('imagens/op_1.jpg',8,51,6,6);
$pdf->SetXY(15, 50);
$pdf->MultiCell(30,10,"Operación");
$pdf->Image('imagens/op_2.jpg',38,51,6,6);
$pdf->SetXY(45, 50);
$pdf->MultiCell(40,10,"Operación con Inspeción");
$pdf->Image('imagens/op_3.jpg',78,51,6,6);
$pdf->SetXY(85, 50);
$pdf->MultiCell(30,10,"Inspeción");
$pdf->Image('imagens/op_4.jpg',108,51,6,6);
$pdf->SetXY(115, 50);
$pdf->MultiCell(30,10,"Demora");
$pdf->Image('imagens/op_5.jpg',138,51,6,6);
$pdf->SetXY(145, 50);
$pdf->MultiCell(30,10,"Transporte");
$pdf->Image('imagens/op_6.jpg',168,51,6,6);
$pdf->SetXY(175, 50);
$pdf->MultiCell(30,10,"Decisión");
//linha 5
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 60);
$pdf->MultiCell(30,10,"Flujo",1,'C');
$pdf->SetXY(35, 60);
$pdf->MultiCell(20,10,"Nº Ope.",1,'C');
$pdf->SetXY(55, 60);
$pdf->MultiCell(70,10,"Descripción del Operación",1,'C');
$pdf->SetXY(125, 60);
$pdf->MultiCell(80,10,"Obervaciones",1,'C');

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
	
$y=70;
$sql=mysql_query("SELECT * FROM apqp_fluxo WHERE peca='$pc' ORDER BY ordem ASC");
//print "SELECT * FROM apqp_fluxo WHERE peca='$pc' ORDER BY ordem ASC";
if(mysql_num_rows($sql)){
	while($res=mysql_fetch_array($sql)){
		unset($resop);
		if($res["op"]){
			$sqlop=mysql_query("SELECT * FROM apqp_op WHERE id='".$res["op"]."'");
			if(mysql_num_rows($sqlop)){
				$resop=mysql_fetch_array($sqlop);
			}
		}
		$tam2[0]=1;
		$tam2[1]=ceil(strlen($resop["numero"])/8);
		if($tam2[1]==0){$tam2[1]=1;}
		$tam2[2]=ceil(strlen($resop["descricao"])/40);
		if($tam2[2]==0){$tam2[2]=1;}
		$tam2[3]=ceil(strlen($resop["obs"])/50);
		if($tam2[3]==0){$tam2[3]=1;}
		$maxa=max($tam2);
		for($i=0;$i<=3;$i++){
			if($tam[$i]==1){
				$ql[$i]=1;
			}else{
				$ql[$i]=$maxa - $tam2[$i];
			}
		}
		if($y>=265){
			$maxi=$maxa*5;
			$y=70;
			$pg++;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(5, 1);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(70);
			$pdf->Cell(0, 18, 'DIAGRAMA DE FLUJO DEL PROCESO');
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(5, 18);
			$pdf->MultiCell(100,5,"Cliente \n ",1);
			$pdf->SetXY(180, 8);
			$pdf->MultiCell(65,5,"Página: $pg");
			$pdf->SetXY(5, 23);
			$pdf->MultiCell(100,5,"$cliente");
			$pdf->SetXY(105, 18);
			$pdf->MultiCell(50,5,"Número de la Pieza (cliente) \n ",1);
			$pdf->SetXY(105, 23);
			$pdf->MultiCell(50,5,"$peca");
			$pdf->SetXY(155, 18);
			$pdf->MultiCell(50,5,"Revision/Fecha del Plano \n ",1);
			$pdf->SetXY(155, 23);
			$pdf->MultiCell(50,5,"$rev");
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(100,5,"Proveedor\n $razao",1);
			$pdf->SetXY(105, 28);
			$pdf->MultiCell(100,5,"Nombre de la Pieza \n $nome",1);
			//linha 3
			$pdf->SetXY(5, 38);
			$pdf->MultiCell(100,5,"Aprobado por \n $quem",1);
			$pdf->SetXY(105, 38);
			$pdf->MultiCell(50,5,"Fecha \n $dtquem",1);
			$pdf->SetXY(155, 38);
			$pdf->MultiCell(50,5,"Número / Rev. Pieza(Proveedor) \n $num2",1);
			//linha 4
			$pdf->Image('imagens/op_1.jpg',8,51,6,6);
			$pdf->SetXY(15, 50);
			$pdf->MultiCell(30,10,"Operación");
			$pdf->Image('imagens/op_2.jpg',38,51,6,6);
			$pdf->SetXY(45, 50);
			$pdf->MultiCell(40,10,"Operación con Inspeción");
			$pdf->Image('imagens/op_3.jpg',78,51,6,6);
			$pdf->SetXY(85, 50);
			$pdf->MultiCell(30,10,"Inspeción");
			$pdf->Image('imagens/op_4.jpg',108,51,6,6);
			$pdf->SetXY(115, 50);
			$pdf->MultiCell(30,10,"Demora");
			$pdf->Image('imagens/op_5.jpg',138,51,6,6);
			$pdf->SetXY(145, 50);
			$pdf->MultiCell(30,10,"Transporte");
			$pdf->Image('imagens/op_6.jpg',168,51,6,6);
			$pdf->SetXY(175, 50);
			$pdf->MultiCell(30,10,"Decisión");
			//linha 5
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, 60);
			$pdf->MultiCell(30,10,"Flujo",1,'C');
			$pdf->SetXY(35, 60);
			$pdf->MultiCell(20,10,"Nº Ope.",1,'C');
			$pdf->SetXY(55, 60);
			$pdf->MultiCell(70,10,"Descripción del Operación",1,'C');
			$pdf->SetXY(125, 60);
			$pdf->MultiCell(80,10,"Obervaciones",1,'C');
		}
		$w=5;
		if($res["fluxo1"]=="op_" and $res["fluxo2"]=="op_"  and empty($res["op"])){
			break;
		}
		if(empty($res["fluxo1"])) $msg="N";
		if(empty($res["fluxo2"])) $msg1="N";
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(30,$w,"".qlinha($ql[0]),0);
		if($msg!="N"){
			$xm=10; 
			$ym=$y+1;
			$pdf->Image('imagens/'.$res["fluxo1"].'.jpg',$xm,$ym,6,6);
		}
		if($msg1!="N"){
			$xm=20; 
			$ym=$y+1;
			$pdf->Image('imagens/'.$res["fluxo2"].'.jpg',$xm,$ym,6,6);
		}
		$pdf->SetXY(35, $y);
		$pdf->MultiCell(20,$w,$resop["numero"].qlinha($ql[0]),0,'C');
		$pdf->SetXY(55, $y);
		$pdf->MultiCell(70,$w,$resop["descricao"].qlinha($ql[0]),0);
		$pdf->SetXY(125, $y);
		$pdf->MultiCell(80,$w,$resop["obs"].qlinha($ql[0]),0);
		$yi=$y;
		$y=$y+($maxa*5)+5;
		//linhas verticais
		$pdf->Line(5,$yi,5,$y);
		$pdf->Line(205,$yi,205,$y);
		$pdf->Line(35,$yi,35,$y);
		$pdf->Line(55,$yi,55,$y);
		$pdf->Line(35,$yi,35,$y);
		$pdf->Line(125,$yi,125,$y);
	}
	$yi=$y;
	//linhas verticais final
	$pdf->Line(205,$y,205,$yi);
	$pdf->Line(5,$y,5,$yi);
	$pdf->Line(35,$y,35,$yi);
	$pdf->Line(55,$y,55,$yi);
	$pdf->Line(35,$y,35,$yi);
	$pdf->Line(125,$y,125,$yi);

	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
}
$pdf->Line(205,70,205,270);
$pdf->Line(5,70,5,270);
$pdf->Line(35,70,35,270);
$pdf->Line(55,70,55,270);
$pdf->Line(35,70,35,270);
$pdf->Line(125,70,125,270);
$pdf->Line(5,270,205,270);

//fim
?>
