<?
include("conecta.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Ordem Separação Imp.";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
$hj=date("Y-m-d");
if($acao=="baixa"){
	$sql=mysql_query("UPDATE prodserv_ordem,e_compra SET prodserv_ordem.sit='F',e_compra.sit='P' WHERE prodserv_ordem.id='$id' AND prodserv_ordem.compra=e_compra.id");
	$sql=mysql_query("UPDATE prodserv_sep_list,prodserv_ordem SET prodserv_sep_list.sit='3' WHERE prodserv_sep_list.pedido='$ped' AND prodserv_sep_list.prodserv=prodserv_ordem.prodserv");
						//baixa produzidos estoque
							$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
							$pror=mysql_fetch_array($pro);
								if($pror["tipo"]=="SM"){
									$dado=explode("X",$tamanho);
									$altura=$dado[0];
									$largura=$dado[1];
									$qtdit=$altura*$largura;
									$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,origem,tipomov) VALUES('$produto','$hj','$qtdit','2','2')");
								}else if($pror["tipo"]=="PL"){
									$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,origem,tipomov) VALUES('$produto','$hj','$qtdpl','2','2')");
								}
							// Baixaaaaaaa cortina e portas		
								if(!empty($pror["porta"])){
										if(!empty($item)){
											foreach($item as $key=>$value){
												$valor=valor2banco($value);
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$key','$hj','$valor','2','6')");
											}
										}
										$sqlp=mysql_query("SELECT * FROM portasp WHERE id='$pror[porta]'");
										$resp=mysql_fetch_array($sqlp);
											$csid=$resp["pvc_superior"];
											$ciid=$resp["pvc_inferior"];
											$crid=$resp["pvc_cristal"];
										$sqlp2=mysql_query("SELECT * FROM perfil WHERE id='$resp[perfil]'");
										$resp2=mysql_fetch_array($sqlp2);
											$perfilid=$resp2["perfil"];
											
											$cs=valor2banco($cs);
											$ci=valor2banco($ci);
											$cr=valor2banco($cr);
											$perfil=valor2banco($perfil);
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$csid','$hj','$cs','2','6')");
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$ciid','$hj','$ci','2','6')");
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$crid','$hj','$cr','2','6')");
											$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$perfilid','$hj','$perfil','2','6')");
													
								}else if(!empty($pror["cortina"])){
										if(!empty($item)){
											foreach($item as $key=>$value){
												$valor=valor2banco($value);
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$key','$hj','$valor','2','6')");
											}
										}
									$sqlp=mysql_query("SELECT * FROM cortinas WHERE id='$pror[cortina]'");
									$resp=mysql_fetch_array($sqlp);
										//Ids do prodserv de cada item
										$trilho1=$resp["trilho"];
										$pvc1=$resp["pvc"];
										$arrebites1=$resp["arrebites"];
										$parafusos1=$resp["parafusos"];
										$buchas1=$resp["buchas"];
										$penduralg1=$resp["penduralg"];
										$penduralp1=$resp["penduralp"];
										
										$trilho=valor2banco($trilho);
										$pvc=valor2banco($pvc);
										$arrebites=valor2banco($arrebites);
										$parafusos=valor2banco($parafusos);
										$buchas=valor2banco($buchas);
										$penduralg=valor2banco($penduralg);
										$penduralp=valor2banco($penduralp);

												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$trilho1','$hj','$trilho','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$pvc1','$hj','$pvc','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$arrebites1','$hj','$arrebites','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$parafusos1','$hj','$parafusos','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$buchas1','$hj','$buchas','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$penduralg1','$hj','$penduralg','2','6')");
												$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$penduralp1','$hj','$penduralp','2','6')");
									//Fim Cortina
							}
	if($sql){
		$_SESSION["mensagem"]="Baixa com Sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="Não pode ser dado Baixa!";
	}
	print "<script>opener.location='prodserv_ordem.php';window.close();</script>";
}

$sql=mysql_query("SELECT * FROM prodserv_ordem WHERE id='$id'");
$res=mysql_fetch_array($sql);
$prodid=$res["prodserv"];
$tamanho=$res["tamanho"];
$qtdpl=$res["qtd"];
$sql2=mysql_query("SELECT * FROM e_compra WHERE id='$res[compra]'");
	$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$res[prodserv]'");
$res2=mysql_fetch_array($sql2);
	$res3=mysql_fetch_array($sql3);

?>
<html>
<head>
<title>Ordem Produ&ccedil;&atilde;o</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width="700" border="0" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td width="700" align="center" class="titulos"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" align="center"><img src="imagens/logoesi.gif" width="52" height="53"></td>
        <td width="73%" align="left" class="titulos">Baixa Ordem de Produ&ccedil;&atilde;o </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulos">&nbsp;</td>
  </tr>
  <tr align="left">
    <td><form name="form1" method="post" action="">
	<? if(empty($res3["porta"]) and empty($res3["cortina"])){ ?>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="61">&nbsp;C&oacute;digo</td>
          <td width="212"> Descri&ccedil;&atilde;o </td>
          <td width="75" align="left">Tamanho</td>
          <td width="38" align="left">Qtde</td>
          <td width="38" align="left">Un</td>
          <td width="134" align="left">Material</td>
          <td width="134" align="left">Fixa&ccedil;&atilde;o</td>
        </tr>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td>&nbsp;<? print $res3["codprod"]; ?></td>
          <td>&nbsp;<? print $res3["nome"]; ?></td>
          <td align="left">&nbsp;<? print $res["tamanho"]; ?></td>
          <td width="38" align="left">&nbsp;<? print $res["qtd"]; ?></td>
          <td width="38" align="left">&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$res3[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?></td>
          <td width="134" align="left">&nbsp;<? print $res["material"]; ?></td>
          <td width="134" align="left">&nbsp;<? print $res["fixacao"]; ?></td>
        </tr>
      </table>
      <? }else if(!empty($res3["porta"])){ ?>
      <br>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="114" align="left">C&oacute;digo</td>
          <td width="332" align="left">Descri&ccedil;&atilde;o</td>
          <td width="83">&nbsp;Unidade</td>
          <td width="51"> Qtd </td>
          <td width="114" align="center">Qtd utilizada </td>
        </tr>
        <? 
		//Porta, calculo
		$dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1];
			$sqlp=mysql_query("SELECT * FROM portasp WHERE id='$res3[porta]'");
			$resp=mysql_fetch_array($sqlp);
				$porta=$res3[porta];
				$csid=$resp["pvc_superior"];
				$ciid=$resp["pvc_inferior"];
				$crid=$resp["pvc_cristal"];
			
			$sqlp2=mysql_query("SELECT * FROM perfil WHERE id='$resp[perfil]'");
			$resp2=mysql_fetch_array($sqlp2);
				$perfilid=$resp2["perfil"];

				$cs=pvccs($porta,$largura,$altura);
				$ci=pvcci($porta,$largura,$altura);
				$cr=pvccr($porta,$largura,$altura);
				$perfil=perfil($resp["perfil"],$largura,$altura);
		//
		$sqli=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$res[prodserv]'"); while($resi=mysql_fetch_array($sqli)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resi[item]'"); $resp=mysql_fetch_array($sqlp);
		 ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="332" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $resi["qtd"]*$res["qtd"]; ?></td>
          <td width="114" align="center"><input name="item[<?= $resp["id"]; ?>]" type="text" class="formularioselect" id="item" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($resi["qtd"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($cs)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$csid'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="332" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $cs*$res["qtd"]; ?></td>
          <td width="114" align="center"><input name="cs" type="text" class="formularioselect" id="cs" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($cs*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($ci)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$ciid'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="332" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $ci*$res["qtd"]; ?></td>
          <td width="114" align="center"><input name="ci" type="text" class="formularioselect" id="ci" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($ci*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($cr)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$crid'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="332" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $cr*$res["qtd"]; ?></td>
          <td width="114" align="center"><input name="cr" type="text" class="formularioselect" id="cr" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($cr*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($perfil)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$perfilid'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="332" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $perfil*$res["qtd"]; ?></td>
          <td width="114" align="center"><input name="perfil" type="text" class="formularioselect" id="perfil" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($perfil*$res["qtd"]); ?>"></td>
        </tr>
        <? } ?>
      </table>
      <? }else if(!empty($res3["cortina"])){ ?>
      <br>
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366">
        <tr class="textoboldbranco">
          <td width="114" align="left">C&oacute;digo</td>
          <td width="331" align="left">Descri&ccedil;&atilde;o</td>
          <td width="86">&nbsp;Unidade</td>
          <td width="51"> Qtd </td>
          <td width="112" align="center">Qtd utilizada</td>
        </tr>
        <? 
		//Porta, calculo
		$dado=explode("X",$res["tamanho"]);
		$altura=$dado[0];
		$largura=$dado[1];
			$sqlp=mysql_query("SELECT * FROM cortinas WHERE id='$res3[cortina]'");
			$resp=mysql_fetch_array($sqlp);
				$cortina=$res3[cortina];
				//Ids do prodserv de cada item
				$trilho=$resp["trilho"];
				$pvc=$resp["pvc"];
				$arrebites=$resp["arrebites"];
				$parafusos=$resp["parafusos"];
				$buchas=$resp["buchas"];
				$penduralg=$resp["penduralg"];
				$penduralp=$resp["penduralp"];
			
				$a=cortinas($largura,$altura);
		//
		$sqli=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$res[prodserv]'"); while($resi=mysql_fetch_array($sqli)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$resi[item]'"); $resp=mysql_fetch_array($sqlp);
		 ?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $resi["qtd"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="item[<?= $resp["id"]; ?>]2" type="text" class="formularioselect" id="item[<?= $resp["id"]; ?>]" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($resi["qtd"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($trilho)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$trilho'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $a["trilho"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="trilho" type="text" class="formularioselect" id="trilho" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($a["trilho"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($pvc)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$pvc'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;
              <?  print $resp["codprod"]; ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $a["pvc"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="pvc" type="text" class="formularioselect" id="pvc" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($a["pvc"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($arrebites)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$arrebites'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $a["arrebites"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="arrebites" type="text" class="formularioselect" id="arrebites" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($a["arrebites"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($parafusos)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$parafusos'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"]; ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $a["parafusos"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="parafusos" type="text" class="formularioselect" id="parafusos" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($a["parafusos"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($buchas)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$buchas'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"];  ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $a["buchas"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="buchas" type="text" class="formularioselect" id="buchas" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($a["buchas"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($penduralg)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$penduralg'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"];  ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $a["penduralg"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="penduralg" type="text" class="formularioselect" id="penduralg" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($a["penduralg"]*$res["qtd"]); ?>"></td>
        </tr>
        <?
		} if(!empty($penduralp)){
		$sqlp=mysql_query("SELECT * FROM prodserv WHERE id='$penduralp'"); $resp=mysql_fetch_array($sqlp);
		?>
        <tr bgcolor="#FFFFFF" class="texto" onMouseover="changeto('#CCCCCC')" onMouseout="changeback('#FFFFFF')">
          <td align="left">&nbsp;<? print $resp["codprod"];  ?></td>
          <td width="331" align="left">&nbsp;<? print $resp["nome"]; ?></td>
          <td>&nbsp;
              <? $sqlr=mysql_query("SELECT * FROM unidades WHERE id='$resp[unidade]'"); $resr=mysql_fetch_array($sqlr); print $resr["apelido"]; ?>
          </td>
          <td>&nbsp;<? print $a["penduralp"]*$res["qtd"]; ?></td>
          <td width="112" align="center"><input name="penduralp" type="text" class="formularioselect" id="penduralp" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<? print banco2valor($a["penduralp"]*$res["qtd"]); ?>"></td>
        </tr>
        <? } ?>
      </table>
      <? } ?>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><input name="id" type="hidden" id="id" value="<?= $id; ?>">
            <input name="acao" type="hidden" id="acao" value="baixa">
            <input name="ped" type="hidden" id="ped" value="<?= $ped; ?>">
            <input name="produto" type="hidden" id="produto" value="<?= $prodid; ?>">
            <input name="tamanho" type="hidden" id="tamanho" value="<?= $tamanho; ?>">
            <input name="qtdpl" type="hidden" id="qtdpl" value="<?= $qtdpl; ?>">
            <input name="Submit" type="submit" class="textobold" value="Baixar"></td>
          </tr>
        </table>
    </form>
    </td>
  </tr>
  <tr align="center">
    <td><a href="#"></a></td>
  </tr>
</table>
</body>
</html>
