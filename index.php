<?php
	require_once "config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
?>
		<html>
			<head>  
				<style type="text/css"> 
					a:link{ 
						text-decoration:none;
					} 
				</style>
				<link rel="shortcut icon" href="imagens/2.ico" type="image/x-icon"/>
				<meta charset='utf-8'>
				<link rel='stylesheet' type='text/css' href='estilo.css'>
				<script type='text/javascript' src='validacao.js'></script>
				<title>Talkplay</title>
			</head>
			<body bgcolor='#DCDCDC' link="#E1E1E1" alink="#E1E1E1" vlink="#E1E1E1">
	
				
				<div class='principal'>
				<div class='a11'><center><img src='imagens/logo.png' alt='iSimple' width='400px' height='150px'></img></center></div>
				<form method='post' action='?go=logar'>
						<div class='log'><center><font face="Arial"><h1>Logue-se</h1></font></center></div>
						<table id='table'>
							<tr>
								<td><input type='text' name='email' maxlength='40' id='email' placeholder='Digite seu e-mail' autocomplete='off'></td>
							</tr>
							<tr>
								<td><input type='password' name='senha' maxlength='12' id='senha' placeholder='Digite sua senha' autocomplete='off'></td>
							</tr>
							<tr>
								<td><input type='submit' name='btnlogar' id='btnlogar' value='Entrar'></td>
							</tr>
						</table>
					</form>
					</div>
				<div class='principal1'>
					<font face='Arial'>
						<form method='post' name='cadastrar' action='?go=cadastrar' onSubmit="return validar();">
							<div class='log2'><center><font face="Arial"><h1>Ou então cadastre-se:</h1></font></center></div>
							<table id='table1'>
								<tr>
									<td><b>Nome</b></td>
									<td><input type='text' name='nome' maxlength='40' id='nome1' autocomplete="off"></td>
								</tr>
								<tr>
									<td><b>E-mail</b></td>
									<td><input type='text' name='email' maxlength='40' id='email2' autocomplete="off"></td>
								</tr>
								<tr>
									<td><b>Senha</b></td>
									<td><input type='password' name='senha' maxlength='12' id='senha2' autocomplete="off"></td>
								</tr>
								<tr>
									<td><b>Confirme a senha</b></td>
									<td><input type='password' name='senha1' maxlength='12' id='senha3' autocomplete="off"></td>
								</tr>
								<tr>
									<td><b>Data de nascimento</b></td>
									<td><input type='text' name='data' maxlength='10' id='data' placeholder='Exemplo: 16/10/1997' autocomplete="off"></td>
								</tr>
								<tr>
									<td>
										<select name='opcao' id='opcao'>
											<option name='aa'>Escolha sua pergunta de segunrança</option>
											<option name='Qual é o nome da sua madrinha?'>Qual é o nome da sua madrinha?</option>
											<option name='Qual era o nome da sua professor na 1° série?'>Qual era o nome da sua professor na 1° série?</option>
											<option name='Nome do seu primeiro cachorro?'>Nome do seu primeiro cachorro?</option>
											<option name='Qual é o sobrenome do seu pai?</'>Qual é o sobrenome do seu pai?</option>
											<option name='Qual é o nome do seu melhor amigo?'>Qual é o nome do seu melhor amigo?</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><b>Sua resposta</b></td>
									<td><input type='text' name='resposta' maxlength='18' id='resposta' autocomplete="off"></td>
								</tr>
								<tr>
									<td><input type='submit' name='btnlogar' id='btnlog' value='Cadastrar'></td>
								</tr>
							</table>
						</form>
					</font>			
				</div>
				<font face='Courier' size='18pt'><div class='bemvindo'>Seja bem-vindo!</div></font>
				<div class='img'><img src='imagens/2.png' width='50px' height='50px' alt='iSimple'></img></div>
				<div class='esqueceuasenha'><font face='Arial'><a href='esqueceuasenha.php'>Esqueceu a senha?</a></font></div>
			</body>
		</html>
<?php
	}else{
	echo "<meta http-equiv='refresh' content='0, url=inicio/bemvindo.php'>";
	}
	if(@$_GET['go'] == 'cadastrar'){
		$_nome = $_POST['nome'];
		$_email = $_POST['email'];
		$_senha = $_POST['senha'];
		$_data = $_POST['data'];
		$_pergunta = $_POST['opcao'];
		$_resposta = $_POST['resposta'];
		$_verificar = strlen($_data);
		if ($_verificar > 10){
			echo "<script type='text/javascript'>alert('Data inválida')</script>";
		}else{
			$_dia = substr($_data,0,2);
			$_mes = substr($_data,3,2);
			$_ano = substr($_data,6,9);
			if ($_ano > 2012){
				echo "<script type='text/javascript'>alert('Muito novo para se cadastrar')</script>";
			}else{
				if ($_ano % 4 == 0 and $_ano % 100 != 0 or $_ano % 400 == 0 ){
					if ($_dia > 29 && $_mes == 02){
						echo "<script type='text/javascript'>alert('Data inválida')</script>";
					}elseif($_dia > '31' or $_mes > '12' or $_dia < 1 or $_mes < 1 or $_ano < 1){
						echo "<script type='text/javascript'>alert('Data inválida')</script>";
					}elseif($_dia == '31' && $_mes != '1' && $_mes != '3' && $_mes != '5' && $_mes != '7' && $_mes != '8' && $_mes != '10' && $_mes != '12'){
						echo "<script type='text/javascript'>alert('Data inválida')</script>";
					}else{
							$_linha = mysql_num_rows(mysql_query("select * from usuario where email = '$_email'"));
						if ($_linha == 1){
							echo "<script type='text/javascript'>alert('E-mail já cadastrado')</script>";
						}else{
							if($_email == 'usuario@talkplay.com'){
								echo "<script type='text/javascript'>alert('E-mail inválido')</script>";
							}else{
							mysql_query("insert into usuario values ('$_nome','$_email','$_senha','$_data','$_pergunta','$_resposta','Comum',0,NOW())");
							mysql_query("insert into jogandonomomento values ('$_email','Não','Nada')");
							mysql_query("insert into senhaalterada values ('$_email','$_senha')");
							echo "<script type='text/javascript'>alert('Cadastro efetuado com sucesso. Logue-se')</script>";
							}
						}	
					}
				}else{
					if ($_dia > 28 && $_mes == 02){
						echo "<script type='text/javascript'>alert('Data inválida')</script>";
					}elseif($_dia > '31' or $_mes > '12' or $_dia < 1 or $_mes < 1 or $_ano < 1){
						echo "<script type='text/javascript'>alert('Data inválida')</script>";
					}elseif($_dia == '31' && $_mes != '1' && $_mes != '3' && $_mes != '5' && $_mes != '7' && $_mes != '8' && $_mes != '10' && $_mes != '12'){
						echo "<script type='text/javascript'>alert('Data inválida')</script>";
					}else{
						$_linha = mysql_num_rows(mysql_query("select * from usuario where email = '$_email'"));
						if ($_linha == 1){
							echo "<script type='text/javascript'>alert('E-mail já cadastrado')</script>";
						}else{
							if($_email == 'usuario@talkplay.com'){
								echo "<script type='text/javascript'>alert('E-mail inválido')</script>";
							}else{
							mysql_query("insert into usuario values ('$_nome','$_email','$_senha','$_data','$_pergunta','$_resposta','Comum',0,NOW())");
							mysql_query("insert into jogandonomomento values ('$_email','Não','Nada')");
							mysql_query("insert into senhaalterada values ('$_email','$_senha')");
							echo "<script type='text/javascript'>alert('Cadastro efetuado com sucesso. Logue-se')</script>";
							}
						}
					}
				}
			}
		}
	}elseif(@$_GET['go'] == 'logar'){
		$_email = $_POST['email'];
		$_senha = $_POST['senha'];
		if(empty($_email)){
			echo "<script type='text/javascript'>alert('Campo vazio')</script>";
		}elseif(empty($_senha)){
			echo "<script type='text/javascript'>alert('Campo vazio')</script>";
		}else{
			$_login1 = mysql_query("select * from adminnovasenha where email = '$_email' and status = 'Não vista'");
			$_contarlogin1 = @mysql_num_rows($_login1);
			if($_contarlogin1 > 0){
				echo "<script type='text/javascript'>alert('Solicitação em andamento')</script>";
			}else{
			$_login2 = mysql_query("select * from adminnovasenha where email = '$_email' and status != 'Não vista'");
			$_contarlogin2 = @mysql_num_rows($_login2);	
			if($_contarlogin2 > 0){
				$_SESSION['solicitacao'] = $_email;
				echo "<script type='text/javascript'>alert('Sua solicitação foi atendida, clique em OK')</script>";
				echo "<meta http-equiv='refresh' content='0, url=solicitacao.php'>";
			}else{
			$_login = mysql_query("select * from usuario where email = '$_email' and senha = '$_senha'");
			$_contarlogin = @mysql_num_rows($_login);
			if($_contarlogin == 1){
				$_pergunta = @mysql_result ($_login,0,'numerodeacesso');
				$_result = $_pergunta + 1;
				mysql_query("update usuario set numerodeacesso = $_result where email = '$_email'");
				if($_result == 1){
					$_SESSION['email'] = $_email;
					$_SESSION['senha'] = $_senha;
					echo "<meta http-equiv='refresh' content='0, url=inicio/bemvindo.php'>";
				}else{
					$_nick = mysql_query("select * from nick where email = '$_email'");
					$_contarnick = @mysql_num_rows($_nick);
					$_user = @mysql_result ($_nick,0,'statususer');
					$_admin = @mysql_result ($_nick,0,'statusadmin');
					if($_user == "Não"){
						echo "<script type='text/javascript'>alert('Conta desativada. Ative-a agora mesmo')</script>";
					echo "<meta http-equiv='refresh' content='0, url=ativar2.php'>";
					}else if($_admin == "Não"){
						echo "<script type='text/javascript'>alert('Devido ao grande número de denúncias sua conta foi removida')</script>";
						echo "<meta http-equiv='refresh' content='0, url=index.php'>";
					}else{
						$_SESSION['email'] = $_email;
						$_SESSION['senha'] = $_senha;
						echo "<meta http-equiv='refresh' content='0, url=inicio/index.php'>";
					}
				}
			}else{
				echo "<script type='text/javascript'>alert('Usuário/Senha inválido')</script>";
			}
			}
		}
		}
	}
?>