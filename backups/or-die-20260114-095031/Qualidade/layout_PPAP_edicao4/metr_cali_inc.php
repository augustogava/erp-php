<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Metrologia - Inc Inst";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}

$data2=data2banco($data_usoi);
$data3=data2banco($emitido);
$val=valor2banco2($escala1);
$val2=valor2banco2($escala2);
$val3=valor2banco($temp);
$val4=valor2banco2($umidade);
$val5=valor2banco($custo);
if($acao=="incluir"){
	$sql=mysql_query("INSERT INTO metrologia_cad (metr_tipi,metr_func_codi,metr_cad_seto,metr_cad_peri,metr_cad_vali,metr_cad_marc,metr_cad_mode,metr_cad_nser,metr_cad_emit,metr_fabr,metr_cust,metr_cad_tecr,metr_cad_enge,metr_cad_ende,metr_cad_os,metr_cad_ie,metr_cad_temp,metr_cad_umur,metr_inst,metr_loca,metr_esca1,metr_esca2,metr_rev,metr_unid,metr_dese,metr_tena,metr_usoi,metr_pote,metr_prec,metr_leit,metr_cad_obsl,metr_stat_a,metr_stat_e) VALUES ('$tip_inst','$usuario','$setor','$periodo','$validade','$marca','$modelo','$numserie','$data3','$fabricante','$val5','$tecnico','$eng','$end','$os','$ie','$val3','$val4','$instrucao','$localizacao','$val','$val2','$revisao','$unid_med','$desenho','$tensao','$data2','$potencia','$precisao','$leitura','$obs','Aguardando Aprovação','Aguardando Aprovação')") or die ("O Instrumento não pôde ser incluído!");
	if($sql){
		$_SESSION["mensagem"]="Instrumento incluído com sucesso! Lembre-se de verificar a condição do instrumento na opção Alterar.";
		header("Location:metr_cali_hist.php");
		exit;
	}else{
		$_SESSION["mensagem"]="O Instrumento não pôde ser incluído!";
	}
}

if($acao=="alterar"){
	$data4=data2banco (date ('d/m/Y', mktime (0, 0, 0, date('m'), date('d')+$res9['metr_cad_vali'], date('Y'))));

$sql=mysql_query("UPDATE metrologia_cad SET metr_tipi='$tip_inst', metr_func_codi='$usuario', metr_cad_seto='$setor', metr_cad_peri='$periodo', metr_cad_vali='$validade', metr_cad_marc='$marca', metr_cad_mode='$modelo', metr_cad_nser='$numserie', metr_cad_emit='$data3', metr_fabr='$fabricante', metr_cust='$val5', metr_cad_tecr='$tecnico', metr_cad_enge='$eng', metr_cad_ende='$end', metr_cad_os='$os', metr_cad_ie='$ie', metr_cad_temp='$val3', metr_cad_umur='$val4', metr_esca1='$val', metr_esca2='$val2', metr_rev='$revisao', metr_unid='$unid_med', metr_inst='$instrucao', metr_loca='$localizacao', metr_dese='$desenho', metr_tena='$tensao', metr_usoi='$data2', metr_pote='$potencia', metr_prec='$precisao', metr_leit='$leitura', metr_cad_obsl='$obs' WHERE metr_cad_id='$id'") or die ("ALTERAR MORREU"); //, metr_condrec='$cond_rec'
		if($sql){
			$_SESSION["mensagem"]="Instrumento foi alterado com sucesso!";
			header("Location:metr_cali_hist.php");
			exit;		
		}else {
			$_SESSION["mensagem"]="O Instrumento não pôde ser alterado!";
			header("Location:metr_cali_hist.php");
			exit;		
		}
}
	

/*if($acao=="visualizar"){
$cond_rec=$res9["metr_condrec"];
}*/


if($acao=="aprovar"){
$data4=data2banco (date ('d/m/Y', mktime (0, 0, 0, date('m'), date('d')+$res9['metr_cad_vali'], date('Y'))));
	if(isset($botao_apr)){
		if(!empty($cond_rec)){
		$_SESSION["mensagem"]="Caso deseje aprovar novamente, clique em limpar primeiro!";
		}
		if(empty($cond_rec)){
		$cond_rec="Conforme";
		}
		$sql=mysql_query("UPDATE metrologia_cad SET metr_tipi='$tip_inst', metr_func_codi='$usuario', metr_cad_seto='$setor', metr_cad_peri='$periodo', metr_cad_vali='$validade', metr_cad_marc='$marca', metr_cad_mode='$modelo', metr_cad_nser='$numserie', metr_cad_emit='$data3', metr_fabr='$fabricante', metr_cust='$val5', metr_cad_tecr='$tecnico', metr_cad_enge='$eng', metr_cad_ende='$end', metr_cad_os='$os', metr_cad_ie='$ie', metr_cad_temp='$val3', metr_cad_umur='$val4', metr_esca1='$val', metr_esca2='$val2', metr_rev='$revisao', metr_unid='$unid_med', metr_inst='$instrucao', metr_loca='$localizacao', metr_dese='$desenho', metr_tena='$tensao', metr_usoi='$data2', metr_pote='$potencia', metr_prec='$precisao', metr_leit='$leitura', metr_cad_obsl='$obs', metr_condrec='$cond_rec' WHERE metr_cad_id='$id'") or die ("APROVAR MORREU");

		if($sql){
			$_SESSION["mensagem"]="O Instrumento está Conforme!";
			header("Location:metr_cali_inc.php?acao=alt&id=$id");
//			header("Location:metr_cali_inc.php?acao=$acao&id=$id");
			exit;		
		}else {
			$_SESSION["mensagem"]="A avaliação do Instrumento não pôde ser incluída!";
		}
	}
}


if($acao=="limpar"){
$data4=data2banco (date ('d/m/Y', mktime (0, 0, 0, date('m'), date('d')+$res9['metr_cad_vali'], date('Y'))));

	if(isset($limpar)){
		if(empty($cond_rec)){
		$_SESSION["mensagem"]="Se desejar, clique em aprovar!";
		}
		if(!empty($cond_rec)){
		$cond_rec="";
		}
		$sql=mysql_query("UPDATE metrologia_cad SET metr_tipi='$tip_inst', metr_func_codi='$usuario', metr_cad_seto='$setor', metr_cad_peri='$periodo', metr_cad_vali='$validade', metr_cad_marc='$marca', metr_cad_mode='$modelo', metr_cad_nser='$numserie', metr_cad_emit='$data3', metr_fabr='$fabricante', metr_cust='$val5', metr_cad_tecr='$tecnico', metr_cad_enge='$eng', metr_cad_ende='$end', metr_cad_os='$os', metr_cad_ie='$ie', metr_cad_temp='$val3', metr_cad_umur='$val4', metr_esca1='$val', metr_esca2='$val2', metr_rev='$revisao', metr_unid='$unid_med', metr_inst='$instrucao', metr_loca='$localizacao', metr_dese='$desenho', metr_tena='$tensao', metr_usoi='$data2', metr_pote='$potencia', metr_prec='$precisao', metr_leit='$leitura', metr_cad_obsl='$obs', metr_condrec='$cond_rec' WHERE metr_cad_id='$id'") or die ("LIMPAR MORREU");
		if ($sql){
			$_SESSION["mensagem"]="Aprovação excluída com sucesso!";
			header("Location:metr_cali_inc.php?acao=alt&id=$id");
			exit;
		}else{
			$_SESSION["mensagem"]="O Aprovação não pôde ser excluída!";
		}
	}
}

$sql9=mysql_query("SELECT * FROM metrologia_cad WHERE metr_cad_id='$id'");
$res9=mysql_fetch_array($sql9);

$sql2=mysql_query("SELECT * FROM ins_medicao WHERE id='$res9[metr_tipi]'");
$res2=mysql_fetch_array($sql2);

$sql6=mysql_query("SELECT * FROM maodeobra_setor WHERE id='$res9[metr_cad_seto]'");
$res6=mysql_fetch_array($sql6);

$sql7=mysql_query("SELECT * FROM unidades WHERE id='$res9[metr_unid]'");
$res7=mysql_fetch_array($sql7);

$sql10=mysql_query("SELECT * FROM funcionarios WHERE id='$res9[metr_func_codi]'");
$res10=mysql_fetch_array($sql10);


?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script>
<!--
function verifica(cad){
	if(cad.tip_inst.value==''){
		alert('Selecione o Tipo de Instrumento');
		return false;
	}
	if(cad.usuario.value==''){
		alert('Selecione o Nome do Usuário');
		return false;
	}
	if(cad.setor.value==''){
		alert('Selecione o Setor');
		cad.setor.focus();
		return false;
	}
	if(cad.periodo.value==''){
		alert('Preencha o Período');
		cad.periodo.focus();
		return false;
	}
	if(cad.validade.value==''){
		alert('Preencha Data de Validade');
		cad.validade.focus();
		return false;
	}
	if(cad.marca.value==''){
		alert('Preencha a Marca');
		cad.marca.focus();
		return false;
	}
	if(cad.modelo.value==''){
		alert('Preencha o Modelo');
		cad.modelo.focus();
		return false;
	}
	if(cad.numserie.value==''){
		alert('Preencha o Número de Série');
		cad.numserie.focus();
		return false;
	}
	if(cad.emitido.value==''){
		alert('Preencha a Data de Emissão');
		cad.emitido.focus();
		return false;
	}
	if(cad.fabricante.value==''){
		alert('Preencha o nome do Fabricante!');
		cad.fabricante.focus();
		return false;
	}
		if(cad.custo.value==''){
		alert('Preencha o Custo');
		cad.custo.focus();
		return false;
	}
	if(cad.tecnico.value==''){
		alert('Preencha o Técnico');
		cad.tecnico.focus();
		return false;
	}
	if(cad.eng.value==''){
		alert('Preencha o Engenheiro');
		cad.eng.focus();
		return false;
	}
	if(cad.end.value==''){
		alert('Preencha o Endereço');
		cad.end.focus();
		return false;
	}
	if(cad.os.value==''){
		alert('Preencha a OS');
		cad.os.focus();
		return false;
	}
	if(cad.ie.value==''){
		alert('Preencha a Inscrga');
		cad.ie.focus();
		return false;
	}
	if(cad.temp.value==''){
		alert('Preencha a Temperatura');
		cad.temp.focus();
		return false;
	}
	if(cad.umidade.value==''){
		alert('Preencha a % de Umidade UR');
		cad.umidade.focus();
		return false;
	}
	if(cad.instrucao.value==''){
		alert('Preencha a Instrução');
		cad.instrucao.focus();
		return false;
	}
	if(cad.localizacao.value==''){
		alert('Preencha a Localização');
		cad.locarizacao.focus();
		return false;
	}
	if(cad.escala1.value==''){
		alert('Preencha a Escala 1');
		cad.escala1.focus();
		return false;
	}
	if(cad.escala2.value==''){
		alert('Preencha a Escala 2');
		cad.escala2.focus();
		return false;
	}
	if(cad.revisao.value==''){
		alert('Preencha a Revisão');
		cad.revisao.focus();
		return false;
	}
	if(cad.unid_med.value==''){
		alert('Selecione a Unidade de medida');
		cad.unid_med.focus();
		return false;
	}
	if(cad.desenho.value==''){
		alert('Preencha o número do Desenho');
		cad.desenho.focus();
		return false;
	}
	if(cad.tensao.value==''){
		alert('Preencha a Tensão de Alinhamento');
		cad.tensao.focus();
		return false;
	}
	if(cad.data_usoi.value==''){
		alert('Preencha a Data de Uso Inicial');
		cad.data_usoi.focus();
		return false;
	}
	if(cad.potencia.value==''){
		alert('Preencha a Potência');
		cad.potencia.focus();
		return false;
	}
	if(cad.precisao.value==''){
		alert('Preencha a Precisão');
		cad.precisao.focus();
		return false;
	}
	if(cad.leitura.value==''){
		alert('Preencha a Leitura');
		cad.leitura.focus();
		return false;
	}
	return true;
}

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
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="590" border="0" cellpadding="0" cellspacing="0" class="texto">
      <tr>
        <td width="27" align="center"><div align="left"><a href="#" onClick=""><img src="imagens/icon14_ahn.gif" width="14" height="14" border="0" onMouseOver=""></a><span class="impTextoBold">&nbsp;</span></div></td>
        <td width="563" align="right"><div align="left" class="textobold style1"><span class="titulos">Metrologia &gt; Calibra&ccedil;&atilde;o de Instrumentos &gt; Inclus&atilde;o de Instrumento</span></div></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
</table>
<table width="657" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td width="647" align="left" valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return verifica(this)">
      <table width="100%" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td class="textobold">Tipo de Inst.: </td>
          <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="41%"><select name="tip_inst" class="textopreto" id="tip_inst">
                <option>Selecione</option>
                <?php $sql3=mysql_query("SELECT * FROM ins_medicao ORDER BY tipo");
			  while($res3=mysql_fetch_array($sql3)){
			  ?>
                <option value="<?php print $res3["id"];?>" <?php if($res3["id"]==$res9["metr_tipi"]){ print "selected"; } ?>><?php print $res3["tipo"]; ?></option>
                <?php } ?>
              </select></td>
              <td width="26%" class="textobold"><div align="left">Usu&aacute;rio:</div></td>
              <td width="33%" class="textobold"><select name="usuario" class="textopreto" id="usuario">
                <option>Selecione</option>
                <?php $sql4=mysql_query("SELECT * FROM funcionarios ORDER BY nome");
			  while($res4=mysql_fetch_array($sql4)){
			  ?>
                <option value="<?php print $res4["id"];?>" <?php if($res4["id"]==$res9["metr_func_codi"]){ print "selected"; } ?>><?php print $res4["nome"]; ?> </option>
                <?php } ?>
              </select></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="textobold">Setor:</td>
          <td class="textobold"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="43%"><select name="setor" class="textopreto" id="setor">
                  <option>Selecione</option>
                  <?php 
				  	 $sql5=mysql_query("SELECT * FROM maodeobra_setor ORDER BY sigla");
				     while($res5=mysql_fetch_array($sql5)){
			  	  ?>
                  <option value="<?php print $res5["id"];?>" <?php if($res5["id"]==$res9["metr_cad_seto"]){ print "selected"; } ?>> <?php print $res5["sigla"]; ?></option>
                  	<?php } ?>
                </select></td>
                <td width="28%" class="textobold"><div align="left">Per&iacute;odo:</div></td>
                <td width="29%" class="textobold"><input name="periodo" type="text" class="formulario" id="periodo" size="30" maxlength="10" value="<?php echo  $res9["metr_cad_peri"];?>"></td>
                </tr>
          </table></td>
        </tr>
        <tr>
          <td class="textobold">Validade:</td>
	          <td class="textobold"><input name="validade" type="text" class="formulario" id="validade" size="15" maxlength="10" value="<?php echo  $res9["metr_cad_vali"];?>"></td>
        </tr>
        <tr>
          <td class="textobold">Marca:</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="43%"><input name="marca" type="text" class="formulario" id="marca" size="15" maxlength="15" value="<?php echo  $res9["metr_cad_marc"];?>"></td>
              <td width="28%" class="textobold">Modelo:</td>
              <td width="29%"><input name="modelo" type="text" class="formulario" id="modelo" size="30" maxlength="20" value="<?php echo  $res9["metr_cad_mode"];?>"></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td class="textobold">N&ordm; de S&eacute;rie: </td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="41%"><span class="textobold">
                <input name="numserie" type="text" class="formulario" id="numserie" size="15" maxlength="10" onKeyPress="return validanum(this, event)" value="<?php echo  $res9["metr_cad_nser"];?>">
              </span></td>
              <td width="26%" class="textobold">Emitido em: </td>
              <td width="33%"><span class="textobold">
                <input name="emitido" type="text" class="formulario" id="emitido" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res9["metr_cad_emit"]);?>">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_cali_inc_1','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a>
              </span></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td class="textobold">Fabricante:</td>
          <td><input name="fabricante" type="text" class="formulario" id="fabricante" size="50" maxlength="50" value="<?php echo  $res9["metr_fabr"];?>"></td>
        </tr>
        <tr>
          <td class="textobold">Custo R$: </td>
          <td><input name="custo" type="text" class="formulario" id="custo" size="15" maxlength="15" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php echo  banco2valor($res9["metr_cust"]);?>"></td>
        </tr>
        <tr>
          <td class="textobold">T&eacute;cnico:</td>
          <td><input name="tecnico" type="text" class="formulario" id="tecnico" size="50" maxlength="50" value="<?php echo  $res9["metr_cad_tecr"];?>"></td>
        </tr>
        <tr>
          <td class="textobold">Engenheiro:</td>
          <td><input name="eng" type="text" class="formulario" id="eng" size="50" maxlength="50" value="<?php echo  $res9["metr_cad_enge"];?>"></td>
          </tr>
        <tr>
          <td class="textobold">Endere&ccedil;o:</td>
          <td><input name="end" type="text" class="formulario" id="end" size="50" maxlength="50" value="<?php echo  $res9["metr_cad_ende"];?>"></td>
          </tr>
        <tr>
          <td class="textobold">OS:</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="16%"><input name="os" type="text" class="formulario" id="os" size="5" maxlength="5" onKeyPress="return validanum(this, event)" value="<?php echo  $res9["metr_cad_os"];?>">                </td>
              <td width="4%">I/E:</td>
              <td width="16%"><input name="ie" type="text" class="formulario" id="ie" size="5" maxlength="5" onKeyPress="return validanum(this, event)" value="<?php echo  $res9["metr_cad_ie"];?>"></td>
              <td width="19%">Temperatura &ordm;C: </td>
              <td width="17%"><input name="temp" type="text" class="formulario" id="temp" size="7" maxlength="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="<?php print banco2valor($res9["metr_cad_temp"]);?>"></td>
              <td width="18%">Umidade UR %: </td>
              <td width="10%"><input name="umidade" type="text" class="formulario" id="umidade" size="7" maxlength="10" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value="<?php print banco2valor2($res9["metr_cad_umur"]);?>"></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td class="textobold">Instru&ccedil;&atilde;o:</td>
          <td><input name="instrucao" type="text" class="formularioselect" id="instrucao" size="90" maxlength="90" value="<?php echo  $res9["metr_inst"];?>"></td>
        </tr>
        <tr>
          <td class="textobold">Localiza&ccedil;&atilde;o:</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="29%"><input name="localizacao" type="text" class="formulario" id="localizacao" size="30" maxlength="30" value="<?php echo  $res9["metr_loca"];?>"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td class="textobold">Escala 1:</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="17%" class="textobold"><input name="escala1" type="text" class="formulario" id="escala1" size="10" maxlength="15" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value="<?php echo  $res9["metr_esca1"];?>"></td>
              <td width="11%" class="textobold">Escala 2:</td>
              <td width="17%" class="textobold"><input name="escala2" type="text" class="formulario" id="escala2" size="10" maxlength="15" onKeyDown="formataMoeda3(this,retornaKeyCode(event))" onKeyUp="formataMoeda3(this,retornaKeyCode(event))" value="<?php echo  $res9["metr_esca2"];?>"></td>
              <td width="10%" class="textobold">Revis&atilde;o:</td>
              <td width="13%" class="textobold"><input name="revisao" type="text" class="formulario" id="revisao" size="5" maxlength="5" onKeyPress="return validanum(this, event)" value="<?php echo  $res9["metr_rev"];?>"></td>
              <td width="16%" class="textobold">Unid. Medida: </td>
              <td width="16%" class="textobold"><select name="unid_med" class="textopreto" id="unid_med">
                <option>Selecione</option>
                <?php $sql8=mysql_query("SELECT * FROM unidades ORDER BY apelido");
			  while($res8=mysql_fetch_array($sql8)){
			  ?>
                <option value="<?php print $res8["id"];?>" <?php if($res8["id"]==$res9["metr_unid"]){ print "selected"; } ?>> <?php print $res8["apelido"]; ?></option>
                <?php } ?>
              </select>            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="textobold">Desenho:</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="43%"><input name="desenho" type="text" class="formulario" id="desenho" size="30" maxlength="30" value="<?php echo  $res9["metr_dese"];?>"></td>
              <td width="28%">Tens&atilde;o Alinh.: </td>
              <td width="29%"><input name="tensao" type="text" class="formulario" id="tensao" size="30" maxlength="30" value="<?php echo  $res9["metr_tena"];?>"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="textobold">Data uso inicial: </td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="textobold">
              <td width="43%"><input name="data_usoi" type="text" class="formulario" id="data_usoi" size="10" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)" value="<?php echo  banco2data($res9["metr_usoi"]);?>">&nbsp;<a href="#" class="" onClick="window.open('agenda_pop.php?window_position=metr_cali_inc_2','','scrollbars=no,width=155,height=138');"><img src="imagens/icon14_cal.gif" width="14" height="14" border="0"></a></td>
              <td width="28%">Pot&ecirc;ncia:</td>
              <td width="29%"><input name="potencia" type="text" class="formulario" id="potencia" size="30" maxlength="30" value="<?php echo  $res9["metr_pote"];?>"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="textobold">Precis&atilde;o</td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="43%" class="textobold"><input name="precisao" type="text" class="formulario" id="precisao" size="30" maxlength="30" value="<?php echo  $res9["metr_prec"];?>"></td>
              <td width="28%" class="textobold">Leitura:</td>
              <td width="29%" class="textobold"><input name="leitura" type="text" class="formulario" id="leitura" size="30" maxlength="30" value="<?php echo  $res9["metr_leit"];?>"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="textobold">Obs Lin.:</td>
          <td class="textobold"><textarea name="obs" rows="4" wrap="VIRTUAL" class="formularioselect" id="obs" onFocus="enterativa=0;" onBlur="enterativa=1;" value=""><?php print $res9["metr_cad_obsl"];?></textarea></td>
          </tr>
        <tr>
          <td colspan="2" class="textobold"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="29%" class="textobold">Condi&ccedil;&atilde;o do Recebimento: </td>
              <td width="47%"><input name="cond_rec" type="text" class="formulario" id="cond_rec" size="50" maxlength="50" value="<?php echo  $res9["metr_condrec"];?>"></td>
              <td width="12%"><?php 
			  if(empty($res9["metr_condrec"])){
					$java_apr="if(confirm('A condição do recebimento do Instrumento está comforme?')) {form1.acao.value='aprovar';form1.submit();}else{ return false; }";
				  }
			  else{
					$java_apr="window.alert('Clique em Limpar primeiro');return false;";
				  }		
			  
			  if(!empty($res9["metr_condrec"])){
					$java_limp="if(confirm('Você deseja realmente excluir a Condição de Recebimento?')) { form1.acao.value='limpar';form1.submit();}else{ return false; }";
				}
			  else{
					$java_limp="window.alert('É necessário que a Conformidade do Instrumento esteja aprovada para que possa ser excluída.');return false;";
			  }		

			  ?>
				  <?php if (!($acao=="vis")){?>
				  <label>
				  <input name="botao_apr" type="submit" class="microtxt" id="botao_apr" value="Aprovar" onClick="<?php echo  $java_apr; ?>" <?php if ($acao=="inc"){?> disabled <?php } ?>>
				  </label></td>
              <td width="12%">
			  <input name="limpar" type="submit" class="microtxt" id="limpar" onClick="<?php echo  $java_limp; ?>" value="Limpar" <?php if ($acao=="inc"){?> disabled <?php } ?> >
			  <?php } ?></td>
                </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2" class="textobold"><img src="imagens/dot.gif" width="20" height="8"></td>
          </tr>
        <tr align="center">
          <td height="24" colspan="2" class="textobold">
            <input name="button12" type="button" class="microtxt" value="Voltar" onClick="window.location='metr_cali_hist.php';">
            &nbsp;&nbsp;&nbsp;&nbsp;
			
			<?php if (!($acao=="vis")){
				
				if (($acao=="alt") || ($acao=="aprovar")){ ?>
				<input name="Alterar" type="submit" class="microtxt" value="Alterar">
				<?php } ?>
			
				<?php if($acao=="inc"){ ?> 
				<input name="Incluir" type="submit" class="microtxt" id="Incluir" value="Incluir">
				<?php } ?>
				
		<?php } ?>
            <input type="hidden" name="acao" id="acao2"	value="<?php if($acao=="alt"){ print "alterar"; } else if($acao=="inc"){ print "incluir"; } else if($acao=="limp"){ print "limpar"; } else { print "visualizar"; }?>">
            <input type="hidden" name="id" value= <?php print $id;?>>
			<?php 
			mysql_query("UPDATE metrologia_cad SET metr_tipi_apelido='$res2[tipo]', metr_tipi_nome='$res2[descricao]', metr_func_nome='$res10[nome]', metr_seto_sigla='$res6[sigla]', metr_unid_nome='$res7[apelido]' WHERE metr_cad_id='$id'");
			?></td>
          </tr>
      </table>
    </form></td>
  </tr>
</table>
<blockquote>&nbsp;</blockquote>
</body>
</html>
<?php include("mensagem.php"); ?>