<?
include("conecta.php");
if(empty($_SESSION["login_nome"]) or empty($_SESSION["login_nivel"])){
	print "<script>top.window.close();</script>";
	exit;
}
function varre($dir,$filtro=".jpg;.jpeg"){
	$ray=explode("/",$_SERVER['SCRIPT_NAME']);
	array_shift ($ray);
	array_pop($ray);
	for($i=0; $i < substr_count($dir, "../");$i++){
		array_pop($ray);		
	}
	$ray=implode("/",$ray);
	if($dir=="."){
		$dire="";
	}else{
		$dire=str_replace("../","",$dir);
	}
	$ray="/".$ray."/".$dire;
	$uri=$_SERVER['HTTP_HOST'].$ray;
	$ar=1;
	$diraberto = opendir($dir); // Abre o diretorio especificado
    chdir($dir); // Muda o diretorio atual p/ o especificado
    while($arq = readdir($diraberto)) { // Le o conteudo do arquivo
        if($arq == ".." || $arq == ".")continue; // Desconsidera os diretorios
        $arr_ext = explode(";",$filtro);
        foreach($arr_ext as $ext) {
            $extpos = (strtolower(substr($arq,strlen($arq)-strlen($ext)))) == strtolower($ext);
            if ($extpos == strlen($arq) and is_file($arq)){ // Verifica se o arquivo é igual ao filtro
				$arquivos[$ar]["id"]=$ar;
				$arquivos[$ar]["url"]="http://".$uri.$arq;
				$arquivos[$ar]["arquivo"]=$arq;
				$ar++;
			}
        }
    }
    chdir(".."); // Volta um diretorio
    closedir($diraberto); // Fecha o diretorio atual
	$_SESSION["arqlist"]=$arquivos;
}
varre("imagebank/");
$arqs=$_SESSION["arqlist"];
?>
<html>
<head>
<title>Banco de Imagens</title>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="scripts.js"></script>
<script language="JavaScript">
windowWidth=520;
windowHeight=300;
if (parseInt(navigator.appVersion) >= 4) window.moveTo((screen.width/2)-(windowWidth/2+10),(screen.height/2)-(windowHeight/2+20));
function editimg(imgSrc){
	opener.iView.document.execCommand('insertimage', false, imgSrc);
	window.close();
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="textobold"><a href="imagebank2.php" class="textobold">INSERIR 
      UMA IMAGEM</a></td>
  </tr>
</table>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#003366">
  <tr class="textoboldbranco"> 
    <td width="50" align="center">&nbsp;</td>
    <td width="0">&nbsp;URL</td>
    <td width="20" align="center">&nbsp;</td>
    <td width="20" align="center">&nbsp;</td>
  </tr>
  <?
if(count($arqs)==0){
?>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="4" align="center" class="textobold">NENHUMA IMAGEM ENCONTRADA</td>
  </tr>
  <?
	}else{
		//BLOCO PAGINACAO
		$wpaginacao=10;
		$results_tot=count($arqs); //total de registros encontrados
		$maxpag=5; //numero maximo de resultados por pagina
		if($results_tot>$maxpag){
			$wpaginar=true;
			if(!isset($wp)){
				$param=0;
				$temp=0;
				$wp=0;
			}else{
				$temp = $wp;
				$passo1 = $temp - 1;
				$passo2 = $passo1*$maxpag;
				$param  = $passo2;				
			}
			$arqs = array_slice ($arqs, $param, $maxpag);
			$results_parc=count($arqs);
			$result_div=$results_tot/$maxpag;
			$n_inteiro=(int)$result_div;
			if($n_inteiro<$result_div){
				$n_paginas=$n_inteiro+1;
			}else{
				$n_paginas=$result_div;
			}
			$pg_atual=$param/$maxpag+1;
			$reg_inicial=$param+1;
			$pg_anterior=$pg_atual-1;
			$pg_proxima=$pg_atual+1;
			$reg_final=$param;
		}
		// BLOCO PAGINACAO
		if($wpaginar){
			$j=0;
			$som=0;
		}else{
			$j=1;
			$som=1;
		}
		for($i=$j;$i < sizeof($arqs)+$som; $i++){
			$id=$arqs[$i]["id"];
			$imagem=$arqs[$i]["arquivo"];
			$url=$arqs[$i]["url"];
			$reg_final++; // PAGINACAO conta quantos registros imprimiu
	?>
  <tr bgcolor="#FFFFFF"> 
    <td width="50" align="center"><a href="#" onClick="return abre('imagebank/foto.php?img=<? print $imagem; ?>','foto','width=10,height=10');"><img src="imagebank/gd.php?img=<? print $imagem; ?>&wid=50" alt="Clique para ampliar" border="0" align="absmiddle"></a></td>
    <td width="0" class="texto">&nbsp;<? print $url; ?></td>
    <td width="20" align="center"><a href="#" onClick="return editimg('<? print $url; ?>');"><img src="imagens/icon_14img.gif" alt="Selecionar imagem" width="14" height="14" border="0"></a></td>
    <td width="20" align="center"><a href="#" onClick="return pergunta('Deseja excluir esta imagem?','imagebank/bank.php?id=<? print $id; ?>&acao=exc&wp=<? print $wp; ?>');"><img src="imagens/icon14_lixeira.gif" width="14" height="14" border="0"></a></td>
  </tr>
  <?
		}
	}
	?>
</table>
            </table></td>
        </tr>
		<? if($wpaginar){ ?>
        <tr>
          <td><table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr> 
        <td align="center"> <table width="1%" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top"> 
              <td align="right"> 
                <? 
				$antz=false;
				if($wp>1){
					$antz=true;
				?>
                <a href="<? print "imagebank.php?wp=$pg_anterior"; ?>" class="texto"> 
                <? } ?>
                <img src="imagens/pag_1.gif" width="26" height="13" border="0"> 
                <? if($antz){ ?>
                <br>
                Anterior</a> 
                <? } ?>
              </td>
              <?
				$link_impressos=0;
				if ($temp > $wpaginacao){
		    	    $n_start  = $temp - ceil($wpaginacao/2);
					$wpaginacao=$temp+ceil($wpaginacao/2);
		    	    if($n_start<0){
			    	    $n_start=0;
		    		}
		        	$link_impressos = $n_start;
				}
				while(($link_impressos<$n_paginas) and ($link_impressos<$wpaginacao)){
					$link_impressos++;
				?>
              <td align="center"> 
                <? if($pg_atual != $link_impressos){ ?>
                <a href="<? print "imagebank.php?wp=$link_impressos"; ?>" class="texto"> 
                <? } ?>
                <img src="imagens/pag_<? if($pg_atual==$link_impressos) { print "3"; }else{ print "2"; } ?>.gif" border="0"><br>
                <? if($pg_atual==$link_impressos){ print "<span class=\"textobold\">$link_impressos</span>"; }else{ print $link_impressos; }?>
                <? if($pg_atual != $link_impressos){ ?>
                </a> 
                <? } ?>
              </td>
              <?
				}
				?>
              <td> 
                <? if($reg_final<$results_tot){ ?>
                <a href="<? print "imagebank.php?wp=$pg_proxima"; ?>" class="texto"> 
                <? } ?>
                <img src="imagens/pag_4.gif" width="34" height="15" border="0"> 
                <? if($reg_final<$results_tot){ ?>
                <br>
                Próximo</a> 
                <? } ?>
              </td>
            </tr>
          </table></td>
      </tr>
    </table>
			<? } ?>
</body>
</html>
<? include("mensagem.php"); ?>