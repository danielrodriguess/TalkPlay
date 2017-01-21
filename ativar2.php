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
				<title>Ativação de conta - Talkplay</title>
			</head>
				<body bgcolor='#DCDCDC'>
				<div class='principal' color='#E1E1E1'>
				<div class='a'><center><img src='imagens/logo.png' alt='iSimple' width='400px' height='150px'></img></center></div>
					<form method='post' action='?go=trocar'>
						<div class='log'><center><font face="Arial"><h1>Confirme seus dados</h1></font></center></div>
						<table id='table'>
							<tr>
								<td><input type='text' name='email' maxlength='40' id='email' placeholder='Digite seu e-mail' autocomplete='off'></td>
							</tr>
							<tr>	
								<td><input type='password' name='email1' maxlength='40' id='email' placeholder="Confirme sua senha" autocomplete='off'></td>
							</tr>
							<tr>				
								<td><input type='submit' name='btnlogar' id='btnlogar2' value='Confirmar'></td>
							</tr>
						</table>
					</form>
				</div>
				<a href='index.php'><input type='button' name='btnlogar' id='btncancelar20' value='Cancelar'></a>
			</body>
		</html>
<?php
	}else{
		echo "<meta http-equiv='refresh' content='0, url=inicio/bemvindo.php'>";
	}if(@$_GET['go'] == 'trocar'){
		$_aa = $_POST['email'];
		$_saenha =$_POST['email1'];
	if(empty($_aa) || empty($_saenha)){
		echo "<script type='text/javascript'>alert('Preencha o campo')</script>";
		echo "<meta http-equiv='refresh' content='0, url=ativar2.php'>";
	}else{
		$_verificando = mysql_query("select * from usuario where email = '$_aa'");
		$_contarverificando = mysql_num_rows($_verificando);
		if($_contarverificando == 0){
			echo "<script type='text/javascript'>alert('Email inválido')</script>";
			echo "<meta http-equiv='refresh' content='0, url=ativar2.php'>";
		}else{
			$_verificandonick = mysql_query("select * from nick where email = '$_aa'");
			$_contarverificandonick = mysql_num_rows($_verificandonick);
			$_nick = @mysql_result($_verificandonick,0,'nick');
			$_user = @mysql_result($_verificandonick,0,'statususer');
			$_admin = @mysql_result($_verificandonick,0,'statusadmin');
			if($_user == "Não"){
			$_ativar = mysql_query("select * from usuario where email = '$_aa' and senha = '$_saenha'");
			$_contarativar = mysql_num_rows($_ativar);
			if($_contarativar > 0){
				$_img = mysql_query("select * from fotos where email = '$_aa' and atual = 'Sim'");
				$_contarimg = mysql_num_rows($_img);
				if($_contarimg > 0){
					$_img = @mysql_result($_img,0,'imagem');
					mysql_query("update fotodeperfil set imagem = '$_img' where nick = '$_nick'");
					mysql_query("update nick set statususer = 'Sim' where nick = '$_nick'");
					mysql_query("update notificacao set imagemdodestinatario = '$_img' where nickremetente = '$_nick'");
					mysql_query("update ranking set imagem = '$_img' where email = '$_nick'");
					mysql_query("update amigos set status = 'Sim' where nickremetente = '$_nick'");
					mysql_query("update amigos set status = 'Sim' where nickdestinatario = '$_nick'");
					echo "<script type='text/javascript'>alert('Conta ativada com sucesso')</script>";
					echo "<meta http-equiv='refresh' content='0, url=index.php'>";
				}else{
					mysql_query("update fotodeperfil set imagem = 'padrao.jpg' where nick = '$_nick'");
					mysql_query("update nick set statususer = 'Sim' where nick = '$_nick'");
					mysql_query("update notificacao set imagemdodestinatario = 'padrao.jpg' where nickremetente = '$_nick'");
					mysql_query("update ranking set imagem = 'padrao.jpg' where email = '$_nick'");
					mysql_query("update amigos set status = 'Sim' where nickremetente = '$_nick'");
					mysql_query("update amigos set status = 'Sim' where nickdestinatario = '$_nick'");
					echo "<script type='text/javascript'>alert('Conta ativada com sucesso')</script>";
					echo "<meta http-equiv='refresh' content='0, url=index.php'>";
				}
			}else{
				echo "<script type='text/javascript'>alert('Senha inválida')</script>";
			}
		}
	else if($_admin == "Não"){
				echo "<script type='text/javascript'>alert('Sua conta foi desativada pelo nossos admins entre em contato e veja')</script>";
				echo "<meta http-equiv='refresh' content='0, url=index.php'>";
			}else{
				echo "<script type='text/javascript'>alert('Sua conta não está desativada. Por favor faça seu login')</script>";
				echo "<meta http-equiv='refresh' content='0, url=index.php'>";
			}
	
	}
	}
	}
?>