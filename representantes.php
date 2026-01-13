<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Representante";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	foreach($cidades as $key=>$valor){
		$cidade.="$valor,";
	}
	$cidade=substr($cidade,0,strlen($cidade)-1);
	$sql=mysql_query("INSERT INTO representante (nome,cidades) VALUES ('$nome','$cidade')");
	if($sql){
		$_SESSION["mensagem"]="Representante incluído com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Representante não pôde ser incluído!";
		$acao="inc";
	}
}elseif($acao=="alterar"){
	foreach($cidades as $key=>$valor){
		$cidade.="$valor,";
	}
	$cidade=substr($cidade,0,strlen($cidade)-1);
	$sql=mysql_query("UPDATE representante SET nome='$nome',cidades='$cidade' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Representante alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O Representante não pôde ser alterado!";
		$acao="alt";
	}
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM representante WHERE id='$id'");
		if($sql){
			$_SESSION["mensagem"]="Representante excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O Representante não pôde ser excluído!";
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
<tr>
		  <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Representantes</div></td>
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
          <td><table width="300" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center"><a href="representantes.php?acao=inc" class="textobold">Incluir 
                    um representante</a> </div></td>
              </tr>
            </table>
            <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr class="textoboldbranco"> 
                <td width="406">&nbsp;Nome</td>
                <td width="20">&nbsp;</td>
                <td width="20">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM representante ORDER BY id ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
			  <tr bgcolor="#FFFFFF"> 
                <td colspan="3" align="center" class="textobold">NENHUM REPRESENTANTE 
                  CADASTRADO </td>
              </tr>
			  <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td>&nbsp;<? print $res["nome"]; ?></td>
                <td width="20" align="center"><a href="representantes.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir este Representante?','representantes.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
			  <?
			  	}
			  }
			  ?>
            </table>
            </td>
        </tr>
		<? }elseif($acao=="inc" or $acao=="alt"){
				$sql=mysql_query("SELECT * FROM representante WHERE id='$id'");
				$res=mysql_fetch_array($sql);
		 ?>
        <tr> 
          <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
              <table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#003366"> 
                  <td colspan="2" align="center" class="textoboldbranco"> 
                    <? if($acao=="inc"){ print"Incluir Representante"; }else{ print"Alterar Representante";} ?>                  </td>
                </tr>
                <tr>
                  <td width="73" valign="middle" class="textobold">&nbsp;Nome</td>
                  <td width="227" class="textobold"><input name="nome" type="text" class="formularioselect" id="nome" value="<?= $res["nome"]; ?>"></td>
                </tr>
                <tr>
                  <td valign="top" class="textobold">&nbsp;Cidades</td>
                  <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                       
                        <td><select name="cidades[]" size="15" multiple>
						<?
						$ex=explode(",",$res["cidades"]);
						$sql2=mysql_query("SELECT * FROM cidade ORDER By nome ASC");
						while($res2=mysql_fetch_array($sql2)){
						?>
						<option value="<?= $res2["id"]; ?>" <? if(in_array($res2["id"],$ex)){ print "selected"; } ?>><?= $res2["nome"]; ?></option>
						<? } ?>
                        </select>
                        </td>
                      </tr>
                  </table></td>
                </tr>
                
                

                <tr align="center"> 
                  <td colspan="2" class="textobold">
                    <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='representantes.php?acao=entrar'">
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