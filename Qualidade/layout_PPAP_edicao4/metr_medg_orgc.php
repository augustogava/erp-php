<?php
include("conecta.php");
$popup=true;
include("seguranca.php");

if(!empty($bdesc)&&empty($bcod)){
	$cond.="WHERE metr_lab_fant like '%$bdesc%' ";
}
if(!empty($bcod)&&empty($bdesc)){
	$cond.="WHERE metr_instr_codi LIKE '%$bcod%' ";
}
if(!empty($bdesc)&&!empty($bcod)){
	$cond.="WHERE metr_lab_fant like '%$bdesc%' AND metr_instr_codi LIKE '%$bcod%' ";
}
?>
<html>
<head>
<title>Órgão Calibrador</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script language="JavaScript">
windowWidth=520;
windowHeight=280;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
function marca(id,desc){
	opener.form1.org_cali.value=id;
	opener.form1.org_cali2.value=desc;
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
    <td width="105">C&oacute;d. Laborat&oacute;rio </td>
    <td width="380">Nome Laborat&oacute;rio </td>
  </tr>
	<?php
	$sql=mysql_query("SELECT * FROM metrologia_lab $cond ORDER BY metr_lab_fant ASC");
	if(mysql_num_rows($sql)==0){
	?>
  <tr bgcolor="#FFFFFF">
    <td colspan="2" align="center" class="textopretobold">NENHUM &Oacute;RG&Atilde;O CADASTRADO</td>
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
			$sql=mysql_query("SELECT * FROM metrologia_lab $cond ORDER BY metr_lab_fant ASC LIMIT $param, $maxpag");
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
  <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"><a href="#" onClick="return marca('<?php echo  $res["metr_lab_id"];?>','<?php echo  $res["metr_lab_fant"]; ?>');">
    <td>&nbsp;<?php echo $res["metr_lab_codi"];?></td>
    <td><?php echo  $res["metr_lab_fant"];?></td>
    </a>  </tr>
	<?php
		}
	}
	?>
</table>

<?php if($wpaginar){ ?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><img src="imagens/dot.gif" width="20" height="8"></td>
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
                      <a href="<?php print "metr_medg_orgc.php?wp=$pg_anterior&bdesc=$bdesc&bcod=$bcod"; ?>" class="texto">
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
                      <a href="<?php print "metr_medg_orgc.php?wp=$link_impressos&bdesc=$bdesc&bcod=$bcod"; ?>" class="texto">
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
                      <a href="<?php print "metr_medg_orgc.php?wp=$pg_proxima&bdesc=$bdesc&bcod=$bcod"; ?>" class="texto">
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