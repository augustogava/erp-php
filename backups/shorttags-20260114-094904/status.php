<?
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Status";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
$hj=date("Y-m-d");
//acessos
if(empty($d)){ $d=date("d"); }
if($dia=="mais"){ $d=date("d",mktime(1,1,1,date("m"),$d+1,date("Y"))); }
if($dia=="menos"){ $d=date("d",mktime(1,1,1,date("m"),$d-1,date("Y"))); }
$datac=date("Y-m-d",mktime(1,1,1,date("m"),$d,date("Y")));
//acessos externo
if(empty($d2)){ $d2=date("d"); }
if($dia2=="mais"){ $d2=date("d",mktime(1,1,1,date("m"),$d2+1,date("Y"))); }
if($dia2=="menos"){ $d2=date("d",mktime(1,1,1,date("m"),$d2-1,date("Y"))); }
$datac2=date("Y-m-d",mktime(1,1,1,date("m"),$d2,date("Y")));


if($fun=="S"){ $tipo="funcionario"; }else{ $tipo="cliente"; }
if($acao=="blok"){
		$sql=mysql_query("UPDATE cliente_login SET blok='1' WHERE $tipo=$usu");
		$sql2=mysql_query("DELETE FROM online WHERE user='$usu'");
		$_SESSION["mensagem"]="Bloqueado com Sucesso!";
}else if($acao=="externo"){
		$sql=mysql_query("UPDATE cliente_login SET blok_externo='1' WHERE $tipo=$usu") or die("UPDATE cliente_login SET blok_externo='1' WHERE $tipo=$usu");
		$sql2=mysql_query("DELETE FROM online WHERE user='$usu'");
		$_SESSION["mensagem"]="Bloqueado com Sucesso!";
}else if($acao=="des"){	
		$sql=mysql_query("UPDATE cliente_login SET $tipod='0' WHERE $tipo=$usu");
		$_SESSION["mensagem"]="Desbloqueado com Sucesso!";
}else if($acao=="muda"){
	if($externo=="S"){
		$sql=mysql_query("UPDATE bloquear SET externo='N' WHERE id='1'");
	}else{
		$sql=mysql_query("UPDATE bloquear SET externo='S' WHERE id='1'");
	}
}
$acao="entrar";
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
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {color: #00CC33}
.style2 {color: #FF0000}
.style3 {font-size: 12}
.style4 {font-size: 12px}
-->
</style>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Status'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Mostra os usuários que estão logados no sistema agora!')"></a><span class="impTextoBold">&nbsp;</span></div></td>
    <td width="563" align="right"><div align="left" class="titulos">Status </div></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="750" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
          <td width="310" valign="top"> <div align="center"></div>
            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" class="titulos">&nbsp;&nbsp;&nbsp;Usu&aacute;rios On-line </td>
              </tr>
              <tr>
                <td align="right"><table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
                  <tr class="textoboldbranco">
                    <td width="230">&nbsp;Usu&aacute;rios On-line</td>
                    <td width="21">&nbsp;</td>
                    <td width="22">&nbsp;</td>
                    <td width="22">&nbsp;</td>
                  </tr>
                  <?
			  $sql=mysql_query("SELECT * FROM online WHERE user<>'1' ORDER BY user ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
                  <tr bgcolor="#FFFFFF">
                    <td colspan="4" align="center" class="textobold">NENHUM USU&Agrave;RIO CADASTRADO </td>
                  </tr>
                  <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
				if($res["funcionario"]=="S"){
					$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$res[user]'"); $res2=mysql_fetch_array($sql2);
				}else{
					$sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[user]'"); $res2=mysql_fetch_array($sql2);
				}
			  ?>
                  <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                    <td>&nbsp;<a href="#" class="texto" onMouseOver="this.T_DELAY=10; this.T_WIDTH=225;  return escape('IP: <?= $res["ip"]; ?> <br>Funcionario: <?= $res["funcionario"]; if(!empty($res2["email"])){ print "<br> Email: $res2[email]";?>  <? } ?> <br> Logado Desde: <?= $res["desde"]; ?>')"><? print $res2["nome"]; ?></a></td>
                    <td align="center"><a href="#" onClick="window.open('statusmsg.php?usu=<?= $res["user"]; ?>&nome=<?= $res2["nome"]; ?>','','width=320,height=100,scrollbars=1');"><img src="imagens/icon14_mail.gif" alt="Mandar Msg" width="16" height="10" border="0"></a></td>
                    <td align="center"><a href="status.php?acao=blok&usu=<?= $res["user"]; ?>&fun=<?= $res["funcionario"]; ?>" onMouseOver="this.T_DELAY=10; this.T_WIDTH=225;  return escape('Bloquear esse usuário para acesso ao Manager')"><img src="imagens/icon14_cancelar.gif" width="16" height="16" border="0"></a></td>
                    <td align="center"><a href="status.php?acao=externo&usu=<?= $res["user"]; ?>&fun=<?= $res["funcionario"]; ?>" onMouseOver="this.T_DELAY=10; this.T_WIDTH=225;  return escape('Bloquear esse usuário para acesso Externo(Fora da Empresa)')"><img src="imagens/icon14_cancelar3.gif" width="16" height="16" border="0"></a></td>
                  </tr>
                  <?
			  	}
			  }
			  ?>
                  <tr bgcolor="#FFFFFF">
                    <td colspan="4" align="center" class="textobold"><a href="#" onClick="window.open('statusmsg.php?usu=666666&nome=Todos','','width=320,height=100,scrollbars=1');" class="texto">Mandar Mensagem Para todos</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="titulos">&nbsp;&nbsp;&nbsp;Usu&aacute;rios Bloqueados </td>
              </tr>
              <tr>
                <td align="right" class="titulos"><table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
                  <tr class="textoboldbranco">
                    <td width="230">&nbsp;Usu&aacute;rios</td>
                    <td width="22">&nbsp;</td>
                  </tr>
                  <?
			  $sql=mysql_query("SELECT * FROM cliente_login WHERE blok='1' OR blok_externo='1' ORDER BY id DESC");
			  if(mysql_num_rows($sql)==0){
			  ?>
                  <tr bgcolor="#FFFFFF">
                    <td colspan="2" align="center" class="textobold">NENHUM USU&Agrave;RIO BLOQUEADO </td>
                  </tr>
                  <?
			  }else{
			  	while($res=mysql_fetch_array($sql)){
				if(!empty($res["funcionario"])){
					$user=$res["funcionario"]; $fun="S"; $sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$res[funcionario]'"); $res2=mysql_fetch_array($sql2);
				}else{
					$user=$res["cliente"]; $fun="N"; $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[cliente]'"); $res2=mysql_fetch_array($sql2);
				}
			  ?>
                  <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                    <td>&nbsp;<a href="#" class="texto" onMouseOver="this.T_DELAY=10; this.T_WIDTH=225;  return escape('<? if(!empty($res["blok"])){ print "Bloqueado No Sistema"; $tipo="blok"; }else{ print "Bloqueado para acesso Externo"; $tipo="blok_externo"; } ?>')"><? print $res2["nome"]; ?></a></td>
                    <td align="center"><a href="status.php?acao=des&usu=<?= $user; ?>&tipod=<?= $tipo; ?>&fun=<?= $fun; ?>"><img src="imagens/icon_14_use.gif" alt="Desbloquear" width="14" height="14" border="0"></a></td>
                  </tr>
                  <?
			  	}
			  }
			  ?>
                </table></td>
              </tr>
              <tr>
                
              </tr>
            </table>
          </td>
          <td width="284" align="left" valign="top">
</td>
		</tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td align="left" valign="top">&nbsp;</td>
	    </tr>
		<tr>
		  <td valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td class="titulos">&nbsp;&nbsp;&nbsp;Acesso Externo
                  <? $sqlb=mysql_query("SELECT * FROM bloquear WHERE id=1"); $resb=mysql_fetch_array($sqlb); if($resb["externo"]=="S"){ ?>
                  <a href="status.php?externo=<?= $resb["externo"]; ?>&acao=muda" onMouseOver="this.T_DELAY=10; this.T_WIDTH=225;  return escape('Clique para mudar a Permiss&atilde;o <br> Permitido: Permitido acesso fora da empresa <br> Proibido: Proibido acesso fora da empresa')"><span class="style1">Permitido</span></a><span class="style1"></span>
                  <? }else{ ?>
                  <a href="status.php?externo=<?= $resb["externo"]; ?>&acao=muda" onMouseOver="this.T_DELAY=10; this.T_WIDTH=225;  return escape('Clique para mudar a Permiss&atilde;o')"><span class="style2">Proibido</span></a>
                  <? } ?></td>
            </tr>
            <?
$sql=mysql_query("SELECT DISTINCT (DATA) AS data FROM `externo` WHERE data='$datac2' ORDER BY data DESC");
while($res=mysql_fetch_array($sql)){
?>
            <tr>
              <td class="titulos">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>
                      <table width="300" border="0" align="right" cellpadding="0" cellspacing="1" bgcolor="#003366">
                        <tr class="textoboldbranco">
                          <td colspan="2">&nbsp;
                              <?= banco2data($res["data"]); ?></td>
                        </tr>
                        <tr class="textoboldbranco">
                          <td width="162">&nbsp;Acessos</td>
                          <td width="119">Data / Hora </td>
                        </tr>
                        <?
			  $sql3=mysql_query("SELECT * FROM externo WHERE data='$res[data]' ORDER by usuario ASC") or die("erro");
			  if(mysql_num_rows($sql3)==0){
			  ?>
                        <tr bgcolor="#FFFFFF">
                          <td colspan="2" align="center" class="textobold">NENHUM ACESSO CADASTRADO </td>
                        </tr>
                        <?
			  }else{
			  	while($res3=mysql_fetch_array($sql3)){
			  ?>
                        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
                          <td>&nbsp;<a href="#" class="texto" <? if (!empty($res3["ip"])){ ?>onmouseover="this.T_DELAY=10; this.T_WIDTH=225;  return escape('IP: <?= $res3["ip"]; ?>')"<? } ?>><? print $res3["usuario"]; ?></a></td>
                          <td><p><? print banco2data($res3["data"]); ?> / <? print $res3["hora"]; ?></p></td>
                        </tr>
                        <? } ?>
                        <tr class="textoboldbranco">
                          <td width="162">&nbsp;<a href="status.php?dia2=menos&d2=<?= $d2; ?>" class="textoboldbranco">Dia Anterior</a> </td>
                          <td width="119" align="right"><a href="status.php?dia2=mais&d2=<?= $d2; ?>" class="textoboldbranco">Pr&oacute;ximo dia</a> </td>
                        </tr>
                        <? } ?>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
              <?
}
			  ?>
            </tr>
          </table></td>
		  <td align="left" valign="top"><span class="titulos">&nbsp;<img src="imagens/spacer.gif" width="139" height="5">Acessos</span><?
$sql=mysql_query("SELECT DISTINCT (DATA) AS data FROM `acessos` WHERE data='$datac' ORDER BY data DESC");
while($res=mysql_fetch_array($sql)){
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
<table width="300" border="0" align="right" cellpadding="0" cellspacing="1" bgcolor="#003366">
  <tr class="textoboldbranco">
    <td colspan="2">&nbsp;<?= banco2data($res["data"]); ?></td>
    </tr>
            <tr class="textoboldbranco">
              <td width="162">&nbsp;Acessos</td>
              <td width="119">Data / Hora </td>
            </tr>
            <?
			  $sql3=mysql_query("SELECT * FROM acessos WHERE data='$res[data]' ORDER by usuario ASC") or die("erro");
			  if(mysql_num_rows($sql3)==0){
			  ?>
            <tr bgcolor="#FFFFFF">
              <td colspan="2" align="center" class="textobold">NENHUM ACESSO CADASTRADO </td>
            </tr>
            <?
			  }else{
			  	while($res3=mysql_fetch_array($sql3)){
				if($res3["tipo"]=="S" or empty($res3["tipo"])){
					$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$res3[usuario]'"); $res2=mysql_fetch_array($sql2);
				}else{
					$sql2=mysql_query("SELECT * FROM clientes WHERE id='$res3[usuario]'"); $res2=mysql_fetch_array($sql2);
				}
					
			  ?>
            <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
              <td>&nbsp;<a href="#" class="texto" <? if (!empty($res3["ip"])){ ?>onmouseover="this.T_DELAY=10; this.T_WIDTH=225;  return escape('IP: <?= $res3["ip"]; ?>')"<? } ?>><? print $res2["nome"]; ?></a></td>
              <td><p><? print banco2data($res3["data"]); ?> / <? print $res3["hora"]; ?></p>                </td>
            </tr>
			  	<? } ?>
			            <tr class="textoboldbranco">
              <td width="162">&nbsp;<a href="status.php?dia=menos&d=<?= $d; ?>" class="textoboldbranco">Dia Anterior</a> </td>
              <td width="119" align="right"><a href="status.php?dia=mais&d=<?= $d; ?>" class="textoboldbranco">Pr&oacute;ximo dia</a> </td>
            </tr><? } ?>
          </table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>            
<?
}
			  ?></td>
	    </tr>

      </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>