<?php
include("conecta.php");
include("seguranca.php");
$qtecnico="vendas@cyberhosting.com.br";
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
<title>Pedidos Pendentes - Historico - ERP System</title>
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
            <h1 class="erp-card-title"><i class="fas fa-history"></i> Pedidos Pendentes - Historico</h1>
        </div>
    </div>
    
    <?php if(isset($_SESSION["mensagem"])): ?>
    <div class="erp-alert erp-alert-success">
        <?php echo $_SESSION["mensagem"]; unset($_SESSION["mensagem"]); ?>
    </div>
    <?php endif; ?>
    
    <div class="erp-table-container">
        <table class="erp-table">
            <thead>
                <tr>
                    <th width="100">Pedido</th>
                    <th width="100">Numero NF</th>
                    <th width="120">Emissao NF</th>
                    <th width="120">Vencimento NF</th>
                    <th width="120">Liquidacao NF</th>
                    <th>Prazo de Pagamento</th>
                    <th width="80" class="erp-text-center">Acoes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql=mysql_query("select nf.* from vendas,nf WHERE nf.pedido=vendas.id AND vendas.cliente='$cli'");
            if(mysql_num_rows($sql)==0){
            ?>
                <tr>
                    <td colspan="7" class="erp-text-center" style="padding:40px;">Nenhum pedido pendente</td>
                </tr>
            <?php
            }else{
                while($res=mysql_fetch_array($sql)){
            ?>
                <tr>
                    <td><strong><?php echo completa($res["id"],10); ?></strong></td>
                    <td><?php echo $res["fantasia"]; ?></td>
                    <td><?php echo banco2data($res["dtabre"]); ?></td>
                    <td><?php echo banco2data($res["dtabre"]); ?></td>
                    <td><?php echo banco2data($res["dtabre"]); ?></td>
                    <td><?php echo banco2data($res["dtabre"]); ?></td>
                    <td class="erp-text-center">
                        <a href="pedidospendentes_v.php?cp=<?php echo $res["id"]; ?>&clid=<?php echo $res["cliente"]; ?>" class="erp-table-action" title="Detalhes">
                            <i class="fas fa-eye"></i>
                        </a>
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
