<?
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$user=$_SESSION["login_funcionario"];

//Verificação
$_SESSION["modulo"]="dime";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='dime'");
if(mysql_num_rows($sqlm)){
	$resm=mysql_fetch_array($sqlm);
	if($resm["funcionario"]=="S" or empty($resm["funcionario"])){
		$sql2=mysql_query("SELECT * FROM funcionarios WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}else{
		$sql2=mysql_query("SELECT * FROM clientes WHERE id='$resm[user]'"); $res2=mysql_fetch_array($sql2);
	}
	$_SESSION["mensagem"]="O usuario $res2[nome] está alterando este módulo!";
	header("Location:apqp_menu.php");
	exit;
}
// - - -FIM- - - 
$sql=mysql_query("SELECT * FROM apqp_endi WHERE peca='$pc'");
if(!mysql_num_rows($sql)){
	$sql=mysql_query("INSERT INTO apqp_endi (peca) VALUES ('$pc')");
	$sql=mysql_query("SELECT * FROM apqp_endi WHERE peca='$pc'");
}
$res=mysql_fetch_array($sql);

	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Dimensional'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Material'");
			if(!mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='alt'; if(verifica()){ form1.submit(); } return false; } return false;";
				$btn_car="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ selcar(); } return false;";
				$btn_aut="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ return preenche(); } return false;";
				$btn_exc="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja remover as linhas selecionadas?')){form1.acao.value='alt';form1.delsel.value='1';form1.submit(); } return false; } return false;";
			}else{
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ form1.acao.value='alt'; if(verifica()){ form1.submit(); }  } return false;";
				$btn_car="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ selcar(); } return false;";
				$btn_aut="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ return preenche(); } return false;";
				$btn_exc="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprová-los novamente!?')){ if(confirm('Deseja remover as linhas selecionadas?')){form1.acao.value='alt';form1.delsel.value='1';form1.submit(); } return false; } return false;";
			}
		}else{
			$btnsalva="form1.acao.value='alt'; if(verifica()){ form1.submit(); } return false;";
			$btn_car="selcar();";
			$btn_aut="return preenche();";
			$btn_exc="if(confirm('Deseja remover as linhas selecionadas?')){form1.acao.value='alt';form1.delsel.value='1';form1.submit(); } return false;";
		}
			$sqlenma=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
			if(mysql_num_rows($sqlenma)){
				$javalimp="if(confirm('Deseja remover a aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')){ form1.acao.value='alt';form1.submit(); }else{ return false; } } else{return false;}";		
			} else {
				$javalimp="if(confirm('Deseja remover a aprovação?')){ form1.acao.value='alt';form1.submit(); } else {return false;}";
			}
	}else{
		if($_SESSION["login_funcionario"]=="S"){
			$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='alt'; if(verifica()){ form1.submit(); } return false; }else{ return false; } }else{ return false; }";
			$btn_car="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ selcar(); }else{ return false; } }else{ return false; }";
			$btn_aut="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ return preenche(); }else{ return false; } }else{ return false; }";
			$btn_exc="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='alt';form1.delsel.value='1';form1.submit(); }else{ return false; } }else{ return false; }";
			
			$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='alt';form1.submit(); }else{ return false; } }else{ return false; }";
		}else{
			$sqlv=mysql_query("SELECT * FROM apqp_pc WHERE id='$pc'");
			$resv=mysql_fetch_array($sqlv);
			if($resv["status"]>1){
				$btnsalva="form1.acao.value='alt'; form1.submit();";
				$btn_car="selcar();";
				$btn_aut="return preenche();";
				$btn_exc="if(confirm('Deseja remover as linhas selecionadas?')){form1.acao.value='alt';form1.delsel.value='1';form1.submit(); } return false;";
			}else{
				$btnsalva="window.alert('Certificado de submissão deve estar aprovado pelo fornecedor!');";
				$btn_car="window.alert('Certificado de submissão deve estar aprovado pelo fornecedor!');";
				$btn_aut="window.alert('Certificado de submissão deve estar aprovado pelo fornecedor!');";
				$btn_exc="window.alert('Certificado de submissão deve estar aprovado pelo fornecedor!');";
			}
		}
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
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?=$pc?> + '');
	return true;
}

function preenche(){
	if(confirm('A tabela do Relatório Dimensional será preenchida com todas as características do tipo DIMENSIONAL em ordem crescente.\nOs dados existentes na tabela serão DELETADOS.\nVocê deseja continuar?')){
		form1.acao.value='auto';
		form1.submit();
	}
	return false;
}
function selcar(){
	varcar=form1.wcar[form1.wcar.selectedIndex].value;
	form1.maisum.value=varcar;
	if(varcar!=0){
		form1.submit();
	}
}
function verifica(cad){
	for(i=1;i<=form1.acum.value;i++){
			if(document.all['forn'+i].value==''){
				alert('Preencha campo Pelo Fornecedor');
				form1.document.all['forn'+i].focus();
				return false;
			}		
	}
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
.style2 {color: #004996}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="81%" border="0" cellpadding="0" cellspacing="0">
  <form name="form1" method="post" action="apqp_endi_sql.php">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_ensaio_dim.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Ensaio dimensional '; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Relatório do Ensaio de Dimensional deve ser preenchido conforme o Manual do PPAP da AIAG - Segunda Edição, Fevereiro 95 Segunda Impressão Julho 95.<br><strong>Local da Inspeção - </strong>Local onde a inspeção foi realizada<br><strong>Item - </strong>Sistema de referência adotado para identificar as características. <br><strong>Dimensão/Especificação - </strong>Descrições das características tal como mencionadas nos desenhos.<br><strong>Resultados das medições - </strong>Esses campos que são editáveis para entrar com os resultados.<br><strong>S - </strong>Símbolo referente à característica.<br><strong>Botão Automático - </strong>Ao clicar neste botão ele ira preencher a tabela com toda a característica do tipo dimensional.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - Ensaio dimensional <? print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>      </td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr class="textobold">
        <td width="997"><table width="600" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="161" class="textobold">&nbsp;Laborat&oacute;rio:</td>
            <td width="202"><input name="locall" type="text" class="formulario" id="local2" value="<?= $res["local"]; ?>" size="40" maxlength="50"></td>
            <td width="219">&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Caracter&iacute;stica:</td>
            <td><select name="wcar" class="formulario" id="select" onChange="<?= $btn_car; ?>">
              <option value="0">Selecione</option>
              <?
$cars=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc' AND tipo='Dim' ORDER BY numero ASC");
if(mysql_num_rows($cars)){
	while($rcars=mysql_fetch_array($cars)){
?>
              <option value="<?= $rcars["id"]; ?>">
              <?= htmlspecialchars($rcars["numero"], ENT_QUOTES); ?>
  -
  <?= htmlspecialchars($rcars["descricao"], ENT_QUOTES); ?>
              </option>
              <?
	}
}
?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Adicionar Caracter&iacute;sticas:</td>
            <td><input name="buton" type="button" class="microtxt" onClick="<?= $btn_aut; ?>" value="Autom&aacute;tico"></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr class="textobold">
        <td><table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#999999">
            <?
$sql=mysql_query("SELECT ensaio1.*,car.numero,car.descricao,car.simbolo,car.espec,car.tipo,car.lie,car.lse FROM apqp_car AS car, apqp_endi AS ensaio, apqp_endil AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER By car.numero ASC");
if(!mysql_num_rows($sql)){
?>
            <tr>
              <td colspan="10" align="center" bgcolor="#003366" class="textoboldbranco">Ensaio Dimensional </td>
            </tr>
            <tr>
              <td colspan="10" align="center" class="textopretobold">SELECIONE AS CARACTER&Iacute;STICAS </td>
            </tr>
            <?
}else{
?>
            <tr align="center" bgcolor="#003366">
              <td colspan="2" rowspan="2" bgcolor="#004996" class="textoboldbranco">Item</td>
              <td width="269" rowspan="2" class="textoboldbranco">Dimens&atilde;o / Especifica&ccedil;&atilde;o </td>
              <td width="34" rowspan="2" class="textoboldbranco">LIE</td>
              <td width="34" rowspan="2" class="textoboldbranco">LSE </td>
              <td width="59" rowspan="2" align="center" class="textoboldbranco">Data do Teste</td>
              <td width="44" rowspan="2" align="center" class="textoboldbranco">&nbsp;Quant. Testada</td>
              <td width="200" height="15" bgcolor="#4871AD" class="rodape">Resultados das Medi&ccedil;&otilde;es </td>
              <td rowspan="2" align="center" class="textoboldbranco">Ok</td>
              <td rowspan="2" align="center" class="textoboldbranco">N&atilde;o<br>
            Ok</td>
            </tr>
            <tr align="center" bgcolor="#003366" class="textoboldbranco">
              <td> <div align="center">Pelo Fornecedor</div>                <div align="center"></div></td>
              </tr>
            <?
	$i=0;
	while($res1=mysql_fetch_array($sql)){
		$i++;
		$dimenesp="$res1[descricao] - $res1[espec]";
		$especificacao="$res1[lie] / $res1[lse]";
?>
            <tr>
              <td width="22" align="center"><input name="del[<?= $res1["id"]; ?>]" type="checkbox" id="del[<?= $res1["id"]; ?>]" value="<?= $res1["id"]; ?>"></td>
              <td width="16"><input name="pcar1" type="text" class="formularioselectsemborda" id="pcar1" size="1"  value="<?= $res1["numero"]; ?>" readonly=""></td>
              <td><input name="pcar2" type="text" class="formularioselectsemborda" id="pcar2"  value="<?= $dimenesp; ?>" size="1" maxlength="50" readonly=""></td>
              <td><input name="lie" type="text" class="formularioselectsemborda" id="lie" size="1"  value="<? print $res1["lie"];?>" readonly=""></td>
              <td><input name="esp_lim22" type="text" class="formularioselectsemborda" id="lse" size="1"  value="<? print $res1["lse"];?>" readonly=""></td>
              <td align="center"><input name="data_t[<?= $res1["id"]; ?>]" type="text" class="formularioselectsemborda" id="data_t[<?= $res1["id"]; ?>]"  value="<? if($res["data_t"]!="0000-00-00"){ print banco2data($res1["data_t"]); } ?>" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="1" maxlength="10"></td>
              <td align="center"><input name="quant_test[<?= $res1["id"]; ?>]" type="text" class="formularioselectsemborda" id="quant_test[<?= $res1["id"]; ?>]"  value="<? if($res1["quant_test"]!="0"){ print $res1["quant_test"]; } ?>" size="1" maxlength="7"></td>
              <td><input name="forn[<?= $res1["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="forn<?= $i; ?>"  value="<?= $res1["forn"]; ?>" size="40" maxlength="255"></td>
              <td width="32" align="center"><input name="ok[<?= $res1["id"]; ?>]" type="radio" value="S" <? if($res1["ok"]=="S") print "checked"; ?>></td>
              <td width="33" align="center"><input name="ok[<?= $res1["id"]; ?>]" type="radio" value="N" <? if($res1["ok"]=="N") print "checked"; ?>></td>
            </tr>
            <?
	}
}
?>
            <input name="delsel" type="hidden" id="delsel" value="0">
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><div align="left"><img src="imagens/dot.gif" width="20" height="8">
    </div>    </td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="600" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#999999" bgcolor="#999999">
      <tr>
        <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr class="textobold">
              <td width="104" align="right"><div align="left">Aprovado por:</div></td>
              <td width="200" ><input name="quem1" type="text" class="formulario" id="quem2" value="<?= $res["quem"]; ?>" size="40" maxlength="255"></td>
              <td width="28" align="center"><div align="left">Data:</div></td>
              <td width="60" ><input name="dtquem" type="text" class="formulario" id="dtquem3" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["dtquem"]); ?>" size="12" maxlength="10"></td>
              <? 
		 		  if(empty($res["quem"])){
				  	$javas="if(confirm('Deseja Aprovar Ensaio Dimensional?')){form1.acao.value='alt';form1.submit();}else{ return false; }";
					$javalimp="window.alert('O Ensaio Dimensional n&atilde;o foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
				  $javas="window.alert('O Ensaio Dimensional j&aacute; foi aprovado, caso deseje retirar a aprova&ccedil;&atilde;o, clique no bot&atilde;o limpar.');return false;";
				  }
				  
				  ?>
              <td width="126"><div align="center">
                  <input name="ap" type="submit" class="microtxt" id="ap2" value="aprovar" onClick="<?= $javas; ?>" <? if($user=="N"){?>disabled<? } ?>>
                &nbsp;
                <input name="lap" type="submit" class="microtxt" id="lap2" value="limpar" onClick="<?= $javalimp;?>" <? if($user=="N"){?>disabled<? } ?>>
              </div></td>
            </tr>
            <tr class="textobold">
              <td align="right"><div align="left">Representante do cliente: </div></td>
              <td><input name="rep1" type="text" class="formulario" id="rep1" value="<?= $res["rep"]; ?>" size="40" maxlength="255"></td>
              <td align="center"><div align="left">Data:</div></td>
              <td><input name="dtrep" type="text" class="formulario" id="dtrep2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($res["dtrep"]); ?>" size="12" maxlength="10"></td>
              <td width="126"><div align="left">
                  <? 	 
			if(empty($res["rep"])){
				if($resv["status"]>1){
					$javas2="if(confirm('Deseja Aprovar Ensaio Dimensional?')){ if(confirm('Caso aprove, n&atilde;o ser&aacute; poss&iacute;vel remover a aprova&ccedil;&atilde;o. Tem certeza que deseja aprovar?')){ form1.acao.value='alt';form1.submit();}}else{ return false; }";
				}else{
					$javas2="return false;";
				}
			}else{
					$javas2="return false;";
			}
	  		?>
                &nbsp;
                <input name="ap2" type="submit" class="microtxt" id="ap2" value="aprovar" onClick="<?= $javas2; ?>" <? if( ($user!="N")||(empty($res["quem"])) ){?> disabled <? } ?>>
              </div></td>
            </tr>
          </table>
            <? if($aprov=="N") print "<script>bloke();</script>"; ?></td>
      </tr>
      <tr>
        <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><table width="601" border="0" align="center" cellpadding="3" cellspacing="0" class="texto">
            <tr>
              <? if($_SESSION["e_mail"]=="S"){ ?>
              <td width="16%" align="left" class="textobold">&nbsp;Enviar e-mail: </td>
              <td width="56%"><input name="email" type="text" class="formularioselect" id="email3" value="Digite o e-mail aqui"></td>
              <? if(in_array("U",$emailt)){ ?>
              <td width="3%"><div align="center"><a href="#" onClick="return abre('busca_email2.php','a','width=320,height=380,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" alt="Buscar Email de Funcion&aacute;rios" width="14" height="14" border="0"></a></div></td>
              <? } if(in_array("G",$emailt)){ ?>
              <td width="8%"><div align="center"><a href="#" onClick="return abre('busca_email_grupo.php','a','width=320,height=380,scrollbars=1');">
                <input name="grupo" type="hidden" id="grupo">
                  <input name="grupo_nome" type="hidden" id="grupo_nome">
                <img src="imagens/icon14_grupo.gif" alt="Buscar Grupo de Emails" width="26" height="13" border="0"></a></div></td>
              <? } if(in_array("C",$emailt)){ ?>
              <td width="4%"><div align="center"><a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"></a><a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" alt="Buscar Emails de Clientes" width="18" height="18" border="0"></a></div></td>
              <? } ?>
              <td width="9%"><div align="center">
                <? if($_SESSION["login_funcionario"]=="S"){ ?>
                <a href="#" onClick="vailogo1('email','<?= $pc; ?>');"><img src="imagens/icon14_mail.gif" alt="Enviar Email" width="16" height="10" border="0"></a>
                <? } ?>
              </div></td>
              <? } if($_SESSION["i_mp"]=="S"){ ?>
              <td width="4%"><div align="center"><a href="#" onClick="vailogo('imp');"><img src="imagens/icon14_imp.gif" alt="Imprimir" width="15" height="15" border="0"></a></div></td>
              <? } ?>
            </tr>
            <tr>
              <td colspan="7" align="left" class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF"><input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
          &nbsp;
          <input name="acao3" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('dimensional','<?=$res["id"];?>')">
          &nbsp;
          <input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?= $btnsalva; ?>;">
          &nbsp;
          <input name="button12223" type="button" class="microtxt" value="Remover Linha" onClick="<?= $btn_exc; ?>">
          &nbsp;&nbsp;
          <?
$apqp->agenda_p("Ensaio Dimensional","apqp_endi.php");
?>
          <input name="maisum" type="hidden" id="maisum">
          <input name="acao" type="hidden" id="acao" value="alt">
          <input name="id" type="hidden" id="id" value="<?= $res["id"]; ?>">
          <input name="local" type="hidden" id="local" value="dimensional">
          <input type="hidden" name="acum"></td>
      </tr>
    </table></td>
  </tr>
</table></form>
</body>
</html>
<script>
arop1=new Array;
arop2=new Array;
arop3=new Array;
arop4=new Array;
<?= $montaray; ?>
</script>
<script language="javascript" src="tooltip.js"></script>
<? include("mensagem.php"); ?>