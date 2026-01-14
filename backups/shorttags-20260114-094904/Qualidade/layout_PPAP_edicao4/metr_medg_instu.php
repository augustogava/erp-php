<?
include("conecta.php");
$popup=true;
include("seguranca.php");

if(!empty($bdesc)){
	$cond.=" AND metr_instr_desc like '%$bdesc%' ";
}
if(!empty($bcod)){
	$cond.=" AND metr_instr_codi LIKE '%$bcod%' ";
}

?>
<html>
<head>
<title>Instrução de Utilização</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script language="JavaScript">
windowWidth=520;
windowHeight=280;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
function marca(id,desc){
	opener.form1.inst_util.value=id;
	opener.form1.inst_util2.value=desc;
	window.close();
}
function fec(){
	window.close();
}
</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
  <tr>
    <td colspan="2" bgcolor="#FFFFFF" class="texto style1"><form name="form1" method="post" action="">
      <table width="300" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
        </tr>
        
        <tr>
          <td class="textobold">Descri&ccedil;&atilde;o:</td>
          <td><input name="bdesc" type="text" class="formularioselect" id="bdesc"></td>
        </tr>
        <tr>
          <td width="52" class="textobold">C&oacute;digo:</td>
          <td width="248"><input name="bcod" type="text" class="formulario" id="bcod" size="15">
              <img src="imagens/dot.gif" width="20" height="5"> <span class="textobold">
              <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
              </span>
              <input name="buscar" type="hidden" id="buscar5" value="true"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr class="textoboldbranco">
    <td width="93">C&oacute;digo </td>
    <td width="392">Descri&ccedil;&atilde;o</td>
  </tr>
	<?
	$sql=mysql_query("SELECT * FROM metrologia_instr WHERE metr_instr_tipo='2' $cond ORDER BY metr_instr_codi ASC");
	if(mysql_num_rows($sql)==0){
	?>
  <tr bgcolor="#FFFFFF">
    <td colspan="2" align="center" class="textopretobold">NENHUMA INSTRU&Ccedil;&Atilde;O CADASTRADA </td>
  </tr>
	<?
	}else{
		//BLOCO PAGINACAO
		$results_tot=mysql_num_rows($sql); //total de registros encontrados
		$maxpag=7; //numero maximo de resultados por pagina
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
			$sql=mysql_query("SELECT * FROM metrologia_instr WHERE metr_instr_tipo='2' $cond ORDER BY metr_instr_codi ASC LIMIT $param, $maxpag");
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
  <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"><a href="#" onClick="return marca('<?= $res["metr_instr_id"]; ?>','<?= $res["metr_instr_desc"]; ?>');">
    <td>&nbsp;<?=$res["metr_instr_codi"];?></td>
    <td><?= $res["metr_instr_desc"];?></td></a>  </tr>
	<?
		}
	}
	?>
</table>
<? if($wpaginar){ ?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td align="center">
                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                  <tr valign="top">
                    <td align="right">
                      <? 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                      <a href="<? print "metr_medg_instu.php?wp=$pg_anterior&bdesc=$bdesc&bcod=$bcod"; ?>" class="texto">
                      <? } ?>
                      <img src="imagens/pag_f.gif" border="0">
                      <? if($antz){ ?>
                      <br>
            Anterior</a>
                      <? } ?>                    </td>
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
                      <a href="<? print "metr_medg_instu.php?wp=$link_impressos&bdesc=$bdesc&bcod=$bcod"; ?>" class="texto">
                      <? } ?>
                      <img src="imagens/pag_e<? if($pg_atual==$link_impressos) { print "2"; }else{ print ""; } ?>.gif" border="0"><br>
                      <? if($pg_atual==$link_impressos){ print "<span class=\"textobold\">$link_impressos</span>"; }else{ print $link_impressos; }?>
                      <? if($pg_atual != $link_impressos){ ?>
                      </a>
                      <? } ?></td>
                    <?
				}
				?>
                    <td>
                      <? if($reg_final<$results_tot){ ?>
                      <a href="<? print "metr_medg_instu.php?wp=$pg_proxima&bdesc=$bdesc&bcod=$bcod"; ?>" class="texto">
                      <? } ?>
                      <img src="imagens/pag_der.gif" border="0">
                      <? if($reg_final<$results_tot){ ?>
                      <br>
            Pr&oacute;ximo</a>
                      <? } ?>                    </td>
                  </tr>
              </table></td>
            </tr>
</table>            <? } ?>
</body>
</html>
<? include("mensagem.php"); ?>