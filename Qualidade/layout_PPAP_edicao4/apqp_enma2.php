<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$locall=Input::request("locall");
$forn_mat=Input::request("forn_mat");
$forncod=Input::request("forncod");
$wcar=Input::request("wcar");
$maisum=Input::request("maisum");
$ap=Input::request("ap");
$lap=Input::request("lap");
$ap2=Input::request("ap2");
$delsel=Input::request("delsel");
$del=Input::request("del", []);
$forn=Input::request("forn", []);
$cli=Input::request("cli", []);
$ok=Input::request("ok", []);
$data_t=Input::request("data_t", []);
$quant_test=Input::request("quant_test", []);
$local=Input::request("local");
$email=Input::request("email");
$id=Input::request("id");
$rep1=Input::request("rep1");
$apqp=new set_apqp;
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$user=$_SESSION["login_funcionario"];

//Verificação
$_SESSION["modulo"]="mater";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='mater'");
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
$sql=mysql_query("SELECT * FROM apqp_enma WHERE peca='$pc'");
if(!mysql_num_rows($sql)){
	$sql=mysql_query("INSERT INTO apqp_enma (peca) VALUES ('$pc')");
	$sql=mysql_query("SELECT * FROM apqp_enma WHERE peca='$pc'");
}
$res=mysql_fetch_array($sql);

	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Material'");
		if(mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Ensaio Desempenho'");
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
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?php echo $pc?> + '');
	return true;
}

function preenche(){
	if(confirm('A tabela do Relatório Material será preenchida com todas as características do tipo MATERIAL em ordem crescente.\nOs dados existentes na tabela serão DELETADOS.\nVocê deseja continuar?')){
		form1.acao.value='auto';
		form1.submit();
	}
	return false;
}
function selcar(){
	varcar=form1.wcar[form1.wcar.selectedIndex].value;
	form1.maisum.value=varcar;
	form1.acao.value="alt";
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
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <form name="form1" method="post" action="apqp_enma_sql.php">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_ensaio_amt.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Ensaio material'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Relatório do Ensaio de Material deve ser preenchido conforme o Manual do PPAP da AIAG - Segunda Edição, Fevereiro 95 Segunda Impressão Julho 95.<br><strong>Laboratório - </strong>Local onde os ensaios realizados.<br><strong>Tipo de teste - </strong>Teste que é realizado para determinação de uma determinada característica do material.<br><strong>S - </strong>Símbolo referente à característica.<br><strong>Dimensão/especificação - </strong>Descrições das características tal como mencionadas nos desenhos.<br><strong>result.das medições - </strong>Campo onde você entra com os resultados das dimensões obtidos pelo cliente ou pelo fornecedor.<br><strong>Botão Automático - </strong>Ao clicar neste botão ele ira preencher a tabela com toda a característica do tipo material.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - Ensaio material <?php print $npc; ?></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr class="textobold">
        <td width="881"><table width="928" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="233" class="textobold">&nbsp;Laborat&oacute;rio: </td>
            <td width="227"><input name="locall" type="text" class="formulario" id="local2" value="<?php echo  $res["local"]; ?>" size="40" maxlength="50"></td>
            <td width="113" class="textobold">&nbsp;Forn. do Material: </td>
            <td width="331"><input name="forn_mat" type="text" class="formulario" id="forn_mat" value="<?php echo  $res["forn_mat"]; ?>" size="40" maxlength="50"></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Forn. - espec. - cliente / C&oacute;d. Vendedor:</td>
            <td class="textobold"><input name="forncod" type="text" class="formulario" id="forncod" value="<?php echo  $res["forncod"]; ?>" size="40" maxlength="26"></td>
            <td class="textobold">&nbsp;Caracter&iacute;stica:</td>
            <td><select name="wcar" class="formulario" id="select" onChange="<?php echo  $btn_car; ?>">
                <option value="0">Selecione</option>
                <?php
$cars=mysql_query("SELECT * FROM apqp_car WHERE peca='$pc' AND tipo='Mat' ORDER BY numero ASC");
if(mysql_num_rows($cars)){
	while($rcars=mysql_fetch_array($cars)){
?>
                <option value="<?php echo  $rcars["id"]; ?>">
                <?php echo  htmlspecialchars($rcars["numero"], ENT_QUOTES); ?>
                  -
                  <?php echo  htmlspecialchars($rcars["descricao"], ENT_QUOTES); ?>
                </option>
                <?php
	}
}
?>
            </select></td>
          </tr>
          <tr>
            <td class="textobold">&nbsp;Adicionar Caracter&iacute;sticas:</td>
            <td><input name="Submit" type="submit" class="microtxt" value="Autom&aacute;tico" onClick="<?php echo  $btn_aut; ?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr class="textobold">
        <td><table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#999999">
          <?php
$sql=mysql_query("SELECT ensaio1.* AS tp,car.numero,car.descricao,car.espec,car.tipo,car.lie,car.lse FROM apqp_car AS car, apqp_enma AS ensaio, apqp_enmal AS ensaio1 WHERE ensaio1.car=car.id AND ensaio.peca='$pc' AND ensaio.id=ensaio1.ensaio ORDER By car.numero ASC");
if(!mysql_num_rows($sql)){
?>
          <tr>
            <td colspan="11" align="center" bgcolor="#003366" class="textoboldbranco">Ensaio Material </td>
          </tr>
          <tr>
            <td colspan="11" align="center" class="textopretobold">SELECIONE AS CARACTER&Iacute;STICAS </td>
          </tr>
          <?php
}else{
?>
          <tr align="center" bgcolor="#003366">
            <td colspan="2" rowspan="2" bgcolor="#004996" class="textoboldbranco">Item</td>
            <td width="325" rowspan="2" class="textoboldbranco"> Especifica&ccedil;&atilde;o do Material / Rev. / Data</td>
            <td width="33" rowspan="2" class="textoboldbranco">LIE</td>
            <td width="32" rowspan="2" class="textoboldbranco">LSE </td>
            <td width="52" rowspan="2" class="textoboldbranco">Data do Teste </td>
            <td width="44" rowspan="2" align="center" class="textoboldbranco"><p align="center">&nbsp;Quant. Testada</p>              </td>
            <td colspan="2" bgcolor="#4871AD" class="rodape">Resultado das Medi&ccedil;&otilde;es</td>
            <td width="20" rowspan="2" align="center" class="textoboldbranco">Ok</td>
            <td width="29" rowspan="2" align="center" class="textoboldbranco">N&atilde;o<br>
      Ok </td>
          </tr>
          <tr align="center" bgcolor="#003366" class="textoboldbranco">
            <td width="176"> Pelo Fornecedor </td>
            <td width="175">Pelo Cliente </td>
          </tr>
          <?php
	$i=0;
	while($res1=mysql_fetch_array($sql)){
		$i++;
		$dimenesp="$res1[descricao] - $res1[espec]";
		$especificacao="$res1[lie] / $res1[lse]";
?>
          <tr>
            <td width="25" align="center"><input name="del[<?php echo  $res1["id"]; ?>]" type="checkbox" id="del[<?php echo  $res1["id"]; ?>]" value="<?php echo  $res1["id"]; ?>"></td>
            <td width="19"><input name="pcar1" type="text" class="formularioselectsemborda" id="pcar1" size="1"  value="<?php echo  $res1["numero"]; ?>" readonly=""></td>
            <td><input name="pcar2" type="text" class="formularioselectsemborda2222" id="pcar2" value="<?php echo  $dimenesp; ?>" size="60" maxlength="50" readonly=""></td>
            <td><input name="lie" type="text" class="formularioselectsemborda" id="lie" size="1"  value="<?php print $res1["lie"];?>" readonly=""></td>
            <td><input name="esp_lim22" type="text" class="formularioselectsemborda" id="lse" size="1"  value="<?php print $res1["lse"];?>" readonly=""></td>
            <td><input name="data_t[<?php echo  $res1["id"]; ?>]" type="text" class="formularioselectsemborda" id="data_t[<?php echo  $res1["id"]; ?>]"  value="<?php if($res["data_t"]!="0000-00-00"){ print banco2data($res1["data_t"]); } ?>" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="1" maxlength="10"></td>
            <td align="center"><input name="quant_test[<?php echo  $res1["id"]; ?>]" type="text" class="formularioselectsemborda" id="quant_test[<?php echo  $res1["id"]; ?>]"  value="<?php if($res1["quant_test"]!="0"){ print $res1["quant_test"]; } ?>" size="1" maxlength="7"></td>
            <td><input name="forn[<?php echo  $res1["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="forn<?php echo  $i; ?>"  value="<?php echo  $res1["forn"]; ?>" size="30" maxlength="255"></td>
            <td><input name="cli[<?php echo  $res1["id"]; ?>]" type="text" class="formularioselectsemborda2222" id="cli<?php echo  $res1["id"]; ?>" size="30" maxlength="255" value="<?php echo  $res1["cli"]; ?>"></td>
            <td align="center"><input name="ok[<?php echo  $res1["id"]; ?>]" type="radio" value="S" <?php if($res1["ok"]=="S") print "checked"; ?>></td>
            <td align="center"><input name="ok[<?php echo  $res1["id"]; ?>]" type="radio" value="N" <?php if($res1["ok"]=="N") print "checked"; ?>></td>
          </tr>
          <?php
	}
}
?>
          <input name="maisum" type="hidden" id="maisum" value="0">
          <input name="delsel" type="hidden" id="delsel" value="0">
        </table></td>
      </tr>
      <tr class="textobold">
        <td><img src="imagens/dot.gif" width="20" height="8"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="600" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#999999" bgcolor="#999999">
      <tr>
        <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="0">
          <tr class="textobold">
            <td width="92" align="right"><div align="left">Aprovado por:</div></td>
            <td width="200" colspan="-1"><input name="quem1" type="text" class="formulario" id="quem2" value="<?php echo  $res["quem"]; ?>" size="40" ></td>
            <td width="23" colspan="-1" align="center"><div align="left">Data:</div></td>
            <td width="60" colspan="-1"><input name="dtquem" type="text" class="formulario" id="dtquem3" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dtquem"]); ?>" size="12" maxlength="10"></td>
			<?php 
		 		  if(empty($res["quem"])){
				  	$javas="if(confirm('Deseja Aprovar Ensaio material?')){form1.acao.value='alt';form1.submit();}else{ return false; }";
					$javalimp="window.alert('O Ensaio Material não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
				  $javas="window.alert('O Ensaio Material já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				  ?>
            <td width="133" colspan="-1"><div align="center">
                <input name="ap" type="submit" class="microtxt" id="ap2" value="aprovar" onClick="<?php echo  $javas; ?>" <?php if($user=="N"){?>disabled<?php } ?>>
&nbsp;
        <input name="lap" type="submit" class="microtxt" id="lap2" value="limpar" onClick="<?php echo  $javalimp;?>" <?php if($user=="N"){?>disabled<?php } ?>>
            </div></td>
            </tr>
          <tr class="textobold">
            <td align="right"><div align="left">Representante do cliente:</div></td>
            <td colspan="-1"><input name="rep" type="text" class="formulario" id="rep2" value="<?php echo  $res["rep"]; ?>" size="40" maxlength="50"></td>
            <td colspan="-1" align="center"><div align="left">Data:</div></td>
            <td colspan="-1"><input name="dtrep" type="text" class="formulario" id="dtrep2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["dtrep"]); ?>" size="12" maxlength="10"></td>
            <td width="133" colspan="-1">
		      <div align="left">
		 <?php 
		  if(empty($res["rep"])){
				if($resv["status"]>1){
					$javas2="if(confirm('Deseja Aprovar Ensaio Dimensional?')){ if(confirm('Caso aprove, não será possível remover a aprovação. Tem certeza que deseja aprovar?')){ form1.acao.value='alt';form1.submit();}}else{ return false; }";
				}else{
					$javas2="return false;";
				}
			}else{
					$javas2="return false;";
			}
		?>
		        &nbsp;&nbsp;&nbsp;
		        <input name="ap2" type="submit" class="microtxt" id="ap2" value="aprovar" onClick="<?php echo  $javas2; ?>" <?php if( ($user!="N")||(empty($res["quem"])) ){?> disabled <?php } ?>>
		      </div></td>
            </tr>
        </table><?php if($aprov=="N") print "<script>bloke();</script>"; ?></td>
      </tr>
      <tr>
        <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                <table width="601" border="0" align="center" cellpadding="3" cellspacing="0" class="texto">
                  <tr>
				  <?php if($_SESSION["e_mail"]=="S"){ ?>
                    <td width="16%" align="left" class="textobold">&nbsp;Enviar e-mail: </td>
                    <td width="56%"><input name="email" type="text" class="formularioselect" id="email3" value="Digite o e-mail aqui"></td> 
					<?php if(in_array("U",$emailt)){ ?>
                    <td width="3%"><div align="center"><a href="#" onClick="return abre('busca_email2.php','a','width=320,height=380,scrollbars=1');"><img src="imagens/icon14_pessoas.gif" alt="Buscar Email de Funcionários" width="14" height="14" border="0"></a></div></td>
					<?php } if(in_array("G",$emailt)){ ?>
                    <td width="8%"><div align="center"><a href="#" onClick="return abre('busca_email_grupo.php','a','width=320,height=380,scrollbars=1');"><input name="grupo" type="hidden" id="grupo">
                <input name="grupo_nome" type="hidden" id="grupo_nome"><img src="imagens/icon14_grupo.gif" alt="Buscar Grupo de Emails" width="26" height="13" border="0"></a></div></td>
				 <?php } if(in_array("C",$emailt)){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"></a><a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_cli.gif" alt="Buscar Emails de Clientes" width="18" height="18" border="0"></a></div></td>
				<?php } ?>
                    <td width="9%"><div align="center"><?php if($_SESSION["login_funcionario"]=="S"){ ?><a href="#" onClick="vailogo1('email','<?php echo  $pc; ?>');"><img src="imagens/icon14_mail.gif" alt="Enviar Email" width="16" height="10" border="0"></a><?php } ?></div></td>
					<?php } if($_SESSION["i_mp"]=="S"){ ?>
                    <td width="4%"><div align="center"><a href="#" onClick="vailogo('imp');"><img src="imagens/icon14_imp.gif" alt="Imprimir" width="15" height="15" border="0"></a></div></td>
					<?php } ?>
                  </tr>
                  <tr>
                    <td colspan="7" align="left" class="textobold"><img src="imagens/spacer.gif" width="46" height="5"></td>
                  </tr>
                </table>
			</td>
      </tr>
      <tr>
        <td align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">&nbsp;
          <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('material','<?php echo $res["id"];?>')">
&nbsp;
<input name="button12222" type="button" class="microtxt" value="Salvar" onClick="<?php echo  $btnsalva; ?>;">
&nbsp;
<input name="button12223" type="button" class="microtxt" value="Remover Linha" onClick="<?php echo  $btn_exc; ?>">
&nbsp;&nbsp;
<?php
$apqp->agenda_p("Ensaio Material","apqp_enma.php");
?>
<input name="acao" type="hidden" id="acao" value="alt">
<input name="id" type="hidden" id="id" value="<?php echo  $res["id"]; ?>">
<a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
<input name="local" type="hidden" id="local" value="material">
<input type="hidden" name="acum">
</a></td>
      </tr>
    </table>
      </td>
  </tr>
</form></table>
</body>
</html>
<script>
arop1=new Array;
arop2=new Array;
arop3=new Array;
arop4=new Array;
<?php echo  $montaray; ?>
</script>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>