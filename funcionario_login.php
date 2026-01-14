<?php
include("conecta.php");
include("seguranca.php");
if(!empty($acao)){
	$loc="Funcionario_login";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if(empty($acao)){
	$sql=mysql_query("SELECT * FROM cliente_login WHERE funcionario='$id'");
	if(mysql_num_rows($sql)==0){
		$acao="inc";
	}else{
		$acao="alt";
	}
}
$login = "";
$senha = "";
$per = "";
$nivel = "";
$sit = "";
$prim = "";

if($acao=="alt"){
	$sql=mysql_query("SELECT * FROM cliente_login WHERE funcionario='$id'");
	if(mysql_num_rows($sql)!=0){
		$res=mysql_fetch_array($sql);
		$login=$res["login"];
		$senha=$res["senha"];
		$per=$res["perm"];
		$nivel=$res["nivel"];
		$sit=$res["sit"];
		$prim=$res["primeiro"];
	}
}elseif($acao=="alterar"){
	if(!empty($img) && isset($_FILES["img"])){
		if($_FILES["img"]["type"]!="image/x-png"){
			$_SESSION["mensagem"]="A imagem deve ter extensao .png";
			header("Location:funcionario_login.php?id=$id");
			exit;	
		}else{
			$sql=mysql_query("SELECT MAX(assinatura) as assinatura FROM cliente_login WHERE funcionario='$id'");
			$res=mysql_fetch_array($sql);
			$nomeid=$res["assinatura"]+1;
			$arquivo="$patch/assinaturas/$nomeid.png";
			copy($img, "$arquivo");
			$sql=mysql_query("UPDATE cliente_login SET assinatura='$nomeid' WHERE funcionario='$id'");
		}
	}
	if(strlen($senha)<6){
		$_SESSION["mensagem"]="A senha deve ter mais de 6 Digitos!";		
		header("Location:funcionario_login.php?acao=inc&id=$id");
		exit;		
	}else{
		$sql=mysql_query("UPDATE cliente_login SET login='$login',senha='$senha',nivel='$nivel',sit='$sit',perm='$porra',primeiro='$primeiro' WHERE funcionario='$id'");
		if($sql){
			$_SESSION["mensagem"]="Cadastro de login alterado!";
			header("Location:funcionarios.php");
			exit;				
		}else{
			$_SESSION["mensagem"]="O cadastro de login nao pode ser alterado!";
			$acao="alt";
		}	
	}
}elseif($acao=="incluir"){
	$nomeid = 0;
	if(!empty($img) && isset($_FILES["img"])){
		if($_FILES["img"]["type"]!="image/x-png"){
			$_SESSION["mensagem"]="A imagem deve ter extensao .png";
			header("Location:funcionario_login.php?acao=inc&id=$id");
			exit;	
		}else{
			$sql=mysql_query("SELECT MAX(assinatura) as assinatura FROM cliente_login WHERE funcionario='$id'");
			$res=mysql_fetch_array($sql);
			$nomeid=$res["assinatura"]+1;
			$arquivo="$patch/assinaturas/$nomeid.png";
			copy($img, "$arquivo");
		}
	}
	if(strlen($senha)<6){
		$_SESSION["mensagem"]="A senha deve ter mais de 6 Digitos!";		
		header("Location:funcionario_login.php?acao=inc&id=$id");
		exit;		
	}else{
		$sql=mysql_query("SELECT * FROM cliente_login WHERE login='$login'");
		if(!mysql_num_rows($sql)){
			$sql=mysql_query("INSERT INTO cliente_login (funcionario,login,senha,nivel,sit,assinatura,primeiro,perm) VALUES ('$id','$login','$senha','$nivel','$sit','$nomeid','$primeiro','$porra')");
		}else{
			$_SESSION["mensagem"]="Usuario ja existe!";		
			header("Location:funcionario_login.php?id=$id");
			exit;		
		}
		if($sql){
			$_SESSION["mensagem"]="Cadastro de login concluido!";
			header("Location:funcionarios.php");
			exit;				
		}else{
			$_SESSION["mensagem"]="O cadastro de login nao pode ser concluido!";
			$acao="inc";
		}	
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Cadastro de Funcionarios - Login - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.login.value==''){
		alert('Informe o nome de Usuario');
		cad.login.focus();
		return false;
	}
	if(cad.senha.value!=''){
		if(cad.senha2.value==''){
			alert('Confirme a Senha');
			cad.senha2.focus();
			return false;
		}
		if(cad.senha2.value!=cad.senha.value){
			alert('A senha e a confirmacao nao conferem');
			cad.senha2.value='';
			cad.senha2.focus();
			return false;
		}
	}else{
		alert('Informe a senha');
		cad.senha.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-user-lock"></i> Cadastro de Funcionarios - Login</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <form name="form1" method="post" action="" onsubmit="return verifica(this)" enctype="multipart/form-data">
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Usuario</label>
                        <input name="login" type="text" class="erp-form-control" value="<?php echo $login; ?>" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Senha</label>
                        <input name="senha" type="password" class="erp-form-control" value="<?php echo $senha; ?>" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Confirmar Senha</label>
                        <input name="senha2" type="password" class="erp-form-control" value="<?php echo $senha; ?>" maxlength="20">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nivel</label>
                        <select name="nivel" class="erp-form-control">
                            <?php
                            $sql=mysql_query("SELECT * FROM niveis WHERE nome<>'cliente' and nome<>'clientes' ORDER BY nome ASC");
                            while($resniv=mysql_fetch_array($sql)){
                            ?>
                            <option value="<?php echo $resniv["id"]; ?>"<?php if($resniv["id"]==$nivel) echo " selected"; ?>><?php echo $resniv["nome"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Permissao</label>
                        <select name="porra" class="erp-form-control">
                            <option value="">Selecione</option>
                            <option value="4" <?php if($per=="4") echo "selected"; ?>>Total</option>
                            <option value="3" <?php if($per=="3") echo "selected"; ?>>Escrita</option>
                            <option value="2" <?php if($per=="2") echo "selected"; ?>>Exclusao</option>
                            <option value="1" <?php if($per=="1") echo "selected"; ?>>Leitura</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Assinatura Digital</label>
                        <input name="img" type="file" class="erp-form-control">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Situacao</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="sit" type="radio" value="A" <?php if($sit=="A" or empty($sit)) echo "checked"; ?>> Ativo
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="sit" type="radio" value="I" <?php if($sit=="I") echo "checked"; ?>> Inativo
                            </label>
                        </div>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Trocar senha no primeiro acesso</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="primeiro" type="radio" value="S" <?php if($prim=="S") echo "checked"; ?>> Sim
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="primeiro" type="radio" value="N" <?php if($prim=="N") echo "checked"; ?>> Nao
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <?php if($acao=="alt"){ ?>
                <button type="button" class="erp-btn erp-btn-outline" onclick="window.location='funcionarios.php<?php if(!empty($bcod) or!empty($bnome)) echo "?webmst=cpp"; if(!empty($bcod)) echo "&bcod=$bcod"; if(!empty($bnome)) echo "&bnome=$bnome";?>';">
                    Voltar
                </button>
                <?php } ?>
                <button type="submit" class="erp-btn erp-btn-primary">
                    <i class="fas fa-check"></i> Salvar
                </button>
            </div>
            <input name="id" type="hidden" value="<?php echo $id; ?>">
            <input name="acao" type="hidden" value="<?php if($acao=="inc"){ echo "incluir"; }else{ echo "alterar"; } ?>">
        </form>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
