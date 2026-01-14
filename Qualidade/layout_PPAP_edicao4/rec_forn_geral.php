<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="inc";
if(!empty($acao)){
	$loc="Fornecedores";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	if(empty($cpf)){
		if(!CalculaCNPJ($cnpj)){
				$_SESSION["mensagem"]="CNPJ Incorreto!";
				header("Location:fornecedores_geral.php?acao=inc&codigo=$codigo&nome=$nome&fantasia=$fantasia&endereco=$endereco&bairro=$bairro&cidade=$cidade&estado=$estado&cep=$cep&tipo=$tipo&cpf=$cpf&cnpj=$cnpj&fone=$fone&ie=$ie&im=$im&email=$email&site=$site&municipal=$municipal&inss=$inss");
				exit;
		}
	}
	if(empty($cnpj)){
		if(!CalculaCpf($cpf)){
				$_SESSION["mensagem"]="CPF Incorreto!";
				header("Location:fornecedores_geral.php?acao=inc&codigo=$codigo&nome=$nome&fantasia=$fantasia&endereco=$endereco&bairro=$bairro&cidade=$cidade&estado=$estado&cep=$cep&tipo=$tipo&cpf=$cpf&cnpj=$cnpj&fone=$fone&ie=$ie&im=$im&email=$email&site=$site&municipal=$municipal&inss=$inss");
				exit;
		}
	}
		if(empty($fantasia)) $fantasia=$nome;
		$sql=mysql_query("INSERT INTO fornecedores (codigo,loja,nome,fantasia,endereco,bairro,cidade,estado,cep,tipo,cpf,cnpj,fone,fax,cxpostal,ie,im,contato,contabil,banco,transp,prioridade,departamento,representante,email,site,municipal,inss) VALUES ('$codigo','$loja','$nome','$fantasia','$endereco','$bairro','$cidade','$estado','$cep','$tipo','$cpf','$cnpj','$fone','$fax','$cxpostal','$ie','$im','$contato','$contabil','$banco','$transp','$prioridade','$departamento','$representante','$email','$site','$municipal','$inss')");
		if($sql){
			$_SESSION["mensagem"]="Cadastro geral concluído!";
			$sql=mysql_query("select max(id)as maxid from fornecedores");
			$res=mysql_fetch_array($sql);
			$id=$res["maxid"];
			header("Location:rec_forn_geral.php");
			exit;
		}else{
			$_SESSION["mensagem"]="O cadastro geral não pôde ser concluído!";
			$acao="inc";
		}	
}elseif($acao=="alterar"){
	if(empty($cpf)){
		if(!CalculaCNPJ($cnpj)){
				$_SESSION["mensagem"]="CNPJ Incorreto!";
				header("Location:fornecedores_geral.php?acao=alt&id=$id");
				exit;
		}
	}
	if(empty($cnpj)){
		if(!CalculaCpf($cpf)){
				$_SESSION["mensagem"]="CPF Incorreto!";
				header("Location:fornecedores_geral.php?acao=alt&id=$id");
				exit;
		}
	}
		if(empty($fantasia)) $fantasia=$nome;
		$sql=mysql_query("UPDATE fornecedores SET codigo='$codigo',loja='$loja',nome='$nome',fantasia='$fantasia',endereco='$endereco',bairro='$bairro',cidade='$cidade',estado='$estado',cep='$cep',tipo='$tipo',cpf='$cpf',cnpj='$cnpj',fone='$fone',fax='$fax',cxpostal='$cxpostal',ie='$ie',im='$im',contato='$contato',contabil='$contabil',banco='$banco',transp='$transp',prioridade='$prioridade',departamento='$departamento',representante='$representante',email='$email',site='$site',municipal='$municipal',inss='$inss' WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Cadastro geral alterado!";
			header("Location:rec_forn_geral.php?bcod=$bcod&bnome=$bnome");
			exit;		
		}else{
			$_SESSION["mensagem"]="O cadastro geral não pôde ser alterado!";
			$acao="alt";
		}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM fornecedores WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$codigo=$res["codigo"];
	$nome=$res["nome"];
	$fantasia=$res["fantasia"];
	$endereco=$res["endereco"];
	$bairro=$res["bairro"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
	$cep=$res["cep"];
	$tipo=$res["tipo"];
	$cpf=$res["cpf"];
	$cnpj=$res["cnpj"];
	$fone=$res["fone"];
	$ie=$res["ie"];
	$im=$res["im"];
	$email=$res["email"];
	$site=$res["site"];
	$municipal=$res["municipal"];
	$inss=$res["inss"];
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
	if(cad.nome.value==''){
		alert('Preencha o Nome');
		cad.nome.focus();
		return false;
	}
	if(cad.fantasia.value==''){
		alert('Preencha a fantasia');
		cad.fantasia.focus();
		return false;
	}
	if(cad.endereco.value==''){
		alert('Preencha o Endereço');
		cad.endereco.focus();
		return false;
	}
	if(cad.bairro.value==''){
		alert('Preencha o Bairro');
		cad.bairro.focus();
		return false;
	}
	if(cad.cep.value==''){
		alert('Preencha o CEP');
		cad.cep.focus();
		return false;
	}
	if(cad.cidade.value==''){
		alert('Preencha a Cidade');
		cad.cidade.focus();
		return false;
	}
	if(cad.fone.value==''){
		alert('Preencha o Fone');
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
		alert('Preencha o e-mail');
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
    <td><table width="364" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="texto">
      <tr>
        <td width="29" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="335" align="right"><div align="left"><span class="textobold style1 style1 style1">Recebimento &gt; Cadastro 
          &gt; Fornecedores</span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td width="376"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="102%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="377" border="0" cellpadding="0" cellspacing="3">
            <tr class="textobold">
              <td>&nbsp;C&oacute;digo: </td>
              <td><input name="codigo" type="text" class="formulario" id="codigo" value="<?php print $codigo; ?>" size="10" maxlength="10" alt="Testeeee"></td>
            </tr>

            <tr class="textobold">
              <td width="116">&nbsp;Empresa:</td>
              <td width="252"><input name="nome" type="text" class="formulario" id="nome" value="<?php print $nome; ?>" size="50" maxlength="100"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Fantasia:</td>
              <td><input name="fantasia" type="text" class="formulario" id="fantasia" value="<?php print $fantasia; ?>" size="50" maxlength="30"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Endere&ccedil;o:</td>
              <td><input name="endereco" type="text" class="formulario" id="endereco" value="<?php print $endereco; ?>" size="50" maxlength="100"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Bairro:</td>
              <td><input name="bairro" type="text" class="formulario" id="bairro" value="<?php print $bairro; ?>" size="50" maxlength="30"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Cidade:</td>
              <td><input name="cidade" type="text" class="formulario" id="cidade" value="<?php print $cidade; ?>" size="50" maxlength="30"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;CEP: </td>
              <td><input name="cep" type="text" class="formulario" id="cep" value="<?php print $cep; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Estado:</td>
              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
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
            <tr class="textobold">
              <td>&nbsp;Fone:</td>
              <td><input name="fone" type="text" class="formulario" id="fone" value="<?php print $fone; ?>" size="10" maxlength="9"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;CPF:</td>
              <td><input name="cpf" type="text" class="formulario" id="cpf"  size="20" maxlength="15" onKeyPress="return validanum(this, event)" onKeyUp="mcpf(this)" onBlur="bloqueia();" value="<?php print $cpf; ?>"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;CNPJ:</td>
              <td><input name="cnpj" type="text" class="formulario" id="cnpj" value="<?php print $cnpj; ?>" size="20" maxlength="15" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)" onBlur="bloqueia2();"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Ins. Estadual:</td>
              <td><input name="ie" type="text" class="formulario" id="ie" value="<?php print $ie; ?>" size="20" maxlength="20"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Ins. Municipal:</td>
              <td><input name="im" type="text" class="formulario" id="im" value="<?php print $im; ?>" size="20" maxlength="20"></td>
            </tr>
            <tr class="textobold">
              <td height="23">&nbsp;Email:</td>
              <td><input name="email" type="text" class="formulario" id="email" value="<?php print $email; ?>" size="50" maxlength="50"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Site:</td>
              <td><input name="site" type="text" class="formulario" id="site" value="<?php print $site; ?>" size="50" maxlength="50"></td>
            </tr>

          </table></td>
        </tr>
      </table>
      <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center">
            <input name="id" type="hidden" id="id2" value="<?php print $id; ?>">
            <input name="acao" type="hidden" id="acao2" value="<?php if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='rec_forn_busca.php<?php if(!empty($bcod) or!empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>';">
  &nbsp;&nbsp;&nbsp;&nbsp;
  <?php if($acao=="inc"){?>
  <input name="button122" type="submit" class="microtxt" value="Incluir">
  <?php } else if($acao=="alt"){?>
  <input name="button122" type="submit" class="microtxt" value="Alterar">
  <?php } ?>
          </div></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
  
</body>
</html>
<?php include("mensagem.php"); ?>