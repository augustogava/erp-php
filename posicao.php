<?
include("conecta.php");
//include("seguranca.php");

//inicio da busca
if(empty($busca)){
		if($material==-1 or !(isset($material))){
		$busca="WHERE nome LIKE '%$nome%' AND codprod LIKE '%$codprod%' ";
		}else{
		$busca="WHERE nome LIKE '%$nome%' AND codprod LIKE '%$codprod%' AND material = '$material' ";
		}
}
//fim da busca

$acao="alt";
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="titulos">Posi&ccedil;&atilde;o</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
	    </tr>
  <tr>
    <td align="left" valign="top"><form>
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
        </tr>
        <tr class="textobold">
          <td width="150">&nbsp;Nome:</td>
          <td width="250">
            <input name="nome" type="text" class="formulario" id="nome" size="50"></td>
        </tr>
        <tr class="textobold">
          <td align="left">&nbsp;Codigo do produto :</td>
          <td align="left"><input name="codprod" type="text" class="formulario" id="codprod" size="25" onKeyPress="return validanum(this, event)"></td>
        </tr>
        <tr class="texto">
          <td align="left"> <strong>&nbsp;Material:</strong></td>
          <td align="left"><select name="material" class="texto" id="material">
              <option value="-1" selected>Todos os materiais</option>
              <? 
			$sqlmaterial=mysql_query("SELECT * FROM material ");
				while($resmaterial=mysql_fetch_array($sqlmaterial)){
			?>
              <option value="<? print $resmaterial["id"]; ?>"><? print $resmaterial["nome"];?></option>
              <? } ?>
          </select></td>
        </tr>
        <tr class="textobold">
          <td colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td colspan="2" align="center"><input name="Submit22" type="submit" class="microtxt" value="Buscar">
          <input name="buscar" type="hidden" id="buscar" value="true">
          </td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr> 
    <td align="left" valign="top">	<form action="posicao_sql.php" method="post" name="form1" >
	<table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><div align="center" class="textobold">ALTERA&Ccedil;&Atilde;O DE PRIORIDADE </div></td>
        </tr>
      </table>
      <table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="216"> &nbsp;&nbsp;Nome</td>
          <td width="60" align="center">Cod.</td>
          <td width="120" align="center">Posi&ccedil;&atilde;o</td>
          </tr>
        <?
			  $sql=mysql_query("SELECT * FROM prodserv $busca ORDER BY posicao ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="3" align="center" class="textobold">NENHUM PRODUTO ENCONTRADO</td>
        </tr>
        <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
          <td height="20" class="texto">&nbsp;<? print $res["nome"]; ?></td>
          <td width="60" align="center" class="texto">&nbsp;<? print $res["codprod"]; ?></td>
          <td align="center"><input name="posicao[<? print $res["id"]; ?>]" type="text" class="texto" id="posicao<? print $res["id"]; ?>" onKeyPress="return validanum(this, event)" value="<? print $res["posicao"]; ?>" maxlength="7"></td>
          </tr>
        <? } } ?>
      </table>
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center"><span class="texto">Obs.: As<strong> 7 (sete)</strong> primeiras posi&ccedil;&otilde;es ser&atilde;o destaque<br>
            na p&aacute;gina 
            princial.</span><span class="textobold"><br>
                </span><br>
                <input name="Submit2" type="submit" class="microtxt" value="Continuar">
                <input name="acao" type="hidden" id="acao" value="alt">
                </div>
            </div></td>
        </tr>
      </table>
	  </form>
    </td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>