<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$wsit=Input::request("wsit");
$forne=Input::request("forne");
$buscar=Input::request("buscar");
$id=Input::request("id");
$wp=Input::request("wp");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Recebimento - Entrega";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="entrar"){
	if(!isset($wsit)) $wsit="2";
	if($wsit=="2"){
		$busca=" WHERE entrega.fornecedor=fornecedores.id ";
	}
	if(!empty($forne)){
		$busca.=" AND fornecedores.nome LIKE '%$forne%' ";
	}
	$sql=mysql_query("SELECT * , entrega.id AS ids FROM entrega,fornecedores $busca ORDER By entrega.id DESC");
	$res=mysql_fetch_array($sql);
	$sql2=mysql_query("SELECT nome FROM fornecedores WHERE id='$res[fornecedor]'");
	$res2=mysql_fetch_array($sql2);
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM entrega WHERE id='$id'") or erp_db_fail();
	$res=mysql_fetch_array($sql);
	$sql2=mysql_query("SELECT nome FROM fornecedores WHERE id='$res[fornecedor]'");
	$res2=mysql_fetch_array($sql2);
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
function verificabusca(cad){
	if(cad.emissao.value!=''){
		if(!verifica_data(cad.emissao.value)){
			alert('Data de emissão incorreta');
			cad.emissao.focus();
			return false;
		}
		if(!verifica_data(cad.emissao2.value)){
			cad.emissao2.value='';
		}
	}
	return true;
}
function verifica(cad){
	if(cad.entregue[0].checked){
		if(!verifica_data(cad.entrega.value)){
			alert('Data de entrega incorreta');
			cad.entrega.focus();
			return false;
		}
	}else{
		cad.entrega.value='';
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" valign="top" class="chamadas"><table width="591" border="0" cellpadding="0" cellspacing="0" class="textopreto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="564" align="right"><div align="left"><span class="textobold style1 style1 style1 style1">Recebimento &gt; Entrega</span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
<?php
if($acao=="entrar"){
?>
  <tr>
    <td align="left" valign="top"><form name="formbus" method="post" action="" onSubmit="return verificabusca(this);">
      <table width="336" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td colspan="3" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
        </tr>
        <tr>
          <td width="80" class="textobold">&nbsp;Fornecedor:</td>
          <td width="194" class="textobold">
            <div align="left">
              <input name="forne" type="text" class="formularioselect" id="forne">
            </div></td>
          <td width="62" class="textobold"><div align="right"><img src="imagens/dot.gif" width="20" height="5">
              <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
              <input name="buscar" type="hidden" id="buscar5" value="true">
          </div></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="671" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="textobold"><a href="rec_entrega_sql.php?acao=inc" class="textobold">Incluir uma Entrega</a></td>
      </tr>
    </table>
    <table width="673" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
      <tr class="textoboldbranco">
        <td width="65" align="center">ID</td>
        <td width="466">Fornecedor</td>
        <td width="29" align="center">&nbsp;</td>
        <td width="29" align="center">&nbsp;</td>
      </tr>
<?php
if(!mysql_num_rows($sql)){
?>	  

      <tr bgcolor="#FFFFFF">
        <td colspan="4" align="center" class="textopretobold">NENHUM PEDIDO DE VENDA ENCONTRADO</td>
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
					$sql=mysql_query("SELECT * , entrega.id AS ids FROM entrega,fornecedores $busca ORDER By entrega.id DESC");
					$res=mysql_fetch_array($sql);
					$sql2=mysql_query("SELECT nome FROM fornecedores WHERE id='$res[fornecedor] ORDER BY nome ASC LIMIT $param, $maxpag'");
					$results_parc=mysql_num_rows($sql2);
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
?>
      <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
        <td align="center"><?php echo  $res["ids"]; ?></td>
        <td width="466">&nbsp;<?php echo  $res["fantasia"]; ?></td>
        <td width="29" align="center"><a href="<?php echo  $_SERVER['PHP_SELF']; ?>?acao=alt&id=<?php echo  $res["ids"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
        <td width="29" align="center"><a href="#" onClick="pergunta('Deseja excluir esta entrega?','rec_entrega_sql.php?id=<?php echo  $res["ids"]; ?>&acao=exc');"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
      </tr>
<?php
	}
}
?>
    </table>
    <div align="center"><br>
	<?php if($wpaginar){ ?>
     <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td align="right"><?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
              <a href="<?php print "rec_entrega.php?wp=$pg_anterior&forne=$forne"; ?>" class="paginacao2">
              <?php } ?>
              <img src="imagens/pag_f.gif" width="27" height="14" border="0">
              <?php if($antz){ ?>
              <br>
                Anterior</a>
              <?php } ?>          </td>
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
              <a href="<?php print "rec_entrega.php?wp=$link_impressos&forne=$forne"; ?>" class="paginacao">
              <?php } ?>
              <img src="imagens/pag_e<?php if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
              <?php if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
              <?php if($pg_atual != $link_impressos){ ?>
              </a>
              <?php } ?>          </td>
          <?php
				}
				?>
          <td><?php if($reg_final<$results_tot){ ?>
              <a href="<?php print "rec_entrega.php?wp=$pg_proxima&forne=$forne"; ?>" class="paginacao2">
              <?php } ?>
              <img src="imagens/pag_der.gif" width="26" height="14" border="0">
              <?php if($reg_final<$results_tot){ ?>
              <br>
                Pr&oacute;ximo</a>
              <?php } ?>          </td>
        </tr>
      </table><?php } ?>
    </div>
    </td>
  </tr>
<?php
}elseif($acao=="alt"){
?>
<form name="form1" method="post" action="rec_entrega_sql.php" onSubmit="return verifica(this);">
  <tr>
    <td align="left" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <td><table width="100%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td align="left" valign="top" bgcolor="#003366" class="textoboldbranco">&nbsp;
                <?php if($acao=="alt"){ print "Alterar"; }else{ print "Incluir"; } ?>
              Entrega </td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="602" border="0" cellspacing="0" cellpadding="0">
                <tr class="textobold">
                  <td width="122">Fornecedor</td>
                  <td width="7">&nbsp;</td>
                  <td width="122">&nbsp;</td>
                  <td width="7">&nbsp;</td>
                  <td width="122">&nbsp;</td>
                  <td width="48">&nbsp;</td>
                  <td width="84"><input name="fornecedor" type="hidden" id="fornecedor" value="<?php echo  $res["fornecedor"]; ?>"></td>
                  <td width="21">&nbsp;</td>
                  <td width="69" colspan="3" rowspan="5">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="7"><input name="nome" type="text" class="formularioselect" id="nome" value="<?php print $res2["nome"]; ?>" readonly></td>
                  <td align="center"><a href="#" onClick="return abre('rec_skip_lote_forn.php','a','width=320,height=300,scrollbars=1');"> <img src="imagens/icon_14_pess.gif" width="14" height="14" border="0"> </a></td>
                </tr>
                <tr>
                  <td class="textobold">Data Entrega </td>
                  <td class="textobold">&nbsp;</td>
                  <td class="textobold">Lote </td>
                  <td class="textobold">&nbsp;</td>
                  <td colspan="3" class="textobold">Dia de Atraso </td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td><input name="data" type="text" class="formulario" id="data" value="<?php echo  banco2data($res["data"]); ?>" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" size="10" maxlength="10">
                    <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_entrega_1&var_field=data','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
                  <td>&nbsp;</td>
                  <td><input name="lote" type="text" class="formularioselect" id="lote" value="<?php echo  $res["lote"]; ?>" maxlength="20"></td>
                  <td>&nbsp;</td>
                  <td colspan="3"><input name="atraso" type="text" class="formularioselect" id="atraso" value="<?php echo  $res["atraso"]; ?>" maxlength="20"></td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td class="textobold">Tamanho do Lote </td>
                  <td>&nbsp;</td>
                  <td class="textobold">Tam. Lt. Amostragem </td>
                  <td>&nbsp;</td>
                  <td class="textobold">Nota fiscal </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td><input name="tamanho" type="text" class="formularioselect" id="skip3" value="<?php echo  $res["tamanho"]; ?>" maxlength="20"></td>
                  <td>&nbsp;</td>
                  <td><input name="tam_amostragem" type="text" class="formularioselect" id="skip4" value="<?php print $res["tam_amostragem"]; ?>" maxlength="20"></td>
                  <td>&nbsp;</td>
                  <td><input name="nf" type="text" class="formularioselect" id="papp" value="<?php echo  $res["nf"]; ?>" maxlength="20"></td>
                  <td>&nbsp;</td>
                  <td class="textobold">Data da NF </td>
                  <td colspan="4" align="left"><input name="data_nf" type="text" class="formulario" id="papp4" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res["data_nf"]); ?>" size="10" maxlength="10">
                    <a href="#" class="" onClick="window.open('agenda_pop.php?window_position=rec_entrega_2&var_field=data_nf','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
                </tr>
                <tr>
                  <td class="textobold">Num. Pedido </td>
                  <td>&nbsp;</td>
                  <td class="textobold">CRM</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="textobold">Pre&ccedil;o Unit&aacute;rio</td>
                  <td colspan="4" align="left"><input name="unitario" type="text" class="formulario" id="papp5" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php echo  banco2valor($res["unitario"]); ?>" size="10" maxlength="20"></td>
                </tr>
                <tr>
                  <td><input name="pedido" type="text" class="formularioselect" id="papp2" value="<?php echo  $res["pedido"]; ?>" maxlength="20"></td>
                  <td>&nbsp;</td>
                  <td><input name="crm" type="text" class="formularioselect" id="papp3" value="<?php echo  $res["crm"]; ?>" maxlength="20"></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="textobold">Certificado</td>
                  <td colspan="4" align="left"><input name="certificado" type="text" class="formulario" id="papp6" value="<?php echo  $res["certificado"]; ?>" size="10" maxlength="20"></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
                <tr>
                  <td bgcolor="#FFFFFF"><table width="594" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
                      <tr class="textoboldbranco">
                        <td width="22" align="center">&nbsp;</td>
                        <td width="0">Descri&ccedil;&atilde;o</td>
                        <td width="24" align="center">&nbsp;</td>
                      </tr>
                      <?php
$sql=mysql_query("SELECT * FROM entrega_list WHERE entrega='$id'");
if(!mysql_num_rows($sql)){
	$sql=mysql_query("INSERT INTO entrega_list (entrega) VALUES ('$id')");
	$sql=mysql_query("SELECT * FROM entrega_list WHERE entrega='$id'");
}
if(mysql_num_rows($sql)){
	while($resl=mysql_fetch_array($sql)){
		if($resl["item"]){
			$sqlp=mysql_query("SELECT nome FROM apqp_pc WHERE id='$resl[item]'");
			$resp=mysql_fetch_array($sqlp);
			$resl["prod"]=$resp["nome"];
		}
?>
                      <tr bgcolor="#FFFFFF">
                        <td align="center"><input name="del[<?php echo  $resl["id"]; ?>]" type="checkbox" id="del<?php echo  $resl["id"]; ?>" value="<?php echo  $resl["id"]; ?>"></td>
                        <td width="0"><input name="descricao[<?php echo  $resl["id"]; ?>]" type="text" class="formularioselect" id="descricao<?php echo  $resl["id"]; ?>" size="1" readonly="" value="<?php echo  $resl["prod"]; ?>">
                            <input name="prodserv[<?php echo  $resl["id"]; ?>]" type="hidden" id="prodserv<?php echo  $resl["id"]; ?>" value="<?php echo  $resl["item"] ?>"></td>
                        <td align="center"><a href="#" onClick="return abre('rec_skip_lote_pc.php?line=<?php echo  $resl["id"]; ?>&abre=S','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" width="14" height="14" border="0"></a></td>
                      </tr>
                      <?php
	}
}
?>
                  </table></td>
                </tr>
            </table></td>
          </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="imagens/dot.gif" width="20" height="8"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><span class="textobold"></a>&nbsp;
      <input name="Button" type="button" class="microtxt" value="Voltar" onClick="window.location='<?php echo  $_SERVER['PHP_SELF']; ?>';">      
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="Button" type="button" class="microtxt" value="Adicionar Linha" onClick="form1.maisum.value='1'; form1.submit();">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="Submit" type="submit" class="microtxt" value="Excluir Linhas" onClick="form1.delsel.value='1'; form1.submit();">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Incluir" type="submit" class="microtxt" id="Incluir" value="Continuar">
        <input name="acao" type="hidden" id="acao" value="alt">
        <input name="delsel" type="hidden" id="delsel">
        <input name="maisum" type="hidden" id="maisum2">
        <input name="id" type="hidden" id="maisum3" value="<?php echo  $id; ?>">
</span></td>
  </tr>
  </form>
 <?php } ?>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>