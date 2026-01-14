<?
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if($buscar){
	unset($wp);
}

if(!empty($bdescr)){
	$cond=" WHERE descr like '%$bdescr%'";
}

if(!empty($bfitn)){
	$cond=" WHERE fitn like '%$bfitn%'";
}

if(!empty($bdescr)&&!empty($bfitn)){
	$cond=" WHERE descr like '%$bdescr%' AND fitn like '%$bfitn%'";
}

if($acao=="exc"){
	mysql_query("DELETE FROM rec_plac WHERE id='$id'");
	mysql_query("DELETE FROM rec_rese WHERE cod_plac='$id'");
	// cria followup caso exclua 
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
		$res_emp=mysql_fetch_array($sql_emp);
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Plano de Controle do Recebimento.','O usuário $quem1 excluiu o Plano de Controle do Recebimento chamado $descricao e seus respectivos Ensaios.','$user')");
	//		
	header("Location:rec_plac.php");
	exit;
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
<table width="446" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="446"><table width="445" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="445"> <form name="form1" method="post" action="">
		  <table width="434" border="0" cellpadding="0" cellspacing="0" class="textopreto">
          <tr>
            <td width="25" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Grupos'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Em desenvolvimento')"><span class="impTextoBold">&nbsp;</span></div></td>
            <td width="363" align="right"><div align="left" class="titulos">Recebimento &gt;  Busca &gt; Plano de Controle </div></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
      </table>
              <table width="308" border="0" cellspacing="3" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">BUSCA</td>
                </tr>
                <tr class="textobold"> 
                  <td width="113">Descri&ccedil;&atilde;o:</td>
                  <td width="148"><input name="bdescr" type="text" class="formularioselect" id="bdescr" size="26"></td>
                </tr>
                <tr class="textobold">
                  <td>N&ordm; do Plano de Controle:</td>
                  <td><input name="bfitn" type="text" class="formulario" id="bfitn" size="15">&nbsp;<img src="imagens/dot.gif" width="20" height="5">
                    <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
                    <input name="buscar" type="hidden" id="buscar5" value="true"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr> 
          <td><table width="445" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
            <tr class="textobold">
              <td colspan="5" align="center" bgcolor="#FFFFFF" class="textobold"><a href="rec_plac_geral.php?acao=inc" class="textobold">Incluir Plano de Controle </a></td>
              </tr>
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="118" align="center">N&ordm; Plano de Controle </td>
                <td width="45"><div align="center">Rev</div></td>
                <td width="232" align="center"><div align="left">&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o</div></td>
                <td width="20" align="center">&nbsp;</td>
                <td width="24" align="center">&nbsp;</td>
              </tr>
              <?
			  $sql=mysql_query("SELECT * FROM rec_plac $cond ORDER BY fitn ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto"> 
                <td colspan="5" align="center" class="textopretobold">NENHUM PLANO DE CONTROLE 
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
					$sql=mysql_query("SELECT * FROM rec_plac $cond ORDER BY fitn ASC LIMIT $param, $maxpag");
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
                <td align="center"><? print $res["fitn"]; ?></td>
                <td><div align="center">
                  <?= $res["verf"];?>
                </div>                </td>
                <td align="left">
				&nbsp;
				<? 
				 print $res["descr"]; ?><? $descricao=$res["descr"]; ?></td>
                <td width="20" align="center"><a href="rec_plac_geral.php?acao=alt&id=<? print $res["id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="24" align="center"><a href="#" onClick="return pergunta('Deseja excluir este Plano de Controle?','rec_plac.php?acao=exc&id=<? print $res["id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
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
            <a href="<? print "rec_plac.php?wp=$pg_anterior&bdescr=$bdescr&bfitn=$bfitn"; ?>" class="paginacao2"> 
            <? } ?>
            <img src="imagens/pag_f.gif" width="27" height="14" border="0"> 
            <? if($antz){ ?>
            <br>
            Anterior</a>
            <? } ?>          </td>
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
            <a href="<? print "rec_plac.php?wp=$link_impressos&bdescr=$bdescr&bfitn=$bfitn"; ?>" class="paginacao"> 
            <? } ?>
            <img src="imagens/pag_e<? if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
            <? if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
            <? if($pg_atual != $link_impressos){ ?>
            </a>
            <? } ?>          </td>
          <?
				}
				?>
          <td> 
            <? if($reg_final<$results_tot){ ?>
            <a href="<? print "rec_plac.php?wp=$pg_proxima&bdescr=$bdescr&bfitn=$bfitn"; ?>" class="paginacao2"> 
            <? } ?>
            <img src="imagens/pag_der.gif" width="26" height="14" border="0"> 
            <? if($reg_final<$results_tot){ ?>
            <br>
            Próximo</a>
            <? } ?>          </td>
        </tr>
      </table></td>
  </tr>
    <? } ?>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><span class="textobold">
      <input name="voltar" type="button" class="microtxt" value="Voltar" onClick="window.location='mana_rece.php';">
    </span></td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>