<?php
include("conecta.php");
$acao=Input::request("acao");
$motivo=Input::request("motivo");
$vias=Input::request("vias");
$responsavel=Input::request("responsavel");
$id=Input::request("id");
$pedido=Input::request("pedido");
$cp=Input::request("cp");
if($acao=="cance"){
	mysql_query("UPDATE nf SET motivo='$motivo',vias='$vias',responsavel='$responsavel',data_can=NOW(),vis='N' WHERE id='$id'");
	//$sql=mysql_query("DELETE FROM e_compra WHERE id='$compra'");
		//$sql=mysql_query("DELETE FROM vendas WHERE id='$pedido'");
					$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$pedido'") or erp_db_fail();
						while($res=mysql_fetch_array($sql2)){
							$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,valor,origem,tipomov) VALUES('$res[produto]','$hj','$res[qtd]','$res[unitario]','2','5')");
						}
		if($sql){
			$_SESSION["mensagem"]="Cancelado Com sucesso!";
		}else{
			$_SESSION["mensagem"]="Não pode ser cancelado!";
		}
		print "<script>window.close();</script>";
}
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
	if(cad.ok.value!='OK'){
		alert('Digite OK para confirmar o Cancelamento!');
		cad.ok.focus();
		return false;
	}
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="form1" method="post" action="" onSubmit="return verifica(this);">
  <table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" class="textoboldbranco">Cancelamento Nota </td>
          </tr>
        <tr>
          <td width="49%" class="textobold">Motivo Cancelamento: </td>
          <td width="51%" class="textopreto"><input name="motivo" type="text" class="formularioselect" id="motivo"></td>
        </tr>
        <tr>
          <td><strong class="textobold">Todas as vias?</strong> </td>
          <td class="textopreto"><input name="vias" id="via1" type="radio" value="S" onClick="form1.envia.disabled=false;">
            Sim&nbsp;
            <input name="vias" type="radio" id="via2" value="N" checked="checked" onClick="form1.envia.disabled=true;">
            N&atilde;o</td>
        </tr>
		
        <tr>
          <td class="textobold">Respons&aacute;vel:</td>
          <td><input name="responsavel" type="text" class="formularioselect" id="responsavel"></td>
        </tr>
        <tr>
          <td align="left" class="textobold">Digite OK: </td>
          <td align="left"><input name="ok" type="text" class="formulario" id="ok" size="10"></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input name="id" type="hidden" id="id" value="<?php print $id; ?>">
            <input name="pedido" type="hidden" id="pedido" value="<?php print $pedido; ?>">
            <input name="cp" type="hidden" id="cp" value="<?php print $cp; ?>">
            <input name="acao" type="hidden" id="acao" value="cance">
            <input name="Submit" type="submit" class="microtxt" id="envia" value="Enviar"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html><script>form1.envia.disabled=true;</script>