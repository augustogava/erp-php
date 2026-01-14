<?php
include("conecta.php");
include("seguranca.php");
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

// query do followup
$sql_emp=mysql_query("SELECT fantasia FROM empresa");
$res_emp=mysql_fetch_array($sql_emp);
//

if($buscar){
	unset($wp);
}

if(!empty($bnome)){
	$cond=" WHERE metr_instr_desc like '%$bnome%'";
}
if(!empty($bcodi)){
	$cond= " WHERE metr_instr_codi like '%$bcodi%'";
}
if(!empty($bnome)&&!empty($bcodi)){
	$cond= " WHERE metr_instr_desc like '%$bnome%' AND metr_instr_codi like '%$bcodi%'";
}

if($acao=="exc"){
	$sql2=mysql_query("SELECT * FROM metrologia_instr WHERE metr_instr_id='$id'");
	$res2=mysql_fetch_array($sql2);
	$sql=mysql_query("DELETE FROM metrologia_instr WHERE metr_instr_id='$id'");
	// cria followup caso exclua o padrão
		mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Exclusão de Instrução.','O usuário $quem1 excluiu a Instrução $res2[metr_instr_desc].','$user')");
	//				
	header("Location:metr_instr_busca.php");
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
    <td width="446"><table width="498" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="498"> <form name="form1" method="post" action="">
		  <table width="434" border="0" cellpadding="0" cellspacing="0" class="textopreto">
          <tr>
            <td width="25" align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Grupos'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Em desenvolvimento')"><span class="impTextoBold">&nbsp;</span></div></td>
            <td width="363" align="right"><div align="left" class="titulos">Metrologia &gt; Instru&ccedil;&atilde;o &gt; Busca</div></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
      </table>
              <table width="239" border="0" cellspacing="3" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">BUSCA</td>
                </tr>
                <tr class="textobold">
                  <td width="79">Descri&ccedil;&atilde;o:</td>
                  <td width="148"><input name="bnome" type="text" class="formularioselect" id="bnome" size="26"></td>
                </tr>
                <tr class="textobold">
                  <td>C&oacute;d.:</td>
                  <td><input name="bcodi" type="text" class="formulario" id="bcodi" size="15" maxlength="15">
                    <img src="imagens/dot.gif" width="20" height="5">
                    <input name="imageField" type="image" src="imagens/icon_busca.gif" width="17" height="17" border="0">
                    <input name="buscar" type="hidden" id="buscar5" value="true"></td>
                </tr>
              </table>
          </form></td>
        </tr>
        <tr> 
          <td><table width="496" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
            <tr class="textobold">
              <td colspan="5" align="center" bgcolor="#FFFFFF" class="textobold"><a href="metr_instr_cad.php?acao=inc" class="textobold">Incluir Instru&ccedil;&atilde;o </a></td>
              </tr>
              <tr bgcolor="#003366" class="textoboldbranco"> 
                <td width="49" align="center">C&oacute;d</td>
                <td width="286">&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o </td>
                <td width="117"><div align="center">Tipo de Instru&ccedil;&atilde;o</div></td>
                <td width="19" align="center">&nbsp;</td>
                <td width="19" align="center">&nbsp;</td>
              </tr>
              <?php
			  $sql=mysql_query("SELECT * FROM metrologia_instr $cond ORDER BY metr_instr_desc ASC");
			  if(mysql_num_rows($sql)==0){
			  ?>
              <tr bgcolor="#FFFFFF" class="textopreto"> 
                <td colspan="5" align="center" class="textopretobold">NENHUMA INSTRU&Ccedil;&Atilde;O 
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
					$sql=mysql_query("SELECT * FROM metrologia_instr WHERE $cond ORDER BY metr_instr_desc ASC LIMIT $param, $maxpag");
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
                <td align="center"><?php print $res["metr_instr_codi"]; ?></td>
                <td>&nbsp;&nbsp;<?php print $res["metr_instr_desc"]; ?></td>
                <td>
                <div align="center"><?php if($res["metr_instr_tipo"]=="1"){ print Calibração; } else if($res["metr_instr_tipo"]=="2"){ print Utilização; } else if($res["metr_instr_tipo"]=="3"){ print MSA;}?></div></td>
                <td width="19" align="center"><a href="metr_instr_cad.php?acao=alt&id=<?php print $res["metr_instr_id"]; ?>"><img src="imagens/icon14_alterar.gif" alt="Alterar" width="14" height="14" border="0"></a></td>
                <td width="19" align="center"><a href="#" onClick="return pergunta('Deseja excluir este Padrão?','metr_instr_busca.php?acao=exc&id=<?php print $res["metr_instr_id"]; ?>')"><img src="imagens/icon14_lixeira.gif" alt="Excluir" width="14" height="14" border="0"></a></td>
              </tr>
              <?php
			  	}
			  }
			  ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <?php if($wpaginar){ ?>
  <tr>
    <td colspan="3"><img src="imagens/dot.gif" width="200" height="10"></td>
  </tr>
  <tr> 
    <td align="center"> <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top"> 
          <td align="right"> 
            <?php 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
            <a href="<?php print "metr_instr_busca.php?wp=$pg_anterior&bnome=$bnome&bcodi=$bcodi"; ?>" class="paginacao2"> 
            <?php } ?>
            <img src="imagens/pag_f.gif" width="27" height="14" border="0"> 
            <?php if($antz){ ?>
            <br>
            Anterior</a>
            <?php } ?>          </td>
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
            <a href="<?php print "metr_instr_busca.php?wp=$pg_anterior&bnome=$bnome&bcodi=$bcodi"; ?>" class="paginacao"> 
            <?php } ?>
            <img src="imagens/pag_e<?php if($pg_atual==$link_impressos) print "2"; ?>.gif" width="10" height="14" border="0"><br>
            <?php if($pg_atual==$link_impressos){ print "<span class=\"paginacao2\">$link_impressos</span>"; }else{ print $link_impressos; }?>
            <?php if($pg_atual != $link_impressos){ ?>
            </a>
            <?php } ?>          </td>
          <?php
				}
				?>
          <td> 
            <?php if($reg_final<$results_tot){ ?>
            <a href="<?php print "metr_instr_busca.php?wp=$pg_anterior&bnome=$bnome&bcodi=$bcodi"; ?>" class="paginacao2"> 
            <?php } ?>
            <img src="imagens/pag_der.gif" width="26" height="14" border="0"> 
            <?php if($reg_final<$results_tot){ ?>
            <br>
            Próximo</a>
            <?php } ?>          </td>
        </tr>
      </table></td>
  </tr>
    <?php } ?>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><span class="textobold">
      <input name="voltar" type="button" class="microtxt" value="Voltar" onClick="window.location='mana_metr.php';">
    </span></td>
  </tr>
</table>
</body>
</html>
<?php include("mensagem.php"); ?>