<?php
	require_once "config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
?>
		<html>
			<head>
				<link rel="shortcut icon" href="imagens/2.ico" type="image/x-icon"/>
				<meta charset='utf-8'>
				<link rel='stylesheet' type='text/css' href='estilo.css'>
				<title>Esqueceu a senha - Talkplay</title>
			</head>
				<body bgcolor='#DCDCDC'>
				<div class='principal' color='#E1E1E1'>
				<div class='a'><center><img src='imagens/logo.png' alt='iSimple' width='400px' height='150px'></img></center></div>
					<form method='post' action='?go=trocar'>
						<div class='log'><center><font face="Arial"><h1>Digite seu email</h1></font></center></div>
						<table id='table'>
							<tr>
								<td><input type='text' name='email' maxlength='40' id='email' placeholder='Digite seu e-mail' autocomplete='off'></td>
							</tr>
							<tr>					
								<td><input type='submit' name='btnlogar' id='btnlogar2' value='Continuar'></td>
							</tr>
						</table>
					</form>
				</div>
				<a href='index.php'><input type='button' name='btnlogar' id='btnlogar3' value='Voltar'></a>
			</body>
		</html>
<?php
	}else{
		echo "<meta http-equiv='refresh' content='0, url=inicio/bemvindo.php'>";
	}	
	if(@$_GET['go'] == 'trocar'){
		$_email = $_POST['email'];
		if(empty($_email)){
			echo "<script type='text/javascript'>alert('Campo vazio')</script>";
		}else{
			$_linha = mysql_query("select * from usuario where email = '$_email'");
			$_linhas = @mysql_num_rows($_linha);
			if($_linhas == 1){
				$_nick = mysql_query("select * from nick where email = '$_email'");
				$_pegarnick = @mysql_num_rows($_nick);
				$_admin = @mysql_result($_nick,0,'statusadmin');
				$_user = @mysql_result($_nick,0,'statususer');
				if($_user == "Não"){
					echo "<script type='text/javascript'>alert('Conta desativada. Ative-a agora mesmo')</script>";
					echo "<meta http-equiv='refresh' content='0, url=ativar2.php'>";
				}else if($_admin == "Não"){
					echo "<script type='text/javascript'>alert('Devido ao grande número de denúncias sua conta foi removida')</script>";
					echo "<meta http-equiv='refresh' content='0, url=esqueceuasenha.php'>";
				}else{
					$_SESSION['trocarsenha'] = $_email;
					echo "<meta http-equiv='refresh' content='0, url=esqueceuasenha2.php'>";
				}
			}else{
				echo "<script type='text/javascript'>alert('E-mail inválido')</script>";
			}
		}
	}
?>