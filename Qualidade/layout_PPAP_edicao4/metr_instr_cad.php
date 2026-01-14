<?php
include("conecta.php");
include("seguranca.php");
$acao=verifi($permi,$acao);
$hora=hora();
$hj=date("Y-m-d");
$quem1=$_SESSION["login_nome"];
$user=$_SESSION["login_codigo"];

if(!empty($acao)){
	$loc="Metrologia - Inc Instrução";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

if($acao=="incluir"){
$codi=strtoupper($codi);
$data1=data2banco($data1);

	$sql2=mysql_query("SELECT metr_instr_codi FROM metrologia_instr WHERE metr_instr_codi='$codi'");
	if(!mysql_num_rows($sql2)==0){
		$_SESSION["mensagem"]="Digite outro código para a Instrução, este já existe!";
		header("Location:metr_lab_cad.php?acao=inc&tipo=$tipo&codi=$codi&desc=$desc&inst=$inst&emit=$emit&cada=$cada&data1=$data1");
		exit;		
	}
	
	$sql=mysql_query("INSERT INTO metrologia_instr (metr_instr_tipo, metr_instr_codi, metr_instr_desc, metr_instr_inst, metr_instr_emit, metr_instr_cada, metr_instr_data) VALUES ('$tipo', '$codi', '$desc', '$inst', '$emit', '$cada', '$data1')");
	if($sql){
		$_SESSION["mensagem"]="Instrução incluída com sucesso!";
		// cria followup caso inclua um instrução
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Inclusão de Instrução.','O usuário $quem1 incluiu uma nova Instrução chamada $desc.','$user')");
		//	
		header("Location:metr_instr_busca.php");
		exit;
	}else{
		$_SESSION["mensagem"]="A Instrução não pôde ser incluída!";
	}
}

if($acao=="alterar"){
	$data1=data2banco($data1);
	$sql=mysql_query("UPDATE metrologia_instr SET metr_instr_tipo='$tipo', metr_instr_codi='$codi', metr_instr_desc='$desc', metr_instr_inst='$inst', metr_instr_emit='$emit', metr_instr_cada='$cada', metr_instr_data='$data1' WHERE metr_instr_id='$id'");
	if($sql){
		$_SESSION["mensagem"]="A Instrução foi alterada com sucesso!";
		// cria followup caso altere o instrução
		$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao,funcionarios) VALUES ('$res_emp[fantasia]','$hj','$hora','Alteração de cadastro da Instrução.','O usuário $quem1 alterou o cadastro da Instrução $inst.','$user')");
		//	
		header("Location:metr_instr_busca.php");
		exit;		
	}else {
		$_SESSION["mensagem"]="A Instrução não pôde ser alterada!";
	}
}

$sql=mysql_query("SELECT * FROM metrologia_instr WHERE metr_instr_id='$id'");
$res=mysql_fetch_array($sql);

if($acao=="alt"){
$tipo=$res["metr_instr_tipo"];
$codi=$res["metr_instr_codi"];
$desc=$res["metr_instr_desc"];
$inst=$res["metr_instr_inst"];
$emit=$res["metr_instr_emit"];
$cada=$res["metr_instr_cada"];
$data1=banco2data($res["metr_instr_data"]);
}

?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	if(cad.tipo.value==''){
		alert('Preencha o Tipo.');
		return false;
	}
	if(cad.codi.value==''){
		alert('Preencha o Código.');
		cad.codi.focus();
		return false;
	}
	if(cad.desc.value==''){
		alert('Preencha a Descrição.');
		cad.desc.focus();
		return false;
	}	
	if(cad.inst.value==''){
		alert('Preencha a Instrução.');
		cad.inst.focus();
		return false;
	}	
	if(cad.emit.value==''){
		alert('Preencha o Emitente.');
		cad.emit.focus();
		return false;
	}
	if(cad.cada.value==''){
		alert('Preencha o nome do Cadastrador.');
		cad.cada.focus();
		return false;
	}
	if(cad.data1.value==''){
		alert('Preencha a Data.');
		cad.data1.focus();
		return false;
	}
	return true;
}
</script>
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<link href="../../style3.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="617" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="321" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="texto">
      <tr>
        <td width="18" align="center"><div align="left"><a href="#" onClick=""><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver=""></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="303" align="right"><div align="left" class="textobold style1"><span class="titulos">Metrologia &gt; Cadastro Instru&ccedil;&atilde;o </span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr> 
    <td width="591"><form name="form1" method="post" action="" onSubmit="return verifica(this)">
      <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td><table width="570" border="0" cellpadding="0" cellspacing="3">
            <tr>
              <td class="textobold">Tipo:</td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="20%" class="textobold"><label>
                    <input name="tipo" type="radio" value="1" <?php if($tipo==1){ print "checked"; }?>>
Calibra&ccedil;&atilde;o</label></td>
                  <td width="19%" class="textobold"><input name="tipo" type="radio" value="2" <?php if($tipo==2){ print "checked"; }?>>
Utiliza&ccedil;&atilde;o</td>
                  <td width="61%" class="textobold">
                    <label></label>
                    <label>
                    <input name="tipo" type="radio" value="3" <?php if($tipo==3){ print "checked"; }?>>
                    </label>
                    MSA</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td width="74" class="textobold">C&oacute;digo: </td>
              <td width="441"><span class="textobold">
                <input name="codi" type="text" class="formulario" id="codi" size="10" maxlength="10" value="<?php print $codi;?>" <?php if($acao=="alt"){ print "readonly"; } ?>>
              </span></td>
            </tr>
            <tr>
              <td class="textobold">Descri&ccedil;&atilde;o:</td>
              <td><label>
              <input name="desc" type="text" class="formulario" id="desc" value="<?php print $desc;?>" size="50" maxlength="50">
              </label></td>
            </tr>
            <tr>
              <td class="textobold">Instru&ccedil;&atilde;o:</td>
              <td class="textobold"><label>
              <textarea name="inst" cols="100" rows="8" class="formulario" wrap="VIRTUAL" id="textarea"  onFocus="enterativa=0;" onBlur="enterativa=1;" id="inst"><?php print $inst; ?></textarea>
                
              </label></td>
            </tr>
            <tr>
              <td class="textobold">Emitente:</td>
              <td><input name="emit" type="text" class="formulario" id="emit" value="<?php print $emit;?>" size="50" maxlength="50"></td>
            </tr>
            <tr>
              <td class="textobold">Cadastrador: </td>
              <td><input name="cada" type="text" class="formulario" id="cada" size="50" maxlength="50" value="<?php print $quem1;?>"></td>
            </tr>
            <tr>
              <td class="textobold">Data:</td>
              <td><input name="data1" type="text" class="formulario" id="data1" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php print $data1;?>">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_instr_cad','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="64%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><span class="textobold">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='metr_instr_busca.php';">
&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if ($acao=="alt"){ ?>
			<input name="Alterar" type="submit" class="microtxt" value="Alterar">
			<?php } ?>
			<?php if($acao=="inc"){ ?>
			<input name="Incluir" type="submit" class="microtxt" id="Incluir" value="Incluir">
			<?php } ?>
			<input type="hidden" name="acao" id="acao2"	value="<?php if($acao=="alt"){ print "alterar"; } else if($acao=="inc"){ print "incluir"; } ?>">
			<input type="hidden" name="id" value= <?php print $id;?>>
          </span></div></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<label></label>
</body>
</html>
<?php include("mensagem.php"); ?>