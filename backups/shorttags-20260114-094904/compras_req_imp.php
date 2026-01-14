<?
include("conecta.php");

$sql=mysql_query("SELECT * FROM compras_requisicao WHERE id='$id'");
$res=mysql_fetch_array($sql);
?>
<html>
<head>
<title>Proposta</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
<!--

function imprimir(botao){
	window.print();
	return false;
}
//-->
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	font-size: 14px;
	font-weight: bold;
}
.style2 {font-size: 24px}
.style4 {color: #FFFFFF}
.style5 {font-size: 12px}
-->
</style></head>

<body>
<table width="650" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="700" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" align="center"><img src="imagens/logoesi.gif" width="52" height="53"></td>
        <td width="73%" align="center" class="titulos style2">REQUISI&Ccedil;&Atilde;O </td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td align="center"><hr width="600" class="texto">
      <table width="400" border="0" cellpadding="0" cellspacing="0">
        
        <tr>
          <td class="textobold">&nbsp;N&uacute;mero:</td>
          <td class="texto"><?= completa($res["id"],8); ?></td>
        </tr>
        <tr>
          <td class="textobold">&nbsp;Data:</td>
          <td class="texto"><? print banco2data($res["data"]); ?></td>
        </tr>
        <tr>
          <td width="57" class="textobold">&nbsp;Resp.:</td>
          <td width="343" class="texto"><?= $res["responsavel"]; ?></td>
        </tr>
        <tr align="center">
          <td colspan="2" class="textobold"><img src="imagens/dot.gif" width="20" height="5"></td>
        </tr>
        <tr align="center">
          <td colspan="2" class="textobold"><table width="600" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr>
                <td bgcolor="#FFFFFF"><table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#003366" class="texto">
                    <tr class="textoboldbranco">
                      <td width="28">Qtd.</td>
                      <td width="89">Unidade</td>
                      <td width="147">Produto</td>
                      <td width="63">Valor</td>
                      <td width="152">Motivo</td>
                      <td width="84">Solicitante</td>
                    </tr>
                    <?
$sql=mysql_query("SELECT * FROM compras_requisicao_list  WHERE requisicao='$id'");
if(mysql_num_rows($sql)){
	while($resl=mysql_fetch_array($sql)){
		if($resl["produto"]){
			$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resl[produto]'");
			$resp=mysql_fetch_array($sqlp);
			$resl["prod"]=$resp["nome"];
		}
?>
                    <tr bgcolor="#FFFFFF">
                      <td width="28"><? if(!empty($resl["qtde"])){ print banco2valor($resl["qtde"]); }else{ print banco2valor($resl["qtd"]); }  ?></td>
                      <td><?= $resl["unidade"]; ?></td>
                      <td><?= $resl["prod"]; ?></td>
                      <input name="prodserv[<?= $resl["id"]; ?>]" type="hidden" id="prodserv<?= $resl["id"]; ?>" value="<?= $resl["produto"] ?>">
                      <td width="63"><?= banco2valor($resl["valor"]); ?></td>
                      <td width="152"><select name="motivo[<?= $resl["id"]; ?>]" class="formularioselect" id="motivo<?= $resl["id"]; ?>">
                          <option value="" <? if(empty($resl["operacao"])) print "selected"; ?>>Selecione</option>
                          <option value="acerto" <? if($resl["motivo"]=="acerto") print "selected"; ?>>Acerto Estoque</option>
                          <option value="Producao" <? if($resl["motivo"]=="producao") print "selected"; ?>>Produ&ccedil;&atilde;o</option>
                          <option value="manutencao" <? if($resl["motivo"]=="manutencao") print "selected"; ?>>Manuten&ccedil;&atilde;o</option>
                          <option value="amostra" <? if($resl["motivo"]=="amostra") print "selected"; ?>>Amostra</option>
                          <option value="transf_int" <? if($resl["motivo"]=="transf_int") print "selected"; ?>>Transforma&ccedil;&atilde;o Interna</option>
                          <option value="transf_ext" <? if($resl["motivo"]=="transf_ext") print "selected"; ?>>Transforma&ccedil;&atilde;o Externa</option>
                      </select></td>
                      <td width="84"><?= $resl["solicitante"]; ?></td>
                    </tr>
                    <?
	}
}
?>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr align="center">
          <td colspan="2" class="textobold"><img src="imagens/dot.gif" width="20" height="5"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>

  
  <tr align="center">
    <td><input name="Submit22" type="button" class="microtxt" value="Imprimir" onClick="return imprimir(this)"></td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
