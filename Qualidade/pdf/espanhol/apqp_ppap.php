<?php
include("conecta.php");
include("seguranca.php");

?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script>
function valida(){
	if(form1.pc.value=="0"){
		alert("Selecione Uma Peça!!!");
		form1.pc.focus();
		return false
	}
	if(form1.nome2[0].cheked=true){
		alert("Ta selecionado!!!");
		form1.pc.focus();
		return false
	}
	return true
}
function hori(){
	form1.nome.checked=false;
	form1.nome1.checked=false;
	form1.nome2.checked=false;
	form1.nome3.checked=false;
	form1.nome4.checked=false;
	form1.nome5.checked=false;
	form1.nome6.checked=false;
	form1.nome7.checked=false;
	form1.nome8.checked=false;
}
function veri(){
	form1.nome21.checked=false;
	form1.nome22.checked=false;
	form1.nome23.checked=false;
	form1.nome24.checked=false;
	form1.nome25.checked=false;
	form1.nome26.checked=false;

}

</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top" class="chamadas">APQP - Impress&atilde;o Autom&aacute;tica do PPAP </td>
  </tr>
  <tr>
    <td><table width="594" border="0" cellpadding="0" cellspacing="1" >
      <tr>
        <td bgcolor="#003366" class="textoboldbranco">&nbsp;Selecione os Itens a serem impressos</td>
        </tr>
      <tr>
        <td height="328" class="textoboldbranco"><form name="form1" method="post" action="apqp_ppap_sql.php" onSubmit="return valida(this)">
          <div align="center">
		  <select name="pc">
		  	<option value="0">Selecione um peça</option>
		  	<?php
		  	$sql=mysql_query("select * from apqp_pc order by nome asc");
			while($rec=mysql_fetch_array($sql)){?>
				<option value="<?php echo $rec["id"]?>"><?php echo $rec["numero"]." - ".$rec["nome"];?></option>
			<?php
			}?>
		  </select>
		    </div>
          <table width="602" border="0" cellpadding="3" cellspacing="0" class="texto">
            <tr>
              <td align="center" bgcolor="#003366" class="textoboldbranco">&nbsp;</td>
              <td bgcolor="#003366" class="textoboldbranco">Relat&oacute;rios Horizontais </td>
              <td align="center">&nbsp;</td>
              <td align="center" bordercolor="#003366" bgcolor="#003366" class="textoboldbranco">&nbsp;</td>
              <td bordercolor="#003366" bgcolor="#003366" class="textoboldbranco">Relat&oacute;rios Verticais</td>
              <td align="center" bordercolor="#003366" bgcolor="#003366" class="textoboldbranco">&nbsp;</td>
              <td bordercolor="#003366" bgcolor="#003366" class="textoboldbranco">&nbsp;</td>
            </tr>
            <tr>
              <td width="23" align="center"><input name="nome2[0]" type="checkbox" id="nome21" value="cronograma" onClick="hori();"></td>
              <td width="136" class="textobold">&nbsp;Cronograma</td>
              <td width="20" align="center">&nbsp;</td>
              <td width="20" align="center" bordercolor="#003366">                <input name="nome[0]" type="checkbox" id="nome" value="fluxo" onClick="veri();"></td>
              <td width="145" bordercolor="#003366" class="textobold">&nbsp;Diagrama de Fluxo</td>
              <td width="20" align="center" bordercolor="#003366"><input name="nome[5]" type="checkbox" id="nome5" value="rr"  onClick="veri();"></td>
              <td width="196" bordercolor="#003366" class="textobold">&nbsp;Estudos de R&amp;R </td>
            </tr>
            <tr>
              <td align="center"><input name="nome2[1]" type="checkbox" id="nome22" value="projeto" onClick="hori();" disabled></td>
              <td class="textobold">&nbsp;FMEA de Projeto </td>
              <td align="center">&nbsp;</td>
              <td align="center" bordercolor="#003366"><input name="nome[1]" type="checkbox" id="nome1" value="dimensional"  onClick="veri();"></td>
              <td bordercolor="#003366" class="textobold">&nbsp;Ensaio Dimensional </td>
              <td align="center" bordercolor="#003366"><input name="nome[6]" type="checkbox" id="nome6" value="capabilidade"  onClick="veri();"></td>
              <td bordercolor="#003366" class="textobold">&nbsp;Estudo de Capabilidade </td>
            </tr>
            <tr>
              <td align="center"><input name="nome2[2]" type="checkbox" id="nome23" value="processo" onClick="hori();"></td>
              <td class="textobold">&nbsp;FMEA de processo </td>
              <td align="center">&nbsp;</td>
              <td align="center" bordercolor="#003366"><input name="nome[2]" type="checkbox" id="nome2" value="material"  onClick="veri();"></td>
              <td bordercolor="#003366" class="textobold">&nbsp;Ensaio Material </td>
              <td align="center" bordercolor="#003366"><input name="nome[7]" type="checkbox" id="nome7" value="inst"  onClick="veri();" disabled></td>
              <td bordercolor="#003366" class="textobold">Instru&ccedil;&otilde;es do Operador </td>
            </tr>
            <tr>
              <td align="center"><input name="nome2[3]" type="checkbox" id="nome24" value="controle" onClick="hori();"></td>
              <td class="textobold">&nbsp;Plano de Controle </td>
              <td align="center">&nbsp;</td>
              <td align="center" bordercolor="#003366"><input name="nome[3]" type="checkbox" id="nome3" value="desempenho"  onClick="veri();"></td>
              <td bordercolor="#003366" class="textobold">&nbsp;Ensaio Desempenho </td>
              <td align="center" bordercolor="#003366"><input name="nome[8]" type="checkbox" id="nome8" value="sumario"  onClick="veri();"></td>
              <td bordercolor="#003366" class="textobold">Sum&aacute;rio e Aprova&ccedil;&atilde;o do APQP</td>
            </tr>
            <tr>
              <td align="center"><input name="nome2[4]" type="checkbox" id="nome25" value="aparencia" onClick="hori();" disabled></td>
              <td class="textobold">&nbsp;Aprova&ccedil;&atilde;o de Apar&ecirc;ncia</td>
              <td align="center">&nbsp;</td>
              <td align="center" bordercolor="#003366"><input name="nome[4]" type="checkbox" id="nome4" value="submissao"  onClick="veri();"></td>
              <td bordercolor="#003366" class="textobold">&nbsp;Certificado de Submissão </td>
              <td align="center" bordercolor="#003366">&nbsp;</td>
              <td bordercolor="#003366" class="textobold">&nbsp;</td>
            </tr>
            <tr>
              <td align="center"><input name="nome2[5]" type="checkbox" id="nome26" value="chk" onClick="hori();" disabled></td>
              <td class="textobold"><div align="left">Checklist APQP </div></td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td><div align="center">
              </div></td>
              <td colspan="2" align="left">&nbsp;                </td>
              </tr>
          </table>
          <span class="textobold">Obs: Todos Relat&oacute;rios est&atilde;o divididos em dois grupos, os R. Horizontais e os R. Verticais. Voc&ecirc; s&oacute; ira conseguir imprimir relat&oacute;rios de grupos iguais, ou seja, se voc&ecirc; quizer imprimir relat&oacute;rios Horizontais s&oacute; poder&aacute; imprimir relat&oacute;rios do grupo horizontal e vice-versa.</span><br>
          <table width="100%"  border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td bgcolor="#003366" class="textoboldbranco"><div align="center">Op&ccedil;&otilde;es de Envio </div></td>
            </tr>
            <tr>
              <td><table width="63%"  border="0" cellspacing="0" cellpadding="5" align="center">
                <tr class="textobold">
                  <td width="10%"><input name="acao" type="radio" value="email">
                  </td>
                  <td width="65%">Enviar no Email
                      <input name="email" type="text" id="email" value="Digite aqui o email"></td>
                  <td width="8%" align="center"><input name="acao" type="radio" value="imp"></td>
                  <td width="17%">Imprimir</td>
                </tr>
              </table>
                <div align="center">
                  <input type="submit" name="Submit" value="OK">
</div></td>
            </tr>
          </table>
          </form></td>
      </tr>
    </table>      </td>
  </tr>
  <tr>
    <td align="center" valign="top"><a href="apqp_pc.php"><img src="imagens/c_voltar.gif" alt="Voltar" width="41" height="14" border="0"></a></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>