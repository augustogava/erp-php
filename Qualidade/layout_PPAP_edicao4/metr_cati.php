<?php
include("conecta.php");
include("seguranca.php");
$buscar=Input::request("buscar");
$acao=Input::request("acao");
$desc=Input::request("desc");
$bcod=Input::request("bcod");
$id=Input::request("id");
$bnome=Input::request("bnome");

if($buscar){
	unset($wp);
}

if(!empty($acao)){
	$loc="Metrologia - Tipo Inst";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(!empty($desc)){
	$cond="WHERE descricao like '%$desc%'";
}
if(!empty($bcod)){
	$cond="WHERE tipo LIKE '%$bcod%'";
}
if(!empty($desc) and !empty($bcod)){
	$cond="WHERE descricao like '%$desc%' AND tipo LIKE '%$bcod%'";
}
if($acao=="exc"){
$sql=mysql_query("DELETE FROM ins_medicao WHERE id='$id'");

}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>
<form name="form1" method="post" action="">
             <table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
               <tr>
                 <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                 <td width="564" align="right"><div align="left"><span class="textobold style1 style1 style1 style1">Metrologia &gt; Cadastro de Tipo de Instrumento</span></div></td>
               </tr>
               <tr>
                 <td align="center">&nbsp;</td>
                 <td align="right">&nbsp;</td>
               </tr>
             </table>
             <table width="226" border="0" cellspacing="3" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">BUSCA</td>
                </tr>
                <tr class="textobold"> 
                  <td>Descri&ccedil;&atilde;o:</td>
                  <td><input name="desc" type="text" class="formularioselect" id="desc" size="20"></td>
                </tr>
                <tr class="textobold"> 
                  <td width="69">Tipo:</td>
                  <td width="148"><input name="bcod" type="text" class="formulario" id="bcod" size="15"> 
                    <img src="imagens/dot.gif" width="20" height="5">
                    <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
                    <input name="buscar" type="hidden" id="buscar5" value="true"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr> 
          <td><table width="244" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="218" align="center"><a href="metr_medg.php?acao=inc" class="textobold"><strong>IncluirTipo de Instrumento de medição </strong></a></td>
            </tr>
          </table><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="129" align="left">Tipo</td>
                <td width="403">&nbsp;Descri&ccedil;&atilde;o</td>
                <td width="33" align="center">&nbsp;</td>
                <td width="24" align="center">&nbsp;</td>
              </tr>
              <?php
			  $sql=mysql_query("SELECT * FROM ins_medicao $cond ORDER BY tipo DESC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto"> 
                <td colspan="4" align="center" class="textopretobold">NENHUM INSTRUMENTO 
                  ENCONTRADO </td>
              </tr>
              <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                <td width="113" height="18"><?php print $res["tipo"]; ?></td>
                <td height="18">&nbsp;<?php print $res["descricao"]; ?></td>
                <td height="18" align="center"><a href="metr_medg.php?acao=alt&id=<?php print $res["id"]; print "&desc=$desc&bnome=$bnome";?>"><img src="imagens/icon14_alterar.gif" alt="Entrega" width="14" height="14" border="0"></a></td>
                <td height="18" align="center"><a href="#" onClick="return pergunta('Deseja excluir este Instrumento?','metr_cati.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?php
			  	}
			  }
			  ?>
            </table>
          <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><div align="center"><br>
                  <input name="Button2" type="button" class="microtxt" value="Voltar" onClick="window.location='mana_metr.php'">
              </div></td>
            </tr>
          </table>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>