<?php
include("conecta.php");
include("seguranca.php");

$wcli=$_SESSION["login_codigo"];
$whjd=date("Y-m-d");
$whjh=hora();
$sql=mysql_query("SELECT * FROM acessos WHERE usuario='$wcli' AND data='$whjd'");
if(mysql_num_rows($sql)==0){
	$sql=mysql_query("INSERT INTO acessos (usuario,data,hora) VALUES ('$wcli','$whjd','$whjh')");
}else{
	$res=mysql_fetch_array($sql);
	$id=$res["id"];
	$sql=mysql_query("UPDATE acessos SET hora='$whjh' WHERE id='$id'");
}

include_once('TreeMenuXL.php');

if($_SESSION["login_funcionario"]=="S"){	
	$var="funcionario";
}else{
	$var="cliente";
}

$sql=mysql_query("SELECT niveis.menus,niveis.submenus FROM cliente_login,niveis WHERE cliente_login.".$var."='$wcli' AND niveis.id=cliente_login.nivel");
$res=mysql_fetch_array($sql);
$menus=explode(",",$res["menus"]);
$submenus=explode(",",$res["submenus"]); 

$menu_icons = [
	'Cadastros' => '<i class="fas fa-clipboard-list"></i>',
	'Comercial' => '<i class="fas fa-bag-shopping"></i>',
	'Financeiro' => '<i class="fas fa-dollar-sign"></i>',
	'Estoque' => '<i class="fas fa-boxes-stacked"></i>',
	'CRM' => '<i class="fas fa-users"></i>',
	'Relatorios' => '<i class="fas fa-chart-bar"></i>',
	'Configuracoes' => '<i class="fas fa-gear"></i>'
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<style>
body {
    margin: 0;
    padding: 0;
    background: #fff;
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

.erp-menu {
    list-style: none;
    padding: 8px;
    margin: 0;
}

.erp-menu-item {
    margin-bottom: 4px;
}

.erp-menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    font-size: 14px;
    font-weight: 500;
    color: #2c3e50;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
    cursor: pointer;
}

.erp-menu-link:hover {
    background: #f8f9fa;
    color: #4169E1;
}

.erp-menu-link.active {
    background: rgba(65, 105, 225, 0.1);
    color: #4169E1;
    font-weight: 600;
}

.erp-menu-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.erp-menu-text {
    flex: 1;
}

.erp-menu-arrow {
    font-size: 12px;
    transition: transform 0.2s;
}

.erp-menu-link.expanded .erp-menu-arrow {
    transform: rotate(90deg);
}

.erp-submenu {
    list-style: none;
    padding: 0;
    margin: 4px 0 0 0;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.erp-submenu.show {
    max-height: 1000px;
}

.erp-submenu-link {
    display: flex;
    align-items: center;
    padding: 8px 12px 8px 44px;
    font-size: 13px;
    color: #6c757d;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
    position: relative;
}

.erp-submenu-link::before {
    content: '';
    position: absolute;
    left: 24px;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #bdc3c7;
}

.erp-submenu-link:hover {
    background: #f8f9fa;
    color: #4169E1;
    padding-left: 48px;
}

.erp-submenu-link:hover::before {
    background: #4169E1;
}

.erp-submenu-link.active {
    background: rgba(65, 105, 225, 0.1);
    color: #4169E1;
    font-weight: 600;
}

.erp-submenu-link.active::before {
    background: #4169E1;
    width: 6px;
    height: 6px;
}

.erp-menu-home {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    margin: 8px;
    background: linear-gradient(135deg, #4169E1, #2E4FC7);
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 4px 12px rgba(65, 105, 225, 0.2);
    transition: all 0.2s;
}

.erp-menu-home:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(65, 105, 225, 0.3);
}

.erp-menu-divider {
    height: 1px;
    background: #e8ebf3;
    margin: 12px 16px;
}
</style>
</head>

<body>
<nav>
    <a href="corpo.php" target="corpo" class="erp-menu-home">
        <span style="font-size:18px;"><i class="fas fa-house"></i></span>
        <span>Pagina Inicial</span>
    </a>
    
    <div class="erp-menu-divider"></div>
    
    <ul class="erp-menu">
    <?php
    if($_SESSION["login_c1"]=="mkrsis"){
        $sql=mysql_query("SELECT * FROM menus ORDER BY posicao ASC");
    }else{
        $sql=mysql_query("SELECT * FROM menus WHERE sit='A' ORDER BY posicao ASC");  	
    }
    
    while($res=mysql_fetch_array($sql)){
        if(in_array($res["id"],$menus) or $res["sit"]=="F" or $_SESSION["login_c1"]=="mkrsis"){
            $menu_id = $res["id"];
            $menu_text = $res["texto"];
            $icon = isset($menu_icons[$menu_text]) ? $menu_icons[$menu_text] : '<i class="fas fa-file-lines"></i>';
            
            echo '<li class="erp-menu-item">';
            echo '<a href="javascript:void(0)" class="erp-menu-link" onclick="toggleSubmenu('.$menu_id.')">';
            echo '<span class="erp-menu-icon">'.$icon.'</span>';
            echo '<span class="erp-menu-text">'.$menu_text.'</span>';
            echo '<span class="erp-menu-arrow"><i class="fas fa-chevron-right"></i></span>';
            echo '</a>';
            
            $sql2=mysql_query("SELECT * FROM submenus WHERE menu=$menu_id ORDER BY posicao ASC");
            $has_submenu = false;
            $submenu_html = '';
            
            while($res2=mysql_fetch_array($sql2)){
                if(in_array($res2["id"],$submenus) or $res["sit"]=="F" or $_SESSION["login_c1"]=="mkrsis"){
                    $has_submenu = true;
                    $submenu_html .= '<li>';
                    $submenu_html .= '<a href="'.$res2["url"].'" class="erp-submenu-link">';
                    $submenu_html .= $res2["texto"];
                    $submenu_html .= '</a>';
                    $submenu_html .= '</li>';
                }
            }
            
            if($has_submenu){
                echo '<ul class="erp-submenu" id="submenu'.$menu_id.'">';
                echo $submenu_html;
                echo '</ul>';
            }
            
            echo '</li>';
        }
    }
    ?>
    </ul>
</nav>

<script>
function toggleSubmenu(menuId) {
    const link = event.currentTarget;
    const submenu = document.getElementById('submenu' + menuId);
    
    if(submenu) {
        link.classList.toggle('expanded');
        submenu.classList.toggle('show');
    }
}

document.querySelectorAll('.erp-submenu-link').forEach(link => {
    link.addEventListener('click', function() {
        document.querySelectorAll('.erp-submenu-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
</body>
</html>
