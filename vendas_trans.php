<?php
include("conecta.php");
if($buscar){
	unset($wp);
}
if(empty($acao)) $acao="entrar";
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO transportadora (cod_transport,nome,razao,cnpj,ie,endereco,complemento,cep,bairro,cidade,uf,contato,telefone,fax,celular,email,contato2,fax2,tel2,celular2,email2,site,coleta,end_entrega,bairro_entrega,cid_entrega,est_entrega,reg_atuante,est_atuante,temp_col) VALUES ('$cod_transport','$nome','$razao','$cnpj','$ie','$endereco','$complemento','$cep','$bairro','$cidade','$uf','$contato','$telefone','$fax','$celular','$email','$contato2','$fax2','$tel2','$celular2','$email2','$site','$coleta','$end_entrega','$bairro_entrega','$cid_entrega','$est_entrega','$reg_atuante','$est_atuante','$temp_col')");
	
	if($sql){
		$_SESSION["mensagem"]="Transportadora incluída com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="A Transportadora não pôde ser incluída!";
		$acao="inc";
	}
}
if(!empty($bcli)){
	$busca="WHERE nome LIKE '%$bcli%'";
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
function seleciona(id,nome){
	opener.form1.transp.value=nome;
	opener.form1.transportadora.value=id;
	window.close();
}
windowWidth=320;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
</script>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
if($acao=="entrar"){
?>
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
    <td align="center"><a href="vendas_trans.php?acao=inc" class="textobold">Incluir</a>
      <table width="300" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
          <tr class="textoboldbranco"> 
            <td width="277">&nbsp;Transportadora</td>
            <td width="20" align="center">&nbsp;</td>
          </tr>
		<?php
		$sql=mysql_query("SELECT * FROM transportadora $busca ORDER BY nome ASC");
		if(mysql_num_rows($sql)==0){
		?>
          <tr bgcolor="#FFFFFF" class="texto"> 
            <td colspan="2" align="center">NENHUMA TRANSPORTADORA ENCONTRADA</td>
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
				$sql=mysql_query("SELECT * FROM transportadora $busca ORDER BY nome ASC LIMIT $param, $maxpag");
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
		  <tr bgcolor="#FFFFFF" class="texto"> 
            <td>&nbsp;<?php print $res["nome"]; ?></td>
            <td width="20" align="center"><a href="#" onClick="return seleciona('<?php print $res["id"]; ?>','<?php print $res["nome"]; ?>');"><img src="imagens/icon_14_use.gif" alt="Selecionar" width="14" height="14" border="0"></a></td>
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
                  <a href="<?php print "vendas_trans.php?wp=$pg_anterior&bcli=$bcli"; ?>" class="paginacao2"> 
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
                  <a href="<?php print "vendas_trans.php?wp=$link_impressos&bcli=$bcli"; ?>" class="paginacao"> 
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
                  <a href="<?php print "vendas_trans.php?wp=$pg_proxima&bcli=$bcli"; ?>" class="paginacao2"> 
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
<form action="" method="post" name="form1" onSubmit="return verifica(form1);">
        <table width="300" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#003366">
            <td colspan="2" align="center" class="textoboldbranco">
              Incluir</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Cod. Interno</td>
            <td class="textobold"><input name="cod_transport" type="text" class="formularioselect" id="cod_transport" value="<?php print $res["id"]; ?>" size="45" maxlength="50" readonly=""></td>
          </tr>
          <tr>
            <td width="107" align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Fantasia:</td>
            <td width="293" class="textobold"><input name="nome" type="text" class="formularioselect" value="<?php print $res["nome"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Raz&atilde;o Social: </td>
            <td class="textobold"><input name="razao" type="text" class="formularioselect" id="nome3" value="<?php print $res["razao"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;CNPJ:</td>
            <td class="textobold"><input name="cnpj" type="text" class="formularioselect" id="nome4" value="<?php print $res["cnpj"]; ?>" size="45" maxlength="20" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;IE:</td>
            <td class="textobold"><input name="ie" type="text" class="formularioselect" id="nome5" value="<?php print $res["ie"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Endere&ccedil;o:</td>
            <td class="textobold"><input name="endereco" type="text" class="formularioselect" id="nome6" value="<?php print $res["endereco"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Complemento</td>
            <td class="textobold"><input name="complemento" type="text" class="formularioselect" id="complemento" value="<?php print $res["complemento"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;CEP:</td>
            <td class="textobold"><input name="cep" type="text" class="formularioselect" id="nome7" value="<?php print $res["cep"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Bairro:</td>
            <td class="textobold"><input name="bairro" type="text" class="formularioselect" id="nome8" value="<?php print $res["bairro"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;UF:</td>
            <td align="left" class="textobold"><span class="texto">
              <select name="uf" id="uf"  class="formulario">
                <option>Selecione</option>
                <?php
	$sql2=mysql_query("SELECT * FROM estado") or erp_db_fail();
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?php echo  $res2["id"]; ?>" <?php if($res2["id"]==$res["uf"]){ print "selected"; } ?>>
                <?php echo  $res2["nome"]; ?>
                </option>
                <?php } ?>
              </select>
            </span></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Cidade:</td>
            <td align="left" class="textobold"><input name="cidade" type="text" class="formulario" id="cidade" value="<?php print $cidade; ?>" size="50" maxlength="30">          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textoboldwhite">
              <p class="textobold">&nbsp;Telefone 1 :</p></td>
            <td align="left" class="textobold"><input name="telefone" type="text" class="formularioselect" id="nome11" value="<?php print $res["telefone"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Regi&atilde;o atuante:</td>
            <td align="left" class="textobold"><input name="reg_atuante" type="text" class="formularioselect" id="reg_atuante" value="<?php print $res["reg_atuante"]; ?>" size="45" maxlength="50"></td>
          </tr>
          <tr align="center">
            <td align="left" bgcolor="#FFFFFF" class="textobold">&nbsp;Estados atuantes: </td>
            <td align="left" class="textobold"><span class="texto"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
              <select name="est_atuante" id="select2" class="formulario">
                <option>Selecione</option>
                <?php
	$sql2=mysql_query("SELECT * FROM estado") or erp_db_fail();
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?php echo  $res2["id"]; ?>" <?php if($res2["id"]==$res["est_atuante"]){ print "selected"; } ?>>
                <?php echo  $res2["nome"]; ?>
                </option>
                <?php } ?>
              </select>
            </font></span></td>
          </tr>
          <tr align="center">
            <td colspan="2" class="textobold">
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='transp_incluir.php'">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Submit2" type="submit" class="microtxt" value="Continuar">
              <input name="acao" type="hidden" id="acao" value="<?php if($acao=="alt"){ print "alt"; }else{ print "incluir"; } ?>"></td>
          </tr>
        </table>
</form>
<?php } ?>
</body>
</html>