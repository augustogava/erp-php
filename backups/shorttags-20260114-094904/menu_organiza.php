<? 
include("conecta.php");
include("seguranca.php");
if($acao=="ok"){
	for($i=0;$i<sizeof($menus);$i++){
		$id=$menus[$i];
		$sql=mysql_query("UPDATE menus set posicao='$i' WHERE id='$id'");
	}
	$_SESSION["mensagem"]="Posições Alteradas";
	$acao="entrar";
}
?>
<HTML>
<HEAD>
<TITLE>Organiza Menus</TITLE>
<link href="style.css" rel="stylesheet" type="text/css">
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="webmaster" content="Christian Paul Pach">
<script>
<!--
function Moveup(dbox) {
for(var i = 0; i < dbox.options.length; i++) {
if (dbox.options[i].selected && dbox.options[i] != "" && dbox.options[i] != dbox.options[0]) {
var tmpval = dbox.options[i].value;
var tmpval2 = dbox.options[i].text;
dbox.options[i].value = dbox.options[i - 1].value;
dbox.options[i].text = dbox.options[i - 1].text
dbox.options[i-1].value = tmpval;
dbox.options[i-1].text = tmpval2;
      }
   }
}
function Movedown(ebox) {
for(var i = 0; i < ebox.options.length; i++) {
if (ebox.options[i].selected && ebox.options[i] != "" && ebox.options[i+1] != ebox.options[ebox.options.length]) {
var tmpval = ebox.options[i].value;
var tmpval2 = ebox.options[i].text;
ebox.options[i].value = ebox.options[i+1].value;
ebox.options[i].text = ebox.options[i+1].text
ebox.options[i+1].value = tmpval;
ebox.options[i+1].text = tmpval2;
      }
   }
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
</HEAD>
<BODY bgColor=#FFFFFF background="imagens/mdagua.gif" leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">
<table width="594" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Organiza</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="400" border="0" cellpadding="2" cellspacing="1" bgcolor="#003366">
        <tr> 
          <td align="center" bgcolor="#003366" class="textoboldbranco">Organiza 
            Menu</td>
        </tr>
        <tr> 
          <?
  $sql=mysql_query("SELECT * FROM menus ORDER BY posicao ASC");
  while($res=mysql_fetch_array($sql)){
  	$texto=$res["texto"];
	$id=$res["id"];
	$ops.="<option value=\"$id\">$texto</option>\n";
  }
  ?>
          <script>
  function marca(lista){
  	for(i=0;i<lista.length;i++){
		lista.options[i].selected=true;
	}
	lista.name='menus[]';
  }
  </script>
          <td bgcolor="#FFFFFF"> <form name="form1" method="post" action="" onSubmit="return marca(this.menus)">
              <table width="300" border="0" align="center" cellpadding="5" cellspacing="0">
                <tr> 
                  <td width="147"><select name="menus" size="10" multiple class="formulario" id="select">
                      <? print $ops; ?> 
                    </select> </td>
                  <td width="133"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center"><input name="sobe" type="button" class="formulario" id="sobe"onclick="Moveup(this.form.menus)" value="Sobe&gt;&gt;"> 
                          <input name="acao" type="hidden" id="acao" value="ok"></td>
                      </tr>
                      <tr> 
                        <td align="center"><input name="desce" type="button" class="formulario" id="desce"onclick="Movedown(this.form.menus)" value="&lt;&lt;Desce"></td>
                      </tr>
                      <tr> 
                        <td align="center"><input name="Submit3" type="submit" class="formulario" value="Continuar"></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</BODY>
</HTML>
<?
include("mensagem.php");
?>