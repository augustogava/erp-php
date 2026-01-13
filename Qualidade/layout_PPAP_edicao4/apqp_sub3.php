<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sql=mysql_query("SELECT * FROM apqp_sub WHERE peca='$pc'");
$sqlc=mysql_query("SELECT clientes.tag FROM apqp_pc,clientes WHERE apqp_pc.cliente=clientes.id");
$resc=mysql_fetch_array($sqlc);
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	header("location:apqp_sub1.php");
	exit;
}
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
		if(!mysql_num_rows($sqlb)){
			$btnsalva="form1.acao.value='s3'; form1.submit(); return false;";
		}else{
			$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='s3'; form1.submit(); }else{ return false; } }else{ return false; }";
		}
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

function habilita(){
<? if($resc["tag"]=="S"){ ?>
	document.all.nivel41.style.background="white";
	document.form1.nivel41.disabled=false;
	document.all.nivel42.style.background="white";
	document.form1.nivel42.disabled=false;
	document.all.nivel43.style.background="white";
	document.form1.nivel43.disabled=false;
	document.all.nivel44.style.background="white";
	document.form1.nivel44.disabled=false;
	document.all.nivel45.style.background="white";
	document.form1.nivel45.disabled=false;
	document.all.nivel46.style.background="white";
	document.form1.nivel46.disabled=false;
	document.all.nivel47.style.background="white";
	document.form1.nivel47.disabled=false;
	document.all.nivel48.style.background="white";
	document.form1.nivel48.disabled=false;
	document.all.nivel49.style.background="white";
	document.form1.nivel49.disabled=false;
	document.all.nivel410.style.background="white";
	document.form1.nivel410.disabled=false;
	document.all.nivel411.style.background="white";
	document.form1.nivel411.disabled=false;
	document.all.nivel412.style.background="white";
	document.form1.nivel412.disabled=false;
	document.all.nivel413.style.background="white";
	document.form1.nivel413.disabled=false;
	document.all.nivel414.style.background="white";
	document.form1.nivel414.disabled=false;
	document.all.nivel415.style.background="white";
	document.form1.nivel415.disabled=false;
	document.all.nivel416.style.background="white";
	document.form1.nivel416.disabled=false;
	document.all.nivel417.style.background="white";
	document.form1.nivel417.disabled=false;
	document.all.nivel418.style.background="white";
	document.form1.nivel418.disabled=false;
	document.all.nivel419.style.background="white";
	document.form1.nivel419.disabled=false;
	 <? } ?>
	
}
function inicia(){
<? if($resc["tag"]=="S"){ ?>
	document.all.nivel41.style.background="silver";
	document.form1.nivel41.disabled=true;
	document.all.nivel42.style.background="silver";
	document.form1.nivel42.disabled=true;	
	document.all.nivel43.style.background="silver";
	document.form1.nivel43.disabled=true;
	document.all.nivel44.style.background="silver";
	document.form1.nivel44.disabled=true;
	document.all.nivel45.style.background="silver";
	document.form1.nivel45.disabled=true;
	document.all.nivel46.style.background="silver";
	document.form1.nivel46.disabled=true;
	document.all.nivel47.style.background="silver";
	document.form1.nivel47.disabled=true;
	document.all.nivel48.style.background="silver";
	document.form1.nivel48.disabled=true;
	document.all.nivel49.style.background="silver";
	document.form1.nivel49.disabled=true;
	document.all.nivel410.style.background="silver";
	document.form1.nivel410.disabled=true;
	document.all.nivel411.style.background="silver";
	document.form1.nivel411.disabled=true;
	document.all.nivel412.style.background="silver";
	document.form1.nivel412.disabled=true;
	document.all.nivel413.style.background="silver";
	document.form1.nivel413.disabled=true;
	document.all.nivel414.style.background="silver";
	document.form1.nivel414.disabled=true;
	document.all.nivel415.style.background="silver";
	document.form1.nivel415.disabled=true;
	document.all.nivel416.style.background="silver";
	document.form1.nivel416.disabled=true;
	document.all.nivel417.style.background="silver";
	document.form1.nivel417.disabled=true;
	document.all.nivel418.style.background="silver";
	document.form1.nivel418.disabled=true;
	document.all.nivel419.style.background="silver";
	document.form1.nivel419.disabled=true;
	 <? } ?>
}

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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="600" border="0" cellpadding="0" cellspacing="0">
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
        <td width="127" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">n&iacute;vel de submiss&atilde;o </td>
		<a href="apqp_sub4.php">
        <td width="117" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">aprova&ccedil;&atilde;o forn. </td>
		</a>
		<a href="apqp_sub5.php">
		<td width="129" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">disposi&ccedil;&atilde;o do cliente </td>
		</a>        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="600" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_sub_sql.php">
          <td bgcolor="#FFFFFF"><table width="600" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td class="chamadas"><input name="nivel" type="radio" value="1" <? if($res["nivel"]=="1") print "checked"; ?> onClick="inicia();">
    N&iacute;vel 1 -</td>
              <td class="textobold">Certificado apenas (e para itens designados de apar&ecirc;ncia, um Relat&oacute;rio de Aprova&ccedil;&atilde;o de Apar&ecirc;ncia) submetido ao cliente </td>
            </tr>
            <tr class="textobold">
              <td colspan="2" class="chamadas"><img src="imagens/dot.gif" width="50" height="12"></td>
              </tr>
            <tr>
              <td class="chamadas"><input name="nivel" type="radio" value="2" <? if($res["nivel"]=="2") print "checked"; ?> onClick="inicia();">
    N&iacute;vel 2 -</td>
              <td class="textobold">Certificado com amostras do produto e dados limitados de suporte submetidos ao cliente </td>
            </tr>
            <tr class="textobold">
              <td colspan="2" class="chamadas"><img src="imagens/dot.gif" width="50" height="12"></td>
            </tr>
            <tr>
              <td class="chamadas"><input name="nivel" type="radio" value="3" <? if($res["nivel"]=="3") print "checked"; ?> onClick="inicia();">
    N&iacute;vel 3 -</td>
              <td class="textobold">Certificado com amostras do produto e todos os dados de suporte submetidos ao cliente </td>
            </tr>
            <tr class="textobold">
              <td colspan="2" class="chamadas"><img src="imagens/dot.gif" width="50" height="12"></td>
            </tr>
            <tr>
              <td rowspan="2" class="chamadas"><input name="nivel" type="radio" value="4" <? if($res["nivel"]=="4") print "checked"; ?> onClick="habilita();">
    N&iacute;vel 4 -</td>
              <td class="textobold">Certificado e outros requisitos conforme definido pelo cliente </td>
            </tr>
            <tr class="textobold">
			<? if($resc["tag"]=="S"){ ?>
              <td class="chamadas">
			  
			  <table width="450" border="0" cellpadding="0" cellspacing="0" class="textopreto">
                <tr>
                  <td width="23" align="center">1</td>
                  <td width="23" align="center">2</td>
                  <td width="23" align="center">3</td>
                  <td width="23" align="center">4</td>
                  <td width="23" align="center">5</td>
                  <td width="23" align="center">6</td>
                  <td width="23" align="center">7</td>
                  <td width="23" align="center">8</td>
                  <td width="23" align="center">9</td>
                  <td width="23" align="center">10</td>
                  <td width="23" align="center">11</td>
                  <td width="23" align="center">12</td>
                  <td width="23" align="center">13</td>
                  <td width="23" align="center">14</td>
                  <td width="23" align="center">15</td>
                  <td width="23" align="center">16</td>
                  <td width="23" align="center">17</td>
                  <td width="23" align="center">18</td>
                  <td width="23" align="center">19</td>
                </tr>
				<? $ar=explode(",",$res["nivel4"]); ?>
                <tr>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel41" value="1" <? if(in_array("1",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel42" value="2" <? if(in_array("2",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel43" value="3" <? if(in_array("3",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel44" value="4" <? if(in_array("4",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel45" value="5" <? if(in_array("5",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel46" value="6" <? if(in_array("6",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel47" value="7" <? if(in_array("7",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel48" value="8" <? if(in_array("8",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel49" value="9" <? if(in_array("9",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel410" value="10" <? if(in_array("10",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel411" value="11" <? if(in_array("11",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel412" value="12" <? if(in_array("12",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel413" value="13" <? if(in_array("13",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel414" value="14" <? if(in_array("14",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel415" value="15" <? if(in_array("15",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel416" value="16" <? if(in_array("16",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel417" value="17" <? if(in_array("17",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel418" value="18" <? if(in_array("18",$ar)){ print "checked"; } ?>></td>
                  <td align="center"><input name="nivel4[]" type="checkbox" id="nivel419" value="19" <? if(in_array("19",$ar)){ print "checked"; } ?>></td>
                </tr>
              </table>
			 
			  </td>
			   <? } ?>
            </tr>
            <tr class="textobold">
              <td colspan="2" class="chamadas"><img src="imagens/dot.gif" width="50" height="12"></td>
            </tr>
            <tr>
              <td width="124" class="chamadas"><input name="nivel" type="radio" value="5" <? if($res["nivel"]=="5") print "checked"; ?> onClick="inicia();">
              N&iacute;vel 5 -</td>
              <td width="471" class="textobold">Certificado com amostras do produto e todos os dados de suporte verificados na localidade de manufatura do fornecedor </td>
            </tr>
			<script>inicia();</script>
			<? if($res["nivel"]=="4"){ ?>
			<script>habilita();</script>
			<? } ?>
            <tr>
              <td colspan="2"><img src="imagens/dot.gif" width="50" height="5">
                
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
                </table>
				</td>
              </tr>
            <tr>
              <td colspan="2" align="center"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('submissao','<?=$res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?= $btnsalva; ?>">

                  <input name="acao" type="hidden" id="acao" value="1">
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