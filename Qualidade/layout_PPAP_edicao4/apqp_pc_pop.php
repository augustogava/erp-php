<?php
include("conecta.php");
include("seguranca.php");
$buscar=Input::request("buscar");
$bcli=Input::request("bcli");
$bpeca=Input::request("bpeca");
$bnum=Input::request("bnum");
$wp=Input::request("wp");
if($buscar){
	unset($wp);
}
$cond="WHERE apqp_pc.cliente=clientes.id";
if(!empty($bcli)){
	$cond.=" AND (clientes.nome like '%$bcli%' OR clientes.fantasia like '%bcli%') ";
}
if(!empty($bpeca)){
	$cond.=" AND apqp_pc.nome like '%$bpeca%' ";
}
if(!empty($bnum)){
	$cond.=" AND apqp_pc.numero like '%$bnum%' ";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="chamadas"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14"><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1 style1 style1 style1 style1">APQP - Cadastro de Pe&ccedil;as </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr> 
    <td align="left" valign="top"><form name="form1" method="post" action="">
      <table width="300" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
          </tr>
        <tr>
          <td class="textobold">&nbsp;Cliente</td>
          <td><input name="bcli" type="text" class="formularioselect" id="bcli"></td>
        </tr>
        <tr>
          <td class="textobold">&nbsp;Pe&ccedil;a</td>
          <td><input name="bpeca" type="text" class="formularioselect" id="bpeca"></td>
        </tr>
        <tr>
          <td width="52" class="textobold">&nbsp;N&uacute;mero</td>
          <td width="248"><input name="bnum" type="text" class="formulario" id="bnum" size="15">
            <img src="imagens/dot.gif" width="20" height="5">
            <span class="textobold">
            <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
</span>            <input name="buscar" type="hidden" id="buscar5" value="true"></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="594" border="0" cellpadding="3" cellspacing="1" bgcolor="#999999">
      <tr class="textoboldbranco">
        <td width="90">&nbsp;N&uacute;mero</td>
        <td width="65" align="center">&nbsp;Data</td>
        <td width="190">&nbsp;Nome</td>
        <td>&nbsp;Cliente</td>
        <td width="16" align="center">&nbsp;</td>
        </tr>
	  <?php
	  $sql=mysql_query("SELECT apqp_pc.id,apqp_pc.numero,apqp_pc.nome,apqp_pc.rev,apqp_pc.dtrev,clientes.fantasia FROM apqp_pc,clientes $cond ORDER BY numero ASC, rev ASC");
	  if(mysql_num_rows($sql)==0){
	  ?>
      <tr bgcolor="#FFFFFF">
        <td colspan="5" align="center" class="textopretobold">NENHUMA PE&Ccedil;A ENCONTRADA &nbsp;</td>
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
					$sql=mysql_query("SELECT apqp_pc.id,apqp_pc.numero,apqp_pc.nome,apqp_pc.rev,apqp_pc.dtrev,clientes.fantasia FROM apqp_pc,clientes $cond ORDER BY numero ASC, rev ASC LIMIT $param, $maxpag");
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
       <a href="#" onClick="return pergunta('Deseja copiar todas as Características?','apqp_peca.php?id=<?php print $res["id"]; ?>&peca=<?php print $id; ?>&acao=tudo')"> 
       <td width="90">&nbsp;<?php print $res["numero"]." - ".$res["rev"]; ?></td>
        <td width="65" align="center"><?php print banco2data($res["dtrev"]); ?></td>
        <td>&nbsp;<?php print $res["nome"]; ?></td>
        <td>&nbsp;<?php print $res["fantasia"]; ?></td></a>
        <td align="center"><a href="apqp_car_pop.php?id=<?php print $res["id"]; ?>&acao=inc&menu=S&num=<?php print $res["numero"]; ?>&rev=<?php print $res["rev"]; ?>&peca=<?php print $id; ?>&npc2=<?php print $npc2; ?>"><img src="imagens/icon14_alterar.gif" alt="Visualizar" width="14" height="14" border="0"></a></td>
       
        </tr>
	  <?php
	  	}
	}
	?>
    </table>
      <?php if($wpaginar) { ?>
      <table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><table width="1%" border="0" cellspacing="0" cellpadding="0">
              <tr valign="top">
                <td align="right">
                  <?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                  <a href="<?php print "apqp_pc_pop.php?wp=$pg_anterior&bcli=$bcli&bpeca=$bpeca&bnum=$bnum"; ?>" class="paginacao2">
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
                <td align="center">
                  <?php if($pg_atual != $link_impressos){ ?>
                  <a href="<?php print "apqp_pc_pop.php?wp=$link_impressos&bcli=$bcli&bpeca=$bpeca&bnum=$bnum"; ?>" class="paginacao">
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
                <td>
                  <?php if($reg_final<$results_tot){ ?>
                  <a href="<?php print "apqp_pc_pop.php?wp=$pg_proxima&bcli=$bcli&bpeca=$bpeca&bnum=$bnum"; ?>" class="paginacao2">
                  <?php } ?>
                  <img src="imagens/pag_der.gif" width="26" height="14" border="0">
                  <?php if($reg_final<$results_tot){ ?>
                  <br>
            Pr&oacute;ximo</a>
                  <?php } ?>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
    <?php } ?></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>