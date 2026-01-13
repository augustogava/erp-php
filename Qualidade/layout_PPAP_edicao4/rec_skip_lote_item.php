<?
include("conecta.php");
if(empty($btipo)) $btipo="rec_plac";

if($buscar){
	unset($wp);
}
if(!empty($bitem)){
	$busca="WHERE descr LIKE '%$bitem%'";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function seleciona(descr,id){
	opener.form1.item.value=descr;
	opener.form1.iditem.value=id;
	window.close();
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><form name="form1" method="post" action="">
        <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
          </tr>
          <tr class="textobold"> 
            <td width="69">&nbsp;Descrição:</td>
            <td width="231"> <input name="bitem" type="text" class="formulario" id="bitem" size="30">
              <img src="imagens/dot.gif" width="20" height="5">
              <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
              <input name="buscar" type="hidden" id="buscar5" value="true"></td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td><table width="300" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
        <tr class="textoboldbranco"> 
          <td width="267">&nbsp;Ítem</td>
          <td width="18">&nbsp;</td>
        </tr>
		<?
		$sql=mysql_query("SELECT * FROM $btipo $busca ORDER BY descr ASC");
		if(mysql_num_rows($sql)==0){
		?>
        <tr bgcolor="#FFFFFF" class="texto"> 
          <td colspan="2" align="center" class="textopretobold">NENHUM REGISTRO ENCONTRADO</td>
        </tr>
        <?
		}else{
			//BLOCO PAGINACAO
			$results_tot=mysql_num_rows($sql); //total de registros encontrados
			$maxpag=10; //numero maximo de resultados por pagina
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
				$sql=mysql_query("SELECT * FROM $btipo $busca ORDER BY descr ASC LIMIT $param, $maxpag");
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
          <td>&nbsp;<? print $res["descr"]; ?></td>
          <td colspan="2"><div align="center"><a href="javascript:window.close();" onClick="return seleciona('<? print $res["descr"]; ?>','<? print $res["id"]; ?>');"><img src="imagens/icon_14img.gif" width="14" height="14" border="0"></a></div>
          </a></td>
		</tr>
		<?
			}
		}
		?>
      </table></td>
  </tr>
  <tr>
    <td align="center">      <? if($wpaginar) { ?>
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="center"><table width="1%" border="0" cellspacing="0" cellpadding="0">
              <tr valign="top"> 
                <td align="right"> 
                  <? 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                  <a href="<? print $_SERVER['PHP_SELF']."?wp=$pg_anterior&bitem=$bitem&btipo=$btipo"; ?>" class="paginacao2"> 
                  <? } ?>
                  <img src="imagens/pag_f.gif" border="0"> 
                  <? if($antz){ ?>
                  <br>
                  Anterior</a> 
                <? } ?>                </td>
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
                  <a href="<? print $_SERVER['PHP_SELF']."?wp=$link_impressos&bitem=$bitem&btipo=$btipo"; ?>" class="paginacao"> 
                  <? } ?>
                  <img src="imagens/pag_e<? if($pg_atual==$link_impressos) print "2"; ?>.gif"  border="0"><br>
                  <? if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
                  <? if($pg_atual != $link_impressos){ ?>
                  </a> 
                  <? } ?>
                </td>
                <?
				}
				?>
                <td> 
                  <? if($reg_final<$results_tot){ ?>
                  <a href="<? print $_SERVER['PHP_SELF']."?wp=$pg_proxima&bitem=$bitem&btipo=$btipo"; ?>" class="paginacao2"> 
                  <? } ?>
                  <img src="imagens/pag_der.gif" border="0"> 
                  <? if($reg_final<$results_tot){ ?>
                  <br>
                  Próximo</a> 
                <? } ?>                </td>
              </tr>
            </table></td>
        </tr>
      </table>
      <? } ?></td>
  </tr>
</table>
</body>
</html>
