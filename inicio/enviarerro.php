<?php
	require_once "../config.php";
	$_erro = $_POST['erro'];
	$_email = $_POST['email'];
	if(empty($_erro)){
		echo "<script type='text/javascript'>alert('Descreva o erro')</script>";
		echo "<meta http-equiv='refresh' content='0, url=report.php'>";
	}else{
		mysql_query("insert into erros values ('$_email','$_erro')");
		echo "<script type='text/javascript'>alert('Enviado. Sempre estamos fazendo o possível para melhorar! Obrigado pela sua opinião')</script>";
		echo "<meta http-equiv='refresh' content='0, url=index.php'>";
	}
?>