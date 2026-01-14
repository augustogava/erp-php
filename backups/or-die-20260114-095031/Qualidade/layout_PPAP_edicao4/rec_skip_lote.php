<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Recebimento - Skip Lote";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
	if(!empty($forne)){
		$busca.="WHERE fantasia LIKE '%$forne%'";
	}

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM skip_lote WHERE id='$id'") or die("Nao selecionou");
	$res=mysql_fetch_array($sql);
	$sql2=mysql_query("SELECT nome FROM fornecedores WHERE id='$res[fornecedor]'");
	$res2=mysql_fetch_array($sql2);
	$sqlitem=mysql_query("SELECT descr FROM rec_plac WHERE id='$res[item]'");
	$resitem=mysql_fetch_array($sqlitem);
	$fornecedor=$res2["nome"];
	$item=$resitem["descr"];
	$sit=$res["sit"];	
	$skip_lote=$res["skip_lote"];
	$tempo_limite=$res["tempo_limite"];
	$ref_forn=$res["ref_forn"];
	$papp=$res["papp"];
	$data2=banco2data($res["data"]);
	$validade=banco2data($res["validade"]);
	$status=$res["status"];	
	$atualiza=$res["atualiza"];
	$notifica=$res["notifica"];
	$norma=$res["norma"];
	$plano=$res["plano"];
	$nivel=$res["nivel"];
	$nqa=$res["nqa"];
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
function verifica(cad){
	if(cad.fornecedor.value==''){
		alert('Busque o Fornecedor');
		cad.fornecedor.focus();
		return false;
	}
	if(cad.item.value==''){
		alert('Busque o Ítem');
		cad.item.focus();
		return false;
	}
	if(cad.sit.value==0){
		alert('Selecione a Situação');
		cad.sit.focus();
		return false;
	}
	if(cad.skip_lote.value==0){
		alert('Selecione o Skip Lote');
		cad.skip_lote.focus();
		return false;
	}
	if(cad.tempo_limite.value==''){
		alert('Digite o Tempo Limite');
		cad.tempo_limite.focus();
		return false;
	}
	if(cad.ref_forn.value==''){
		alert('Digite a Ref. Fornecedor');
		cad.ref_forn.focus();
		return false;
	}
	if(cad.papp.value==''){
		alert('Digite o Nº PAPP');
		cad.papp.focus();
		return false;
	}
	if(cad.data2.value==''){
		alert('Digite a Data');
		cad.data2.focus();
		return false;
	}
	if(cad.validade.value==''){
		alert('Digite a Validade');
		cad.validade.focus();
		return false;
	}
	if(cad.status.value==0){
		alert('Selecione o Status');
		cad.status.focus();
		return false;
	}
	if(cad.atualiza[0].checked==false && cad.atualiza[1].checked==false){
		alert('Selecione o Atualiza');
		cad.status.focus();
		return false;
	}
	if(cad.notifica[0].checked==false && cad.notifica[1].checked==false){
		alert('Selecione o Notifica');
		return false;
	}
	if(cad.norma.value==0){
		alert('Selecione a Norma');
		cad.norma.focus();
		return false;
	}
	if(cad.plano.value==0){
		alert('Selecione o Plano');
		cad.plano.focus();
		return false;
	}
	if(cad.nivel.value==0){
		alert('Selecione o Nível');
		cad.nivel.focus();
		return false;
	}
	if(cad.nqa.value==0){
		alert('Selecione o NQA');
		cad.nqa.focus();
		return false;
	}
	return true;
}

function callscreen(acao){
	if(form1.sit.value=="3" && form1.acao.value=="incluir"){
		window.open('rec_skip_lote_just.php','','scrollbars=no,width=385,height=180');		
	}
}

// elementos select associados
function changeselect(){
var skiplote_1=new Array("Controlar todas as entregas","Controla 1 a cada 2 entregas","Controla 1 a cada 3 entregas","Controla 1 a cada 4 entregas","Controla 1 a cada 5 entregas","Controla 1 a cada 7 entregas","Controla 1 a cada 10 entregas","Controla 1 a cada 15 entregas","Controla 1 a cada 20 entregas","Controla 1 a cada 30 entregas","Controla 1 a cada 40 entregas","Controla 1 a cada 50 entregas","Controla 1 a cada 60 entregas","Controla 1 a cada 70 entregas","Controla 1 a cada 80 entregas","Controla 1 a cada 90 entregas","Controla 1 a cada 100 entregas","Controla 1 entrega por dia","Controla 1 entrega por semana","Controla 1 entrega por mês","Controla 1 entrega por 2 meses","Controla 1 entrega por 3 meses","Controla 1 entrega por 4 meses","Controla 1 entrega por 5 meses","Controla 1 entrega por 6 meses","Controla 1 entrega por ano","Controla 1 CRM");
var skiplote_2=new Array("Controlar todas as entregas","Controla 1 a cada 2 entregas","Controla 1 a cada 3 entregas","Controla 1 a cada 4 entregas","Controla 1 CRM");
var skiplote_3=new Array("N/A");
var skiplote_4=new Array("N/A");

    var sit;
    sit = document.form1.sit[document.form1.sit.selectedIndex].value;
    if (sit != 0) { 
       meus_skiplote=eval("skiplote_" + sit); // se o valor do sit = 1 chama o array skiplote_1
       num_skiplote=meus_skiplote.length;
       document.form1.skip_lote.length = num_skiplote; // define quantos elementos o select terá
       for(i=0;i<num_skiplote;i++){ 
          document.form1.skip_lote.options[i].value=meus_skiplote[i]; // colocar variáveis para assumir os valores ao retornar ao php
          document.form1.skip_lote.options[i].text=meus_skiplote[i]; // e armazenar no banco.
       } 
    }else{ 
       document.form1.skip_lote.length = 1;
       document.form1.skip_lote.options[0].value = "-";
       document.form1.skip_lote.options[0].text = "-";
    } 
    document.form1.skip_lote.options[0].selected = true;
}
function changeselect2(){
	var norma = document.form1.norma[document.form1.norma.selectedIndex].value;
	if (norma==1){
		document.form1.plano.disabled=true;
		document.form1.nivel.disabled=true;
		document.form1.nqa.disabled=true;				
		document.form1.plano.value=0;
		document.form1.nivel.value=0;
		document.form1.nqa.value=0;				
	}else{
		document.form1.plano.disabled=false;
		document.form1.nivel.disabled=false;
		document.form1.nqa.disabled=false;					
	}
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
<table width="729" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="729" align="left" valign="top" class="chamadas"><table width="591" border="0" cellpadding="0" cellspacing="0" class="textopreto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="564" align="right"><div align="left"><span class="titulos">Recebimento &gt; Skip-Lote</span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
<?php
if($acao=="entrar"){
?>
  <tr>
    <td align="left" valign="top"><form name="formbus" method="post" action="" onSubmit="return verificabusca(this);">
      <table width="320" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td colspan="3" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
        </tr>
        <tr>
          <td width="84" class="textobold">&nbsp;Fornecedor:</td>
          <td width="175" class="textobold"><input name="forne" type="text" class="formularioselect" id="forne"></td>
          <td width="61" class="textobold"><div align="right"><img src="imagens/dot.gif" width="20" height="5">
              <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
              <input name="buscar" type="hidden" id="buscar5" value="true">
          </div></td>
        </tr>
        <tr>
          <td colspan="3" class="textobold">&nbsp;</td>
          </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="textobold"><a href="rec_skip_lote.php?acao=inc" class="textobold">Incluir um Skip Lote</a></td>
      </tr>
    </table>
    <table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
      <tr class="textoboldbranco">
        <td width="80" align="center">Skip Lote </td>
        <td width="451">&nbsp;Fornecedor</td>
        <td width="29" align="center">&nbsp;</td>
        <td width="29" align="center">&nbsp;</td>
      </tr>
<?php
$sql=mysql_query("SELECT * FROM skip_lote $busca ORDER BY id DESC");

if(!mysql_num_rows($sql)){
?>	  
      <tr bgcolor="#FFFFFF">
        <td colspan="4" align="center" class="textopretobold">NEHHUM SKIP LOTE ENCONTRADO</td>
        </tr>
<?php
}else{
				//BLOCO PAGINACAO
				$results_tot=mysql_num_rows($sql); //total de registros encontrados
				$maxpag=20; //numero maximo de resultados por pagina
				if($results_tot>$maxpag){
					$wpaginar=true;
					if(!isset($wp)){
						$param=0;
						$temp=0;
						$wp=0;
					}else{
						$temp = $wp;
	  					$passo1 = $temp - 1;
	  					$passo2 = $passo1*$maxpag;
	  					$param  = $passo2;				
					}
					$sqlskip=mysql_query("SELECT * FROM skip_lote $busca ORDER BY id ASC LIMIT $param, $maxpag") or die (					"SELECT * FROM skip_lote $busca ORDER BY id ASC LIMIT $param, $maxpag");
					$results_parc=mysql_num_rows($sqlskip);
					$result_div=$results_tot/$maxpag;
					$n_inteiro=(int)$result_div;
					if($n_inteiro<$result_div){
						$n_paginas=$n_inteiro+1;
					}else{
						$n_paginas=$result_div;
					}
					$pg_atual=$param/$maxpag+1;
					$reg_inicial=$param+1;
					$pg_anterior=$pg_atual-1;
					$pg_proxima=$pg_atual+1;
					$reg_final=$param;
				}
				// BLOCO PAGINACAO
	while($res=mysql_fetch_array($sql)){
		$sql2=mysql_query("SELECT fantasia FROM fornecedores WHERE id='$res[fornecedor]'");
		$res2=mysql_fetch_array($sql2);
?>
      <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td align="center"><?php echo  $res["id"]; ?></td>
        <td width="451">&nbsp;<?php echo  $res2["fantasia"]; ?></td>
        <td width="29" align="center"><a href="rec_skip_lote.php?acao=alt&id=<?php echo  $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
        <td width="29" align="center"><a href="#" onClick="pergunta('Deseja excluir este Skip Lote?','rec_skip_lote_sql.php?id=<?php echo  $res["id"]; ?>&acao=exc');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
      </tr>
<?php
	}
}
?>
    </table>
    <table width="82%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="center"><br>
          <?php if($wpaginar){ ?>
          <table width="1%" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td align="right"><?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                  <a href="<?php print "rec_skip_lote.php?wp=$pg_anterior&forne=$forne"; ?>" class="paginacao2">
                  <?php } ?>
                  <img src="imagens/pag_f.gif" width="27" height="14" border="0">
                  <?php if($antz){ ?>
                  <br>
                    Anterior</a>
                  <?php } ?>
              </td>
              <?php
				$link_impressos=0;
				if ($temp > $wpaginacao){
		    	    $n_start  = $temp - ceil($wpaginacao/2);
					$wpaginacao=$temp+ceil($wpaginacao/2);
		    	    if($n_start<0){
			    	    $n_start=0;
		    		}
		        	$link_impressos = $n_start;
				}
				while(($link_impressos<$n_paginas) and ($link_impressos<$wpaginacao)){
					$link_impressos++;
				?>
              <td align="center"><?php if($pg_atual != $link_impressos){ ?>
                  <a href="<?php print "rec_skip_lote.php?wp=$link_impressos&forne=$forne"; ?>" class="paginacao">
                  <?php } ?>
                  <img src="imagens/pag_e<?php if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
                  <?php if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
                  <?php if($pg_atual != $link_impressos){ ?>
                  </a>
                  <?php } ?>
              </td>
              <?php
				}
				?>
              <td><?php if($reg_final<$results_tot){ ?>
                  <a href="<?php print "rec_skip_lote.php?wp=$pg_proxima&forne=$forne"; ?>" class="paginacao2">
                  <?php } ?>
                  <img src="imagens/pag_der.gif" width="26" height="14" border="0">
                  <?php if($reg_final<$results_tot){ ?>
                  <br>
                    Pr&oacute;ximo</a>
                  <?php } ?>
              </td>
            </tr>
          </table>
          <?php } ?>
</div></td>
      </tr>
      <tr>
        <td><div align="center"><span class="textobold">
          <input name="Button2" type="button" class="microtxt" value="Voltar" onClick="window.location='mana_rece.php'">
        </span></div></td>
      </tr>
    </table></td>
  </tr>
<?php
}elseif($acao!="entrar"){
?>
<form name="form1" method="post" action="rec_skip_lote_sql.php?acao=$acao" onSubmit="return verifica(this);">
  <tr>
    <td align="center" valign="top"><table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <td><table width="90%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td align="left" valign="top" bgcolor="#003366" class="textoboldbranco">&nbsp;<?php if($acao=="alt"){ print "Alterar"; }else{ print "Incluir"; } ?>Skip lote </td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="719" border="0" cellspacing="0" cellpadding="0">
                <tr class="textobold">
                  <td width="160">Fornecedor</td>
                  <td width="5">&nbsp;</td>
                  <td width="110"><input name="idfornecedor" type="hidden" id="idfornecedor" value="<?php echo  $res["fornecedor"]; ?>"></td>
                  <td width="128">&nbsp;</td>
                  <td width="18">&nbsp;</td>
                  <td width="10">&nbsp;</td>
                  <td width="122">&nbsp;</td>
                  <td width="18">&nbsp;</td>
                  <td width="10">&nbsp;</td>
                  <td width="138">&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="4"><input name="fornecedor" type="text" class="formularioselect" id="fornecedor" value="<?php print $fornecedor; ?>" readonly></td>
                  <td><div align="center"><a href="#" onClick="return abre('rec_skip_lote_forn.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_pess.gif" width="14" height="14" border="0"></a></div></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center"><a href="#" onClick="return abre('rec_skip_lote_forn.php','a','width=320,height=300,scrollbars=1');"></a></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td class="textobold">&Iacute;tem</td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold"><input name="iditem" type="hidden" id="iditem" value="<?php echo  $res["item"]; ?>"></td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td colspan="4"><input name="item" type="text" class="formularioselect" id="item" value="<?php print $item; ?>" readonly></td>
                  <td><div align="center"><a href="#" onClick="return abre('rec_skip_lote_item.php','a','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" width="14" height="14" border="0"></a></div></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center"><a href="#" onClick="return abre('rec_skip_lote_forn.php','a','width=320,height=300,scrollbars=1');"></a></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td class="textobold">Situa&ccedil;&atilde;o</td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">Skip-Lote</td>
                  <td class="textobold"><input name="tipo" type="hidden" id="tipo"></td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">Tempo limite / meses </td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="textobold">Ref. Fornecedor </td>
                  </tr>
                <tr>
                  <td><select name="sit" class="formularioselect" id="sit" onChange="callscreen('$acao');changeselect();" >
                    <option value="0"<?php if($sit=="0"){ print"selected"; }?>>Selecione</option>
                    <option value="1"<?php if($sit=="1"){ print "selected";}?>>A - Assegurado</option>
                    <option value="2"<?php if($sit=="2"){ print "selected";}?>>B - Qualificado</option>
                    <option value="3"<?php if($sit=="3"){ print "selected";}?>>C - Pr&eacute;-Qualificado</option>
                    <option value="4"<?php if($sit=="4"){ print "selected";}?>>D - N&atilde;o Habilitado</option>
                  </select></td>
                  <td>&nbsp;</td><input name="tipo" type="hidden" value="">
                  <td colspan="2"><select name="skip_lote" class="formularioselect" id="skip_lote">
				  <?php if($sit=="1"){?>
                    <option value="Controlar todas as entregas"<?php if($skip_lote=="Controlar todas as entregas"){ print "selected";}?>>Controlar todas as entregas</option>
                    <option value="Controla 1 a cada 2 entregas"<?php if($skip_lote=="Controla 1 a cada 2 entregas"){ print "selected";}?>>Controla 1 a cada 2 entregas</option>
                    <option value="Controla 1 a cada 3 entregas"<?php if($skip_lote=="Controla 1 a cada 3 entregas"){ print "selected";}?>>Controla 1 a cada 3 entregas</option>
                    <option value="Controla 1 a cada 4 entregas"<?php if($skip_lote=="Controla 1 a cada 4 entregas"){ print "selected";}?>>Controla 1 a cada 4 entregas</option>                    
					<option value="Controla 1 a cada 5 entregas"<?php if($skip_lote=="Controla 1 a cada 5 entregas"){ print "selected";}?>>Controla 1 a cada 5 entregas</option>
                    <option value="Controla 1 a cada 7 entregas"<?php if($skip_lote=="Controla 1 a cada 7 entregas"){ print "selected";}?>>Controla 1 a cada 7 entregas</option>
                    <option value="Controla 1 a cada 10 entregas"<?php if($skip_lote=="Controla 1 a cada 10 entregas"){ print "selected";}?>>Controla 1 a cada 10 entregas</option>
                    <option value="Controla 1 a cada 15 entregas"<?php if($skip_lote=="Controla 1 a cada 15 entregas"){ print "selected";}?>>Controla 1 a cada 15 entregas</option>                    
					<option value="Controla 1 a cada 20 entregas"<?php if($skip_lote=="Controla 1 a cada 20 entregas"){ print "selected";}?>>Controla 1 a cada 20 entregas</option>
                    <option value="Controla 1 a cada 30 entregas"<?php if($skip_lote=="Controla 1 a cada 30 entregas"){ print "selected";}?>>Controla 1 a cada 30 entregas</option>
                    <option value="Controla 1 a cada 40 entregas"<?php if($skip_lote=="Controla 1 a cada 40 entregas"){ print "selected";}?>>Controla 1 a cada 40 entregas</option>
                    <option value="Controla 1 a cada 50 entregas"<?php if($skip_lote=="Controla 1 a cada 50 entregas"){ print "selected";}?>>Controla 1 a cada 50 entregas</option>
					<option value="Controla 1 a cada 60 entregas"<?php if($skip_lote=="Controla 1 a cada 60 entregas"){ print "selected";}?>>Controla 1 a cada 60 entregas</option>
                    <option value="Controla 1 a cada 70 entregas"<?php if($skip_lote=="Controla 1 a cada 70 entregas"){ print "selected";}?>>Controla 1 a cada 70 entregas</option>
                    <option value="Controla 1 a cada 80 entregas"<?php if($skip_lote=="Controla 1 a cada 80 entregas"){ print "selected";}?>>Controla 1 a cada 80 entregas</option>
                    <option value="Controla 1 a cada 90 entregas"<?php if($skip_lote=="Controla 1 a cada 90 entregas"){ print "selected";}?>>Controla 1 a cada 90 entregas</option>
					<option value="Controla 1 a cada 100 entregas"<?php if($skip_lote=="Controla 1 a cada 100 entregas"){ print "selected";}?>>Controla 1 a cada 100 entregas</option>
                    <option value="Controla 1 entrega por dia"<?php if($skip_lote=="Controla 1 entrega por dia"){ print "selected";}?>>Controla 1 entrega por dia</option>
                    <option value="Controla 1 entrega por semana"<?php if($skip_lote=="Controla 1 entrega por semana"){ print "selected";}?>>Controla 1 entrega por semana</option>
                    <option value="Controla 1 entrega por mês"<?php if($skip_lote=="Controla 1 entrega por mês"){ print "selected";}?>>Controla 1 entrega por mês</option>
					<option value="Controla 1 entrega por 2 meses"<?php if($skip_lote=="Controla 1 entrega por 2 meses"){ print "selected";}?>>Controla 1 entrega por 2 meses</option>
                    <option value="Controla 1 entrega por 3 meses"<?php if($skip_lote=="Controla 1 entrega por 3 meses"){ print "selected";}?>>Controla 1 entrega por 3 meses</option>
                    <option value="Controla 1 entrega por 4 meses"<?php if($skip_lote=="Controla 1 entrega por 4 meses"){ print "selected";}?>>Controla 1 entrega por 4 meses</option>
                    <option value="Controla 1 entrega por 5 meses"<?php if($skip_lote=="Controla 1 entrega por 5 meses"){ print "selected";}?>>Controla 1 entrega por 5 meses</option>
					<option value="Controla 1 entrega por 6 meses"<?php if($skip_lote=="Controla 1 entrega por 6 meses"){ print "selected";}?>>Controla 1 entrega por 6 meses</option>
					<option value="Controla 1 entrega por ano"<?php if($skip_lote=="Controla 1 entrega por ano"){ print "selected";}?>>Controla 1 entrega por ano</option>					
                    <option value="Controla 1 CRM"<?php if($skip_lote=="Controla 1 CRM"){ print "selected";}?>>Controla 1 CRM</option>
					<?php } else if($sit=="2"){ ?>
					<option value="Controlar todas as entregas"<?php if($skip_lote=="Controlar todas as entregas"){ print "selected";}?>>Controlar todas as entregas</option>
					<option value="Controla 1 a cada 2 entregas"<?php if($skip_lote=="Controla 1 a cada 2 entregas"){ print "selected";}?>>Controla 1 a cada 2 entregas</option>					
					<option value="Controla 1 a cada 3 entregas"<?php if($skip_lote=="Controla 1 a cada 3 entregas"){ print "selected";}?>>Controla 1 a cada 3 entregas</option>
					<option value="Controla 1 a cada 4 entregas"<?php if($skip_lote=="Controla 1 a cada 4 entregas"){ print "selected";}?>>Controla 1 a cada 4 entregas</option>
					<option value="Controla 1 CRM"<?php if($skip_lote=="Controla 1 CRM"){ print "selected";}?>>Controla 1 CRM</option>
					<?php } else if($sit=="3"){ ?>
					<option value="N/A"<?php if($skip_lote=="N/A"){ print "selected";}?>>N/A</option>
					<?php } else if($sit=="4"){ ?>
					<option value="N/A"<?php if($skip_lote=="N/A"){ print "selected";}?>>N/A</option>
					<?php } ?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input name="tempo_limite" type="text" class="formulario" id="tempo_limite" value="<?php echo $tempo_limite;?>" size="20" maxlength="5"></td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input name="ref_forn" type="text" class="formularioselect" id="ref_forn" value="<?php echo $ref_forn;?>" maxlength="20"></td>
                  </tr>
                <tr>
                  <td class="textobold">N&ordm; PAPP</td>
                  <td>&nbsp;</td>
                  <td class="textobold">Data</td>
                  <td class="textobold">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><span class="textobold">Validade</span></td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="textobold">Status</td>
                  </tr>
                <tr>
                  <td><input name="papp" type="text" class="formularioselect" value="<?php echo $papp;?>" id="papp"></td>
                  <td>&nbsp;</td>
                  <td><input name="data2" type="text" class="formulario" id="data2" value="<?php echo $data2;?>" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="20" maxlength="10"></td>
                  <td><div align="left"><img src="imagens/dot.gif" width="2" height="0"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_skip_lote1','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></div></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input name="validade" type="text" class="formulario" id="validade" value="<?php echo $validade;?>" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="20" maxlength="10"></td>
                  <td align="center"><div align="center"><a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_skip_lote2','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></div></td>
                  <td>&nbsp;</td>
                  <td class="textobold"><select name="status" class="formularioselect" id="status" onChange="MM_jumpMenu('parent',this,0)">
                    <option value="0"<?php if($status==0){print"selected";}?>>Selecione</option>
                    <option value="1"<?php if($status==1){print"selected";}?>>Fabricante</option>
                    <option value="2"<?php if($status==2){print"selected";}?>>Revendedor</option>
                    <option value="3"<?php if($status==3){print"selected";}?>>Permuta</option>
                                    </select></td>
                  </tr>
                <tr>
                  <td class="textobold">Atualiza</td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">Notifica</td>
                  <td class="textobold">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold"><label>
                    <input name="atualiza" type="radio" value="S" <?php if($atualiza=="S"){ print "checked";}?>>
                    Sim
                    <input name="atualiza" type="radio" value="N" <?php if($atualiza=="N"){ print "checked";}?>>
                    Não</label></td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold"><input name="notifica" type="radio" value="S" <?php if($notifica=="S"){ print "checked";}?>>
Sim
  <input name="notifica" type="radio" value="N" <?php if($notifica=="N"){ print "checked";}?>>
N&atilde;o</td>
                  <td class="textobold">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input name="just" type="hidden" id="just"></td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="textobold">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>

        </table></td>
      </tr>
    </table>
      <img src="imagens/dot.gif" width="20" height="8" />
      <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="100%" border="0" cellspacing="3" cellpadding="0">
            <tr>
              <td class="textoboldbranco">&nbsp;Amostragem</td>
              </tr>
            <tr>
              <td><table width="719" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="172" class="textobold">Norma</td>
                  <td width="10">&nbsp;</td>
                  <td width="173" class="textobold">Plano</td>
                  <td width="10">&nbsp;</td>
                  <td width="173" class="textobold">N&iacute;vel</td>
                  <td width="10">&nbsp;</td>
                  <td width="171" class="textobold">NQA</td>
                </tr>
                <tr>
                  <td>
				  	<select name="norma" class="formularioselect" id="norma" onChange="changeselect2()">
                    <option value="0"<?php if($norma==0){print"selected";}?>>Selecione</option>
                    <option value="1"<?php if($norma==1){print"selected";}?>>N/A</option>
                    <option value="2"<?php if($norma==2){print"selected";}?>>NBR-5426</option>
                                    </select></td>
                  <td>&nbsp;</td>
                  <td><select name="plano" class="formularioselect" id="plano" onChange="">
                    <option value="0"<?php if($plano==0){print"selected";}?>>Selecione</option>
                    <option value="1"<?php if($plano==1){print"selected";}?>>Simples Atenuada</option>
                    <option value="2"<?php if($plano==2){print"selected";}?>>Simples Severa</option>
                    <option value="3"<?php if($plano==3){print"selected";}?>>Simples Normal</option>
                    <option value="4"<?php if($plano==4){print"selected";}?>>Dupla Atenuada</option>
                    <option value="5"<?php if($plano==5){print"selected";}?>>Dupla Severa</option>
                    <option value="6"<?php if($plano==6){print"selected";}?>>Dupla Normal1</option>
                                    </select></td>
                  <td>&nbsp;</td>
                  <td><select name="nivel" class="formularioselect" id="nivel" onChange="">
                    <option value="0"<?php if($nivel==0){print"selected";}?>>Selecione</option>
                    <option value="1"<?php if($nivel==1){print"selected";}?>>S1</option>
                    <option value="2"<?php if($nivel==2){print"selected";}?>>S2</option>
                    <option value="3"<?php if($nivel==3){print"selected";}?>>S3</option>
                    <option value="4"<?php if($nivel==4){print"selected";}?>>S4</option>
                    <option value="5"<?php if($nivel==5){print"selected";}?>>01</option>
                    <option value="6"<?php if($nivel==6){print"selected";}?>>02</option>
                    <option value="7"<?php if($nivel==7){print"selected";}?>>03</option>
                                    </select></td>
                  <td>&nbsp;</td>
                  <td><select name="nqa" class="formularioselect" id="nqa" onChange="MM_jumpMenu('parent',this,0)">
                    <option value="0"<?php if($nqa==0){print"selected";}?>>Selecione</option>
                    <option value="1"<?php if($nqa==1){print"selected";}?>>0.010</option>
                    <option value="2"<?php if($nqa==2){print"selected";}?>>0.015</option>
                    <option value="3"<?php if($nqa==3){print"selected";}?>>0.025</option>
                    <option value="4"<?php if($nqa==4){print"selected";}?>>0.040</option>
                    <option value="5"<?php if($nqa==5){print"selected";}?>>0.065</option>
                    <option value="6"<?php if($nqa==6){print"selected";}?>>0.10</option>
                    <option value="7"<?php if($nqa==7){print"selected";}?>>0.15</option>
                    <option value="8"<?php if($nqa==8){print"selected";}?>>0.25</option>
                    <option value="9"<?php if($nqa==9){print"selected";}?>>0.40</option>
                    <option value="10"<?php if($nqa==10){print"selected";}?>>0.65</option>
                    <option value="11"<?php if($nqa==11){print"selected";}?>>1.0</option>
                    <option value="12"<?php if($nqa==12){print"selected";}?>>1.5</option>
                    <option value="13"<?php if($nqa==13){print"selected";}?>>2.5</option>
                    <option value="14"<?php if($nqa==14){print"selected";}?>>4.0</option>
                    <option value="15"<?php if($nqa==15){print"selected";}?>>6.5</option>
                    <option value="16"<?php if($nqa==16){print"selected";}?>>10</option>
                    <option value="17"<?php if($nqa==17){print"selected";}?>>15</option>
                    <option value="18"<?php if($nqa==18){print"selected";}?>>25</option>
                    <option value="19"<?php if($nqa==19){print"selected";}?>>40</option>
                    <option value="20"<?php if($nqa==20){print"selected";}?>>65</option>
                    <option value="21"<?php if($nqa==21){print"selected";}?>>100</option>
                    <option value="22"<?php if($nqa==22){print"selected";}?>>150</option>
                    <option value="23"<?php if($nqa==23){print"selected";}?>>250</option>
                    <option value="24"<?php if($nqa==24){print"selected";}?>>400</option>
                    <option value="25"<?php if($nqa==25){print"selected";}?>>650</option>
                    <option value="26"<?php if($nqa==26){print"selected";}?>>1000</option>
					</select>
				  </td>
                </tr>
              </table>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
        </tr>
        <tr>
          <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
        </tr>

        <tr>
          <td><div align="center"><span class="textobold">
            <input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='<?php echo  $_SERVER['PHP_SELF']; ?>'">
            </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit" type="submit" class="microtxt" value="Continuar">
            <input name="acao" type="hidden" id="acao" value="<?php if($acao=="alt"){ print "alterar"; }else{ print "incluir"; } ?>">
            <input name="id" type="hidden" id="id" value="<?php echo  $id; ?>">
</span></div></td>
        </tr>
      </table>
      </td>
  </tr>
  </form>
 <?php } ?>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>