<?php
include("conecta.php");
if(empty($acao)) exit;
//$acao=verifi($permi,$acao);
if(!empty($acao)){
	$loc="Cadastro Produtos";
	$pagina=$_SERVER['SCRIPT_FILENAME'];
	include("log.php");
}
if($acao=="incluir"){
	$sql=mysql_query("SELECT * FROM prodserv WHERE codprod='$codprod'");
	if(mysql_num_rows($sql)){
				$_SESSION["mensagem"]="Já existe um produto com esse código!";
				header("Location:prodserv.php?acao=inc");
				exit;
	}
	$min=valor2banco($min);
	$max=valor2banco($max);
	$est=valor2banco($est);
	$vm=valor2banco($vm);
	$comi=valor2banco($comi);
	$cm=valor2banco($cm);
	$cs=valor2banco($cs);
	$pv=valor2banco($pv);
	$icms=valor2banco($icms);
	$ipi=valor2banco($ipi);
	$margem=valor2banco($margem);
	$percicms=valor2banco($percicms);
	$pesol=valor2banco($pesol);
	$pesob=valor2banco($pesob);
	$ultima_entrega=data2banco($ultima_entrega);
	$prev_entrega=data2banco($prev_entrega);
	$preco_ult_compra=valor2banco($preco_ult_compra);
	$comissao=valor2banco($comissao);
	if($icmsv!="S") $icmsv="N";
	if($ipiv!="S") $ipiv="N";
	if($isento!="S") $isento="N";
	$pv=$cm*$margem;
	$sz=sizeof($id_mat);
	if(!empty($id_mat)){
		foreach($id_mat as $key=>$value){
			$idmat.="$value";
			if(!($key==$sz-1)) $idmat.=",";
		}
	}
	$sql=mysql_query("INSERT INTO prodserv (nome,id_mat,origem,apelido,unidade,categoria,tipo,texto,valorizado,class,min,max,est,vm,comi,cm,cs,pv,icms,icmsv,ipi,ipiv,margem,ume,ums,tabe,tabs,sitri,clafis,percicms,isento,descricao,pesol,pesob,espec,virtual,codprod,material,tamanho,cor,embalagem,prazo_entrega,ultima_entrega,cod_ult_forn,prev_entrega,preco_ult_compra,destaque,comissao,altura,largura,profundidade,cubagem,desc_curta,correlacionado1,correlacionado2,corredor,prateleira,posi,tindicado1,tindicado2,tindicado3,tindicado4,frete,ecat,porta,cortina,fixacao,linha,cortina_not) VALUES ('$nome','$idmat','Sistema','$apelido','$unidade','$categoria','$tipo','$texto','$valorizado','$class','$min','$max','$est','$vm','$comi','$cm','$cs','$pv','$icms','$icmsv','$ipi','$ipiv','$margem','$ume','$ums','$tabe','$tabs','$sitri','$clafis','$percicms','$isento','$descricao','$pesol','$pesob','$espec','$virtual','$codprod','$material','$tamanho','$cor','$embalagem','$prazo_entrega','$ultima_entrega','$cod_ult_forn','$prev_entrega','$preco_ult_compra','$destaque','$comissao','$altura','$largura','$profundidade','$cubagem','$desc_curta','$correlacionado1','$correlacionado2','$corredor','$prateleira','$posi','$tindicado1','$tindicado2','$tindicado3','$tindicado4','$frete','$ecat','$porta','$cortina','$fixacao','$linha','$cortina_not')");
		if($sql){
			$sql=mysql_query("SELECT MAX(id) AS id FROM prodserv");
			$res=mysql_fetch_array($sql);
			$id=$res["id"];
			if(!empty($_FILES["arquivo"]["name"])){
				$nome=$_FILES["arquivo"]["name"];
				$erros=0;
				if($_FILES["arquivo"]["size"] > 512000){
					$erros++;
					$_SESSION["mensagem"].="\\nA imagem deve ter no máximo 500Kb";
				}
				if($erros==0){
					$arquivo="foto/$id.jpg";
					if (file_exists($arquivo)) { 
						unlink($arquivo);
					}
					$upa=copy($_FILES["arquivo"]["tmp_name"], $arquivo);
					if(!$upa){
						$pau=true;
						$_SESSION["mensagem"].="\\nA imagem não pôde ser carregada";
					}else{
						$sql=mysql_query("UPDATE prodserv SET foto='$id.jpg' WHERE id='$id'");
					}
				}else{
					$pau=true;
				}
			}
			if(!$pau){
				$_SESSION["mensagem"]="Produto / Serviço incluído com sucesso!";
				$acao="entrar";
			}else{
				$_SESSION["mensagem"]="Produto / Serviço incluído com sucesso porém".$_SESSION["mensagem"];
				$acao="alt";
			}
		}else{
			$_SESSION["mensagem"]="O Produto / Serviço não pôde ser incluído!";
			$acao="inc";
		}
}elseif($acao=="alterar"){
	$min=valor2banco($min);
	$max=valor2banco($max);
	$est=valor2banco($est);
	$vm=valor2banco($vm);
	$comi=valor2banco($comi);
	$cm=valor2banco($cm);
	$cs=valor2banco($cs);
	$pv=valor2banco($pv);
	$icms=valor2banco($icms);
	$ipi=valor2banco($ipi);
	$margem=valor2banco($margem);
	$percicms=valor2banco($percicms);
	$pesol=valor2banco($pesol);
	$pesob=valor2banco($pesob);
	$ultima_entrega=data2banco($ultima_entrega);
	$prev_entrega=data2banco($prev_entrega);
	$preco_ult_compra=valor2banco($preco_ult_compra);
	$comissao=valor2banco($comissao);
	if($icmsv!="S") $icmsv="N";
	if($ipiv!="S") $ipiv="N";
	if($isento!="S") $isento="N";
	$pv=$cm*$margem;	
	$sz=sizeof($id_mat);
	if(!empty($id_mat)){
		foreach($id_mat as $key=>$value){
			$idmat.="$value";
			if(!($key==$sz-1)) $idmat.=",";
		}
	}
	$sql=mysql_query("UPDATE prodserv SET categoria='$categoria',id_mat='$idmat',corredor='$corredor',prateleira='$prateleira',posi='$posi',virtual='$virtual', nome='$nome',apelido='$apelido',texto='$texto',unidade='$unidade',tipo='$tipo',valorizado='$valorizado',class='$class',min='$min',max='$max',est='$est',vm='$vm',comi='$comi',cm='$cm',cs='$cs',pv='$pv',icms='$icms',icmsv='$icmsv',ipi='$ipi',ipiv='$ipiv',margem='$margem',ume='$ume',ums='$ums',tabe='$tabe',tabs='$tabs',sitri='$sitri',clafis='$clafis',percicms='$percicms',isento='$isento',descricao='$descricao',pesol='$pesol',pesob='$pesob',espec='$espec',codprod='$codprod',material='$material',tamanho='$tamanho',cor='$cor',embalagem='$embalagem',prazo_entrega='$prazo_entrega',ultima_entrega='$ultima_entrega',cod_ult_forn='$cod_ult_forn',prev_entrega='$prev_entrega',preco_ult_compra='$preco_ult_compra',destaque='$destaque',comissao='$comissao',altura='$altura',largura='$largura',profundidade='$profundidade',cubagem='$cubagem',desc_curta='$desc_curta',correlacionado1='$correlacionado1',correlacionado2='$correlacionado2',tindicado1='$tindicado1', tindicado2='$tindicado2', tindicado3='$tindicado3',tindicado4='$tindicado4',frete='$frete',porta='$porta',fixacao='$fixacao',ecat='$ecat',linha='$linha',cortina_not='$cortina_not' WHERE id='$id'");
	if($sql){
		if(!empty($_FILES["arquivo"]["name"])){
			$nome=$_FILES["arquivo"]["name"];
			$erros=0;
			if($_FILES["arquivo"]["size"] > 512000){
				$erros++;
				$_SESSION["mensagem"].="\\nA imagem deve ter no máximo 500Kb";
			}
			if($erros==0){
				$arquivo="foto/$id.jpg";
				if (file_exists($arquivo)) { 
					unlink($arquivo);
				}
				$upa=copy($_FILES["arquivo"]["tmp_name"], $arquivo);
				if(!$upa){
					$pau=true;
					$_SESSION["mensagem"].="\\nA imagem não pôde ser carregada";
				}else{
					$sql=mysql_query("UPDATE prodserv SET foto='$id.jpg' WHERE id='$id'");
				}
			}else{
				$pau=true;
			}
		}
		if(!$pau){
			$_SESSION["mensagem"]="Produto / Serviço alterado com sucesso!";
		}else{
			$_SESSION["mensagem"]="Produto / Serviço alterado com sucesso porém".$_SESSION["mensagem"];
			$acao="alt";
		}
	}else{
		$_SESSION["mensagem"]="O Produto / Serviço não pôde ser alterado!";
		$acao="alt";
	}
	header("Location:prodserv.php?buscar=true&cat=$cat");
	exit;
}elseif($acao=="exc"){
	if(!empty($id)){
		$sql=mysql_query("DELETE FROM prodserv WHERE id='$id'");
		if($sql){
			$arquivo="foto/$id.jpg";
			if (file_exists($arquivo)) { 
				unlink($arquivo);
			}
			$_SESSION["mensagem"]="Produto / serviço excluído com sucesso!";
		}else{
			$_SESSION["mensagem"]="O produto / serviço não pôde ser excluído!";
		}		
	}
	$acao="entrar";
}elseif($acao=="custo"){
	$icms=valor2banco($icms);
	$ipi=valor2banco($ipi);
	$frete=valor2banco($frete);
	$seguro=valor2banco($seguro);
	$ii=valor2banco($ii);
	$di=valor2banco($di);
	$valor=valor2banco($valor);
	$qtd=valor2banco($qtd);
	$rateado=valor2banco($rateado);
	$custo=valor2banco($custo);
	if($icmsv!="S") $icmsv="N";
	if($icmstv!="S") $icmstv="N";
	if($ipiv!="S") $ipiv="N";
	if($ipitv!="S") $ipitv="N";
	if($fretev!="S") $fretev="N";
	if($segurov!="S") $segurov="N";
	$sql=mysql_query("SELECT * FROM prodserv_custo WHERE prodserv='$id'");
	if(mysql_num_rows($sql)==0){
		$sql=mysql_query("INSERT INTO prodserv_custo (prodserv) VALUES ('$id')");
	}
	$sql=mysql_query("UPDATE prodserv_custo SET icms='$icms',icmsv='$icmsv',icmstv='$icmstv',ipi='$ipi',ipiv='$ipiv',ipitv='$ipitv',frete='$frete',fretev='$fretev',seguro='$seguro',segurov='$segurov',ii='$ii',di='$di',valor='$valor',qtd='$qtd',rateado='$rateado',custo='$custo' WHERE prodserv='$id'");
	if($sql){
		$sql=mysql_query("UPDATE prodserv SET cs='$custo' WHERE id='$id'");
		$_SESSION["mensagem"]="Custo de aquisição alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O custo de aquisição não pôde ser alterado!";
		header("Location:prodserv_custo.php?id=$id");
		exit;
	}
}elseif($acao=="venda"){
	$imp=valor2banco($imp);
	$comi=valor2banco($comi);
	$marg=valor2banco($marg);
	$venda=valor2banco($venda);
	$sql=mysql_query("SELECT * FROM prodserv_venda WHERE prodserv='$id'");
	if(mysql_num_rows($sql)==0){
		$sql=mysql_query("INSERT INTO prodserv_venda (prodserv) VALUES ('$id')");
	}
	$sql=mysql_query("UPDATE prodserv_venda SET imp='$imp',comi='$comi',marg='$marg',venda='$venda' WHERE prodserv='$id'");
	if($sql){
		$sql=mysql_query("UPDATE prodserv SET pv='$venda' WHERE id='$id'");
		$_SESSION["mensagem"]="Preço de venda alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O preço de venda não pôde ser alterado!";
		header("Location:prodserv_venda.php?id=$id");
		exit;
	}	
}elseif($acao=="ordemcan"){
	$sql=mysql_query("DELETE FROM prodserv_ordem WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Ordem de Produção cancelada com sucesso!";
		header("Location:prodserv_ordem.php");
		exit;
	}else{
		$_SESSION["mensagem"]="A Ordem de Produção não pôde ser cancelada!";
		header("Location:prodserv_ordem_abre.php?acao=alt&id=$id");
		exit;
	}
}elseif($acao=="ordeminc"){
	$qtd=valor2banco($qtd);
	$usuario=$_SESSION["login_nome"];
	$sql=mysql_query("SELECT virtual FROM prodserv WHERE id='$item' AND virtual=0");
	if(mysql_num_rows($sql)){
		$sql=mysql_query("INSERT INTO prodserv_ordem (prodserv,qtd,data,usuario) VALUES ('$item','$qtd',NOW(),'$usuario')");
		if($sql){
			$sql=mysql_query("SELECT MAX(id) AS id FROM prodserv_ordem");
			$res=mysql_fetch_array($sql);
			$id=$res["id"];
			$_SESSION["mensagem"]="Ordem de Produção aberta com sucesso!";
			$acao="ordemver";
		}else{
			$_SESSION["mensagem"]="A Ordem de Produção não pôde ser aberta!";
			header("Location:prodserv_ordem_abre.php");
			exit;
		}
	}else{
			$_SESSION["mensagem"]="A Ordem de Produção não pôde ser aberta!\\nEste produto é virtual, verifique e tente novamente";
			header("Location:prodserv_ordem_abre.php");
			exit;	
	}
}elseif($acao=="ordemalt"){
	$qtd=valor2banco($qtd);
	$usuario=$_SESSION["login_nome"];
	$sql=mysql_query("UPDATE prodserv_ordem SET qtd='$qtd',usuario='$usuario' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Ordem de Produção alterada com sucesso!";
		$acao="ordemver";
	}else{
		$_SESSION["mensagem"]="A Ordem de Produção não pôde ser alterada!";
		header("Location:prodserv_ordem_abre.php?acao=alt&id=$id");
		exit;
	}
}elseif($acao=="ecom"){
	if(!empty($ecat)){
		$sz=sizeof($ecat);
		foreach($ecat as $key=>$value){
			$ecata.="$value";
			if(!($key==$sz-1)) $ecata.=",";
		}
	}
	$sql=mysql_query("UPDATE prodserv SET evisivel='$evisivel',ecat='$ecata',ecat2='$ecat2',epri='$epri' WHERE id='$id'");
	if($sql){
		$_SESSION["mensagem"]="Produto alterado com sucesso!";
		$acao="entrar";
	}else{
		$_SESSION["mensagem"]="O produto não pôde ser alterado!";
		header("Location:prodserv_ecom.php?id=$id");
		exit;
	}
}
if($acao=="ordemver"){
	$sql=mysql_query("SELECT * FROM prodserv_item WHERE prodserv='$item'");
	if(mysql_num_rows($sql)){
		$i=0;
		while($res=mysql_fetch_array($sql)){
			$precisa[$i]["id"]=$res["item"];
			$precisa[$i]["qtd"]=$res["qtd"]*$qtd;
			$i++;
		}
		$erro=false;
		for($i=0;$i<sizeof($precisa);$i++){
			$pid=$precisa[$i]["id"];
			$pqtd=$precisa[$i]["qtd"];
			$sql=mysql_query("SELECT * FROM prodserv WHERE id='$pid' AND est>=$pqtd");
			if(!mysql_num_rows($sql)){
				$_SESSION["mensagem"].="\\nPorém faltam alguns produtos no estoque";
				$erro=true;
				break;
			}
		}
		if(!$erro){
			$quem=$_SESSION["login_nome"];
			$doc="OP nº $id";
			for($i=0;$i<sizeof($precisa);$i++){
				$pid=$precisa[$i]["id"];
				$pqtd=$precisa[$i]["qtd"];
				$sql=mysql_query("SELECT custo FROM prodserv_custo WHERE prodserv='$pid'");
				if(mysql_num_rows($sql)){
					$res=mysql_fetch_array($sql);
					$valor=$res["custo"];
				}else{
					$valor=0;
				}
				$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtds,valor,doc,origem,tipomov,quem) VALUES ('$pid',NOW(),'$pqtd','$valor','$doc',2,6,'$quem')");
				$sql=mysql_query("UPDATE prodserv SET est=est-$pqtd WHERE id='$pid'");
			}
			$sql=mysql_query("SELECT custo FROM prodserv_custo WHERE prodserv='$item'");
			if(mysql_num_rows($sql)){
				$res=mysql_fetch_array($sql);
				$valor=$res["custo"];
			}else{
				$valor=0;
			}
			$sql=mysql_query("INSERT INTO prodserv_est (prodserv,data,qtde,valor,doc,origem,tipomov,quem) VALUES ('$item',NOW(),'$qtd','$valor','$doc',2,5,'$quem')");
			$sql=mysql_query("UPDATE prodserv SET est=est+$qtd WHERE id='$item'");
			$sql=mysql_query("UPDATE prodserv_ordem SET sit=1 WHERE id='$id'");
			$_SESSION["mensagem"]="Ordem de Produção finalizada com sucesso";
			$data=urlencode(date("Y-m-d"));
			header("Location:prodserv_ordem.php?sit=1&bde=$data&bate=$data&item=$item");
			exit;
		}
	}
	
	header("Location:prodserv_ordem.php");
	exit;
}
header("Location:prodserv.php?acao=$acao&id=$id");
?>