<?php
	require_once "../config.php";
	$_nick = $_POST['meunick'];
	$_imagem = $_POST['minhaimagem'];
	$_pergunta = $_POST['pergunta'];
	$_amigos = mysql_query("select * from amigos where nickremetente = '$_nick' and status = 'Sim' || nickdestinatario = '$_nick' and status = 'Sim'");
	$_contaramigos = mysql_num_rows($_amigos);
	if($_contaramigos > 0){
		for($_i=0;$_i<$_contaramigos;$_i++){
			$_resultado = @mysql_fetch_array($_amigos);
			$_nickdestinatario = $_resultado['nickdestinatario'];
			$_nickremetente = $_resultado['nickremetente'];
			if($_nick == $_nickremetente){
				mysql_query("insert into notificacao values (null,'$_nick','$_imagem','$_nickdestinatario','Olha ae','pontos','$_pergunta','Não vista')");
				echo "<script type='text/javascript'>alert('Compartilhado com sucesso')</script>";
				echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
			}elseif($_nick == $_nickdestinatario){
				mysql_query("insert into notificacao values (null,'$_nick','$_imagem','$_nickremetente','Olha ae','pontos','$_pergunta','Não vista')");
				echo "<script type='text/javascript'>alert('Compartilhado com sucesso')</script>";
				echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
			}
		}
	}else{
		echo "<script type='text/javascript'>alert('Você não tem amigos')</script>";
		echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
	}
?>