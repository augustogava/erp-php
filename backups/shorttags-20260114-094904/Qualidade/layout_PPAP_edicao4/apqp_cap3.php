<?
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sqli=mysql_query("SELECT *,apqp_pc.nome AS nome, clientes.fantasia AS nomecli FROM apqp_pc,clientes WHERE apqp_pc.id='$pc' AND apqp_pc.cliente=clientes.id");
$rec=mysql_fetch_array($sqli);
$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car'");
if(mysql_num_rows($sqlc)) $resc=mysql_fetch_array($sqlc);
$sql=mysql_query("SELECT * FROM apqp_cap WHERE peca='$pc' AND car='$car'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	$sql=mysql_query("INSERT INTO apqp_cap (peca,car) VALUES ('$pc','$car')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM apqp_cap");
	$res=mysql_fetch_array($sql);
}
$id=$res["id"];
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de Capabilidade'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Dimensional'");
			if(mysql_num_rows($sqlb)){
				$javalimp="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='cap3';form1.submit(); }else{ return false; } }else{ return false; }";	$javalimp2="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) {form1.submit(); }else{ return false; } }else{ return false; }";	
			
			}else{
				print "foi";
				$javalimp="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='cap3';form1.submit(); } else {return false;} } return false;";
				$javalimp2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.submit(); } else {return false;} } return false;";
			}	
		}else{
			$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car' AND quem_cap<>''");
			if(mysql_num_rows($sqlc)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.submit(); return false; } return false;";
				$javalimp="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){  form1.acao.value='cap3';form1.submit(); } else {return false;}";
				$javalimp2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){   form1.submit(); } else {return false;}";
			}else{
				$javalimp="if(confirm('Deseja remover a aprovação?')){  form1.acao.value='cap3';form1.submit(); } else {return false;}";
				$javalimp2="if(confirm('Deseja remover a aprovação?')){  form1.submit(); } else {return false;}";
			}
		}
	}else{
		$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='cap3';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.submit(); }else{ return false; } }else{ return false; }";
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
function bloke(){
	document.all.form1.ap.disabled=true;	
	document.all.form1.rep.disabled=true;	
	document.all.form1.lap.disabled=true;	
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
	window.open('apqp_impressao.php?acao=salvar&local='+ form1.local.value +'&pc='+ id + '&car='+ <?=$car?> +'');
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
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nesta tela são exibidos os resultados do estudo de Capabilidade.<strong>Índice de Capacidade (Cp);</strong><br><strong>Índice de Capacidade Centralizado (Cpk)</strong><br><strong>Índice de Desempenho (Pp)</strong><br><strong>Índice de Desempenho Centralizado (Ppk)</strong>')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1">APQP - Estudo de Capabilidade <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><table width="594" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <a href="apqp_cap2.php?car=<?= $car; ?>">
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">estudo</td>
		</a>
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">resultados</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="700" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_cap_sql.php"><td bgcolor="#FFFFFF">
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td width="571"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td><table width="382" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
                <tr>
                  <td bgcolor="#FFFFFF"><table width="411" height="123" border="0" cellpadding="3" cellspacing="0">
                      <tr bgcolor="#999999" class="textoboldbranco">
                        <td colspan="6" align="center">Informa&ccedil;&otilde;es das Amostras </td>
                        </tr>
                      <tr>
                        <td width="78" height="35" class="textobold">&nbsp;Qtd. de Grupos:</td>
                        <td width="52" ><input name="textfield7" type="text" class="formularioselect" value="<?=completa($res["nli"],2); ?>" size="2" readonly=""></td>
                        <td width="54" class="textobold">&nbsp;LIE:</td>
                        <td width="62"  class="texto"><input name="textfield72" type="text" class="formularioselect" value="<?= banco2valor3($resc["lie"]); ?>" size="2" readonly=""></td>
                        <td width="67" class="textobold">&nbsp;X:</td>
                        <td width="62"  class="texto"><input name="textfield722" type="text" class="formularioselect" value="<?= banco2valor3($res["xbar"]); ?>" size="2" readonly=""></td>
                      </tr>
                      <tr>
                        <td width="78" class="textobold">&nbsp;Tamanho do Subgrupo:</td>
                        <td><input name="textfield23" type="text" class="formularioselect" value="05" size="2" readonly=""></td>
                        <td class="textobold">&nbsp;LSE:</td>
                        <td class="texto"><input name="textfield73" type="text" class="formularioselect" value="<?= banco2valor3($resc["lse"]); ?>" size="2" readonly=""></td>
                        <td class="textobold">&nbsp;R:</td>
                        <td class="texto"><input name="textfield723" type="text" class="formularioselect" value="<?= banco2valor3($res["rbar"]);  ?>" size="2" readonly=""></td>
                      </tr>
                      <tr>
                        <td width="78" class="textobold">&nbsp;N&ordm; total de Medidas:</td>
                        <td><input name="textfield33" type="text" class="formularioselect" value="<?=completa($res["nli"]*5,3); ?>" size="2" readonly=""></td>
                        <td class="textobold">&nbsp;M&iacute;nimo:</td>
                        <td class="texto"><input name="textfield74" type="text" class="formularioselect" value="<?= banco2valor3($res["min"]); ?>" size="2" readonly=""></td>
                        <td class="textobold">&nbsp;M&aacute;ximo:</td>
                        <td class="texto"><input name="textfield724" type="text" class="formularioselect" value="<?= banco2valor3($res["max"]); ?>" size="2" readonly=""></td>
                      </tr>
                      <tr>
                        <td colspan="4" class="textobold">&nbsp;N&uacute;mero de pontos fora  limites de controle :</td>
                        <td class="textobold"><span class="texto">
                          <input name="textfield725223" type="text" class="formularioselect" value="<?= $res["pf"]; ?>" size="2" readonly="">
                        </span></td>
                        <td class="texto">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
                    <tr>
                      <td bgcolor="#FFFFFF"><table width="100%" height="35" border="0" cellpadding="3" cellspacing="0">
                          <tr bgcolor="#003366" class="textoboldbranco">
                            <td colspan="4" align="center">Carta de M&eacute;dias </td>
                          </tr>
                          <tr>
                            <td width="85" class="textobold">&nbsp;Inferior (LCI) :</td>
                            <td width="61"><span class="texto">
                              <input name="textfield742" type="text" class="formularioselect" value="<?= banco2valor3($res["lcl"]); ?>" size="2" readonly="">
                            </span></td>
                            <td width="102" class="textobold">&nbsp;Superior (LCS) :</td>
                            <td width="56" class="texto"><input name="textfield725" type="text" class="formularioselect" value="<?= banco2valor3($res["uclx"]); ?>" size="2" readonly=""></td>
                            </tr>
                          <tr>
                            <td colspan="3" class="textobold">&nbsp;N&uacute;mero de pontos fora  limites de controle : </td>
                            <td class="texto"><input name="textfield725222" type="text" class="formularioselect" value="<?= $res["mpf"]; ?>" size="2" readonly=""></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
                    <tr>
                      <td bgcolor="#FFFFFF"><table width="100%" height="35" border="0" align="right" cellpadding="3" cellspacing="0">
                          <tr bgcolor="#003366" class="textoboldbranco">
                            <td colspan="4" align="center">Carta de Amplitudes </td>
                          </tr>
                          <tr>
                            <td width="99" class="textobold">&nbsp;Inferior (LCI) :</td>
                            <td width="51"><span class="texto">
                              <input name="textfield7422" type="text" class="formularioselect" value="<?= banco2valor3(0); ?>" size="2" readonly="">
                            </span></td>
                            <td width="104" class="textobold">&nbsp;Superior (LCS) :</td>
                            <td width="53" class="texto"><input name="textfield7252" type="text" class="formularioselect" value="<?= banco2valor3($res["uclr"]); ?>" size="2" readonly=""></td>
                          </tr>
                          <tr>
                            <td colspan="3" class="textobold">&nbsp;N&uacute;mero de pontos fora limites de controle:</td>
                            <td class="texto"><input name="textfield72522" type="text" class="formularioselect" value="<?= $res["apf"]; ?>" size="2" readonly=""></td>
                          </tr>
                      </table>
                        <p>&nbsp;</p>
                        </td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#003366">
                <tr>
                  <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr bgcolor="#003366" class="textoboldbranco">
                      <td colspan="8" align="center">Capabilidade</td>
                    </tr>
                    <tr>
                      <td width="103" class="textobold">&nbsp;Desvio Padr&atilde;o :</td>
                      <td width="82"><span class="texto">
                        <input name="textfield7262" type="text" class="formularioselect" value="<?= banco2valor3($res["sigma"]); ?>" size="2" readonly="">
                      </span></td>
                      <td width="22" align="center" class="textobold">&nbsp;Cp:</td>
                      <td width="94" class="texto"><input name="textfield726" type="text" class="formularioselect" value="<?= banco2valor3($res["cp"]); ?>" size="2" readonly=""></td>
                      <td width="33" align="center" class="textobold">&nbsp;Cpk:</td>
                      <td width="88" class="texto"><input name="textfield7222" type="text" class="formularioselect" value="<?= banco2valor3($res["cpk"]); ?>" size="2" readonly=""></td>
                      <td width="30" class="textobold"><div align="center">CR:</div></td>
                      <td width="89" class="texto"><input name="textfield72222" type="text" class="formularioselect" value="<?= banco2valor3($res["cr"]); ?>" size="2" readonly=""></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
                <br>
                <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#003366">
                  <tr>
                    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                        <tr bgcolor="#003366" class="textoboldbranco">
                          <td colspan="8" align="center">Performace</td>
                        </tr>
                        <tr>
                          <td width="103" class="textobold">&nbsp;Desvio Padr&atilde;o :</td>
                          <td width="82"><span class="texto">
                            <input name="per" type="text" class="formularioselect" id="per" value="<?= banco2valor3($res["sigma2"]); ?>" size="2" readonly="">
                          </span></td>
                          <td width="22" align="center" class="textobold">Pp:</td>
                          <td width="94" class="texto"><input name="pp" type="text" class="formularioselect" id="pp" value="<?= banco2valor3($res["pp"]); ?>" size="2" readonly=""></td>
                          <td width="33" align="center" class="textobold">Ppk:</td>
                          <td width="88" class="texto"><input name="ppk" type="text" class="formularioselect" id="ppk" value="<?= banco2valor3($res["ppk"]); ?>" size="2" readonly=""></td>
                          <td width="30" class="textobold"><div align="center">PR:</div></td>
                          <td width="89" class="texto"><input name="pr" type="text" class="formularioselect" id="pr" value="<?= banco2valor3($res["pr"]); ?>" size="2" readonly=""></td>
                        </tr>
                    </table></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><img src="imagens/dot.gif" width="20" height="8"></td>
              </tr>
            <tr>
              <td align="center" bgcolor="#003366" class="textoboldbranco">M&eacute;dias</td>
            </tr>
            <tr>
              <td align="center"><img src="apqp_cap_xbar.php?id=<?= $res["id"]; ?>"></td>
            </tr>
            <tr>
              <td align="center" class="texto"><span class="textobold">X:</span>&nbsp;<?= banco2valor3($res["xbar"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="textobold">LICX:</span>&nbsp;
                <?= banco2valor3($res["lcl"]); ?>                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="textobold">LSCX</span>:&nbsp;
                <?= banco2valor3($res["uclx"]); ?></td>
            </tr>
            <tr>
              <td align="center"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#003366" class="textoboldbranco">Amplitudes</td>
            </tr>
            <tr>
              <td align="center"><img src="apqp_cap_rbar.php?id=<?= $res["id"]; ?>"></td>
            </tr>
            <tr>
              <td align="center" class="texto"><span class="textobold">R:</span>&nbsp;
                  <?= banco2valor3($res["rbar"]); ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="textobold">LSCR</span>:&nbsp;
    <?= banco2valor3($res["uclr"]); ?></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#003366" class="textoboldbranco">Histograma</td>
            </tr>
            <tr>
              <td align="center"><img src="apqp_cap_hbar.php?id=<?= $res["id"]; ?>"></td>
            </tr>
            <tr>
              <td><img src="imagens/spacer.gif" width="46" height="5"></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr bgcolor="#003366" class="textoboldbranco">
                  <td width="14%" align="center">Disposi&ccedil;&atilde;o</td>
                  <td width="43%" align="center">Respons&aacute;vel</td>
                  <td width="15%" align="center">Data</td>
                  <td width="28%" align="center">a&ccedil;&otilde;es</td>
                  </tr>
                <tr>
                  
                  <td align="center" class="textobold"><input name="tap1" type="text" class="formularioselect" id="tap15" value="<? if($res["sit"]==0){ print "pendente"; }elseif($res["sit"]==1){ print "aprovado"; }else{ print "reprovado"; } ?>" size="1"></td>
                  <td align="center"><span class="textobold">
                    <input name="tap12" type="text" class="formularioselect" id="tap123" value="<?= $resc["quem_cap"]; ?>">
                  </span></td>
                  <td align="center" class="textobold"><input name="dap" type="text" class="formularioselect" id="dap12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($resc["dtquem_cap"]); ?>" size="7" maxlength="10"></td>
				   <? 
				  if($res["sit"]==2){
				  	$javalimp2="window.alert('O Estudo de Capabilidade já está reprovado!'); return false;";
					$javas="window.alert('O Estudo de Capabilidade está reprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }else{
				  	  if(empty($resc["quem_cap"])){
				  		$javas="if(confirm('Deseja Aprovar essa Pe&ccedil;a?')){form1.submit();}else{ return false; }";
						$javalimp="window.alert('O Estudo de Capabilidade não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  	}else{
				  		$javas="window.alert('O Estudo de Capabilidade já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
					  }
				  }
				  ?>
                  <td align="center"><p>
                      <input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?= $javas; ?>">
				&nbsp;
				<input name="rep" type="submit" class="microtxt" id="rep" value="rejeitar" onClick="<?= $javalimp2;?>">
				&nbsp;
				<input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="<?= $javalimp;?>">
                  </p>                    </td>
					</tr>
					<? 
				   $sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de Capabilidade'");
				   $resb=mysql_fetch_array($sqlb);
				  if($resb["resp"]){
						$javas2="window.alert('O Estudo de R&R está reprovado, se deseja aprovar, clique em Limpar primeiro.');return false;";
						$limpa2="form1.submit();";
				  }else{
				  	  if(empty($res["quem"])){
				  		$javas2="if(confirm('Deseja Aprovar essa Pe&ccedil;a?')){ form1.submit(); }else{ return false; }";
						$limpa2="window.alert('O Estudo de R&R não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  	}else{
				  		$javas2="window.alert('O Estudo de R&R já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
					  }
				  }
				  ?>
                <tr>
                  <td align="center" class="textobold">Aprova&ccedil;&atilde;o Capabilidade </td>
                  <td align="center"><span class="textobold">
                    <input name="tap1232" type="text" class="formularioselect" id="tap1232" value="<?= $resb["resp"]; ?>">
                  </span></td>
                  <td align="center" class="textobold"><input name="dap12" type="text" class="formularioselect" id="dap1" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($resb["fim"]); ?>" size="7" maxlength="10"></td>
                  <td align="center"><input name="apro" type="submit" class="microtxt" id="apro" value="Aprovar" onClick="<?= $javas2; ?>">
                    &nbsp;&nbsp;&nbsp;
                    <input name="lim" type="submit" class="microtxt" id="lim" value="Limpar" onClick="<?= $limpa2; ?>"></td>
                </tr>
                <input name="acao2" type="hidden" id="acao2" value="v4">
              </table>
			  <? if($aprov=="N") print "<script>bloke();</script>"; ?>
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
              <td align="center">
                <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_cap.php';">
				&nbsp;
				<input name="button34" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('apqp_cap_imp','<?=$res["id"];?>')">
&nbsp;&nbsp;
<?
$apqp->agenda_p("Estudos de Capabilidade","apqp_cap3.php");
?>
<input name="car" type="hidden" id="car" value="<?= $car; ?>">
                <input name="acao" type="hidden" id="acao" value="cap3">
                <input name="id" type="hidden" id="id" value="<?= $res["id"]; ?>">
                <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
                <input name="local" type="hidden" id="local" value="capabilidade">
                </a></td>
              </tr>
          </table>
        </td></form>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>