<?php
	require_once "../config.php";
	$_nickdestinatario = $_POST['nick'];
	$_img = $_POST['nick1'];
	$_nick2remetente = $_POST['nick2'];
	mysql_query("insert into notificacao values (null,'$_nick2remetente','$_img','$_nickdestinatario','Aceita?','amigo','','Não vista')");
	mysql_query("insert into amigos values (null,'$_nick2remetente','$_nickdestinatario','Não')");
	echo "<meta http-equiv='refresh' content='0, url=busca.php'>";
?>