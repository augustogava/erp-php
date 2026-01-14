<?
include("conecta.php");
include("seguranca.php");
if(empty($setbco) and empty($_SESSION["banco_ativo"])){
	header("Location:bancos.php");
	exit;
}
if(!empty($setbco)) $_SESSION["banco_ativo"]=$setbco;
$setbco=$_SESSION["banco_ativo"];
$sql=mysql_query("SELECT * FROM bancos WHERE id='$setbco'");
$res=mysql_fetch_array($sql);
$bank=$res["apelido"]." / ".$res["conta"];
$sld=banco2valor($res["saldo"]);
$sld2=banco2valor($res["saldo"]+$res["limite"]);
$hj=date("Y-m-d");
if(empty($bdias)) $bdias=0;
$ate=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-$bdias,date("Y")));
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="titulos">movimenta&ccedil;&atilde;o banc&aacute;ria</td>
  </tr>
  <tr> 
    <td align="center" valign="top" class="textobold">EXTRATO 
      <? if($bdias==0){ print "DO DIA"; }else{ print "$bdias DIAS"; } ?>
    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="66" align="center">Data</td>
          <td width="85">&nbsp;Opera&ccedil;&atilde;o</td>
          <td width="97">&nbsp;Documento</td>
          <td width="67" align="right">Valor&nbsp;</td>
          <td width="184">&nbsp;Hist&oacute;rico</td>
          <td width="88" align="right">Saldo Anterior&nbsp;</td>
        </tr>
        <?
		$sql=mysql_query("SELECT * FROM bancos_lan,operacoes WHERE bancos_lan.operacao=operacoes.id AND bancos_lan.bco='$setbco' AND data >= '$ate' AND data <= '$hj' ORDER BY data ASC");
		if(mysql_num_rows($sql)==0){
		?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="6" align="center" class="textobold">NENHUM LAN&Ccedil;AMENTO 
            ENCONTRADO</td>
        </tr>
        <?
		}else{
			while($res=mysql_fetch_array($sql)){
				if($res["val_ent"]==0){
					$val=$res["val_sai"];
					$neg=true;
				}else{
					$val=$res["val_ent"];
					$neg=false;
				}
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td align="center"><? print banco2data($res["data"]); ?></td>
          <td>&nbsp;<? print $res["nome"]; ?></td>
          <td>&nbsp;<? print $res["documento"]; ?></td>
          <td align="right"> 
            <? if($neg){ print "<font color=\"#ff0000\">-".banco2valor($val)."</font>"; }else{ print banco2valor($val); } ?>
            &nbsp;</td>
          <td>&nbsp;<? print $res["hist"]; ?></td>
          <td align="right"><? print banco2valor($res["saldo_ant"]); ?>&nbsp;</td>
        </tr>
        <?
			}
		}
		?>
      </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="2"><img src="imagens/dot.gif" width="50" height="5"></td>
        </tr>
        <form name="form2" method="post" action="">
          <tr> 
            <td width="191" class="textobold"> Extrato 
              <input name="bdias" type="text" class="formulario" id="bdias" size="2" maxlength="3" onkeypress="return validanum(this, event)">
              dias &nbsp; <input name="imageField2" type="image" src="imagens/c_buscar.gif" border="0"> 
            </td>
            <td width="403" align="right" class="textobold">Saldo atual&nbsp; 
              <input name="textfield" type="text" class="formulario" value="<? print $sld; ?>" size="15" readonly> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saldo + limite&nbsp; <input name="textfield2" type="text" class="formulario" value="<? print $sld2; ?>" size="15" readonly></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>