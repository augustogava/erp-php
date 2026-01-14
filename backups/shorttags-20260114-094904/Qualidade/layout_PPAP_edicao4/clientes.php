<?
include("conecta.php");
include("seguranca.php");
unset($_SESSION["mpc"]);
$nivel=$_SESSION["login_nivel"];
if(!empty($acao)){
	$loc="Clientes";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($buscar){
	unset($wp);
}
if(!empty($bnome) && empty($bfant) && empty($bcod)){
	$cond="WHERE nome like '%$bnome%'";
}
if(empty($bnome) && !empty($bfant) && empty($bcod)){
	$cond="WHERE fantasia like '%$bfant%'";
}
if(empty($bnome) && empty($bfant) && !empty($bcod)){
	$cond="WHERE id='$bcod'";
}
if(!empty($bnome) && !empty($bfant) && empty($bcod)){
	$cond="WHERE nome like '%$bnome%' AND fantasia like '%$bfant%'";
}
if(!empty($bnome) && empty($bfant) && !empty($bcod)){
	$cond="WHERE nome like '%$bnome%' AND id='$bcod'";
}
if(empty($bnome) && !empty($bfant) && !empty($bcod)){
	$cond="WHERE fantasia like '%$bfant%' AND id='$bcod'";
}
if(!empty($bnome) && !empty($bfant) && !empty($bcod)){
	$cond="WHERE nome like '%$bnome%' AND fantasia like '%$bfant%' AND id='$bcod'";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><table width="594" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> <form name="form1" method="post" action="">
		  <table width="591" border="0" cellpadding="0" cellspacing="0" class="textopreto">
          <tr>
            <td width="27" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome<br>Nascimento: xx/xx/xxxx<br>RG: xx.xxx.xxx-x<br>Cart. Profissional: xxxxx<br>Admiss&atilde;o: xx/xx/xxxx<br>Cargo: Escolha um item na lista')"><span class="impTextoBold">&nbsp;</span></div></td>
            <td width="564" align="right"><div align="left"><span class="textobold style1 style1">Clientes</span></div></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
      </table>
              <table width="250" border="0" cellspacing="3" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">BUSCA</td>
                </tr>
                <tr class="textobold"> 
                  <td>Nome:</td>
                  <td><input name="bnome" type="text" class="formularioselect" id="bnome"></td>
                </tr>
                <tr class="textobold">
                  <td>Fantasia:</td>
                  <td><input name="bfant" type="text" class="formularioselect" id="bfant"></td>
                </tr>
                <tr class="textobold"> 
                  <td width="54">C&oacute;digo:</td>
                  <td width="196"><input name="bcod" type="text" class="formulario" id="bcod" size="10">
                    <img src="imagens/dot.gif" width="20" height="5">
                    <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
                    <input name="buscar" type="hidden" id="buscar" value="true"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr> 
          <td><table width="594" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="39" align="center">C&oacute;d</td>
                <td width="414">&nbsp;Nome</td>
                <td width="19" align="center">&nbsp;</td>
                <td width="14" align="center">&nbsp;</td>
                <td width="30" align="center">&nbsp;</td>
                <td width="9" align="center">&nbsp;</td>
                <? if($nivel=="1"){ ?>  <td width="9" align="center">&nbsp;</td><? } ?>
                <td width="26" align="center">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM clientes $cond ORDER BY fantasia ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto"> 
                <td colspan="8" align="center" class="textopretobold">NENHUM CLIENTE 
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
					$sql=mysql_query("SELECT * FROM clientes $cond ORDER BY fantasia ASC LIMIT $param, $maxpag");
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
                <td align="center"><? print $res["id"]; ?></td>
                <td>&nbsp;<? print $res["nome"]; ?></td>
                <td align="center"><a href="clientes_geral.php?acao=alt&id=<? print $res["id"]; print "&bcod=$bcod&bnome=$bnome&bfant=$bfant";?>"><img src="imagens/icon_cli.gif" alt="Pessoal" width="18" height="18" border="0"></a></td>
                <td align="center"><a href="clientes_cobranca.php?id=<? print $res["id"]; print "&bcod=$bcod&bnome=$bnome&bfant=$bfant";?>"><img src="imagens/icon14_dollar.gif" alt="Cobran&ccedil;a" width="14" height="14" border="0"></a></td>
                <td align="center"><a href="clientes_entrega.php?id=<? print $res["id"]; print "&bcod=$bcod&bnome=$bnome&bfant=$bfant";?>"><img src="imagens/icon14_transp.gif" alt="Entrega" width="26" height="14" border="0"></a></td>
                <td align="center"><a href="clientes_financeiro.php?id=<? print $res["id"]; print "&bcod=$bcod&bnome=$bnome&bfant=$bfant";?>"><img src="imagens/icon14_finan.gif" alt="Financeiro" width="19" height="14" border="0"></a></td>
               <? if($nivel=="1"){ ?>
			    <td align="center"><a href="clientes_login.php?id=<? print $res["id"]; print "&bcod=$bcod&bnome=$bnome&bfant=$bfant";?>"><img src="imagens/icon14_key.gif" alt="Senha" width="24" height="14" border="0"></a></td>
				<? } ?>
                <td width="26" align="center"><a href="#" onClick="return pergunta('Deseja excluir este cliente?','clientes.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
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
            <a href="<? print "clientes.php?wp=$pg_anterior&bnome=$bnome&bcod=$bcod&bfant=$bfant"; ?>" class="paginacao2"> 
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
            <a href="<? print "clientes.php?wp=$link_impressos&bnome=$bnome&bcod=$bcod&bfant=$bfant"; ?>" class="paginacao"> 
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
            <a href="<? print "clientes.php?wp=$pg_proxima&bnome=$bnome&bcod=$bcod&bfant=$bfant"; ?>" class="paginacao2"> 
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