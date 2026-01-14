<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="CEP";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	$valor=valor2banco($valor);
	$peso_in=valor2banco($peso_in);
	$peso_fi=valor2banco($peso_fi);
	
	$sql=mysql_query("INSERT INTO cep (tipo,estado,valor,peso_in,peso_fi,prazo) VALUES ('$tipo','$estado','$valor','$peso_in','$peso_fi','$prazo')");
	if($sql){
		$_SESSION["mensagem"]="Inclu�do com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="N�o p�de ser inclu�do!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	$valor=valor2banco($valor);
	$peso_in=valor2banco($peso_in);
	$peso_fi=valor2banco($peso_fi);
	
	$sql=mysql_query("UPDATE cep SET tipo='$tipo',estado='$estado',valor='$valor',peso_in='$peso_in',peso_fi='$peso_fi',prazo='$prazo' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="N�o p�de ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM cep WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Exclu�do com sucesso!";
		}else{
			$_SESSION["mensagem"]="N�o p�de ser exclu�do!";
		}		
	}
	$acao="entrar";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Cadastro Valor Frete </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <? if($acao=="entrar"){ ?>
		<tr> 
          <td><table width="400" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center"><a href="cep.php?acao=inc" class="textobold">Incluir</a> </div></td>
              </tr>
            </table>
            <table width="502" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco">
                <td width="65">Tipo</td> 
                <td width="137">&nbsp;Estado</td>
                <td width="84">Valor</td>
                <td width="164">Peso Inicial - Peso Final </td>
                <td width="20">&nbsp;</td>
                <td width="25">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM cep ORDER BY tipo ASC,estado ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
			  <tr bgcolor="#FFFFFF"> 
                <td colspan="6" align="center" class="textobold">NENHUM 
                  CADASTRADO </td>
              </tr>
			  <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td><? print $res["tipo"]; ?></td> 
                <td>&nbsp;<? $sql2=mysql_query("SELECT * FROM estado WHERE id='$res[estado]'"); $res2=mysql_fetch_array($sql2); print $res2["nome"]; ?></td>
                <td><? print banco2valor($res["valor"]); ?></td>
                <td><? print banco2valor($res["peso_in"])." - ".banco2valor($res["peso_fi"]); ?></td>
                <td width="20" align="center"><a href="cep.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="25" align="center"><a href="#" onClick="return pergunta('Deseja excluir este perfil?','cep.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
			  <?
			  	}
			  }
			  ?>
            </table>
          </td>
        </tr>
		<? }elseif($acao=="inc" or $acao=="alt"){
				$sql=mysql_query("SELECT * FROM cep WHERE id='$id'");
				$res=mysql_fetch_array($sql);
		 ?>
        <tr> 
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
              <table width="300" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="2" align="center" class="textoboldbranco"> 
                    <? if($acao=="inc"){ print"Incluir"; }else{ print"Alterar";} ?>                  </td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;Tipo</td>
                  <td class="textobold"><input name="tipo" type="radio" value="sedex" <? if($res["tipo"]=="sedex"){ print "checked"; } ?>>
                    Sedex 
                    <input name="tipo" type="radio" value="pac" <? if($res["tipo"]=="pac"){ print "checked"; } ?>>
                    PAC</td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;Estado</td>
                  <td class="textobold"><span class="texto">
                    <select name="estado" id="estado"  class="formulario">
                      <option>Selecione</option>
                      <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                      <option value="<?= $res2["id"]; ?>" <? if($res["estado"]==$res2["id"]){ print "selected"; } ?>>
                      <?= $res2["nome"]; ?>
                      </option>
                      <? } ?>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">Prazo:</td>
                  <td class="textobold"><input name="prazo" type="text" class="formulario" id="prazo" value="<? print $res["prazo"]; ?>" size="5" maxlength="3"> 
                  Dias </td>
                </tr>
                <tr>
                  <td valign="middle" class="textobold">&nbsp;Valor</td>
                  <td class="textobold"><input name="valor" type="text" class="formulario" id="valor" value="<? print banco2valor($res["valor"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
                </tr>
                
                
                <tr>
                  <td width="73" class="textobold">&nbsp;Peso Ini. </td>
                  <td width="227" class="textobold"><input name="peso_in" type="text" class="formulario" id="peso_in" value="<? print banco2valor($res["peso_in"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
                </tr>
                <tr>
                  <td class="textobold"> &nbsp;Peso Fin. </td>
                  <td class="textobold"><input name="peso_fi" type="text" class="formulario" id="peso_fi" value="<? print banco2valor($res["peso_fi"]); ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
                </tr>
                
                <tr align="center"> 
                  <td colspan="2" class="textobold">
                    <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='cep.php?acao=entrar'">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="Submit2" type="submit" class="microtxt" value="Continuar">
                  <input name="acao" type="hidden" id="acao2" value="<? if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>">
                  <input name="id" type="hidden" id="id" value="<?= $id; ?>"></td>
                </tr>
              </table>
            </form></td>
        </tr>
		<? } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>