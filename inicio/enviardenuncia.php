<?php
	require_once "../config.php";
	$_reclamacao = $_POST['reclamacao'];
	$_email = $_POST['meuemail'];
	if(empty($_reclamacao)){
		echo "<script type='text/javascript'>alert('Descreva o motivo')</script>";
		echo "<meta http-equiv='refresh' content='0, url=denunciar.php'>";
	}else{
		$_verificar = mysql_query("select * from denuncia where emailquedenunciou = '$_email' and descricao IS NULL and numero IS NULL");
		$_contarverificar = mysql_num_rows($_verificar);
		if($_contarverificar > 0){
			$_emaildenunciado = @mysql_result($_verificar,0,'emaildenunciado');
			$_verificar1 = mysql_query("select * from denuncias where emaildenunciado = '$_emaildenunciado'");
			$_contarverificar1 = mysql_num_rows($_verificar1);
			if($_contarverificar1 > 0){
				$_numero = @mysql_result($_verificar1,0,'numero');
				$_numero += 1;
				mysql_query("update denuncias set numero = $_numero where emaildenunciado = '$_emaildenunciado'");
				mysql_query("update denuncia set descricao = '$_reclamacao' where emailquedenunciou = '$_email' and descricao IS NULL and numero IS NULL");
				mysql_query("update denuncia set numero = 1 where emailquedenunciou = '$_email' and numero IS NULL");
				echo "<script type='text/javascript'>alert('Denuncia enviada com sucesso. Caso a pessoa continue te incomodando clique em bloquear')</script>";
				echo "<meta http-equiv='refresh' content='0, url=amigo.php'>";
			}else{
				mysql_query("insert into denuncias values ('$_emaildenunciado',1)");
				mysql_query("update denuncia set descricao = '$_reclamacao' where emailquedenunciou = '$_email' and descricao IS NULL and numero IS NULL");
				mysql_query("update denuncia set numero = 1 where emailquedenunciou = '$_email' and numero IS NULL");
				echo "<script type='text/javascript'>alert('Denuncia enviada com sucesso. Caso a pessoa continue te incomodando clique em bloquear')</script>";
				echo "<meta http-equiv='refresh' content='0, url=amigo.php'>";
			}
		}
	}
?>