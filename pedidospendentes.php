<?php
include("conecta.php");
include("seguranca.php");
$acao=Input::request("acao");
$data=Input::request("data");
$id=Input::request("id");
$buscar=Input::request("buscar");
$qtecnico="vendas@cyberhosting.com.br";
$busca = "";
if(!empty($data)){
	$data=data2banco($data);
	$busca="AND e_compra.data='$data'";
}

if($acao=="envmail"){
	$sql=mysql_query("SELECT clientes.email FROM clientes,e_compra WHERE e_compra.id='$id' AND e_compra.cliente=clientes.id");
	$res=mysql_fetch_array($sql);
	$email=$res["email"];
	$sql=mysql_query("UPDATE e_compra SET whmail=1 WHERE id='$id'");
	$sql=mysql_query("SELECT * FROM e_itens WHERE compra='$id'");
	$compra=completa($id,10);
	$msg="<br>Pedido: <b>$compra</b><br><br>";
	while($res=mysql_fetch_array($sql)){
		$msg.="Criar o dominio <b>$res[dominio]</b> utilizando o plano <b>$res[produto_nome]</b><br>";
	}
	$msg.="<br>O endereco de email para contato devera ser <b>$email</b><br><br>Apos criar no WHM entre no CyberManager va ate pedidos pendentes e de baixa no pedido no <b>$compra</b><br><br><b>$_SESSION[login_nome]</b>";
	mail($qtecnico,"CyberHosting - Criar Dominios","$msg","From: manager@cyberhosting.com.br\nContent-type: text/html\n");
	$_SESSION["mensagem"]="O WorkFlow do pedido $compra foi enviado";
}elseif($acao=="canc"){
	$sql=mysql_query("SELECT * FROM e_compra WHERE id='$id'"); $res=mysql_fetch_array($sql);
	if($res["tipo"]=="Interno"){ 
		$pedido=$res["pedido"]; 
		$sql2=mysql_query("DELETE FROM vendas WHERE id='$pedido'");
		$sql3=mysql_query("DELETE FROM vendas_list WHERE venda='$pedido'");
	}
	$sql1=mysql_query("DELETE FROM e_compra WHERE id='$id'");
	$sql2=mysql_query("DELETE FROM e_itens WHERE compra='$id'");
	if($sql1 and $sql2){
		$_SESSION["mensagem"]="Pedido cancelado com sucesso!";
	}else{
		$_SESSION["mensagem"]="O pedido nao pode ser cancelado!";
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Pedidos Pendentes - ERP System</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-clock"></i> Pedidos Pendentes</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-card">
        <h3 style="margin-bottom:16px;font-size:16px;color:#2c3e50;"><i class="fas fa-search"></i> Busca</h3>
        <form name="form1" method="post" action="">
            <div class="erp-row">
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data</label>
                        <input name="data" type="text" class="erp-form-control" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <input name="buscar" type="hidden" value="true">
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="100">Compra</th>
                    <th width="100">Pedido</th>
                    <th width="100">Tipo</th>
                    <th>Cliente</th>
                    <th width="100">Data</th>
                    <th width="150">Pagamento</th>
                    <th width="150" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("SELECT *,e_compra.id AS id,e_compra.tipo as tipo FROM e_compra,clientes WHERE clientes.id = e_compra.cliente AND e_compra.sit='E' $busca ORDER BY e_compra.tipo, e_compra.id");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="7" class="erp-text-center" style="padding:40px;">Nenhum pedido pendente</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
                    $desce="pedidospendentes_baixa.php?cp=$res[id]&clid=$res[cliente]";
                    $texto = "";
                    $icon = "fa-dollar-sign";
                    switch($res["pagamento"]){
                        case "faturamento":
                            $texto="Faturamento";
                            $icon="fa-file-invoice-dollar";
                            break;
                        case "boleto":
                            $texto="Boleto";
                            $icon="fa-barcode";
                            break;
                        case "ccvisa":
                        case "ccmaster":
                        case "ccamerican":
                        case "ccdiners":
                            $texto="Cartao de Credito";
                            $icon="fa-credit-card";
                            break;
                        case "tbb":
                        case "tbradesco":
                        case "trans":
                        case "titau":
                        case "tunibanco":
                            $texto="Transferencia";
                            $icon="fa-exchange-alt";
                            break;
                    }
            ?>
                <tr>
                    <td><strong><?php echo completa($res["id"],10); ?></strong></td>
                    <td><?php echo completa($res["pedido"],10); ?></td>
                    <td><?php echo $res["tipo"]; ?></td>
                    <td><?php echo $res["nome"]; ?></td>
                    <td><?php echo banco2data($res["dtabre"]); ?></td>
                    <td><i class="fas <?php echo $icon; ?>"></i> <?php echo $texto; ?></td>
                    <td>
                        <div class="erp-table-actions" style="justify-content:center;">
                            <a href="pedidospendentes_v.php?cp=<?php echo $res["id"]; ?>&clid=<?php echo $res["cliente"]; ?>" class="erp-table-action" title="Detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo $desce; ?>" class="erp-table-action" title="Baixa">
                                <i class="fas fa-check-circle"></i>
                            </a>
                            <a href="#" onclick="return pergunta('Confirma o cancelamento deste pedido?','pedidospendentes.php?acao=canc&id=<?php echo $res["id"]; ?>');" class="erp-table-action" title="Cancelar" style="color:#e74c3c;">
                                <i class="fas fa-times-circle"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
