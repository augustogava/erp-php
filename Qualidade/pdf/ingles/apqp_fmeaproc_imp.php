<?php
if(empty($tira)){
include('../../conecta.php');
require('fpdf.php');}

$pc=$_GET["pc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_fmeaproc WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

if(empty($tira)){$pdf=new FPDF('L');}

$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(5, 5);
$pdf->MultiCell(290,5,"FMEA DE PROCESSO",0,'C');
$pdf->SetXY(5, 18);
$pdf->SetFont('Arial','',8);
$cliente=$res[pecacli];
$rev=$res[rev]." - ".banco2data($res["dtrev"]);
$peca=$res[nome];
$fmea=$resp[numero];
$pg=$pdf->PageNo();
$pdf->MultiCell(50,4,"Número da Peça (cliente) \n $cliente",1);
$pdf->SetXY(55, 18);
$pdf->MultiCell(50,4,"Rev. / Data do Desenho \n $rev",1);
$pdf->SetXY(105, 18);
$pdf->MultiCell(80,4,"Nome da Peça \n $peca",1);
$pdf->SetXY(185, 18);
$pdf->MultiCell(75,4,"Número da FMEA \n $fmea",1);
$pdf->SetXY(260, 18);
$pdf->MultiCell(30,4,"Página \n $pg",1);
//linha 2
$pdf->SetXY(5, 26);
$pdf->MultiCell(100,4,"Preparado Por \n $resp[prep]",1);
$pdf->SetXY(105, 26);
$pdf->MultiCell(80,4,"Responsável Pelo Projeto \n $resp[resp]",1);
$pdf->SetXY(185, 26);
$pdf->MultiCell(105,4,"Cliente \n $res[nomecli]",1);
//linha3
$pdf->SetXY(5, 34);
$pdf->MultiCell(100,4,"Fornecedor \n $rese[razao]",1);
$pdf->SetXY(105, 34);
$pdf->MultiCell(80,4,"Identificação Do Produto \n ",1);
$pdf->SetXY(185, 34);
$pdf->MultiCell(105,4,"Número/Rev. Peça(fornecedor) \n $res[numero] - $res[rev]",1);
//linha4
$pdf->SetXY(5, 42);
$pdf->MultiCell(180,4,"Equipe \n $resp[equipe] ",1);
$pdf->SetXY(185, 42);
$pdf->MultiCell(75,4,"Aprovado Por \n $resp[quem]",1);
$pdf->SetXY(260, 42);
$pdf->MultiCell(30,4,"Data \n ".banco2data($resp["dtquem"])."",1);
//linha5
$pdf->SetXY(5, 50);
$pdf->MultiCell(180,4,"Observações \n $resp[obs]",1);
$pdf->SetXY(185, 50);
$pdf->MultiCell(37.5,4,"Data Início \n ".banco2data($resp["ini"])."",1);
$pdf->SetXY(222.5, 50);
$pdf->MultiCell(37.5,4,"Data Rev. \n ".banco2data($resp["rev"])."",1);
$pdf->SetXY(260, 50);
$pdf->MultiCell(30,4,"Data Chave \n ".banco2data($resp["chv"])."",1);
//linha6
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 60);
$pdf->MultiCell(19,4," \n Função & Requisitos do Processo ",1,'C');
$pdf->SetXY(24, 60);
$pdf->MultiCell(22,4," \n Modo de Falha Potencial \n ",1,'C');
$pdf->SetXY(46, 60);
$pdf->MultiCell(35,4," \n Efeito Potencial da Falha \n \n ",1,'C');
$pdf->SetXY(81, 60);
$pdf->MultiCell(4,4,"Serve",1);
$pdf->SetXY(85, 60);
$pdf->MultiCell(4,4,"Class",1);
$pdf->SetXY(89, 60);
$pdf->MultiCell(28,4," \n Causa / Mecanismo Pot. da Falha \n ",1,'C');
$pdf->SetXY(117, 60);
$pdf->MultiCell(4,4,"Ocorr",1,'C');
$pdf->SetXY(121, 60);
$pdf->MultiCell(70,4," \n Controles Atuais do Projeto \n ",1,'C');
$pdf->SetXY(121, 72);
$pdf->MultiCell(35,8,"Prevenção",1,'C');
$pdf->SetXY(156, 72);
$pdf->MultiCell(35,8,"Detenção",1,'C');
$pdf->SetXY(191, 60);
$pdf->MultiCell(4,4,"Detec",1,'C');
$pdf->SetXY(195, 60);
$pdf->MultiCell(6,4,"   N P R   ",1,'C');
$pdf->SetXY(201, 60);
$pdf->MultiCell(24,4," \n Ações Recomendadas \n \n ",1,'C');
$pdf->SetXY(225, 60);
$pdf->MultiCell(24,4," \n Responsável / Prazo \n \n ",1,'C');
$pdf->SetXY(249, 60);
$pdf->MultiCell(41,4,"Resultado Das Ações",1,'C');
$pdf->SetXY(249, 64);
$pdf->MultiCell(23,4," \n Ações Tomadas \n ",1,'C');
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
$sql=mysql_query("SELECT apqp_fmeaproci.* FROM apqp_fmeaproci,apqp_fmeaproc WHERE apqp_fmeaproc.peca='$pc' AND apqp_fmeaproci.fmea=apqp_fmeaproc.id order by apqp_fmeaproci.item asc");
if(mysql_num_rows($sql)){
	$opnum="";
	$y=80;
	while($res=mysql_fetch_array($sql)){
		//calculando o tamanho dos campos
		$ope=mysql_query("select * from apqp_op where id=$res[item]")or die("Não Foi");
		$ope_tb=mysql_fetch_array($ope);
		if($opera==$ope_tb["descricao"]){
			$show=" ";
		}else{
			$show=$ope_tb["numero"]." - ".$ope_tb["descricao"];
			$pdf->Line(5,$y,290,$y);
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
			$y=48;
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetFont('Arial','B',14);
			$pdf->SetXY(5, 5);
			$pdf->MultiCell(290,5,"FMEA DE PROCESSO",0,'C');
			$pdf->SetXY(5, 18);
			$pdf->SetFont('Arial','',8);
			$pg=$pdf->PageNo();
			$pdf->MultiCell(50,4,"Número da Peça (cliente) \n $cliente",1);
			$pdf->SetXY(55, 18);
			$pdf->MultiCell(50,4,"Rev. / Data do Desenho \n $rev",1);
			$pdf->SetXY(105, 18);
			$pdf->MultiCell(80,4,"Nome da Peça \n $peca",1);
			$pdf->SetXY(185, 18);
			$pdf->MultiCell(75,4,"Número da FMEA \n $fmea",1);
			$pdf->SetXY(260, 18);
			$pdf->MultiCell(30,4,"Página \n $pg",1);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(5, 28);
			$pdf->MultiCell(19,4," \n Função & Requisitos do Processo ",1,'C');
			$pdf->SetXY(24, 28);
			$pdf->MultiCell(22,4," \n Modo de Falha Potencial \n ",1,'C');
			$pdf->SetXY(46, 28);
			$pdf->MultiCell(35,4," \n Efeito Potencial da Falha \n \n ",1,'C');
			$pdf->SetXY(81, 28);
			$pdf->MultiCell(4,4,"Serve",1);
			$pdf->SetXY(85, 28);
			$pdf->MultiCell(4,4,"Class",1);
			$pdf->SetXY(89, 28);
			$pdf->MultiCell(28,4," \n Causa / Mecanismo Pot. da Falha \n ",1,'C');
			$pdf->SetXY(117, 28);
			$pdf->MultiCell(4,4,"Ocorr",1,'C');
			$pdf->SetXY(121, 28);
			$pdf->MultiCell(70,4," \n Controles Atuais do Projeto \n ",1,'C');
			$pdf->SetXY(121, 40);
			$pdf->MultiCell(35,8,"Prevenção",1,'C');
			$pdf->SetXY(156, 40);
			$pdf->MultiCell(35,8,"Detenção",1,'C');
			$pdf->SetXY(191, 28);
			$pdf->MultiCell(4,4,"Detec",1,'C');
			$pdf->SetXY(195, 28);
			$pdf->MultiCell(6,4,"   N P R   ",1,'C');
			$pdf->SetXY(201, 28);
			$pdf->MultiCell(24,4," \n Ações Recomendadas \n \n ",1,'C');
			$pdf->SetXY(225, 28);
			$pdf->MultiCell(24,4," \n Responsável / Prazo \n \n ",1,'C');
			$pdf->SetXY(249, 28);
			$pdf->MultiCell(41,4,"Resultado Das Ações",1,'C');
			$pdf->SetXY(249, 32);
			$pdf->MultiCell(23,4," \n Ações Tomadas \n ",1,'C');
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
			$fig="../../apqp_fluxo/$res[icone].jpg";
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
}
if($pg>1){
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
}

if(empty($tira)){
$pdf->Output('apqp_fmeaproc.pdf','I');
}
?>
