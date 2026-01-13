<?
include("conecta.php");
include("seguranca.php");
if($buscar){
	unset($wp);
}
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Ordem Produção";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="baixa"){
	$sql=mysql_query("UPDATE prodserv_ordem,e_compra SET prodserv_ordem.sit='F',e_compra.sit='P' WHERE prodserv_ordem.id='$id' AND prodserv_ordem.compra=e_compra.id");
	$sql=mysql_query("UPDATE prodserv_sep_list,prodserv_ordem SET prodserv_sep_list.sit='3' WHERE prodserv_sep_list.pedido='$ped' AND prodserv_sep_list.prodserv=prodserv_ordem.prodserv");
						//baixa produzidos estoque
						$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$ped'") or die("Naun foi");
						while($res=mysql_fetch_array($sql2)){
							//POrta//
							$produto=$res["produto"];
							$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
							$pror=mysql_fetch_array($pro);
								if(!empty($pror["porta"])){
									//Medida
										$porta=$pror["porta"];
										$dado=explode("X",$res["medidas"]);
											$altura=$dado[0];
											$largura=$dado[1];
										//
											$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
											while($ress=mysql_fetch_array($sqls)){
												$tota+=$ress["val"]*$ress["qtd"];
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','6')");
											}
											$sqlp=mysql_query("SELECT * FROM portasp WHERE id='$porta'");
											$resp=mysql_fetch_array($sqlp);
											$sql2=mysql_query("SELECT * FROM perfil WHERE id='$resp[perfil]'");
											$res2=mysql_fetch_array($sql2);
											$cs=pvccs($porta,$largura,$altura);
											$ci=pvcci($porta,$largura,$altura);
											$cr=pvccr($porta,$largura,$altura);
											$perfil=perfil($resp["perfil"],$largura,$altura);
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc_superior]','$hj','$cs','2','6')");
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc_inferior]','$hj','$ci','2','6')");
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc_cristal]','$hj','$cr','2','6')");
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res2[perfil]','$hj','$perfil','2','6')");
								}
							//Porta
							 // Cortinaa
								if(!empty($pror["cortina"])){
										$cortina=$pror["cortina"];
										//Medida
											$dado=explode("X",$tamanho);
												$altura=$dado[0];
												$largura=$dado[1];
										//Fim medida
										$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
										while($ress=mysql_fetch_array($sqls)){
											$tota+=$ress["val"]*$ress["qtd"];
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtdd,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','2')");
										}
										$sqlp=mysql_query("SELECT * FROM portasp WHERE id='$cortina'");
										$resp=mysql_fetch_array($sqlp);
												
										$a=cortinas($largura,$altura);
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[trilho]','$hj','$a[trilho]','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[pvc]','$hj','$a[pvc]','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[arrebites]','$hj','$a[arrebites]','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[parafusos]','$hj','$a[parafusos]','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[buchas]','$hj','$a[buchas]','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[penduralg]','$hj','$a[penduralg]','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$resp[penduralp]','$hj','$a[penduralp]','2','6')");
									//Fim Cortina
							}
						}
						// Fim produzidos

	if($sql){
		$_SESSION["mensagem"]="Baixa com Sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="Não pode ser dado Baixa!";
	}
}
if(!isset($sit)) $sit="A";
$busca="WHERE prodserv_ordem.sit='$sit' ";
if(!empty($item)){
	$busca.="AND prodserv.ordem.prodserv='$item' ";
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="components.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.bde.value!='' || cad.bate.value!=''){
		if(!verifica_data(cad.bde.value)){
			alert('Período incorreto');
			cad.bde.focus();
			return false;
		}
		if(!verifica_data(cad.bate.value)){
			alert('Período incorreto');
			cad.bate.focus();
			return false;
		}
	}
	return true;
}
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Ordem de Produ&ccedil;&atilde;o </div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="imagens/dot.gif" width="100" height="5"></td>
  </tr>
  <tr><td><form name="form1" method="post" action="" onSubmit="return verifica(this);">
    <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
      <tr>
        <td bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" align="center" bgcolor="#003366" class="textoboldbranco">Busca</td>
            </tr>
            <tr class="textobold">
              <td width="63">&nbsp;Produto:</td>
              <td width="217"><input name="nome" type="text" class="formularioselect" id="nome3" size="7" maxlength="50" readonly></td>
              <td width="20" align="center"><a href="#" onClick="return abre('prodserv_bus2.php','busca','width=320,height=300,scrollbars=1');"><img src="imagens/icon_14_search.gif" alt="Selecione um Item" width="14" height="14" border="0"></a></td>
            </tr>
            <tr class="textobold">
              <td>&nbsp;Situa&ccedil;&atilde;o:</td>
              <td colspan="2"><input name="sit" type="radio" value="0" checked>
                abertas
                  <input name="sit" type="radio" value="1">
                  finalizadas
                  <input name="buscar" type="hidden" id="buscar" value="true">
                  <input name="item" type="hidden" id="item"></td>
            </tr>
            <tr class="textobold">
              <td colspan="3"><img src="imagens/dot.gif" width="100" height="5"></td>
            </tr>
            <tr class="textobold">
              <td colspan="3" align="center"><input name="Submit2" type="submit" class="microtxt" value="Buscar"></td>
            </tr>
            <tr class="textobold">
              <td colspan="3" align="center"><img src="imagens/dot.gif" width="100" height="5"></td>
            </tr>
        </table></td>
      </tr>
    </table>
  </form></td></tr>
  <tr>
    <td align="left" valign="top">
<? $sqlc=mysql_query("SELECT * FROM prodserv_cat ORDER By texto ASC"); 
while($catr=mysql_fetch_array($sqlc)){ $cat=$catr["id"]; ?>
<?
$sql=mysql_query("SELECT *,prodserv_ordem.id as idd FROM prodserv_ordem,prodserv $busca AND prodserv_ordem.prodserv=prodserv.id AND prodserv.ecat='$cat' ORDER BY prodserv_ordem.id ASC");
if(!mysql_num_rows($sql)){
?>
    
      
   
      <?
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
		$sql=mysql_query("SELECT *,prodserv_ordem.id as idd FROM prodserv_ordem,prodserv $busca AND prodserv_ordem.prodserv=prodserv.id AND prodserv.categoria='$cat' ORDER BY prodserv_ordem.id ASC LIMIT $param, $maxpag");
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
	
?>
  <table width="642" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
<tr align="left" class="textoboldbranco">
        <td colspan="8">&nbsp;          <?= $catr["texto"]; ?></td>
        </tr>
      <tr class="textoboldbranco">
        <td width="55" align="left">&nbsp;&nbsp;Compra</td>
        <td width="50" align="left">Pedido</td>
        <td width="340">&nbsp;Produto</td>
        <td width="77" align="center">Status</td>
        <td width="49" align="center">&nbsp;Qtd</td>
        <td width="19" align="center">&nbsp;</td>
        <td width="21" align="center">&nbsp;</td>
        <td width="22" align="center">&nbsp;</td>
      </tr>
	  <?
	  
	  while($res=mysql_fetch_array($sql)){
		$reg_final++; // PAGINACAO conta quantos registros imprimiu
		$sql2=mysql_query("SELECT nome FROM prodserv WHERE id='$res[prodserv]'");
		$res2=mysql_fetch_array($sql2);
		if($res["sit"]=="A"){
			$walt="#\" onClick=\"window.open('prodserv_ordem_baixa.php?acao=entrar&id=$res[idd]&ped=$res[pedido]','','scrollbars=yes,width=730,height=500');";
		}else{
			$walt="#\" onclick=\"return mensagem('Esta Ordem de Produção já foi finalizada');";
		}
		$st="";
		switch($res["status"]){
			case "1";
				$st="Na fila";
				break;
			case "2";
				$st="Em produção";
				break;
			case "3";
				$st="Produzido";
				break;
		}
		
		?>
      <tr bgcolor="#FFFFFF" class="texto">
        <td align="left"><? print $res["compra"]; ?></td>
        <td align="left"><? print $res["pedido"]; ?></td>
        <td width="340">&nbsp;<? print $res2["nome"]; ?></td>
        <td align="center">&nbsp;<?= $st; ?></td>
        <td align="center"><? print banco2valor($res["qtd"]); ?></td>
        <td align="center"><a href="prodserv_ordem_abre.php?acao=alt&id=<? print $res["idd"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
        <td width="21" align="center"><a href="#" onClick="window.open('prodserv_ordem_imp.php?id=<? print $res["idd"]; ?>','','scrollbars=yes,width=730,height=500');"><img src="imagens/icon14_imp.gif" alt="Visualizar" width="15" height="15" border="0"></a></td>
        <td width="22" align="center"><a href="<? print $walt; ?>"><img src="imagens/icon14_baixar.gif" alt="Alterar" width="16" height="16" border="0"></a></td>
      </tr>
      <?
	} ?>
</table>
<br>
<?
} }
?>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top"><? if($wpaginar) { ?>
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
                    <a href="<? print "prodserv_ordem.php?wp=$pg_anterior&bde=$bde&bate=$bate&item=$item"; ?>" class="paginacao2">
                    <? } ?>
                    <img src="imagens/pag_f.gif" border="0">
                    <? if($antz){ ?>
                    <br>
                Anterior</a>
                    <? } ?>
                  </td>
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
                    <a href="<? print "prodserv_ordem.php?wp=$link_impressos&bde=$bde&bate=$bate&item=$item"; ?>" class="paginacao">
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
                    <a href="<? print "prodserv_ordem.php?wp=$pg_proxima&bde=$bde&bate=$bate&item=$item"; ?>" class="paginacao2">
                    <? } ?>
                    <img src="imagens/pag_der.gif" border="0">
                    <? if($reg_final<$results_tot){ ?>
                    <br>
                Pr&oacute;ximo</a>
                    <? } ?>
                  </td>
                </tr>
            </table></td>
          </tr>
        </table>
        <? } ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>