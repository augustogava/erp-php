<?
include("conecta.php");
if($abre=="S"){
	$_SESSION["vendas_prodserv_line"]=$line;
}
$line=$_SESSION["vendas_prodserv_line"];
if($buscar){
	unset($wp);
}
if(!empty($bcli)){
	$busca="WHERE nome LIKE '%$bcli%'";
}
if(!empty($categoria)){
	$busca="WHERE ecat='$categoria'";
}
if(!empty($categoria) and !empty($bcli)){
	$busca="WHERE ecat='$categoria' AND nome LIKE '%$bcli%'";
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
function seleciona(id,nome,valo){
	opener.form1.prodserv<? print $line; ?>.value=id;
	opener.form1.descricao<? print $line; ?>.value=nome;
	opener.form1.unitario<? print $line; ?>.value=valo;
	window.close();
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><form name="form1" method="post" action="">
        <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#003366"> 
            <td colspan="2" align="center" class="textoboldbranco">BUSCA</td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Nome:</td>
            <td><input name="bcli" type="text" class="formularioselect" id="bcli"></td>
          </tr>
          <tr class="textobold"> 
            <td width="55">Categoria:</td>
            <td><select name="categoria" class="formularioselect" id="categoria">
              <option value="">Selecione</option>
              <?
function no($idpai,$wcat){
	$sql=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$idpai' ORDER BY texto ASC");
	if(mysql_num_rows($sql)!=0){
		while($res=mysql_fetch_array($sql)){
			$sql2=mysql_query("SELECT * FROM prodserv_cat WHERE idpai='$res[id]' ORDER BY texto ASC");
			$widpai=$res["id"];
			$esp=0;
			while($widpai!=0){
				$sql3=mysql_query("SELECT idpai FROM prodserv_cat WHERE id='$widpai'");
				$res3=mysql_fetch_array($sql3);
				$widpai=$res3["idpai"];
				if($widpai!=0) $esp++;
			}
			if($res["id"]==$wcat){
				$selsel="selected";
			}else{
				$selsel="";
			}
			print "<option value=\"$res[id]\" $selsel>".str_repeat("&nbsp;", $esp*4)."$res[texto]</option>\n";
			if(mysql_fetch_array($sql2)){
				no($res["id"],$wcat);
			}
		}
	}
}
no(0,$cat);
?>
            </select></td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center"><input name="Submit2" type="submit" class="microtxt" value="Buscar">
            <input name="buscar" type="hidden" id="buscar5" value="true"> 
              <input name="altura" type="hidden" id="buscar" value="<?= $altura; ?>">
			   <input name="largura" type="hidden" id="buscar" value="<?= $largura; ?>"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td align="center"><a href="#" class="textobold" onClick="return abre('prodserv.php?acao=inc','inc','width=620,height=400,scrollbars=1');">incluir novo produto </a>
      <table width="99%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr class="textoboldbranco">
            <td width="51">Codigo</td>
            <td width="148">Produto</td>
            <td width="135">Descri&ccedil;&atilde;o</td>
            <td width="35">Pre&ccedil;o Venda </td>
            <td width="30">Saldo</td>
            <td width="60" align="center">Saldo Disponivel </td> 
            <td width="28" align="center">&nbsp;</td>
          </tr>
		<?
		$sql=mysql_query("SELECT * FROM prodserv $busca ORDER BY categoria ASC");
		if(mysql_num_rows($sql)==0){
		?>
          <tr bgcolor="#FFFFFF" class="texto">
            <td colspan="7" align="center">NENHUM PRODUTO ENCONTRADO</td>
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
				$sql=mysql_query("SELECT * FROM prodserv $busca ORDER BY categoria ASC LIMIT $param, $maxpag");
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
					//print "(cortinasp($cortina,$a[trilho],$a[pvc],$a[arrebites],$a[parafusos],$a[buchas],$a[penduralg],$a[penduralp])+$tota)*$res[margem]";
				}else{
					$val=$res["pv"];
				}
		?>
		  <tr bgcolor="#FFFFFF" class="texto">
		    <td><? print $res["codprod"]; ?></td>
		    <td><? print $res["nome"]; ?></td>
		    <td><? print $res["descricao"]; ?></td>
		    <td><? print $res["pv"]; ?></td>
		    <td><? $sqls=mysql_query("SELECT SUM(qtde-qtds) AS qtdt, SUM(qtde-qtdd) AS qtdd FROM prodserv_est WHERE id='$res[id]'"); $ress=mysql_fetch_array($sqls); print $ress["qtdt"]; ?></td>
		    <td><? print $ress["qtdd"]; ?></td> 
            <td width="28" align="center"><a href="#" onClick="return seleciona('<? print $res["id"]; ?>','<?= htmlspecialchars($resnome,ENT_QUOTES); ?>','<? print banco2valor($val); ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
          </tr>
		  <?
			}
		}
		?>
    </table></td></tr>
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
                  <a href="<? print "vendas_prodserv.php?wp=$pg_anterior&bcli=$bcli&altura=$altura&largura=$largura"; ?>" class="paginacao2"> 
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
                  <a href="<? print "vendas_prodserv.php?wp=$link_impressos&bcli=$bcli&altura=$altura&largura=$largura"; ?>" class="paginacao"> 
                  <? } ?>
                  <img src="imagens/pag_e<? if($pg_atual==$link_impressos) print "2"; ?>.gif" border="0"><br>
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
                  <a href="<? print "vendas_prodserv.php?wp=$pg_proxima&bcli=$bcli&altura=$altura&largura=$largura"; ?>" class="paginacao2"> 
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