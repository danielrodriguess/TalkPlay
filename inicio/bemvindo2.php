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
			if($_numero != 2){
				echo "<meta http-equiv='refresh' content='0, url=bemvindo.php'>";
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
							Escolha sua foto de perfil e diverta-se!
						</font>
					</center>
					<br><br><br>
					<center>
						<form method='post' action='?go=nick' enctype="multipart/form-data">
							<table>
								<tr>
									<font face='Arial'>Escolha uma foto de perfil</font>
									<td><input type='file' name='nick'></td>
								</tr>
								<tr>
									<div class='alinhar'><td><input type='submit' value='Confimar' name='confirme' id='btnlogar6'></td></div>
								</tr>
							</table>
						</form>
						<form method='post' action='?go=dps'>
							<table>
								<tr>
									<td><input type='submit' value='Pular essa parte' id='btnlogar7'></td>
								</tr>
							</table>
						</form>
					</center>
					<div class='padrao'><center><img src='../fotodeperfil/padrao.jpg' alt='iSimple' width='140px' height='140px'></img></center></div>
				</body>
			</html>
			<?php
		}
	}
}
if(@$_GET['go'] == 'nick'){
		if (!empty($_FILES['nick']['name'])){
		$_temporario = $_FILES['nick']['tmp_name'];
		$_nome = $_FILES['nick']['name'];
		$_pegarextensao = pathinfo ($_nome,PATHINFO_EXTENSION);
		$_extensao = strtolower($_pegarextensao);
		if(strstr('.jpg;.jpeg;.png',$_extensao)) {
			$_novo = uniqid(time()).".$_extensao";
			$_destino = '../fotodeperfil/'.$_novo;
			move_uploaded_file($_temporario, $_destino);
			mysql_query("insert into fotodeperfil values (null,'$_email','$_novo')");
			mysql_query("insert into fotos values ('$_email','$_novo','Sim')");
			echo "<div class='padrao1'><center><img src='../fotodeperfil/$_novo' alt='iSimple' width='140px' height='140px'></img></center></div>";
			echo "<meta http-equiv='refresh' content='1, url=index.php'>";
			$_result = $_numero + 1;
			
			mysql_query("update usuario set numerodeacesso = $_result where email='$_email' and senha = '$_senha'");
		}else{
			echo "<script type='text/javascript'>alert('Selecione uma imagem. Formatos aceitos: .JPG, .PNG, .JPEG')</script>";
		}
		}else{
			echo "<script type='text/javascript'>alert('Selecione uma imagem')</script>";
		}
}else if(@$_GET['go'] == 'dps'){
	$_nome = 'padrao.jpg';
	mysql_query("insert into fotodeperfil values (null,'$_email','$_nome')");
	echo "<meta http-equiv='refresh' content='0, url=index.php'>";
	$_result = $_numero + 1;
	mysql_query("update usuario set numerodeacesso = $_result where email='$_email' and senha = '$_senha'");
	echo "<meta http-equiv='refresh' content='0, url=index.php'>";
}
?>