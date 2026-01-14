<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Recebimento - Não Conformidades";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$sql=mysql_query("SELECT * FROM conformidades WHERE id='$id'");
$res=mysql_fetch_array($sql);

if($acao=="alt"){
	$cod=$res["cod"];
	$descricao=$res["descricao"];
	$classe=$res["classe"];
}

if($acao=="incluir"){
$cod=strtoupper($cod);

	$sql2=mysql_query("SELECT cod FROM conformidades WHERE cod='$cod'");
		if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="O cadastro da Não Conformidade não foi incluída. Digite outro código para a Não Conformidade, este já existe!";
		header("Location:rec_conformidades_geral.php?acao=inc&cod=$cod&descricao=$descricao&classe=$classe");
		exit;		
	}

	$sql=mysql_query("INSERT INTO conformidades (cod,descricao,classe) VALUES ('$cod','$descricao','$classe')");
	if($sql){
		$_SESSION["mensagem"]="Não Conformidade incluída com sucesso!";
		// cria followup caso inclua
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Não Conformidade.','O usuário $quem1 incluiu um nova Não Conformidade chamada $descricao.','$user')");
		//	
		header("Location:rec_conformidades.php");
		exit;
	}else{
		$_SESSION["mensagem"]="A Não Conformidade não pôde ser concluída!";
	}	
}elseif($acao=="alterar"){
	$sql=mysql_query("UPDATE conformidades SET cod='$cod',descricao='$descricao',classe='$classe' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Não Conformidade alterada com sucesso!";
		// cria followup caso altere
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro da Não Conformidade.','O usuário $quem1 alterou o cadastro da Não Conformidade $descricao.','$user')");
		//	
		header("Location:rec_conformidades.php");
		exit;		
	}else{
		$_SESSION["mensagem"]="A Não Conformidade não pôde ser alterada!";
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
	if(cad.classe.value==''){
		alert('Preencha a Classe');
		cad.classe.focus();
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
<table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                <td width="564" align="right"><div align="left" class="textobold style1">Recebimento &gt; Cadastro &gt; N&atilde;o Conformidade</div></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
            </table>
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="76%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="450" border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco"><div align="left">Cadastro</div></td>
            </tr>
            <tr class="textobold">
              <td>Cod. Conformidade: </td>
              <td><input name="cod" type="text" class="formulario" id="cod" value="<? print $cod; ?>" size="10" maxlength="10"></td>
            </tr>
            <tr class="textobold">
              <td width="144">&nbsp;Descri&ccedil;&atilde;o:</td>
              <td width="306"><input name="descricao" type="text" class="formularioselect" id="descricao" value="<? print $descricao; ?>" size="40" maxlength="100"></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Classe:</td>
              <td><label>
                <select name="classe" class="textopreto" id="classe">
                  <option value="0"<? if($classe==0){ print "selected";}?>>Selecione</option>
                  <option value="1"<? if($classe==1){ print "selected";}?>>A - Muito S&eacute;rio</option>
                  <option value="2"<? if($classe==2){ print "selected";}?>>B - Moderadamente S&eacute;rio</option>
                  <option value="3"<? if($classe==3){ print "selected";}?>>C - Controle Interno</option>
                </select>
                </label></td>
            </tr>

          </table></td>
        </tr>
      </table>
      <table width="76%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">
              <input name="id" type="hidden" id="id2" value="<? print $id; ?>">
              <input name="acao" type="hidden" id="acao2" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">
              <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='rec_conformidades.php';">
              &nbsp;&nbsp;&nbsp;&nbsp;<span class="textobold">
              <? if ($acao=="alt"){ ?>
              <input name="Alterar" type="submit" class="microtxt" value="Alterar">
              <? } ?>
              <? if($acao=="inc"){ ?>
              <input name="Incluir" type="submit" class="microtxt" id="Incluir" value="Incluir">
              <? } ?>
              </span></div></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
&nbsp; 
</body>
</html>
<? include("mensagem.php"); ?>