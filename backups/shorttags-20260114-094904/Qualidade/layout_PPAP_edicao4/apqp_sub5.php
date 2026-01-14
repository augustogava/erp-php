<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	header("location:apqp_sub1.php");
	exit;
}
$coment=$res["comentario"];
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sqlb)){
			$btnsalva="return abre('apqp_sub_ass2.php','busca','width=320,height=100,scrollbars=1'); return false;";
		}else{
			$btnsalva="return abre('apqp_sub_ass2.php','busca','width=320,height=100,scrollbars=1'); return false;";
		}

$sqlc=mysql_query("SELECT clientes.tag FROM apqp_pc,clientes WHERE apqp_pc.cliente=clientes.id");
$resc=mysql_fetch_array($sqlc);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function vailogo(type){
	form1.acao.value=type;
	form1.submit();
	return true
}
function vailogo1(type,peca){
	window.open('apqp_imp_email.php?acao='+type+'&local='+form1.local.value+'&email='+form1.email.value+'&pc='+peca,'busca','width=430,height=140,scrollbars=1');
}
function abrir(url,id){
	window.location='pdf/'+url+'.php?id='+id+'';
	return true;
}
function salvar(url,id){
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?=$pc?> + '');
	return true;
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
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_certf_submi.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Certificado de Submiss&atilde;o'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Certificado de Submiss&atilde;o deve ser preenchido conforme o Manual do PPAP da AIAG - Terceira Edi&ccedil;&atilde;o. Utilize as abas da parte superior da tela para navegar entre os diversos t&oacute;picos do certificado de submiss&atilde;o.')"></a><span class="impTextoBold"></span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Certificado de submiss&atilde;o <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top" class="textobold"><img src="imagens/dot.gif" width="50" height="5"></td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <a href="apqp_sub1.php">
		<td width="94" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">inf. da pe&ccedil;a </td>
		</a>		
		<a href="apqp_sub2.php">
		<td width="115" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">inf. da submiss&atilde;o </td>
		</a>
		<a href="apqp_sub3.php">
        <td width="127" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">n&iacute;vel de submiss&atilde;o </td>
		</a>
		<a href="apqp_sub4.php">
        <td width="117" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">aprova&ccedil;&atilde;o forn. </td>
		</a>
		<td width="129" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">disposi&ccedil;&atilde;o do cliente </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_sub_sql.php">
          <td bgcolor="#FFFFFF"><table width="571" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td colspan="2"><table width="571" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                <tr>
                  <td align="center" class="textoboldbranco">declara&ccedil;&atilde;o</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="textobold"><table width="550" border="0" align="center" cellpadding="3" cellspacing="0">
				  <? if($resc["tag"]!="S"){?>
                      <tr>
                        <td colspan="2" class="textobold"><input name="disp" type="radio" value="1" <? if($res["disp"]=="1" or empty($res["disp"])) print "checked"; ?>>
                          Sem Disposi&ccedil;&atilde;o
                            <input name="disp" type="radio" value="2" <? if($res["disp"]=="2") print "checked"; ?>>
                            Aprovado
                            <input name="disp" type="radio" value="3" <? if($res["disp"]=="3") print "checked"; ?>>
                            Derrogado</td>
                        </tr>
					  <tr>
                        <td width="67" class="textobold"><input name="disp" type="radio" value="4" <? if($res["disp"]=="4") print "checked"; ?>>                          
                          Outro:</td>
                        <td width="483" class="textobold"><input name="disp_pq" type="text" class="formularioselect" id="atende_pq3" value="<? print $res["disp_pq"]; ?>" maxlength="255"></td>
                      </tr>
					  <? } else { ?>
					  <tr>
                        <td colspan="2" class="textobold"><input name="disp" type="radio" value="1" <? if($res["disp"]=="1" or empty($res["disp"])) print "checked"; ?>>
Sem Disposi&ccedil;&atilde;o
<input name="disp" type="radio" value="2" <? if($res["disp"]=="2") print "checked"; ?>>
Aprovado
<input name="disp" type="radio" value="3" <? if($res["disp"]=="3") print "checked"; ?>>
Derrogado
<input name="disp" type="radio" value="4" <? if($res["disp"]=="4") print "checked"; ?>> 
Aprova&ccedil;&atilde;o Interina
</td>
                        </tr>
					  <? } ?>
                  </table></td>
                </tr>
              </table></td>
              </tr>
            <tr class="textobold">
              <td colspan="2">
			  <? if($resc["tag"]=="S"){?><img src="imagens/dot.gif" width="50" height="5"></td>
              </tr>
            <tr class="textobold">
              <td width="165">Coment&aacute;rios:</td>
              <td width="406"><textarea name="comentario" cols="72" rows="2" class="formulario" id="comentario"><? print $coment; ?></textarea>
              &nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><? } ?>
			  <img src="imagens/dot.gif" width="50" height="5">
              	<table width="601" border="0" align="center" cellpadding="3" cellspacing="0" class="texto">
                  <tr>
				  <? if($_SESSION["e_mail"]=="S"){ ?>
                    <td width="16%" align="left" class="textobold">&nbsp;Enviar e-mail: </td>
                    <td width="56%"><input name="email" type="text" class="formularioselect" id="email3" value="Digite o e-mail aqui"></td> 
					<? if(in_array("U",$emailt)){ ?>
                    <td width="3%"><div align="center"><a href="#" onClick="return abre('busca_email2.php','a','width=320,height=380,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" alt="Buscar Email de Funcionários" width="14" height="14" border="0"></a></div></td>
					<? } if(in_array("G",$emailt)){ ?>
                    <td width="8%"><div align="center"><a href="#" onClick="return abre('busca_email_grupo.php','a','width=320,height=380,scrollbars=1');"><input name="grupo" type="hidden" id="grupo">
                <input name="grupo_nome" type="hidden" id="grupo_nome"><img src="imagens/icon14_grupo.gif" alt="Buscar Grupo de Emails" width="26" height="13" border="0"></a></div></td>
				 <? } if(in_array("C",$emailt)){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"></a><a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" alt="Buscar Emails de Clientes" width="18" height="18" border="0"></a></div></td>
				<? } ?>
                    <td width="9%"><div align="center"><? if($_SESSION["login_funcionario"]=="S"){ ?><a href="#" onClick="vailogo1('email','<?= $pc; ?>');"><img src="imagens/icon14_mail.gif" alt="Enviar Email" width="16" height="10" border="0"></a><? } ?></div></td>
					<? } if($_SESSION["i_mp"]=="S"){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="vailogo('imp');"><img src="imagens/icon14_imp.gif" alt="Imprimir" width="15" height="15" border="0"></a></div></td>
					<? } ?>
                  </tr>
                  <tr>
                    <td colspan="7" align="left" class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
                    </tr>
                </table>			</td>
              </tr>
            <tr>
              <td colspan="2" align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">                
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('submissao','<?=$res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?= $btnsalva; ?>">
<input name="acao" type="hidden" id="acao" value="1">
<input name="assinatura" type="hidden" id="assinatura">
<a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
<input name="local" type="hidden" id="local" value="submissao">
</a></td>
              </tr>
          </table></td>
        </form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>