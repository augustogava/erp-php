<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$linha=Input::request("linha");
$posicao=Input::request("posicao");
$selectop=Input::request("selectop");
$selop=Input::request("selop");
$ope=Input::request("ope");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
//Verificação
$_SESSION["modulo"]="fluxo";
$sqlm=mysql_query("SELECT * FROM online WHERE user<>'$iduser' and peca='$pc' and modulo='fluxo'");
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
$ops=mysql_query("SELECT * FROM apqp_op WHERE peca='$pc' ORDER BY numero ASC");

$sql=mysql_query("SELECT * FROM apqp_fluxo WHERE peca='$pc' ORDER BY ordem ASC");
$nume=mysql_num_rows($sql);
$reg=20-$nume;
$sql=mysql_query("SELECT MAX(ordem)as ordem FROM apqp_fluxo WHERE peca='$pc'");
$res=mysql_fetch_array($sql); $ord=$res["ordem"]+1;
$i=01;
while($i<=$reg){
	$sql2=mysql_query("INSERT INTO apqp_fluxo (peca,ordem) VALUES ('$pc','$ord')");
	$ord++;
	$i++;
}
$sql=mysql_query("SELECT * FROM apqp_fluxo WHERE peca='$pc' ORDER BY ordem ASC");
		$sql2=mysql_query("SELECT MAX(ordem) AS ordem FROM apqp_fluxo WHERE peca='$pc'");
		if(mysql_num_rows($sql2)){
			$res=mysql_fetch_array($sql2);
			$linha=$res["ordem"]+1;
		}else{
			$linha=1;
		}
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
		$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Diagrama de Fluxo'");
		if(!mysql_num_rows($sqlb)){
			$btnsalva="form1.acao.value='salvar'; form1.submit(); return false;";
			$btnsalva2="form1.acao.value='linha'; form1.submit(); return false;";
			$btnsalva3="if(form1.linha.value==''){ alert('Informe a linha a ser removida'); }else{ form1.acao.value='remover'; form1.submit(); } return false;";
		}else{
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
			if(mysql_num_rows($sqlb)){
				$btnsalva="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){ form1.acao.value='salvar'; form1.submit();  } return false;";
				$btnsalva2="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){ form1.acao.value='linha'; form1.submit();  } return false;";
				$btnsalva3="if (confirm('Caso queira editar este documento terá que revisar todos os documentos a frente e aprovalos novamente!?')){ if(form1.linha.value==''){ alert('Informe a linha a ser removida'); }else{ form1.acao.value='remover'; form1.submit(); } return false;  } return false;";
			}else{
				$btnsalva="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='salvar'; form1.submit();  } return false;";
				$btnsalva2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ form1.acao.value='linha'; form1.submit();  } return false;";
				$btnsalva3="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(form1.linha.value==''){ alert('Informe a linha a ser removida'); }else{ form1.acao.value='remover'; form1.submit(); } return false;  } return false;";
			}

		}
		$sqlfmea=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='FMEA de Processo'");
		if(!mysql_num_rows($sqlfmea)){
			$javalimp="if(confirm('Deseja remover a aprovação?')){ form1.submit(); } else{ return false; }";
		 } else {
			$javalimp="if(confirm('Deseja remover a aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')){ form1.submit(); }else{ return false; } } else { return false; }";
		}
	}else{
			$btnsalva="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='salvar'; form1.submit(); }else{ return false; } }else{ return false; }";
			$btnsalva2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='linha'; form1.submit(); }else{ return false; } }else{ return false; }";
			$btnsalva3="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ if(form1.linha.value==''){ alert('Informe a linha a ser removida'); }else{ form1.acao.value='remover'; form1.submit(); } return false; }else{ return false; } }else{ return false; }";
			$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.submit(); }else{ return false; } }else{ return false; }";

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
function mudaseta(num,pos){
	if(form1.linha.value!=''){
		document.all['seta'+form1.linha.value].src='imagens/op_.jpg';
		document.all['setaa'+form1.linha.value].src='imagens/op_.jpg';
	}
	document.all['seta'+num].src='imagens/op_seta.gif';
	document.all['setaa'+num].src='imagens/op_.jpg';
	form1.linha.value=num;
	form1.posicao.value=pos;
}
function mudaseta2(num,pos){
	if(form1.linha.value!=''){
		document.all['setaa'+form1.linha.value].src='imagens/op_.jpg';
		document.all['seta'+form1.linha.value].src='imagens/op_.jpg';
	}
	document.all['setaa'+num].src='imagens/op_seta.gif';
	document.all['seta'+num].src='imagens/op_.jpg';
	form1.linha.value=num;
	form1.posicao.value=pos;
}
function seta(num,tipo){
	if(form1.linha.value=='' || form1.posicao.value==''){
		alert('Selecione um campo para modificá-lo');
	}else{
		if(tipo==1){
			tipo='s';
			if((form1.posicao.value==1 && form1.all['i2'+form1.linha.value].value.substr(0,3)!='op_') || (form1.posicao.value==2 && form1.all['i1'+form1.linha.value].value.substr(0,3)!='op_')){
				form1.all['t1'+form1.linha.value].value='';
				form1.all['t2'+form1.linha.value].value='';
				form1.all['t3'+form1.linha.value].value='';
				form1.all['op'+form1.linha.value].value='0';
			}
		}else{
			tipo='op_';
			if(num==0){
				alert('Selecione uma operação');
				return false;
			}
			form1.all['t1'+form1.linha.value].value=arop1[num];
			form1.all['t2'+form1.linha.value].value=arop2[num];
			form1.all['t3'+form1.linha.value].value=arop3[num];
			form1.all['op'+form1.linha.value].value=num;
			num=arop4[num];
			if(form1.posicao.value==1 && form1.all['i2'+form1.linha.value].value.substr(0,3)=='op_'){
				form1.all['i2'+form1.linha.value].value='0';
				document.all['img2'+form1.linha.value].src='imagens/op_.jpg';
			}else if(form1.posicao.value==2 && form1.all['i1'+form1.linha.value].value.substr(0,3)=='op_'){
				form1.all['i1'+form1.linha.value].value='0';
				document.all['img1'+form1.linha.value].src='imagens/op_.jpg';			
			}
		}
		document.all['img'+form1.posicao.value+form1.linha.value].src='imagens/'+tipo+num+'.jpg';
		form1.all['i'+form1.posicao.value+form1.linha.value].value=tipo+num;
	}
	return false;
}
function mselop(){
	if(form1.selectop[form1.selectop.selectedIndex].value==0){
		form1.selop.value='';
		document.imgop.src='imagens/apqp_setas2.gif';
	}else{
		form1.selop.value=form1.selectop[form1.selectop.selectedIndex].value;
		document.imgop.src='imagens/op_'+arop4[form1.selop.value]+'.jpg';
	}
	seta(form1.selectop[form1.selectop.selectedIndex].value,2);
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
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
     <tr>
      <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_diagrama_fluxo.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Diagrama de Fluxo de Dados'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Para preencher o Diagrama de Fluxo, as operações devem ter sido previamente registradas no Cadastro de Operações.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
      <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1">APQP - Diagrama de Fluxo <?php print $npc; ?></div></td>
    </tr>
    <tr>
     <td align="center">&nbsp;</td>
     <td align="right">&nbsp;</td>
   </tr>
</table>
<form name="form1" method="post" action="apqp_fluxo_sql.php">
<table width="100%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0">
      <td align="center">
        <tr>
          <td width="1029" align="center" valign="top"><div align="left"></div>
          <table width="593" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="3"><img src="imagens/dot.gif" width="20" height="8"></td>
              </tr>
              <tr>
                <td width="323"><img src="imagens/apqp_setas.gif" width="323" height="30" border="0" usemap="#MapMap"></td>
                <td width="30"><a href="#" onClick="return seta(selectop[selectop.selectedIndex].value,2);"><img src="imagens/apqp_setas2.gif" name="imgop" width="30" height="30" border="0" id="imgop"></a></td>
                <td width="0"><select name="selectop" class="formularioselect" id="selectop" onChange="mselop();">
                    <option value="0">Selecione uma opera&ccedil;&atilde;o</option>
                    <?php
if(mysql_num_rows($ops)){
	while($rops=mysql_fetch_array($ops)){
		$montaray.="arop1[".$rops["id"]."]='".htmlspecialchars($rops["numero"], ENT_QUOTES)."';\n";
		$montaray.="arop2[".$rops["id"]."]='".htmlspecialchars($rops["descricao"], ENT_QUOTES)."';\n";
		$montaray.="arop3[".$rops["id"]."]='".htmlspecialchars($rops["obs"], ENT_QUOTES)."';\n";
		$montaray.="arop4[".$rops["id"]."]='".$rops["tipo"]."';\n";
?>
                    <option value="<?php echo  $rops["id"]; ?>">
                    <?php echo  htmlspecialchars($rops["numero"], ENT_QUOTES); ?>
                -
                <?php echo  htmlspecialchars($rops["descricao"], ENT_QUOTES); ?>
                    </option>
                    <?php
	}
}
?>
                </select></td>
              </tr>
              <tr>
                <td colspan="3"><img src="imagens/dot.gif" width="20" height="3"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="top"><?php
if(mysql_num_rows($sql)){
?>
              <table width="100%"  border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
                <tr bgcolor="#004993" class="textoboldbranco">
                  <td colspan="4" align="center">Fluxo</td>
                  <td width="81" align="center" bordercolor="#FFFFFF">OP N&ordm; </td>
                  <td width="379" align="center" bordercolor="#FFFFFF">Descri&ccedil;&atilde;o da Opera&ccedil;&atilde;o </td>
                  <td width="364" align="center" bordercolor="#FFFFFF">Observa&ccedil;&otilde;es</td>
                </tr>
                <?php
	while($res=mysql_fetch_array($sql)){
		unset($resop);
		if($res["op"]){
			$sqlop=mysql_query("SELECT * FROM apqp_op WHERE id='".$res["op"]."'");
			if(mysql_num_rows($sqlop)){
				$resop=mysql_fetch_array($sqlop);
			}
		}
		if(empty($res["fluxo1"])) $res["fluxo1"]="op_";
		if(empty($res["fluxo2"])) $res["fluxo2"]="op_";
?>
                <tr bgcolor="#FFFFFF">
                  <td width="27" align="center" valign="middle"><img src="imagens/op_.jpg" name="seta<?php echo  $res["id"]; ?>" width="16" height="15" id="seta<?php echo  $res["id"]; ?>"></td>
                  <td width="54" align="center" valign="middle"><a href="#" onClick="mudaseta(<?php echo  $res["id"]; ?>,1); return false;"><img src="imagens/<?php echo  $res["fluxo1"]; ?>.jpg" name="img1<?php echo  $res["id"]; ?>" border="0" id="img1<?php echo  $res["id"]; ?>"></a></td>
                  <td width="30" align="center" valign="middle"><img src="imagens/op_.jpg" name="setaa<?php echo  $res["id"]; ?>" width="16" height="15" id="setaa<?php echo  $res["id"]; ?>"></td>
                  <td width="54" align="center" valign="middle"><a href="#" onClick="mudaseta2(<?php echo  $res["id"]; ?>,2); return false;"><img src="imagens/<?php echo  $res["fluxo2"]; ?>.jpg" name="img2<?php echo  $res["id"]; ?>" border="0" id="img2<?php echo  $res["id"]; ?>"></a></td>
                  <td><input name="t1<?php echo  $res["id"]; ?>" type="text" class="formularioselectsemborda" id="t1<?php echo  $res["id"]; ?>" value="<?php echo  $resop["numero"]; ?>" size="1" readonly=""></td>
                  <td width="379"><input name="t2<?php echo  $res["id"]; ?>" type="text" class="formularioselectsemborda" id="t2<?php echo  $res["id"]; ?>" value="<?php echo  $resop["descricao"]; ?>" size="1" readonly=""></td>
                  <td><input name="t3<?php echo  $res["id"]; ?>" type="text" class="formularioselectsemborda" id="t3<?php echo  $res["id"]; ?>" value="<?php echo  $resop["obs"]; ?>" size="1" readonly=""></td>
                  <input name="op[<?php echo  $res["id"]; ?>]" type="hidden" id="op<?php echo  $res["id"]; ?>" value="<?php echo  $res["op"]; ?>">
                  <input name="i1[<?php echo  $res["id"]; ?>]" type="hidden" id="i1<?php echo  $res["id"]; ?>" value="<?php echo  $res["fluxo1"]; ?>">
                  <input name="i2[<?php echo  $res["id"]; ?>]" type="hidden" id="i2<?php echo  $res["id"]; ?>" value="<?php echo  $res["fluxo2"]; ?>">
                </tr>
                <?php
	}
?>
              </table>
              <?php
}
?>
          </td>
        </tr>
      
    </table>
      <map name="MapMap">
        <area shape="rect" coords="4,3,27,27" href="#" onClick="return seta(1,1);">
        <area shape="rect" coords="28,3,53,27" href="#" onClick="return seta(2,1);">
        <area shape="rect" coords="54,3,78,27" href="#" onClick="return seta(3,1);">
        <area shape="rect" coords="79,3,105,27" href="#" onClick="return seta(4,1);">
        <area shape="rect" coords="106,3,131,27" href="#" onClick="return seta(5,1);">
        <area shape="rect" coords="132,3,158,27" href="#" onClick="return seta(6,1);">
        <area shape="rect" coords="159,3,184,27" href="#" onClick="return seta(7,1);">
        <area shape="rect" coords="185,3,211,27" href="#" onClick="return seta(8,1);">
        <area shape="rect" coords="212,3,238,27" href="#" onClick="return seta(9,1);">
        <area shape="rect" coords="239,3,264,27" href="#" onClick="return seta(10,1);">
        <area shape="rect" coords="265,3,291,27" href="#" onClick="return seta(11,1);">
        <area shape="rect" coords="292,3,317,27" href="#" onClick="return seta(12,1);">
      </map></td>
  </tr>
</table>
<br>
<table width="600" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#999999" bgcolor="#999999">
  <tr>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><table width="590" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td width="85"><span class="textobold"> Aprovado por:</span></td>
          <td width="363"><span class="textobold">
            <?php  $sel=mysql_query("SELECT * FROM apqp_cron WHERE peca='$pc' AND ativ='Diagrama de Fluxo'"); $sele=mysql_fetch_array($sel); if(!empty($sele["resp"])){  $quem=$sele["resp"]; }else{ } ?>
            <input name="quem1" type="text" class="formularioselect" id="quem2" value="<?php echo  $quem; ?>">
          </span></td>
          <td width="124"><div align="center">
		   <?php 
				  if(empty($sele["resp"])){
				  	$javas="if(confirm('Deseja Aprovar Diagrama de Fluxo?')){form1.submit();}else{ return false; }";
					$javalimp="window.alert('O Estudo Diagrama de Fluxo não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  }else{
				  $javas="window.alert('O Diagrama de Fluxo já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
				  }
				  ?>
		   <input name="ap" type="submit" class="microtxt" id="ap" value="aprovar" onClick="<?php echo  $javas; ?>">
		   &nbsp;
              <input name="lap" type="submit" class="microtxt" id="lap" value="limpar" onClick="<?php echo  $javalimp;?>">
          </div></td>
        </tr>
      </table>
	   <?php if($aprov=="N") print "<script>bloke();</script>"; ?>
        
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
			
        <a href="#" onClick="return abre('busca_email.php','a','width=320,height=380,scrollbars=1');"><span class="textobold">
        
        </span></a>
        <table width="100%"  border="0" cellspacing="0" cellpadding="6">
          <tr>
            <td><div align="center">
                <input name="button122" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_menu.php';">
&nbsp;
              <input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('fluxo','<?php echo $res["id"];?>')">
&nbsp;
              <input name="button1223" type="button" class="microtxt" value="Salvar Altera&ccedil;oes" onClick="<?php echo  $btnsalva; ?>">
&nbsp;
              <input name="button12232" type="button" class="microtxt" value="Adicionar Linha" onClick="<?php echo  $btnsalva2; ?>">
&nbsp;
              <input name="button122322" type="button" class="microtxt" value="Remover Linha" onClick="<?php echo  $btnsalva3; ?>">
			  &nbsp;&nbsp;
<?php
$apqp->agenda_p("Diagrama de Fluxo","apqp_fluxo.php");
?>
              <input name="linha" type="hidden" id="linha">
              <input name="posicao" type="hidden" id="posicao">
              <input name="acao" type="hidden" id="1">
              <input name="selop" type="hidden" id="selop">
              <input name="local" type="hidden" id="local" value="fluxo">
            </div></td>
          </tr>
      </table></form></td>
  </tr>
</table>
<p>
  <map name="Map">
    <area shape="rect" coords="4,3,27,27" href="#" onClick="return seta(1,1);">
    <area shape="rect" coords="28,3,53,27" href="#" onClick="return seta(2,1);">
    <area shape="rect" coords="54,3,78,27" href="#" onClick="return seta(3,1);">
    <area shape="rect" coords="79,3,105,27" href="#" onClick="return seta(4,1);">
    <area shape="rect" coords="106,3,131,27" href="#" onClick="return seta(5,1);">
    <area shape="rect" coords="132,3,158,27" href="#" onClick="return seta(6,1);">
    <area shape="rect" coords="159,3,184,27" href="#" onClick="return seta(7,1);">
    <area shape="rect" coords="185,3,211,27" href="#" onClick="return seta(8,1);">
    <area shape="rect" coords="212,3,238,27" href="#" onClick="return seta(9,1);">
    <area shape="rect" coords="239,3,264,27" href="#" onClick="return seta(10,1);">
    <area shape="rect" coords="265,3,291,27" href="#" onClick="return seta(11,1);">
    <area shape="rect" coords="292,3,317,27" href="#" onClick="return seta(12,1);">
  </map>
</p>
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