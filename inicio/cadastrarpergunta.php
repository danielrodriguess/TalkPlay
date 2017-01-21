<?php
	require_once "../config.php";
	$_categoria = $_POST['opcao'];
	$_pergunta = $_POST['pergunta'];
	$_alternativa1 = $_POST['alternativa1'];
	$_alternativa2 = $_POST['alternativa2'];
	$_alternativa3 = $_POST['alternativa3'];
	$_alternativa4 = $_POST['alternativa4'];
	$_alternativacerta = $_POST['alternativacerta'];
	$_nick = $_POST['nick'];
	$_img = $_POST['img'];
	if(empty($_categoria) || empty($_pergunta) || empty($_alternativa1) || empty($_alternativa2) || empty($_alternativa3) || empty($_alternativa4) || empty($_alternativacerta)){
		echo "<script>alert('Preencha todos os campos')</script>";
		echo "<meta http-equiv='refresh' content='0, url=enviesuapergunta.php'>";
	}else{
		if($_alternativacerta == $_alternativa1 || $_alternativacerta == $_alternativa2 || $_alternativacerta == $_alternativa3 || $_alternativacerta == $_alternativa4){
			if($_categoria == 'Conhecimentos gerais - Harry Potter'){
				$_categoria1 = "conhecimentosgerais";
			}elseif($_categoria == 'Perguntas de lógica'){
				$_categoria1 = "logica";
			}
			$_verificar = mysql_query("select * from adminperguntas where pergunta = '$_pergunta' and categoria = '$_categoria1'");
			$_contarverificar = mysql_num_rows($_verificar);
			if($_contarverificar > 0){
				echo "<script>alert('Pergunta já enviada ao moderador')</script>";
				echo "<meta http-equiv='refresh' content='0, url=enviesuapergunta.php'>";
			}else{
				mysql_query("insert into adminperguntas values ('$_nick','$_categoria1','$_pergunta','$_alternativa1','$_alternativa2','$_alternativa3','$_alternativa4','$_alternativacerta','Não vista')");
				echo "<script>alert('Pergunta enviada ao moderador. Você receberá uma notificação quando ela for aceita')</script>";
				echo "<meta http-equiv='refresh' content='0, url=enviesuapergunta.php'>";
			}
		}else{
			echo "<meta http-equiv='refresh' content='0, url=enviesuapergunta.php'>";
			echo "<script>alert('Revise sua alternativa certa. Ela precisa está igual ao campo da alternativa')</script>";
		}
	}
?>