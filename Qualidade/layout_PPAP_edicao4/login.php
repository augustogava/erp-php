<?php
include("conecta.php");
include("vlm.php");
	$_SESSION["usu"]=$usuario;
	$_SESSION["sen"]=$senha;	
	$ip=$_SERVER['REMOTE_ADDR'];
	$data=date("Y-m-d"); $hora=date("H:i:s");
	$pip=explode(".",$ip);
	if($pip[0]!="192"){
		$dia=date("w");
		switch($dia){
			case "0":
				$dian="Domingo";
				break;
			case "1":
				$dian="Segunda";
				break;
			case "2":
				$dian="Terça";
				break;
			case "3":
				$dian="Quarta";
				break;
			case "4":
				$dian="Quinta";
				break;
			case "5":
				$dian="Sexta";
				break;
			case "5":
				$dian="Sabado";
				break;
		}
		$ext=true;
		$sql=mysql_query("INSERT INTO externo (usuario,data,hora,ip) VALUES('$usuario','$data','$hora','$ip')");
		$msg="<b>Acesso Externo Manager $resas[fantasia]</b><br><br>Usuário: $usuario<br>Data: $data $dian<br>Hora: $hora<br>IP: $ip";
		mail("domingos@cyber1.com.br","Acesso externo Cybermanager ","$msg","From: manager@200.143.15.104\nContent-type: text/html\n");
		mail("douglas@cyber1.com.br","Acesso externo Cybermanager ","$msg","From: manager@200.143.15.104\nContent-type: text/html\n");mail("augusto@cyber1.com.br","Acesso externo Cybermanager ","$msg","From: manager@200.143.15.104\nContent-type: text/html\n");

	}else{
		$ext=false;
	}
include("inclog.php");

$sql=mysql_query("SELECT * FROM online WHERE (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(data)) > 100") or erp_db_fail();
while($res=mysql_fetch_array($sql)){
	$sql2=mysql_query("DELETE FROM online WHERE id='$res[id]'");
}
$sqlb=mysql_query("SELECT * FROM bloquear WHERE id=1");
$resb=mysql_fetch_array($sqlb);
if($resb["block"]=="S"){
	$_SESSION["lerro"]="Sistema em Manutenção";
	header("Location:../adm/index.php");
	exit;
}
//Bloquer externo.....
if($ext){
	if($resb["externo"]=="N"){
	$_SESSION["lerro"]="Acesso Externo Proibido";
	header("Location:../adm/index.php");
	exit;
	}
}
//////////////////////
if(empty($usuario) or empty($senha)){
	$erro=true;
}else{
	if(!$ext){
		$sql=mysql_query("SELECT * FROM cliente_login WHERE login='$usuario' AND senha='$senha' AND sit='A' AND blok='0'");
		if(mysql_num_rows($sql)==0){
			$erro=true;
		}
	}else{
		$sql=mysql_query("SELECT * FROM cliente_login WHERE login='$usuario' AND senha='$senha' AND sit='A' AND blok='0' AND blok_externo='0'");
		if(mysql_num_rows($sql)==0){
			$erro2=true;
		}
	}
}
if($erro){
	$_SESSION["lerro"]="Login Incorreto";
	header("Location:../adm/index.php");
}else if($erro2){
	$_SESSION["lerro"]="Usuário Bloqueado para acesso externo, contate administrador!";
	header("Location:../adm/index.php");
}else{
	$res=mysql_fetch_array($sql);
	if(empty($res[funcionario])){
		$nivelnum=$res["nivel"];
		$cliente=$res["cliente"];
		$sql=mysql_query("SELECT clientes.nome as clinome,niveis.nome as nivel,cliente_login.primeiro as primeiro,cliente_login.id as ids,cliente_login.perm as permissao,cliente_login.aprovar as aprovar,cliente_login.email as email,cliente_login.email_t as email_t,cliente_login.imp  FROM clientes,niveis,cliente_login WHERE clientes.id=$cliente AND clientes.id=cliente_login.cliente AND cliente_login.nivel=niveis.id");
		if(mysql_num_rows($sql)!=0){
			$res=mysql_fetch_array($sql);
			$nome=$res["clinome"];
			$nivel=$res["nivel"];
		}else{
			$nome="Não Localizado";
			$nivel="Não Localizado";
		}
		$sql=mysql_query("SELECT cargos.nome as cargonome FROM funcionarios,cargos WHERE funcionarios.cliente='$cliente' AND cargos.id=funcionarios.cargo");
		if($sql){
			$res=mysql_fetch_array($sql);
			$cargo=$res["cargonome"];
		}
			$_SESSION["login_funcionario"]="N"; // isso sgnifica que o login é de cliente
	}else{
		$nivelnum=$res["nivel"];
		$cliente=$res["funcionario"];
		$sql=mysql_query("SELECT funcionarios.nome as clinome,niveis.nome as nivel,cliente_login.primeiro as primeiro,cliente_login.id as ids,cliente_login.perm as permissao,cliente_login.aprovar as aprovar,cliente_login.email as email,cliente_login.email_t as email_t,cliente_login.imp FROM funcionarios,niveis,cliente_login WHERE funcionarios.id=$cliente AND funcionarios.id=cliente_login.funcionario AND cliente_login.nivel=niveis.id") or erp_db_fail();
		if(mysql_num_rows($sql)!=0){
			$res=mysql_fetch_array($sql);
			$nome=$res["clinome"];
			$nivel=$res["nivel"];
		}else{
			$nome="Não Localizado";
			$nivel="Não Localizado";
		}
		$sql=mysql_query("SELECT cargo FROM funcionarios WHERE id='$cliente'");
		if($sql){
			$cargo=$res["cargo"];
		}
			$_SESSION["login_funcionario"]="S";
	}
	$sql=mysql_query("SELECT * FROM online WHERE user='$cliente'");
	if(mysql_num_rows($sql)){
			$_SESSION["lerro"]="Usuário já logado no sistema";
			header("Location:../adm/index.php");
	}else{
		$_SESSION["email_adm"]=$resm["admin"];
		$_SESSION["permissao"]=$res["permissao"];
		$_SESSION["aprovar"]=$res["aprovar"];
		$_SESSION["i_mp"]=$res["imp"];
		$_SESSION["e_mail"]=$res["email"];
		$_SESSION["e_mail_t"]=$res["email_t"];
		$_SESSION["login_codigo"]=$cliente;
		$_SESSION["login_nome"]=$nome;
		$_SESSION["login_cargo"]=$cargo;
		$_SESSION["login_nivel_nome"]=$nivel;
		$_SESSION["login_nivel"]=$nivelnum;
		$_SESSION["login_c1"]=$usuario;
		if($res["primeiro"]=="S") header("Location:primeiro.php?id=$res[ids]"); else header("Location:index.php");
	}
}
?>