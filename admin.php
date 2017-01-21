<?php
	require_once "config.php";
	session_start();
	if (!isset($_SESSION['trocarsenha'])){
		echo "<meta http-equiv='refresh' content='0, url=index.php'>";
	}else{
		$_email = $_SESSION['trocarsenha'];	
		$_verificar1 = mysql_query("select * from adminnovasenha where email = '$_email' and status = 'Não vista'");
		$_contarverificar1 = mysql_num_rows($_verificar1);
		if($_contarverificar1 > 0){
			echo "<script type='text/javascript'>alert('Solicitação em andamento. Aguarde')</script>";
			echo "<meta http-equiv='refresh' content='0, url=index.php'>";
		}else{
?>
		<html>
			<head>
				<link rel="shortcut icon" href="imagens/2.ico" type="image/x-icon"/>
				<meta charset='utf-8'>
				<link rel='stylesheet' type='text/css' href='estilo.css'>
				<title>Entrar em contato com administração - Talkplay</title>
			</head>
			<body bgcolor='#DCDCDC'>
				<div class='a1'><center><img src='imagens/logo.png' alt='iSimple' width='400px' height='150px'></img></center></div>
				<a href='index.php'><input type='button' name='btnlogar' id='btnlogarcancelar' value='Cancelar'></a>
				<br><br><br><br><br><center><font face='Arial'>Confirme algumas informações</font></center>
				<?php
				$_p = mysql_query("select * from usuario where email = '$_email'");
				$_pergunta = @mysql_result($_p,0,'pergunta');
				echo "<table>
				<form method='post' action='?go=admin'>
					<tr>
						<td><font face='Arial'>Digite seu nome(o nome que você cadastrou): </font></td>
						<td><input type='text' name='troca1' maxlength='36' id='troca1'></td>
					</tr>
					
					<tr>
						<td><font face='Arial'><b><br><br>Responda: </b>$_pergunta</font></td>
					</tr>
					<tr>
						<td><font face='Arial'><b>Resposta: </b></font></td>
						<td><input type='text' name='troca2' maxlength='36' id='troca1'></td>
					</tr>
					<tr>
						<td><input type='checkbox' name='troca3' maxlength='36' id='troca1'><font face='Arial'>Não sei a resposta</font></td>
					</tr>
					<tr>
						<td><input type='submit' id='troca10' value='Enviar dados'></td>
					</tr>
				</form>
				</table>";
				?>
			</body>
		</html>
<?php
	}
	}
	if(@$_GET['go'] == 'admin'){
		$_nome = $_POST['troca1'];
		$_resposta = $_POST['troca2'];
		if(empty($_nome)){
			echo "<script type='text/javascript'>alert('Coloque seu nome')</script>";
		}else if(empty($_resposta) && !isset($_POST['troca3'])){
			echo "<script type='text/javascript'>alert('Por favor sua resposta')</script>";
		}else{
			$_verificarnome = mysql_query("select * from usuario where email = '$_email' and nome = '$_nome'");
			$_contarverificarnome = mysql_num_rows($_verificarnome);
			if($_contarverificarnome > 0){
				if(isset($_POST['troca3']) && empty($_resposta)){
					echo "<script type='text/javascript'>alert('Olá $_nome. Infelizmente não há nada que possamos fazer, por favor crie uma nova conta')</script>";
					unset($_SESSION['trocarsenha']);
					echo "<meta http-equiv='refresh' content='0, url=index.php'>";
				}else{
					$_verificarnome2 = mysql_query("select * from usuario where email = '$_email' and nome = '$_nome' and pergunta = '$_pergunta' and resposta = '$_resposta'");
					$_contarverificarnome2 = mysql_num_rows($_verificarnome2);
					if($_contarverificarnome2 > 0){
						$_a = rand(1,100000);
						mysql_query("insert into adminnovasenha values ('$_email',$_a,'Não vista','','')");
						echo "<script type='text/javascript'>alert('Olá $_nome, seu código é $_a. Anote-o e guarde-o pois vai precisar dele para concluir sua alteração.')</script>";
						unset($_SESSION['trocarsenha']);
						echo "<meta http-equiv='refresh' content='0, url=index.php'>";
					}else{
						echo "<script type='text/javascript'>alert('Resposta incorreta')</script>";
					}
				}
			}else{
				echo "<script type='text/javascript'>alert('Nome incorreto')</script>";
			}
		}
	}
?>