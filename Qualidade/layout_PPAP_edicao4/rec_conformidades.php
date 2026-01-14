<?php
include("conecta.php");
include("seguranca.php");
$buscar=Input::request("buscar");
$acao=Input::request("acao");
$bdescr=Input::request("bdescr");
$bcod=Input::request("bcod");
$id=Input::request("id");
$wp=Input::request("wp");
if(!empty($acao)){
	$loc="Recebimento - Não Conformidades";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(!empty($bdescr)){
	$cond="WHERE descricao like '%$bdescr%'";
}
if(!empty($bcod)){
	$cond="WHERE cod LIKE '%$bcod%'";
}
if(!empty($bdescr) and !empty($bcod)){
	$cond="WHERE descricao like '%$bdescr%' AND cod LIKE '%$bcod%'";
}
if($acao=="exc"){
$sql=mysql_query("DELETE FROM conformidades WHERE id='$id'");

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
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>
<form name="form1" method="post" action="">
             <table width="591" border="0" cellpadding="0" cellspacing="0" class="textopreto">
               <tr>
                 <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
                 <td width="564" align="right"><div align="left"><span class="textobold style1 style1 style1">Recebimento &gt; Busca &gt; N&atilde;o Conformidades </span></div></td>
               </tr>
               <tr>
                 <td align="center">&nbsp;</td>
                 <td align="right">&nbsp;</td>
               </tr>
             </table>
             <br> 
             <table width="263" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">BUSCA</td>
                </tr>
                <tr class="textobold"> 
                  <td>Descri&ccedil;&atilde;o:</td>
                  <td><input name="bdescr" type="text" class="formularioselect" id="bdescr" size="36"></td>
                </tr>
                <tr class="textobold"> 
                  <td width="71">C&oacute;d:</td>
                  <td width="192"><input name="bcod" type="text" class="formulario" id="bcod" size="10">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="imagens/dot.gif" width="20" height="5">
                    <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
                    <input name="buscar" type="hidden" id="buscar5" value="true"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr> 
          <td><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center"><a href="rec_conformidades_geral.php?acao=inc" class="textobold"><strong>Incluir N&atilde;o Conformidade </strong></a></td>
            </tr>
          </table><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="129" align="left">C&oacute;d</td>
                <td width="403">&nbsp;Descri&ccedil;&atilde;o</td>
                <td width="33" align="center">&nbsp;</td>
                <td width="24" align="center">&nbsp;</td>
              </tr>
              <?php
			  $sql=mysql_query("SELECT * FROM conformidades $cond ORDER BY id DESC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto"> 
                <td colspan="4" align="center" class="textopretobold">NENHUMA N&Atilde;O-CONFORMIDADE 
                  ENCONTRADA</td>
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
			  		$sql=mysql_query("SELECT * FROM conformidades $cond ORDER BY fitn ASC LIMIT $param, $maxpag");
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
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
                <td align="left"><?php print $res["cod"]; ?></td>
                <td>&nbsp;<?php print $res["descricao"]; ?></td>
                <td align="center"><a href="rec_conformidades_geral.php?acao=alt&id=<?php print $res["id"]; print "&bdescr=$bdescr&bcod=$bcod";?>"><img src="imagens/icon14_alterar.gif" alt="Entrega" width="14" height="14" border="0"></a></td>
                <td align="center"><a href="#" onClick="return pergunta('Deseja excluir esta conformidade?','rec_conformidades.php?acao=exc&id=<?php print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?php
			  	}
			  }
			  ?>
            </table>
		  <?php if($wpaginar){ ?>
          <br><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr valign="top">
              <td align="right"><?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                  <a href="<?php print "rec_conformidades.php?wp=$pg_anterior&bdescr=$bdescr&bcod=$bcod"; ?>" class="paginacao2">
                  <?php } ?>
                  <img src="imagens/pag_f.gif" width="27" height="14" border="0">
                  <?php if($antz){ ?>
                  <br>
                    Anterior</a>
                  <?php } ?>              </td>
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
                  <a href="<?php print "rec_conformidades.php?wp=$link_impressos&bdescr=$bdescr&bcod=$bcod"; ?>" class="paginacao">
                  <?php } ?>
                  <img src="imagens/pag_e<?php if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
                  <?php if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
                  <?php if($pg_atual != $link_impressos){ ?>
                  </a>
                  <?php } ?>              </td>
              <?php
				}
				?>
              <td><?php if($reg_final<$results_tot){ ?>
                  <a href="<?php print "rec_conformidades.php?wp=$pg_proxima&bdescr=$bdescr&bcod=$bcod"; ?>" class="paginacao2">
                  <?php } ?>
                  <img src="imagens/pag_der.gif" width="26" height="14" border="0">
                  <?php if($reg_final<$results_tot){ ?>
                  <br>
                    Pr&oacute;ximo</a>
                  <?php } ?>              </td>
            </tr>
          </table>
          <?php } ?>
          <div align="center"><br>
            <input name="Voltar" type="submit" class="microtxt" id="Voltar" onClick="window.location='mana_rece.php';" value="Voltar">
              </p>
          </div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>