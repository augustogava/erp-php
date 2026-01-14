<?
include("conecta.php");
include("seguranca.php");
$apqp=new set_apqp;
if(empty($acao)) $acao="entrar";
$pc=$_SESSION["mpc"];
$npc=$_SESSION["npc"];
$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car'");
if(mysql_num_rows($sqlc)) $resc=mysql_fetch_array($sqlc);
$sql=mysql_query("SELECT * FROM apqp_rr WHERE peca='$pc' AND car='$car'");
if(mysql_num_rows($sql)){
	$res=mysql_fetch_array($sql);
}else{
	$sql=mysql_query("INSERT INTO apqp_rr (peca,car) VALUES ('$pc','$car')");
	$sql=mysql_query("SELECT MAX(id) AS id FROM apqp_rr");
	$res=mysql_fetch_array($sql);
}
$id=$res["id"];
	$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Certificado de Submissão'");
	if(!mysql_num_rows($sqlb)){
			$sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
			if(mysql_num_rows($sqlb)){
				$sqlcert=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de Capabilidade'");
				if(mysql_num_rows($sqlcert)){
					$javalimp="if(confirm('Deseja Remover a Aprovação?')){ if(confirm('Caso queira remover a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; }";
					$javalimp2="if(confirm('Deseja Rejeitar a Aprovação?')){ if(confirm('Caso queira rejeitar a aprovação, terá que revisar todos os documentos a frente e aprová-los novamente.')) { form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; }";
		
				}else{
					$javalimp="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; } ";
					$javalimp2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; } ";
				}
			}else{
				$sqlc=mysql_query("SELECT * FROM apqp_car WHERE id='$car' AND quem<>''");
				if(mysql_num_rows($sqlc)){
					$javalimp="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; }";
					$javalimp2="if (confirm('Documento Aprovado! Caso queira alterá-lo será removida a aprovação')){ if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; }";
				}else{
					$javalimp="if(confirm('Deseja Remover a Aprovação?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; }";
					$javalimp2="if(confirm('Deseja Rejeitar a Aprovação?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; }";
				}
			}
		
	}else{
		$javalimp="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; }";
		$javalimp2="if(confirm('O Certificado de submissão já esta aprovado, caso queira remover a aprovação deste Estudo será removida a aprovação de todos os relatórios. Deseja remover?')){ if(confirm('Você tem certeza que deseja remover a aprovação? Terá que aprovar todos os relatórios novamente.')){ form1.acao.value='rr3';form1.submit(); }else{ return false; } }else{ return false; }";


	}
	
if(empty($resc["tol"])){ 
	print "<script>window.alert('Essa característica não possui LIE e LSE preenchidos!')</script>";
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
	document.all.form1.lap2.disabled=true;	
		document.all.form1.rep.disabled=true;	
	document.all.form1.lap.disabled=true;	
}
function vailogo1(type,peca){
	window.open('apqp_imp_email.php?acao='+type+'&local='+form1.local.value+'&email='+form1.email.value+'&pc='+peca,'busca','width=430,height=140,scrollbars=1');
}
function vailogo(type){
	form1.acao.value=type;
	form1.submit();
	return true
}
function abrir(url,id){
	window.location='pdf/'+url+'.php?id='+id+'';
	return true;
}
function salvar(url,id){
	window.open('apqp_impressao.php?acao=salvar&local='+ url +'&pc='+ <?=$pc?> +'&car='+ form1.car.value +'');
	return true;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 16px}
.style2 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="623" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="623" align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_rr.html','','width=680,height=501,left=300,top=50')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de R&R - Resultados'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('O Sistema PAPP calcula os valores de Repetitividade, Reprodutibilidade, R&R, Variação da Peça e Variação Total, indicando também qual a colaboração (%) de cada uma destas variações no processo.')"></a></div></td>
        <td width="563" align="right"><div align="left" class="textobold style2">APQP - Estudo de R&amp;R <? print $npc; ?></div></td>
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
        <a href="apqp_rr2.php?car=<?= $car; ?>">
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="textobold" onMouseOver="this.style.backgroundColor='#006699';this.style.color='#FFFFFF';" onMouseOut="this.style.backgroundColor='#FFFFFF';this.style.color='#003366';">estudo</td>
		</a>
		<td width="100" align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">resultados</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <form name="form1" method="post" action="apqp_rr_sql.php"><td bgcolor="#FFFFFF">
          <table width="578" border="0" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="6"><table width="595" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
                <tr>
                  <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                      <tr bgcolor="#003366" class="textoboldbranco">
                        <td colspan="2">&nbsp;An&aacute;lise do Dispositivo de Medi&ccedil;&atilde;o </td>
                        <td width="54" align="center"><input name="lugar" type="radio" value="<?= $res["prr"]; ?>" onClick="window.location='apqp_rr3.php?calcv=<?= $res["prr"]; ?>&car=<?= $car; ?>&ck=1';" <? if($ck=="1") print "checked"; ?>>
                          % VT </td>
                        <td width="50" align="center"> <input name="lugar" type="radio" onClick="window.location='apqp_rr3.php?calcv=<?= @($res["rr"]/$resc["tol"])*10; ?>&car=<?= $car; ?>&ck=2';" <? if($ck=="2" or empty($ck)) print "checked"; ?>>
                          %  T. </td>
                        <td width="230" bgcolor="#004996"></td>
                      </tr>
                      <tr>
                        <td width="194" align="right" class="textobold">Varia&ccedil;&atilde;o do Equipamento (VE)&nbsp; </td>
                        <td width="35"><input name="textfield" type="text" class="formularioselect" value="<?= banco2valor3($res["ev"]); ?>" size="2" readonly=""></td>
                        <td><input name="textfield6" type="text" class="formularioselect" value="<?= banco2valor3($res["pev"]); ?>" size="2" readonly=""></td>
                        <td class="texto"><input name="textfield62" type="text" class="formularioselect" value="<?= banco2valor3(@($res["ev"]/$resc["tol"])*100); ?>" size="2" readonly=""></td>
                        <td class="texto">&nbsp;
                          <? if(@(($res["ev"]/$resc["tol"])*10)>20){ ?>
                          <font color="#FF0000">A varia&ccedil;&atilde;o do equipamento est&aacute; muito alta</font>
                          <? }else{ ?>
                          OK
                          <? } ?></td>
                      </tr>
                      <tr>
                        <td align="right" class="textobold">Varia&ccedil;&atilde;o entre Operadores (VO)&nbsp; </td>
                        <td><input name="textfield2" type="text" class="formularioselect" value="<?= banco2valor3($res["ov"]); ?>" size="2" readonly=""></td>
                        <td><input name="textfield22" type="text" class="formularioselect" value="<?= banco2valor3($res["pov"]); ?>" size="2" readonly=""></td>
                        <td class="texto"><input name="textfield622" type="text" class="formularioselect" value="<?= banco2valor3(@($res["ov"]/$resc["tol"])*100); ?>" size="2" readonly=""></td>
                        <td class="texto">&nbsp;
                          <? if($res["pov"]>20){ ?>
                          <font color="#FF0000">A varia&ccedil;&atilde;o do operador est&aacute; muito alta</font>
                          <? }else{ ?>
                          OK
                          <? } ?></td>
                      </tr>
                      <tr>
                        <td align="right" class="textobold">Repetitividade &amp; Reprodutibilidade (R&amp;R)&nbsp; </td>
                        <td><input name="textfield3" type="text" class="formularioselect" value="<?= banco2valor3($res["rr"]); ?>" size="2" readonly=""></td>
                        <td><input name="textfield32" type="text" class="formularioselect" value="<?= banco2valor3($res["prr"]); ?>" size="2" readonly=""></td>
                        <td class="texto"><input name="textfield623" type="text" class="formularioselect" value="<?= $tolera=banco2valor3(@($res["rr"]/$resc["tol"])*100); ?>" size="2" readonly=""></td>
                        <td class="texto">&nbsp;
                          <? if($res["prr"]>30){ ?>
                          <font color="#FF0000">R&amp;R necessita de melhoramentos</font>
                          <? }else{ ?>
                          OK
                          <? } ?></td>
                      </tr>
                      <tr>
                        <td align="right" class="textobold">Varia&ccedil;&atilde;o entre Pe&ccedil;as (VP)&nbsp; </td>
                        <td><input name="textfield4" type="text" class="formularioselect" value="<?= banco2valor3($res["pv"]); ?>" size="2" readonly=""></td>
                        <td><input name="textfield42" type="text" class="formularioselect" value="<?= banco2valor3($res["ppv"]); ?>" size="2" readonly=""></td>
                        <td class="texto">&nbsp;</td>
                        <td class="texto">&nbsp;                          <? if($res["ppv"]<90){ ?>
                          <font color="#FF0000">VP precisa ser maior do que 90%</font>
                          <? }else{ ?>
                          OK
                          <? } ?></td>
                      </tr>
                      <tr>
                        <td align="right" class="textobold">Varia&ccedil;&atilde;o Total (VT)&nbsp; </td>
                        <td><input name="textfield5" type="text" class="formularioselect" value="<?= banco2valor3($res["tv"]); ?>" size="2" readonly=""></td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr align="center" bgcolor="#003366">
                        <td colspan="5" class="textoboldbranco">M&eacute;todo de An&aacute;lise: Toler&acirc;ncia </td>
                        </tr>
                      <tr align="center">
                        <td colspan="5" class="textobold"><span class="style1"><? 
if(empty($calcv)){ $calcv=str_replace(",",".",$tolera); }
if($calcv<"10"){ 
	print "R&R Abaixo de 10% - Sistema de medição Aceitável"; 
}else if(($calcv>"10") and ($calcv<"30")){ 
	print "R&R entre 10% e 30% - Sistema de medição pode ser aceitável baseado na importância da aplicação, custo do dispositivo de medição, custo dos reparos, etc."; 
}else if($calcv>30){ 
	print "R&R acima de 30% - Sistema de medição precisa de melhorias. Faça todos os esforços para identificar os problemas e corrigí-los"; 
} 
?>
</span></td>
                        </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="6"><img src="imagens/dot.gif" width="20" height="8"></td>
              </tr>
            <tr>
              <td colspan="6" align="center" bgcolor="#003366" class="textoboldbranco">M&eacute;dias</td>
            </tr>
            <tr>
              <td colspan="6" align="center"><img src="apqp_rr_xbar.php?id=<?= $res["id"]; ?>"></td>
            </tr>
            <tr>
              <td colspan="6" align="center" class="texto"><span class="textobold">% Fora dos Limites de Controle:&nbsp;
                <?= $res["mpf"]; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; X:</span>&nbsp;<?= banco2valor3($res["average"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="textobold">LICX:</span>&nbsp;
                <?= banco2valor3($res["lcl"]); ?>                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="textobold">LSCX</span>:&nbsp;
                <?= banco2valor3($res["uclx"]); ?></td>
            </tr>
            <tr>
              <td colspan="6" align="center"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="6" align="center" bgcolor="#003366" class="textoboldbranco">Amplitudes</td>
            </tr>
            <tr>
              <td colspan="6" align="center"><img src="apqp_rr_rbar.php?id=<?= $res["id"]; ?>"></td>
            </tr>
            <tr align="left">
              <td colspan="6" class="texto"><span class="textobold">Pontos fora dos limites de controle:&nbsp;                <?= $res["apf"]; ?> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R:</span>&nbsp;
                  <?= banco2valor3($res["rbar"]); ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>LICR: 0,0000&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>&nbsp;<span class="textobold">LSCR</span>:&nbsp;
    <?= banco2valor3($res["uclr"]); ?></td>
            </tr>
            <tr>
              <td colspan="6"><img src="imagens/spacer.gif" width="46" height="5"></td>
            </tr>
            <tr>
              <td colspan="6"><table width="578" border="0" align="center" cellpadding="3" cellspacing="0">
				  
                <tr bgcolor="#003366" class="textoboldbranco">
                  <td align="center">Disposi&ccedil;&atilde;o</td>
                  <td align="center">Respons&aacute;vel</td>
                  <td align="center">Data</td>
                  <td align="center">a&ccedil;&otilde;es</td>
                </tr>
                <tr>
                 
                  <td width="86" align="center" class="textobold"><input name="tap1" type="text" class="formularioselect" id="tap15" value="<? if($res["sit"]==0){ print "pendente"; }elseif($res["sit"]==1){ print "aprovado"; }else{ print "reprovado"; } ?>" size="1"></td>
                  <td width="205" align="center"><span class="textobold">
                    <input name="tap123" type="text" class="formularioselect" id="tap123" value="<?= $resc["quem"]; ?>">
                  </span></td>
                  <td width="54" align="center" class="textobold"><input name="dap1" type="text" class="formularioselect" id="dap12" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?= banco2data($resc["dtquem"]); ?>" size="7" maxlength="10"></td>
				   <? 
				  if($res["sit"]==2){
						$javas="window.alert('O Estudo de R&R está reprovado, se deseja aprovar, clique em Limpar primeiro.');return false;";
						$javalimp2="window.alert('O Estudo de R&R já está reprovado!'); return false;";
				  }else{
				  	  if(empty($resc["quem"])){
				  		$javas="if(confirm('Deseja Aprovar essa Pe&ccedil;a?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; }";
						$javalimp="window.alert('O Estudo de R&R não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  	}else{
				  		$javas="window.alert('O Estudo de R&R já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
					  }
				  }
				  ?>
                   <td width="209" align="center"><input name="lap2" type="submit" class="microtxt" id="lap2" value="Aprovar" onClick="<?= $javas; ?>">
                    &nbsp;
					<input name="rep" type="submit" class="microtxt" id="rep" value="Rejeitar" onClick="<?= $javalimp2; ?>">
                    &nbsp;
					<input name="lpt" type="submit" class="microtxt" id="lpt" value="Limpar" onClick="<?= $javalimp; ?>"></td>
				</tr>
				 <? 
				   $sqlb=mysql_query("SELECT * FROM apqp_cron WHERE perc='100' AND peca='$pc' AND ativ='Estudos de R&R'");
				   $resb=mysql_fetch_array($sqlb);
				  if($resb["resp"]){
						$javas2="window.alert('O Estudo de R&R está reprovado, se deseja aprovar, clique em Limpar primeiro.');return false;";
						$limpa2="form1.acao.value='rr3';form1.submit();";
				  }else{
				  	  if(empty($res["quem"])){
				  		$javas2="if(confirm('Deseja Aprovar essa Pe&ccedil;a?')){ form1.acao.value='rr3';form1.submit(); }else{ return false; }";
						$limpa2="window.alert('O Estudo de R&R não foi aprovado ainda, se deseja aprovar, clique em Aprovar.');return false;";
				  	}else{
				  		$javas2="window.alert('O Estudo de R&R já foi aprovado, caso deseje retirar a aprovação, clique no botão limpar.');return false;";
					  }
				  }
				  ?>
                <tr>
                  <td align="center" class="textobold">Aprova&ccedil;&atilde;o R&amp;R </td>
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
              <td width="83"><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="209"><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="68"><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="34"><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="85"><img src="imagens/dot.gif" width="20" height="8"></td>
              <td width="63"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td colspan="6" align="center">
                <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='apqp_rr.php';">
&nbsp;
				<input name="acao2" type="button" class="microtxt" value="Salvar em Disco" onClick="salvar('rr','<?=$res["id"];?>')">
&nbsp;&nbsp;
<?
$apqp->agenda_p("Estudos de RR","apqp_rr3.php");
?>
                <input name="car" type="hidden" id="car" value="<?= $car; ?>">
                <input name="acao" type="hidden" id="acao" value="1">
                <input name="id" type="hidden" id="id" value="<?= $res["id"]; ?>">
                <a href="#" onClick="return abre('busca_email.php','a','width=320,height=300,scrollbars=1');">
                <input name="local" type="hidden" id="local" value="rr">
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