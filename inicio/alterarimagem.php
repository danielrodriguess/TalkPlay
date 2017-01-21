<?php
	require_once "../config.php";
	$_imagem = $_POST['imagem'];
	$_email = $_POST['email'];
	$_nick = $_POST['nick'];
			mysql_query("update fotodeperfil set imagem = '$_imagem' where email = '$_email'");
			mysql_query("update fotos set atual = 'Sim' where email = '$_email' and imagem = '$_imagem'");
			mysql_query("update ranking set imagem = '$_imagem' where email = '$_nick'");
			mysql_query("update fotos set atual = 'Não' where imagem != '$_imagem'");
			mysql_query("update notificacao set imagemdodestinatario = '$_imagem' where nickremetente = '$_nick'");
			echo "<meta http-equiv='refresh' content='0, url=fotos.php'>";
?>