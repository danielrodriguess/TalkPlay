<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];
		$_linha = mysql_query("select * from usuario where email = '$_email' and senha = '$_senha'");
		$_l = @mysql_num_rows($_linha);
		if($_l == 1){
			$_numero = @mysql_result($_linha,0,'numerodeacesso');
			if($_numero != 1){
				echo "<meta http-equiv='refresh' content='0, url=index.php'>";
			}else{
?>
			<html>
				<head>
					<style type="text/css"> 
						a:link{ 
							text-decoration:none;
						} 
					</style>
					<link rel="shortcut icon" href="../imagens/2.ico" type="image/x-icon"/>
					<meta charset='utf-8'>
					<link rel='stylesheet' type='text/css' href='../estilo.css'>
					<title>Bem-vindo - Talkplay</title>
				</head>
				<body bgcolor='#DCDCDC' link="#E1E1E1" alink="#E1E1E1" vlink="#E1E1E1">
					<div class='principal' color='#E1E1E1'>
					<div class='a'><center><img src='../imagens/teste.png' alt='iSimple' width='50px' height='50px'></img></center></div>
					<center>
						<h1>
							Seja bem-vindo <br>
							<?php
								echo $_email;
							?>
						</h1>
					</center>
					<br>
					<center>
						<font face='Arial'>
							Como esse é o seu primeiro acesso, você pode definir algumas preferências de seu perfil.<br>
							Como por exemplo seu apelido que é obrigatório e é atravês dele que as pessoas vão te achar/identificar
						</font>
					</center>
					<br><br><br>
					<center>
						<form method='post' action='?go=nick'>
							<table>
								<tr>
									<font face='Arial'>Digite aqui seu apelido</font>
									<td><input type='text' name='nick' id='nick' maxlength='12'></td>
								</tr>
								<tr>
									<td><input type='submit' value='Confimar' id='btnlogar1'></td>
								</tr>
							</table>
						</form>
					</center>
				</body>
			</html>
			<?php
		}
	}
}
if(@$_GET['go'] == 'nick'){
	$_nick = $_POST['nick'];
	if(empty($_nick)){
		echo "<script type='text/javascript'>alert('Campo vazio')</script>";
	}else{
		$_verificar = mysql_query("select * from nick where nick = '$_nick'");
		$_contarlinhas = @mysql_num_rows($_verificar);
		if($_contarlinhas == 0){
			if($_nick == 'Usuario'){
				echo "<script type='text/javascript'>alert('Não é possível registrar-se com o apelido 'Usuário'')</script>";
			}else{
				mysql_query("insert into nick values ('$_email','$_nick','Sim','Sim')");
				mysql_query("insert into onlinenomomento values ('$_nick','Não')");
				$_result = $_numero + 1;
				mysql_query("update usuario set numerodeacesso = $_result where email='$_email' and senha = '$_senha'");
				echo "<meta http-equiv='refresh' content='0, url=bemvindo2.php'>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Nickname já está sendo utilizado')</script>";
		}
	}
}
?>