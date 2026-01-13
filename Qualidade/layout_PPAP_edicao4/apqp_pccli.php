<?
include("conecta.php");
$popup=true;
include("seguranca.php");
if(empty($btipo)) $btipo="clientes";
if($buscar){
	unset($wp);
}
if(!empty($bcli) && empty($bcod)){
	$busca="WHERE nome LIKE '%$bcli%'";
}
if(!empty($bcli) && !empty($bcod)){
	$busca="WHERE nome LIKE '%$bcli%' AND id LIKE '%$bcod%'";
}
if(empty($bcli) && !empty($bcod)){
	$busca="WHERE id LIKE '$bcod'";
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
function seleciona(nome,id){
	opener.form1.nomecli.value=nome;
	opener.form1.cliente.value=id;
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
        <table width="300" border="0" cellspacing="3" cellpadding="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
          </tr>
          <tr class="textobold"> 
            <td width="55">&nbsp;Nome:</td>
            <td width="245"> <input name="bcli" type="text" class="formularioselect" id="bcli"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;C&oacute;digo:</td>
            <td><input name="bcod" type="text" class="formulario" id="bcod" size="10">
              <img src="imagens/dot.gif" width="20" height="5">
              <input name="imageField2" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
              <input name="buscar2" type="hidden" id="buscar2" value="true"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td><table width="300" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
        <tr class="textoboldbranco"> 
          <td width="277">&nbsp;Cliente</td>
        </tr>
		<?
		$sql=mysql_query("SELECT * FROM $btipo $busca ORDER BY nome ASC");
		if(mysql_num_rows($sql)==0){
		?>
        <tr bgcolor="#FFFFFF" class="texto"> 
          <td align="center" class="textopreto">NENHUM REGISTRO ENCONTRADO</td>
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
				$sql=mysql_query("SELECT * FROM $btipo $busca ORDER BY nome ASC LIMIT $param, $maxpag");
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
		<tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> <a href="#" onClick="return seleciona('<? print $res["nome"]; ?>','<? print $res["id"]; ?>');">
          <td>&nbsp;<? print $res["nome"]; ?></td>
          </a>        </tr>
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
                  <a href="<? print "apqp_pccli.php?wp=$pg_anterior&bcli=$bcli&bcod=$bcod"; ?>" class="paginacao2"> 
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
                  <a href="<? print "apqp_pccli.php?wp=$link_impressos&bcli=$bcli&bcod=$bcod"; ?>" class="paginacao"> 
                  <? } ?>
                  <img src="imagens/pag_e<? if($pg_atual==$link_impressos) print "2"; ?>.gif" border="0"><br>
                  <? if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
                  <? if($pg_atual != $link_impressos){ ?>
                  </a> 
                <? } ?>                </td>
                <?
				}
				?>
                <td> 
                  <? if($reg_final<$results_tot){ ?>
                  <a href="<? print "apqp_pccli.php?wp=$pg_proxima&bcli=$bcli&bcod=$bcod"; ?>" class="paginacao2"> 
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