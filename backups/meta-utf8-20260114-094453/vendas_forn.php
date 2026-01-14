<?
include("conecta.php");
if(empty($btipo)) $btipo="clientes";
if($btipo=="clientes"){
	$bt="C";
	$bt2="Cliente";
}else{
	$bt="F";
	$bt2="Fornecedor";
}
if($buscar){
	unset($wp);
}
if(!empty($bcli)){
	$busca="WHERE nome LIKE '%$bcli%' AND fantasia LIKE '%$bcli%'";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function seleciona(nome,id){
	opener.form1.nome.value=nome;
	opener.form1.cliente.value=id;
	window.close();
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua2.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><form name="form1" method="post" action="">
        <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
          </tr>
          <tr class="textobold"> 
            <td width="55">&nbsp;Nome:</td>
            <td> <input name="bcli" type="text" class="formularioselect" id="bcli"></td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center"><input name="Submit2" type="submit" class="microtxt" value="Buscar">
            <input name="buscar" type="hidden" id="buscar5" value="true"> 
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td><table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco"> 
          <td width="277">&nbsp;<? print $bt2; ?></td>
          <td width="20" align="center">&nbsp;</td>
        </tr>
		<?
		$sql=mysql_query("SELECT * FROM $btipo $busca ORDER BY nome ASC");
		if(mysql_num_rows($sql)==0){
		?>
        <tr bgcolor="#FFFFFF" class="texto"> 
          <td colspan="2" align="center">NENHUM REGISTRO ENCONTRADO</td>
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
		<tr bgcolor="#FFFFFF" class="texto"> 
          <td>&nbsp;<? print $res["nome"]; ?></td>
          <td width="20" align="center"><a href="#" onClick="return seleciona('<? print $res["nome"]; ?>','<? print $res["id"]; ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
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
                  <a href="<? print $_SERVER['PHP_SELF']."?wp=$pg_anterior&bcli=$bcli&btipo=$btipo"; ?>" class="paginacao2"> 
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
                  <a href="<? print $_SERVER['PHP_SELF']."?wp=$link_impressos&bcli=$bcli&btipo=$btipo"; ?>" class="paginacao"> 
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
                  <a href="<? print $_SERVER['PHP_SELF']."?wp=$pg_proxima&bcli=$bcli&btipo=$btipo"; ?>" class="paginacao2"> 
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
