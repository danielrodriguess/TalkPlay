<?php
	require_once "../config.php";
	$_id = $_POST['id'];
	$_nick = $_POST['nick'];
	$_imagem = $_POST['imagem'];
	$_nickr = $_POST['nickr'];
		mysql_query("update notificacao set status='Visul' where id='$_id'");
		mysql_query("insert into notificacao values(null,'$_nick','$_imagem','$_nickr','Não aceito','normal','normal','Não vista')");
		echo "<meta http-equiv='refresh' content='0, url=notificacao.php'>";
?>