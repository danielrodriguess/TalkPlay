<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['veperguntas'])){
		echo "<meta http-equiv='refresh' content='0, url=jogo1.php'>";
	}else{
		$_valor = $_SESSION['veperguntas'];
		if($_valor == 1){
			$_SESSION['score'] = 0;
			$_score = $_SESSION['score'];
		}else{
			$_score = $_SESSION['score'];
		}
		$_opcao = $_POST['opcao'];
		$_certo = $_POST['certo'];
		if (empty($_opcao)){
			echo "<script type='text/javascript'>alert('Escolha uma opção')</script>";
			echo "<meta http-equiv='refresh' content='0, url=quiz.php'>";
		}else if ($_opcao != $_certo){
			$_valor += 1;
			$_SESSION['veperguntas'] = $_valor;
			$_score = $_score;
			$_SESSION['score'] = $_score;
			echo "<meta http-equiv='refresh' content='0, url=quiz.php'>";
		}else{
			$_valor += 1;
			$_SESSION['veperguntas'] = $_valor;
			$_score += 10;
			$_SESSION['score'] = $_score;
			echo "<meta http-equiv='refresh' content='0, url=quiz.php'>";
		}
	}
?>