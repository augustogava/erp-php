<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
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
function verifica(cad){
	if(cad.nome.value=='' || cad.cliente=='' || cad.cliente_tipo==''){
		alert('Escolha o cliente/fornecedor');
		return abre('nf_cli.php','a','width=320,height=300,scrollbars=1');
	}
	return true
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
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="593" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top" class="titulos"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Nota Fiscal de Saida </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="28" height="8"></td>
  </tr>
  <? if($acao=="entrar"){ ?>
  <tr>
    <td align="left" valign="top"><form name="form2" method="post" action="">
      <table width="240" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr bgcolor="#003366" class="textoboldbranco">
          <td colspan="3" align="center" class="textoboldbranco">Informe a quantidade de produtos na nota </td>
          </tr>
        <tr bgcolor="#FFFFFF" class="textobold">
          <td width="76" align="right">Qtd&nbsp;</td>
          <td width="34"><input name="qtdp" type="text" class="formularioselectsemborda" id="qtdp" onKeyPress="return validanum(this, event)" value="0" size="1" maxlength="2"></td>
          <td width="126"><img src="imagens/dot.gif" width="10" height="8">
            <input name="imageField2" type="image" src="imagens/c_continuar.gif" width="68" height="12" border="0">
            <input name="acao" type="hidden" id="acao" value="nfs"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <? }else{ ?>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="nf_sql.php" onSubmit="return verifica(this);">
      <table width="592" border="0" cellspacing="0" cellpadding="0">
        <tr class="textobold">
          <td width="100">Remetente</td>
          <td width="6">&nbsp;</td>
          <td width="78">&nbsp;</td>
          <td width="6">&nbsp;</td>
          <td width="112">&nbsp;</td>
          <td width="7">&nbsp;</td>
          <td width="81">&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="11">&nbsp;</td>
          <td width="70">&nbsp;</td>
          <td width="68">&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td colspan="7"><input name="nome" type="text" class="formularioselect" id="nome" size="1" readonly></td>
          <td width="53" align="center"><a href="#" onClick="return abre('nf_cli.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" width="14" height="14" border="0"></a></td>
          <td width="11" align="right">N&ordm;</td>
          <td colspan="2"><input name="numero" type="text" class="formularioselect" id="numero" onKeyPress="return validanum(this, event)" size="1" maxlength="6"></td>
          </tr>
        <tr class="textobold">
          <td width="100">Opera&ccedil;&atilde;o</td>
          <td width="6">&nbsp;</td>
          <td width="78">&nbsp;</td>
          <td>&nbsp;</td>
          <td>Natureza</td>
          <td width="7">&nbsp;</td>
          <td width="81"><input name="cliente" type="hidden" id="cliente" value="<? print $cliente; ?>">
            <input name="cliente_tipo" type="hidden" id="cliente_tipo" value="<? print $cliente_tipo; ?>">
            <input name="es" type="hidden" id="es" value="S">            </td>
          <td width="53"><input name="acao" type="hidden" id="acao" value="nfs"></td>
          <td width="11">&nbsp;</td>
          <td width="70">CFOP</td>
          <td width="68">&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td colspan="3"><select name="operacao" class="formularioselect" id="operacao">
            <?
				$sqlo=mysql_query("SELECT * FROM opertab WHERE tipo='S' ORDER BY nome ASC");
				while($reso=mysql_fetch_array($sqlo)){
				?>
            <option value="<? print $reso["id"]; ?>"><? print $reso["nome"]; ?></option>
            <?
				}
				?>
          </select></td>
          <td>&nbsp;</td>
          <td colspan="4"><input name="natureza" type="text" class="formularioselect" id="natureza" size="1" maxlength="100"></td>
          <td width="11">&nbsp;</td>
          <td colspan="2"><input name="cfop" type="text" class="formularioselect" id="cfop" size="1" maxlength="5"></td>
          </tr>
        <tr align="right" class="textobold">
          <td colspan="11"><table width="300" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="84">Emiss&atilde;o</td>
              <td width="5">&nbsp;</td>
              <td width="90">Data de Entrada </td>
              <td width="5">&nbsp;</td>
              <td width="107">Hora de sa&iacute;da </td>
            </tr>
            <tr class="textobold">
              <td><input name="emissao" type="text" class="formularioselect" id="emissao" size="1" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
              <td width="5">&nbsp;</td>
              <td><input name="dtes" type="text" class="formularioselect" id="dtes" size="1" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)"></td>
              <td width="5">&nbsp;</td>
              <td><input name="hs" type="text" class="formularioselect" id="hs" size="1" maxlength="8" onKeyPress="return validanum(this, event)" onKeyUp="mhora(this)"></td>
            </tr>
          </table></td>
          </tr>
        <? if($qtdp!=0){ ?>
		<tr class="textobold">
          <td width="100">PRODUTOS</td>
          <td width="6">&nbsp;</td>
          <td width="78">&nbsp;</td>
          <td width="6">&nbsp;</td>
          <td width="112">&nbsp;</td>
          <td width="7">&nbsp;</td>
          <td width="81">&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="11">&nbsp;</td>
          <td width="70">&nbsp;</td>
          <td width="68">&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td colspan="11"><table width="591" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr class="textoboldbranco">
              <td width="22">cod</td>
              <td width="14">&nbsp;</td>
              <td width="103">Descri&ccedil;&atilde;o</td>
              <td width="33">Unid.</td>
              <td width="56">Cl. Fiscal </td>
              <td width="51">Sit. Trib. </td>
              <td width="41">Qtd</td>
              <td width="48">Valor</td>
              <td width="38">ICMS</td>
              <td width="34">IPI</td>
              <td width="62">ICMS Sub.</td>
              <td width="38">Base</td>
              <td width="38">IR</td>
              </tr>
            <? for ($i=1;$i<=$qtdp;$i++){ ?>
			<tr bgcolor="#FFFFFF" class="textobold">
              <td><input name="prodserv[]" type="text" class="formularioselectsemborda" id="prodserv<? print $i; ?>" onKeyPress="return validanum(this, event)" size="1" maxlength="6" readonly></td>
              <td width="14"><a href="#"><img src="imagens/icon_14_search.gif" width="14" height="14" border="0" onClick="return abre('nf_prodserv.php?line=<? print $i; ?>&abre=S','busca','width=320,height=300,scrollbars=1');"></a></td>
              <td width="103"><input name="pdescricao[]" type="text" class="formularioselectsemborda" id="pdescricao<? print $i; ?>" size="1" maxlength="100"></td>
              <td width="33"><input name="punidade[]" type="text" class="formularioselectsemborda" id="punidade<? print $i; ?>" size="1" maxlength="5"></td>
              <td width="56"><input name="pclafis[]" type="text" class="formularioselectsemborda" id="pclafis<? print $i; ?>" size="1" maxlength="10"></td>
              <td width="51"><input name="psitri[]" type="text" class="formularioselectsemborda" id="psitri<? print $i; ?>" size="1" maxlength="5"></td>
              <td width="41"><input name="pqtd[]" type="text" class="formularioselectsemborda" id="pqtd<? print $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td width="48"><input name="punitario[]" type="text" class="formularioselectsemborda" id="unitario<? print $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td width="38"><input name="picms[]" type="text" class="formularioselectsemborda" id="picms<? print $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td width="34"><input name="pipi[]" type="text" class="formularioselectsemborda" id="pipi<? print $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td width="62"><input name="picmss[]" type="text" class="formularioselectsemborda" id="picmss<? print $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td width="38"><input name="pbase[]" type="text" class="formularioselectsemborda" id="pbase<? print $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td width="38"><input name="pir[]" type="text" class="formularioselectsemborda" id="pir<? print $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          </tr>
		  <? } ?>
			<tr bgcolor="#FFFFFF" class="textobold">
			  <td colspan="13" align="center" class="texto">obs: caso n&atilde;o seja selecionado o cod do produto ele n&atilde;o ser&aacute; inclu&iacute;do na nota fiscal </td>
			  </tr>
          </table></td>
          </tr><? } ?>
        <tr class="textobold">
          <td width="100">SERVI&Ccedil;OS</td>
          <td width="6">&nbsp;</td>
          <td width="78">&nbsp;</td>
          <td width="6">&nbsp;</td>
          <td width="112">&nbsp;</td>
          <td width="7">&nbsp;</td>
          <td width="81">&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="11">&nbsp;</td>
          <td width="70">&nbsp;</td>
          <td width="68">&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td colspan="8" valign="top"><textarea name="servicos" rows="7" wrap="VIRTUAL" class="formularioselect" id="servicos" onFocus="enterativa=0;" onBlur="enterativa=1;"></textarea></td>
          <td colspan="3" valign="top"><table width="140"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr class="textobold">
              <td colspan="3">&nbsp;I.M</td>
            </tr>
            <tr class="textobold">
              <td colspan="3"><input name="im" type="text" class="formularioselect" id="im" size="1" maxlength="20"></td>
            </tr>
            <tr class="textobold">
              <td width="43%">&nbsp;%</td>
              <td width="12%">&nbsp;</td>
              <td width="45%">Val ISS </td>
            </tr>
            <tr class="textobold">
              <td><input name="issper" type="text" class="formularioselect" id="issper" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td>&nbsp;</td>
              <td><input name="issval" type="text" class="formularioselect" id="issval" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
            </tr>
            <tr class="textobold">
              <td colspan="3">&nbsp;Total Servi&ccedil;os </td>
            </tr>
            <tr class="textobold">
              <td colspan="3"><input name="servicosval" type="text" class="formularioselect" id="servicosval" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
            </tr>
          </table></td>
          </tr>
        <tr class="textobold">
          <td colspan="4">C&aacute;lculo do Imposto</td>
          <td width="112">&nbsp;</td>
          <td width="7">&nbsp;</td>
          <td width="81">&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="11">&nbsp;</td>
          <td width="70">&nbsp;</td>
          <td width="68">&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td width="100">Base ICMS </td>
          <td width="6">&nbsp;</td>
          <td width="78">Val ICMS </td>
          <td width="6">&nbsp;</td>
          <td width="112">Base ICMS subst </td>
          <td width="7">&nbsp;</td>
          <td colspan="2">Val ICMS subst </td>
          <td width="11">&nbsp;</td>
          <td colspan="2">Total Produtos </td>
          </tr>
        <tr class="textobold">
          <td width="100"><input name="baseicms" type="text" class="formularioselect" id="baseicms" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="6">&nbsp;</td>
          <td width="78"><input name="valicms" type="text" class="formularioselect" id="valicms" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="6">&nbsp;</td>
          <td width="112"><input name="baseicmss" type="text" class="formularioselect" id="baseicmss" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="7">&nbsp;</td>
          <td colspan="2"><input name="valicmss" type="text" class="formularioselect" id="valicmss" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="11">&nbsp;</td>
          <td colspan="2"><input name="produtos" type="text" class="formularioselect" id="produtos" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          </tr>
        <tr class="textobold">
          <td width="100">Frete</td>
          <td width="6">&nbsp;</td>
          <td width="78">Seguro</td>
          <td width="6">&nbsp;</td>
          <td width="112">Outras despesas </td>
          <td width="7">&nbsp;</td>
          <td colspan="2">Valor IPI </td>
          <td width="11">&nbsp;</td>
          <td colspan="2">Total da Nota </td>
          </tr>
        <tr class="textobold">
          <td width="100"><input name="frete" type="text" class="formularioselect" id="frete" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="6">&nbsp;</td>
          <td width="78"><input name="seguro" type="text" class="formularioselect" id="seguro" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="6">&nbsp;</td>
          <td width="112"><input name="outros" type="text" class="formularioselect" id="outros" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="7">&nbsp;</td>
          <td colspan="2"><input name="ipi" type="text" class="formularioselect" id="ipi" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td width="11">&nbsp;</td>
          <td colspan="2"><input name="total" type="text" class="formularioselect" id="total" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          </tr>
        <tr class="textobold">
          <td colspan="3" valign="bottom">Transportadora</td>
          <td width="6">&nbsp;</td>
          <td width="112" rowspan="2" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
            <tr>
              <td align="center" class="textoboldbranco">Frete por conta </td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF" class="textobold"><input name="fretepor" type="radio" value="1" checked>
                1-
                remetente
                  <input name="fretepor" type="radio" value="2">
                  2-
                destinat&aacute;rio </td>
            </tr>
          </table></td>
          <td width="7">&nbsp;</td>
          <td colspan="5" rowspan="2" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="27%">Placa</td>
              <td width="2%">&nbsp;</td>
              <td width="19%">UF</td>
              <td width="2%">&nbsp;</td>
              <td width="50%">CNPJ</td>
            </tr>
            <tr class="textobold">
              <td><input name="placa" type="text" class="formularioselect" id="placa" size="1" maxlength="7"></td>
              <td>&nbsp;</td>
              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
                <select name="placauf" class="formularioselect" id="UF">
                  <option value="AC"<? if($estado=="AC") print "selected"; ?>>AC</option>
                  <option value="AL"<? if($estado=="AL") print "selected"; ?>>AL</option>
                  <option value="AM"<? if($estado=="AM") print "selected"; ?>>AM</option>
                  <option value="AP"<? if($estado=="AP") print "selected"; ?>>AP</option>
                  <option value="BA"<? if($estado=="BA") print "selected"; ?>>BA</option>
                  <option value="CE"<? if($estado=="CE") print "selected"; ?>>CE</option>
                  <option value="DF"<? if($estado=="DF") print "selected"; ?>>DF</option>
                  <option value="ES"<? if($estado=="ES") print "selected"; ?>>ES</option>
                  <option value="GO"<? if($estado=="GO") print "selected"; ?>>GO</option>
                  <option value="MA"<? if($estado=="MA") print "selected"; ?>>MA</option>
                  <option value="MG"<? if($estado=="MG") print "selected"; ?>>MG</option>
                  <option value="MS"<? if($estado=="MS") print "selected"; ?>>MS</option>
                  <option value="MT"<? if($estado=="MT") print "selected"; ?>>MT</option>
                  <option value="PA"<? if($estado=="PA") print "selected"; ?>>PA</option>
                  <option value="PB"<? if($estado=="PB") print "selected"; ?>>PB</option>
                  <option value="PE"<? if($estado=="PE") print "selected"; ?>>PE</option>
                  <option value="PI"<? if($estado=="PI") print "selected"; ?>>PI</option>
                  <option value="PR"<? if($estado=="PR") print "selected"; ?>>PR</option>
                  <option value="RJ"<? if($estado=="RJ") print "selected"; ?>>RJ</option>
                  <option value="RN"<? if($estado=="RN") print "selected"; ?>>RN</option>
                  <option value="RO"<? if($estado=="RO") print "selected"; ?>>RO</option>
                  <option value="RR"<? if($estado=="RR") print "selected"; ?>>RR</option>
                  <option value="RS"<? if($estado=="RS") print "selected"; ?>>RS</option>
                  <option value="SC"<? if($estado=="SC") print "selected"; ?>>SC</option>
                  <option value="SE"<? if($estado=="SE") print "selected"; ?>>SE</option>
                  <option value="SP"<? if($estado=="SP" or empty($estado)) print "selected"; ?>>SP</option>
                  <option value="TO"<? if($estado=="TO") print "selected"; ?>>TO</option>
                </select>
              </font></td>
              <td>&nbsp;</td>
              <td><input name="tcnpj" type="text" class="formularioselect" id="tcnpj" size="1" maxlength="20"></td>
            </tr>
          </table></td>
        </tr>
        <tr class="textobold">
          <td colspan="3" valign="top"><input name="transp" type="text" class="formularioselect" id="transp" size="1" maxlength="100"></td>
          <td width="6">&nbsp;</td>
          <td width="7">&nbsp;</td>
          </tr>
        <tr class="textobold">
          <td colspan="3">Endere&ccedil;o</td>
          <td width="6">&nbsp;</td>
          <td colspan="4" rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="77%">Cidade</td>
              <td width="3%">&nbsp;</td>
              <td width="20%">UF</td>
              </tr>
            <tr class="textobold">
              <td><input name="tcid" type="text" class="formularioselect" id="tcid" size="1" maxlength="30"></td>
              <td>&nbsp;</td>
              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
                <select name="tuf" class="formularioselect" id="tuf">
                  <option value="AC"<? if($estado=="AC") print "selected"; ?>>AC</option>
                  <option value="AL"<? if($estado=="AL") print "selected"; ?>>AL</option>
                  <option value="AM"<? if($estado=="AM") print "selected"; ?>>AM</option>
                  <option value="AP"<? if($estado=="AP") print "selected"; ?>>AP</option>
                  <option value="BA"<? if($estado=="BA") print "selected"; ?>>BA</option>
                  <option value="CE"<? if($estado=="CE") print "selected"; ?>>CE</option>
                  <option value="DF"<? if($estado=="DF") print "selected"; ?>>DF</option>
                  <option value="ES"<? if($estado=="ES") print "selected"; ?>>ES</option>
                  <option value="GO"<? if($estado=="GO") print "selected"; ?>>GO</option>
                  <option value="MA"<? if($estado=="MA") print "selected"; ?>>MA</option>
                  <option value="MG"<? if($estado=="MG") print "selected"; ?>>MG</option>
                  <option value="MS"<? if($estado=="MS") print "selected"; ?>>MS</option>
                  <option value="MT"<? if($estado=="MT") print "selected"; ?>>MT</option>
                  <option value="PA"<? if($estado=="PA") print "selected"; ?>>PA</option>
                  <option value="PB"<? if($estado=="PB") print "selected"; ?>>PB</option>
                  <option value="PE"<? if($estado=="PE") print "selected"; ?>>PE</option>
                  <option value="PI"<? if($estado=="PI") print "selected"; ?>>PI</option>
                  <option value="PR"<? if($estado=="PR") print "selected"; ?>>PR</option>
                  <option value="RJ"<? if($estado=="RJ") print "selected"; ?>>RJ</option>
                  <option value="RN"<? if($estado=="RN") print "selected"; ?>>RN</option>
                  <option value="RO"<? if($estado=="RO") print "selected"; ?>>RO</option>
                  <option value="RR"<? if($estado=="RR") print "selected"; ?>>RR</option>
                  <option value="RS"<? if($estado=="RS") print "selected"; ?>>RS</option>
                  <option value="SC"<? if($estado=="SC") print "selected"; ?>>SC</option>
                  <option value="SE"<? if($estado=="SE") print "selected"; ?>>SE</option>
                  <option value="SP"<? if($estado=="SP" or empty($estado)) print "selected"; ?>>SP</option>
                  <option value="TO"<? if($estado=="TO") print "selected"; ?>>TO</option>
                </select>
              </font></td>
              </tr>
          </table></td>
          <td width="11">&nbsp;</td>
          <td colspan="2">I.E</td>
          </tr>
        <tr class="textobold">
          <td colspan="3"><input name="tend" type="text" class="formularioselect" id="tend" size="1" maxlength="50"></td>
          <td width="6">&nbsp;</td>
          <td width="11">&nbsp;</td>
          <td colspan="2"><input name="tie" type="text" class="formularioselect" id="tie" size="1" maxlength="20"></td>
          </tr>
        <tr class="textobold">
          <td width="100">Qtd</td>
          <td width="6">&nbsp;</td>
          <td width="78">Esp&eacute;cie</td>
          <td width="6">&nbsp;</td>
          <td width="112">Marca</td>
          <td width="7">&nbsp;</td>
          <td width="81">N&uacute;mero</td>
          <td colspan="4" rowspan="2" valign="middle"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="6">&nbsp;</td>
              <td width="104">Peso Bruto </td>
              <td width="5">&nbsp;</td>
              <td width="81">Peso L&iacute;quido </td>
            </tr>
            <tr class="textobold">
              <td width="6">&nbsp;</td>
              <td><input name="pbruto" type="text" class="formularioselect" id="pbruto" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
              <td width="5">&nbsp;</td>
              <td><input name="pliquido" type="text" class="formularioselect" id="pliquido" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
            </tr>
          </table></td>
          </tr>
        <tr class="textobold">
          <td><input name="qtd" type="text" class="formularioselect" id="qtd" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          <td>&nbsp;</td>
          <td><input name="especie" type="text" class="formularioselect" id="especie" size="1" maxlength="20"></td>
          <td>&nbsp;</td>
          <td><input name="marca" type="text" class="formularioselect" id="marca" size="1" maxlength="20"></td>
          <td>&nbsp;</td>
          <td><input name="tnum" type="text" class="formularioselect" id="tnum" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" size="1"></td>
          </tr>
        <tr class="textobold">
          <td colspan="11">DADOS ADICIONAIS </td>
          </tr>
        <tr class="textobold">
          <td colspan="11"><textarea name="adicionais" rows="7" wrap="VIRTUAL" class="formularioselect" id="adicionais" onFocus="enterativa=0;" onBlur="enterativa=1;"></textarea></td>
          </tr>
        <tr class="textobold">
          <td colspan="11" align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="124">Parcelamento</td>
              <td width="11">&nbsp;</td>
              <td width="140">Conta Cont&aacute;bil </td>
              <td width="10">&nbsp;</td>
              <td width="142">Categoria</td>
              <td width="12">&nbsp;</td>
              <td width="153">Filial</td>
            </tr>
            <tr class="textobold">
              <td width="124"><select name="parcelamento" class="formularioselect" id="select">
                <?
				$sql=mysql_query("SELECT * FROM parcelamentos ORDER BY descricao ASC");
				while($res=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res["id"]; ?>" <? if($parcelamento==$res["id"]) print "selected"; ?>><? print $res["descricao"]; ?></option>
                <? } ?>
              </select></td>
              <td width="11">&nbsp;</td>
              <td><select name="conta" class="formularioselect" id="select2">
                <?
				$sql=mysql_query("SELECT * FROM pcontas WHERE idpai!=0 ORDER BY descricao ASC");
				while($res=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res["id"]; ?>" <? if($conta==$res["id"]) print "selected"; ?>><? print $res["descricao"]; ?></option>
                <? } ?>
              </select></td>
              <td width="10">&nbsp;</td>
              <td><select name="categoria" class="formularioselect" id="select3">
                <?
				$sql=mysql_query("SELECT * FROM categorias ORDER BY nome ASC");
				while($res=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res["id"]; ?>" <? if($categoria==$res["id"]) print "selected"; ?>><? print $res["nome"]; ?></option>
                <? } ?>
              </select></td>
              <td width="12">&nbsp;</td>
              <td><select name="banco" class="formularioselect" id="banco">
                <?
				$sqlo=mysql_query("SELECT * FROM bancos ORDER BY apelido ASC");
				while($reso=mysql_fetch_array($sqlo)){
				?>
                <option value="<? print $reso["id"]; ?>"><? print $reso["apelido"]; ?></option>
                <?
				}
				?>
              </select></td>
            </tr>
          </table></td>
        </tr>
        <tr class="textobold">
          <td colspan="11" align="center"><input name="fluxo" type="checkbox" id="fluxo" value="N" <? if($fluxo=="S") print "checked"; ?>>
N&atilde;o incluir no fluxo de caixa
<input name="cartorio" type="checkbox" id="cartorio" value="S" <? if($cartorio=="S") print "checked"; ?>>
Em cart&oacute;rio
<input name="cobranca" type="checkbox" id="cobranca" value="S" <? if($cobranca=="S") print "checked"; ?>>
Em cobran&ccedil;a
<input name="demonstrativo" type="checkbox" id="demonstrativo" value="S" <? if($demonstrativo=="S") print "checked"; ?>>
N&atilde;o entra na demonstra&ccedil;&atilde;o</td>
        </tr>
        <tr class="textobold">
          <td colspan="11">&nbsp;</td>
        </tr>
        <tr class="textobold">
          <td colspan="11" align="center"><img src="imagens/c_voltar.gif" width="41" height="12"><img src="imagens/dot.gif" width="20" height="5">
            <input name="imageField" type="image" src="imagens/c_continuar.gif" width="68" height="12" border="0"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <? } ?>
</table>
</body>
</html>
<? include("mensagem.php"); ?>