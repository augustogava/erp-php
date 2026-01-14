<?php
include("conecta.php");
$popup=true;
include("seguranca.php");

if(!empty($bdesc)){
	$cond.=" AND descricao LIKE '%$bdesc%' ";
}
if(!empty($btipo)){
	$cond.=" AND tipo LIKE '%$btipo%' ";
}

?>
<html>
<head>
<title>Busca de Tipo de Instrumento</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script language="JavaScript">
windowWidth=680;
windowHeight=50;

if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
function marca(id,descricao){
		opener.form1.tipi.value=descricao;
		opener.form1.idtipi.value=id;
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
<table width="307" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
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
          <td width="52" class="textobold">Tipo:</td>
          <td width="248"><input name="btipo" type="text" class="formulario" id="btipo" size="15">
              <img src="imagens/dot.gif" width="20" height="5"> <span class="textobold">
              <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
              </span>
              <input name="buscar" type="hidden" id="buscar5" value="true"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr class="textoboldbranco">
    <td width="95">Tipo</td>
    <td width="197">Descri&ccedil;&atilde;o</td>
  </tr>
	<?php
	$sql=mysql_query("SELECT * FROM ins_medicao WHERE 1 $cond ORDER BY tipo ASC");
	if(mysql_num_rows($sql)==0){
	?>
  <tr bgcolor="#FFFFFF">
    <td colspan="2" align="center" class="textopretobold">NENHUM INSTRUMENTO DE MEDI&Ccedil;&Atilde;O CADASTRADO</td>
  </tr>
	<?php
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
			$sql=mysql_query("SELECT * FROM ins_medicao WHERE 1 $cond ORDER BY tipo ASC LIMIT $param, $maxpag");
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
  <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"><a href="#" onClick="return marca('<?php print $res["id"]; ?>','<?php print $res["descricao"]; ?>');">
    <td>&nbsp;<?php echo $res["tipo"];?></td>
    <td><?php echo  $res["descricao"];?></td></a>  </tr>
	<?php
		}
	}
	?>
</table>
<a href="javascript:window.close();" onClick="marca('<?php print $res["id"]; ?>','<?php echo $res["tipo"]." - ".$res["descricao"];?>');"></a>
<?php if($wpaginar){ ?>
<table width="296" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="296"><img src="imagens/dot.gif" width="20" height="8"></td>
            </tr>
            <tr>
              <td align="center">
                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                  <tr valign="top">
                    <td align="right">
                      <?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                      <a href="<?php print "rec_plac_lisi.php?wp=$pg_anterior&bdesc=$bdesc&btipo=$btipo"; ?>" class="texto">
                      <?php } ?>
                      <img src="imagens/pag_f.gif" border="0">
                      <?php if($antz){ ?>
                      <br>
            Anterior</a>
                      <?php } ?>                    </td>
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
                      <a href="<?php print "rec_plac_lisi.php?wp=$link_impressos&bdesc=$bdesc&btipo=$btipo"; ?>" class="texto">
                      <?php } ?>
                      <img src="imagens/pag_e<?php if($pg_atual==$link_impressos) { print "2"; }else{ print ""; } ?>.gif" border="0"><br>
                      <?php if($pg_atual==$link_impressos){ print "<span class=\"textobold\">$link_impressos</span>"; }else{ print $link_impressos; }?>
                      <?php if($pg_atual != $link_impressos){ ?>
                      </a>
                      <?php } ?></td>
                    <?php
				}
				?>
                    <td>
                      <?php if($reg_final<$results_tot){ ?>
                      <a href="<?php print "rec_plac_lisi.php?wp=$pg_proxima&bdesc=$bdesc&btipo=$btipo"; ?>" class="texto">
                      <?php } ?>
                      <img src="imagens/pag_der.gif" border="0">
                      <?php if($reg_final<$results_tot){ ?>
                      <br>
            Pr&oacute;ximo</a>
                      <?php } ?>                    </td>
                  </tr>
              </table></td>
            </tr>
</table>            <?php } ?>
</body>
</html>
<?php include("mensagem.php"); ?>