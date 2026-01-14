<?
include("conecta.php");
include("seguranca.php");
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(!verifica_data(cad.dia.value)){
		alert('Data incorreta');
		cad.dia.focus();
		return false;
	}
	if(cad.descricao.value==''){
		alert('Informe a descrição do feriado');
		cad.descricao.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Feriados</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><form name="form1" method="post" action="feriados_sql.php" onSubmit="return verifica(this)">
        <table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="155" rowspan="7" align="center" valign="middle"> <? include("calfer.php"); ?></td>
            <td width="10" rowspan="8" class="textobold">&nbsp;</td>
            <td class="textobold"><img src="imagens/dot.gif" width="20" height="15"></td>
          </tr>
          <?
		  if($cal_dia<10) $cal_dia="0".$cal_dia;
		  if($cal_mes<10) $cal_mes="0".$cal_mes;
		  $cal_hj=$cal_dia.$cal_mes;
		  $sql=mysql_query("SELECT * FROM feriados WHERE diames='$cal_hj' AND anual='S'");
		  if(mysql_num_rows($sql)==0){
		  	$cal_hj=$cal_ano."-".$cal_mes."-".$cal_dia;
			$sql=mysql_query("SELECT * FROM feriados WHERE dia='$cal_hj'");
			if(mysql_num_rows($sql)==0){
				$acao="inc";
				$res["dia"]=$cal_ano."-".$cal_mes."-".$cal_dia;
			}else{
				$res=mysql_fetch_array($sql);
				$acao="alt";
			}
		  }else{
		  	$res=mysql_fetch_array($sql);
			$res["dia"]=$cal_ano."-".$cal_mes."-".$cal_dia;
			$acao="alt";
		  }
		  ?>
          <tr> 
            <td width="248" class="textobold">Data do feriado</td>
          </tr>
          <tr> 
            <td><input name="dia" type="text" class="formulario" id="dia" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<? if(!empty($res["dia"])) print banco2data($res["dia"]); ?>" size="10" maxlength="10"> 
              <img src="imagens/dot.gif" width="20" height="8"> <input name="anual" type="checkbox" id="anual" value="S" <? if($res["anual"]=="S") print "checked"; ?>> 
              <span class="textobold">Feriado anual</span></td>
          </tr>
          <tr> 
            <td class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
          <tr> 
            <td class="textobold">Descri&ccedil;&atilde;o</td>
          </tr>
          <tr> 
            <td><input name="descricao" type="text" class="formularioselect" id="descricao" value="<? print $res["descricao"]; ?>" maxlength="100"></td>
          </tr>
          <tr> 
            <td align="right">
<input name="acao" type="hidden" id="acao" value="<? print $acao; ?>"> 
              <input name="id" type="hidden" id="id" value="<? print $res["id"]; ?>"> 
              <input name="cal_dia" type="hidden" id="cal_dia" value="<? print $cal_dia; ?>"> 
              <input name="cal_mes" type="hidden" id="cal_mes" value="<? print $cal_mes; ?>"> 
              <input name="cal_ano" type="hidden" id="cal_ano" value="<? print $cal_ano; ?>">
              <input name="imageField" type="image" src="imagens/icon20_disk.gif" alt="Salvar Altera&ccedil;&otilde;es" width="20" height="24" border="0"> 
              <img src="imagens/dot.gif" width="20" height="5"> <a href="#" onClick="return pergunta('Deseja excluir este feriado?','feriados_sql.php?acao=exc&id=<? print $res["id"]; print "&cal_dia=$cal_dia&cal_mes=$cal_mes&cal_ano=$cal_ano"; ?>');"><img src="imagens/icon20_lixeira.gif" alt="Excluir Feriado" width="20" height="20" border="0"></a><img src="imagens/dot.gif" width="20" height="5">            </td>
          </tr>
          <tr> 
            <td width="155" align="center" valign="middle"><table width="155" border="0" cellspacing="0" cellpadding="0">
                <tr class="textobold"> 
                  <td colspan="2"><img src="imagens/dot.gif" width="20" height="3"></td>
                </tr>
                <tr class="textobold"> 
                  <td width="15" bgcolor="#<? print $cornaoutil; ?>">&nbsp;</td>
                  <td>&nbsp;Dias n&atilde;o &uacute;teis</td>
                </tr>
                <tr class="textobold"> 
                  <td colspan="2"><img src="imagens/dot.gif" width="20" height="3"></td>
                </tr>
                <tr class="textobold"> 
                  <td bgcolor="#<? print $corferiado; ?>">&nbsp;</td>
                  <td>&nbsp;Feriados</td>
                </tr>
              </table></td>
            <td align="right" valign="top">&nbsp;</td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>