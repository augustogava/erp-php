<?php
include("conecta.php");
include("seguranca.php");

$wcli=$_SESSION["login_codigo"];
$whjd=date("Y-m-d");
$whjh=hora();
$funcionario=$_SESSION["login_funcionario"];
$ip=$_SERVER['REMOTE_ADDR'];
$sql=mysql_query("INSERT INTO acessos (usuario,tipo,data,hora,ip) VALUES ('$wcli','$funcionario','$whjd','$whjh','$ip')");

if($_SESSION["login_funcionario"]=="S"){	
	$var="funcionario";
}else{
	$var="cliente";
}

$sql=mysql_query("SELECT niveis.menus,niveis.submenus FROM cliente_login,niveis WHERE cliente_login.".$var."='$wcli' AND niveis.id=cliente_login.nivel");
$res=mysql_fetch_array($sql);
$menus=explode(",",$res["menus"]);
$submenus=explode(",",$res["submenus"]); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Sistema ERP v3.5.1</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="style.css" rel="stylesheet" type="text/css">
<link href="components.css" rel="stylesheet" type="text/css">
<link href="layout-fixes.css" rel="stylesheet" type="text/css">
<style>
.main-layout {
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
    background: #f8f9fa;
}

.main-header {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    padding: 12px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    flex-shrink: 0;
    z-index: 1000;
}

.main-header h1 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #4169E1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
}

.main-body {
    display: flex;
    flex: 1;
    overflow: hidden;
}

.main-sidebar {
    width: 250px;
    background: #ffffff;
    border-right: 1px solid #e8ebf3;
    overflow-y: auto;
    overflow-x: hidden;
    flex-shrink: 0;
    padding: 8px 0;
}

/* Tree Menu Styles */
.tree-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tree-item {
    position: relative;
}

.tree-link {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    color: #2c3e50;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    user-select: none;
}

.tree-link:hover {
    background: #f8f9fa;
    color: #4169E1;
}

.tree-link.active {
    background: #e8f0fe;
    color: #4169E1;
    border-left: 3px solid #4169E1;
    padding-left: 13px;
}

.tree-icon {
    width: 20px;
    margin-right: 10px;
    font-size: 14px;
    text-align: center;
    color: #6c757d;
}

.tree-link:hover .tree-icon {
    color: #4169E1;
}

.tree-text {
    flex: 1;
    font-weight: 500;
}

.tree-toggle {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
    color: #6c757d;
    font-size: 12px;
}

.tree-link.open .tree-toggle {
    transform: rotate(90deg);
}

.tree-submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    background: #f8f9fa;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.tree-submenu.open {
    max-height: 2000px;
}

.tree-submenu .tree-link {
    padding-left: 48px;
    font-size: 13px;
    font-weight: 400;
}

.tree-submenu .tree-link:hover {
    background: #e8ebf3;
    padding-left: 52px;
}

.tree-submenu .tree-icon {
    font-size: 12px;
}

.main-sidebar::-webkit-scrollbar {
    width: 6px;
}

.main-sidebar::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.main-sidebar::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

.main-sidebar::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

.main-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    background: #f8f9fa;
}

.main-content iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
}

.main-footer {
    background: #2c3e50;
    color: white;
    padding: 12px 24px;
    text-align: center;
    font-size: 13px;
    flex-shrink: 0;
}
</style>
</head>
<body>

<div class="main-layout">
    <div class="main-header">
        <h1><i class="fas fa-chart-line"></i> Sistema ERP v3.5.1</h1>
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <div style="font-size:14px;font-weight:600;"><?=$_SESSION["login_nome"]?></div>
                <div style="font-size:12px;opacity:0.8;"><?=$_SESSION["login_nivel_nome"]?></div>
            </div>
        </div>
    </div>
    
    <div class="main-body">
        <div class="main-sidebar">
            <ul class="tree-menu">
                <?php
                $sql_menus=mysql_query("SELECT * FROM menus WHERE sit='A' ORDER BY posicao ASC");
                while($menu=mysql_fetch_array($sql_menus)){
                    if(in_array($menu["id"],$menus) or $_SESSION["login_c1"]=="cyber"){
                        $menu_id = "submenu_".$menu["id"];
                        
                        // Check if has submenus
                        $sql_subs=mysql_query("SELECT * FROM submenus WHERE menu=".$menu["id"]." ORDER BY posicao ASC");
                        $has_subs = (mysql_num_rows($sql_subs) > 0);
                        
                        echo '<li class="tree-item">';
                        
                        if($has_subs){
                            // Menu with submenu
                            echo '<div class="tree-link" data-submenu="'.$menu_id.'">';
                            echo '<i class="fas fa-folder tree-icon"></i>';
                            echo '<span class="tree-text">'.$menu["texto"].'</span>';
                            echo '<i class="fas fa-chevron-right tree-toggle"></i>';
                            echo '</div>';
                            
                            // Submenu
                            echo '<ul class="tree-submenu" id="'.$menu_id.'">';
                            mysql_data_seek($sql_subs, 0); // Reset pointer
                            while($sub=mysql_fetch_array($sql_subs)){
                                if(in_array($sub["id"],$submenus) or $_SESSION["login_c1"]=="cyber"){
                                    echo '<li class="tree-item">';
                                    echo '<a href="'.$sub["url"].'" class="tree-link" target="corpo">';
                                    echo '<i class="fas fa-file tree-icon"></i>';
                                    echo '<span class="tree-text">'.$sub["texto"].'</span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                            }
                            echo '</ul>';
                        } else {
                            // Menu without submenu
                            echo '<a href="'.$menu["url"].'" class="tree-link" target="corpo">';
                            echo '<i class="fas fa-file tree-icon"></i>';
                            echo '<span class="tree-text">'.$menu["texto"].'</span>';
                            echo '</a>';
                        }
                        
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
        
        <div class="main-content">
            <iframe name="corpo" src="corpo.php" scrolling="auto"></iframe>
        </div>
    </div>
    
    <div class="main-footer">
        <i class="fas fa-code"></i> Sistema ERP v3.5.1 - <?=date("Y")?> - <i class="fas fa-user"></i> <?=$_SESSION["login_nome"]?>
    </div>
</div>

<script>
// Tree menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add click event to all menu items with submenu
    const menuItems = document.querySelectorAll('.tree-link[data-submenu]');
    
    menuItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const submenuId = this.getAttribute('data-submenu');
            const submenu = document.getElementById(submenuId);
            
            // Close all other submenus
            document.querySelectorAll('.tree-submenu').forEach(function(sub) {
                if(sub.id !== submenuId) {
                    sub.classList.remove('open');
                    const parent = document.querySelector('[data-submenu="' + sub.id + '"]');
                    if(parent) parent.classList.remove('open');
                }
            });
            
            // Toggle current submenu
            if(submenu.classList.contains('open')) {
                submenu.classList.remove('open');
                this.classList.remove('open');
            } else {
                submenu.classList.add('open');
                this.classList.add('open');
            }
        });
    });
    
    // Highlight active menu item when clicked
    const links = document.querySelectorAll('.tree-submenu .tree-link');
    links.forEach(function(link) {
        link.addEventListener('click', function() {
            document.querySelectorAll('.tree-link.active').forEach(function(item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
});
</script>
</body>
</html>
