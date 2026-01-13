<?
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script>
<!--
function verifica(cad){
	if(cad.numero.value==''){
		alert('Preencha o Número Interno');
		cad.numero.focus();
		return false;
	}
	return true;
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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_cad_pecas.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Cadastro de peças'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Preencha os campos obrigatórios, Numero interno, Rev, Data, Nome da peça, Cliente, N° peça Cli e depois de um clique em Cadastrar')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Recebimento - Solicita&ccedil;&atilde;o de An&aacute;lise Comprobat&oacute;ria </div></td>
      </tr>
</table>
  <form name="form1" method="post" action="" onSubmit="return verifica(this)">
    <table width="469" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <td width="465" align="left" valign="top">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" class="textobold"><table width="467" border="0" cellspacing="3" cellpadding="0">
                <tr class="textobold">
                  <td colspan="7" class="textoboldbranco">&nbsp;Solicita&ccedil;&atilde;o de An&aacute;lise Comprobat&oacute;ria </td>
                </tr>
                <tr class="textobold">
                  <td width="20%">&nbsp;Or&ccedil;amento N&ordm;:</td>
                  <td width="23%"><input name="textfield2" type="text" class="formulario" size="10"></td>
                  <td width="17%"><div align="right">Solicitante:&nbsp;</div></td>
                  <td width="40%" colspan="4"><input name="textfield62" type="text" class="formularioselect" value="Mostrar quem está logado"></td>
                </tr>
                <tr class="textobold">
                  <td colspan="5"><img src="imagens/dot.gif" width="20" height="8"></td>
                </tr>
                <tr class="textobold">
                  <td><div align="left">&nbsp;Amostras N&ordm;1:</div></td>
                  <td><label>
                    <input name="textfield" type="text" class="formulario" size="10">
                  </label></td>
                  <td><div align="right">Material:&nbsp;</div></td>
                  <td colspan="4"><input name="textfield6" type="text" class="formularioselect"></td>
                </tr>
                <tr class="textobold">
                  <td><div align="left">&nbsp;Amostras N&ordm;1:</div></td>
                  <td><input name="dtent" type="text" class="formulario" id="dtent" size="10"></td>
                  <td><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_cad_1&var_field=dteng','','scrollbars=no,width=155,height=138');"></a>
                      <div align="right">Material:&nbsp;</div></td>
                  <td colspan="4"><input name="textfield7" type="text" class="formularioselect"></td>
                </tr>
                <tr class="textobold">
                  <td colspan="7"><img src="imagens/dot.gif" width="20" height="8"></td>
                </tr>
                
                <tr class="textobold">
                  <td colspan="2">Ensaio a Realizar: </td>
                  <td>&nbsp;</td>
                  <td colspan="4">&nbsp;</td>
                </tr>
                <tr class="textobold">
                  <td colspan="7"><table width="451" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="24%" class="textobold"><label>
                        <div align="right">
                          <input type="checkbox" name="checkbox" value="checkbox">
                          </div>
                      </label></td>
                      <td width="30%" class="textobold">&nbsp;Carbono</td>
                      <td width="7%" class="textobold"><input type="checkbox" name="checkbox7" value="checkbox"></td>
                      <td width="39%" class="textobold">Resist&ecirc;ncia &agrave; Tra&ccedil;&atilde;o </td>
                    </tr>
                    <tr>
                      <td class="textobold"><div align="right">
                        <input type="checkbox" name="checkbox2" value="checkbox">
                        </div></td>
                      <td class="textobold">&nbsp;Mangan&ecirc;s</td>
                      <td class="textobold"><input type="checkbox" name="checkbox8" value="checkbox"></td>
                      <td class="textobold">Limite de Elasticidade </td>
                    </tr>
                    <tr>
                      <td class="textobold"><div align="right">
                        <input type="checkbox" name="checkbox3" value="checkbox">
                        </div></td>
                      <td class="textobold">&nbsp;F&oacute;sforo</td>
                      <td class="textobold"><input type="checkbox" name="checkbox9" value="checkbox"></td>
                      <td class="textobold">Alongamento</td>
                    </tr>
                    <tr>
                      <td class="textobold"><div align="right">
                        <input type="checkbox" name="checkbox4" value="checkbox">
                        </div></td>
                      <td class="textobold">&nbsp;Enxofre</td>
                      <td class="textobold"><input type="checkbox" name="checkbox10" value="checkbox"></td>
                      <td class="textobold">Salt Spray </td>
                    </tr>
                    <tr>
                      <td class="textobold"><div align="right">
                        <input type="checkbox" name="checkbox5" value="checkbox">
                        </div></td>
                      <td class="textobold">&nbsp;Cromo</td>
                      <td class="textobold"><input type="checkbox" name="checkbox11" value="checkbox"></td>
                      <td class="textobold">Kiesternish</td>
                    </tr>
                    <tr>
                      <td class="textobold"><div align="right">
                        <input type="checkbox" name="checkbox6" value="checkbox">
                        </div></td>
                      <td class="textobold">&nbsp;N&iacute;quel</td>
                      <td class="textobold"><input type="checkbox" name="checkbox12" value="checkbox"></td>
                      <td class="textobold"><input name="textfield72" type="text" class="formulario" size="35"></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td class="textobold"><div align="right">OBS:&nbsp;</div></td>
              <td width="88%" rowspan="2" class="textobold"><textarea name="historico" rows="4" wrap="VIRTUAL" class="formularioselect" id="historico" onFocus="enterativa=0;" onBlur="enterativa=1;"><? print $res["historico"]; ?></textarea></td>
              <td rowspan="2"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=apqp_pc_inc_2&var_field=dteng','','scrollbars=no,width=155,height=138');"></a></td>
            </tr>
            <tr>
              <td width="9%" class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
          </table>
	    </td>
      </tr>
    </table>
    <span class="textobold"><img src="imagens/dot.gif" width="20" height="8"></span>
    <table width="469" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="center"><span class="textobold">
          <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_pc.php';">
          &nbsp;&nbsp;&nbsp;
          <input name="button1222" type="submit" class="microtxt" value="Incluir">
        </span></div></td>
      </tr>
    </table>
  </form>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>