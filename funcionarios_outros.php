<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="alt";
if($acao=="alterar"){
	$afastamento_ini=data2banco($afastamento_ini);
	$afastamento_fim=data2banco($afastamento_fim);
	$res_data=data2banco($res_data);
	$ferias_ini=data2banco($ferias_ini);
	$ferias_fim=data2banco($ferias_fim);
	$cracha_prov_ini=data2banco($cracha_prov_ini);
	$cracha_prov_fim=data2banco($cracha_prov_fim);
	$sql=mysql_query("UPDATE funcionario_outros SET situacao='$situacao',afastamento_ini='$afastamento_ini',afastamento_fim='$afastamento_fim',res_causa='$res_causa',res_data='$res_data',ferias_ini='$ferias_ini',ferias_fim='$ferias_fim',cracha_prov='$cracha_prov',cracha_prov_ini='$cracha_prov_ini',cracha_prov_fim='$cracha_prov_fim' WHERE cliente='$id'");
	if($sql){
		$_SESSION["mensagem"]="cadastro de outros dados alterado!";
		header("Location:funcionarios.php?bcod=$bcod&bnome=$bnome");
		exit;		
	}else{
		$_SESSION["mensagem"]="O cadastro de outros dados não pôde ser alterado!";
		$afastamento_ini=banco2data($afastamento_ini);
		$afastamento_fim=banco2data($afastamento_fim);
		$res_data=banco2data($res_data);
		$ferias_ini=banco2data($ferias_ini);
		$ferias_fim=banco2data($ferias_fim);
		$cracha_prov_ini=banco2data($cracha_prov_ini);
		$cracha_prov_fim=banco2data($cracha_prov_fim);				
		$acao="alt";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM funcionario_outros,clientes WHERE funcionario_outros.cliente='$id' AND clientes.id='$id'");
	$res=mysql_fetch_array($sql);
	$situacao=$res["situacao"];
	$afastamento_ini=banco2data($res["afastamento_ini"]);
	$afastamento_fim=banco2data($res["afastamento_fim"]);
	$res_causa=$res["res_causa"];
	$res_data=banco2data($res["res_data"]);
	$ferias_ini=banco2data($res["ferias_ini"]);
	$ferias_fim=banco2data($res["ferias_fim"]);
	$cracha_prov=$res["cracha_prov"];
	$cracha_prov_ini=banco2data($res["cracha_prov_ini"]);
	$cracha_prov_fim=banco2data($res["cracha_prov_fim"]);
	$fantasia=$res["fantasia"];
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	return true;
}
</script>
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="450" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Cadastro 
              de Funcion&aacute;rios - Outros Dados</td>
          </tr>
          <tr class="textobold"> 
            <td width="116">Nome:</td>
            <td width="334"><? print $fantasia; ?></td>
          </tr>
          <tr class="textobold"> 
            <td>Situa&ccedil;&atilde;o:</td>
            <td> 
              <input name="situacao" type="text" class="formulario" id="situacao" value="<? print $situacao; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Ini. Afastamento:</td>
            <td>
<input name="afastamento_ini" type="text" class="formulario" id="afastamento_ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $afastamento_ini; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>Fim Afastamento:</td>
            <td>
<input name="afastamento_fim" type="text" class="formulario" id="afastamento_fim" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $afastamento_fim; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>Causa Rescis&atilde;o:</td>
            <td> 
              <input name="res_causa" type="text" class="formularioselect" id="res_causa" value="<? print $res_causa; ?>" size="63" maxlength="50"></td>
          </tr>
          <tr class="textobold"> 
            <td>Data Rescis&atilde;o:</td>
            <td>
<input name="res_data" type="text" class="formulario" id="res_data" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $res_data; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>In&iacute;cio das F&eacute;rias:</td>
            <td>
<input name="ferias_ini" type="text" class="formulario" id="ferias_ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $ferias_ini; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>Fim das F&eacute;rias:</td>
            <td>
<input name="ferias_fim" type="text" class="formulario" id="ferias_fim" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $ferias_fim; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>Crach&aacute; Provis&oacute;rio:</td>
            <td> 
              <input name="cracha_prov" type="text" class="formulario" id="cracha_prov" value="<? print $cracha_prov; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Ini. Crach&aacute; Prov.:</td>
            <td>
<input name="cracha_prov_ini" type="text" class="formulario" id="cracha_prov_ini" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $cracha_prov_ini; ?>" size="10" maxlength="10"></td>
          </tr>
          <tr class="textobold"> 
            <td>Fim Crach&aacute; Prov.:</td>
            <td>
<input name="cracha_prov_fim" type="text" class="formulario" id="cracha_prov_fim" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? print $cracha_prov_fim; ?>" size="10" maxlength="10"> 
              <input name="id" type="hidden" id="id3" value="<? print $id; ?>"> 
              <input name="acao" type="hidden" id="acao2" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>"></td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center"> 
              <? if($acao=="alt"){ ?>
             
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='funcionarios.php<? if(!empty($bcod) or!empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>'">
            
              <img src="imagens/dot.gif" width="50" height="5"> 
              <? } ?>
              <input name="Submit2" type="submit" class="microtxt" value="Continuar"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
&nbsp; 
</body>
</html>
<? include("mensagem.php"); ?>