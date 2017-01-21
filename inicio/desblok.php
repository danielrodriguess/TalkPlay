<?php
	require_once "../config.php";
	$_nickquedeu = $_POST['dei'];
	$_destino = $_POST['destino'];
	mysql_query("delete from blok where nickquedeu = '$_nickquedeu' && nickquetomou = '$_destino'");
	echo "<meta http-equiv='refresh' content='0, url=amigo.php'>";
?>