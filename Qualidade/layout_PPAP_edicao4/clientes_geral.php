<?php
include("conecta.php");
include("seguranca.php");
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];
$npc=$_SESSION["npc"];
$apqp=new set_apqp;

unset($_SESSION["mpc"]);
if(!empty($acao)){
	$loc="Clientes Login";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="inc";
if($acao=="incluir"){
	foreach($_REQUEST as $name=>$valor){
		$$name=$valor;
	}
	$comissao=valor2banco($comissao);
		if(empty($cpf)){
			if(!CalculaCNPJ($cnpj)){
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:clientes_geral.php?acao=inc&cod_forn=$cod_forn&nome=$nome&fantasia=$fantasia&loja=$loja&status=$status&tipo=$tipo&atividade=$atividade&endereco=$endereco&bairro=$bairro&cep=$cep&cidade=$cidade&estado=$estado&fone=$fone&fax=$fax&contato=$contato&departamento=$departamento&cpf=$cpf&cnpj=$cnpj&ie=$ie&im=$im&vendedor=$vendedor&comissao=$comissao&regiao=$regiao$contabil=$contabil&banco1=$banco1&banco2=$banco2&banco3=$banco3&banco4=$banco4&banco5=$banco5&email=$email&site=$site&logo=$logo&tag=$tag&relatorios=$relatorios");
					exit;
			}
		}
		if(empty($cnpj)){
			if(!CalculaCpf($cpf)){
					$_SESSION["mensagem"]="CPF Incorreto!";
					header("Location:clientes_geral.php?acao=inc&cod_forn=$cod_forn&nome=$nome&fantasia=$fantasia&loja=$loja&status=$status&tipo=$tipo&atividade=$atividade&endereco=$endereco&bairro=$bairro&cep=$cep&cidade=$cidade&estado=$estado&fone=$fone&fax=$fax&contato=$contato&departamento=$departamento&cpf=$cpf&cnpj=$cnpj&ie=$ie&im=$im&vendedor=$vendedor&comissao=$comissao&regiao=$regiao$contabil=$contabil&banco1=$banco1&banco2=$banco2&banco3=$banco3&banco4=$banco4&banco5=$banco5&email=$email&site=$site&logo=$logo&tag=$tag&relatorios=$relatorios");
					exit;
			}
		}
		if(empty($fantasia)) $fantasia=$nome;
		$sql=mysql_query("INSERT INTO clientes (loja,cod_forn,nome,fantasia,status,tipo,atividade,endereco,bairro,cep,cidade,estado,fone,fax,contato,departamento,cnpj,cpf,ie,im,vendedor,comissao,regiao,contabil,banco1,banco2,banco3,banco4,banco5,email,site,logo,tag,relatorios) VALUES ('$loja','cod_forn','$nome','$fantasia','$status','$tipo','$atividade','$endereco','$bairro','$cep','$cidade','$estado','$fone','$fax','$contato','$departamento','$cnpj','$cpf','$ie','$im','$vendedor','$comissao','$regiao','$contabil','$banco1','$banco2','$banco3','$banco4','$banco5','$email','$site','$logo','$tag','$relatorios')");
		if($sql){
			$_SESSION["mensagem"]="Cadastro geral concluído!";
			// cria followup caso inclua um simbolo
				$sql_emp=mysql_query("SELECT fantasia FROM empresa");
				$res_emp=mysql_fetch_array($sql_emp);
				mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Cadastro Geral de Clientes.','O usuário $quem1 incluiu o cadastro do cliente $fantasia.','$user')");
			//					
			$sql=mysql_query("select max(id)as maxid from clientes");
			$res=mysql_fetch_array($sql);
			$id=$res["maxid"];
			header("Location:clientes_cobranca.php?id=$id&acao=inc&bcod=$bcod&bnome=$bnome");
			exit;
		}else{
			$_SESSION["mensagem"]="O cadastro geral não pôde ser concluído!";
			$comissao=banco2valor($comissao);		
			$acao="inc";
		}	
}elseif($acao=="alterar"){
		if(empty($cpf)){
			if(!CalculaCNPJ($cnpj)){			
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:clientes_geral.php?acao=alt&id=$id");
					exit;
			}
		}
		if(empty($cnpj)){
			if(!CalculaCpf($cpf)){
					$_SESSION["mensagem"]="CPF Incorreto!";
					
					header("Location:clientes_geral.php?acao=alt&id=$id");
					exit;
			}
		}
		$comissao=valor2banco($comissao);
		if(empty($fantasia)) $fantasia=$nome;
		$sql=mysql_query("UPDATE clientes SET loja='$loja',cod_forn='$cod_forn',nome='$nome',fantasia='$fantasia',status='$status',tipo='$tipo',atividade='$atividade',endereco='$endereco',bairro='$bairro',cep='$cep',cidade='$cidade',estado='$estado',fone='$fone',fax='$fax',contato='$contato',departamento='$departamento',cnpj='$cnpj',cpf='$cpf',ie='$ie',im='$im',vendedor='$vendedor',comissao='$comissao',regiao='$regiao',contabil='$contabil',banco1='$banco1',banco2='$banco2',banco3='$banco3',banco4='$banco4',banco5='$banco5',email='$email',site='$site',logo='$logo',tag='$tag',relatorios='$relatorios' WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Cadastro geral alterado!";
				// cria followup caso alterar o cadastro
					$sql_emp=mysql_query("SELECT fantasia FROM empresa");
					$res_emp=mysql_fetch_array($sql_emp);
					mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração de Cadastro de Clientes.','O usuário $quem1 alterou o Cadastro do cliente $fantasia.','$user')");
				//						
			header("Location:clientes.php?bcod=$bcod&bnome=$bnome");
			exit;		
		}else{
			$_SESSION["mensagem"]="O cadastro geral não pôde ser alterado!";
			$comissao=banco2valor($comissao);				
			$acao="alt";
		}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	$cod_forn=$res["cod_forn"];
	$cpf=$res["cpf"];
	$cnpj=$res["cnpj"];
	$loja=$res["loja"];
	$nome=$res["nome"];
	$fantasia=$res["fantasia"];
	$status=$res["status"];
	$tipo=$res["tipo"];
	$atividade=$res["atividade"];
	$endereco=$res["endereco"];
	$bairro=$res["bairro"];
	$cep=$res["cep"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
	$fone=$res["fone"];
	$fax=$res["fax"];
	$contato=$res["contato"];
	$departamento=$res["departamento"];
	$ie=$res["ie"];
	$im=$res["im"];
	$vendedor=$res["vendedor"];
	$comissao=number_format($res["comissao"],2,",",".");
	$regiao=$res["regiao"];
	$contabil=$res["contabil"];
	$banco1=$res["banco1"];
	$banco2=$res["banco2"];
	$banco3=$res["banco3"];
	$banco4=$res["banco4"];
	$banco5=$res["banco5"];
	$email=$res["email"];
	$site=$res["site"];
	$logo=$res["logo"];
	$tag=$res["tag"];
	$relatorios=$res["relatorios"];
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
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
	if(cad.cod_forn.value==''){
		alert('Preencha o Código do Fornecedor.');
		cad.cod_forn.focus();
		return false;
	}
	if(cad.nome.value==''){
		alert('Preencha o Nome');
		cad.nome.focus();
		return false;
	}
	if(cad.fantasia.value==''){
		alert('Preencha a Fantasia');
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
			alert('Preencha o CPF');
			cad.cpf.focus();
			return false;
		}
	}
	if(cad.contato.value==''){
		alert('Preencha o Contato');
		cad.contato.focus();
		return false;
	}
	if(cad.banco1.value==''){
		alert('Preencha o Banco1');
		cad.banco1.focus();
		return false;
	}
	if(cad.email.value==''){
		alert('Preencha o Email');
		cad.email.focus();
		return false;
	}else{
		if(!verifica_email(cad.email.value)){
			alert('Email Inválido');
			cad.email.focus();
			return false;
		}
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style2 {font-size: 14px}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="502" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" align="center" class="titulos"><table width="433" border="0" align="left" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome&lt;br&gt;Nascimento: xx/xx/xxxx&lt;br&gt;RG: xx.xxx.xxx-x&lt;br&gt;Cart. Profissional: xxxxx&lt;br&gt;Admiss&atilde;o: xx/xx/xxxx&lt;br&gt;Cargo: Escolha um item na lista')" /><span class="impTextoBold">&nbsp;</span></div></td>
                <td align="right"><div align="left" class="titulos">Cadastro de 
                  Clientes - Geral</div></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td width="25" align="center" class="titulos">&nbsp;</td>
                <td width="362" align="right" class="titulos">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;C&oacute;d. Fornecedor: </td>
            <td><input name="cod_forn" type="text" class="formulario" id="cod_forn" value="<?php print $cod_forn; ?>" size="10" maxlength="8" /></td>
          </tr>
          <tr class="textobold">
            <td width="109">&nbsp;Nome:</td>
            <td width="393"><input name="nome" type="text" class="formulario" id="nome" value="<?php print $nome; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Fantasia:</td>
            <td><input name="fantasia" type="text" class="formulario" id="fantasia" value="<?php print $fantasia; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Loja:</td>
            <td><input name="loja" type="text" class="formulario" id="loja" value="<?php print $loja; ?>" size="10" maxlength="2" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Status:</td>
            <td>&nbsp;
                <input name="status" type="radio" value="A" <?php if($status=="A" or empty($status)) print "checked"; ?> />
              Ativo
              <input name="status" type="radio" value="I" <?php if($status=="I") print "checked"; ?> />
              Inativo</td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Tipo:</td>
            <td><input name="tipo" type="text" class="formulario" id="tipo" value="<?php print $tipo; ?>" size="10" maxlength="2" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Atividade:</td>
            <td><input name="atividade" type="text" class="formulario" id="atividade" value="<?php print $atividade; ?>" size="10" maxlength="3" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco" type="text" class="formulario" id="endereco" value="<?php print $endereco; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro" type="text" class="formulario" id="bairro" value="<?php print $bairro; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep" type="text" class="formulario" id="cep" value="<?php print $cep; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Cidade:</td>
            <td><input name="cidade" type="text" class="formulario" id="cidade" value="<?php print $cidade; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td height="21">&nbsp;Estado:</td>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
              <select name="estado" class="textobold" id="UF">
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
            <td><input name="fone" type="text" class="formulario" id="fone" value="<?php print $fone; ?>" size="20" maxlength="15" onKeyPress="return validanum(this, event)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Fax:</td>
            <td><input name="fax" type="text" class="formulario" id="fax" value="<?php print $fax; ?>" size="20" maxlength="15" onKeyPress="return validanum(this, event)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Contato:</td>
            <td><input name="contato" type="text" class="formulario" id="contato" value="<?php print $contato; ?>" size="50" maxlength="50" />
                <?php if($acao=="alt"){ ?>
              &nbsp;&nbsp;<a href="cliente_contatos.php?cli=<?php print $id; ?>" class="textobold">contatos followup </a>
              <?php } ?></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Departamento:</td>
            <td><input name="departamento" type="text" class="formulario" id="departamento" value="<?php print $departamento; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CPF</td>
            <td><input name="cpf" type="text" class="formulario" id="cpf" value="<?php print $cpf; ?>" size="20" maxlength="16" onKeyPress="return validanum(this, event)" onKeyUp="mcpf(this)" onBlur="bloqueia();"/></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CNPJ</td>
            <td><input name="cnpj" type="text" class="formulario" id="cnpj" value="<?php print $cnpj; ?>" size="20" maxlength="20" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)" onBlur="bloqueia2();"/></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ins. Estadual:</td>
            <td><input name="ie" type="text" class="formulario" id="ie" value="<?php print $ie; ?>" size="20" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ins. Municipal:</td>
            <td><input name="im" type="text" class="formulario" id="im" value="<?php print $im; ?>" size="20" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Vendedor:</td>
            <td><input name="vendedor" type="text" class="formulario" id="vendedor" value="<?php print $vendedor; ?>" size="10" maxlength="3" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;% Comiss&atilde;o:</td>
            <td><input name="comissao" type="text" class="formulario" id="comissao" value="<?php print $comissao; ?>" size="10" maxlength="5"onkeydown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Regi&atilde;o:</td>
            <td><input name="regiao" type="text" class="formulario" id="regiao" value="<?php print $regiao; ?>" size="20" maxlength="20" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Conta Cont&aacute;bil:</td>
            <td><input name="contabil" type="text" class="formulario" id="contabil" value="<?php print $contabil; ?>" onKeyPress="return validanum(this, event)" size="20" maxlength="20" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Banco1:</td>
            <td><input name="banco1" type="text" class="formulario" id="banco1" value="<?php print $banco1; ?>" size="20" maxlength="20" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Banco2:</td>
            <td><input name="banco2" type="text" class="formulario" id="banco2" value="<?php print $banco2; ?>" size="20" maxlength="20" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Banco3:</td>
            <td><input name="banco3" type="text" class="formulario" id="banco3" value="<?php print $banco3; ?>" size="20" maxlength="20" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Banco4:</td>
            <td><input name="banco4" type="text" class="formulario" id="banco4" value="<?php print $banco4; ?>" size="20" maxlength="20" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Banco5:</td>
            <td><input name="banco5" type="text" class="formulario" id="banco5" value="<?php print $banco5; ?>" size="20" maxlength="20" />
                <input name="id" type="hidden" id="id" value="<?php print $id; ?>" />
                <input name="acao" type="hidden" id="acao" value="<?php if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Email:</td>
            <td><input name="email" type="text" class="formulario" id="email" value="<?php print $email; ?>" size="50" maxlength="50" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Site:</td>
            <td><input name="site" type="text" class="formulario" id="site" value="<?php print $site; ?>" size="50" maxlength="50" /></td>
          </tr>
          <tr class="textobold">
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="textobold">Op&ccedil;&otilde;es</td>
          </tr>
          <tr>
            <td colspan="2" class="textopreto"><input name="logo" type="checkbox" id="logo" value="S" <?php if($logo=="S"){ print "checked"; } ?>>
              Imprimir Certificado de Submiss&atilde;o sem os Logotipos de DaimChrysler/Ford e GM </td>
          </tr>
          <tr>
            <td colspan="2" class="textopreto"><input name="tag" type="checkbox" id="tag" value="S" <?php if($tag=="S"){ print "checked"; } ?>>
              Certificado de Submiss&atilde;o conforme TAG 1001(Truck Advisory Group) </td>
          </tr>
          <tr>
            <td colspan="2" class="textopreto"><input name="relatorios" type="checkbox" id="relatorios" value="S" <?php if($relatorios=="S"){ print "checked"; } ?>>
              Relat&oacute;rios de Resultados de Ensaios Dimensional/Material e Desempenho incluem Resultados do Cliente </td>
          </tr>
          <tr class="textobold">
            <td colspan="2" align="center"><?php if($acao=="alt"){ ?>
                <?php } ?>
                <input name="voltar" type="button" class="microtxt" id="voltar" value="Voltar" onClick="window.location='clientes.php'" />
              &nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit" type="submit" class="microtxt" value="Continuar" /></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>