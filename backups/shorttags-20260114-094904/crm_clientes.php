<?
include("conecta.php");
include("seguranca.php");
$nivel=$_SESSION["login_nivel"];
if(!empty($acao)){
	$loc="Clientes";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($buscar){
	unset($wp);
}
//QUERYY
if(!empty($proposta)){
	$query="SELECT DISTINCT(clientes.id),clientes.nome FROM clientes,vendas_orcamento,vendas_orcamento_list,prodserv WHERE vendas_orcamento.cliente=clientes.id AND vendas_orcamento_list.orcamento=vendas_orcamento.id AND vendas_orcamento_list.produto=prodserv.id AND prodserv.ecat='$proposta'";
}else if(!empty($comprado)){
	$query="SELECT DISTINCT(clientes.id),clientes.nome FROM clientes,vendas,vendas_list,prodserv WHERE vendas.cliente=clientes.id AND vendas_list.venda=vendas.id AND vendas_list.produto=prodserv.id AND prodserv.ecat='$comprado'";
}else if(!empty($compra)){
	$dt=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-$compra,date("Y")));
	$query="SELECT clientes.* FROM e_compra,clientes WHERE e_compra.cliente=clientes.id AND e_compra.data<'$dt' AND e_compra.data<>'0000-00-00'";
}else{
	$query="SELECT * FROM clientes WHERE 1";
}
if(!empty($codigo)){
	$query.=" AND clientes.id='$codigo'";
}
if(!empty($sit)){
	$query.=" AND clientes.status='$sit'";
}
if(!empty($razao)){
	$query.=" AND clientes.nome like '%$razao%'";
}
if(!empty($nome)){
	$query.=" AND clientes.fantasia like '%$nome%'";
}
if(!empty($loja)){
	$query.=" AND clientes.loja like '%$loja%'";
}
if(!empty($cnpj)){
	$query.=" AND clientes.cnpj like '%$cnpj%'";
}
if(!empty($cidade)){
	$query.=" AND clientes.cidade like '%$cidade%'";
}
if(!empty($endereco)){
	$query.=" AND clientes.endereco like '%$endereco%'";
}
if(!empty($bairro)){
	$query.=" AND clientes.bairro like '%$bairro%'";
}
if(!empty($estado)){
	$query.=" and clientes.estado='$estado'";
}
if(!empty($porte)){
	$query.=" and (clientes.porte_che='$porte' or clientes.porte_fun='$porte' or clientes.porte_fat='$porte')";
}
if(!empty($vendedor)){
	$query.=" and clientes.vendedor='$vendedor'";
}
if(!empty($grupo)){
	$query.=" and clientes.grupo='$grupo'";
}
if(!empty($ramo)){
	$query.=" and clientes.ramo='$ramo'";
}
if(!empty($nome)){
	$query.=" and clientes.fantasia like '%$nome%'";
}
if(!empty($origem)){
	$query.=" and clientes.origem_cad='$origem'";
}
if(!empty($atualizacao)){
	$dt=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-$atualizacao,date("Y")));
	$query.=" and clientes.atualizacao<'$dt' AND clientes.atualizacao<>'0000-00-00'";
}
if(!empty($followup)){
	$dataf=data2banco($followup);
	//$dt=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-$followup,date("Y")));
	$query="SELECT DISTINCT(clientes.id),clientes.nome FROM clientes,followup WHERE clientes.id=followup.cliente AND followup.data='$dataf' AND followup.data<>'0000-00-00'";
}
if(!empty($vendedor)){
	$query.=" AND followup.vendedor='$vendedor'";
}
if($acao=="exc"){
	$sql=mysql_query("SELECT * FROM analises WHERE cliente='$id'");
	if(mysql_num_rows($sql)==0){
		$sql=mysql_query("DELETE FROM cliente_cobranca WHERE cliente='$id'");
		if($sql){
			$sql=mysql_query("DELETE FROM cliente_entrega WHERE cliente='$id'");
			if($sql){
				$sql=mysql_query("DELETE FROM cliente_financeiro WHERE cliente='$id'");
				if($sql){
					$sql=mysql_query("DELETE FROM cliente_login WHERE cliente='$id'");
					if($sql){
						$sql=mysql_query("DELETE FROM clientes WHERE id='$id'");
					}else{
						$err=true;
					}
				}else{
					$err=true;
				}
			}else{
				$err=true;
			}
		}else{
			$err=true;
		}
	}else{
		$err=true;
	}
	if(!$err){
		$_SESSION["mensagem"]="Cliente excluído com sucesso!";
	}else{
		$_SESSION["mensagem"]="O cliente não pôde ser excluído!";
	}
}
?>
<html>
<head>
<title>CyberManager</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
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
          <td> <form name="form1" method="get" action="">
		  <table width="591" border="0" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
            <td width="564" align="right"><div align="left"><span class="textobold style1 style1">Clientes</span></div></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
      </table>
              <table width="400" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">BUSCA</td>
                </tr>
                <tr class="textobold">
                  <td>C&oacute;digo:</td>
                  <td><input name="codigo" type="text" class="formulario" id="codigo" size="5"></td>
                </tr>
                <tr class="textobold">
                  <td>Raz&atilde;o Social: </td>
                  <td><input name="razao" type="text" class="formularioselect" id="razao" size="36"></td>
                </tr>
                <tr class="textobold"> 
                  <td>Nome Fantasia:</td>
                  <td><input name="nome" type="text" class="formularioselect" id="nome" size="36"></td>
                </tr>
                <tr class="textobold">
                  <td>Porte:</td>
                  <td><select name="porte" class="textobold" id="porte">
                      <option value="" selected="selected">Selecione</option>
						<option value="1">Pequeno</option>
						<option value="2">Médio</option>
						<option value="3">Grande</option>
                  </select></td>
                </tr>
                <tr class="textobold"> 
                  <td width="151">Matriz/Filial:</td>
                  <td width="249"><select name="grupo" class="textobold" id="select2">
                    <option value="" selected="selected">Selecione</option>
                    <? $sql=mysql_query("select * from grupos");
			while($res=mysql_fetch_array($sql)){
			 ?>
                    <option value="<?= $res["id"]; ?>">
                      <?= $res["nome"]; ?>
                      </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr class="textobold">
                  <td>Ramo:</td>
                  <td><select name="ramo" class="textobold" id="select3">
                    <option value="" selected="selected">Selecione</option>
                    <? $sql=mysql_query("select * from ramo");
			while($res=mysql_fetch_array($sql)){
			 ?>
                    <option value="<?= $res["id"]; ?>">
                    <?= $res["nome"]; ?>
                    </option>
                    <? } ?>
                  </select></td>
                </tr>
                <tr class="textobold">
                  <td>Loja:</td>
                  <td><input name="loja" type="text" class="formularioselect" id="cnpj" size="36"></td>
                </tr>
                <tr class="textobold">
                  <td>CNPJ:</td>
                  <td><input name="cnpj" type="text" class="formularioselect" id="cnpj" size="36"></td>
                </tr>
                
                <tr class="textobold">
                  <td>Estado:</td>
                  <td><span class="texto">
                    <select name="estado" id="estado" class="formulario">
                      <option value="">Selecione</option>
                      <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                      <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$estado){ print "selected"; } ?>>
                      <?= $res2["nome"]; ?>
                      </option>
                      <? } ?>
                    </select>
                  </span></td>
                </tr>
                <tr class="textobold">
                  <td>Endere&ccedil;o:</td>
                  <td><input name="endereco" type="text" class="formularioselect" id="endereco" size="36"></td>
                </tr>
                <tr class="textobold">
                  <td>Bairro:</td>
                  <td><input name="bairro" type="text" class="formularioselect" id="bairro" size="36"></td>
                </tr>
                <tr class="textobold">
                  <td>Cidade:</td>
                  <td><input name="cidade" type="text" class="formularioselect" id="cidade" size="36"></td>
                </tr>
                <tr class="textobold">
                  <td>Situa&ccedil;&atilde;o:</td>
                  <td><select name="sit" class="textobold" id="sit">
                      <option value="" selected="selected">Selecione</option>
                      <option value="A">Ativo</option>
                      <option value="I">Inativo</option>
                      <option value="P">Prospect</option>
                  </select></td>
                </tr>
                <tr class="textobold">
                  <td>Origem:</td>
                  <td><select name="origem" class="textobold" id="origem">
                      <option selected="selected" value="">Selecione</option>
                      <option value="mkr" <? if($origem=="mkr"){ print "selected"; } ?>>MKR</option>
                      <option value="site" <? if($origem=="site"){ print "selected"; } ?>>Site</option>
                      <option value="ativo" <? if($origem=="ativo"){ print "selected"; } ?>>Ativo</option>
                      <option value="Receptivo" <? if($origem=="receptivo"){ print "selected"; } ?>>Receptivo</option>
                      <option value="bd" <? if($origem=="bd"){ print "selected"; } ?>>BD Externo</option>
                      <option value="Representante" <? if($origem=="representante"){ print "selected"; } ?>>Representante</option>
                    </select></td>
                </tr>
                
                <tr class="textobold">
                  <td>&Uacute;lt. compra a mais de:</td>
                  <td><input type="text" value="" onKeyPress="return validanum(this, event)" maxlength="10" size="10" name="compra" onChange="form1.proposta.value='';form1.comprado.value='';"></td>
                </tr>
                <tr class="textobold">
                  <td>&Uacute;lt. atualiza&ccedil;&atilde;o a mais de:</td>
                  <td><input type="text" value="" onKeyPress="return validanum(this, event)" maxlength="10" size="10" name="atualizacao" onChange="form1.proposta.value='';form1.comprado.value='';"></td>
                </tr>
                <tr class="textobold">
                  <td> Follow-up do dia: </td>
                  <td><input type="text" value="" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" maxlength="10" size="10" name="followup" onChange="form1.proposta.value='';form1.comprado.value='';"> &nbsp;
                    <select name="vendedor" class="formulario" id="vendedor">
                      <option value="" selected>Selecione</option>
                      <?
$sqlv=mysql_query("SELECT c.fantasia,c.id FROM clientes AS c, cliente_login AS cl, niveis AS n WHERE cl.nivel=n.id AND n.vendedor=1 AND cl.cliente=c.id ORDER BY c.fantasia ASC");
if(mysql_num_rows($sqlv)){
	while($resv=mysql_fetch_array($sqlv)){
?>
                      <option value="<?= $resv["id"]; ?>" <? if($resv["id"]==$res["vendedor"]) print "selected"; ?>><?= $resv["fantasia"]; ?></option>
                      <?
	}
}
?>
                    </select></td>
                </tr>
                
                <tr class="textobold">
                  <td>Tiveram Produto com proposta: </td>
                  <td><select name="proposta" class="formularioselect" id="proposta" onChange="form1.comprado.value='';form1.compra.value='';">
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
$w=$res["ecat"];
no(0,$w);
?>
                  </select></td>
                </tr>
                <tr class="textobold">
                  <td>Tiveram Produto Comprado: </td>
                  <td><select name="comprado" class="formularioselect" id="comprado" onChange="form1.proposta.value='';form1.compra.value='';">
				   <option value="">Selecione</option>
                    <?
$w=$res["ecat"];
no(0,$w);
?>
                  </select></td>
                </tr>
                <tr class="textobold">
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
                <tr class="textobold">
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr class="textobold">
                  <td colspan="2" align="center"><input name="Submit" type="submit" class="microtxt" value="Buscar">
&nbsp;
<input name="buscar" type="hidden" id="buscar" value="true"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr> 
          <td><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="51" align="center">C&oacute;d</td>
                <td width="345">&nbsp;Nome</td>
                <td width="194">Loja</td>
                <? if($nivel=="1"){ ?>  <? } ?>
              </tr>
              <?
			  $sql=mysql_query($query);
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="texto"> 
                <td colspan="3" align="center" class="textobold">NENHUM CLIENTE 
                  ENCONTRADO </td>
              </tr>
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
					$query.=" ORDER BY nome ASC LIMIT $param, $maxpag";
					$sql=mysql_query($query);
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
              <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')"> 
			  <a href="crm_infg.php?cli=<? print $res["id"]; ?>" class="textobold">
                <td align="center"><? print $res["id"]; ?></td>
                <td>&nbsp;<? print $res["nome"];  ?></td>
			    <td><? print $res["loja"];  ?></td>
			  </a>              </tr>
              <?
			  	}
			  }
			  ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <? if($wpaginar){ ?>
  <tr>
    <td colspan="3"><img src="imagens/dot.gif" width="200" height="10"></td>
  </tr>
  <tr> 
    <td align="center"> <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top"> 
          <td align="right"> 
            <? 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
            <a href="<? print "crm_clientes.php?wp=$pg_anterior&nome=$nome&razao=$razao&porte=$porte&grupo=$grupo&ramo=$ramo&cnpj=$cnpj&bairro=$bairro&estado=$estado&cidade=$cidade&compra=$compra&atualizacao=$atualizacao&followup=$followup&proposta=$proposta&comprado=$comprado&vendedor=$vendedor&origem=$origem&endereco=$endereco"; ?>" class="paginacao2"> 
            <? } ?>
            <img src="imagens/pag_f.gif" width="27" height="14" border="0"> 
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
            <a href="<? print "crm_clientes.php?wp=$link_impressos&nome=$nome&razao=$razao&porte=$porte&grupo=$grupo&ramo=$ramo&cnpj=$cnpj&bairro=$bairro&estado=$estado&cidade=$cidade&compra=$compra&atualizacao=$atualizacao&followup=$followup&proposta=$proposta&comprado=$comprado&vendedor=$vendedor&origem=$origem&endereco=$endereco"; ?>" class="paginacao"> 
            <? } ?>
            <img src="imagens/pag_e<? if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
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
            <a href="<? print "crm_clientes.php?wp=$pg_proxima&nome=$nome&razao=$razao&porte=$porte&grupo=$grupo&ramo=$ramo&cnpj=$cnpj&bairro=$bairro&estado=$estado&cidade=$cidade&compra=$compra&atualizacao=$atualizacao&followup=$followup&proposta=$proposta&comprado=$comprado&vendedor=$vendedor&origem=$origem&endereco=$endereco"; ?>" class="paginacao2"> 
            <? } ?>
            <img src="imagens/pag_der.gif" width="26" height="14" border="0"> 
            <? if($reg_final<$results_tot){ ?>
            <br>
            Próximo</a>
            <? } ?>
          </td>
        </tr>
      </table></td>
  </tr>
  <? } ?>
</table>
</body>
</html>
<? include("mensagem.php"); ?>