<?
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Clientes Login";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$comissao=valor2banco($comissao);
	if(empty($cpf)){
			if(!CalculaCNPJ($cnpj)){
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:clientes_geral.php");
					exit;
			}
		}
		if(empty($cnpj)){
			if(!CalculaCpf($cpf)){
					$_SESSION["mensagem"]="CPF Incorreto!";
					header("Location:clientes_geral.php");
					exit;
			}
		}
	if(empty($fantasia)) $fantasia=$nome;
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO clientes (loja,transportadora,nome,fantasia,status,tipo,endereco,bairro,cep,cidade,estado,fone,fax,contato,departamento,cnpj,cpf,ie,im,vendedor,comissao,regiao,contabil,banco1,banco2,banco3,banco4,banco5,email,site,grupo,porte,ramo,complemento,ddd,dddf,origem_cad,data) VALUES ('$loja','$transportadora','$nome','$fantasia','$status','$tipo','$endereco','$bairro','$cep','$cidade','$estado','$fone','$fax','$contato','$departamento','$cnpj','$cpf','$ie','$im','$vendedor','$comissao','$regiao','$contabil','$banco1','$banco2','$banco3','$banco4','$banco5','$email','$site','$grupo','$porte','$ramo','$complemento','$ddd','$dddf','$origem','$hj')");
	if($sql){
		$_SESSION["mensagem"]="Cadastro geral conclu�do!";
		$sql=mysql_query("select max(id)as maxid from clientes");
		$res=mysql_fetch_array($sql);
		$id=$res["maxid"];
		header("Location:clientes_cobranca.php?id=$id&acao=inc&bcod=$bcod&bnome=$bnome");
		exit;
	}else{
		$_SESSION["mensagem"]="O cadastro geral n�o p�de ser conclu�do!";
		$comissao=banco2valor($comissao);		
		$acao="inc";
	}	
}elseif($acao=="alterar"){
	$comissao=valor2banco($comissao);
	if(empty($cpf)){
			if(!CalculaCNPJ($cnpj)){
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:clientes_geral.php");
					exit;
			}
		}
		if(empty($cnpj)){
			if(!CalculaCpf($cpf)){
					$_SESSION["mensagem"]="CPF Incorreto!";
					header("Location:clientes_geral.php");
					exit;
			}
		}
	if(empty($fantasia)) $fantasia=$nome;

	
	$sql=mysql_query("UPDATE clientes SET loja='$loja',transportadora='$transportadora',nome='$nome',fantasia='$fantasia',status='$status',tipo='$tipo',endereco='$endereco',bairro='$bairro',cep='$cep',cidade='$cidade',estado='$estado',fone='$fone',fax='$fax',contato='$contato',departamento='$departamento',cnpj='$cnpj',cpf='$cpf',ie='$ie',im='$im',vendedor='$vendedor',comissao='$comissao',regiao='$regiao',contabil='$contabil',banco1='$banco1',banco2='$banco2',banco3='$banco3',banco4='$banco4',banco5='$banco5',email='$email',site='$site',grupo='$aba',porte='$porte',ramo='$ramo',complemento='$complemento',ddd='$ddd',dddf='$dddf',origem_cad='$origem' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro geral alterado!";
		header("Location:clientes.php?bcod=$bcod&bnome=$bnome");
		exit;		
	}else{
		$_SESSION["mensagem"]="O cadastro geral n�o p�de ser alterado!";
		$comissao=banco2valor($comissao);				
		$acao="alt";
	}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	if(empty($res["cpf"])){
		$cpfcnpj=$res["cnpj"];
	}else{
		$cpfcnpj=$res["cpf"];
	}
	$loja=$res["loja"];
	$transportadora=$res["transportadora"];
	$nome=$res["nome"];
	$fantasia=$res["fantasia"];
	$status=$res["status"];
	$tipo=$res["tipo"];
	$origem=$res["origem_cad"];
	$atividade=$res["atividade"];
	$endereco=$res["endereco"];
	$complemento=$res["complemento"];
	$bairro=$res["bairro"];
	$cep=$res["cep"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
	$ddd=$res["ddd"];
	$dddf=$res["dddf"];
	$fone=$res["fone"];
	$fax=$res["fax"];
	$ramo=$res["ramo"];
	$porte=$res["porte"];
	$grupo=$res["grupo"];
	$contato=$res["contato"];
	$departamento=$res["departamento"];
	$ie=$res["ie"];
	$cpf=$res["cpf"];
	$cnpj=$res["cnpj"];
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
	switch($res["sit"]){
		case "0":
			$sit="Inativo";
		break;
		case "1":
			$sit="Ativo";
		break;
		case "2":
			$sit="Prospect";
		break;
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script src="ajax.js"></script>
<script src="ajax2.js" type="text/javascript"></script>
<script src="funcoes.js" type="text/javascript"></script>
<script>
function verifica(cad){
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
		alert('Preencha o Endere�o');
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
			alert('Email Inv�lido');
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
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;javascript:Atualiza6('atualiza_grupo.php?pr=c',this.value);"onkeypress="return ent()">
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
            <td width="109">&nbsp;Nome:</td>
            <td width="393"><input name="nome" type="text" class="formulario" id="nome" value="<? print $nome; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Fantasia:</td>
            <td><input name="fantasia" type="text" class="formulario" id="fantasia" value="<? print $fantasia; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Loja:</td>
            <td><input name="loja" type="text" class="formulario" id="loja" value="<? print $loja; ?>" size="20" maxlength="20" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Transportadora:</td>
            <td><select name="transportadora" class="textobold" id="select2">
              <option selected="selected">Selecione</option>
              <? $sql=mysql_query("select * from transportadora Order By nome ASC");
			while($res=mysql_fetch_array($sql)){
			 ?>
              <option value="<?= $res["id"]; ?>" <? if($transportadora==$res["id"]){ print "selected"; } ?>>
              <?= $res["nome"]; ?>
              </option>
              <? } ?>
            </select></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Grupo:</td>
            <td><div id="grupo_atu"></div><span id="campo1"><span onClick=" editar(1, this, 1, 'nome');">Clique aqui para inserir um Grupo</span></span></td>
          </tr>
          
          <tr class="textobold">
            <td>&nbsp;Porte:</td>
            <td><select name="porte" class="textobold" id="porte">
              <option selected="selected">Selecione</option>
              <option value="pequeno" <? if($porte=="pequeno"){ print "selected"; } ?>>Pequeno</option>
              <option value="media" <? if($porte=="media"){ print "selected"; } ?>>Media</option>
              <option value="grande" <? if($porte=="grande"){ print "selected"; } ?>>Grande</option>
            </select>            </td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ramo Atividade: </td>
            <td><select name="ramo" class="textobold" id="select3">
              <option selected="selected">Selecione</option>
              <? $sql=mysql_query("select * from ramo");
			while($res=mysql_fetch_array($sql)){
			 ?>
              <option value="<?= $res["id"]; ?>" <? if($ramo==$res["id"]){ print "selected"; } ?>>
                <?= $res["nome"]; ?>
                </option>
              <? } ?>
            </select></td>
          </tr>
          
          
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco" type="text" class="formulario" id="endereco" value="<? print $endereco; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Complemento:</td>
            <td><input name="complemento" type="text" class="formulario" id="complemento" value="<? print $complemento; ?>" size="10" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro" type="text" class="formulario" id="bairro" value="<? print $bairro; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep" type="text" class="formulario" id="cep" value="<? print $cep; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Estado:</td>
            <td><span class="texto">
              <select name="estado" id="estado" onChange="javascript:Atualiza('atualiza.php?pr=c',this.value);" class="formulario">
                <option>Selecione</option>   
                <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$estado){ print "selected"; } ?>>
                <?= $res2["nome"]; ?>
                </option>
                <? } ?>
              </select>
            </span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Cidade:</td>
            <td>
			<div id="atualiza">			</div></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Tel:</td>
            <td><input name="ddd" type="text" class="formulario" id="ddd" value="<? print $ddd; ?>" size="2" maxlength="15" onKeyPress="return validanum(this, event)" />
            <input name="fone" type="text" class="formulario" id="fone" value="<? print $fone; ?>" size="20" maxlength="15" onKeyPress="return validanum(this, event)" /></td>
          </tr>
          
          <tr class="textobold">
            <td>&nbsp;Fax:</td>
            <td><input name="dddf" type="text" class="formulario" id="dddf" value="<? print $dddf; ?>" size="2" maxlength="15" onKeyPress="return validanum(this, event)" />
            <input name="fax" type="text" class="formulario" id="fax" value="<? print $fax; ?>" size="20" maxlength="15" onKeyPress="return validanum(this, event)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Contato:</td>
            <td><input name="contato" type="text" class="formulario" id="contato" value="<? print $contato; ?>" size="50" maxlength="50" />
                <? if($acao=="alt"){ ?>
              &nbsp;&nbsp;<a href="cliente_contatos.php?cli=<? print $id; ?>" class="textobold">outros 
                contatos</a>
              <? } ?></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Departamento:</td>
            <td><input name="departamento" type="text" class="formulario" id="departamento" value="<? print $departamento; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CPF</td>
            <td><input name="cpf" type="text" class="formulario" id="cpf" value="<? print $cpf; ?>" size="20" maxlength="16" onKeyPress="return validanum(this, event)" onKeyUp="mcpf(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CNPJ</td>
            <td><input name="cnpj" type="text" class="formulario" id="cnpj" value="<? print $cnpj; ?>" size="20" maxlength="20" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ins. Estadual:</td>
            <td><input name="ie" type="text" class="formulario" id="ie" value="<? print $ie; ?>" size="20" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ins. Municipal:</td>
            <td><input name="im" type="text" class="formulario" id="im" value="<? print $im; ?>" size="20" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Vendedor:</td>
            <td><select name="vendedor" class="formularioselect" id="select">
              <option value="0" selected>Selecione</option>
              <?
$sqlv=mysql_query("SELECT c.fantasia,c.id FROM clientes AS c, cliente_login AS cl, niveis AS n WHERE cl.nivel=n.id AND n.vendedor=1 AND cl.cliente=c.id ORDER BY c.fantasia ASC");
if(mysql_num_rows($sqlv)){
	while($resv=mysql_fetch_array($sqlv)){
?>
              <option value="<?= $resv["id"]; ?>" <? if($resv["id"]==$res["vendedor"]) print "selected"; ?>>
              <?= $resv["fantasia"]; ?>
              </option>
              <?
	}
}
?>
            </select></td>
          </tr>
          
          <tr class="textobold">
            <td>&nbsp;Email:</td>
            <td><input name="email" type="text" class="formulario" id="email" value="<? print $email; ?>" size="50" maxlength="50" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Site:</td>
            <td><input name="site" type="text" class="formulario" id="site" value="<? print $site; ?>" size="50" maxlength="50" />
              <input name="id" type="hidden" id="id" value="<? print $id; ?>" />
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Origem:</td>
            <td><select name="origem" class="textobold" id="origem">
                <option selected="selected">Selecione</option>
                <option value="Receptivo" <? if($origem=="receptivo"){ print "selected"; } ?>>Receptivo</option>
                <option value="bd" <? if($origem=="bd"){ print "selected"; } ?>>BD Externo</option>
                <option value="Representante" <? if($origem=="representante"){ print "selected"; } ?>>Representante</option>
              </select>            </td>
          </tr>
          <tr class="textobold">
            <td align="left">&nbsp;Situa&ccedil;&atilde;o:</td>
            <td align="left"><?= $sit; ?></td>
          </tr>
          <tr class="textobold">
            <td colspan="2" align="center">
               
                <input name="voltar" type="button" class="microtxt" id="voltar" value="Voltar" onClick="history.go(-1)" />
              &nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit" type="submit" class="microtxt" value="Continuar" />			  </td>
          </tr>
        </table>
      </form>
	  <? if($acao=="alt"){ ?>
	  <script>
		setTimeout('javascript:Atualiza(\'atualiza.php?pr=c\',<?= $estado; ?>);',500);
		setTimeout('document.form1.cidade.value=<?= $cidade; ?>',1000);
		setTimeout('document.form1.aba.value=<?= $grupo; ?>',1500);
		
		</script>
	  <? } ?>
    </td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>