<?
include("conecta.php");
require('pdf/fpdf.php');
$quem=$_SESSION["login_nome"];
$who=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];
$hj=date("Y-m-d");
$hora=hora();
$sql3=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'"); $res3=mysql_fetch_array($sql3);
$sqlc=mysql_query("SELECT * FROM clientes WHERE id='$res3[cliente]'"); $resc=mysql_fetch_array($sqlc);
if($_SESSION["login_funcionario"]=="N"){
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$_SESSION[login_codigo]'");	
	$res=mysql_fetch_array($sql);
	$tag=$res["tag"];
	$dequem=$res["email"];
}else{
	$sql2=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
	$res2=mysql_fetch_array($sql2);
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$res2[cliente]'");	
	$res=mysql_fetch_array($sql);
	$tag=$res["tag"];
	$sql=mysql_query("SELECT * FROM funcionarios WHERE id='$_SESSION[login_codigo]'");	
	$res=mysql_fetch_array($sql);
	$dequem=$res["email"];
}
$msg="";
if(!empty($acao)){
	$loc="Imprimir PPAP";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($lingua=="usa"){
	$cam="ingles/";
	$lang="Inglês";
}else if($lingua=="spa"){
	$cam="espanhol/";
	$lang="Espanhol";	
}else if($lingua=="ger"){
	$cam="alemao/";
	$lang="Alemão";	
}else if($lingua=="fra"){
	$cam="frances/";
	$lang="Francês";
}else{
	$cam="";
	$lang="Português";	
}
if($acao=="email"){
	if(!strstr($email,"@") or !strstr($email,".")){
		$_SESSION["mensagem"]="Email Invalido!";
		header("location:apqp_ppap.php");
		exit;
	}
	$pc=$_POST["pc"];
	$nome=$_POST["nome"];
	$sqlp=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'"); $resp=mysql_fetch_array($sqlp); $pecaa=$resp["numero"]."-".$resp["rev"];
		include ("classes/jpgraph/jpgraph.php");
		include ("classes/jpgraph/jpgraph_line.php");
		include ("classes/jpgraph/jpgraph_bar.php");
		$pdf=new FPDF();
		$logo="OK";
	if(!empty($nome)){
		foreach($nome as $nome1){
			switch($nome1){
						case "submissao": 
						if($tag=="S"){
							include("pdf/".$cam."apqp_sub_imp2_2.php");
						} else {
							include("pdf/".$cam."apqp_sub_imp2_1.php");
						}
						break;
						case "dimensional": 
						include("pdf/".$cam."apqp_endi_imp2.php");
						break;
						case "material": 
						include("pdf/".$cam."apqp_enma_imp2.php");
						break;
						case "desempenho":
						include("pdf/".$cam."apqp_ende_imp2.php");
						break;
						case "rr": 
						include("pdf/".$cam."apqp_rr_imp_2.php");
						break;
						case "capabilidade": 
						include("pdf/".$cam."apqp_cap_imp_2.php");
						break;
						case "fluxo":
						include("pdf/".$cam."apqp_fluxo_imp2.php");
						break;
						case "sumario": 
						include("pdf/".$cam."apqp_sum_imp_2.php");
						break;
						case "inst": 
						include("pdf/".$cam."apqp_inst_imp2.php");
						break;
						case "viabilidade":
						include("pdf/".$cam."apqp_viabilidade_imp1_2.php");
						break;
						case "granel": 
						include("pdf/".$cam."apqp_granel_imp2.php");
						break;
						case "ope":
						include("pdf/".$cam."apqp_fmeaope_imp2.php");
						break;
						case "interina":
						include("pdf/".$cam."apqp_interina_imp.php");
						break;
			}
		}
	}
if(!empty($nome2)){
	//$pdf=new FPDF('L');
	foreach($nome2 as $nome3){
		switch($nome3){
				case "cronograma": 
				include("pdf/".$cam."apqp_crono_imp2.php");
				break;
				case "controle": 
				include("pdf/".$cam."apqp_plano_imp2.php");
				break;
				case "processo":
				include("pdf/".$cam."apqp_fmeaproc_imp2.php");
				break;
				case "projeto": 
				include("pdf/".$cam."apqp_fmeaproj_imp2.php");
				break;
				case "aparencia": 
				include("pdf/".$cam."apqp_apro_imp2.php");
				break;
				case "chk":
				include("pdf/".$cam."apqp_chk_imp2.php");
				break;
		}
	}
}
$pdf->Output('relatoriopp.pdf','F');
// - - - - - - - - - - - - - 
$fp = fopen("relatoriopp.pdf","rb");
$anexo = fread($fp,filesize("relatoriopp.pdf"));         
$anexo = base64_encode($anexo);
fclose($fp);
$anexo = chunk_split($anexo);

$boundary = "XYZ-" . date("dmYis") . "-ZYX";

    $mens = "--$boundary\n";
    $mens .= "Content-Transfer-Encoding: 8bits\n";
    $mens .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n\n"; //plain
    $mens .= "$mensagem\n";
    $mens .= "--$boundary\n";
$mens .= "Content-Type: application/pdf\n";
$mens .= "Content-Disposition: attachment; filename=\"ppap_$pecaa.pdf\"\n";
$mens .= "Content-Transfer-Encoding: base64\n\n";
$mens .= "$anexo\n";
$mens .= "--$boundary--\r\n";

$headers  = "MIME-Version: 1.0\n";
$headers .= "From: $dequem\r\n";
$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
$headers .= "$boundary\n";

//envio o email com o anexo   
				mail($email,"$assunto",$mens,$headers);
				$_SESSION["mensagem"]="Email enviado com sucesso!";
				// cria followup do email
					$sql_emp=mysql_query("SELECT fantasia FROM empresa");
					$res_emp=mysql_fetch_array($sql_emp);
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail do PPAP da peça $npc.','O usuário $quem enviou por e-mail a impressão do PPAP em $lang da peça $npc para $email.','$who')");
				//
				header("location:apqp_ppap.php");
				exit;
// // - - - - - // //
}

if($acao=="salvar"){
	// cria followup da impressão
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando impressão PPAP da peça $npc.','O usuário $quem salvou em disco a impressão do PPAP em $lang da peça $npc.','$who')");
	//
	
	$pc=$_POST["pc"];
	$nome=$_POST["nome"];
	include ("classes/jpgraph/jpgraph.php");
	include ("classes/jpgraph/jpgraph_line.php");
	include ("classes/jpgraph/jpgraph_bar.php");
	$pdf=new FPDF();
	$logo="OK";
	if(!empty($nome)){
		foreach($nome as $nome1){
			switch($nome1){
				case "submissao": 
					if($tag=="S"){
						include("pdf/".$cam."apqp_sub_imp2_2.php");
					} else {
						include("pdf/".$cam."apqp_sub_imp2_1.php");
					}
					break;
					case "dimensional": 
					include("pdf/".$cam."apqp_endi_imp2.php");
					break;
					case "material": 
					include("pdf/".$cam."apqp_enma_imp2.php");
					break;
					case "desempenho":
					include("pdf/".$cam."apqp_ende_imp2.php");
					break;
					case "rr": 
					include("pdf/".$cam."apqpp_rr_imp_2.php");
					break;
					case "capabilidade": 
					include("pdf/".$cam."apqpp_cap_imp_2.php");
					break;
					case "fluxo":
					include("pdf/".$cam."apqp_fluxo_imp2.php");
					break;
					case "sumario": 
					include("pdf/".$cam."apqp_sum_imp_2.php");
					break;
					case "inst": 
					include("pdf/".$cam."apqp_inst_imp2.php");
					break;
					case "viabilidade":
					include("pdf/".$cam."apqp_viabilidade_imp1_2.php");
					break;
					case "granel": 
					include("pdf/".$cam."apqp_granel_imp2.php");
					break;
					case "ope":
					include("pdf/".$cam."apqp_fmeaope_imp2.php");
					break;
					case "interina":
					include("pdf/".$cam."apqp_interina_imp.php");
					break;
			}
		}
	}
	
	if(!empty($nome2)){
	//$pdf=new FPDF('L');
		foreach($nome2 as $nome3){
			switch($nome3){
				case "cronograma": 
				include("pdf/".$cam."apqp_crono_imp2.php");
				break;
				case "controle": 
				include("pdf/".$cam."apqp_plano_imp2.php");
				break;
				case "processo":
				include("pdf/".$cam."apqp_fmeaproc_imp2.php");
				break;
				case "projeto": 
				include("pdf/".$cam."apqp_fmeaproj_imp2.php");
				break;
				case "aparencia": 
				include("pdf/".$cam."apqp_apro_imp2.php");
				break;
				case "chk":
				include("pdf/".$cam."apqp_chk_imp2.php");
				break;
			}
		}
		
	}
	$pdf->Output('relatorio.pdf','D');

}
if($acao=="imp"){
	
	$pc=$_POST["pc"];
	$nome=$_POST["nome"];
	include ("classes/jpgraph/jpgraph.php");
	include ("classes/jpgraph/jpgraph_line.php");
	include ("classes/jpgraph/jpgraph_bar.php");
	$pdf=new FPDF();
	$logo="OK";
	if(!empty($nome)){
		foreach($nome as $nome1){
			switch($nome1){
				case "submissao": 
					$estudo.="Certificado de Submissão";
					if($tag=="S"){
						include("pdf/".$cam."apqp_sub_imp2_2.php");
					} else {
						include("pdf/".$cam."apqp_sub_imp2_1.php");
					}
					break;
					case "dimensional": 
					$estudo.="Ensaio Dimensional, ";
					if($resc["relatorios"]!="S"){
						include("pdf/".$cam."apqp_endi_imp2.php");
					} else {
						include("pdf/".$cam."apqp_endic_imp2.php");
					}
					break;
					case "material": 
					$estudo.="Ensaio Material, ";
					if($resc["relatorios"]!="S"){					
						include("pdf/".$cam."apqp_enma_imp2.php");
					} else {
						include("pdf/".$cam."apqp_enmac_imp2.php");
					}						
					break;
					case "desempenho":
					$estudo.="Ensaio de Desempenho, ";
					if($resc["relatorios"]!="S"){					
						include("pdf/".$cam."apqp_ende_imp2.php");
					} else {		
						include("pdf/".$cam."apqp_endec_imp2.php");						
					}
					break;
					case "rr": 
					$estudo.="Estudo de R&R, ";
					include("pdf/".$cam."apqpp_rr_imp_2.php");
					break;
					case "capabilidade": 
					$estudo.="Estudo de Capabilidade, ";
					include("pdf/".$cam."apqpp_cap_imp_2.php");
					break;
					case "fluxo":
					$estudo.="Diagrama de Fluxo, ";
					include("pdf/".$cam."apqp_fluxo_imp2.php");
					break;
					case "sumario": 
					$estudo.="Sumário e Aprovação do APQP, ";
					include("pdf/".$cam."apqp_sum_imp_2.php");
					break;
					case "inst": 
					$estudo.="Instruções do Operador, ";
					include("pdf/".$cam."apqp_inst_imp2.php");
					break;
					case "viabilidade":
					$estudo.="Viabilidade, ";
					include("pdf/".$cam."apqp_viabilidade_imp1_2.php");
					break;
					case "granel": 
					//$estudo.="";
					include("pdf/".$cam."apqp_granel_imp2.php");
					break;
					case "ope":
					//$estudo.="";
					include("pdf/".$cam."apqp_fmeaope_imp2.php");
					break;
					case "interina":
					$estudo.="Aprovação Interina, ";
					include("pdf/".$cam."apqp_interina_imp.php");
					break;
			}
		}
	}
	
	if(!empty($nome2)){
	//$pdf=new FPDF('L');
		foreach($nome2 as $nome3){
			switch($nome3){
				case "cronograma": 
				$estudo.="Cronograma, ";
				include("pdf/".$cam."apqp_crono_imp2.php");
				break;
				case "controle": 
				$estudo.="Plano de Controle, ";
				include("pdf/".$cam."apqp_plano_imp2.php");
				break;
				case "processo":
				$estudo.="FMEA de Processo, ";
				include("pdf/".$cam."apqp_fmeaproc_imp2.php");
				break;
				case "projeto": 
				$estudo.="FMEA de Projeto, ";
				include("pdf/".$cam."apqp_fmeaproj_imp2.php");
				break;
				case "aparencia": 
				$estudo.="Aprovação de Aparência, ";
				include("pdf/".$cam."apqp_apro_imp2.php");
				break;
				case "chk":
				$estudo.="Checklist APQP, ";
				include("pdf/".$cam."apqp_chk_imp2.php");
				break;
			}
		}
		
	}
	$pdf->Output('relatorio.pdf','I');
	// cria followup da impressão
	$sql_emp=mysql_query("SELECT fantasia FROM empresa");
	$res_emp=mysql_fetch_array($sql_emp);
	mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão PPAP da peça $npc.','O usuário $quem efetuou a impressão do PPAP dos seguintes estudos: $estudo em $lang da peça $npc.','$who')");
	//
}
?>