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
		$_SESSION["mensagem"]="O cadastro de apontamento nao pode ser alterado!";
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
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Funcionarios - Apontamento</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="mascaras.js"></script>
<script src="scripts.js"></script>
<script>
function verifica(cad){
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-clock"></i> Funcionarios - Apontamento</h1>
            <div>
                <a href="funcionarios.php?bcod=<?=$bcod?>&bnome=<?=$bnome?>" class="erp-btn erp-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-<?=strpos($_SESSION["mensagem"],'alterado')!==false||strpos($_SESSION["mensagem"],'sucesso')!==false?'success':'danger'?>">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>

    <form name="form1" method="post" action="" onSubmit="return verifica(this)">
        <input name="id" type="hidden" value="<? print $id; ?>">
        <input name="bcod" type="hidden" value="<? print $bcod; ?>">
        <input name="bnome" type="hidden" value="<? print $bnome; ?>">
        <input name="acao" type="hidden" value="<? if($acao=="inc"){ print "incluir"; }else{ print "alterar"; } ?>">

        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-user"></i> Dados</h3>

            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome</label>
                        <input type="text" class="erp-form-control" value="<? print $fantasia; ?>" disabled>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tipo Salario</label>
                        <input name="salario_tipo" type="text" class="erp-form-control" id="salario_tipo" value="<? print $salario_tipo; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Base de Horas</label>
                        <input name="horas" type="text" class="erp-form-control" id="horas" onKeyPress="return validanum(this, event)" value="<? print $horas; ?>" maxlength="4">
                    </div>
                </div>
            </div>

            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Adicional Noturno</label>
                        <input name="adicional_not" type="text" class="erp-form-control" id="adicional_not" value="<? print $adicional_not; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Horas Desc. Falta</label>
                        <input name="horas_falta" type="text" class="erp-form-control" id="horas_falta" value="<? print $horas_falta; ?>" onKeyPress="return validanum(this, event)" onKeyUp="mhora(this)">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Horas Extra</label>
                        <div style="display:flex;gap:16px;align-items:center;height:42px;">
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="extra" type="radio" value="S" <? if($extra=="S" or empty($extra)) print "checked"; ?>>
                                <span>Sim</span>
                            </label>
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="extra" type="radio" value="N" <? if($extra=="N") print "checked"; ?>>
                                <span>Nao</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Conj. de Opcoes</label>
                        <input name="conjunto_op" type="text" class="erp-form-control" id="conjunto_op" value="<? print $conjunto_op; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tolerancia Atrasos</label>
                        <input name="tolerancia_atraso" type="text" class="erp-form-control" id="tolerancia_atraso" value="<? print $tolerancia_atraso; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Tolerancia Extra</label>
                        <input name="tolerancia_extra" type="text" class="erp-form-control" id="tolerancia_extra" value="<? print $tolerancia_extra; ?>" maxlength="20">
                    </div>
                </div>
            </div>

            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Horario Principal</label>
                        <input name="horario_princ" type="text" class="erp-form-control" id="horario_princ" value="<? print $horario_princ; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Escala de Folga</label>
                        <input name="escala_folga" type="text" class="erp-form-control" id="escala_folga" value="<? print $escala_folga; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Conj. de Eventos</label>
                        <input name="conjunto_eve" type="text" class="erp-form-control" id="conjunto_eve" value="<? print $conjunto_eve; ?>" maxlength="20">
                    </div>
                </div>
            </div>

            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Banco de Horas</label>
                        <div style="display:flex;gap:16px;align-items:center;height:42px;">
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="banco_horas" type="radio" value="S" <? if($banco_horas=="S" or empty($banco_horas)) print "checked"; ?>>
                                <span>Sim</span>
                            </label>
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="banco_horas" type="radio" value="N" <? if($banco_horas=="N") print "checked"; ?>>
                                <span>Nao</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Responsavel</label>
                        <input name="responsavel" type="text" class="erp-form-control" id="responsavel" value="<? print $responsavel; ?>" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Folga por Escala</label>
                        <div style="display:flex;gap:16px;align-items:center;height:42px;">
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="folga_escala" type="radio" value="S" <? if($folga_escala=="S" or empty($folga_escala)) print "checked"; ?>>
                                <span>Sim</span>
                            </label>
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="folga_escala" type="radio" value="N" <? if($folga_escala=="N") print "checked"; ?>>
                                <span>Nao</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">% Hora Atividade</label>
                        <input name="hora_ativ" type="text" class="erp-form-control" id="hora_ativ" value="<? print $hora_ativ; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Apontamento Aut.</label>
                        <div style="display:flex;gap:16px;align-items:center;height:42px;">
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="apontamento_aut" type="radio" value="S" <? if($apontamento_aut=="S" or empty($apontamento_aut)) print "checked"; ?>>
                                <span>Sim</span>
                            </label>
                            <label style="display:flex;gap:8px;align-items:center;margin:0;">
                                <input name="apontamento_aut" type="radio" value="N" <? if($apontamento_aut=="N") print "checked"; ?>>
                                <span>Nao</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">% DSR Hora Aula</label>
                        <input name="hora_aula" type="text" class="erp-form-control" id="hora_aula" value="<? print $hora_aula; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))">
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="funcionarios.php?bcod=<?=$bcod?>&bnome=<?=$bnome?>" class="erp-btn erp-btn-secondary">Cancelar</a>
            <button type="submit" class="erp-btn erp-btn-success">Continuar</button>
        </div>
    </form>
</div>

<? include("mensagem.php"); ?>
</body>
</html>