<?php
	require_once "../config.php";
	$_nick = $_POST['meunick'];
	$_img = $_POST['fotominha'];
	$_destino = $_POST['destiny'];
	mysql_query("insert into notificacao values (null,'$_nick','$_img','$_destino','Aceita?','amigo','','Não vista')");
	mysql_query("insert into amigos values (null,'$_nick','$_destino','Não')");
	echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
?>