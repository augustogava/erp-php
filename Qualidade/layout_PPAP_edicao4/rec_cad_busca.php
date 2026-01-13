<?
include("conecta.php");
include("seguranca.php");

if($buscar){
	unset($wp);
}

if(!empty($bnome)){
	$cond=" WHERE metr_tipi_nome like '%$bnome%'";
}

if(!empty($bcod)){
	$cond=" WHERE metr_inst_cod like '%$bcod%'";
}

if(!empty($bnome)&&!empty($bcod)){
	$cond=" WHERE metr_tipi_nome like '%$bnome%' AND metr_inst_cod like '%$bcod%'";
}

if($acao=="exc"){
	$sql2=mysql_query("SELECT metr_inst_cod FROM metrologia_cad WHERE metr_cad_id='$id'");
	$res2=mysql_fetch_array($sql2);
	// cria followup caso exclua
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Instrumento de Medição.','O usuário $quem1 excluiu o Instrumento de Medição código $res2[metr_inst_cod].','$user')");
	//	
	$sql=mysql_query("DELETE FROM metrologia_cad WHERE metr_cad_id='$id'");
	header("Location:metr_insm_busca.php");
	exit;
}

?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="446" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="446"><table width="537" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="537"> <form name="form1" method="post" action="">
		  <table width="434" border="0" cellpadding="0" cellspacing="0" class="textopreto">
          <tr>
            <td width="25" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Grupos'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Em desenvolvimento')"><span class="impTextoBold">&nbsp;</span></div></td>
            <td width="363" align="right"><div align="left" class="titulos">Recebimento &gt; Controle de Entrega </div></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
      </table>
              <table width="273" border="0" cellspacing="3" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">BUSCA</td>
                </tr>
                <tr class="textobold"> 
                  <td width="54">Nome:</td>
                  <td width="210"><input name="bnome" type="text" class="formularioselect" id="bnome" size="26"></td>
                </tr>
                <tr class="textobold">
                  <td>C&oacute;digo:</td>
                  <td><input name="bcod" type="text" class="formulario" id="bcod" size="15">&nbsp;<img src="imagens/dot.gif" width="20" height="5">
                    <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
                    <input name="buscar" type="hidden" id="buscar5" value="true"></td>
                </tr>
              </table>
          </form></td>
        </tr>
        <tr> 
          <td><table width="537" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
            <tr class="textobold">
              <td colspan="9" align="center" bgcolor="#FFFFFF" class="textobold"><a href="metr_insm.php?acao=inc" class="textobold">Incluir Nova Entrega </a></td>
              </tr>
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="53" align="center"><div align="center">N&ordm; Rast </div></td>
                <td width="62">&nbsp;&nbsp;Data</td>
                <td width="79">&nbsp;&nbsp;Fornecedor</td>
                <td width="92">&nbsp;&nbsp;N&ordm; Nota Fisc. </td>
                <td width="82">&nbsp;&nbsp;Quant. Rolo </td>
                <td width="55" align="center">Total</td>
                <td width="67" align="center"><div align="left">&nbsp;&nbsp;Status</div></td>
                <td width="21" align="center">&nbsp;</td>
                <td width="16" align="center">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM metrologia_cad $cond ORDER BY metr_tipi_nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto"> 
                <td colspan="9" align="center" class="textopretobold">NENHUMA ENTREGA ENCONTRADA </td>
              </tr>
              <?
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
					$sql=mysql_query("SELECT * FROM metrologia_cad $cond ORDER BY metr_tipi_nome ASC LIMIT $param, $maxpag");
					$results_parc=mysql_num_rows($sql);
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
					$reg_final++; // PAGINACAO conta quantos registros imprimiu
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td align="center">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td width="21" align="center"><a href="metr_insm.php?acao=alt&id=<? print $res["metr_cad_id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="16" align="center"><a href="#" onClick="return pergunta('Deseja excluir este instrumento?','metr_insm_busca.php?acao=exc&id=<? print $res["metr_cad_id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?
			  	}
			  }
			  ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <? if($wpaginar){ ?>
  <tr>
    <td colspan="3"><img src="imagens/dot.gif" width="200" height="10"></td>
  </tr>
  <tr> 
    <td align="center"> <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top"> 
          <td align="right"> 
            <? 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
            <a href="<? print "metr_insm_busca.php?wp=$pg_anterior&bnome=$bnome&bcod=$bcod"; ?>" class="paginacao2"> 
            <? } ?>
            <img src="imagens/pag_f.gif" width="27" height="14" border="0"> 
            <? if($antz){ ?>
            <br>
            Anterior</a>
            <? } ?>          </td>
          <?
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
          <td align="center"> 
            <? if($pg_atual != $link_impressos){ ?>
            <a href="<? print "metr_insm_busca.php?wp=$link_impressos&bnome=$bnome&bcod=$bcod"; ?>" class="paginacao"> 
            <? } ?>
            <img src="imagens/pag_e<? if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
            <? if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
            <? if($pg_atual != $link_impressos){ ?>
            </a>
            <? } ?>          </td>
          <?
				}
				?>
          <td> 
            <? if($reg_final<$results_tot){ ?>
            <a href="<? print "metr_insm_busca.php?wp=$pg_proxima&bnome=$bnome&bcod=$bcod"; ?>" class="paginacao2"> 
            <? } ?>
            <img src="imagens/pag_der.gif" width="26" height="14" border="0"> 
            <? if($reg_final<$results_tot){ ?>
            <br>
            Próximo</a>
            <? } ?>          </td>
        </tr>
      </table></td>
  </tr>
    <? } ?>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><span class="textobold">
      <input name="voltar" type="button" class="microtxt" value="Voltar" onClick="window.location='mana_metr.php';">
    </span></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>