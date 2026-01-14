<?php
include("conecta.php");
include("seguranca.php");
if(empty($acao)) $acao="entrar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Nota Fiscal de Entrada - ERP System</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script src="mascaras.js"></script>
<script>
function verifica(cad){
	if(cad.nome.value=='' || cad.cliente=='' || cad.cliente_tipo==''){
		alert('Escolha o cliente/fornecedor');
		return abre('nf_cli.php','a','width=320,height=300,scrollbars=1');
	}
	return true;
}
</script>
</head>

<body style="background:#f8f9fa;padding:24px;" onLoad="enterativa=1;" onkeypress="return ent()">

<div class="erp-container-fluid">
    <div class="erp-card">
        <div class="erp-card-header">
            <h1 class="erp-card-title"><i class="fas fa-file-invoice"></i> Nota Fiscal de Entrada</h1>
            <a href="nf.php" class="erp-btn erp-btn-outline">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    
    <?php if($acao=="entrar"){ ?>
    <div class="erp-card">
        <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;">
            <i class="fas fa-list-ol"></i> Quantidade de Produtos
        </h3>
        <form name="form2" method="post" action="">
            <div class="erp-row">
                <div class="erp-col" style="max-width:200px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Informe a quantidade de produtos na nota</label>
                        <input name="qtdp" type="text" class="erp-form-control" onKeyPress="return validanum(this, event)" value="0" maxlength="2">
                    </div>
                </div>
                <div class="erp-col" style="flex:0 0 auto;display:flex;align-items:flex-end;">
                    <div class="erp-form-group" style="margin-bottom:0;">
                        <input name="acao" type="hidden" value="nfe">
                        <button type="submit" class="erp-btn erp-btn-primary" style="height:42px;">
                            <i class="fas fa-arrow-right"></i> Continuar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php }else{ ?>
    <form name="form1" method="post" action="nf_sql.php" onSubmit="return verifica(this);">
        <input name="cliente" type="hidden" value="<?php echo $cliente; ?>">
        <input name="cliente_tipo" type="hidden" value="<?php echo $cliente_tipo; ?>">
        <input name="es" type="hidden" value="E">
        <input name="acao" type="hidden" value="nfe">
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-user"></i> Remetente</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:3;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cliente/Fornecedor</label>
                        <div style="display:flex;gap:8px;">
                            <input name="nome" type="text" class="erp-form-control" readonly style="background:#f8f9fa;">
                            <a href="#" onclick="return abre('nf_cli.php','a','width=320,height=300,scrollbars=1');" class="erp-btn erp-btn-outline">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">No Nota</label>
                        <input name="numero" type="text" class="erp-form-control" onKeyPress="return validanum(this, event)" maxlength="6">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Operacao</label>
                        <select name="operacao" class="erp-form-control">
                            <?php
                            $sqlo=mysql_query("SELECT * FROM opertab WHERE tipo='E' ORDER BY nome ASC");
                            while($reso=mysql_fetch_array($sqlo)){
                            ?>
                            <option value="<?php echo $reso["id"]; ?>"><?php echo $reso["nome"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Natureza</label>
                        <input name="natureza" type="text" class="erp-form-control" maxlength="100">
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CFOP</label>
                        <input name="cfop" type="text" class="erp-form-control" maxlength="5">
                    </div>
                </div>
            </div>
            
            <div class="erp-row">
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Emissao</label>
                        <input name="emissao" type="text" class="erp-form-control" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Data Entrada</label>
                        <input name="dtes" type="text" class="erp-form-control" maxlength="10" onKeyPress="return validanum(this, event)" onKeyUp="mdata(this)">
                    </div>
                </div>
                <div class="erp-col" style="max-width:150px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Hora Saida</label>
                        <input name="hs" type="text" class="erp-form-control" maxlength="8" onKeyPress="return validanum(this, event)" onKeyUp="mhora(this)">
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($qtdp!=0){ ?>
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-box"></i> Produtos</h3>
            <div class="erp-table-container">
                <table class="erp-table">
                    <thead>
                        <tr>
                            <th width="50">Cod</th>
                            <th width="30"></th>
                            <th>Descricao</th>
                            <th width="50">Unid</th>
                            <th width="80">Cl.Fiscal</th>
                            <th width="70">Sit.Trib</th>
                            <th width="70">Qtd</th>
                            <th width="70">Valor</th>
                            <th width="60">ICMS</th>
                            <th width="50">IPI</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php for ($i=1;$i<=$qtdp;$i++){ ?>
                    <tr>
                        <td><input name="prodserv[]" type="text" class="erp-form-control" id="prodserv<?php echo $i; ?>" onKeyPress="return validanum(this, event)" maxlength="6" readonly style="background:#f8f9fa;padding:4px;font-size:12px;"></td>
                        <td><a href="#" onclick="return abre('nf_prodserv.php?line=<?php echo $i; ?>&abre=S','busca','width=320,height=300,scrollbars=1');"><i class="fas fa-search" style="color:#4169E1;"></i></a></td>
                        <td><input name="pdescricao[]" type="text" class="erp-form-control" id="pdescricao<?php echo $i; ?>" maxlength="100" style="padding:4px;font-size:12px;"></td>
                        <td><input name="punidade[]" type="text" class="erp-form-control" id="punidade<?php echo $i; ?>" maxlength="5" style="padding:4px;font-size:12px;"></td>
                        <td><input name="pclafis[]" type="text" class="erp-form-control" id="pclafis<?php echo $i; ?>" maxlength="10" style="padding:4px;font-size:12px;"></td>
                        <td><input name="psitri[]" type="text" class="erp-form-control" id="psitri<?php echo $i; ?>" maxlength="5" style="padding:4px;font-size:12px;"></td>
                        <td><input name="pqtd[]" type="text" class="erp-form-control" id="pqtd<?php echo $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" style="padding:4px;font-size:12px;"></td>
                        <td><input name="punitario[]" type="text" class="erp-form-control" id="unitario<?php echo $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" style="padding:4px;font-size:12px;"></td>
                        <td><input name="picms[]" type="text" class="erp-form-control" id="picms<?php echo $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" style="padding:4px;font-size:12px;"></td>
                        <td><input name="pipi[]" type="text" class="erp-form-control" id="pipi<?php echo $i; ?>" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" style="padding:4px;font-size:12px;"></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div style="margin-top:10px;padding:8px;background:#fff3cd;border-radius:6px;font-size:12px;color:#856404;">
                <i class="fas fa-info-circle"></i> Obs: caso nao seja selecionado o cod do produto ele nao sera incluido na nota fiscal
            </div>
        </div>
        <?php } ?>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-tools"></i> Servicos</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Descricao dos Servicos</label>
                        <textarea name="servicos" class="erp-form-control" rows="5" onFocus="enterativa=0;" onBlur="enterativa=1;"></textarea>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">I.M</label>
                        <input name="im" type="text" class="erp-form-control" maxlength="20">
                    </div>
                    <div class="erp-row">
                        <div class="erp-col">
                            <div class="erp-form-group">
                                <label class="erp-form-label">% ISS</label>
                                <input name="issper" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                            </div>
                        </div>
                        <div class="erp-col">
                            <div class="erp-form-group">
                                <label class="erp-form-label">Val ISS</label>
                                <input name="issval" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                            </div>
                        </div>
                    </div>
                    <div class="erp-form-group">
                        <label class="erp-form-label">Total Servicos</label>
                        <input name="servicosval" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-calculator"></i> Calculo do Imposto</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Base ICMS</label>
                        <input name="baseicms" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Val ICMS</label>
                        <input name="valicms" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Base ICMS Subst</label>
                        <input name="baseicmss" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Val ICMS Subst</label>
                        <input name="valicmss" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Total Produtos</label>
                        <input name="produtos" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Frete</label>
                        <input name="frete" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Seguro</label>
                        <input name="seguro" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Outras Despesas</label>
                        <input name="outros" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Valor IPI</label>
                        <input name="ipi" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Total da Nota</label>
                        <input name="total" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00" style="font-weight:bold;color:#27AE60;">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-truck"></i> Transportadora</h3>
            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Nome</label>
                        <input name="transp" type="text" class="erp-form-control" maxlength="100">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Frete por conta</label>
                        <div style="display:flex;gap:20px;margin-top:8px;">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="fretepor" type="radio" value="1" checked> 1-Remetente
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input name="fretepor" type="radio" value="2"> 2-Destinatario
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Placa</label>
                        <input name="placa" type="text" class="erp-form-control" maxlength="7">
                    </div>
                </div>
                <div class="erp-col" style="max-width:100px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">UF</label>
                        <select name="placauf" class="erp-form-control">
                            <option value="SP" selected>SP</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AM">AM</option>
                            <option value="AP">AP</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MG">MG</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="PR">PR</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="RS">RS</option>
                            <option value="SC">SC</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">CNPJ</label>
                        <input name="tcnpj" type="text" class="erp-form-control" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">I.E</label>
                        <input name="tie" type="text" class="erp-form-control" maxlength="20">
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col" style="flex:2;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Endereco</label>
                        <input name="tend" type="text" class="erp-form-control" maxlength="50">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Cidade</label>
                        <input name="tcid" type="text" class="erp-form-control" maxlength="30">
                    </div>
                </div>
                <div class="erp-col" style="max-width:100px;">
                    <div class="erp-form-group">
                        <label class="erp-form-label">UF</label>
                        <select name="tuf" class="erp-form-control">
                            <option value="SP" selected>SP</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AM">AM</option>
                            <option value="AP">AP</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MG">MG</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="PR">PR</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="RS">RS</option>
                            <option value="SC">SC</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Qtd</label>
                        <input name="qtd" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Especie</label>
                        <input name="especie" type="text" class="erp-form-control" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Marca</label>
                        <input name="marca" type="text" class="erp-form-control" maxlength="20">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Numero</label>
                        <input name="tnum" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Peso Bruto</label>
                        <input name="pbruto" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Peso Liquido</label>
                        <input name="pliquido" type="text" class="erp-form-control" onKeyDown="formataMoeda(this,retornaKeyCode(event))" onKeyUp="formataMoeda(this,retornaKeyCode(event))" value="0,00">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-sticky-note"></i> Dados Adicionais</h3>
            <div class="erp-form-group">
                <textarea name="adicionais" class="erp-form-control" rows="4" onFocus="enterativa=0;" onBlur="enterativa=1;"></textarea>
            </div>
        </div>
        
        <div class="erp-card">
            <h3 style="margin-bottom:20px;font-size:18px;color:#2c3e50;"><i class="fas fa-cog"></i> Configuracoes</h3>
            <div class="erp-row">
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Parcelamento</label>
                        <select name="parcelamento" class="erp-form-control">
                            <?php
                            $sql=mysql_query("SELECT * FROM parcelamentos ORDER BY descricao ASC");
                            while($res=mysql_fetch_array($sql)){
                            ?>
                            <option value="<?php echo $res["id"]; ?>" <?php if($parcelamento==$res["id"]) echo "selected"; ?>><?php echo $res["descricao"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Conta Contabil</label>
                        <select name="conta" class="erp-form-control">
                            <?php
                            $sql=mysql_query("SELECT * FROM pcontas WHERE idpai!=0 ORDER BY descricao ASC");
                            while($res=mysql_fetch_array($sql)){
                            ?>
                            <option value="<?php echo $res["id"]; ?>" <?php if($conta==$res["id"]) echo "selected"; ?>><?php echo $res["descricao"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Categoria</label>
                        <select name="categoria" class="erp-form-control">
                            <?php
                            $sql=mysql_query("SELECT * FROM categorias ORDER BY nome ASC");
                            while($res=mysql_fetch_array($sql)){
                            ?>
                            <option value="<?php echo $res["id"]; ?>" <?php if($categoria==$res["id"]) echo "selected"; ?>><?php echo $res["nome"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="erp-col">
                    <div class="erp-form-group">
                        <label class="erp-form-label">Filial</label>
                        <select name="banco" class="erp-form-control">
                            <?php
                            $sqlo=mysql_query("SELECT * FROM bancos ORDER BY apelido ASC");
                            while($reso=mysql_fetch_array($sqlo)){
                            ?>
                            <option value="<?php echo $reso["id"]; ?>"><?php echo $reso["apelido"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:20px;flex-wrap:wrap;margin-top:12px;">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input name="fluxo" type="checkbox" value="N" <?php if($fluxo=="S") echo "checked"; ?>> Nao incluir no fluxo de caixa
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input name="cartorio" type="checkbox" value="S" <?php if($cartorio=="S") echo "checked"; ?>> Em cartorio
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input name="cobranca" type="checkbox" value="S" <?php if($cobranca=="S") echo "checked"; ?>> Em cobranca
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input name="demonstrativo" type="checkbox" value="S" <?php if($demonstrativo=="S") echo "checked"; ?>> Nao entra na demonstracao
                </label>
            </div>
        </div>
        
        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:24px;">
            <a href="nf.php" class="erp-btn erp-btn-outline">Cancelar</a>
            <button type="submit" class="erp-btn erp-btn-primary">
                <i class="fas fa-check"></i> Salvar Nota Fiscal
            </button>
        </div>
    </form>
    <?php } ?>
</div>

<?php include("mensagem.php"); ?>
</body>
</html>
