<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Recebimento - Ensaio";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$sql=mysql_query("SELECT * FROM ensaio WHERE id='$id'");
$res=mysql_fetch_array($sql);

if($acao=="alt"){
	$cod=$res["codigo"];
	$descricao=$res["descricao"];
	$data_cad=banco2data($res["data_cad"]);
	$carta=$res["carta"];
	$usuario=$res["usuario"];
	$metodo=$res["metodo"];
}

//if(empty($acao)) $acao="inc";
if($acao=="incluir"){
$cod=strtoupper($cod);

	$sql2=mysql_query("SELECT codigo FROM ensaio WHERE codigo='$cod'");
		if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="O cadastro do Ensaio não foi incluído. Digite outro Código do Ensaio, este já existe!";
		header("Location:rec_ensaio_geral.php?acao=inc&cod=$cod&descricao=$descricao&data_cad=$data_cad&usuario=$usuario&carta=$carta&metodo=$metodo");
		exit;		
	}

	$data_cad=date("Y-m-d");
	$usuario=$_SESSION["login_nome"];
	$sql=mysql_query("INSERT INTO ensaio (codigo,descricao,data_cad,usuario,carta,metodo) VALUES ('$cod','$descricao','$data_cad','$usuario','$carta','$metodo')");

	if($sql){
		$_SESSION["mensagem"]="Ensaio incluído com sucesso!";
		// cria followup caso inclua 
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Ensaio.','O usuário $quem1 incluiu um novo Ensaio chamado $descricao.','$user')");
		//	
		header("Location:rec_ensaio.php");
		exit;
	}else{
		$_SESSION["mensagem"]="O Ensaio não pôde ser concluído!";
	}	
}

if($acao=="alterar"){
	$sql=mysql_query("UPDATE ensaio SET codigo='$cod',descricao='$descricao',carta='$carta',metodo='$metodo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro alterado!";
		// cria followup caso altere
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro do Ensaio.','O usuário $quem1 alterou o cadastro do Ensaio $descricao.','$user')");
		//			
		header("Location:rec_ensaio.php");
		exit;		
	}else{
		$_SESSION["mensagem"]="O Ensaio não pôde ser alterado!";
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	if(cad.cod.value==''){
		alert('Preencha o Código');
		cad.cod.focus();
		return false;
	}
	if(cad.descricao.value==''){
		alert('Preencha a Descrição');
		cad.descricao.focus();
		return false;
	}
	if(cad.carta.value==''){
		alert('Preencha a Carta');
		cad.carta.focus();
		return false;
	}
	if(cad.metodo.value==''){
		alert('Preencha o Método');
		cad.metodo.focus();
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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="450" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="423" align="right"><div align="left" class="textobold style1"><span class="titulos">Recebimento &gt; Cadastro &gt; Ensaio </span></div></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
</table>
<table width="449" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="449"><form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return verifica(this)">
      <table width="75%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="393" border="0" cellpadding="0" cellspacing="3">
            <tr class="textobold">
              <td>&nbsp;C&oacute;digo do Ensaio: </td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="26%" class="textobold"><input name="cod" type="text" class="formulario" id="cod" value="<?php print $cod; ?>" size="10" maxlength="10"></td>
                    <td width="44%" class="textobold">&nbsp;&nbsp;&nbsp;Data do Cadastro: </td>
                    <td width="30%" class="textobold"><input name="datacad" type="text" class="formulario" id="datacad" value="<?php if(empty($data_cad)){ print date("d/m/Y"); }else{ print $data_cad; } ?>" size="10" maxlength="15" readonly=""></td>
                  </tr>
                </table></td>
            </tr>
            <tr class="textobold">
              <td width="124">&nbsp;Descri&ccedil;&atilde;o:</td>
              <td width="260"><input name="descricao" type="text" class="formulario" id="descricao" value="<?php print $descricao; ?>" size="50" maxlength="100"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Cadastrador:</td>
              <td><input name="usuario" type="text" class="formulario" id="usuario" value="<?php if(empty($usuario)){ print $_SESSION["login_nome"]; }else{ print $usuario; } ?>" size="30" maxlength="100" readonly=""></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Carta:</td>
              <td><label><select name="carta" class="textopreto" id="carta">
                  <option value="0"<?php if($carta==0){ print "selected"; }?>>Selecione</option>
                  <option value="1"<?php if($carta==1){ print "selected"; }?>>HIS - Histograma</option>
                  <option value="2">XBR - M&eacute;dias e Amplitudes</option>
                  <option value="3">XBS - M&eacute;dias e Desvio Padr&atilde;o</option>
                  <option value="4"<?php if($carta==4){ print "selected"; }?>>XMR - Medianas e Amplitudes</option>
                  <option value="5"<?php if($carta==5){ print "selected"; }?>>IND - Individuais</option>
                  <option value="6">P.- Porc. Unid. N&atilde;o Conforme</option>
                  <option value="7">U. - N&uacute;m. N&atilde;o Conform. p/ Unid.</option>
                  <option value="8">NP - N&uacute;m. Unidades N&atilde;o Conforme</option>
                  <option value="9">C - N&uacute;m. N&atilde;o Conformidades</option>
                  <option value="10"<?php if($carta==10){ print "selected"; }?>>TXT - Texto</option>
                </select></label></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;M&eacute;todo: </td>
              <td><input name="metodo" type="text" class="formulario" id="metodo" value="<?php print $metodo; ?>" size="30" maxlength="30"></td>
            </tr>

          </table></td>
        </tr>
      </table>
      <table width="88%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center">
           <?php /* <input name="id" type="hidden" id="id2" value="<?php print $id; ?>">
            <input name="acao" type="hidden" id="acao2" value="<?php if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
            <?php if($acao=="alt"){ ?>
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='rec_ensaio.php<?php if(!empty($bcod) or!empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>';">
  &nbsp;&nbsp;&nbsp;&nbsp;
  <?php } ?>
  <input name="button122" type="submit" class="microtxt" value="Continuar">
          */ ?>
           <span class="textobold">
           <input name="Voltar" type="button" class="microtxt" id="Voltar" onClick="window.location='rec_ensaio.php';" value="Voltar">
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
&nbsp; 
</body>
</html>
<?php include("mensagem.php"); ?>