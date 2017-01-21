<?php
	require_once "../config.php";
	$_email = $_SESSION['email'];
	mysql_query("update jogandonomomento set jogandonomomento = 'Não' where email = '$_email'");
	
?>