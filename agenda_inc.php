<?
include("conecta.php");
include("seguranca.php");
$nivel=$_SESSION["login_nivel"];
$agendador=$_SESSION["login_nome"];
if($acao=="entrar"){
	settype($dia,string);
	if(strlen($dia)==1) $dia="0$dia";
	settype($mes,string);
	if(strlen($mes)==1) $mes="0$mes";	
}elseif($acao=="ok"){
	$data=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+$dias,date("Y")));
	$texto=$texto."\n Agendada por: ".$agendador;
	$sql=mysql_query("INSERT INTO agenda (cliente,nome,texto,titulo,data,hora) VALUES ('$cli','$nome','$texto','$titulo','$data','$hora')");
	if($sql){
		$_SESSION["mensagem"]="Compromisso agendado com sucesso!";
		header("Location:crm_infg.php?cli=$cli");
		exit;
	}else{
		$_SESSION["mensagem"]="O compromisso não pôde ser agendado!";
		$acao="entrar";
	}	
}	
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function verifica(cadastro){
	if(cadastro.nome[cadastro.nome.selectedIndex].value==''){
		alert("Informe o Nome");
		cadastro.nome.focus();
		return false;
	}
	if (cadastro.data.value == ""){
		alert("Informe a Data");
		cadastro.data.focus();
		return(false);
    }	
	if (cadastro.hora.value.length != 8){
		alert("Hora Inválida");
		cadastro.hora.focus();
		return(false);
    }
	if (cadastro.hora.value == "00:00:00"){
		alert("Informe a hora");
		cadastro.hora.focus();
		return(false);
    }	
	if (cadastro.titulo.value == ""){
		alert("Informe o Título");
		cadastro.titulo.focus();
		return(false);
    }	
	if (cadastro.texto.value == ""){
		alert("Informe a Descrição do Compromisso");
		cadastro.texto.focus();
		return(false);
    }					
	return(true);
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Agenda</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><form action="" onSubmit="return verifica(this)" method="post" name="form1" >
        <table width="400" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="16" class="textobold">Agendar compromisso para</td>
          </tr>
          <tr> 
            <td height="16" class="textobold"> <select name="nome" class="formularioselect" id="select3">
                <option value="" selected>Selecione</option>
                <?
							$sql=mysql_query("SELECT clientes.id AS cliente,clientes.nome AS nome FROM clientes,cliente_login,niveis WHERE clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id AND niveis.tipo='F' ORDER BY clientes.nome ASC");
							while($res=mysql_fetch_array($sql)){
								$nome=$res["nome"];
						   	    $ray=explode(" ",$nome);
 	                            $nome=$ray[0];
							?>
                <option value="<? print($nome); ?>"><? print($nome); ?></option>
                <? } ?>
              </select></td>
          </tr>
          <tr> 
            <td width="302" height="16" class="textobold">Dias</td>
          </tr>
          <tr> 
            <td><span class="textobold">
              <input name="dias" type="text" class="formulario" id="dias" size="8" maxlength="8">
            </span></td>
          </tr>
          <tr> 
            <td class="textobold">Hora (hh:mm:ss)</td>
          </tr>
          <tr> 
            <td class="textobold"><input name="hora" type="text" class="formulario" id="hora" onKeyUp="mhora(this)" value="00:00:00" size="8" maxlength="8">
              <input name="acao" type="hidden" id="acao" value="ok">
              <input name="cli" type="hidden" id="acao2" value="<? print $cli; ?>"></td>
          </tr>
          <tr> 
            <td class="texto"><span class="textobold">T&iacute;tulo</span> <span class="texto">(m&aacute;ximo 
              30 caracteres)</span></td>
          </tr>
          <tr> 
            <td><input name="titulo" type="text" class="formularioselect" id="titulo" size="50" maxlength="30"></td>
          </tr>
          <tr> 
            <td class="textobold">Descri&ccedil;&atilde;o do Compromisso</td>
          </tr>
          <tr> 
            <td><textarea name="texto" cols="70" rows="6" wrap="VIRTUAL" class="formularioselect" id="textarea2" onFocus="enterativa=0;" onBlur="enterativa=1;"></textarea></td>
          </tr>
          <tr> 
            <td align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td align="center"><span class="textobold">
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
            </span></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>