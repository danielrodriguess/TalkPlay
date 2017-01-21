<?php
	require_once "../config.php";
	$_imagem = $_POST['imagem'];
	$_email = $_POST['email'];
	$_nick = $_POST['nick'];
	$_ver = mysql_query("select * from fotodeperfil where imagem = '$_imagem' and email = '$_email'");
	$_contarver = mysql_num_rows($_ver);
	if($_contarver > 0){
			$_nova = "padrao.jpg";
			mysql_query("delete from fotos where email = '$_email' and imagem='$_imagem'");
			mysql_query("update fotodeperfil set imagem = '$_nova' where email = '$_email'");
			mysql_query("update ranking set imagem = '$_nova' where email = '$_nick'");
			mysql_query("update notificacao set imagemdodestinatario = '$_nova' where nickremetente = '$_nick'");
			echo "<meta http-equiv='refresh' content='0, url=fotos.php'>";
	}else{
		mysql_query("delete from fotos where email = '$_email' and imagem='$_imagem'");
		echo "<meta http-equiv='refresh' content='0, url=fotos.php'>";
	}
?>