<meta charset="utf-8">
<?php
	//conectando com bd
	$con = @mysql_connect("localhost","root","") or die("Não foi possível conectar com o servidor");
	//nome do banco
	mysql_select_db("talkplay",$con) or die ("Banco de dados não localizado");
	//acentuação
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
?>