<?
include("conecta.php");
require('pdf/fpdf.php');

$msg="";
/*
$fluxo="http://www.cybermanager.com.br/cybermanager/apqp_fluxo_imp.php";
$processo="http://www.cybermanager.com.br/cybermanager/apqp_fmeaproc_imp.php?pc=7";
*/
if($acao=="email"){
	if(!empty($nome)){
	foreach($nome as $nome1){
		switch($nome1){
			case "fluxo":
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_fluxo_imp.php?pc=$pc\" class=\"textobold style1\">Diagrama de Fluxo</a><br>";
			break;
			case "chk":
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_chk_imp.php?pc=$pc\" class=\"textobold style1\">Checklist APQP </a><br>";
			break;
			case "rr": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_rr_imp.php?pc=$pc\" class=\"textobold style1\">Estudos de R&amp;R</a><br>";
			break;
			case "dimensional": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_endi_imp.php?pc=$pc\" class=\"textobold style1\">Ensaio Dimensional</a><br>";
			break;
			case "material": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_enma_imp.php?pc=$pc\" class=\"textobold style1\">Ensaio Material</a><br>";
			break;
			case "desempenho": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_ende_imp.php?pc=$pc\" class=\"textobold style1\">Ensaio Desempenho</a><br>";
			break;
			case "submissao": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_sub_imp.php?pc=$pc\" class=\"textobold style1\">Certificado de Submissão</a><br>";
			break;
			case "capabilidade": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_cap_imp.php?pc=$pc\" class=\"textobold style1\">Estudo de Capabilidade</a><br>";
			break;
			case "inst": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_inst_imp.php?pc=$pc\" class=\"textobold style1\">Instruções do Operador </a><br>";
			break;
			case "granel": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_granel_imp.php?pc=$pc\" class=\"textobold style1\">Instruções do Operador </a><br>";
			break;
		}
	}
	foreach($nome2 as $nome3){
		switch($nome3){
			case "projeto": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_fmeaproj_imp.php?pc=$pc\" class=\"textobold style1\">FMEA de Projeto</a><br>";
			break;
			case "processo": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_fmeaproc_imp.php?pc=$pc\" class=\"textobold style1\">FMEA de processo</a><br>";
			break;
			case "controle": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_plano_imp.php?pc=$pc\" class=\"textobold style1\">Plano de Controle</a><br>";
			break;
			case "cronograma": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_crono_imp.php?pc=$pc\" class=\"textobold style1\">Cronograma</a><br>";
			break;
			case "aparencia": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_apro_imp.php?pc=$pc\" class=\"textobold style1\">Aprova&ccedil;&atilde;o de Apar&ecirc;ncia</a><br>";
			break;
			case "sumario": 
			$msg.="<a href=\"http://www.cybermanager.com.br/cybermanager/pdf/apqp_sum_imp.php?pc=$pc\" class=\"textobold style1\">Sumário e Aprovação do APQP</a><br>";
			break;
		}
	}
		if(!empty($msg)){
			$lines = file ('includes/email/ppap.php');
			$i="1";
				foreach($lines as $line){
					$line=str_replace("%MSG%",$msg,$line);
					$mensagem.="$line";		
				}
				email('augusto@cyber1.com.br','Feeder',$email,"PPAP",'PPAP - Relatórios',$mensagem);
				$_SESSION["mensagem"]="Email enviado com sucesso!";
				print "<script>window.location='apqp_ppap.php';</script>";
		}
	}else{
				$_SESSION["mensagem"]="Escolha algum Item";
				print "<script>window.close();</script>";
	}
}
if($acao=="salvar"){
	"<script>window.open('relatorio.php');</script>";
}
if($acao=="imp"){
	if(!empty($nome)){
	include ("classes/jpgraph/jpgraph.php");
	include ("classes/jpgraph/jpgraph_line.php");
	
	$pdf=new FPDF();
	$logo="OK";
		foreach($nome as $nome1){
			switch($nome1){
				case "submissao": 
				include('pdf/apqp_sub_imp2.php');
				break;
				case "dimensional": 
				include('pdf/apqp_endi_imp2.php');
				break;
				case "material": 
				include('pdf/apqp_enma_imp2.php');
				break;
				case "desempenho": 
				include('pdf/apqp_ende_imp2.php');
				break;
				case "rr": 
				include('pdf/apqp_rr_imp_2.php');
				break;
				case "fluxo":
				include('pdf/apqp_fluxo_imp2.php');
				break;
				case "capabilidade": 
				include('pdf/apqp_cap_imp_2.php');
				break;
				case "chk":
				include('pdf/apqp_chk_imp2.php');
				break;
				case "inst": 
				include('pdf/apqp_inst_imp2.php');
				break;
				case "granel": 
				include('pdf/apqp_granel_imp2.php');
				break;
				case "viabilidade": 
				include('pdf/apqp_viabilidade_imp1_2.php.php');
				break;
			}
		}
		$pdf->Output('relatorio.pdf','D');
	}
	if(!empty($nome2)){
	$pdf=new FPDF('L');
		foreach($nome2 as $nome3){
			switch($nome3){
				case "controle": 
				include("pdf/apqp_plano_imp2.php");
				break;
				case "processo":
				include("pdf/apqp_fmeaproc_imp2.php");
				break;
				case "projeto": 
				include("pdf/apqp_fmeaproj_imp2.php");
				break;
				case "cronograma": 
				include("pdf/apqp_crono_imp2.php");
				break;
				case "aparencia": 
				include("pdf/apqp_apro_imp2.php");
				break;
				case "sumario": 
				include('pdf/apqp_sum_imp_2.php');
				break;
			}
		}
		$pdf->Output('relatorio_v.pdf','D');
	}

}
?>