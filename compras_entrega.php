<?php
include("conecta.php");
$acao=Input::request("acao");
$buscar=Input::request("buscar");
$bcli=Input::request("bcli");
$id=Input::request("id");
$wp=Input::request("wp");
if($buscar){
	unset($wp);
}
if(empty($acao)){ $acao="entrar"; }
if(!empty($bcli)){
	$busca="WHERE apelido LIKE '%$bcli%'";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function seleciona(id,nome,nume,entr){
	opener.form1.dentrega.value=id;
	opener.form1.dentrega1.value=nome + ' - ' + entr;
	opener.form1.dentregan.value=nume;
	window.close();
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php if($acao=="entrar"){ ?>
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
    <td align="center"><table width="321" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr class="textoboldbranco"> 
            <td width="216">&nbsp;Empresa</td>
          </tr>
		<?php
		$sql=mysql_query("SELECT * FROM empresa $busca ORDER BY nome ASC");
		if(mysql_num_rows($sql)==0){
		?>
          <tr bgcolor="#FFFFFF" class="texto"> 
            <td align="center">NENHUMA EMPRESA ENCONTRADA</td>
          </tr>
          <?php
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
				$sql=mysql_query("SELECT * FROM empresa $busca ORDER BY nome ASC LIMIT $param, $maxpag");
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
				$resnome=str_replace("'","",$res["nome"]);
		?>
		  <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
<a href="compras_entrega.php?acao=ver&id=<?php echo  $res["id"]; ?>">
            <td>&nbsp;<?php print $res["nome"]; ?></td>
</a>
          </tr>

		  <?php
			}
		}
		?>
    </table></td></tr>
  <tr>
    <td align="center">      <?php if($wpaginar) { ?>
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="center"><table width="1%" border="0" cellspacing="0" cellpadding="0">
              <tr valign="top"> 
                <td align="right"> 
                  <?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                  <a href="<?php print "compras_trans.php?wp=$pg_anterior&bcli=$bcli"; ?>" class="paginacao2"> 
                  <?php } ?>
                  <img src="imagens/pag_f.gif" border="0"> 
                  <?php if($antz){ ?>
                  <br>
                  Anterior</a> 
                <?php } ?>                </td>
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
                  <a href="<?php print "compras_trans.php?wp=$link_impressos&bcli=$bcli"; ?>" class="paginacao"> 
                  <?php } ?>
                  <img src="imagens/pag_e<?php if($pg_atual==$link_impressos) print "2"; ?>.gif" border="0"><br>
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
                  <a href="<?php print "compras_trans.php?wp=$pg_proxima&bcli=$bcli"; ?>" class="paginacao2"> 
                  <?php } ?>
                  <img src="imagens/pag_der.gif" border="0"> 
                  <?php if($reg_final<$results_tot){ ?>
                  <br>
                  Próximo</a> 
                <?php } ?>                </td>
              </tr>
            </table></td>
        </tr>
      </table>
      <?php } ?></td>
  </tr>
</table>
<?php }else{ ?>
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textobold">Selecione o n&uacute;mero da entrega: </td>
  </tr>
  <tr>
    <td align="center"><table width="321" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
     <?php
		$sql=mysql_query("SELECT * FROM empresa WHERE id='$id'");
		$res=mysql_fetch_array($sql);
		?>
        <tr class="textoboldbranco">
          <td width="296">&nbsp;<?php print $res["nome"]; ?></td>
          <td width="22">&nbsp;</td>
        </tr>
   
        <tr bgcolor="#FFFFFF" class="texto">
          <td>Entrega1: <?php echo  $res["apelido_ent1"]; ?></td>
          <td align="center"><a href="#" onClick="return seleciona('<?php print $id; ?>','<?php print $res["nome"]; ?>','1','<?php print $res["apelido_ent1"]; ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
        </tr>
        <tr bgcolor="#FFFFFF" class="texto">
          <td>Entrega2:
              <?php echo  $res["apelido_ent2"]; ?></td>
          <td align="center"><a href="#" onClick="return seleciona('<?php print $id; ?>','<?php print $res["nome"]; ?>','2','<?php print $res["apelido_ent2"]; ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
        </tr>
        <tr bgcolor="#FFFFFF" class="texto">
          <td>Entrega3:
              <?php echo  $res["apelido_ent3"]; ?></td>
          <td align="center"><a href="#" onClick="return seleciona('<?php print $id; ?>','<?php print $res["nome"]; ?>','3','<?php print $res["apelido_ent3"]; ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
        </tr>
        <tr bgcolor="#FFFFFF" class="texto">
          <td>Entrega4:
              <?php echo  $res["apelido_ent4"]; ?></td>
          <td align="center"><a href="#" onClick="return seleciona('<?php print $id; ?>','<?php print $res["nome"]; ?>','4','<?php print $res["apelido_ent4"]; ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    </td>
  </tr>
</table>
<?php } ?>
</body>
</html>