<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Metrologia - Inc Lab";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$sql=mysql_query("SELECT * FROM metrologia_lab WHERE metr_lab_id='$id'");
$res=mysql_fetch_array($sql);

if($acao=="alt"){
$cod=$res["metr_lab_codi"];
$data1=banco2data($res["metr_lab_data"]);
$empresa=$res["metr_lab_emp"];
$fantasia=$res["metr_lab_fant"];
$endereco=$res["metr_lab_ende"];
$bairro=$res["metr_lab_bair"];
$cidade=$res["metr_lab_cida"];
$estado=$res["metr_lab_esta"];
$pais=$res["metr_lab_pais"];
$cep=$res["metr_lab_cep"];
$fone=$res["metr_lab_fone"];
$fax=$res["metr_lab_fax"];
$cpf=$res["metr_lab_cpf"];
$cnpj=$res["metr_lab_cnpj"];
$insc_m=$res["metr_lab_insm"];
$insc_e=$res["metr_lab_inse"];
$email=$res["metr_lab_mail"];
$site=$res["metr_lab_site"];
$atualizacao=$res["metr_lab_atual"];
}

$data2=data2banco($data);
$atual="$hora - $quem1";

if($acao=="incluir"){
$cod=strtoupper($cod);

	$sql2=mysql_query("SELECT metr_lab_codi FROM metrologia_lab WHERE metr_lab_codi='$cod'");
	if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="O cadastro do laboratório não foi incluído. Digite outro código para o Laboratório, este já existe!";
		header("Location:metr_lab_cad.php?acao=inc&cod=$cod&data1=$data1&empresa=$empresa&fantasia=$fantasia&endereco=$endereco&bairro=$bairro&cidade=$cidade&pais=$pais&cep=$cep&estado=$estado&fone=$fone&fax=$fax&cpf=$cpf&cnpj=$cnpj&insc_m=$insc_m&insc_e=$insc_e&email=$email&site=$site&atualizacao=$atualizacao");
		exit;		
	}
	
	if(empty($cpf)){
		if(!CalculaCNPJ($cnpj)){
			$_SESSION["mensagem"]="CNPJ Incorreto!";
			header("Location:metr_lab_cad.php?acao=inc&cod=$cod&data1=$data1&empresa=$empresa&fantasia=$fantasia&endereco=$endereco&bairro=$bairro&cidade=$cidade&cep=$cep&estado=$estado&pais=$pais&fone=$fone&fax=$fax&cpf=$cpf&cnpj=$cnpj&insc_m=$insc_m&insc_e=$insc_e&email=$email&site=$site&atualizacao=$atualizacao");
			exit;
		}
	}

	if(empty($cnpj)){
		if(!CalculaCpf($cpf)){
			$_SESSION["mensagem"]="CPF Incorreto!";
			header("Location:metr_lab_cad.php?acao=inc&cod=$cod&data1=$data1&empresa=$empresa&fantasia=$fantasia&endereco=$endereco&bairro=$bairro&cidade=$cidade&cep=$cep&estado=$estado&pais=$pais&fone=$fone&fax=$fax&cpf=$cpf&cnpj=$cnpj&insc_m=$insc_m&insc_e=$insc_e&email=$email&site=$site&atualizacao=$atualizacao");
			exit;
		}
	}
	
	if(empty($cnpj)){
		$sql3=mysql_query("SELECT metr_lab_cpf FROM metrologia_lab WHERE metr_lab_cpf='$cpf'");
		if(!mysql_num_rows($sql3)==0){
			$_SESSION["mensagem"]="Digite outro CPF, este já existe!";
			header("Location:metr_lab_cad.php?acao=inc&cod=$cod&data1=$data1&empresa=$empresa&fantasia=$fantasia&endereco=$endereco&bairro=$bairro&cidade=$cidade&cep=$cep&estado=$estado&pais=$pais&fone=$fone&fax=$fax&cpf=$cpf&cnpj=$cnpj&insc_m=$insc_m&insc_e=$insc_e&email=$email&site=$site&atualizacao=$atualizacao");
			exit;		
		}
	}
	
	if(empty($cpf)){
		$sql4=mysql_query("SELECT metr_lab_cnpj FROM metrologia_lab WHERE metr_lab_cnpj='$cnpj'");
		if(!mysql_num_rows($sql4)==0){
			$_SESSION["mensagem"]="Digite outro CNPJ, este já existe!";
			header("Location:metr_lab_cad.php?acao=inc&cod=$cod&data1=$data1&empresa=$empresa&fantasia=$fantasia&endereco=$endereco&bairro=$bairro&cidade=$cidade&cep=$cep&estado=$estado&pais=$pais&fone=$fone&fax=$fax&cpf=$cpf&cnpj=$cnpj&insc_m=$insc_m&insc_e=$insc_e&email=$email&site=$site&atualizacao=$atualizacao");
			exit;		
		}
	}
	
	$sql=mysql_query("INSERT INTO metrologia_lab (metr_lab_codi, metr_lab_data, metr_lab_emp, metr_lab_fant, metr_lab_ende, metr_lab_bair, metr_lab_cida, metr_lab_cep, metr_lab_esta, metr_lab_pais, metr_lab_fone, metr_lab_fax, metr_lab_cpf, metr_lab_cnpj, metr_lab_insm, metr_lab_inse, metr_lab_mail, metr_lab_site, metr_lab_atual) VALUES ('$cod', '$data2', '$empresa', '$fantasia', '$endereco', '$bairro', '$cidade', '$cep', '$estado', '$pais', '$fone', '$fax', '$cpf', '$cnpj', '$insc_m', '$insc_e', '$email', '$site', '$atual')");
	if($sql){
		$_SESSION["mensagem"]="Laboratório incluído com sucesso!";
		// cria followup caso inclua um laboratório
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Laboratório.','O usuário $quem1 incluiu um novo Laboratório chamado $fantasia.','$user')");
		//	
		header("Location:metr_lab_busca.php");
		exit;
	}else{
		$_SESSION["mensagem"]="O Laboratório não pôde ser incluído!";
	}
}

if($acao=="alterar"){
	$sql=mysql_query("UPDATE metrologia_lab SET metr_lab_codi='$cod', metr_lab_data='$data2', metr_lab_emp='$empresa', metr_lab_fant='$fantasia', metr_lab_ende='$endereco', metr_lab_bair='$bairro', metr_lab_cida='$cidade', metr_lab_cep='$cep', metr_lab_esta='$estado', metr_lab_pais='$pais', metr_lab_fone='$fone', metr_lab_fax='$fax' ,metr_lab_cpf='$cpf', metr_lab_cnpj='$cnpj', metr_lab_insm='$insc_m', metr_lab_inse='$insc_e', metr_lab_mail='$email', metr_lab_site='$site', metr_lab_atual='$atual' WHERE metr_lab_id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Instrumento foi alterado com sucesso!";
		// cria followup caso altere o laboratório
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro do Laboratório.','O usuário $quem1 alterou o cadastro do Laboratório $fantasia.','$user')");
		//	
		header("Location:metr_lab_busca.php");
		exit;		
	}else {
		$_SESSION["mensagem"]="O Instrumento não pôde ser alterado!";
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function bloqueia(){
	if(!form1.cpf.value==''){
		document.all.cnpj.style.background="silver";
		document.form1.cnpj.disabled=true;
	}else{
		document.all.cnpj.style.background="white";
		document.form1.cnpj.disabled=false;
	}
}
function bloqueia2(){
	if(!form1.cnpj.value==''){
		document.all.cpf.style.background="silver";
		document.form1.cpf.disabled=true;
	}else{
		document.all.cpf.style.background="white";
		document.form1.cpf.disabled=false;
	}
}
function verifica(cad){
	if(cad.cod.value==''){
		alert('Preencha o Código.');
		cad.cod.focus();
		return false;
	}
	if(cad.data.value==''){
		alert('Preencha a Data do Cadastro.');
		cad.data.focus();
		return false;
	}	
	if(cad.empresa.value==''){
		alert('Preencha a Empresa.');
		cad.empresa.focus();
		return false;
	}
	if(cad.fantasia.value==''){
		alert('Preencha a Fantasia.');
		cad.fantasia.focus();
		return false;
	}
	if(cad.endereco.value==''){
		alert('Preencha o Endereço.');
		cad.endereco.focus();
		return false;
	}
	if(cad.bairro.value==''){
		alert('Preencha o Bairro.');
		cad.bairro.focus();
		return false;
	}
	if(cad.cidade.value==''){
		alert('Preencha a Cidade.');
		cad.cidade.focus();
		return false;
	}
	if(cad.pais.value==''){
		alert('Preencha o País.');
		cad.pais.focus();
		return false;
	}
	if(cad.cep.value==''){
		alert('Preencha o CEP.');
		cad.cep.focus();
		return false;
	}
	if(cad.fone.value==''){
		alert('Preencha o Fone.');
		cad.fone.focus();
		return false;
	}
	if(cad.cpf.value==''){
		if(cad.cnpj.value==''){
			alert('Preencha o CPF ou o CNPJ.');
			cad.cpf.focus();
			return false;
		}
	}
	if(cad.email.value==''){
		alert('Preencha o E-mail.');
		cad.email.focus();
		return false;
	}
	return true;
}
</script>
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="384" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="406" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="texto">
      <tr>
        <td width="16" align="center"><div align="left"><a href="#" onClick=""><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver=""></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="344" align="right"><div align="left" class="textobold style1"><span class="titulos">Metrologia &gt; Cadastro de Laborat&oacute;rio - Geral </span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr> 
    <td width="376"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="394" border="0" cellpadding="0" cellspacing="3">
            <tr>
              <td width="127" class="textobold">C&oacute;digo: </td>
              <td width="258"><table width="108%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="29%"><span class="textobold">
                      <input name="cod" type="text" class="formulario" id="cod" size="10" maxlength="10" value="<?php print $cod;?>" <?php if($acao=="alt"){ print "readonly"; } ?>>
                    </span></td>
                    <td width="38%" class="textobold"><div align="center">Data do Cadastro :</div></td>
                    <td width="33%" class="textobold"><input name="data1" type="text" class="formulario" id="data1" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="10" maxlength="10" value="<?php print $data1;?>">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_lab_cad','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td class="textobold">Empresa:</td>
              <td class="textobold"><input name="empresa" type="text" class="formulario" id="empresa" size="50" maxlength="50" value="<?php print $empresa;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Fantasia:</td>
              <td class="textobold"><input name="fantasia" type="text" class="formulario" id="fantasia" size="50" maxlength="50" value="<?php print $fantasia;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Endere&ccedil;o:</td>
              <td><input name="endereco" type="text" class="formulario" id="endereco" size="50" maxlength="50" value="<?php print $endereco;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Bairro: </td>
              <td><input name="bairro" type="text" class="formulario" id="bairro" size="50" maxlength="50" value="<?php print $bairro;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Cidade:</td>
              <td><input name="cidade" type="text" class="formulario" id="cidade" size="50" maxlength="50" value="<?php print $cidade;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Cep: </td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="56%"><input name="cep" type="text" class="formulario" id="cep" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" value="<?php print $cep;?>"></td>
                  <td width="23%"><span class="textobold">Estado:</span></td>
                  <td width="21%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
                    <select name="estado" class="formulario" id="UF">
                      <option value="AC"<?php if($estado=="AC") print "selected"; ?>>AC</option>
                      <option value="AL"<?php if($estado=="AL") print "selected"; ?>>AL</option>
                      <option value="AM"<?php if($estado=="AM") print "selected"; ?>>AM</option>
                      <option value="AP"<?php if($estado=="AP") print "selected"; ?>>AP</option>
                      <option value="BA"<?php if($estado=="BA") print "selected"; ?>>BA</option>
                      <option value="CE"<?php if($estado=="CE") print "selected"; ?>>CE</option>
                      <option value="DF"<?php if($estado=="DF") print "selected"; ?>>DF</option>
                      <option value="ES"<?php if($estado=="ES") print "selected"; ?>>ES</option>
                      <option value="GO"<?php if($estado=="GO") print "selected"; ?>>GO</option>
                      <option value="MA"<?php if($estado=="MA") print "selected"; ?>>MA</option>
                      <option value="MG"<?php if($estado=="MG") print "selected"; ?>>MG</option>
                      <option value="MS"<?php if($estado=="MS") print "selected"; ?>>MS</option>
                      <option value="MT"<?php if($estado=="MT") print "selected"; ?>>MT</option>
                      <option value="PA"<?php if($estado=="PA") print "selected"; ?>>PA</option>
                      <option value="PB"<?php if($estado=="PB") print "selected"; ?>>PB</option>
                      <option value="PE"<?php if($estado=="PE") print "selected"; ?>>PE</option>
                      <option value="PI"<?php if($estado=="PI") print "selected"; ?>>PI</option>
                      <option value="PR"<?php if($estado=="PR") print "selected"; ?>>PR</option>
                      <option value="RJ"<?php if($estado=="RJ") print "selected"; ?>>RJ</option>
                      <option value="RN"<?php if($estado=="RN") print "selected"; ?>>RN</option>
                      <option value="RO"<?php if($estado=="RO") print "selected"; ?>>RO</option>
                      <option value="RR"<?php if($estado=="RR") print "selected"; ?>>RR</option>
                      <option value="RS"<?php if($estado=="RS") print "selected"; ?>>RS</option>
                      <option value="SC"<?php if($estado=="SC") print "selected"; ?>>SC</option>
                      <option value="SE"<?php if($estado=="SE") print "selected"; ?>>SE</option>
                      <option value="SP"<?php if($estado=="SP" or empty($estado)) print "selected"; ?>>SP</option>
                      <option value="TO"<?php if($estado=="TO") print "selected"; ?>>TO</option>
                    </select>
                  </font></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td class="textobold">Pa&iacute;s:</td>
              <td><input name="pais" type="text" class="formulario" id="pais" size="50" maxlength="50" value="<?php print $pais;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Fone:</td>
              <td><input name="fone" type="text" class="formulario" id="fone" size="20" maxlength="9" value="<?php print $fone;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Fax:</td>
              <td><input name="fax" type="text" class="formulario" id="fax" size="20" maxlength="9" value="<?php print $fax;?>"></td>
            </tr>
            <tr>
              <td class="textobold">CPF:</td>
              <td><input name="cpf" type="text" class="formulario" id="cpf" size="20" maxlength="14" onKeyPress="return validanum(this, event)" onKeyUp="mcpf(this)" onBlur="bloqueia();" value="<?php print $cpf;?>" <?php if($acao=="alt"){ print "readonly"; } ?>></td>
            </tr>
            <tr>
              <td class="textobold">CNPJ:</td>
              <td><input name="cnpj" type="text" class="formulario" id="cnpj" size="20" maxlength="15" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)" onBlur="bloqueia2();" value="<?php print $cnpj;?>" <?php if($acao=="alt"){ print "readonly"; } ?>></td>
            </tr>
            <tr>
              <td class="textobold">Incri&ccedil;&atilde;o Municipal:</td>
              <td><input name="insc_m" type="text" class="formulario" id="insc_m" size="20" maxlength="20" value="<?php print $insc_m;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Incri&ccedil;&atilde;o Estadual:</td>
              <td><input name="insc_e" type="text" class="formulario" id="insc_e" size="20" maxlength="20" value="<?php print $insc_e;?>"></td>
            </tr>
            <tr>
              <td class="textobold">E-mail:</td>
              <td><input name="email" type="text" class="formulario" id="email" size="50" maxlength="50" value="<?php print $email;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Site:</td>
              <td><input name="site" type="text" class="formulario" id="site" size="50" maxlength="50" value="<?php print $site;?>"></td>
            </tr>
            <tr>
              <td class="textobold">&Uacute;ltima Atualiza&ccedil;&atilde;o: </td>
              <td><input name="atualizacao" type="text" class="formulario" id="atualizacao" size="50" maxlength="50" value="<?php echo $atualizacao; ?>" readonly=""></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="73%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><span class="textobold">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='metr_lab_busca.php';">
&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if ($acao=="alt"){ ?>
			<input name="Alterar" type="submit" class="microtxt" value="Alterar">
			<?php } ?>
			<?php if($acao=="inc"){ ?>
			<input name="Incluir" type="submit" class="microtxt" id="Incluir" value="Incluir">
			<?php } ?>
			<input type="hidden" name="acao" id="acao2"	value="<?php if($acao=="alt"){ print "alterar"; } else if($acao=="inc"){ print "incluir"; } ?>">
			<input type="hidden" name="id" value= <?php print $id;?>>
          </span></div></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>