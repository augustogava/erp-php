<?php
include("conecta.php");
$bd=new set_bd;
$sql=mysql_query("SELECT * FROM romaneio WHERE id='$id'");
$res=mysql_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Romaneio - ERP System</title>
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
function imprimir(botao){
	var guarda=botao.innerHTML;
	botao.innerHTML='<i class="fas fa-spinner fa-spin"></i>';
	window.print();
	botao.innerHTML=guarda;
	return false;
}
</script>
<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; padding: 0 !important; }
    .erp-card { box-shadow: none !important; border: none !important; }
}
</style>
</head>

<body style="background:#f8f9fa;padding:24px;">

<div class="erp-container-fluid" style="max-width:800px;">
    <div class="erp-card">
        <div style="display:flex;align-items:center;gap:20px;margin-bottom:20px;">
            <img src="imagens/logoesi.gif" width="52" height="53" alt="Logo">
            <div>
                <h1 style="margin:0;font-size:24px;color:#2c3e50;">MKR Comercial Ltda.</h1>
                <p style="margin:4px 0 0 0;color:#6c757d;">Romaneio de Entrega</p>
            </div>
        </div>
        
        <div class="erp-row" style="margin-bottom:20px;">
            <div class="erp-col">
                <p style="margin:0;"><strong>Romaneio No:</strong> <?php echo $res["id"]?></p>
                <p style="margin:4px 0 0 0;"><strong>Entrega de Correspondencia</strong></p>
            </div>
        </div>
        
        <div style="background:#f8f9fa;padding:12px;border-radius:8px;margin-bottom:20px;">
            <p style="margin:0;font-weight:600;">Agencia Sedex</p>
            <p style="margin:4px 0 0 0;">Ag. General Flores - Tel: 3225 9919</p>
        </div>
        
        <p style="margin-bottom:20px;"><strong>Data:</strong> ___/___/______</p>
        
        <div class="erp-table-container">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th width="120">CEP</th>
                        <th width="120">Forma Envio</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql=mysql_query("SELECT clientes.id as cod,clientes.nome,vendas.frete_tp FROM romaneio_itens,prodserv_sep,vendas,clientes WHERE romaneio_itens.romaneio='$res[id]' AND romaneio_itens.separacao=prodserv_sep.id AND vendas.id=prodserv_sep.pedido AND vendas.cliente=clientes.id");
                if(mysql_num_rows($sql)==0){
                ?>
                    <tr>
                        <td colspan="3" class="erp-text-center" style="padding:40px;">Nenhum registro encontrado</td>
                    </tr>
                <?php
                }else{
                    while($res=mysql_fetch_array($sql)){
                        $ent=mysql_query("SELECT cep FROM cliente_entrega WHERE cliente='$res[cod]'");
                        $rent=mysql_fetch_array($ent);
                        $frm="";
                        switch($res["frete_tp"]){
                            case "1": $frm="Sedex"; break;
                            case "2": $frm="PAC"; break;
                            case "3": $frm="Sedex 10"; break;
                        }
                ?>
                    <tr>
                        <td><?php echo $res["cod"]." ".$res["nome"]; ?></td>
                        <td><?php echo $rent["cep"]; ?></td>
                        <td><?php echo $frm; ?></td>
                    </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        
        <div class="erp-text-center no-print" style="margin-top:20px;">
            <button type="button" class="erp-btn erp-btn-primary" onclick="return imprimir(this)">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
</div>

</body>
</html>
