<?php

$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_fmeaproj WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

$pdf->AddPage('L');
$numero=$res["numero"];
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetXY(5, 1);
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(5, 3);
$pdf->MultiCell(290,5,"DESIGN FAILURE MODE AND EFFECTS ANALYSIS",0,'C');

$pdf->SetFont('Arial','',8);
$cliente=$res[pecacli];
$rev=$res[niveleng]." - ".banco2data($res["dteng"]);
$peca=$res[nome];
$fmea=$resp[numero];
$pg=1;
$pdf->SetXY(260, 5);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(5, 18);
$pdf->MultiCell(50,4,"Part Number(Customer) \n $cliente",1);
$pdf->SetXY(55, 18);
$pdf->MultiCell(50,4,"Drawing Revision / Date \n $rev",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(80,4,"Part Name \n $peca",1);
$pdf->SetXY(185, 18);
$pdf->MultiCell(105,4,"FMEA Number \n $fmea",1);
//linha 2
$pdf->SetXY(5, 26);
$pdf->MultiCell(100,4,"Prepared By \n $resp[prep]",1);
$pdf->SetXY(105, 26);
$pdf->MultiCell(80,4,"Design Responsability \n $resp[resp]",1);
$pdf->SetXY(185, 26);
$pdf->MultiCell(105,4,"Customer \n $res[nomecli]",1);
//linha3
$pdf->SetXY(5, 34);
$pdf->MultiCell(100,4,"Supplier \n $rese[razao]",1);
$pdf->SetXY(105, 34);
$pdf->MultiCell(80,4,"Product Identification \n ",1);
$pdf->SetXY(185, 34);
$pdf->MultiCell(105,4,"Part Number / Revision(Supplier) \n $res[numero] - $res[rev]",1);
//linha4
$pdf->SetXY(5, 42);
$pdf->MultiCell(180,4,"Core Team \n $resp[equipe] ",1);
$pdf->SetXY(185, 42);
$pdf->MultiCell(75,4,"Approved By \n $resp[quem]",1);
$pdf->SetXY(260, 42);
$pdf->MultiCell(30,4,"Date \n ".banco2data($resp["dtquem"])."",1);
//linha5
$pdf->SetXY(5, 50);
$pdf->MultiCell(180,4,"Remarks \n $resp[obs]",1);
$pdf->SetXY(185, 50);
$pdf->MultiCell(37.5,4,"Start Date \n ".banco2data($resp["ini"])."",1);
$pdf->SetXY(222.5, 50);
$pdf->MultiCell(37.5,4,"Revision Date \n ".banco2data($resp["rev"])."",1);
$pdf->SetXY(260, 50);
$pdf->MultiCell(30,4,"Key Date \n ".banco2data($resp["chv"])."",1);
//linha6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 60);
$pdf->MultiCell(19,4," \n Item or Function \n \n ",1,'C');
$pdf->SetXY(24, 60);
$pdf->MultiCell(22,4," \n Potential Failure Mode \n \n ",1,'C');
$pdf->SetXY(46, 60);
$pdf->MultiCell(35,4," \n Potential Effects(s) of Failure \n \n ",1,'C');
$pdf->SetXY(81, 60);
$pdf->MultiCell(4,4,"Serve",1);
$pdf->SetXY(85, 60);
$pdf->MultiCell(4,4,"Class",1);
$pdf->SetXY(89, 60);
$pdf->MultiCell(28,4," \n Potential Cause(s) Mechanisms of Failure \n ",1,'C');
$pdf->SetXY(117, 60);
$pdf->MultiCell(4,4,"Ocorr",1,'C');
$pdf->SetXY(121, 60);
$pdf->MultiCell(70,4," \n Actual Projects Control \n ",1,'C');
$pdf->SetXY(121, 72);
$pdf->MultiCell(35,8,"Prevention",1,'C');
$pdf->SetXY(156, 72);
$pdf->MultiCell(35,8,"Detection",1,'C');
$pdf->SetXY(191, 60);
$pdf->MultiCell(4,4,"Detec",1,'C');
$pdf->SetXY(195, 60);
$pdf->MultiCell(6,4,"   N P R   ",1,'C');
$pdf->SetXY(201, 60);
$pdf->MultiCell(24,4," \n Recommended Action \n \n ",1,'C');
$pdf->SetXY(225, 60);
$pdf->MultiCell(24,4," \n Responsability and Completion Date \n ",1,'C');
$pdf->SetXY(249, 60);
$pdf->MultiCell(41,4,"Action Results",1,'C');
$pdf->SetXY(249, 64);
$pdf->MultiCell(23,4," \n Action Taken \n \n ",1,'C');
$pdf->SetXY(272, 64);
$pdf->MultiCell(4,4,"Serv",1,'C');
$pdf->SetXY(276, 64);
$pdf->MultiCell(4,4,"Ocor",1,'C');
$pdf->SetXY(280, 64);
$pdf->MultiCell(4,4,"Dete",1,'C');
$pdf->SetXY(284, 64);
$pdf->MultiCell(6,4,"  N P R   ",1,'C');
$pdf->SetFont('Arial','',8);

//linha 7 preenchimento dos dados
$sql=mysql_query("SELECT fmea1.*,op.descricao FROM apqp_op AS op, apqp_fmeaproj AS fmea, apqp_fmeaproji AS fmea1 WHERE fmea.peca='$pc' AND fmea.id=fmea1.fmea AND fmea1.item=op.id ORDER BY op.descricao ASC");
if(mysql_num_rows($sql)){
	$opnum="";
	$y=80;
	$tam="";
	while($res=mysql_fetch_array($sql)){
		//calculando o tamanho dos campos
		$ope=mysql_query("select * from apqp_op where id=$res[item]")or erp_db_fail();
		$ope_tb=mysql_fetch_array($ope);
		if($opera==$ope_tb["descricao"]){
			$show=" ";
			$pdf->Line(24,$y,290,$y);
		}else{
			$show=$ope_tb["numero"]." - ".$ope_tb["descricao"];
			$pdf->SetLineWidth(0.5);
			$pdf->Line(5.5,$y,289.5,$y);
			$pdf->SetLineWidth(0.2);
		}
		$opera=$ope_tb["descricao"];
		$tam[0]=flinha($show,13);
		if($tam[0]==0){$tam[0]=1;}
		$tam[1]=flinha($res["modo"],16);
		if($tam[1]==0){$tam[1]=1;}
		$tam[2]=flinha($res["efeitos"],24);
		if($tam[2]==0){$tam[2]=1;}
		$tam[3]=flinha($res["sev"],1);
		if($tam[3]==0){$tam[3]=1;}
		$tam[4]=1;
		$tam[5]=flinha($res["causa"],18);
		if($tam[5]==0){$tam[5]=1;}
		$tam[6]=flinha($res["ocor"],1);
		if($tam[6]==0){$tam[6]=1;}
		$tam[7]=flinha($res["controle"],24);
		if($tam[7]==0){$tam[7]=1;}
		$tam[8]=flinha($res["controle2"],24);
		if($tam[8]==7){
			$tam[8]=5;
		}
		if($tam[8]==0){$tam[8]=1;}
		$tam[9]=flinha($res["det"],1);
		if($tam[9]==0){$tam[9]=1;}
		$tam[10]=flinha($res["npr"],2);
		if($tam[10]==0){$tam[10]=1;}
		$tam[11]=flinha($res["ar"],14);
		if($tam[11]==0){$tam[11]=1;}
		$tam[12]=flinha($res["resp"]." / ".banco2data($res["prazo"]),14);
		if($tam[12]==0){$tam[12]=1;}
		$tam[13]=flinha($res["at"],14);
		if($tam[13]==0){$tam[13]=1;}
		$tam[14]=flinha($res["sev2"],1);
		if($tam[14]==0){$tam[14]=1;}
		$tam[15]=flinha($res["ocor2"],1);
		if($tam[15]==0){$tam[15]=1;}
		$tam[16]=flinha($res["det2"],1);
		if($tam[16]==0){$tam[16]=1;}
		$tam[17]=flinha($res["npr2"],1);
		if($tam[17]==0){$tam[17]=1;}
		$max=max($tam);
		for($i=0;$i<=17;$i++){
			$ql[$i]=$max - $tam[$i];
		}
		//verificando tamanho da linha
		$maxi=$max*4;
		$total=$y + $maxi;
		if($total>=185){
		 $y=191;
		}
		$w=4;
		//adicionando uma nova página
		if($y>=185){
				// desenvolvedor
				$pdf->SetFont('Arial','B',5);  
				$pdf->SetXY(250,182.5);
				$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
			$y=48;
			$pdf->AddPage('L');
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetFont('Arial','B',14);
			$pdf->SetXY(5, 5);
			$pdf->MultiCell(290,5,"DESIGN FAILURE MODE AND EFFECTS ANALYSIS",0,'C');
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pg++;
			$pdf->MultiCell(50,4,"Part Number(Customer) \n $cliente",1);
			$pdf->SetXY(55, 18);
			$pdf->MultiCell(50,4,"Drawing Revision / Date \n $rev",1);
			$pdf->SetXY(105, 18);
			$pdf->MultiCell(80,4,"Part Name \n $peca",1);
			$pdf->SetXY(185, 18);
			$pdf->MultiCell(105,4,"FMEA Number \n $fmea",1);
			$pdf->SetXY(260, 5);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(40,5,"PPAP Nº $numero \n Page: $pg");
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(19,4," \n Item or Function \n \n ",1,'C');
			$pdf->SetXY(24, 28);
			$pdf->MultiCell(22,4," \n Potential Failure Mode \n \n ",1,'C');
			$pdf->SetXY(46, 28);
			$pdf->MultiCell(35,4," \n Potential Effects(s) of Failure \n \n ",1,'C');
			$pdf->SetXY(81, 28);
			$pdf->MultiCell(4,4,"Serve",1);
			$pdf->SetXY(85, 28);
			$pdf->MultiCell(4,4,"Class",1);
			$pdf->SetXY(89, 28);
			$pdf->MultiCell(28,4," \n Potential Cause(s) Mechanisms of Failure \n ",1,'C');
			$pdf->SetXY(117, 28);
			$pdf->MultiCell(4,4,"Ocorr",1,'C');
			$pdf->SetXY(121, 28);
			$pdf->MultiCell(70,4," \n Actual Projects Control \n ",1,'C');
			$pdf->SetXY(121, 40);
			$pdf->MultiCell(35,8,"Prevenction",1,'C');
			$pdf->SetXY(156, 40);
			$pdf->MultiCell(35,8,"Detection",1,'C');
			$pdf->SetXY(191, 28);
			$pdf->MultiCell(4,4,"Detec",1,'C');
			$pdf->SetXY(195, 28);
			$pdf->MultiCell(6,4,"   N P R   ",1,'C');
			$pdf->SetXY(201, 28);
			$pdf->MultiCell(24,4," \n Recommended Action \n \n ",1,'C');
			$pdf->SetXY(225, 28);
			$pdf->MultiCell(24,4," \n Responsability and Completion Date \n ",1,'C');
			$pdf->SetXY(249, 28);
			$pdf->MultiCell(41,4,"Action Results",1,'C');
			$pdf->SetXY(249, 32);
			$pdf->MultiCell(23,4," \n Action Taken \n \n ",1,'C');
			$pdf->SetXY(272, 32);
			$pdf->MultiCell(4,4,"Serv",1,'C');
			$pdf->SetXY(276, 32);
			$pdf->MultiCell(4,4,"Ocor",1,'C');
			$pdf->SetXY(280, 32);
			$pdf->MultiCell(4,4,"Dete",1,'C');
			$pdf->SetXY(284, 32);
			$pdf->MultiCell(6,4,"  N P R   ",1,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->Line(5,48,5,185);
			$pdf->Line(24,48,24,185);
			$pdf->Line(46,48,46,185);
			$pdf->Line(81,48,81,185);
			$pdf->Line(85,48,85,185);
			$pdf->Line(89,48,89,185);
			$pdf->Line(117,48,117,185);
			$pdf->Line(121,48,121,185);
			$pdf->Line(156,48,156,185);
			$pdf->Line(191,48,191,185);
			$pdf->Line(195,48,195,185);
			$pdf->Line(201,48,201,185);
			$pdf->Line(225,48,225,185);
			$pdf->Line(249,48,249,185);
			$pdf->Line(272,48,272,185);
			$pdf->Line(276,48,276,185);
			$pdf->Line(280,48,280,185);
			$pdf->Line(284,48,284,185);
			$pdf->Line(290,48,290,185);
			$pdf->Line(5,185,290,185);

		}else{
			$pdf->Line(5,80,5,185);
			$pdf->Line(24,80,24,185);
			$pdf->Line(46,80,46,185);
			$pdf->Line(81,80,81,185);
			$pdf->Line(85,80,85,185);
			$pdf->Line(89,80,89,185);
			$pdf->Line(117,80,117,185);
			$pdf->Line(121,80,121,185);
			$pdf->Line(156,80,156,185);
			$pdf->Line(191,80,191,185);
			$pdf->Line(195,80,195,185);
			$pdf->Line(201,80,201,185);
			$pdf->Line(225,80,225,185);
			$pdf->Line(249,80,249,185);
			$pdf->Line(272,80,272,185);
			$pdf->Line(276,80,276,185);
			$pdf->Line(280,80,280,185);
			$pdf->Line(284,80,284,185);
			$pdf->Line(290,80,290,185);
			$pdf->Line(5,185,290,185);
		}
		if($res["item"]==$opnum){
			$res["descricao"]=" ";
		}else{
			$opnum=$res["item"];
		}
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(19,4,$show,0,'C');
		$pdf->SetXY(24, $y);
		$pdf->MultiCell(22,4,$res["modo"],0,'C');
		$pdf->SetXY(46, $y);
		$pdf->MultiCell(35,4,$res["efeitos"],0,'C');
		$pdf->SetXY(81, $y);
		$pdf->MultiCell(4,4,$res["sev"],0);
		$pdf->SetXY(85, $y);
		$ym=$y+1;
		if(!empty($res["icone"])){ 
			$fig="apqp_fluxo/$res[icone].jpg";
			$pdf->Image($fig,86,$y,3,3);
		}
		
		$pdf->MultiCell(4,4,"");
		$pdf->SetXY(89, $y);
		$pdf->MultiCell(28,4,$res["causa"],0,'C');
		$pdf->SetXY(117, $y);
		$pdf->MultiCell(4,4,$res["ocor"],0,'C');
		$pdf->SetXY(121, $y);
		$pdf->MultiCell(35,4,$res["controle"],0,'C');
		$pdf->SetXY(156, $y);
		$pdf->MultiCell(35,4,$res["controle2"],0,'C');
		$pdf->SetXY(191, $y);
		$pdf->MultiCell(4,4,$res["det"],0,'C');
		$pdf->SetXY(195, $y);
		$pdf->MultiCell(6,4,$res["npr"],0,'C');
		$pdf->SetXY(201, $y);
		$pdf->MultiCell(24,4,$res["ar"],0,'C');
		$pdf->SetXY(225, $y);
		$pdf->MultiCell(24,4,$res["resp"]." / ".banco2data($res["prazo"]).$tam[12],0,'C');
		$pdf->SetXY(249, $y);
		$pdf->MultiCell(23,4,$res["at"],0);
		$pdf->SetXY(272, $y);
		$pdf->MultiCell(4,4,$res["sev2"],0,'C');
		$pdf->SetXY(276, $y);
		$pdf->MultiCell(4,4,$res["ocor2"],0,'C');
		$pdf->SetXY(280, $y);
		$pdf->MultiCell(4,4,$res["det2"],0,'C');
		$pdf->SetXY(284, $y);
		$pdf->MultiCell(6,4,$res["npr2"],0,'C');
		$yi=$y;
		$y=($max*4)+$y;
		$yf=$y;
	}
//em baixo rodape
$pdf->SetFont('Arial','B',5);  
$pdf->SetXY(252,182.90);
$pdf->MultiCell(50,7,"Powered by www.qualitymanager.com.br");
}
?>
