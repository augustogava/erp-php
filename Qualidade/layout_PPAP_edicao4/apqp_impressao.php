<?
include("conecta.php");
require('pdf/fpdf.php');
$sql=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'"); $res=mysql_fetch_array($sql); $numer=$res["numero"]; $revi=$res["rev"];
$sqlc=mysql_query("SELECT * FROM clientes WHERE id='$res[cliente]'"); $resc=mysql_fetch_array($sqlc);
$tag=$resc["tag"];
$pecaa=$numer."-".$revi;
$hj=date("Y-m-d");
$hora=hora();
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];

// sql para buscar o nome da empresa
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if($_SESSION["login_funcionario"]=="N"){
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$_SESSION[login_codigo]'");	
	$res=mysql_fetch_array($sql);
	$dequem=$res["email"];
}else{
	$sql=mysql_query("SELECT * FROM funcionarios WHERE id='$_SESSION[login_codigo]'");	
	$res=mysql_fetch_array($sql);
	$dequem=$res["email"];
}
$msg="";
$mens="";
$headers="";

if($acao=="email"){ // envia e-mail com arquivo pdf do módulo anexo

	if(!strstr($email,"@") or !strstr($email,".")){
		$_SESSION["mensagem"]="Email Invalido!";
		print "<script>history.go(-1);</script>";
	}

		$pc=$_SESSION["mpc"];
		include ("classes/jpgraph/jpgraph.php");
		include ("classes/jpgraph/jpgraph_line.php");
		include ("classes/jpgraph/jpgraph_bar.php");
				switch($local){

					case "fluxo":
					// cria followup caso envie e-mail com anexo do Diagrama de fluxo
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Diagrama de fluxo da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Diagrama de fluxo da peça $npc para $email.','$user')");
					//					
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_fluxo_imp2.php');
					break;

					case "dimensional": 
					// cria followup caso envie e-mail com anexo do Ensaio Dimensional
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Ensaio Dimensional da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Ensaio Dimensional da peça $npc para $email.','$user')");
					//					
					$pdf=new FPDF();
					$logo="OK";
					if($resc["relatorios"]!="S"){
						include('pdf/apqp_endi_imp2.php');
					}else{
						include('pdf/apqp_endic_imp2.php');
					}
					break;
					
					case "desempenho":
					// cria followup caso envie e-mail com anexo do Ensaio de Desempenho
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Ensaio de Desempenho da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Ensaio de Desempenho da peça $npc para $email.','$user')");
					//					
					$pdf=new FPDF();
					$logo="OK";
					if($resc["relatorios"]!="S"){	
						include('pdf/apqp_ende_imp2.php');
					}else{
						include('pdf/apqp_endec_imp2.php');
					}
					break;
					
					case "submissao": 
					// cria followup caso envie e-mail com anexo do Certificado de Submissão
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Certificado de Submissão da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Certificado de Submissão da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					if($tag=="S"){
						include('pdf/apqp_sub_imp2_2.php');
					} else {
						include('pdf/apqp_sub_imp2_1.php');
					}
					break;
					case "inst": 
					// cria followup caso envie e-mail com anexo da Instrução do Operador
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Instrução do Operador da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Instrução do Operador da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_inst_imp2.php');
					break;
					
					case "granel": 
					// cria followup caso envie e-mail com anexo da Checklist Material a Granel
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Checklist Material a Granel da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Checklist Material a Granel da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_granel_imp2.php');
					break;
					
					case "sumario": 
					// cria followup caso envie e-mail com anexo da Sumário de Aprovação
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Sumário de Aprovação da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Sumário de Aprovação da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_sum_imp_2.php');
					break;
					
					case "capabilidade": 
					// cria followup caso envie e-mail com anexo da Capabilidade
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Capabilidade da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Capabilidade da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_cap_imp_2.php');
					break;
					
					case "rr": 
					// cria followup caso envie e-mail com anexo do Estudo de R&R
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Estudo de R&R da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Estudo de R&R da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_rr_imp_2.php');
					break;
					
					case "material": 
					// cria followup caso envie e-mail com anexo do Ensaio de Material
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Ensaio de Material da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Ensaio de Material da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					if($resc["relatorios"]!="S"){
						include('pdf/apqp_enma_imp2.php');
					}else{
						include('pdf/apqp_enmac_imp2.php');
					}
					break;
					
					case "viabilidade":
					// cria followup caso envie e-mail com anexo da viabilidade
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Viabilidade da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Viabilidade da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					include("pdf/apqp_viabilidade_imp1_2.php");
					break;
					
					case "interina":
					// cria followup caso envie e-mail com anexo da Aprovação Interina
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Aprovação Interina da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Aprovação Interina da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					include('pdf/apqp_interina_imp.php');
					break;
					
					case "processo":	
					// cria followup caso envie e-mail com anexo do FMEA de processo
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do FMEA de processo da peça $npc.','O usuário $quem1 enviou e-mail com anexo do FMEA de processo da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF('L');
					include("pdf/apqp_fmeaproc_imp2.php");
					break;
					
					case "projeto": 
					// cria followup caso envie e-mail com anexo do FMEA de projeto
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do FMEA de projeto da peça $npc.','O usuário $quem1 enviou e-mail com anexo do FMEA de projeto da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF('L');
					include("pdf/apqp_fmeaproj_imp2.php");
					break;

					case "controle": 
					// cria followup caso envie e-mail com anexo do Plano de Controle
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Plano de Controle da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Plano de Controle da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF('L');
					include("pdf/apqp_plano_imp2.php");
					break;
					
					case "crono": 
					// cria followup caso envie email do cronograma
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Cronograma da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Cronograma da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF('L');
					include("pdf/apqp_crono_imp2.php");
					break;
					
					case "aparencia": 
					// cria followup caso envie e-mail com anexo da Aprovação de Aparência
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Aprovação de Aparência da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Aprovação de Aparência da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF('L');
					include("pdf/apqp_apro_imp2.php");
					break;
					
					case "chk":
					// cria followup caso envie email do Checklist APQP
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do Checklist APQP da peça $npc.','O usuário $quem1 enviou e-mail com anexo do Checklist APQP da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF('L');
					include('pdf/apqp_chk_imp2.php');
					break;
					
					case "ope":
					// cria followup caso envie email do FMEA de Operação
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo do FMEA de Operação da peça $npc.','O usuário $quem1 enviou e-mail com anexo do FMEA de Operação da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF('L');
					include('pdf/apqp_fmeaope_imp2.php');
					break;
			}
		$pdf->Output('relatorio.pdf','F');
// - - - - - - - - - - - - - 
$fp = fopen("relatorio.pdf","rb");
$anexo = fread($fp,filesize("relatorio.pdf"));         
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
$mens .= "Content-Disposition: attachment; filename=\"$local$pecaa.pdf\"\n";
$mens .= "Content-Transfer-Encoding: base64\n\n";
$mens .= "$anexo\n";
$mens .= "--$boundary--\r\n";

$headers  = "MIME-Version: 1.0\n";
$headers .= "From: $dequem\r\n";
$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
$headers .= "$boundary\n";

//envio o email com o anexo  
				mail($email,"$assunto",$mens,$headers);
				if($local=="ope"){
					$_SESSION["mensagem"]="Email enviado com sucesso!";
					header("location:apqp_fmeacad_inc.php?id=$id&acao=alt");
					exit;
				}else{
					print "<script>window.alert('Enviado Com sucesso!');window.close();</script>";
				}
// // - - - - - // //



unset($ato);
unset($acao);
}
if($acao=="imp"){  // imprimir
		$pc=$_SESSION["mpc"];
		include ("classes/jpgraph/jpgraph.php");
		include ("classes/jpgraph/jpgraph_line.php");
		include ("classes/jpgraph/jpgraph_bar.php");
				switch($local){
					
					case "fluxo":
					// cria followup caso efetue a impressão do arquivo do Diagrama de fluxo
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Diagrama de fluxo da peça $npc.','O usuário $quem1 imprimiu o Diagrama de fluxo da peça $npc.','$user')");
					//					
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_fluxo_imp2.php');
					break;
					
					case "dimensional": 
					// cria followup caso efetue a impressão do arquivo do Ensaio Dimensional
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Ensaio Dimensional da peça $npc.','O usuário $quem1 imprimiu o Ensaio Dimensional da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					if($resc["relatorios"]!="S"){
						include('pdf/apqp_endi_imp2.php');
					}else{
						include('pdf/apqp_endic_imp2.php');
					}
					break;
					
					case "desempenho":
					// cria followup caso efetue a impressão do arquivo do Ensaio de Desempenho
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Ensaio de Desempenho da peça $npc.','O usuário $quem1 imprimiu o Ensaio de Desempenho da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					if($resc["relatorios"]!="S"){
						include('pdf/apqp_ende_imp2.php');
					}else{
						include('pdf/apqp_endec_imp2.php');
					}
					break;
					
					case "submissao": 
					// cria followup caso efetue a impressão do arquivo do Certificado de Submissão
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Certificado de Submissão da peça $npc.','O usuário $quem1 imprimiu o Certificado de Submissão da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					if($tag=="S"){
						include('pdf/apqp_sub_imp2_2.php');
					} else {
						include('pdf/apqp_sub_imp2_1.php');
					}
					break;
					
					case "inst": 
					// cria followup caso efetue a impressão do arquivo do Instrução do Operador
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Instrução do Operador da peça $npc.','O usuário $quem1 imprimiu o Instrução do Operador da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_inst_imp2.php');
					break;
					
					case "granel": 
					// cria followup caso efetue a impressão do arquivo do Diagrama de fluxo
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Checklist Material a Granel da peça $npc.','O usuário $quem1 imprimiu o Checklist Material a Granel da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_granel_imp2.php');
					break;
					
					case "sumario": 
					// cria followup caso efetue a impressão do arquivo do Sumário de Aprovação
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Sumário de Aprovação da peça $npc.','O usuário $quem1 imprimiu o Sumário de Aprovação da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_sum_imp_2.php');
					break;
					
					case "capabilidade": 
					// cria followup caso efetue a impressão do arquivo da Capabilidade
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão da Capabilidade da peça $npc.','O usuário $quem1 imprimiu a Capabilidade da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_cap_imp_2.php');
					break;
					
					case "rr": 
					// cria followup caso efetue a impressão do arquivo do Estudo de R&R
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Estudo de R&R da peça $npc.','O usuário $quem1 imprimiu o Estudo de R&R da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					include('pdf/apqp_rr_imp_2.php');
					break;
					
					case "material": 
					// cria followup caso efetue a impressão do arquivo do Ensaio de Material
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Ensaio de Material da peça $npc.','O usuário $quem1 imprimiu o Ensaio de Material da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					if($resc["relatorios"]!="S"){	
						include('pdf/apqp_enma_imp2.php');
					}else{
						include('pdf/apqp_enmac_imp2.php');
					}
					break;
					
					case "interina":
					// cria followup caso efetue a impressão do arquivo da Aprovação Interina
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão da Aprovação Interina da peça $npc.','O usuário $quem1 imprimiu a Aprovação Interina da peça $npc.','$user')");
					$pdf=new FPDF();
					include('pdf/apqp_interina_imp.php');
					break;
					
					case "viabilidade":
					// cria followup caso efetue a impressão do arquivo da Viabilidade
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão da Viabilidade da peça $npc.','O usuário $quem1 imprimiu a Viabilidade da peça $npc.','$user')");
					$pdf=new FPDF();
					$logo="OK";
					include("pdf/apqp_viabilidade_imp1_2.php");
					break;
					
					case "processo":
					// cria followup caso efetue a impressão do arquivo do FMEA de Processo
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do FMEA de Processo da peça $npc.','O usuário $quem1 imprimiu o FMEA de Processo da peça $npc.','$user')");
					$pdf=new FPDF('L');
					include("pdf/apqp_fmeaproc_imp2.php");
					break;
					
					case "projeto": 
					// cria followup caso efetue a impressão do arquivo do FMEA de Projeto
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do FMEA de Projeto da peça $npc.','O usuário $quem1 imprimiu o FMEA de Projeto da peça $npc.','$user')");
					$pdf=new FPDF('L');
					include("pdf/apqp_fmeaproj_imp2.php");
					break;
					
					case "controle": 
					// cria followup caso efetue a impressão do arquivo do Plano de Controle
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Plano de Controle da peça $npc.','O usuário $quem1 imprimiu o Plano de Controle da peça $npc.','$user')");
					$pdf=new FPDF('L');
					include("pdf/apqp_plano_imp2.php");
					break;
					
					case "crono": 
					// cria followup caso efetue a impressão do arquivo do Cronograma
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Cronograma da peça $npc.','O usuário $quem1 imprimiu o Cronograma da peça $npc.','$user')");
					$pdf=new FPDF('L');
					include("pdf/apqp_crono_imp2.php");
					break;
					
					case "aparencia": 
					// cria followup caso efetue a impressão do arquivo da Aprovação de Aparência
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão da Aprovação de Aparência da peça $npc.','O usuário $quem1 imprimiu a Aprovação de Aparência da peça $npc.','$user')");
					$pdf=new FPDF('L');
					include("pdf/apqp_apro_imp2.php");
					break;
					
					case "chk":
					// cria followup caso efetue a impressão do arquivo do Checklist APQP
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do Checklist APQP da peça $npc.','O usuário $quem1 imprimiu o Checklist APQP da peça $npc.','$user')");
					$pdf=new FPDF('L');
					include('pdf/apqp_chk_imp2.php');
					break;
					
					case "ope":
					// cria followup caso efetue a impressão do arquivo do FMEA de Operação
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Impressão do FMEA de Operação da peça $npc.','O usuário $quem1 imprimiu o FMEA de Operação da peça $npc.','$user')");
					$pdf=new FPDF('L');
					include('pdf/apqp_fmeaope_imp2.php');
					
					break;
			}
		$pdf->Output('relatorio.pdf','I');

unset($ato);
unset($acao);
}
if($acao=="salvar"){  // botão salvar em disco

		include ("classes/jpgraph/jpgraph.php");
		include ("classes/jpgraph/jpgraph_line.php");
		include ("classes/jpgraph/jpgraph_bar.php");
				switch($local){
					
					case "fluxo":					
					// cria followup caso salve em disco o Diagrama de fluxo
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Diagrama de fluxo da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Diagrama de fluxo da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Diagram Fluxo";
					include('pdf/apqp_fluxo_imp2.php');
					break;
					
					case "dimensional": 
					// cria followup caso salve em disco o Ensaio Dimensional
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Ensaio Dimensional da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Ensaio Dimensional da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Ensaio Dimensional";
					if($resc["relatorios"]!="S"){
						include('pdf/apqp_endi_imp2.php');
					}else{
						include('pdf/apqp_endic_imp2.php');
					}
					break;
					
					case "desempenho":
					// cria followup caso salve em disco o Ensaio Desempenho
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Ensaio de Desempenho da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Ensaio de Desempenho da peça $npc.','$user')");
					//					
					$nom="Ensaio Desempenho";
					$pdf=new FPDF();
					$logo="OK";
					if($resc["relatorios"]!="S"){
						include('pdf/apqp_ende_imp2.php');
					}else{
						include('pdf/apqp_endec_imp2.php');
					}
					break;
					
					case "submissao": 
					// cria followup caso salve em disco o Certificado de Submissão
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Certificado de Submissão da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Certificado de Submissão da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Certificado Submissão";
					if($tag=="S"){
						include('pdf/apqp_sub_imp2_2.php');
					} else {
						include('pdf/apqp_sub_imp2_1.php');
					}
					break;
					case "inst": 
					// cria followup caso salve em disco a Instrução do Operador
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo da Instrução do Operador da peça $npc.','O usuário $quem1 salvou em disco o arquivo da Instrução do Operador da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Instrução Operador";
					include('pdf/apqp_inst_imp2.php');
					break;
					
					case "granel": 
					// cria followup caso envie e-mail com anexo da Checklist Material a Granel
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Checklist Material a Granel da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Checklist Material a Granel da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Checklist Material a Granel";
					include('pdf/apqp_granel_imp2.php');
					break;
					
					case "sumario": 
					// cria followup caso salve em disco a Sumário de Aprovação
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo da Sumário de Aprovação da peça $npc.','O usuário $quem1 salvou em disco o arquivo da Sumário de Aprovação da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Sumário e Aprovação APQP";
					include('pdf/apqp_sum_imp_2.php');
					break;
					
					case "capabilidade": 
					// cria followup caso envie e-mail com anexo da Capabilidade
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Envio de e-mail com anexo da Capabilidade da peça $npc.','O usuário $quem1 enviou e-mail com anexo da Capabilidade da peça $npc para $email.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Estudo Capabilidade";
					include('pdf/apqp_cap_imp_2.php');
					break;
					
					case "rr": 
					// cria followup caso salve em disco o Estudo de R&R
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Estudo de R&R da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Estudo de R&R da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Estudo R&R";
					include('pdf/apqp_rr_imp_2.php');
					break;
				
					case "material": 
					// cria followup caso salve em disco o Ensaio de Material
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Ensaio de Material da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Ensaio de Material da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Ensaio Material";
					if($resc["relatorios"]!="S"){
						include('pdf/apqp_enma_imp2.php');
					}else{
						include('pdf/apqp_enmac_imp2.php');
					}
					break;
			
					case "viabilidade":
					// cria followup caso salve em disco a Viabilidade
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo da Viabilidade da peça $npc.','O usuário $quem1 salvou em disco o arquivo do da Viabilidade da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Viabilidade";
					include("pdf/apqp_viabilidade_imp1_2.php");
					break;
			
					case "interina":
					// cria followup caso salve em disco a Aprovação Interina
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo da Aprovação Interina da peça $npc.','O usuário $quem1 salvou em disco o arquivo do da Aprovação Interina da peça $npc.','$user')");
					//
					$pdf=new FPDF();
					$logo="OK";
					$nom="Aprovação Interina";
					include('pdf/apqp_interina_imp.php');
					break;
			
					case "processo":
					// cria followup caso salve em disco o do FMEA de processo
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do FMEA de processo da peça $npc.','O usuário $quem1 salvou em disco o arquivo do FMEA de processo da peça $npc.','$user')");
					//
					$pdf=new FPDF('L');
					$nom="Fmea Processo";
					include("pdf/apqp_fmeaproc_imp2.php");
					break;
		
					case "projeto": 
					// cria followup caso salve em disco o do FMEA de projeto
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do FMEA de projeto da peça $npc.','O usuário $quem1 salvou em disco o arquivo do FMEA de projeto da peça $npc.','$user')");
					//
					$pdf=new FPDF('L');
					$nom="Fmea Projeto";
					include("pdf/apqp_fmeaproj_imp2.php");
					break;
		
					case "controle": 
					// cria followup caso salve em disco o Plano de controle
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Plano de Controle da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Plano de Controle da peça $npc.','$user')");
					//
					$pdf=new FPDF('L');
					$nom="Plano Controle";
					include("pdf/apqp_plano_imp2.php");
					break;
		
					case "crono": 
					// cria followup caso salve em disco o Cronograma
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Cronograma da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Cronograma da peça $npc.','$user')");
					//
					$pdf=new FPDF('L');
					$nom="Cronograma";
					include("pdf/apqp_crono_imp2.php");
					break;
		
					case "aparencia": 
					// cria followup caso salve em disco a Aprovação de Aparência
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo da Aprovação de Aparência da peça $npc.','O usuário $quem1 salvou em disco o arquivo do da Aprovação de Aparência da peça $npc.','$user')");
					//
					$nom="Aprovação Aparência";
					$pdf=new FPDF('L');
					include("pdf/apqp_apro_imp2.php");
					break;
		
					case "chk":
					// cria followup caso salve em disco o Checklist APQP
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do Checklist APQP da peça $npc.','O usuário $quem1 salvou em disco o arquivo do Checklist APQP da peça $npc.','$user')");
					//
					$nom="Checklist APQP";
					$pdf=new FPDF('L');
					include('pdf/apqp_chk_imp2.php');
					break;
			
					case "ope":
					// cria followup caso salve em disco o FMEA de Operação
						mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Salvando em disco o arquivo do FMEA de Operação da peça $npc.','O usuário $quem1 salvou em disco o arquivo do FMEA de Operação da peça $npc.','$user')");
					//
					$nom="Fmea Operações";
					$pdf=new FPDF('L');
					include('pdf/apqp_fmeaope_imp2.php');
					
					break;
			}
		$pdf->Output("$nom $pecaa.pdf",'I');

unset($ato);
unset($acao);
}
?>