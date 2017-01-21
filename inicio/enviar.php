<?php
	require_once "../config.php";
	$_nickr = $_POST['nickremetente'];
	$_nickd = $_POST['nickdestinatario'];
	mysql_query("insert into mensagem (id,nickremetente,nickdestinatario) values (null,'$_nickr','$_nickd')");
	echo "<meta http-equiv='refresh' content='0, url=conversa.php'>";
?>