<?php
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
<table width="585" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="585"><table width="585" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="585"> <form name="form1" method="post" action="">
		  <table width="434" border="0" cellpadding="0" cellspacing="0" class="textopreto">
          <tr>
            <td width="25" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Grupos'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Em desenvolvimento')"><span class="impTextoBold">&nbsp;</span></div></td>
            <td width="363" align="right"><div align="left" class="titulos">Recebimento &gt; Cronograma de Acompanhamento </div></td>
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
          <td><table width="584" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
            <tr class="textobold">
              <td colspan="26" align="center" bgcolor="#FFFFFF" class="textobold">Cronograma de Acompanhamento de An&aacute;lise Comprobat&oacute;ria</td>
              </tr>
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="58"><div align="center">Material</div></td>
                <td colspan="24">&nbsp;&nbsp;Controle das Entradas &nbsp;&nbsp;</td>
                <td width="47" align="center"><div align="center">Status</div></td>
              </tr>
              <?php
			  $sql=mysql_query("SELECT * FROM metrologia_cad $cond ORDER BY metr_tipi_nome ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <?php /* ?><tr bgcolor="#FFFFFF" class="textopreto"> 
                <td colspan="30" align="center" class="textopretobold">NENHUMA - aten&ccedil;&atilde;o !!!!!!!!!!!!!!!!!!!!!!! colocar mensagem adequada</td>
              </tr><?php */ ?>
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
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td width="23">&nbsp;</td>
                <td align="center"><a href="metr_insm.php?acao=alt&id=<?php print $res["metr_cad_id"]; ?>"></a><a href="#" onClick="return pergunta('Deseja excluir este instrumento?','metr_insm_busca.php?acao=exc&id=<?php print $res["metr_cad_id"]; ?>')"></a></td>
              </tr>
              <?php
			  	}
			  }
			  ?>
            </table></td>
        </tr>
    </table></td>
  </tr>
  <?php if($wpaginar){ ?>
  <tr>
    <td colspan="3"><img src="imagens/dot.gif" width="200" height="10"></td>
  </tr>
  <tr> 
    <td align="center"> <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top"> 
          <td align="right"> 
            <?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
            <a href="<?php print "metr_insm_busca.php?wp=$pg_anterior&bnome=$bnome&bcod=$bcod"; ?>" class="paginacao2"> 
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
          <td align="center"> 
            <?php if($pg_atual != $link_impressos){ ?>
            <a href="<?php print "metr_insm_busca.php?wp=$link_impressos&bnome=$bnome&bcod=$bcod"; ?>" class="paginacao"> 
            <?php } ?>
            <img src="imagens/pag_e<?php if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
            <?php if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
            <?php if($pg_atual != $link_impressos){ ?>
            </a>
            <?php } ?>          </td>
          <?php
				}
				?>
          <td> 
            <?php if($reg_final<$results_tot){ ?>
            <a href="<?php print "metr_insm_busca.php?wp=$pg_proxima&bnome=$bnome&bcod=$bcod"; ?>" class="paginacao2"> 
            <?php } ?>
            <img src="imagens/pag_der.gif" width="26" height="14" border="0"> 
            <?php if($reg_final<$results_tot){ ?>
            <br>
            Próximo</a>
            <?php } ?>          </td>
        </tr>
      </table></td>
  </tr>
    <?php } ?>
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
<?php include("mensagem.php"); ?>