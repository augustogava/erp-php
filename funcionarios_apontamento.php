<?
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="alt";
if($acao=="alterar"){
	$adicional_not=valor2banco($adicional_not);
	$hora_ativ=valor2banco($hora_ativ);
	$hora_aula=valor2banco($hora_aula);
	$sql=mysql_query("UPDATE funcionario_apontamento SET salario_tipo='$salario_tipo',horas='$horas',adicional_not='$adicional_not',horas_falta='$horas_falta',extra='$extra',conjunto_op='$conjunto_op',tolerancia_atraso='$tolerancia_atraso',tolerancia_extra='$tolerancia_extra',horario_princ='$horario_princ',escala_folga='$escala_folga',conjunto_eve='$conjunto_eve',banco_horas='$banco_horas',responsavel='$responsavel',folga_escala='$folga_escala',hora_ativ='$hora_ativ',apontamento_aut='$apontamento_aut',hora_aula='$hora_aula' WHERE cliente='$id'");
	if($sql){
		$_SESSION["mensagem"]="Cadastro de apontamento alterado!";
		header("Location:funcionarios.php?bcod=$bcod&bnome=$bnome");
		exit;		
	}else{
		$_SESSION["mensagem"]="O cadastro de apontamento não pôde ser alterado!";
		$adicional_not=banco2valor($adicional_not);
		$hora_ativ=banco2valor($hora_ativ);
		$hora_aula=banco2valor($hora_aula);				
		$acao="alt";
	}
}elseif($acao=="alt"){
	$sql=mysql_query("SELECT * FROM funcionario_apontamento,clientes WHERE funcionario_apontamento.cliente='$id' AND clientes.id='$id'");
	$res=mysql_fetch_array($sql);
	$salario_tipo=$res["salario_tipo"];
	$horas=$res["horas"];
	$adicional_not=banco2valor($res["adicional_not"]);
	$horas_falta=$res["horas_falta"];
	$extra=$res["extra"];
	$conjunto_op=$res["conjunto_op"];
	$tolerancia_atraso=$res["tolerancia_atraso"];
	$tolerancia_extra=$res["tolerancia_extra"];
	$horario_princ=$res["horario_princ"];
	$escala_folga=$res["escala_folga"];
	$conjunto_eve=$res["conjunto_eve"];
	$banco_horas=$res["banco_horas"];
	$responsavel=$res["responsavel"];
	$folga_escala=$res["folga_escala"];
	$hora_ativ=banco2valor($res["hora_ativ"]);
	$apontamento_aut=$res["apontamento_aut"];
	$hora_aula=banco2valor($res["hora_aula"]);
	$fantasia=$res["fantasia"];
}
?>
<html>
<head>
<title>CyberManager</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function verifica(cad){
	return true;
}
</script>
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="enterativa=1;"onkeypress="return ent()">
<table width="594" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td><form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <table width="450" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2" align="center" bgcolor="#003366" class="textoboldbranco">Cadastro 
              de Funcion&aacute;rios - Apontamento</td>
          </tr>
          <tr class="textobold"> 
            <td width="109">Nome:</td>
            <td width="341"><? print $fantasia; ?></td>
          </tr>
          <tr class="textobold"> 
            <td>Tipo Sal&aacute;rio:</td>
            <td> 
              <input name="salario_tipo" type="text" class="formulario" id="salario_tipo" value="<? print $salario_tipo; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Base de Horas:</td>
            <td>
<input name="horas" type="text" class="formulario" id="horas" onKeyPress="return validanum(this, event)" value="<? print $horas; ?>" size="5" maxlength="4"></td>
          </tr>
          <tr class="textobold"> 
            <td>Adicional Noturno:</td>
            <td>
<input name="adicional_not" type="text" class="formulario" id="adicional_not" value="<? print $adicional_not; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>Horas Desc. Falta:</td>
            <td>
<input name="horas_falta" type="text" class="formulario" id="horas_falta" value="<? print $horas_falta; ?>" size="10" onKeyPress="return validanum(this, event)" onKeyUp="mhora(this)"></td>
          </tr>
          <tr class="textobold"> 
            <td>Horas Extra:</td>
            <td>&nbsp; 
              <input name="extra" type="radio" value="S" <? if($extra=="S" or empty($extra)) print "checked"; ?>>
              Sim 
              <input name="extra" type="radio" value="N" <? if($extra=="N") print "checked"; ?>>
              N&atilde;o </td>
          </tr>
          <tr class="textobold"> 
            <td>Conj. de Op&ccedil;&otilde;es:</td>
            <td> 
              <input name="conjunto_op" type="text" class="formulario" id="conjunto_op" value="<? print $conjunto_op; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Toler&acirc;ncia Atrasos:</td>
            <td> 
              <input name="tolerancia_atraso" type="text" class="formulario" id="tolerancia_atraso" value="<? print $tolerancia_atraso; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Toler&acirc;ncia Extra:</td>
            <td> 
              <input name="tolerancia_extra" type="text" class="formulario" id="tolerancia_extra" value="<? print $tolerancia_extra; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Hor&aacute;rio Principal:</td>
            <td> 
              <input name="horario_princ" type="text" class="formulario" id="horario_princ" value="<? print $horario_princ; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Escala de Folga:</td>
            <td> 
              <input name="escala_folga" type="text" class="formulario" id="escala_folga" value="<? print $escala_folga; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Conj. de Eventos:</td>
            <td> 
              <input name="conjunto_eve" type="text" class="formulario" id="conjunto_eve" value="<? print $conjunto_eve; ?>" size="20" maxlength="20"></td>
          </tr>
          <tr class="textobold"> 
            <td>Banco de Horas:</td>
            <td>&nbsp; 
              <input name="banco_horas" type="radio" value="S" <? if($banco_horas=="S" or empty($banco_horas)) print "checked"; ?>>
              Sim 
              <input name="banco_horas" type="radio" value="N" <? if($banco_horas=="N") print "checked"; ?>>
              N&atilde;o </td>
          </tr>
          <tr class="textobold"> 
            <td>Respons&aacute;vel:</td>
            <td> 
              <input name="responsavel" type="text" class="formularioselect" id="responsavel" value="<? print $responsavel; ?>" size="63" maxlength="50"></td>
          </tr>
          <tr class="textobold"> 
            <td>Folga por Escala:</td>
            <td>&nbsp; 
              <input name="folga_escala" type="radio" value="S" <? if($folga_escala=="S" or empty($folga_escala)) print "checked"; ?>>
              Sim 
              <input name="folga_escala" type="radio" value="N" <? if($folga_escala=="N") print "checked"; ?>>
              N&atilde;o </td>
          </tr>
          <tr class="textobold"> 
            <td>% Hora Atividade:</td>
            <td>
<input name="hora_ativ" type="text" class="formulario" id="hora_ativ" value="<? print $hora_ativ; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"></td>
          </tr>
          <tr class="textobold"> 
            <td>Apontamento Aut.:</td>
            <td>&nbsp; 
              <input name="apontamento_aut" type="radio" value="S" <? if($apontamento_aut=="S" or empty($apontamento_aut)) print "checked"; ?>>
              Sim 
              <input name="apontamento_aut" type="radio" value="N" <? if($apontamento_aut=="N") print "checked"; ?>>
              N&atilde;o </td>
          </tr>
          <tr class="textobold"> 
            <td>% DSR Hora Aula:</td>
            <td>
<input name="hora_aula" type="text" class="formulario" id="hora_aula" value="<? print $hora_aula; ?>" size="10" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))"> 
              <input name="id" type="hidden" id="id3" value="<? print $id; ?>"> 
              <input name="acao" type="hidden" id="acao" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>"></td>
          </tr>
          <tr class="textobold"> 
            <td colspan="2" align="center"> 
              <? if($acao=="alt"){ ?>
              
              <input name="Submit22" type="button" class="microtxt" value="voltar" onClick="window.location='funcionarios.php<? if(!empty($bcod) or!empty($bnome)) print "?webmst=cpp"; if(!empty($bcod)) print "&bcod=$bcod"; if(!empty($bnome)) print "&bnome=$bnome";?>'">
           
              <img src="imagens/dot.gif" width="50" height="5"> 
              <? } ?>
              <input name="Submit2" type="submit" class="microtxt" value="Continuar"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
&nbsp; 
</body>
</html>
<? include("mensagem.php"); ?>