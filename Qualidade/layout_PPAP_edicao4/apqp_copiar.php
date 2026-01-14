<?php
include("conecta.php");
include("seguranca.php");
$sql=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
$res=mysql_fetch_array($sql);
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc'");
			while($resb=mysql_fetch_array($sqlb)){
				$nome[]=$resb["ativ"];
			}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function verifica(cad){
	if(cad.numero_para.value==''){
		alert('Preencha o N. da peça');
		cad.numero_para.focus();
		return false;
	}
	if(cad.rev2.value==''){
		alert('Preencha a Revisão');
		cad.rev2.focus();
		return false;
	}
	if(cad.cliente.value==''){
		alert('Escolha o CLiente');
		cad.cliente.focus();
		return false;
	}
	var teste;
	for(i=0;i<=23;i++){
		if(document.all['cp'+i].checked==true){
				teste='sim';
		}
	}
	if(teste!='sim'){
			window.alert('Selecione os itens a serem copiados!');
			return false;
	}


	return true;
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
.style2 {font-size: 12px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="700" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top" class="chamadas"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Copiar </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="apqp_copiar_sql_f.php" onSubmit="return verifica(this)">
      <table width="700" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="100%" border="0" cellpadding="3" cellspacing="0" class="texto">
            <tr>
              <td colspan="4" class="textoboldbranco">Copiar De: </td>
            </tr>
            <tr>
              <td width="89" class="textobold">N&ordm; da Pe&ccedil;a </td>
              <td width="227" class="textobold"><input name="numero" type="text" disabled class="formulario" id="numero" value="<?php echo  $res["numero"]; ?>" size="50" maxlength="40">
              </td>
              <td width="132" align="right"><div align="left"><span class="textobold">&nbsp;Revis&atilde;o da Pe&ccedil;a &nbsp; </span></div></td>
              <td width="234"><p class="textobold">
                  <input name="rev" type="text" class="formularioselect" id="rev4" value="<?php echo  $res["rev"]; ?>" size="5" maxlength="20" disabled>
              </p></td>
            </tr>
            <tr>
              <td class="textobold">Cliente</td>
              <td><input name="clienteasd" type="text" class="formularioselect" id="clienteasd" value="<?php $sql2=mysql_query("SELECT * FROM clientes WHERE id='$res[cliente]'"); $res2=mysql_fetch_array($sql2); print $res2["nome"]; ?>" maxlength="150" disabled></td>
              <td align="right" class="textobold"><div align="left">N&deg; Pe&ccedil;a Cliente </div></td>
              <td>
                <input name="pcli" type="text" class="formularioselect" id="rev3" value="<?php echo  $res["pecacli"]; ?>" size="5" maxlength="20" disabled>
              </td>
            </tr>
            <tr>
              <td class="textobold">&nbsp;</td>
              <td>&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" class="textoboldbranco">Copiar Para: </td>
            </tr>
            <tr>
              <td class="textobold">N&ordm; da Pe&ccedil;a </td>
              <td class="textobold"><input name="numero_para" type="text" class="formularioselect" id="numero_para" maxlength="40">
              </td>
              <td align="right"><div align="left"><span class="textobold">&nbsp;Revis&atilde;o da Pe&ccedil;a &nbsp; </span></div></td>
              <td><p class="textobold">
                  <input name="rev_para" type="text" class="formularioselect" id="rev2" size="5" maxlength="20">
              </p></td>
            </tr>
            <tr>
              <td class="textobold">Cliente
                <input name="cliente" type="hidden" id="cliente" value="<?php print $res["cliente"]; ?>"></td>
              <td><input name="nomecli" type="text" class="formulario" id="nomecli" value="<?php print $res["nomecli"]; ?>" size="45" readonly>
                <a href="#" onClick="return abre('apqp_pccli.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" width="18" height="18" border="0"></a></td>
              <td align="right" class="textobold"><div align="left">N&deg;  Pe&ccedil;a Cliente </div></td>
              <td><input name="pcli_para" type="text" class="formularioselect" id="pcli_para" size="5" maxlength="20"></td>
            </tr>
            <tr>
              <td colspan="4" class="textobold">&nbsp;</td>
            </tr>
            <tr align="left">
              <td colspan="4" class="textoboldbranco">Op&ccedil;&otilde;es de C&oacute;pia (Selecione os documentos a serem copiados) </td>
            </tr>
            <tr align="center">
              <td colspan="4" class="textobold"><table width="700" border="0" cellpadding="3" cellspacing="0" class="texto">
                  <tr>
                    <td width="3%" align="center"><input name="cp[0]" type="checkbox" id="cp0" value="apqp_fluxo" <?php if(!empty($nome)){ if(in_array("Diagrama de Fluxo",$nome)){ print "Checked"; } } ?>></td>
                    <td width="21%" class="textobold">Diagrama de Fluxo </td>
                    <td width="4%" align="center"><input name="cp[6]" type="checkbox" id="cp6" value="apqp_endi"  <?php if(!empty($nome)){ if(in_array("Ensaio Dimensional",$nome)){ print "Checked"; } } ?>></td>
                    <td width="21%" class="textobold">Ensaio Dimensional </td>
                    <td width="3%" align="center"><input name="cp[12]" type="checkbox" id="cp12" value="apqp_plano" <?php if(!empty($nome)){ if(in_array("Plano de Controle",$nome)){ print "Checked"; } } ?>></td>
                    <td width="18%" class="textobold">Plano de Controle </td>
                    <td width="4%" align="center"><input name="cp[18]" type="checkbox" id="cp18" value="apqp_sum" <?php if(!empty($nome)){ if(in_array("Sumário e Aprovação do APQP",$nome)){ print "Checked"; } } ?>></td>
                    <td width="26%" class="textobold">Sum&aacute;rio e Aprova&ccedil;&atilde;o do APQP </td>
                  </tr>
                  <tr>
                    <td align="center"><input name="cp[1]" type="checkbox" id="cp1" value="apqp_fmeaproj"></td>
                    <td class="textobold">Fmea de Projeto </td>
                    <td align="center"><input name="cp[7]" type="checkbox" id="cp7" value="apqp_enma" <?php if(!empty($nome)){ if(in_array("Ensaio Material",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Ensaio Material </td>
                    <td align="center"><input name="cp[13]" type="checkbox" id="cp13" value="apqp_cron"></td>
                    <td class="textobold">Cronograma</td>
                    <td align="center"><input name="cp[19]" type="checkbox" id="cp19" value="apqp_chk" ></td>
                    <td class="textobold">Checklists APQP </td>
                  </tr>
                  <tr>
                    <td align="center"><input name="cp[2]" type="checkbox" id="cp2" value="apqp_fmeaproc" <?php if(!empty($nome)){ if(in_array("FMEA de Processo",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Fmea de Processo </td>
                    <td align="center"><input name="cp[8]" type="checkbox" id="cp8" value="apqp_ende" <?php if(!empty($nome)){ if(in_array("Ensaio Desempenho",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Ensaio Desempenho</td>
                    <td align="center"><input name="cp[14]" type="checkbox" id="cp14" value="apqp_viabilidade" <?php if(!empty($nome)){ if(in_array("Viabilidade",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Viabilidade</td>
                    <td align="center"><input name="cp[20]" type="checkbox" id="cp20" value="interina"></td>
                    <td class="textobold">Aprova&ccedil;&atilde;o Interina - GM </td>
                  </tr>
                  <tr>
                    <td align="center"><input name="cp[3]" type="checkbox" id="cp3" value="apqp_rr" <?php if(!empty($nome)){ if(in_array("Estudos de R&R",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Estudos de R&amp;R </td>
                    <td align="center"><input name="cp[9]" type="checkbox" id="cp9" value="apqp_sub" <?php if(!empty($nome)){ if(in_array("Certificado de Submissão",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Certificado de Submiss&atilde;o </td>
                    <td align="center"><input name="cp[15]" type="checkbox" id="cp15" value="apqp_des" ></td>
                    <td class="textobold">Imagens e Desenhos</td>
                    <td align="center"><input name="cp[21]" type="checkbox" id="cp21" value="sem" disabled></td>
                    <td class="textobold">VDA</td>
                  </tr>
                  <tr>
                    <td align="center"><input name="cp[4]" type="checkbox" id="cp4" value="apqp_cap" <?php if(!empty($nome)){ if(in_array("Estudos de Capabilidade",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Estudos de Capabilidade </td>
                    <td align="center"><input name="cp[10]" type="checkbox" id="cp10" value="apqp_apro"></td>
                    <td class="textobold">Aprova&ccedil;&atilde;o de Apar&ecirc;ncia</td>
                    <td align="center"><input name="cp[16]" type="checkbox" id="cp16" value="apqp_granel" ></td>
                    <td class="textobold">Checklist Granel </td>
                    <td align="center"><input name="cp[22]" type="checkbox" id="cp22" value="sem" disabled></td>
                    <td class="textobold">Matriz de Caracter&iacute;sticas </td>
                  </tr>
                  <tr>
                    <td align="center"><input name="cp[5]" type="checkbox" id="cp5" value="apqp_doc"></td>
                    <td class="textobold">Documentos</td>
                    <td align="center"><input name="cp[11]" type="checkbox" id="cp11" value="apqp_inst"<?php if(!empty($nome)){ if(in_array("Instruções do Operador",$nome)){ print "Checked"; } } ?>></td>
                    <td class="textobold">Instru&ccedil;&atilde;o do Operador </td>
                    <td align="center"><input name="cp[17]" type="checkbox" id="cp17" value="sem" disabled></td>
                    <td class="textobold">Tempos e Custos </td>
                    <td align="center"><input name="cp[23]" type="checkbox" id="cp23" value="sem" disabled></td>
                    <td class="textobold">PSA - RAI </td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center">
              <td colspan="4" class="textobold">
                <input name="pc" type="hidden" id="pc" value="<?php echo  $pc; ?>">
                <input name="acao" type="hidden" value="copiar">
                <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_pc.php';">
&nbsp;
<input name="button122" type="submit" class="microtxt" value="Copiar">
              </td>
            </tr>
          </table></td>
        </tr>
      </table>
      </form></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>