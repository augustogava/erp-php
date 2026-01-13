<?php
$npc=$_SESSION["npc"];
$tam="";
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$res=mysql_fetch_array($sql);
if(!mysql_num_rows($sql)) exit;
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_inst WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);
$sql=mysql_query("SELECT op.* FROM apqp_op AS op WHERE op.id='$resp[op]'");
if(mysql_num_rows($sql)) $resop=mysql_fetch_array($sql);
$id=$resp["id"];
$ope=$resop["numero"]." - ".$resop["descricao"];
$pecacli=$res["pecacli"];
$nome=$res["nome"];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$cliente=$res["nomecli"];
$razao=$rese["razao"];
$macloc=$resop["macloc"];
$prep=$resp["prep"];
$prep_dt=banco2data($resp["prep_data"]);
$quem=$resp["quem"];
$num=$resp["numero"]." - ".$resp["rev"];
$dtquem=banco2data($resp["dtquem"]);
$rev2=$resp["rev"];
$rev_alt=$resp["rev_alt"];
$rev_dt=banco2data($resp["rev_data"]);
$numero=$res["numero"];
$pdf->AddPage();
$pg=1;
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(180, 8);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(80);
$pdf->Cell(0, 18, 'OP'.$ope.'');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(75,5,"Número da Peça (cliente) \n $pecacli",1);
$pdf->SetXY(80, 18);
$pdf->MultiCell(85,5,"Nome da Peça \n $nome",1);
$pdf->SetXY(165, 18);
$pdf->MultiCell(40,5,"Rev. / Data do Desenho \n $rev",1);
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(75,5,"Cliente \n $cliente",1);
$pdf->SetXY(80, 28);
$pdf->MultiCell(125,5,"Fornecedor\n $razao",1);
//linha 3
$pdf->SetXY(5, 38);
$pdf->MultiCell(75,5,"Máquina/Local \n $macloc",1);
$pdf->SetXY(80, 38);
$pdf->MultiCell(85,5,"Preparado por \n $prep",1);
$pdf->SetXY(165, 38);
$pdf->MultiCell(40,5,"Data \n $prep_dt",1);
//linha 4
$pdf->SetXY(5, 48);
$pdf->MultiCell(75,5,"Aprovado por \n $quem",1);
$pdf->SetXY(80, 48);
$pdf->MultiCell(85,5,"Número/Rev. Peça (fornecedor) \n $num",1);
$pdf->SetXY(165, 48);
$pdf->MultiCell(40,5,"Data \n $dtquem",1);
//linha 5
$pdf->SetXY(5, 58);
$pdf->MultiCell(30,5,"Revisão Número \n $rev2",1);
$pdf->SetXY(35, 58);
$pdf->MultiCell(130,5,"Descrição das Alterações \n $rev_alt",1);
$pdf->SetXY(165, 58);
$pdf->MultiCell(40,5,"Data Efetivação  \n $rev_data",1);
	// desenvolvedor
	$pdf->SetFont('Arial','B',5);  
	$pdf->SetXY(168,269);
	$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
//linha6
$y=70;
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, $y);
$pdf->MultiCell(200,5,"PROCEDIMENTO",1,'C');
$pdf->SetFont('Arial','',8);
$y=$y+5;
$sql=mysql_query("SELECT * FROM apqp_instp WHERE inst='$resp[id]'");
if(mysql_num_rows($sql)){
	$l=mysql_num_rows($sql);
	if($l==0){$n=6;}else{$n=$l*7.2;}
	$pdf->SetXY(5, $y);
	$pdf->MultiCell(200,$n,"",1);
	$ym=$y+1;
	while($res=mysql_fetch_array($sql)){
		if($y>=255){
			$y=70;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(5, 1);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(80);
			$pdf->Cell(0, 18, 'OP'.$ope.'');
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(75,5,"Número da Peça (cliente) \n $pecacli",1);
			$pdf->SetXY(80, 18);
			$pdf->MultiCell(85,5,"Nome da Peça \n $nome",1);
			$pdf->SetXY(165, 18);
			$pdf->MultiCell(40,5,"Rev. / Data do Desenho \n $rev",1);
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(75,5,"Cliente \n $cliente",1);
			$pdf->SetXY(80, 28);
			$pdf->MultiCell(125,5,"Fornecedor\n $razao",1);
			//linha 3
			$pdf->SetXY(5, 38);
			$pdf->MultiCell(75,5,"Máquina/Local \n $macloc",1);
			$pdf->SetXY(80, 38);
			$pdf->MultiCell(85,5,"Preparado por \n $prep",1);
			$pdf->SetXY(165, 38);
			$pdf->MultiCell(40,5,"Data \n $prep_dt",1);
			//linha 4
			$pdf->SetXY(5, 48);
			$pdf->MultiCell(75,5,"Aprovado por \n $quem",1);
			$pdf->SetXY(80, 48);
			$pdf->MultiCell(85,5,"Número/Rev. Peça (fornecedor) \n $num",1);
			$pdf->SetXY(165, 48);
			$pdf->MultiCell(40,5,"Data \n $dtquem",1);
			//linha 5
			$pdf->SetXY(5, 58);
			$pdf->MultiCell(30,5,"Revisão Número \n $rev2",1);
			$pdf->SetXY(35, 58);
			$pdf->MultiCell(130,5,"Descrição das Alterações \n $rev_alt",1);
			$pdf->SetXY(165, 58);
			$pdf->MultiCell(40,5,"Data Efetivação  \n $rev_data",1);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, $y);
			$pdf->MultiCell(200,5,"PROCEDIMENTO",1,'C');
			$pdf->SetFont('Arial','',8);
		}
		unset($resop);
		if($res["op"]){
			$sqlop=mysql_query("SELECT * FROM apqp_op WHERE id='".$res["op"]."'");
			if(mysql_num_rows($sqlop)){
				$resop=mysql_fetch_array($sqlop);
			}
		}
		if(empty($res["fluxo1"])) $res["fluxo1"]="op_";
		if(empty($res["fluxo2"])) $res["fluxo2"]="op_";
		
		$pdf->Image("imagens/inst_$res[tipo].jpg",7,$ym,5,5);
		$pdf->SetFont('Arial','B',6);
		$pdf->SetXY(15, $y);
		$pdf->MultiCell(85,10,"$res[texto]");
		$y+=7;
		$ym=$ym+7;
	}
}
//linha 7
$y=$y+3;
$pdf->SetXY(5, $y);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(200,5,"CONTROLES",1,'C');
//linha 8
$y=$y+5;
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(5, $y);
$pdf->MultiCell(50,10,"Características",1,'C');
$pdf->SetXY(55, $y);
$pdf->MultiCell(5,5,"C E  ",1,'C');
$pdf->SetXY(60, $y);
$pdf->MultiCell(105,5,"Método",1,'C');
$pdf->SetXY(165, $y);
$pdf->MultiCell(40,5,"Plano de \n Reação  e \n Ações Corretivas ",1,'C');
//linha 9
$y=$y+5;
$pdf->SetXY(60, $y);
$pdf->MultiCell(30,5,"Tol. / Espec. do Prod. / Proc. ",1,'C');
$pdf->SetXY(90, $y);
$pdf->MultiCell(25,5,"Técnica de Aval. / Medição",1,'C');
$pdf->SetXY(115, $y);
$pdf->MultiCell(25,5,"Amostra",1,'C');
$pdf->SetXY(140, $y);
$pdf->MultiCell(25,5,"Método de Controle",1,'C');
//linha 10
$y=$y+5;
$pdf->SetXY(5, $y);
$pdf->MultiCell(6,5,"Nº",1,'C');
$pdf->SetXY(11, $y);
$pdf->MultiCell(44,5,"Descrição",1,'C');
$pdf->SetXY(115, $y);
$pdf->MultiCell(12,5,"Tam.",1,'C');
$pdf->SetXY(127, $y);
$pdf->MultiCell(13,5,"Freq.",1,'C');
$y+=5;

//linha 11
$pdf->SetFont('Arial','',7);
$sql=mysql_query("SELECT plano1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo FROM apqp_car AS car, apqp_instc AS plano1 WHERE plano1.car=car.id AND plano1.inst='$resp[id]'");
if(mysql_num_rows($sql)){
	$opnum="";
	while($res=mysql_fetch_array($sql)){
		if($y>=255){
			$y=70;
			$pg++;
			$pdf->AddPage();
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(168,269);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(180, 8);
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Página: $pg");
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetXY(5, 1);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(80);
			$pdf->Cell(0, 18, 'OP'.$ope.'');
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(75,5,"Número da Peça (cliente) \n $pecacli",1);
			$pdf->SetXY(80, 18);
			$pdf->MultiCell(85,5,"Nome da Peça \n $nome",1);
			$pdf->SetXY(165, 18);
			$pdf->MultiCell(40,5,"Rev. / Data do Desenho \n $rev",1);
			//linha 2
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(75,5,"Cliente \n $cliente",1);
			$pdf->SetXY(80, 28);
			$pdf->MultiCell(125,5,"Fornecedor\n $razao",1);
			//linha 3
			$pdf->SetXY(5, 38);
			$pdf->MultiCell(75,5,"Máquina/Local \n $macloc",1);
			$pdf->SetXY(80, 38);
			$pdf->MultiCell(85,5,"Preparado por \n $prep",1);
			$pdf->SetXY(165, 38);
			$pdf->MultiCell(40,5,"Data \n $prep_dt",1);
			//linha 4
			$pdf->SetXY(5, 48);
			$pdf->MultiCell(75,5,"Aprovado por \n $quem",1);
			$pdf->SetXY(80, 48);
			$pdf->MultiCell(85,5,"Número/Rev. Peça (fornecedor) \n $num",1);
			$pdf->SetXY(165, 48);
			$pdf->MultiCell(40,5,"Data \n $dtquem",1);
			//linha 5
			$pdf->SetXY(5, 58);
			$pdf->MultiCell(30,5,"Revisão Número \n $rev2",1);
			$pdf->SetXY(35, 58);
			$pdf->MultiCell(130,5,"Descrição das Alterações \n $rev_alt",1);
			$pdf->SetXY(165, 58);
			$pdf->MultiCell(40,5,"Data Efetivação  \n $rev_data",1);
			$pdf->SetXY(5, $y);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(200,5,"CONTROLES",1,'C');
			//linha 8
			$y=$y+5;
			$pdf->SetFont('Arial','B',7);
			$pdf->SetXY(5, $y);
			$pdf->MultiCell(50,10,"Características",1,'C');
			$pdf->SetXY(55, $y);
			$pdf->MultiCell(5,5,"C E  ",1,'C');
			$pdf->SetXY(60, $y);
			$pdf->MultiCell(105,5,"Método",1,'C');
			$pdf->SetXY(165, $y);
			$pdf->MultiCell(40,5,"Plano de \n Reação  e \n Ações Corretivas ",1,'C');
			//linha 9
			$y=$y+5;
			$pdf->SetXY(60, $y);
			$pdf->MultiCell(30,5,"Tol. / Espec. do Prod. / Proc. ",1,'C');
			$pdf->SetXY(90, $y);
			$pdf->MultiCell(25,5,"Técnica de Aval. / Medição",1,'C');
			$pdf->SetXY(115, $y);
			$pdf->MultiCell(25,5,"Amostra",1,'C');
			$pdf->SetXY(140, $y);
			$pdf->MultiCell(25,5,"Método de Controle",1,'C');
			//linha 10
			$y=$y+5;
			$pdf->SetXY(5, $y);
			$pdf->MultiCell(6,5,"Nº",1,'C');
			$pdf->SetXY(11, $y);
			$pdf->MultiCell(44,5,"Descrição",1,'C');
			$pdf->SetXY(115, $y);
			$pdf->MultiCell(12,5,"Tam.",1,'C');
			$pdf->SetXY(127, $y);
			$pdf->MultiCell(13,5,"Freq.",1,'C');
			$y+=5;
		}
		$pdf->SetFont('Arial','',6);
		$tam[0]=flinha($res["numero"],6);
		if($tam[0]==0){$tam[0]=1;}
		$tam[1]=flinha($res["descricao"],44);
		if($tam[1]==0){$tam[1]=1;}
		$tam[2]=flinha($res["espec"],30);
		if($tam[2]==0){$tam[2]=1;}
		$tam[3]=flinha($res["tecnicas"],25);
		if($tam[3]==0){$tam[3]=1;}
		$tam[4]=flinha($res["tamanho"],12);
		if($tam[4]==0){$tam[4]=1;}
		$tam[5]=flinha($res["freq"],13);
		if($tam[5]==0){$tam[5]=1;}
		$tam[6]=flinha($res["metodo"],25);
		if($tam[6]==0){$tam[6]=1;}
		$tam[7]=flinha($res["reacao"],40);
		if($tam[7]==0){$tam[7]=1;}
		$maxi=max($tam);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$maxi - $tam[$i];
		}
		if($res["opnum"]==$opnum){
			$res["opnum"]="&nbsp;";
			$res["opdesc"]="&nbsp;";
			$res["macloc"]="&nbsp;";
		}else{
			$opnum=$res["opnum"];
		}
		$ym=$y+1;
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(6,5,$res["numero"],0,'C');
		$pdf->SetXY(11, $y);
		$pdf->MultiCell(44,5,$res["descricao"].$tam[1],0,'C');
		if(empty($res["simbolo"])){ $img="imagens/quad.jpg"; }else{ $img="apqp_fluxo/$res[simbolo].jpg"; }
		$pdf->SetXY(55, $y);
		$pdf->Image($img,56,$ym,3,3);
		$pdf->MultiCell(10,5,"",0,'C');
		$pdf->SetXY(60, $y);
		$pdf->MultiCell(30,5,$res["espec"],0,'C');
		$pdf->SetXY(90, $y);
		$pdf->MultiCell(25,5,$res["tecnicas"],0,'C');
		$pdf->SetXY(115, $y);
		$pdf->MultiCell(12,5,$res["tamanho"],0,'C');
		$pdf->SetXY(127, $y);
		$pdf->MultiCell(13,5,$res["freq"],0,'C');
		$pdf->SetXY(140, $y);
		$pdf->MultiCell(25,5,$res["metodo"],0,'C');
		$pdf->SetXY(165, $y);
		$pdf->MultiCell(40,5,$res["reacao"],0,'C');
		$yi=$y;
		$y=$y+($maxi*5);
		$pdf->Line(5,$y,205,$y);
		$pdf->Line(5,$yi,5,$y);
		$pdf->Line(11,$yi,11,$y);
		$pdf->Line(55,$yi,55,$y);
		$pdf->Line(60,$yi,60,$y);
		$pdf->Line(90,$yi,90,$y);
		$pdf->Line(115,$yi,115,$y);
		$pdf->Line(127,$yi,127,$y);
		$pdf->Line(140,$yi,140,$y);
		$pdf->Line(165,$yi,165,$y);
		$pdf->Line(205,$yi,205,$y);
	}
}

$pdf->Line(205,70,205,270);
$pdf->Line(5,70,5,270);
$pdf->Line(5,270,205,270);
			
if($resp["desenho"]=="S"){
 	include('pdf/apqp_inst2_imp.php');
}
//fim
?>