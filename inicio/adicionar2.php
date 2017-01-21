<?php
	require_once "../config.php";
	$_id = $_POST['id'];	
	$_nickr = $_POST['nickr'];
	$_img = $_POST['img'];
	$_nickd = $_POST['nick'];	
	mysql_query("update notificacao set status = 'Visto' where id = '$_id'");
	mysql_query("update amigos set status = 'Sim' where nickremetente = '$_nickr' and nickdestinatario = '$_nickd'");
	mysql_query("insert into notificacao values ('','$_nickd','$_img','$_nickr','Aceitou','amigo','','Não vista')");
	echo "<meta http-equiv='refresh' content='0, url=notificacao.php'>";
?>