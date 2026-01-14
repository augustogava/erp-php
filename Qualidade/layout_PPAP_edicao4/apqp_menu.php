<?php
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];

$_SESSION["modulo"]="";
if($menu=="S"){
	$_SESSION["mpc"]=$pc;
	$_SESSION["npc"]="($num - $rev)";
}else{
	$pc=$_SESSION["mpc"];
	$npc=$_SESSION["npc"];
}
if(!empty($acao)){
	$loc="APQP";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="exc"){
		//verificar Cliente
		$apqp->cliente_apro("apqp_menu.php");
		// - - - - - - - -  -
	// cria followup caso exclua a peça 
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão da peça $npc.','O usuário $quem1 efetuou a exclusão de peça $npc.','$user')");
	//
	$sql=mysql_query("DELETE FROM apqp_pc WHERE id='$id'") or erp_db_fail();
	$_SESSION["mensagem"]="Exluido com sucesso!";
	header("Location:apqp_pc.php");
	exit;
}
$funcionario=$_SESSION["login_funcionario"];
if($funcionario=="N"){
	header("location:apqp_menu2.php");
	exit;
}
$sqlm=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
$resm=mysql_fetch_array($sqlm);
if($resm["status"]==2){
	$js="window.alert('Não pode ser exluida, peça já foi aprovada!')";
}else{
	$js="return ask('Clique em confirmar para excluir a peça','Você tem certeza que deseja excluir a peça!','Todos os dados contido nesta peça será excluido permanentemente! Confirma a exclusão?','Todos os dados contido nesta peça será excluido permanentemente! Confirme a Exclusão?','apqp_menu.php?acao=exc&id=$pc')";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function ask(wmsg,wmsg2,wmsg3,wsim){
	if(confirm(wmsg)){
			if(confirm(wmsg2)){
				if(confirm(wmsg3)){
					window.location.href = wsim;
				}
			}
	}
	return false;
}
function someini(){
	apqp4.style.display = 'inline';
	minmax4.src='imagens/icon14_min.gif';			
	pos4=false;
	apqp1.style.display = 'inline';
	minmax1.src='imagens/icon14_max.gif';			
	pos1=true;
	apqp2.style.display = 'none';
	minmax2.src='imagens/icon14_max.gif';
	pos2=true;
	apqp3.style.display = 'none';
	minmax3.src='imagens/icon14_max.gif';
	pos3=true;
}
function some(num){
	if(pos1==false && num=='1'){
		apqp1.style.display = 'none';
		minmax1.src='imagens/icon14_max.gif';
		pos1=true;
	}else if(num=='1'){
		apqp1.style.display = 'inline';
		minmax1.src='imagens/icon14_min.gif';
		pos1=false;
	}
	
	if(pos2==false && num=='2'){
		apqp2.style.display = 'none';
		minmax2.src='imagens/icon14_max.gif';
		pos2=true;
	}else if(num=='2'){
		apqp2.style.display = 'inline';
		minmax2.src='imagens/icon14_min.gif';
		pos2=false;
	}
	
	if(pos3==false && num=='3'){
		apqp3.style.display = 'none';
		minmax3.src='imagens/icon14_max.gif';
		pos3=true;
	}else if(num=='3'){
		apqp3.style.display = 'inline';
		minmax3.src='imagens/icon14_min.gif';
		pos3=false;
	}
	
	if(pos4==false && num=='4'){
		apqp4.style.display = 'none';
		minmax4.src='imagens/icon14_max.gif';
		pos4=true;
	}else if(num=='4'){
		apqp4.style.display = 'inline';
		minmax4.src='imagens/icon14_min.gif';
		pos4=false;
	}
	return false;
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_STICKY=true; this.T_TITLE='APQP Documentação'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Esta é a pagina principal para fazermos o estudo de uma peça, que é dividida em duas partes, Cadastro e APQP.')"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Documenta&ccedil;&atilde;o <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="600"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="594"><table width="594" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="569" class="textoboldbranco">&nbsp;CADASTRO</td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('4');"><img src="imagens/icon14_min.gif" name="minmax4" width="16" height="16" border="0" id="minmax4"></a></td>
            </tr>
            <tr align="left" bgcolor="#FFFFFF">
              <td colspan="2" id="apqp4"><table width="475" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="118"><a href="apqp_pc2.php?acao=alt&id=<?php print $pc; ?>"><img src="imagens/inst_4.jpg" alt="Pe&ccedil;as" width="30" height="30" border="0"></a></td>
                    <td width="118"><a href="apqp_car.php?id=<?php print $pc; ?>&acao=inc"><img src="imagens/inst_5.jpg" alt="Caracter&iacute;sticas" width="30" height="30" border="0"></a></td>
                    <td width="118"><a href="apqp_op.php?id=<?php print $pc; ?>"><img src="imagens/apqp_instru.gif" alt="Opera&ccedil;&otilde;es" width="32" height="32" border="0"></a></td>
                    <td width="118"><a href="#" onClick="<?php echo  $js; ?>" class="textobold"><img src="imagens/icon20_lixeira.gif" alt="Excluir" width="20" height="20" border="0"></a></td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="118"><a href="apqp_pc2.php?acao=alt&id=<?php print $pc; ?>" class="textobold">Pe&ccedil;a</a>s</td>
                    <td width="118"><a href="apqp_car.php?id=<?php print $pc; ?>&acao=inc" class="textobold">Caracter&iacute;sticas</a></td>
                    <td width="118"><a href="apqp_op.php?id=<?php print $pc; ?>" class="textobold">Opera&ccedil;&otilde;es</a></td>
                    <td width="118"><a href="#" onClick="<?php echo  $js; ?>" class="textobold">Excluir Pe&ccedil;a</a> </td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="200" height="3"></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="569" class="textoboldbranco">&nbsp;APQP</td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('1');"><img src="imagens/icon14_min.gif" name="minmax1" width="16" height="16" border="0" id="minmax1"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp1" colspan="2"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="118"><a href="apqp_crono.php"><img src="imagens/apqp_crono.gif" alt="Cronograma" width="32" height="32" border="0"></a></td>
                    <td width="118"><a href="apqp_doc.php"><img src="imagens/apqp_docu.gif" alt="Documentos" width="32" height="32" border="0"></a></td>
                    <td width="118">
			<?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Desenho (Se aplicável)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_des.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_desen.gif" alt="Desenhos" width="32" height="32" border="0"></a>
					</td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_fmeaprojc.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_fmeaproj.gif" alt="Fmea Proj." width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Viabilidade' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_viabilidade1.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_viab.gif" alt="Viabilidade" width="32" height="32" border="0"></a></td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="118"><a href="apqp_crono.php" class="textobold">Cronograma</a></td>
                    <td width="118"><a href="apqp_doc.php" class="textobold">Documentos</a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Desenho (Se aplicável)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_des.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Desenhos</a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='FMEA de Projeto (Se aplicável)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_fmeaprojc.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>FMEA de Projeto</a> </td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Viabilidade' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_viabilidade1.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Viabilidade</a></td>
                  </tr>
                  <tr align="center">
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Diagrama de Fluxo' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_fluxo.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_fluxo.gif" alt="Fluxo" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='FMEA de Processo' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_fmeaprocc.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_fmeaproc.gif" alt="Fmea Proc." width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Plano de Controle' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_planoc.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_plano.gif" alt="Plano Controle" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Instruções do Operador' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_inst.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_instru.gif" alt="Int. Operador" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Estudos de R&R' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_rr.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_rr.gif" alt="R&amp;R" width="32" height="32" border="0"></a></td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Diagrama de Fluxo' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_fluxo.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Diagrama de Fluxo</a> </td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='FMEA de Processo' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_fmeaprocc.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>FMEA de Processo</a> </td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Plano de Controle' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_planoc.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Plano de Controle</a> </td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Instruções do Operador' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_inst.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Instru&ccedil;&otilde;es do Operador </a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Estudos de R&R' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_rr.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Estudos da R&amp;R</a> </td>
                  </tr>
                  <tr align="center">
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Estudos de Capabilidade' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_cap.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_capa.gif" alt="Capabilidade" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Ensaio Dimensional' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_endi.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_dimen.gif" alt="Dimensional" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Ensaio Material' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_enma.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_material.gif" alt="Material" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Ensaio Desempenho' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_ende.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_desem.gif" alt="Desempenho" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Relatório de Aprovação de Aparência (Se aplicável)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_aproc.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_apar.gif" alt="Apar&ecirc;ncia" width="32" height="32" border="0"></a></td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Estudos de Capabilidade' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_cap.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Estudos de Capabilidade </a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Ensaio Dimensional' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_endi.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Ensaio Dimensional</a> </td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Ensaio Material' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_enma.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Ensaio Material</a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Ensaio Desempenho' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_ende.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Ensaio Desempenho</a> </td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Relatório de Aprovação de Aparência (Se aplicável)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_aproc.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Aprova&ccedil;&atilde;o de Apar&ecirc;ncia </a></td>
                  </tr>
                  <tr align="center">
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Certificado de Submissão' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_sub1.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_subm.gif" alt="Submiss&atilde;o" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Sumario de Aprovação do APQP (Validação final)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_sum1.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/apqp_sumapro.gif" alt="Aprova&ccedil;&atilde;o" width="32" height="32" border="0"></a></td>
                    <td width="118"><a href="apqp_granelt.php"><img src="imagens/apqp_check.gif" alt="Checklist Granel" width="32" height="32" border="0"></a></td>
                    <td width="118"><a href="apqp_chk.php"><img src="imagens/apqp_checkapqp.gif" alt="Checklist APQP" width="32" height="32" border="0"></a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Interina' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_apro_int1.php\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\">";
			}
			?>
					<?php echo  $link; ?><img src="imagens/logo.png" alt="Aprov. Interina" width="44" height="32" border="0"></a></td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Certificado de Submissão' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_sub1.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Certifica&ccedil;&atilde;o de Submiss&atilde;o </a></td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Sumario de Aprovação do APQP (Validação final)' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_sum1.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Sum&aacute;rio e Aprova&ccedil;&atilde;o do APQP</a> </td>
                    <td width="118"><a href="apqp_granelt.php" class="textobold">Checklist Material a Granel</a></td>
                    <td width="118"><a href="apqp_chk.php" class="textobold">Checklist APQP</a> </td>
                    <td width="118"><?php
			$sql=mysql_query("select * from apqp_cron WHERE peca='$pc' AND ativ='Interina' AND responsavel<>''");
			if(mysql_num_rows($sql)){
				$link="<a href=\"apqp_apro_int1.php\" class=\"textobold\">";
			}else{
				$link="<a href=\"#\" onclick=\"window.alert('Documento bloqueado! Pois não faz parte do Cronograma.')\" class=\"textobold\">";
			}
			?>
					<?php echo  $link; ?>Aprova&ccedil;&atilde;o Interina</a></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="200" height="3"></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="569" class="textoboldbranco">&nbsp;VDA</td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('2');"><img src="imagens/icon14_min.gif" name="minmax2" width="16" height="16" border="0" id="minmax2"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp2" colspan="2"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="118"><a href="vda_foc_pc.php"><img src="imagens/apqp_vdacapa.gif" width="32" height="32" border="0"></a></td>
                    <td width="118"><img src="imagens/apqp_ensdim.gif" width="32" height="32"></td>
                    <td width="118"><img src="imagens/apqp_ensmat.gif" width="32" height="32"></td>
                    <td width="118"><img src="imagens/apqp_ensdes.gif" width="32" height="32"></td>
                    <td width="118"><img src="imagens/apqp_relvda.gif" width="32" height="32"></td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="118"><a href="vda_foc_pc.php" class="textobold">VDA Folha Capa </a></td>
                    <td width="118">Ensaio Dimensional </td>
                    <td width="118">Ensaio Material </td>
                    <td width="118">Ensaio Desempenho</td>
                    <td width="118">Relat&oacute;rio VDA de Inspe&ccedil;&atilde;o de amostras iniciais </td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="imagens/dot.gif" width="200" height="3"></td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td width="569" class="textoboldbranco">&nbsp;Espec&iacute;ficos</td>
              <td width="22" align="center" class="textoboldbranco"><a href="#" onClick="return some('3');"><img src="imagens/icon14_min.gif" name="minmax3" width="16" height="16" border="0" id="minmax3"></a></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td id="apqp3" colspan="2"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="118"><img src="imagens/apqp_psarai.gif" width="32" height="32"></td>
                    <td width="118"><img src="imagens/apqp_psapva.gif" width="32" height="32"></td>
                    <td width="118">&nbsp;</td>
                    <td width="118">&nbsp;</td>
                    <td width="118">&nbsp;</td>
                  </tr>
                  <tr align="center" class="textobold">
                    <td width="118">PSA - RAI </td>
                    <td width="118">PSA - PVA (Visualizar) </td>
                    <td width="118">&nbsp;</td>
                    <td width="118">&nbsp;</td>
                    <td width="118">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top"><img src="imagens/dot.gif" width="200" height="10"></td>
      </tr>
      <tr>
        <td align="center" valign="top"><p>
            <input name="Button" type="button" class="microtxt" onClick="window.location='apqp_pc.php';" value="Voltar">
        </p></td>
      </tr>
      <script>someini();</script>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>