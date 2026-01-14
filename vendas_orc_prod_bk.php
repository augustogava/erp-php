<?php
include("conecta.php");
if($abre=="S"){
	$_SESSION["compras_prodserv_line"]=$line;
}
$line=$_SESSION["compras_prodserv_line"];
if($buscar){
	unset($wp);
}
if(!empty($bcli)){
	$busca="WHERE nome LIKE '%$bcli%'";
}
if(!empty($codi)){
	$busca="WHERE apelido LIKE '%$codi%'";
}
if(!empty($categoria)){
	$busca="WHERE categoria='$categoria'";
}
if(!empty($codi) and !empty($bcli)){
	$busca="WHERE apelido LIKE '%$codi%' AND nome LIKE '%$bcli%'";
}
if(!empty($categoria) and !empty($bcli)){
	$busca="WHERE categoria='$categoria' AND nome LIKE '%$bcli%'";
}
if(!empty($codi) and !empty($categoria)){
	$busca="WHERE apelido LIKE '%$codi%' AND categoria='$categoria'";
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
function seleciona(id,nome,uni,valu){
	opener.form1.prodserv<?php print $line; ?>.value=id;
	opener.form1.descricao<?php print $line; ?>.value=nome;
	opener.form1.un<?php print $line; ?>.value=uni;
	opener.form1.unitario<?php print $line; ?>.value=valu;
	window.close();
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><form name="form1" method="post" action="">
        <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Categoria:</td>
            <td><select name="categoria" class="formularioselect" id="categoria">
                <option value="">Selecione</option>
                <?php
$sqlr=mysql_query("SELECT * FROM categorias ORDER BY nome ASC");
while($resr=mysql_fetch_array($sqlr)){
?>
                <option value="<?php print $resr["id"]; ?>"<?php if($res["categoria"]==$resr["id"]) print "selected"; ?>><?php print($resr["nome"]); ?></option>
                <?php } ?>
            </select></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Codigo:</td>
            <td>
              <input name="codi" type="text" class="formularioselect" id="codi"></td>
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
    <td align="center"><a href="#" class="textobold" onClick="return abre('prodserv.php?acao=inc','inc','width=620,height=400,scrollbars=1');">incluir novo produto </a>
      <table width="600" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr class="textoboldbranco"> 
            <td width="69">&nbsp;C&oacute;digo</td>
            <td width="184">&nbsp;Produto</td>
            <td width="168">Categoria</td>
            <td width="80">Pre&ccedil;o Venda </td>
            <td width="16" align="center">&nbsp;</td>
          </tr>
		<?php
		$sql=mysql_query("SELECT * FROM prodserv $busca ORDER BY categoria ASC");
		if(mysql_num_rows($sql)==0){
		?>
          <tr bgcolor="#FFFFFF" class="texto"> 
            <td colspan="5" align="center">NENHUM PRODUTO ENCONTRADO</td>
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
				$sql=mysql_query("SELECT * FROM prodserv $busca ORDER BY nome ASC LIMIT $param, $maxpag");
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
				$val="";
				$reg_final++; // PAGINACAO conta quantos registros imprimiu
				$resnome=str_replace("'","",$res["nome"]);
				if(!empty($res["porta"])){
					$porta=$res["porta"];
					$sql2=mysql_query("SELECT * FROM portasp WHERE id='$porta'");
					$res2=mysql_fetch_array($sql2);
					
					$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$res[id]'");
					while($ress=mysql_fetch_array($sqls)){
						$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$ress[item]'"); $res3=mysql_fetch_array($sql3);
						$tota+=$res3["cs"]*$ress["qtd"];
					}
						$cs=pvccs($porta,$largura,$altura);
						$ci=pvcci($porta,$largura,$altura);
						$cr=pvccr($porta,$largura,$altura);
						$perfil=perfil($res2["perfil"],$largura,$altura);
					
						
						$pcs=pvcp("cs",$porta,$cs);
						$pci=pvcp("ci",$porta,$ci);
						$pcr=pvcp("cr",$porta,$cr);
						$perfilpr=perfilp($res2["perfil"],$perfil);
						$val=($tota+$pcs+$pci+$pcr+$perfilpr)*$res["margem"];
				}else if(!empty($res["cortina"])){
					$cortina=$res["cortina"];
					$a=cortinas($largura,$altura);
					$val=(cortinasp($cortina,$a["trilho"],$a["pvc"],$a["arrebites"],$a["parafusos"],$a["buchas"],$a["penduralg"],$a["penduralp"])+$tota)*$res["margem"];
				}else{
					$val=$res["pv"];
				}
				$sql4=mysql_query("SELECT * FROM unidades WHERE id='$res[unidade]'"); $res4=mysql_fetch_array($sql4); $uni=$res4["apelido"];
		?>
		  <tr bgcolor="#FFFFFF" class="texto"> 
            <td>&nbsp;<?php print $res["codprod"]; ?></td>
            <td>&nbsp;<?php print $res["nome"]; ?></td>
            <td><?php $sql2=mysql_query("SELECT * FROM categorias WHERE id='$res[categoria]'"); $res2=mysql_fetch_array($sql2); print $res2["nome"]; ?></td>
            <td>&nbsp;R$ <?php print banco2valor($res["pv"]); ?></td>
            <td width="16" align="center"><a href="#" onClick="return seleciona('<?php print $res["id"]; ?>','<?php echo  htmlspecialchars($resnome,ENT_QUOTES); ?>','<?php echo  $uni; ?>','<?php print banco2valor($val); ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
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
                  <a href="<?php print "compras_prodserv.php?wp=$pg_anterior&bcli=$bcli&categoria=$categoria"; ?>" class="paginacao2"> 
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
                  <a href="<?php print "compras_prodserv.php?wp=$link_impressos&bcli=$bcli&categoria=$categoria"; ?>" class="paginacao"> 
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
                  <a href="<?php print "compras_prodserv.php?wp=$pg_proxima&bcli=$bcli&categoria=$categoria"; ?>" class="paginacao2"> 
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
</body>
</html>