<?php
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
if($acao=="calcula"){
	$sqlm=mysql_query("SELECT * FROM material WHERE id='$idmat'");
	$resm=mysql_fetch_array($sqlm);
	$tot=banco2valor(($alt*$larg)*$resm["valor"]);
	$peso=((valor2banco($alt)*valor2banco($larg))/100)*$resm["peso"];
	$nome.=" - $resm[apelido]";
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
function seleciona(id,nome,valo,matid,valo2,pes){
	opener.form1.prodserv<?php print $line; ?>.value=id;
	opener.form1.descricao<?php print $line; ?>.value=nome;
	opener.form1.unitario<?php print $line; ?>.value=valo;
	opener.form1.pcu<?php print $line; ?>.value=valo2;
	opener.form1.material<?php print $line; ?>.value=matid;
	opener.form1.peso<?php print $line; ?>.value=pes;
	window.close();
}
function calc(idmat,alt,larg,id,nome){
	window.location='vendas_orc_prod.php?acao=calcula&idmat='+idmat+'&alt='+alt+'&larg='+larg+'&id='+id+'&nome='+nome+'<?php print "&line=$line"; ?>';
	//var tot=(alt*larg)*prec;
	//seleciona(id,nome,tot);
}
<?php if($acao=="calcula"){ ?>
function manda(){
	seleciona('<?php echo  $id; ?>','<?php echo  $nome; ?>','<?php echo  $tot; ?>','<?php echo  $idmat; ?>','<?php echo  valor2banco($tot); ?>','<?php echo  $peso; ?>');
}
<?php } ?>
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+100),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php if($acao=="calcula"){ ?>
<script>manda();</script>
<?php } ?>
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
              <?php
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
              <input name="altura" type="hidden" id="buscar" value="<?php echo  $altura; ?>">
			   <input name="largura" type="hidden" id="buscar" value="<?php echo  $largura; ?>"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td align="center"><a href="#" class="textobold" onClick="return abre('prodserv.php?acao=inc','inc','width=620,height=400,scrollbars=1');">incluir novo produto </a>
      <table width="99%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr class="textoboldbranco">
            <td width="57">Codigo</td>
            <td width="204">Produto</td>
            <td width="28">P.V. </td>
            <td width="92" align="center">Saldo Disponivel </td> 
            <td width="93" align="center">Material</td>
            <td width="14" align="center">&nbsp;</td>
          </tr>
		<?php
		$sql=mysql_query("SELECT * FROM prodserv $busca ORDER BY categoria ASC, codprod ASC");
		if(mysql_num_rows($sql)==0){
		?>
          <tr bgcolor="#FFFFFF" class="texto">
            <td colspan="6" align="center">NENHUM PRODUTO ENCONTRADO</td>
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
				$sql=mysql_query("SELECT * FROM prodserv $busca ORDER BY categoria ASC,codprod ASC LIMIT $param, $maxpag");
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
				//Itens
				$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$res[id]'");
					while($ress=mysql_fetch_array($sqls)){
						$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$ress[item]'"); $res3=mysql_fetch_array($sql3);
						$tota+=$res3["cs"]*$ress["qtd"];
					}
				//
				if(!empty($res["porta"])){
					$porta=$res["porta"];
					$sql2=mysql_query("SELECT * FROM portasp WHERE id='$porta'");
					$res2=mysql_fetch_array($sql2);
					
						$cs=pvccs($porta,$largura,$altura);
						$ci=pvcci($porta,$largura,$altura);
						$cr=pvccr($porta,$largura,$altura);
						$perfil=perfil($res2["perfil"],$largura,$altura);
						//print " $porta - $cs -  $ci - $cr - $perfil";
						
						$pcs=pvcp("cs",$porta,$cs);
						$pci=pvcp("ci",$porta,$ci);
						$pcr=pvcp("cr",$porta,$cr);
						$perfilpr=perfilp($res2["perfil"],$perfil);
						//print "($tota+$pcs+$pci+$pcr+$perfilpr)*$res[margem]";
						$val=($tota+$pcs+$pci+$pcr+$perfilpr)*$res["margem"];
				}else if(!empty($res["cortina"])){
					$cortina=$res["cortina"];
					$a=cortinas($largura,$altura);
					$val=(cortinasp($cortina,$a["trilho"],$a["pvc"],$a["arrebites"],$a["parafusos"],$a["buchas"],$a["penduralg"],$a["penduralp"])+$tota)*$res["margem"];
					//print "(cortinasp($cortina,$a[trilho],$a[pvc],$a[arrebites],$a[parafusos],$a[buchas],$a[penduralg],$a[penduralp])+$tota)*$res[margem]";
				}else if(!empty($res["cortina_not"])){
					$cortina_not=$res["cortina_not"];
					$val=(cortina_not($largura,$cortina_not)+$tota)*$res["margem"];
					print "(cortina_not($largura,$cortina_not)+$tota)*$res[margem]";
				}else{
					$val=$res["pv"];
				}
		?>
		  <tr bgcolor="#FFFFFF" class="texto">
		    <td><?php print $res["codprod"]; ?></td>
		    <td><input name="bcli2" type="text" class="formularioselectsemborda2222" id="bcli2" value="<?php print $res["nome"]; ?>" size="40">	        </td>
		    <td><?php print banco2valor($res["pv"]); ?></td>
		    <td><?php print $ress["qtdd"]; ?></td> 
            <td width="93" align="center"><span class="textobold">
              <select name="material" class="preto" id="material" onChange="calc(this.value,'<?php echo  $altura; ?>','<?php echo  $largura ?>','<?php print $res["id"]; ?>','<?php echo  htmlspecialchars($resnome,ENT_QUOTES); ?>');">
                <option value="">Selecione</option>
                <?php
				$idm=explode(",",$res["id_mat"]);
				foreach($idm as $key=>$value){
					$sqlmaterial=mysql_query("SELECT * FROM material WHERE id='$value' ORDER BY nome ASC");
					if(mysql_num_rows($sqlmaterial)){
					$resmaterial=mysql_fetch_array($sqlmaterial)
				?>
                <option value="<?php print $resmaterial["id"]; ?>"><?php print $resmaterial["apelido"]; ?></option>
                <?php } } ?>
              </select>
            </span></td>
            <td width="14" align="center"><a href="#" onClick="return seleciona('<?php print $res["id"]; ?>','<?php echo  htmlspecialchars($resnome,ENT_QUOTES); ?>','<?php print banco2valor($val); ?>','','<?php print $val; ?>','<?php print $res["pesob"]; ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
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
                  <a href="<?php print "vendas_orc_prod.php?wp=$pg_anterior&bcli=$bcli&categoria=$categoria&altura=$altura&largura=$largura"; ?>" class="paginacao2"> 
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
                  <a href="<?php print "vendas_orc_prod.php?wp=$link_impressos&bcli=$bcli&categoria=$categoria&altura=$altura&largura=$largura"; ?>" class="paginacao"> 
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
                  <a href="<?php print "vendas_orc_prod.php?wp=$pg_proxima&bcli=$bcli&categoria=$categoria&altura=$altura&largura=$largura"; ?>" class="paginacao2"> 
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