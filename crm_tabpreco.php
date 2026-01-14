<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$cat=Input::request("cat");
$nome=Input::request("nome");
$buscar=Input::request("buscar");
unset($_SESSION["ps"]);
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cadastro Produtos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if(!empty($cat)){
	$where="WHERE ecat='$cat'";
}
if(!empty($nome)){
	$where="WHERE nome LIKE '%$nome%'";
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
function blok(){
	document.all.id_mat.style.background="white";
	document.form1.id_mat.disabled=false;
	
	document.all.porta.style.background="silver";
	document.form1.porta.disabled=true;
	
	document.all.cortina.style.background="silver";
	document.form1.cortina.disabled=true;
}
function libe(){
	document.all.id_mat.style.background="silver";
	document.form1.id_mat.disabled=true;
	
	document.all.porta.style.background="white";
	document.form1.porta.disabled=false;
	
	document.all.cortina.style.background="white";
	document.form1.cortina.disabled=false;
}
		
function verifica(cad){
	if(cad.codprod.value==''){
		alert('Informe o Código do produto');
		cad.codprod.focus();
		return false;
	}
	if(cad.nome.value==''){
		alert('Informe o nome');
		cad.nome.focus();
		return false;
	}
	if(cad.apelido.value==''){
		alert('Informe o apelido');
		cad.apelido.focus();
		return false;
	}
	if(cad.categoria.value==''){
		alert('Informe a Categoria');
		cad.categoria.focus();
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
        <td width="563" align="right"><div align="left" class="titulos">Tabela de Pre&ccedil;o </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
<?php if($acao=="entrar"){ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="get" action="">
      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#003366">
          <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
        </tr>
        <tr class="textobold">
          <td>&nbsp;Categoria:</td>
          <td><select name="cat" class="formularioselect" id="cat">
            <option value="0" <?php if($res["idpai"]==0) print "selected"; ?>>Raiz</option>
            <?php
function no($idpai,$wcat){
	$sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$idpai' ORDER BY texto ASC");
	if(mysql_num_rows($sql)!=0){
		while($res=mysql_fetch_array($sql)){
			$sql2=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$res[id]' ORDER BY texto ASC");
			$widpai=$res["id"];
			$esp=0;
			while($widpai!=0){
				$sql3=mysql_query("SELECT idpai FROM prodserv_cat WHERE id='$widpai'");
				$res3=mysql_fetch_array($sql3);
				$widpai=$res3["idpai"];
				if($widpai!=0) $esp++;
			}
			if($res["id"]==$wcat){
				$selsel="selected";
			}else{
				$selsel="";
			}
			print "<option value=\"$res[id]\" $selsel>".str_repeat("&nbsp;", $esp*4)."$res[texto]</option>\n";
			if(mysql_fetch_array($sql2)){
				no($res["id"],$wcat);
			}
		}
	}
}
no(0,$cat);
?>
          </select></td>
        </tr>
        <tr class="textobold">
          <td width="55">&nbsp;Nome:</td>
          <td><input name="nome" type="text" class="textobold" id="nome"></td>
        </tr>

        <tr class="textobold">
          <td colspan="2" align="center"><input name="Submit2" type="submit" class="microtxt" value="Buscar">
          <input name="buscar" type="hidden" id="buscar5" value="true"></td>
        </tr>
      </table>
  </form>  </tr>
  <tr> 
    <td align="left" valign="top"><?php if($buscar=="true"){ ?>

      <table width="580" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">

       
        <tr class="textoboldbranco"> 
          <td width="74"> &nbsp;&nbsp;C&oacute;digo</td>
          <td width="287">Produto</td>
          <td width="59">&nbsp;Saldo</td>
          <td width="59" align="center">Saldo Dis. </td>
          <td width="46" align="center">Pre&ccedil;o</td>
          <td width="48" align="center">Prazo</td>
        </tr>
        <?php
			  $sql=mysql_query("SELECT * FROM prodserv $where ORDER BY nome ASC");
			//  print "SELECT * FROM prodserv $where ORDER BY nome ASC";
			  if(mysql_num_rows($sql)==0){
			  ?>
        <tr bgcolor="#FFFFFF"> 
          <td colspan="6" align="center" class="textobold">NENHUM PRODUTO / SERVI&Ccedil;O&nbsp;CADASTRADO</td>
        </tr>
        <?php
			  }else{
			  	while($res=mysql_fetch_array($sql)){
					$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt, SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE prodserv='$res[id]'"); $res1=mysql_fetch_array($sql1);
			  ?>
			  <a href="prodserv.php?acao=alt&id=<?php print $res["id"]; ?>&cat=<?php echo  $cat; ?>&nome=<?php echo  $nome; ?>">
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')" style="cursor:hand"> 
          <td width="74">&nbsp;<?php print $res["codprod"]; ?></td>
          <td width="287"><div onMouseOver="this.T_TITLE='Foto'; this.T_DELAY=10; this.T_WIDTH=70;  return escape('<img src=<?php if(!empty($res["foto"])){ ?>foto/gd.php?img=<?php print $res["foto"]; ?>&wid=60<?php }else{ print "imagens/semFoto.jpg"; }; ?>>')"><?php print $res["nome"]; ?></div></td>
          <td width="59">&nbsp;<?php print $res1["qtdt"]; ?></td>
          <td width="59" align="left"><?php print $res1["qtdd"]; ?></td>
          <td width="46" align="left"><?php print banco2valor($res["pv"]); ?></td>
          <td width="48" align="left"><?php print $res["prazo_entrega"]; ?> Dias </td>
        </tr>
		</a>
        <?php
			  	}
			  }
			
			  ?>
      </table><br>
      <?php  } ?>
<?php } ?></tr>
</td>
</table>

</body>
</html>
<?php include("mensagem.php"); ?>
<script language="javascript" src="tooltip.js"></script>