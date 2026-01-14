<?
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Clientes Login";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
		if(!empty($cnpj)){
			if(!CalculaCNPJ($cnpj)){
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:crm_clientes_geral.php?acao=inc&tipop=$tipop");
					exit;
			}
		}
		if(!empty($cpf)){
			if(!CalculaCpf($cpf)){
					$_SESSION["mensagem"]="CPF Incorreto!";
					header("Location:crm_clientes_geral.php?acao=inc&tipop=$tipop");
					exit;
			}
		}
	if(empty($fantasia)) $fantasia=$nome;
	$hj=date("Y-m-d");
	$sql=mysql_query("INSERT INTO clientes (loja,nome,fantasia,status,tipo,endereco,bairro,cep,cidade,estado,fone,fax,cnpj,cpf,ie,im,vendedor,comissao,regiao,contabil,banco1,banco2,banco3,banco4,banco5,email,site,grupo,porte_che,porte_fun,porte_fat,ramo,complemento,ddd,dddf,origem_cad,data,ddd2,fone2) VALUES ('$loja','$nome','$fantasia','$status','$tipo','$endereco','$bairro','$cep','$cidade','$estado','$fone','$fax','$cnpj','$cpf','$ie','$im','$vendedor','$comissao','$regiao','$contabil','$banco1','$banco2','$banco3','$banco4','$banco5','$email','$site','$aba','$porte_che','$porte_fun','$porte_fat','$ramo','$complemento','$ddd','$dddf','$origem','$hj','$ddd2','$fone2')");
	if($sql){
		$_SESSION["mensagem"]="Cadastro geral concluído!";
		$sql=mysql_query("select max(id)as maxid from clientes");
		$res=mysql_fetch_array($sql);
		$id=$res["maxid"];
		header("Location:clientes_cobranca.php?id=$id&acao=inc&bcod=$bcod&bnome=$bnome");
		exit;
	}else{
		$_SESSION["mensagem"]="O cadastro geral não pôde ser concluído!";
		$comissao=banco2valor($comissao);		
		$acao="inc";
	}	
}elseif($acao=="alterar"){
	if(!empty($cnpj)){
		if(!CalculaCNPJ($cnpj)){
					$_SESSION["mensagem"]="CNPJ Incorreto!";
					header("Location:crm_clientes_geral.php?acao=inc&tipop=$tipop");
					exit;
			}
		}
		if(!empty($cpf)){
			if(!CalculaCpf($cpf)){
					$_SESSION["mensagem"]="CPF Incorreto!";
					header("Location:crm_clientes_geral.php?acao=inc&tipop=$tipop");
					exit;
			}
		}
	if(empty($fantasia)) $fantasia=$nome;
	$sql=mysql_query("UPDATE clientes SET loja='$loja',nome='$nome',fantasia='$fantasia',status='$status',tipo='$tipo',endereco='$endereco',bairro='$bairro',cep='$cep',cidade='$cidade',estado='$estado',fone='$fone',fax='$fax',cnpj='$cnpj',cpf='$cpf',ie='$ie',im='$im',vendedor='$vendedor',comissao='$comissao',regiao='$regiao',contabil='$contabil',banco1='$banco1',banco2='$banco2',banco3='$banco3',banco4='$banco4',banco5='$banco5',email='$email',site='$site',grupo='$aba',porte_che='$porte_che',porte_fun='$porte_fun',porte_fat='$porte_fat',ramo='$ramo',complemento='$complemento',ddd='$ddd',dddf='$dddf',origem_cad='$origem',atualizacao=NOW(),ddd2='$ddd2',fone2='$fone2' WHERE id='$id'");
	//update cobranca
		$sqlco=mysql_query("SELECT * FROM cliente_cobranca WHERE cliente='$id'");
		if(mysql_num_rows($sqlco)){
			$sql=mysql_query("UPDATE cliente_cobranca SET endereco='$endereco_cob',bairro='$bairro_cob',cep='$cep_cob',cidade='$cidade_cob',estado='$estado_cob' WHERE cliente='$id'");
		}else{
			$sql=mysql_query("INSERT INTO cliente_cobranca (cliente,endereco,bairro,cep,cidade,estado) values('$id','$endereco_cob','$bairro_cob','$cep_cob','$cidade_cob','$estado_cob')");
		}
		//update entrega
		$sqlen=mysql_query("SELECT * FROM cliente_entrega WHERE cliente='$id'");
		if(mysql_num_rows($sqlen)){
			$sql=mysql_query("UPDATE cliente_entrega SET endereco='$endereco_ent',bairro='$bairro_ent',cep='$cep_ent',cidade='$cidade_ent',estado='$estado_ent',endereco_ins='$endereco_ins',bairro_ins='$bairro_ins',cep_ins='$cep_ins',cidade_ins='$cidade_ins',estado_ins='$estado_ins' WHERE cliente='$id'");
		}else{
			$sql=mysql_query("INSERT INTO cliente_entrega (cliente,endereco,bairro,cep,cidade,estado,endereco_ins,bairro_ins,cep_ins,cidade_ins,estado_ins) VALUES('$id','$endereco_ent','$bairro_ent','$cep_ent','$cidade_ent','$estado_ent','$endereco_ins','$bairro_ins','$cep_ins','$cidade_ins','$estado_ins')");
		}

	if($sql){
		if(empty($venda)){
			print "<script>window.alert('Cadastrado com sucesso!'); window.close();</script>";	
		}else{
			header("Location:crm_infg.php?cli=$id");
			exit;
		}
	}else{
		$_SESSION["mensagem"]="O cadastro geral não pôde ser alterado!";
		$comissao=banco2valor($comissao);				
		$acao="alt";
	}
}
if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM clientes WHERE id='$id'");
	$res=mysql_fetch_array($sql);
	if(empty($res["cpf"])){
		$cpfcnpj=$res["cnpj"];
		$tipop="J";
	}else{
		$cpfcnpj=$res["cpf"];
		$tipop="F";
	}
	$loja=$res["loja"];
	$nome=$res["nome"];
	$fantasia=$res["fantasia"];
	$status=$res["status"];
	$tipo=$res["tipo"];
	$origem=$res["origem_cad"];
	$atividade=$res["atividade"];
	$endereco=$res["endereco"];
	$complemento=$res["complemento"];
	$bairro=$res["bairro"];
	$cep=$res["cep"];
	$cidade=$res["cidade"];
	$estado=$res["estado"];
	$ddd=$res["ddd"];
	$ddd2=$res["ddd2"];
	$dddf=$res["dddf"];
	$fone=$res["fone"];
	$fone2=$res["fone2"];
	$fax=$res["fax"];
	$ramo=$res["ramo"];
	$porte_che=$res["porte_che"];
	$porte_fun=$res["porte_fun"];
	$porte_fat=$res["porte_fat"];
	$grupo=$res["grupo"];
	$ie=$res["ie"];
	$cpf=$res["cpf"];
	$cnpj=$res["cnpj"];
	$im=$res["im"];
	$vendedor=$res["vendedor"];
	$comissao=number_format($res["comissao"],2,",",".");
	$regiao=$res["regiao"];
	$contabil=$res["contabil"];
	$banco1=$res["banco1"];
	$banco2=$res["banco2"];
	$banco3=$res["banco3"];
	$banco4=$res["banco4"];
	$banco5=$res["banco5"];
	$email=$res["email"];
	$site=$res["site"];
	//cobranca
	$sql2=mysql_query("SELECT * FROM cliente_cobranca WHERE cliente='$id'");
	$res2=mysql_fetch_array($sql2);
	$endereco_cob=$res2["endereco"];
	$bairro_cob=$res2["bairro"];
	$cep_cob=$res2["cep"];
	$cidade_cob=$res2["cidade"];
	$estado_cob=$res2["estado"];
	
	$sql3=mysql_query("SELECT * FROM cliente_entrega WHERE cliente='$id'");
	$res3=mysql_fetch_array($sql3);
	
	$endereco_ent=$res3["endereco"];
	$bairro_ent=$res3["bairro"];
	$cep_ent=$res3["cep"];
	$cidade_ent=$res3["cidade"];
	$estado_ent=$res3["estado"];

	$endereco_ins=$res3["endereco_ins"];
	$bairro_ins=$res3["bairro_ins"];
	$cep_ins=$res3["cep_ins"];
	$cidade_ins=$res3["cidade_ins"];
	$estado_ins=$res3["estado_ins"];

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
<script src="ajax.js"></script>
<script src="ajax2.js" type="text/javascript"></script>
<script src="funcoes.js" type="text/javascript"></script>
<script>
function cobranca(){
	if (document.form1.mesmo.checked==true){
		document.form1.endereco_cob.value=document.form1.endereco.value;
		document.form1.bairro_cob.value=document.form1.bairro.value;
		document.form1.cep_cob.value=document.form1.cep.value;
		document.form1.estado_cob.value=document.form1.estado.value;
		document.form1.cidade_cob.value=document.form1.cidade.value;

	}else{
		document.form1.endereco_cob.value='';
		document.form1.bairro_cob.value='';
		document.form1.cep_cob.value='';
		document.form1.estado_cob.value='';
		document.form1.cidade_cob.value='';
	}
}
function entrega(){
	if (document.form1.mesmo2.checked==true){
		document.form1.endereco_ent.value=document.form1.endereco.value;
		document.form1.bairro_ent.value=document.form1.bairro.value;
		document.form1.cep_ent.value=document.form1.cep.value;
		document.form1.estado_ent.value=document.form1.estado.value;
		document.form1.cidade_ent.value=document.form1.cidade.value;
	
	}else{
		document.form1.endereco_ent.value='';
		document.form1.bairro_ent.value='';
		document.form1.cep_ent.value='';
		document.form1.estado_ent.value='';
		document.form1.cidade_ent.value='';
	}
}
function inst(){
	if (document.form1.mesmo3.checked==true){
		document.form1.endereco_ins.value=document.form1.endereco.value;
		document.form1.bairro_ins.value=document.form1.bairro.value;
		document.form1.cep_ins.value=document.form1.cep.value;
		document.form1.estado_ins.value=document.form1.estado.value;
		document.form1.cidade_ins.value=document.form1.cidade.value;
	
	}else{
		document.form1.endereco_ins.value='';
		document.form1.bairro_ins.value='';
		document.form1.cep_ins.value='';
		document.form1.estado_ins.value='';
		document.form1.cidade_ins.value='';
	}
}
function limpa(sele){
	if(sele==1){
		form1.porte_fun.value=0;
		form1.porte_fat.value=0;
	}else if(sele==2){
		form1.porte_che.value=0;
		form1.porte_fat.value=0;
	}else if(sele==3){
		form1.porte_che.value=0;
		form1.porte_fun.value=0;
	}
}
function verifica(cad){
	if(cad.nome.value==''){
		alert('Preencha o Nome');
		cad.nome.focus();
		return false;
	}
	<? if($tipop=="J"){ ?>
	if(cad.fantasia.value==''){
		alert('Preencha a Fantasia');
		cad.fantasia.focus();
		return false;
	}
	if(cad.aba.value==''){
		alert('Selecione o Grupo');
		cad.aba.focus();
		return false;
	}
	
	if(cad.porte_che.value==''){
		if(cad.porte_fun.value==''){
			if(cad.porte_fat.value==''){
				alert('Selecione o Porte');
				cad.porte_che.focus();
				return false;
			}	
		}
	}
	<? } ?>
	if(cad.ramo.value==''){
		alert('Selecione o Ramo de Atividade');
		cad.ramo.focus();
		return false;
	}
	if(cad.endereco.value==''){
		alert('Preencha o Endereço');
		cad.endereco.focus();
		return false;
	}
	if(cad.bairro.value==''){
		alert('Preencha o Bairro');
		cad.bairro.focus();
		return false;
	}
	if(cad.cep.value==''){
		alert('Preencha o CEP');
		cad.cep.focus();
		return false;
	}
	if(cad.cidade.value==''){
		alert('Preencha a Cidade');
		cad.cidade.focus();
		return false;
	}
	if(cad.estado.value==''){
		alert('Selecione o Estado');
		cad.estado.focus();
		return false;
	}
	if(cad.fone.value==''){
		alert('Preencha o Fone');
		cad.fone.focus();
		return false;
	}
	<? if($tipop=="F"){ ?>
	if(cad.cpf.value==''){
		alert('Preencha o CPF');
		cad.cpf.focus();
		return false;
	}
	<? } ?>
	if(cad.email.value!=''){
		if(!verifica_email(cad.email.value)){
			alert('Email Inválido');
			cad.email.focus();
			return false;
		}
	}

	if(cad.origem.value==''){
		alert('Selecione a origem');
		cad.origem.focus();
		return false;
	}
//Endereco Cobrança
	if(cad.endereco_cob.value==''){
		alert('Preencha o Endereço');
		cad.endereco_cob.focus();
		return false;
	}
	if(cad.bairro_cob.value==''){
		alert('Preencha o Bairro');
		cad.bairro_cob.focus();
		return false;
	}
	if(cad.cep_cob.value==''){
		alert('Preencha o CEP');
		cad.cep_cob.focus();
		return false;
	}
	if(cad.cidade_cob.value==''){
		alert('Preencha a Cidade');
		cad.cidade_cob.focus();
		return false;
	}
	if(cad.estado_cob.value==''){
		alert('Selecione o Estado');
		cad.estado_cob.focus();
		return false;
	}
//Endereco Entrega
	if(cad.endereco_ent.value==''){
		alert('Preencha o Endereço');
		cad.endereco_ent.focus();
		return false;
	}
	if(cad.bairro_ent.value==''){
		alert('Preencha o Bairro');
		cad.bairro_ent.focus();
		return false;
	}
	if(cad.cep_ent.value==''){
		alert('Preencha o CEP');
		cad.cep_ent.focus();
		return false;
	}
	if(cad.cidade_ent.value==''){
		alert('Preencha a Cidade');
		cad.cidade_ent.focus();
		return false;
	}
	if(cad.estado_ent.value==''){
		alert('Selecione o Estado');
		cad.estado_ent.focus();
		return false;
	}
//Endereco Instalacao 
	if(cad.endereco_ins.value==''){
		alert('Preencha o Endereço');
		cad.endereco_ins.focus();
		return false;
	}
	if(cad.bairro_ins.value==''){
		alert('Preencha o Bairro');
		cad.bairro_ins.focus();
		return false;
	}
	if(cad.cep_ins.value==''){
		alert('Preencha o CEP');
		cad.cep_ins.focus();
		return false;
	}
	if(cad.cidade_ins.value==''){
		alert('Preencha a Cidade');
		cad.cidade_ins.focus();
		return false;
	}
	if(cad.estado_ins.value==''){
		alert('Selecione o Estado');
		cad.estado_ins.focus();
		return false;
	}
	if(confirm('Já Verificou o cadastro?')){
		return true;
	}else{
		return false;
	}
	return true;
}
</script>

<style type="text/css">
<!--
.style2 {font-size: 14px}
-->
</style>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;<? if($tipop=="J"){ print "javascript:Atualiza6('atualiza_grupo.php?pr=c',this.value)"; } ?>"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="502" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" align="center" class="titulos"><table width="433" border="0" align="left" cellpadding="0" cellspacing="0" class="texto">
              <tr>
                <td align="center"><div align="left"><img src="imagens/icon14_ahn.gif" width="14" height="14" onMouseOver="this.T_TITLE='Campos Preenchimentos obrigatorio'; this.T_DELAY=10; this.T_WIDTH=225;  return escape('Nome: Entre com nome&lt;br&gt;Nascimento: xx/xx/xxxx&lt;br&gt;RG: xx.xxx.xxx-x&lt;br&gt;Cart. Profissional: xxxxx&lt;br&gt;Admiss&atilde;o: xx/xx/xxxx&lt;br&gt;Cargo: Escolha um item na lista')" /><span class="impTextoBold">&nbsp;</span></div></td>
                <td align="right"><div align="left" class="titulos">Cadastro de 
                  Clientes - Geral</div></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td width="25" align="center" class="titulos">&nbsp;</td>
                <td width="362" align="right" class="titulos">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr class="textobold">
            <td width="109">&nbsp;Nome:</td>
            <td width="393"><input name="nome" type="text" class="formulario" id="nome" value="<? print $nome; ?>" size="50" maxlength="100" /></td>
          </tr>
		  <? if($tipop=="J"){ ?>
          <tr class="textobold">
            <td>&nbsp;Fantasia:</td>
            <td><input name="fantasia" type="text" class="formulario" id="fantasia" value="<? print $fantasia; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Loja:</td>
            <td><input name="loja" type="text" class="formulario" id="loja" value="<? print $loja; ?>" size="10" /></td>
          </tr>
		  <? } ?>
		  <? if($tipop=="J"){ ?>
          <tr class="textobold">
            <td>&nbsp;Grupo:</td>
            <td><div id="grupo_atu"></div><span id="campo1"><span onClick=" editar(1, this, 1, 'nome');">Clique aqui para inserir um Grupo</span></span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Porte:</td>
            <td><table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="textoboldbranco"><div align="center">CheckOuts</div></td>
                  <td class="textoboldbranco"><div align="center">Funcion&aacute;rios</div></td>
                  <td class="textoboldbranco"><div align="center">Faturamento</div></td>
                </tr>
                <tr>
                  <td class="texto"><select name="porte_che" class="formularioselect" id="porte_che">
                    <option selected="">Selecione</option>
                    <option value="1" <? if($porte_che=="1"){ print "selected"; } ?>>De 1 a 3</option>
                    <option value="2" <? if($porte_che=="2"){ print "selected"; } ?>>3 a 10</option>
                    <option value="3" <? if($porte_che=="3"){ print "selected"; } ?>>acima de 10</option>
                  </select></td>
                  <td class="texto"><select name="porte_fun" class="formularioselect" id="porte_fun">
                    <option selected="">Selecione</option>
                    <option value="1" <? if($porte_fun=="1"){ print "selected"; } ?>>De 1 a 20</option>
                    <option value="2" <? if($porte_fun=="2"){ print "selected"; } ?>>20 a 100</option>
                    <option value="3" <? if($porte_fun=="3"){ print "selected"; } ?>>acima de 100</option>
                  </select></td>
                  <td class="texto"><select name="porte_fat" class="formularioselect" id="porte_fat">
                    <option selected="">Selecione</option>
                    <option value="1" <? if($porte_fat=="1"){ print "selected"; } ?>>Até R$ 1.000.000</option>
                    <option value="2" <? if($porte_fat=="2"){ print "selected"; } ?>>de 1.000.000 a 5.000.000</option>
                    <option value="3" <? if($porte_fat=="3"){ print "selected"; } ?>>acima de 5.000.000</option>
                  </select></td>
                </tr>
              </table></td>
          </tr>		  
          <tr class="textobold">
            <td>&nbsp;Ramo Atividade: </td>
            <td><select name="ramo" class="textobold" id="select3">
              <option selected="selected">Selecione</option>
              <? $sql=mysql_query("select * from ramo ORDER By nome ASC");
			while($res=mysql_fetch_array($sql)){
			 ?>
              <option value="<?= $res["id"]; ?>" <? if($ramo==$res["id"]){ print "selected"; } ?>>
                <?= $res["nome"]; ?>
                </option>
              <? } ?>
            </select></td>
          </tr>
           <? } ?>
          
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco" type="text" class="formulario" id="endereco" value="<? print $endereco; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Complemento:</td>
            <td><input name="complemento" type="text" class="formulario" id="complemento" value="<? print $complemento; ?>" size="10" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro" type="text" class="formulario" id="bairro" value="<? print $bairro; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep" type="text" class="formulario" id="cep" value="<? print $cep; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Estado:</td>
            <td><span class="texto">
              <select name="estado" id="estado" class="formulario">
                <option>Selecione</option>
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
            <td>&nbsp;Cidade:</td>
            <td><input name="cidade" type="text" class="formulario" id="cidade" value="<? print $cidade; ?>" size="50" maxlength="30"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Tel:</td>
            <td><input name="ddd" type="text" class="formulario" id="ddd" value="<? print $ddd; ?>" size="2" maxlength="15" onKeyPress="return validanum(this, event)" />
            <input name="fone" type="text" class="formulario" id="fone" value="<? print $fone; ?>" size="20" maxlength="15" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Tel2:</td>
            <td><input name="ddd2" type="text" class="formulario" id="ddd2" value="<? print $ddd2; ?>" size="2" maxlength="15" onKeyPress="return validanum(this, event)" />
                <input name="fone2" type="text" class="formulario" id="fone2" value="<? print $fone2; ?>" size="20" maxlength="15" /></td>
          </tr>
          
          <tr class="textobold">
            <td>&nbsp;Fax:</td>
            <td><input name="dddf" type="text" class="formulario" id="dddf" value="<? print $dddf; ?>" size="2" maxlength="15" onKeyPress="return validanum(this, event)" />
            <input name="fax" type="text" class="formulario" id="fax" value="<? print $fax; ?>" size="20" maxlength="15" /></td>
          </tr>
		  <? if($tipop=="J"){ ?>
          
		  <? } ?>
		  <? if($tipop=="J"){ ?>
          
		  <? } if($tipop=="F"){ ?>
          <tr class="textobold">
            <td>&nbsp;CPF</td>
            <td><input name="cpf" type="text" class="formulario" id="cpf" value="<? print $cpf; ?>" size="20" maxlength="16" onKeyPress="return validanum(this, event)" onKeyUp="mcpf(this)" /></td>
          </tr>
		  <? }else if($tipop=="J"){ ?>
          <tr class="textobold">
            <td>&nbsp;CNPJ</td>
            <td><input name="cnpj" type="text" class="formulario" id="cnpj" value="<? print $cnpj; ?>" size="20" maxlength="20" onKeyPress="return validanum(this, event)" onKeyUp="mcgc(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ins. Estadual:</td>
            <td><input name="ie" type="text" class="formulario" id="ie" value="<? print $ie; ?>" size="20" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Ins. Municipal:</td>
            <td><input name="im" type="text" class="formulario" id="im" value="<? print $im; ?>" size="20" maxlength="30" /></td>
          </tr>
		  <? } ?>
          
          
          <tr class="textobold">
            <td>&nbsp;Email:</td>
            <td><input name="email" type="text" class="formulario" id="email" value="<? print $email; ?>" size="50" maxlength="50" /></td>
          </tr>
		  <? if($tipop=="J"){ ?>
          <tr class="textobold">
            <td>&nbsp;Site:</td>
            <td><input name="site" type="text" class="formulario" id="site" value="<? print $site; ?>" size="50" maxlength="50" /></td>
          </tr>
		   <? } ?>
          <tr class="textobold">
            <td>&nbsp;Origem:</td>
            <td><select name="origem" class="textobold" id="origem">
                <option selected="selected">Selecione</option>
				<option value="mkr" <? if($origem=="mkr"){ print "selected"; } ?>>MKR</option>
				<option value="site" <? if($origem=="site"){ print "selected"; } ?>>Site</option>
				<option value="ativo" <? if($origem=="ativo"){ print "selected"; } ?>>Ativo</option>
                <option value="Receptivo" <? if($origem=="receptivo"){ print "selected"; } ?>>Receptivo</option>
                <option value="bd" <? if($origem=="bd"){ print "selected"; } ?>>BD Externo</option>
                <option value="Representante" <? if($origem=="representante"){ print "selected"; } ?>>Representante</option>
              </select>
              <input name="id" type="hidden" id="id" value="<? print $id; ?>" />
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="textobold">
            <td colspan="2" class="titulos"><input name="mesmo" type="checkbox" id="mesmo" value="S" onClick="cobranca()">Endere&ccedil;o Cobran&ccedil;a </td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco_cob" type="text" class="formulario" id="endereco_cob" value="<? print $endereco_cob; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro_cob" type="text" class="formulario" id="bairro_cob" value="<? print $bairro_cob; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep_cob" type="text" class="formulario" id="cep_cob" value="<? print $cep_cob; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Estado:</td>
            <td><span class="texto">
              <select name="estado_cob" id="select4"  class="formulario">
                <option>Selecione</option>
                <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$estado_cob){ print "selected"; } ?>>
                <?= $res2["nome"]; ?>
                </option>
                <? } ?>
              </select>
            </span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Cidade:</td>
            <td>
              <input name="cidade_cob" type="text" class="formulario" id="cidade_cob" value="<? print $cidade_cob; ?>" size="50" maxlength="30">			</td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="textobold">
            <td colspan="2"><span class="titulos"><span class="menu">
              <input name="mesmo2" type="checkbox" id="mesmo2" value="S" onClick="entrega()">
            </span>Endere&ccedil;o Entrega </span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco_ent" type="text" class="formulario" id="endereco_ent" value="<? print $endereco_ent; ?>" size="50" maxlength="100"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro_ent" type="text" class="formulario" id="bairro_ent" value="<? print $bairro_ent; ?>" size="50" maxlength="30"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep_ent" type="text" class="formulario" id="cep_ent" value="<? print $cep_ent; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)"></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Estado:</td>
            <td><span class="texto">
              <select name="estado_ent" id="estado_ent"  class="formulario">
                <option>Selecione</option>
                <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$estado_ent){ print "selected"; } ?>>
                <?= $res2["nome"]; ?>
                </option>
                <? } ?>
              </select>
            </span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Cidade:</td>
            <td>
              <input name="cidade_ent" type="text" class="formulario" id="cidade_ent" value="<? print $cidade_ent; ?>" size="50" maxlength="30">		</td>
          </tr>
          <tr class="textobold">
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr class="textobold">
            <td colspan="2" class="titulos"><span class="menu">
              <input name="mesmo3" type="checkbox" id="mesmo3" value="S" onClick="inst()">
            </span>Endere&ccedil;o Instala&ccedil;&atilde;o </td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Endere&ccedil;o:</td>
            <td><input name="endereco_ins" type="text" class="formulario" id="endereco_ins" value="<? print $endereco_ins; ?>" size="50" maxlength="100" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Bairro:</td>
            <td><input name="bairro_ins" type="text" class="formulario" id="bairro_ins" value="<? print $bairro_ins; ?>" size="50" maxlength="30" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;CEP: </td>
            <td><input name="cep_ins" type="text" class="formulario" id="cep_ins" value="<? print $cep_ins; ?>" size="10" maxlength="9" onKeyPress="return validanum(this, event)" onKeyUp="mcep(this)" /></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Estado:</td>
            <td><span class="texto">
              <select name="estado_ins" id="select6"  class="formulario">
                <option>Selecione</option>
                <?
	$sql2=mysql_query("SELECT * FROM estado") or die("nao foi");
	while($res2=mysql_fetch_array($sql2)){
	?>
                <option value="<?= $res2["id"]; ?>" <? if($res2["id"]==$estado_ins){ print "selected"; } ?>>
                <?= $res2["nome"]; ?>
                </option>
                <? } ?>
              </select>
            </span></td>
          </tr>
          <tr class="textobold">
            <td>&nbsp;Cidade:</td>
            <td>
              <input name="cidade_ins" type="text" class="formulario" id="cidade_ins" value="<? print $cidade_ins; ?>" size="50" maxlength="30">			</td>
          </tr>
          <tr class="textobold">
            <td colspan="2" align="center">
               
                <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066">
                <input name="venda" type="hidden" id="venda" value="<? print $venda; ?>" />
                <input name="id" type="hidden" id="id" value="<? print $id; ?>" />
                <input name="acao2" type="hidden" id="acao2" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>" />
                </font>
                <input name="voltar" type="button" class="microtxt" id="voltar" value="Voltar" onClick="history.go(-1)" />
              &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit" type="submit" class="microtxt" value="Continuar" />			  </td>
          </tr>
        </table>
      </form>
	   <? if($acao=="alt"){ if($tipop=="J"){ ?>
	<script>
		setTimeout('document.form1.aba.value=<?= $grupo ?>',1400);
		
		</script>
	  <? } } ?>
	  </td>
  </tr>
</table>
</body>
</html>
<? include("mensagem.php"); ?>