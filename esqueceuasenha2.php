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
			echo "<script type='text/javascript'>alert('Já contatou nossos administradores. Aguarde')</script>";
			echo "<meta http-equiv='refresh' content='0, url=index.php'>";
		}else{
			$_verificar2 = mysql_query("select * from adminnovasenha where email = '$_email' and status != 'Não vista'");
			$_contarverificar2 = mysql_num_rows($_verificar2);
			if($_contarverificar2 > 0){
				$_SESSION['solicitacao'] = $_email;
				echo "<script type='text/javascript'>alert('Sua solicitação foi atendida, clique em OK')</script>";
				echo "<meta http-equiv='refresh' content='0, url=solicitacao.php'>";
			}else{
?>
		<html>
			<head>
				<link rel="shortcut icon" href="imagens/2.ico" type="image/x-icon"/>
				<meta charset='utf-8'>
				<link rel='stylesheet' type='text/css' href='estilo.css'>
				<title>Esqueceu a senha - Talkplay</title>
			</head>
			<body bgcolor='#DCDCDC'>
				<div class='a1'><center><img src='imagens/logo.png' alt='iSimple' width='400px' height='150px'></img></center></div>
				<div class='principal3' color='#E1E1E1'>
					<font face='Arial'><div class='log3'><center><font face="Arial"><h1>Verificação de segurança</h1></font></center></div>
					<form method='post' action='?go=trocar'>
						<table id='table'>
							<tr>
								<td>Digite a senha que lembra</td>
								<td><input type='password' name='troca1' maxlength='12' id='troca1' placeholder='Senha'></td>
							</tr>
							<tr>					
								<td>Qual é a resposta para essa pergunta?</td>
							</tr>
							<tr>					
								<td>
									<?php
										$_linha = mysql_query("select * from usuario where email = '$_email'");
										$_linhas = @mysql_num_rows($_linha);
										if($_linhas == 1){
											$_pergunta = @mysql_result ($_linha,0,'pergunta');
											echo $_pergunta;
										}
									?>
								</td>
							</tr>
							<tr>
								<td><input type='text' maxlength='18' name='troca2' id='troca2' autocomplete='off' placeholder='Sua resposta'></td>
							</tr>
							<tr>
								<td>Nova senha</td>
								<td><input type='password' maxlength='12' name='senha1' autocomplete='off' placeholder='Nova senha'></td>
							</tr>
							<tr>
								<td>Confirme sua nova senha</td>
								<td><input type='password' maxlength='12' name='senha2' autocomplete='off' placeholder='Confirme sua nova senha'></td>
							</tr></font>
							<tr>
								<td><input type='submit' value='Confirmar' id='btnlogar1'></td>
							</tr>
						</table>
					</form>
				</div>
				<a href='index.php'><input type='button' name='btnlogar' id='btnlogar5' value='Cancelar'></a>
				<a href='admin.php'><input type='button' name='btnlogar1' id='btnlogarcontato' value='Contatar admin'></a>
			</body>
		</html>
<?php
			}
		}
		if(@$_GET['go'] == 'trocar'){
			$_senha = $_POST['troca1'];
			$_resposta = $_POST['troca2'];
			if(empty($_senha)){
				echo "<script type='text/javascript'>alert('Campo vazio')</script>";
			}elseif(empty($_resposta)){
				echo "<script type='text/javascript'>alert('Campo vazio')</script>";
			}else{
				$_linhaaa = mysql_query("select * from senhaalterada where email = '$_email' and senhaantiga = '$_senha'");
				$_linhaaas = @mysql_num_rows($_linhaaa);
				$_linhaaaa = mysql_query("select * from usuario where email = '$_email' and pergunta = '$_pergunta' and resposta = '$_resposta'");
				$_linhaaaas = @mysql_num_rows($_linhaaaa);
				if($_linhaaas == 1 && $_linhaaaas == 1){
					$_senha1 = $_POST['senha1'];
					$_senha2 = $_POST['senha2'];
					if(empty($_senha1)){
						echo "<script type='text/javascript'>alert('Campo vazio')";
						echo '<script>window.setTimeout("history.back()", 1000);</script>';
					}elseif(empty($_senha2)){
						echo "<script type='text/javascript'>alert('Campo vazio')</script>";
						echo '<script>window.setTimeout("history.back()", 1000);</script>';
					}else{
						if($_senha1 != $_senha2){
							echo "<script type='text/javascript'>alert('Senhas não conferem')</script>";
						}else{
							$_contar = strlen($_senha1);
							$_contar1 = strlen($_senha2);
							if($_contar < 8 || $_contar1 < 8){
								echo "<script type='text/javascript'>alert('Sua senha precisa de ter no mínimo OITO caracteres')</script>";
							}else{
								$_a = mysql_query("select * from usuario where email = '$_email'");
								$_aa = @mysql_num_rows($_a);
								if($_aa == 1){
									$_b = mysql_query("select * from senhaalterada where email = '$_email' and senhaantiga = '$_senha1'");
									$_bb = @mysql_num_rows($_b);
									if($_bb != 0){
										echo "<script type='text/javascript'>alert('Você já utilizou essa senha. Troque por outra')</script>";
									}else{
										$_senha = @mysql_result ($_a,0,'senha');
										mysql_query("insert into senhaalterada values ('$_email','$_senha')");
										mysql_query("update usuario set senha = '$_senha2' where email = '$_email'");
										echo "<script type='text/javascript'>alert('Alterado com sucesso. Vamos te redirecionar para a página de login')</script>";
										unset ($_SESSION ['trocarsenha']);
										echo "<meta http-equiv='refresh' content='0, url=index.php'>";
									}
								}
							}
						}
					}
				}else{
					echo "<script type='text/javascript'>alert('Senha não localizada ou resposta inválida. Envie-nos um e-mail')</script>";
				}
			}
		}
	}
?>