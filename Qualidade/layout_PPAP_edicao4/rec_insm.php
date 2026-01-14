<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Metrologia - Inc Inst";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$user=$_SESSION["login_nome"];
$hora=hora();

$sql2=mysql_query("SELECT * FROM metrologia_cad WHERE metr_cad_id='$id'");
$res2=mysql_fetch_array($sql2);

$data1=data2banco($data2);
$val=valor2banco($custo);
$val2=valor2banco2($usode);
$val3=valor2banco2($usoa);
$val4=valor2banco2($resol);

$sql5=mysql_query("SELECT descricao FROM ins_medicao WHERE id='$inst'");
$res5=mysql_fetch_array($sql5);

if($acao=="alt"){
$cod_inst=$res2["metr_inst_cod"];
$inst=$res2["metr_tipi"];
$usuario=$res2["metr_inst_usuario"];
$fabr=$res2["metr_fabr"];
$data2=banco2data($res2["metr_inst_data"]);
$tipo=$res2["metr_inst_tipo"];
$usode=banco2valor2($res2["metr_inst_usode"]);
$usoa=banco2valor2($res2["metr_inst_usoa"]);
$resol=banco2valor2($res2["metr_inst_reso"]);
$unidade=$res2["metr_unid"];
$normas=$res2["metr_inst_normas"];
$sit=$res2["metr_inst_sit"];
$outro=$res2["metr_inst_outro"];
$custo=banco2valor($res2["metr_cust"]);
$obs=$res2["metr_inst_obs"];
}

if($acao=="incluir"){
$cod_inst=strtoupper($cod_inst);
	$sql6=mysql_query("SELECT metr_inst_cod FROM metrologia_cad WHERE metr_inst_cod='$cod_inst'");
	if(!mysql_num_rows($sql6)==0){
		$_SESSION["mensagem"]="Digite outro código para o Instrumento, este já existe!";
		header("Location:insm_cad.php?acao=inc&cod_inst=$cod_inst&inst=$inst&usuario=$usuario&fabr=$fabr&data2=$data2&tipo=$tipo&usode=$usode&usoa=$usoa&resol=$resol&unidade=$unidade&normas=$normas&sit=$sit&outro=$outro&custo=$custo&obs=$obs");
		exit;		
	}
$sql4=mysql_query("INSERT INTO metrologia_cad (metr_inst_cod,metr_tipi,metr_fabr,metr_inst_data,metr_inst_tipo,metr_inst_usode,metr_inst_usoa,metr_inst_reso,metr_unid,metr_inst_normas,metr_inst_sit,metr_inst_outro,metr_cust,metr_inst_obs,metr_inst_user,metr_inst_hora,metr_tipi_nome,metr_inst_usuario) VALUES ('$cod_inst','$inst','$fabr','$data1','$tipo','$val2','$val3','$val4','$unidade','$normas','$sit','$outro','$val','$obs','$user','$hora','$res5[descricao]','$usuario')")or erp_db_fail();

	if($sql4){
		$_SESSION["mensagem"]="Instrumento incluído com sucesso!";
		// cria followup caso inclua
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Instrumento de Medição.','O usuário $quem1 incluiu um novo Instrumento de Medição código $cod_inst.','$user')");
		//	
		header("Location:rec_insm_busca.php");
		exit;
	}
	else{
		$_SESSION["mensagem"]="O Instrumento não pôde ser incluído!";
	}
}
if($acao=="alterar"){

$sql4=mysql_query("UPDATE metrologia_cad SET metr_inst_cod='$cod_inst', metr_tipi='$inst', metr_fabr='$fabr', metr_inst_data='$data1', metr_inst_tipo='$tipo', metr_inst_usode='$val2', metr_inst_usoa='$val3', metr_inst_reso='$val4', metr_unid='$unidade', metr_inst_normas='$normas', metr_inst_sit='$sit', metr_inst_outro='$outro', metr_cust='$val', metr_inst_obs='$obs', metr_inst_user='$user', metr_inst_hora='$hora', metr_tipi_nome='$res5[descricao]', metr_inst_usuario='$usuario' WHERE metr_cad_id='$id'");
	if($sql4){
		$_SESSION["mensagem"]="Instrumento alterado com sucesso!";
		// cria followup caso altere
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração do cadastro do Instrumento de Medição.','O usuário $quem1 alterou o cadastro do Instrumento de Medição $cod_inst.','$user')");
		//	
		header("Location:rec_insm_busca.php");
		exit;
	}
	else{
		$_SESSION["mensagem"]="O Instrumento não pôde ser alterado!";
	}
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../text.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<script type="text/JavaScript"></script>
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
<!--
function bloqueia1(){
		document.all.outro.style.background="silver";
		document.form1.outro.disabled=true;
	}
function bloqueia2(){
		document.all.outro.style.background="white";
		document.form1.outro.disabled=false;
	}
function verifica(cad){
	if(cad.cod_inst.value==''){
		alert('Digite o Código do Instrumento.');
		cad.cod_inst.focus();
		return false;
	}
	if(cad.inst.value==''){
		alert('Selecione o Tipo de Instrumento.');
		return false;
	}
	if(cad.usuario.value==''){
		alert('Selecione o Usuário que irá utilizar o Instrumento de Medição.');
		return false;
	}
	if(cad.fabr.value==''){
		alert('Digite o nome do Fabricante.');
		cad.fabr.focus();
		return false;
	}
	if(cad.data.value==''){
		alert('Digite a Data da Aquisição.');
		cad.data.focus();
		return false;
	}
	if(cad.usode.value=='0,000'){
		alert('Digite o valor da primeira Faixa de Uso.');
		cad.usode.focus();
		return false;
	}
	if(cad.usode.value==''){
		alert('Digite o valor da primeira Faixa de Uso.');
		cad.usode.focus();
		return false;
	}
	if(cad.usoa.value=='0,000'){
		alert('Digite o valor da segunda Faixa de Uso.');
		cad.usoa.focus();
		return false;
	}
	if(cad.usoa.value==''){
		alert('Digite o valor da segunda Faixa de Uso.');
		cad.usoa.focus();
		return false;
	}
	if(cad.resol.value=='0,000'){
		alert('Digite o valor da Resolução.');
		cad.resol.focus();
		return false;
	}
	if(cad.resol.value==''){
		alert('Digite o valor da Resolução.');
		cad.resol.focus();
		return false;
	}
	if(cad.unidade.value==''){
		alert('Selecione a Unidade de medida.');
		return false;
	}
	if(cad.normas.value==''){
		alert('Digite as normas.');
		cad.normas.focus();
		return false;
	}
	if(cad.custo.value=='0,00'){
		alert('Digite o custo.');
		cad.custo.focus();
		return false;
	}
	if(cad.custo.value==''){
		alert('Digite o custo.');
		cad.custo.focus();
		return false;
	}
	if(cad.tipo.value==''){
		alert('Selecione o Tipo.');
		return false;
	}
	return true;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="70%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick="MM_openBrWindow('help/mini_fmea_projeto.html','','width=680,height=501')"><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0"/></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1">Recebimento &gt; Cadastro &gt; Instrumento de Medição</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <form name="form1" method="post" action="" id="form1" onSubmit="return verifica(this)">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
</table>
  <tr>
    <td><table width="70%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textobold">C&oacute;digo do Instrumento: </td>
        <td class="textobold"><input name="cod_inst" type="text" class="formulario" id="cod_inst" value="<?php print $cod_inst;?>" size="15" <?php if($acao=="alt"){ print "readonly"; } ?>></td>
        <td class="textobold">Tipo de Instrumento: </td>
        <td class="textobold"><select name="inst" class="textopreto">
          <option>Selecione</option>
          <?php $sql=mysql_query("SELECT * FROM ins_medicao ORDER BY tipo");
			  while($res=mysql_fetch_array($sql)){  
		  ?>
          <option value="<?php print $res["id"];?>" <?php if($res["id"]==$inst){ print "selected"; } ?>><?php print $res["tipo"]; ?></option>
          <?php } ?>
        </select></td>
        <td class="textobold">Usu&aacute;rio:</td>
        <td class="textobold"><select name="usuario" class="textopreto" id="usuario">
          <option>Selecione</option>
          <?php $sql4=mysql_query("SELECT * FROM funcionarios ORDER BY nome");
			  while($res4=mysql_fetch_array($sql4)){  
		  ?>
          <option value="<?php print $res4["id"];?>" <?php if($res4["id"]==$usuario){ print "selected"; } ?>><?php print $res4["nome"]; ?></option>
          <?php } ?>
        </select></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="716" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td align="center" bordercolor="#CCCCCC" bgcolor="#003366" class="textoboldbranco">Detalhes</td>
        <td width="3">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="709" border="0" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        
          <td width="687" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="3" cellpadding="0">
            <tr>
              <td width="12%" class="textobold">Fabricante:</td>
              <td class="textobold"><label>
              <input name="fabr" type="text" class="formularioselect" id="fabr" value='<?php print $fabr;?>'>
              </label></td>
              <td width="19%" class="textobold"><div align="center">Data da Aquisi&ccedil;&atilde;o: </div></td>
              <td width="12%" class="textobold"><input name="data2" type="text" class="formulario" id="data2" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value='<?php print $data2;?>' size="10" maxlength="10">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=insm_cad','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td width="6%" class="textobold"><div align="right">Tipo:</div></td>
              <td width="12%" class="textobold"><label>
                <div align="right">
                  <input name="tipo" type="radio" value="1" <?php if($tipo=="1") print "checked"; ?>>
                  Variável</div>
              </label></td>
              <td width="12%" class="textobold"><label>
                <div align="right">
                  <input name="tipo" type="radio" value="2" <?php if($tipo=="2") print "checked"; ?>>
                  Atributo</div>
              </label></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="12%" class="textobold">Faixa de Uso: </td>
                <td width="12%" class="textobold"><label>
                  <input name="usode" type="text" class="formulario" size="10" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value='<?php print $usode;?>'>
                </label></td>
                <td width="5%" class="textobold"><div align="center">&agrave;</div></td>
                <td width="14%" class="textobold"><input name="usoa" type="text" class="formulario" size="10" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value='<?php print $usoa;?>'></td>
                <td width="13%" class="textobold"><div align="center">Resolu&ccedil;&atilde;o:</div></td>
                <td width="16%" class="textobold"><input name="resol" type="text" class="formulario" size="10" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value='<?php print $resol;?>'></td>
                <td width="14%" class="textobold"><div align="center">Unidade:</div></td>
                <td width="14%" class="textobold"><select name="unidade" class="textopreto">
                <option>Selecione</option>
				   <?php $sql3=mysql_query("SELECT * FROM unidades ORDER BY apelido");
					  while($res3=mysql_fetch_array($sql3)){
				   ?>
                <option value="<?php print $res3["id"];?>" <?php if($res3["id"]==$unidade){ print "selected"; } ?>> <?php print $res3["apelido"]; ?></option>
                <?php } ?>
                </select></td>
              </tr>
            </table>            
            <table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="13%" class="textobold">Normas:</td>
                <td width="87%" class="textobold"><input name="normas" type="text" class="formulario" size="114" value='<?php print $normas;?>'></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="12%" class="textobold">Situa&ccedil;&atilde;o:</td>
                <td width="15%" class="textobold"><label>
<input name="sit" type="radio" onClick="bloqueia1();" value="1" <?php if($sit=="1") print "checked"; ?>>                  
Ativo</label></td>
                <td width="15%" class="textobold"><label>
                  <input name="sit" type="radio" onClick="bloqueia1();" value="2" <?php if($sit=="2") print "checked"; ?>>
                  Inativo</label></td>
                <td width="15%" class="textobold"><label>
                  <input name="sit" type="radio" onClick="bloqueia1();" value="3" <?php if($sit=="3") print "checked"; ?>>
                  Excluído</label></td>
                <td width="15%" class="textobold"><label>
                  <input name="sit" type="radio" onClick="bloqueia1();" value="4" <?php if($sit=="4") print "checked"; ?>>
                  Em reparo</label></td>
                <td width="15%" class="textobold"><label>
                  <input name="sit" type="radio" onClick="bloqueia2();" value="5" <?php if($sit=="5") print "checked"; ?>>
                  Outro</label></td>
                <td width="13%" class="textobold"><input name="outro" type="text" class="formulario" id="outro" size="16" value='<?php print $outro;?>'></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="79" class="textobold">Custo: R$ </td>
                <td width="122" class="textobold"><input name="custo" type="text" class="formulario" size="15" maxlength="15" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php print $custo;?>"></td>
                <td width="112" class="textobold"><div align="center">Observa&ccedil;&otilde;es:</div></td>
                <td width="359" class="textobold"><input name="obs" type="text" class="formulario" size="66" value='<?php print $obs;?>'></td>
              </tr>
            </table></td>
      </tr>
    </table>
<table width="56%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr width="21%">
    <td width="22%" class="textobold">&Uacute;ltima altera&ccedil;&atilde;o:</td>
    <td width="78%"><div align="left" class="textopreto"><?php if($res2["metr_inst_user"]!=""){ print "$res2[metr_inst_hora] - $res2[metr_inst_user]"; }?></div></td>
    </tr>
</table>
<table width="67%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <div align="center">
        <input type="hidden" name="acao" id="acao">
        <input name="voltar" type="button" class="treemenu" value="Voltar" onClick="window.location='rec_insm_busca.php';">		
        &nbsp;&nbsp;&nbsp;&nbsp;
		<?php if ($acao=="alt"){ ?>
		<input name="alterar" type="submit" class="microtxt" id="alterar" onClick="form1.acao.value='alterar';" value="Alterar">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<?php } ?>
		<?php if($acao=="inc"){ ?>
        <input name="incluir" type="submit" class="microtxt" value="Incluir" onClick="form1.acao.value='incluir';">
		<?php } ?>
      </div>   </td>
  </tr>
</table>
  </form>
</table>
</body>
</html>
<script language="javascript" src="tooltip.js"></script>
<?php include("mensagem.php"); ?>