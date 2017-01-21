<?php
	require_once "../config.php";
	$_id = $_POST['id'];
	$_meunick = $_POST['meunick'];
	$_destino = $_POST['destino'];
	$_img = $_POST['imgre'];
	mysql_query("delete from amigos where id = '$_id'");
	mysql_query("insert into notificacao values (null,'$_meunick','$_img','$_destino','Foi deletado','amigo','','Não vista')");
	echo "<meta http-equiv='refresh' content='0, url=amigo.php'>";
?>