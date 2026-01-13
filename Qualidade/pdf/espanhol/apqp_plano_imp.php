<?php
include('../../conecta.php');
require('fpdf.php');
$pc=$_GET["pc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM empresa");
if(mysql_num_rows($sql)) $rese=mysql_fetch_array($sql);
$sql=mysql_query("SELECT * FROM apqp_plano WHERE peca='$pc'");
if(mysql_num_rows($sql)) $resp=mysql_fetch_array($sql);

if(empty($tira)){$pdf=new FPDF('L');}

$pdf->AddPage();
$pdf->Image('empresa_logo/logo.jpg',5,1,25);
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(5, 4);
$pdf->MultiCell(290,5,"PLANO DE CONTROLE DO PROCESSO",0,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(260, 8);
$pg=$pdf->PageNo();
$pdf->MultiCell(65,5,"Página: $pg");
$pdf->SetXY(5, 18);
$peca=$res["pecacli"];
$cliente=$res["nomecli"];
$rev=$res["rev"]." - ".banco2data($res["dtrev"]);
$pdf->MultiCell(80,5,"Cliente \n $cliente",1);
$pdf->SetXY(85, 18);
$pdf->MultiCell(50,5,"Número da peça(cliente) \n $peca",1);
$pdf->SetXY(135, 18);
$pdf->MultiCell(50,5,"Rev. / Data do Desenho \n $rev",1);
$pdf->SetXY(185, 18);
$pdf->MultiCell(105,10,"",1);
if($resp["fase"]==1){ $fig1="2"; }else{ $fig1="1"; }
$pdf->Image("../../imagens/icon14_check$fig1.jpg",190,20,4,4);
$pdf->SetXY(195, 18);
$pdf->MultiCell(30,10,"Protótipo");
if($resp["fase"]==2){ $fig2="2"; }else{ $fig2="1"; }
$pdf->Image("../../imagens/icon14_check$fig2.jpg",220,20,4,4);
$pdf->SetXY(225, 18);
$pdf->MultiCell(30,10,"Pré-lançamento");
if($resp["fase"]==3){ $fig3="2"; }else{ $fig3="1"; }
$pdf->Image("../../imagens/icon14_check$fig3.jpg",250,20,4,4);
$pdf->SetXY(255, 18);
$pdf->MultiCell(30,10,"Produção");
//linha 2
$pdf->SetXY(5, 28);
$pdf->MultiCell(35,5,"Nº do plano de controle \n $resp[numero]",1);
$pdf->SetXY(40, 28);
$pdf->MultiCell(95,5,"Nome da Peça \n $res[nome]",1);
$pdf->SetXY(135, 28);
$pdf->MultiCell(90,5,"Fornecerdor \n $rese[razao]",1);
$pdf->SetXY(225, 28);
$pdf->MultiCell(30,5,"Cód. Fornecedor \n ",1);
$pdf->SetXY(255, 28);
$pdf->MultiCell(35,5,"Data Rev. \n ".banco2data($resp["rev"])."",1);
//linha 3
$pdf->SetXY(5, 38);
$pdf->MultiCell(130,5,"Equipe \n $resp[equipe]",1);
$pdf->SetXY(135, 38);
$pdf->MultiCell(50,5,"Aprovação do Fornecedor / Data  \n ".$resp["quem"]." / ".banco2data($resp["dtquem"])."",1);
$pdf->SetXY(185, 38);
$pdf->MultiCell(70,5,"Número/Rev. Peça (fornecedor) \n ".$res["numero"]." - ".$res["rev"]."",1);
$pdf->SetXY(255, 38);
$pdf->MultiCell(35,5,"Data Início. \n ".banco2data($resp["ini"])."",1);
//linha 4
$pdf->SetXY(5, 48);
$pdf->MultiCell(130,5,"Aprovação da Engenharia do Cliente / Data (se requerido) \n ".$resp["apro1"]." / ".banco2data($resp["apro1_data"])."",1);
$pdf->SetXY(135, 48);
$pdf->MultiCell(90,5,"Aprovação da Qualidade do Cliente / Data (se requerido) \n ".$resp["apro2"]." / ".banco2data($resp["apro2_data"])."",1);
$pdf->SetXY(225, 48);
$pdf->MultiCell(65,5,"Contato Chave / Fone  \n $resp[contato]",1);
//linha 5
$pdf->SetXY(5, 58);
$pdf->MultiCell(130,5,"Outra Aprovação / Data (se requerido)  \n ".$resp["apro3"]." / ".banco2data($resp["apro3_data"])."",1);
$pdf->SetXY(135, 58);
$pdf->MultiCell(155,5,"Outra Aprovação / Data (se requerido)   \n ".$resp["apro4"]." / ".banco2data($resp["apro4_data"])."",1);
//linha 6
$pdf->SetXY(5, 70);
$pdf->MultiCell(15,5,"Número Peça / Processo",1,'C');
$pdf->SetXY(20, 70);
$pdf->MultiCell(35,5,"Nome da Peça / Processo ou Descrição da Operação",1,'C');
$pdf->SetXY(55, 70);
$pdf->MultiCell(35,5,"Máquina, Dispositivo, Padrão, Ferramentas para Produção",1,'C');
$pdf->SetXY(90, 70);
$pdf->MultiCell(50,10,"Características",1,'C');
	$pdf->SetXY(90, 80);
	$pdf->MultiCell(6,5,"Nº",1,'C');
	$pdf->SetXY(96, 80);
	$pdf->MultiCell(20,5,"Produto",1,'C');
	$pdf->SetXY(116, 80);
	$pdf->MultiCell(24,5,"Processo",1,'C');
$pdf->SetXY(140, 70);
$pdf->MultiCell(5,5,"C a r",1,'C');
$pdf->SetXY(145, 70);
$pdf->MultiCell(115,5,"Método",1,'C');
	$pdf->SetXY(145, 75);
	$pdf->MultiCell(30,5,"Tol. / Espec. do Prod. / Proc.",1,'C');
	$pdf->SetXY(175, 75);
	$pdf->MultiCell(25,5,"Técnica de Aval. / Medição ",1,'C');
	$pdf->SetXY(200, 75);
	$pdf->MultiCell(30,5,"Amostra",1,'C');
		$pdf->SetXY(200, 80);
		$pdf->MultiCell(15,5,"Tam.",1,'C');
		$pdf->SetXY(215, 80);
		$pdf->MultiCell(15,5,"Freq.",1,'C');
	$pdf->SetXY(230, 75);
	$pdf->MultiCell(30,10,"Metodo de Controle",1,'C');
$pdf->SetXY(260, 70);
$pdf->MultiCell(30,5,"Plano de Reação \n e Ações Corretivas \n ",1,'C');
//linha 7
$sql=mysql_query("SELECT plano1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo,op.descricao AS opdesc,op.macloc, op.numero AS opnum FROM apqp_op AS op, apqp_car AS car, apqp_plano AS plano, apqp_planoi AS plano1 WHERE plano1.car=car.id AND plano.peca='$pc' AND plano.id=plano1.plano AND plano1.op=op.id ORDER By opnum,car.numero ASC");
if(mysql_num_rows($sql)){
	$opnum="";
	$y=85;
	$pdf->Line(5,185,290,185);
	$pdf->Line(5,$y,5,185);
	$pdf->Line(20,$y,20,185);
	$pdf->Line(55,$y,55,185);
	$pdf->Line(90,$y,90,185);
	$pdf->Line(96,$y,96,185);
	$pdf->Line(116,$y,116,185);
	$pdf->Line(140,$y,140,185);
	$pdf->Line(145,$y,145,185);
	$pdf->Line(175,$y,175,185);
	$pdf->Line(200,$y,200,185);
	$pdf->Line(215,$y,215,185);
	$pdf->Line(230,$y,230,185);
	$pdf->Line(260,$y,260,185);
	$pdf->Line(290,$y,290,185);
	while($res=mysql_fetch_array($sql)){
		$maxi=$max*5;
		$total=$y + $maxi;
		if($total>=185){
		 $y=186;
		}
		if($y>=185){
			$y=45;
			$pdf->Line(5,185,290,185);
			$pdf->AddPage();
			$pdf->Image('empresa_logo/logo.jpg',5,1,25);
			$pdf->SetFont('Arial','B',14);
			$pdf->SetXY(5, 4);
			$pdf->MultiCell(290,5,"PLANO DE CONTROLE DO PROCESSO",0,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->SetXY(260, 8);
			$pg=$pdf->PageNo();
			$pdf->MultiCell(65,5,"Página: $pg");
			$pdf->SetXY(5, 18);
			$pdf->MultiCell(80,5,"Cliente \n $cliente",1);
			$pdf->SetXY(85, 18);
			$pdf->MultiCell(50,5,"Número da peça(cliente) \n $peca",1);
			$pdf->SetXY(135, 18);
			$pdf->MultiCell(50,5,"Rev. / Data do Desenho \n $rev",1);
			$pdf->SetXY(185, 18);
			$pdf->MultiCell(105,10,"",1);
			if($resp["fase"]==1){ $fig1="2"; }else{ $fig1="1"; }
			$pdf->Image("../../imagens/icon14_check$fig1.jpg",190,20,4,4);
			$pdf->SetXY(195, 18);
			$pdf->MultiCell(30,10,"Protótipo");
			if($resp["fase"]==2){ $fig2="2"; }else{ $fig2="1"; }
			$pdf->Image("../../imagens/icon14_check$fig2.jpg",220,20,4,4);
			$pdf->SetXY(225, 18);
			$pdf->MultiCell(30,10,"Pré-lançamento");
			if($resp["fase"]==3){ $fig3="2"; }else{ $fig3="1"; }
			$pdf->Image("../../imagens/icon14_check$fig3.jpg",250,20,4,4);
			$pdf->SetXY(255, 18);
			$pdf->MultiCell(30,10,"Produção");
			//linha 2
			$pdf->SetXY(5, 30);
			$pdf->MultiCell(15,5,"Número Peça / Processo",1,'C');
			$pdf->SetXY(20, 30);
			$pdf->MultiCell(35,5,"Nome da Peça / Processo ou Descrição da Operação",1,'C');
			$pdf->SetXY(55, 30);
			$pdf->MultiCell(35,5,"Máquina, Dispositivo, Padrão, Ferramentas para Produção",1,'C');
			$pdf->SetXY(90, 30);
			$pdf->MultiCell(50,10,"Características",1,'C');
				$pdf->SetXY(90, 40);
				$pdf->MultiCell(6,5,"Nº",1,'C');
				$pdf->SetXY(96, 40);
				$pdf->MultiCell(20,5,"Produto",1,'C');
				$pdf->SetXY(116, 40);
				$pdf->MultiCell(24,5,"Processo",1,'C');
			$pdf->SetXY(140, 30);
			$pdf->MultiCell(5,5,"C a r",1,'C');
			$pdf->SetXY(145, 30);
			$pdf->MultiCell(115,5,"Método",1,'C');
				$pdf->SetXY(145, 35);
				$pdf->MultiCell(30,5,"Tol. / Espec. do Prod. / Proc.",1,'C');
				$pdf->SetXY(175, 35);
				$pdf->MultiCell(25,5,"Técnica de Aval. / Medição ",1,'C');
				$pdf->SetXY(200, 35);
				$pdf->MultiCell(30,5,"Amostra",1,'C');
					$pdf->SetXY(200, 40);
					$pdf->MultiCell(15,5,"Tam.",1,'C');
					$pdf->SetXY(215, 40);
					$pdf->MultiCell(15,5,"Freq.",1,'C');
				$pdf->SetXY(230, 35);
				$pdf->MultiCell(30,10,"Metodo de Controle",1,'C');
			$pdf->SetXY(260, 30);
			$pdf->MultiCell(30,5,"Plano de Reação \n e Ações Corretivas \n ",1,'C');
			
		}
		if($res["opnum"]==$opnum){
			$res["opnum"]=" ";
			$res["opdesc"]=" ";
			$res["macloc"]=" ";
		}else{
			$opnum=$res["opnum"];
			$pdf->Line(5,$y,290,$y);
		}
		$tam[0]=flinha($res["opnum"],8);
		if($tam[0]==0){$tam[0]=1;}
		$tam[1]=flinha($res["opdesc"],23);
		if($tam[1]==0){$tam[1]=1;}
		$tam[2]=flinha($res["macloc"],23);
		if($tam[2]==0){$tam[2]=1;}
		$tam[3]=flinha($res["numero"],3);
		if($tam[3]==0){$tam[3]=1;}
		if($res["tipo"]=="Pro"){
			$pro=$res["descricao"];
			if(empty($pro)){
				$tam[4]=1;
			}else{
				$tam[4]=flinha($pro,12);
			}
		}elseif($res["tipo"]!="Pro"){
			$des=$res["descricao"];
			if(empty($des)){
				$tam[5]=1;
			}else{
				$tam[5]=flinha($des,12);
			}
			
		}
		if($tam[4]==0){$tam[4]=1;}
		if($tam[5]==0){$tam[5]=1;}
		$tam[6]=flinha($res["tecnicas"],17);
		if($tam[6]==0){$tam[6]=1;}
		$tam[7]=flinha($res["tamanho"],8);
		if($tam[7]==0){$tam[7]=1;}
		$tam[8]=flinha($res["freq"],11);
		if($tam[8]==0){$tam[8]=1;}
		$tam[9]=flinha($res["metodo"],18);
		if($tam[9]==0){$tam[9]=1;}
		$tam[10]=flinha($res["reacao"],20);
		if($tam[10]==0){$tam[10]=1;}
		$tam[11]=flinha($res["espec"],22);
		if($tam[11]==0){$tam[11]=1;}
		$max=max($tam);
		for($i=0;$i<=11;$i++){
			$ql[$i]=$max - $tam[$i];
		}
		$w=5;
		$pdf->SetXY(5, $y);
		$pdf->MultiCell(15,$w,$res["opnum"],0,'C');
		$pdf->SetXY(20, $y);
		$pdf->MultiCell(35,$w,$res["opdesc"],0,'C');
		$pdf->SetXY(55, $y);
		$pdf->MultiCell(35,$w,$res["macloc"],0,'C');
		$pdf->SetXY(90, $y);
		$pdf->MultiCell(6,$w,$res["numero"],0,'C');
		$pdf->SetXY(96, $y);
		$pdf->MultiCell(20,$w,$des,0,'C');
		$pdf->SetXY(116, $y);
		$pdf->MultiCell(24,$w,$pro,0,'C');
		$pdf->SetXY(140, $y);
		if(empty($res["simbolo"])){ $fig="../../imagens/quad.jpg"; }else{ $fig="../../apqp_fluxo/$res[simbolo].jpg"; }
		$ym=$y+2;
		$pdf->Image($fig,141,$ym,3,3);
		$pdf->MultiCell(10,$w,"",0,'C');
		$pdf->SetXY(145, $y);
		$pdf->MultiCell(30,$w,$res["espec"],0,'C');
		$pdf->SetXY(175, $y);
		$pdf->MultiCell(25,$w,$res["tecnicas"],0,'C');
		$pdf->SetXY(200, $y);
		$pdf->MultiCell(15,$w,$res["tamanho"],0,'C');
		$pdf->SetXY(215, $y);
		$pdf->MultiCell(15,$w,$res["freq"],0,'C');
		$pdf->SetXY(230, $y);
		$pdf->MultiCell(30,5,$res["metodo"],0,'C');
		$pdf->SetXY(260, $y);
		$pdf->MultiCell(30,$w,$res["reacao"],0,'C');
		$yi=$y;
		$y=($max*5)+$y;
		$pdf->Line(5,$yi,5,185);
		$pdf->Line(20,$yi,20,185);
		$pdf->Line(55,$yi,55,185);
		$pdf->Line(90,$yi,90,185);
		$pdf->Line(96,$yi,96,185);
		$pdf->Line(116,$yi,116,185);
		$pdf->Line(140,$yi,140,185);
		$pdf->Line(145,$yi,145,185);
		$pdf->Line(175,$yi,175,185);
		$pdf->Line(200,$yi,200,185);
		$pdf->Line(215,$yi,215,185);
		$pdf->Line(230,$yi,230,185);
		$pdf->Line(260,$yi,260,185);
		$pdf->Line(290,$yi,290,185);
	}
}
$pdf->Line(5,185,290,185);

//fim
if(empty($tira)){
$pdf->Output('appq_plano.pdf','I');
}
?>
