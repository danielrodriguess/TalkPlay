<?php
	require_once "config.php";
	session_start();
	$_email = $_SESSION['solicitacao'];
		$_verificar1 = mysql_query("select * from adminnovasenha where email = '$_email' and status != 'Não vista'");
		$_contarverificar1 = mysql_num_rows($_verificar1);
		if($_contarverificar1 > 0){
?>
		<html>
			<head>
				<link rel="shortcut icon" href="imagens/2.ico" type="image/x-icon"/>
				<meta charset='utf-8'>
				<link rel='stylesheet' type='text/css' href='estilo.css'>
				<title>Solicitações - Talkplay</title>
			</head>
			<body bgcolor='#DCDCDC'>
				<div class='a1'><center><img src='imagens/logo.png' alt='iSimple' width='400px' height='150px'></img></center></div>
				<a href='index.php'><input type='button' name='btnlogar' id='btnlogarcancelar' value='Cancelar'></a>
				<center><font face='Arial'><b><br><br>Recuperação de senha</b></font></center>
				<table>
				<form method='post' action='?go=admin'>
				<tr>
					<td><font face='Arial'>Confirme o código informado: </font></td>
					<td><input type='text' name='cod'></td>
				<tr>
				<tr>
					<td><input type='submit' value='Confirmar' id='btncodigo'></td>
				<tr>
				</form>
				</table>
			</body>
		</html>
<?php
	}else{
		echo "<script type='text/javascript'>alert('Solicitação em andamento. Aguarde')</script>";
		echo "<meta http-equiv='refresh' content='0, url=index.php'>";
	}
	if(@$_GET['go'] == 'admin'){
		$_codigo = $_POST['cod'];
		if(empty($_codigo)){
			echo "<script type='text/javascript'>alert('Confirme seu código')</script>";
		}else{
			$_verificarcodigo = mysql_query("select * from adminnovasenha where email = '$_email' and codigo = '$_codigo'");
			$_contarverificarcodigo = mysql_num_rows($_verificarcodigo);
			if($_contarverificarcodigo > 0){
				$_novasenha = @mysql_result($_verificarcodigo,0,'novasenha');
				mysql_query("delete from adminnovasenha where email = '$_email'");
				echo "<script type='text/javascript'>alert('Sua nova senha: $_novasenha. Logue-se')</script>";
				echo "<meta http-equiv='refresh' content='0, url=index.php'>";
			}else{
				$_verificarcodigo2 = mysql_query("select max(numero) as cod from adminnovasenha where email = '$_email'");
				$_contarverificarcodigo2 = mysql_num_rows($_verificarcodigo2);
				if($_contarverificarcodigo2 > 0){
					$_numero = @mysql_result($_verificarcodigo2,0,'cod');
					$_numero += 1;
					$_v = 5 - $_numero;
					if($_v != 0){
						mysql_query("update adminnovasenha set numero = $_numero where email = '$_email'");
						echo "<script type='text/javascript'>alert('Código inválido. Você tem $_v tentativas.')</script>";
					}else{					
						mysql_query("delete from adminnovasenha where email = '$_email'");
						echo "<script type='text/javascript'>alert('Código inválido. Faça outra solicitação, obrigado!')</script>";
						echo "<meta http-equiv='refresh' content='0, url=esqueceuasenha2.php'>";
					}
				}
			}
		}
	}
?>