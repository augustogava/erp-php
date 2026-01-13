<?
include("conecta.php");
$bd=new set_bd;
if(!isset($nf)) exit;
$hj=date("Y-m-d");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Notas Fiscais";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)) $acao="entrar";
if($acao=="imp"){
		$valu=$bd->pega_nome_bd2("nf","numero_nota",$nf);
		$sql=mysql_query("UPDATE vendas SET faturamento='1',nf='$valu' WHERE id='$id'");
		$sql=mysql_query("UPDATE e_compra SET sit='FF' WHERE id='$cp'");
	//------------- Tirar estoque Total --------------
						$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$id'") or die("Naun foi");
						while($res=mysql_fetch_array($sql2)){
							if(!empty($res["produto"])){
									mysql_query("UPDATE vendas_list SET qtd=qtde WHERE id='$res[id]'") or die("Erro qtd");
									$produto=$res["produto"];
									$pro=mysql_query("SELECT * FROM prodserv WHERE id='$produto'");
									$pror=mysql_fetch_array($pro);
								if(!($pror["tipo"]=="SM")){
									$qtd=$res["qtde"];
									$total=banco2valor($qtd*$res["unitario"]);
									$total=valor2banco($total);
									$unita=$res["unitario"];
										$sql1=mysql_query("SELECT SUM(qtde-qtds) AS qtdt FROM prodserv_est WHERE prodserv='$produto'") or die("Nao foi");
										$res1=mysql_fetch_array($sql1);
									if($res1["qtdt"]>0 and empty($pror["porta"]) and empty($pror["cortina"])){
										$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,origem,tipomov) VALUES('$produto','$hj','$qtd','$unita','2','6')");
									}
								}else{
									$dado=explode("X",$res["medidas"]);
									$altura=$dado[0];
									$largura=$dado[1];
									$qtdit=$altura*$largura;
									$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$produto','$hj','$qtdit','2','6')");
		if(!empty($pror["porta"])){
		//print "foi";
			$porta=$pror["porta"];
			//Medida
				$dado=explode("X",$res["medidas"]);
					$altura=$dado[0];
					$largura=$dado[1];
				$qtdti=$altura*$largura;
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$produto','$hj','$qtdti','2','6')");

			//Fim medida
			$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
			while($ress=mysql_fetch_array($sqls)){
				$tota+=$ress["val"]*$ress["qtd"];
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','6')");
			}
			$sql=mysql_query("SELECT * FROM portasp WHERE id='$porta'");
			$res=mysql_fetch_array($sql);
			$sql2=mysql_query("SELECT * FROM perfil WHERE id='$res[perfil]'");
			$res2=mysql_fetch_array($sql2);
				$cs=pvccs($porta,$largura,$altura);
				$ci=pvcci($porta,$largura,$altura);
				$cr=pvccr($porta,$largura,$altura);
				$perfil=perfil($res["perfil"],$largura,$altura);
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[pvc_superior]','$hj','$cs','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[pvc_inferior]','$hj','$ci','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[pvc_cristal]','$hj','$cr','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res2[perfil]','$hj','$perfil','2','6')");
		}
		// FIM
		//inserir ordem de producao para Cortinas
		if(!empty($pror["cortina"])){
		//print "foi";
			$cortina=$pror["cortina"];
			//Medida
				$dado=explode("X",$res["medidas"]);
					$altura=$dado[0];
					$largura=$dado[1];
				$qtdti=$altura*$largura;
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$produto','$hj','$qtdti','2','6')");

			//Fim medida
			$sqls=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$produto'");
			while($ress=mysql_fetch_array($sqls)){
				$tota+=$ress["val"]*$ress["qtd"];
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$ress[item]','$hj','$ress[qtd]','2','6')");
			}
			$sql=mysql_query("SELECT * FROM cortinas WHERE id='$cortina'");
			$res=mysql_fetch_array($sql);
			$a=cortinas($largura,$altura);
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[trilho]','$hj','$a[trilho]','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[pvc]','$hj','$a[pvc]','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[arrebites]','$hj','$a[arrebites]','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[parafusos]','$hj','$a[parafusos]','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[buchas]','$hj','$a[buchas]','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[penduralg]','$hj','$a[penduralg]','2','6')");
					$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,origem,tipomov) VALUES('$res[penduralp]','$hj','$a[penduralp]','2','6')");

				}
								}
						}
					}
			if($sql){
				$_SESSION["mensagem"]="Está em Faturamento!";
				$sql=mysql_query("UPDATE nf SET impresso='1' WHERE id='$nf'");
				print "<script>opener.location='nf.php';window.close();</script>";
				
			}else{
				$_SESSION["mensagem"]="Não pode ser imprimido!";
				$acao="inc";
			}
		
			
}
if($acao=="ge"){
	if($tipo=="laser"){
		print "<script>window.open('nf_vis_open.php?nf=$nf');</script>";
	}else{
		print "<script>window.open('nf_vis_open2.php?nf=$nf');</script>";
	}
	print "
	<script>
	if(confirm('Foi Impresso Corretamente?')){
		window.location.href = 'nf_vis.php?nf=$nf&acao=imp&id=$id&cp=$cp';
	}
	</script>";
}else if($acao=="atualizar"){
		$pass=true;
		$nna=mysql_query("SELECT * FROM nf WHERE numero='$numero_nota'");
		if(mysql_num_rows($nna) and ($nn!=$numero_nota)){
			$_SESSION["mensagem"]="Número da nota já existe!";
		}else{
			$sql=mysql_query("UPDATE nf SET numero='$numero_nota',numero_formulario='$numero_formulario',especie='$especie',quantidade='$quantidade',marca='$marca',placa='$placa',impresso='2',linha1='$linha1',linha2='$linha2',linha3='$linha3' WHERE id='$nf'") or die("nao foi");
		
			foreach($qtde as $key=>$value){
				if(!empty($value)){
					$sql2=mysql_query("SELECT * FROM vendas_list WHERE id='$key'"); $res2=mysql_fetch_array($sql2);
					$qtdn=$res2["qtd"]-$value;
					if($qtdn>=0){
						$sql=mysql_query("SELECT SUM(qtde-qtds) AS qtdd FROM prodserv_est WHERE prodserv='$res2[produto]'");
						$qtd1=mysql_fetch_array($sql); 
						if($qtd1["qtdd"]>=$value){
							$sql3=mysql_query("UPDATE vendas_list SET qtde='$value',qtd='$qtdn' WHERE id='$key'");		
							$sql=mysql_query("UPDATE nf SET abrir='S' WHERE id='$nf'") or die("nao foi");
						}else{
							$pass=false;
							//tirar quano marco pedir
							$sql3=mysql_query("UPDATE vendas_list SET qtde='$value',qtd='$qtdn' WHERE id='$key'");			
							// / / / / / / / / / * * * / / / / / / / / / 
							$sql=mysql_query("UPDATE nf SET abrir='N' WHERE id='$nf'") or die("nao foi");
						}
						$_SESSION["mensagem"]="Salvo com sucesso!!!";
					}else{
						$_SESSION["mensagem"]="Quantidade Entregue superou a do estoque!";
					}	
				}
				$impa=$imp[$key];
				$sql3=mysql_query("UPDATE vendas_list SET imp='$impa' WHERE id='$key'");
			}
		}
}

$sql=mysql_query("SELECT * FROM nf WHERE id='$nf'");
if(!mysql_num_rows($sql)) exit;
$res=mysql_fetch_array($sql);
if($res["cliente_tipo"]=="C"){
	$res["cliente_tipo"]="clientes";
}else{
	$res["cliente_tipo"]="fornecedores";
}

$sql2=mysql_query("SELECT fantasia,estado FROM $res[cliente_tipo] WHERE id='$res[cliente]'");
$res2=mysql_fetch_array($sql2);
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script language="JavaScript">
<!--
function selecionatodos(j){
	for(i=1;i<=j;i++){
		document.all['imp'+i].checked=true;
	}
}
function desmarcatodos(j){
	for(i=1;i<=j;i++){
		document.all['impa'+i].checked=true;
	}
}
function imprimir(id,cp,nf){
	if(confirm('Foi impresso corretamente?')){
		window.location='nf_vis.php?acao=imp&id=' + id + '&cp=' + cp + '&nf=' + nf;
	}
	return false;
}
windowWidth=680;
windowHeight=500;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body background="imagens/mdagua.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="650" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr class="textobold">
    <td class="titulos"><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_estudo_capabi.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver="this.T_STICKY=true; this.T_TITLE='Estudo de Capabilidade'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('<strong>Caracter&iacute;stica - </strong>Caracter&iacute;stica da pe&ccedil;a a ser estudada.<br><strong>Especifica&ccedil;&atilde;o - </strong>Forma ou medida para ser seguida.<br><strong>Realizado por - </strong>Nome do respons&aacute;vel pelo estudo de R&R.<br><strong>Opera&ccedil;&atilde;o - </strong>Opera&ccedil;&atilde;o da manufatura na qual a especifica&ccedil;&atilde;o de engenharia &eacute; originada.')"></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1 style1 style1 style1">Nota Fiscal</div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr class="textobold">
    <td align="center">&nbsp;</td>
  </tr>
  <form name="form2" method="post" action="">
  <tr class="textobold">
    <td align="center" bgcolor="#003366" class="textoboldbranco">Tipo Impressora </td>
  </tr>
  <tr class="textobold">
    <td align="center">
      <input name="tipo" type="radio" value="ma" id="radiobutton">
      <label for="radiobutton"></label>
    Matricial 
    <input name="tipo" type="radio" value="laser" id="radio">
    <label for="radio"></label>
    Laser    </td>
  </tr>
  <tr class="textobold">
    <td align="center"><input name="cp" type="hidden" id="cp" value="<?= $res["compra"]; ?>">
      <input name="id" type="hidden" id="id" value="<?= $res["pedido"]; ?>">
      <input name="nf" type="hidden" id="nf" value="<?= $nf; ?>">
      <input name="acao" type="hidden" id="acao" value="ge">
      <input name="Submit2" type="submit" class="titulos" value="Gerar Nota Fiscal" ></td>
  </tr>
  </form>
  <tr class="textobold">
    <td><form name="form1" method="post" action="">
      <table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" bgcolor="#003366" class="textoboldbranco">Atualizar Dados </td>
        </tr>
        <tr>
          <td align="left" class="textobold">Entre com os dados corretos e clique em 'Salvar' antes de gerar a nota! </td>
        </tr>
        <tr>
          <td><table width="300"  border="0" align="left" cellpadding="0" cellspacing="0" class="texto">
            <tr>
              <td width="140">Nota n&uacute;mero: </td>
              <td width="160" class="textobold"><input name="numero_nota" type="text" class="texto" id="numero_nota" value="<?= $res["numero"]; ?>" size="8" maxlength="10"></td>
              </tr>
            <tr>
              <td>N&ordm; controle Formul&aacute;rio: </td>
              <td>                <input name="numero_formulario" type="text" class="texto" id="numero_formulario" value="<?= $res["numero_formulario"]; ?>" size="8" maxlength="10"></td>
              </tr>
            
            <tr>
              <td class="textobold">Dados Adicionais </td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td>Linha 1</td>
              <td><select name="linha1" class="formularioselect" id="linha1">
                <option value="" >Selecione</option>
                <?
				$sql=mysql_query("SELECT * FROM dados");
				while($res1=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res1["id"]; ?>" <? if($res["linha1"]==$res1["id"]) print "selected"; ?>><? print $res1["nome"]; ?></option>
                <? } ?>
              </select></td>
            </tr>
            <tr>
              <td>Linha 2 </td>
              <td><select name="linha2" class="formularioselect" id="select">
                <option value="" >Selecione</option>
                <?
				$sql=mysql_query("SELECT * FROM dados");
				while($res1=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res1["id"]; ?>" <? if($res["linha2"]==$res1["id"]) print "selected"; ?>><? print $res1["nome"]; ?></option>
                <? } ?>
              </select></td>
            </tr>
            <tr>
              <td>Linha 3 </td>
              <td><select name="linha3" class="formularioselect" id="select2">
                <option value="" >Selecione</option>
                <?
				$sql=mysql_query("SELECT * FROM dados");
				while($res1=mysql_fetch_array($sql)){
				?>
                <option value="<? print $res1["id"]; ?>" <? if($res["linha3"]==$res1["id"]) print "selected"; ?>><? print $res1["nome"]; ?></option>
                <? } ?>
              </select></td>
            </tr>
            
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Volumes:</td>
              <td><input name="quantidade" type="text" class="texto" id="quantidade" value="<?= $res["quantidade"]; ?>" size="8" maxlength="10"></td>
            </tr>
            <tr>
              <td>Esp&eacute;cie:</td>
              <td><input name="especie" type="text" class="texto" id="especie" value="<?= $res["especie"]; ?>" size="15" maxlength="20"></td>
            </tr>
            <tr>
              <td>marca:</td>
              <td><input name="marca" type="text" class="texto" id="marca" value="<?= $res["marca"]; ?>" size="15" maxlength="20"></td>
            </tr>
            <tr>
              <td>Placa:</td>
              <td><input name="placa" type="text" class="texto" id="placa" value="<?= $res["placa"]; ?>" size="15" maxlength="20"></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              </tr>
            
          </table></td>
        </tr>
        <tr>
          <td align="center">
		  
		  <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#003366" class="texto">
            <tr>
              <td width="20%" align="center" bgcolor="#003366" class="textoboldbranco">Imprimir</td>
              <td width="9%" bgcolor="#003366" class="textoboldbranco">C&oacute;digo</td>
              <td width="39%" bgcolor="#003366" class="textoboldbranco">Descri&ccedil;&atilde;o</td>
              <td width="6%" align="center" bgcolor="#003366" class="textoboldbranco">Qtd</td>
              <td width="15%" align="center" bgcolor="#003366" class="textoboldbranco">Qtd Entregue </td>
              <td width="11%" align="center" bgcolor="#003366" class="textoboldbranco">Valor R$ </td>
            </tr>
			<?
			$sql2=mysql_query("SELECT * FROM vendas_list WHERE venda='$res[pedido]'");
			$i=0;
				while($res2=mysql_fetch_array($sql2)){
					$i++;
					$sql3=mysql_query("SELECT * FROM prodserv WHERE id='$res2[produto]'"); $res3=mysql_fetch_array($sql3);
			?>
            <tr>
              <td bgcolor="#FFFFFF">
                <input name="imp[<?= $res2["id"]; ?>]" type="radio" id="imp<?= $i; ?>" value="s" <? if($res2["imp"]=="s"){ print "checked"; } ?>>
                Sim 
                <input name="imp[<?= $res2["id"]; ?>]" type="radio" id="impa<?= $i; ?>" value="n" <? if($res2["imp"]=="n" or empty($res2["imp"])){ print "checked"; } ?>>
                N&atilde;o</td>
              <td bgcolor="#FFFFFF">&nbsp;<?= $res3["codprod"]; ?></td>
              <td bgcolor="#FFFFFF">&nbsp;<?= substr($res3["desc_curta"],0,35)." . . ."; ?></td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;<?= $res2["qtd"]; ?></td>
              <td bgcolor="#FFFFFF"><input name="qtde[<?= $res2["id"]; ?>]" type="text" class="formularioselect" id="qtde" value="" size="10" maxlength="10" onClick="form1.imp<?= $res2["id"]; ?>.checked=true;"></td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;<?= banco2valor($res2["unitario"]); ?></td>
            </tr>
			<?	
				} 
			?>
          </table>		  </td>
        </tr>
        <tr>
          <td align="left"><img src="imagens/apqp_seta.gif" width="18" height="16">&nbsp;&nbsp;<a href="#" class="textobold" onClick="selecionatodos(<?= $i;?>);">&nbsp;marcar todos</a> / <a href="#" class="textobold" onClick="desmarcatodos(<?= $i;?>);">desmarcar todos</a></td>
        </tr>
        <tr>
          <td align="center">
            <input name="nf" type="hidden" id="nf" value="<?= $nf; ?>">
            <input name="qtdc" type="hidden" id="qtdc" value="<?= $i; ?>">
            <input name="nn" type="hidden" id="nn" value="<?= $res["numero"]; ?>">
            <input name="cp" type="hidden" id="cp" value="<?= $res["compra"]; ?>">
            <input name="id" type="hidden" id="id" value="<?= $res["pedido"]; ?>">
            <input name="acao" type="hidden" id="acao" value="atualizar">
            <input type="submit" name="Submit" value="Salvar">                    </td>
        </tr>
      </table>
</form></td>
  </tr>
  <tr class="textobold">
    <td align="center">&nbsp;    </td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>