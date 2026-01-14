<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cargos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="alterar"){
	if(!empty($estados)){
		foreach($estados as $key=>$valor){
			$est.="$valor,";
		}
	}
	if(!empty($cidades)){
		foreach($cidades as $key=>$valor){
			$cid.="$valor,";
		}
	}
	$minimo=valor2banco($minimo);
	$sql=mysql_query("UPDATE regra SET minimo='$minimo',estados='$est',cidades='$cid' WHERE id='1'");
	if($sql){
		$_SESSION["mensagem"]="Alterado com sucesso!";
		header("location:mkr_conf.php");
		exit;
	}else{
		$_SESSION["mensagem"]="Não pôde ser alterado!";
		header("location:mkr_conf.php");
		exit;
	}
}else if($acao=="entrar"){
	$sql=mysql_query("SELECT * FROM regra WHERE id='1'");
	$res=mysql_fetch_array($sql);
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
<script src="ajax.js"></script>

<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>

<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Regras de Frete </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
        <?php if($acao=="entrar"){ ?>
		<tr> 
          <td><form name="form1" method="post" action="">
            <table width="60%" border="0" cellpadding="0" cellspacing="0" class="textobold">
              <tr>
                <td valign="top">Estados Isentos </td>
                <td><?php $valo=explode(",",$res["estados"]); ?><select name="estados[]" size="5" multiple class="formularioselect" id="estados">
				<?php 
				
				
				$sql2=mysql_query("SELECT * FROM estado ORDER By nome ASC");
				while($res2=mysql_fetch_array($sql2)){
				?>
				<option value="<?php echo  $res2["id"]; ?>" <?php if(in_array($res2["id"],$valo)){ print "selected"; } ?>><?php echo  $res2["nome"]; ?></option>
				<?php
				}
				?>
                </select>
                </td>
              </tr>
              <tr>
                <td valign="top">Cidades Isentas </td>
                <td><select name="cidades[]" size="25" multiple class="formularioselect" id="ciaddes">
                  <?php 
				$val1=explode(",",$res["cidades"]);
				
				$sql2=mysql_query("SELECT * FROM cidade ORDER By estado ASC,nome ASC");
				while($res2=mysql_fetch_array($sql2)){
					$sql3=mysql_query("SELECT * FROM estado WHERE id='$res2[estado]'");
					$res3=mysql_fetch_array($sql3);
				?>
				<option value="<?php echo  $res2["id"]; ?>" <?php if(in_array($res2["id"],$val1)){ print "selected"; } ?>><?php echo  $res3["nome"]; ?> - <?php echo  $res2["nome"]; ?></option>
				<?php
				}
				?>
                                                </select></td>
              </tr>
              <tr>
                <td width="27%">M&iacute;nimo</td>
                <td width="73%"><input name="minimo" type="text" class="formularioselect" id="minimo" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php echo  banco2valor($res["minimo"]); ?>"></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input name="acao" type="hidden" id="acao" value="alterar">
                  <input type="submit" name="Submit" value="Enviar"></td>
                </tr>
            </table>
                    </form>
          </td>
        </tr>
		<?php }elseif($acao=="inc" or $acao=="alt"){ ?>
        
		<?php } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>