<?php
include("conecta.php");
include("seguranca.php");
//selecionar número
		switch($es){
			case "Estudos de RR":
				$es="Estudos de R&R";
				break;
		}
		$sqla=mysql_query("SELECT * FROM agenda WHERE pc='$pc' AND estudo='$es' AND sit='N'");
		$resa=mysql_fetch_array($sqla);
		$conf=$resa["numero"];
		
		$sql=mysql_query("UPDATE agenda SET sit='S',reagendada='N' WHERE numero='$conf'");
	
		$sql_agenda=mysql_query("SELECT * FROM agenda WHERE numero='$conf'");
		$res_agenda=mysql_fetch_array($sql_agenda);
		
		$now=hora();
		$tit=$res_agenda["titulo"];
		$ray1=explode("-",$tit);
		
		mysql_query("INSERT INTO postit (quem,titulo,msg,data,hora,de,denum) VALUES ('$res_agenda[user_apro]', '$ray1[0]', 'O usuário $login_nome já finalizou o estudo $ray1[0] e está aguardando a sua aprovação.', '$data', '$now', '$login_nome', '$codigo')");
		// e-mail para o responsável do cronograma
		//pegar usuario responsavel aprovaçao
			$sql3=mysql_query("SELECT * FROM agenda WHERE numero='$conf'");	
			$res3=mysql_fetch_array($sql3);
			$sql4=mysql_query("SELECT * FROM funcionarios WHERE id='$res3[user_apro]'");	
			$res4=mysql_fetch_array($sql4);
		//pegar resp responsável pelo estudo
			$sql5=mysql_query("SELECT id FROM funcionarios WHERE nome='$login_nome'");	
			$res5=mysql_fetch_array($sql5);
			$sql6=mysql_query("SELECT * FROM funcionarios WHERE id='$res5[id]'");	
			$res6=mysql_fetch_array($sql6);
			
			$inicio=banco2data($res3[ini]);
			$prazo=banco2data($res3[prazo]);
			$mensagem="$res4[nome], o $res6[nome] já finalizou o estudo $ray1[0] da peça $ray1[1]-$ray1[2].";
			$from="From: $login_nome<$res4[email]>";
			mail($res4["email"],$ray1[0],$mensagem,$from);
		//
		
		// cria followup
			
			$sql_emp=mysql_query("SELECT fantasia FROM empresa");
			$res_emp=mysql_fetch_array($sql_emp);
			mysql_query("INSERT INTO followup (empresa,data,hora,titulo,descricao) VALUES ('$res_emp[fantasia]','$data','$now','Finalização da $ray1[0]$ray1[1]-$ray1[2].','O usuário $login_nome finalizou a atividade $ray1[0]$ray1[1]-$ray1[2].')");
			$_SESSION["mensagem"]="Finalizado com sucesso!";
			header("Location:$pag");
			exit;
?>