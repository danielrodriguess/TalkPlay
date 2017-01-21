<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];
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
				<script type="text/javascript" src='../jquery.js'></script>
				<title>Alterar dados - Talkplay</title>
				<script type="text/javascript">
					function carrega(){
						$("#vermensagem").load("alterar.php #vermensagem");
					}
					function tempoatualiza(){
						setInterval("carrega()", 0500);
						setInterval("carrega1()", 0500);
					}
					function carrega1(){
						$(".notificacao").load("alterar.php .notificacao");
						$(".imgnotificacao").load("alterar.php .imgnotificacao");
						//document.getElementById('.notificacao').index.php = location.reload();
					}
				</script>
			</head>
			<body bgcolor='#DCDCDC' link="#E1E1E1" alink="#E1E1E1" vlink="#E1E1E1" onload="tempoatualiza();">
				<a href='index.php'><div class='a'><center><img src='../imagens/teste.png' alt='Haplay' width='50px' height='50px'></img></center></div></a>		
				<div class='lupa'><center><img src='../imagens/lupa.png' alt='Haplay' width='15px' height='15px'></img></center></div>
				<div class='amigo'><center><img src='../imagens/amigo.png' alt='Haplay' width='15px' height='15px'></img></center></div>		
				<center><div class='conta'><font face='Arial'><b>Confirações da sua conta</b></font></div></center>
				<div class='sair'><a href='?go=sair'><font color='Black' face='Arial'>SAIR</a></font></div>
				<div class='logando'>
					<?php
						$_linhaa = mysql_query("select * from nick where email = '$_email'");
						$_nick = @mysql_result($_linhaa,0,'nick');
						$_SESSION['nick'] = $_nick;
						$_imagem = mysql_query("select * from fotodeperfil where email = '$_email'");
						$_caminho = @mysql_result($_imagem,0,'imagem');
					?>
				</div>
				<div class='nick'>
					<?php echo "<font face='Arial'>BEM-VINDO</font>";?>
				</div>
				<div class='notificacao'>
					<?php
						$_notificacao = mysql_query("select * from notificacao where nickdestinatario = '$_nick' and status = 'Não vista'");
						$_contarnotificacao = @mysql_num_rows($_notificacao);
						echo "<font face='Arial'><a href='notificacao.php'>Notificações($_contarnotificacao)</font></a>";
					?>
				</div>
				<div id='vermensagem'>
					<?php
						$_mensagem = mysql_query("select * from mensagem where nickdestinatario = '$_nick' and status = 'Não lida'");
						$_contarmensagem = @mysql_num_rows($_mensagem);
						echo "<font face='Arial'><a href='conversa.php'>Mensagens($_contarmensagem)</a></font>";
					?>
				</div>
				<div class='alterar'>
					<font face='Arial'>ALTERAR DADOS</font>
				</div>
				<div class='imgmensagem'><img src='../Imagens/mensagem.png' width='27px' height='20px'></div>
				<?php	
					if($_contarnotificacao > 0){
						echo "<div class='imgnotificacao'><img src='../Imagens/comnotificacao.png' width='20px' height='20px'></div>";
					}else{
						echo "<div class='imgnotificacao'><img src='../Imagens/semnotificacao.png' width='20px' height='20px'></div>";
					}
				?>
				<?php
					echo "<div class='nick1'>";
					echo "<font face='Arial'>".$_nick."</font>";
					echo "</div>";
				?>
				<?php
					echo "<div class='exibirimagemalterar'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<center><div class='config'>

					<div class='seusdados'>
						<center><b><font face='Arial'>Seus dados</b></center>
						<?php
							$_dados = mysql_query("select * from usuario where email = '$_email'");
							$_dados1 = mysql_query("select * from fotodeperfil where email = '$_email'");
							$_contardados = @mysql_num_rows($_dados);
							if($_contardados > 0){
								$_nome = @mysql_result ($_dados,0,'nome');
								$_email = @mysql_result ($_dados,0,'email');
								$_data = @mysql_result ($_dados,0,'dataa');
								$_pergunta = @mysql_result ($_dados,0,'pergunta');
								$_numero = @mysql_result ($_dados,0,'numerodeacesso');
								$_imagem = @mysql_result ($_dados1,0,'imagem');
								$_real = $_numero - 2;
								echo "<br><br><b>Nome: </b>".$_nome;
								echo "<br><br>";
								echo "<b>Email: </b>".$_email;
								echo "<br><br>";
								echo "<b>Data de nascimento: </b>".$_data;
								echo "<br><br>";
								echo "<b>Sua pergunta de segurança: </b>".$_pergunta;
								echo "<br><br>";
								echo "<b>Número de acessos na sua conta: </b>".$_real;
								echo "<br><br>";
								echo "<b>Apelido utilizado: </b>".$_nick;
								echo "<br><br>";
								echo "<center><b>Foto de perfil utilizada: </b></center>";
								echo "<br><br>";
								echo "<div id=''><center><img src='../fotodeperfil/$_imagem' alt='iSimple' width='140px' height='140px'></img></center></div>";
							}
						?>
					</div></font>
				</div>
					<font face='arial'>
					<div class='hover'>
					<center><br><a href='?go=dados'><font color='Black' face='Arial'>Altere seus dados pessoais</font></a><br><br><br><br>
					<a href='?go=foto'><font color='Black' face='Arial'>Alterar foto de perfil</font></a><br><br><br><br>
					<a href='?go=senha'><font color='Black' face='Arial'>Altere sua senha</font></a></center>
				</font></div>
				<div class='encontrar1'>
					<a href='busca.php'><font color='white' face='Arial'>ENCONTRE AMIGOS</a></font>
				</div>
				<div class='amigos4'>
					<a href='amigo.php'><font color='white' face='Arial'>MEUS AMIGOS</a></font>
				</div>
				<div class='deletarcontar'><a href='deletar.php'><input type='button' id='btndeletar' value='Desativar conta'></a></div><div class='deletarcontar'><a href='deletar.php'><input type='button' id='btndeletar' value='Deletar conta'></a></div>
				<div class='errocontar'><a href='report.php'><input type='button' id='btnerro' value='Reportar erro'></a></div>
			</body>
		</html>
<?php
	}
	if(@$_GET['go'] == 'sair'){
		mysql_query("update jogandonomomento set categoria = 'Nada' where email = '$_email'");
		unset ($_SESSION ['email']);
		unset ($_SESSION ['senha']);
		unset ($_SESSION ['tipo']);
		unset ($_SESSION ['veperguntas']);
		unset ($_SESSION ['tipo']);
		unset ($_SESSION ['score']);
		unset ($_SESSION['nick']);
		unset ($_SESSION ['ranking']);
		mysql_query("delete from denuncia where emailquedenunciou = '$_email' and descricao IS NULL and numero IS NULL");
		mysql_query("update onlinenomomento set status = 'Não' where nick = '$_nick'");
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}elseif(@$_GET['go'] == 'dados'){
		echo "<table>
				<tr>
					<td><a href='?go=nome1'><input type='button' id='alterarnome' value='Alterar nome'></a></td>
					<td><a href='?go=email1'><input type='button' id='alteraremail' value='Alterar e-mail'></a></td>
					<td><a href='?go=nick1'><input type='button' id='alterarnick' value='Alterar apelido'></a></td>
				</tr>
			</table>";
	}elseif(@$_GET['go'] == 'foto'){
		echo "<form method='post' action='?go=foto1' enctype='multipart/form-data'>
							<table id='u'>
								<tr>
									<div class='alinhar2'><font face='Arial'>Escolha uma foto de perfil</font></div>
									<td><input type='file' name='nick'></td>
								</tr>
								<tr>
									<div class='alinhar'><td><input type='submit' value='Confimar' name='confirme' id='btnlogar6'></td></div>
									<div class='alinhar'><td><a href='alterar.php'><input type='button'  class='posicao5' value='Cancelar' name='confirme'></a></td></div>
								</tr>
							</table>
						</form>";
		echo "<div id='padrao1'><center><img src='../fotodeperfil/padrao.jpg' alt='iSimple' width='140px' height='140px'></img></center></div>";
	}elseif(@$_GET['go'] == 'senha'){
		echo "<form method='post' action='?go=trocando'>
							<table id='u1'>
								<tr>
									<td><input type='password' name='senhaatual' placeholder='Senha atual'></td>
								</tr>
								<tr>
									<td><input type='password' name='novasenha1' placeholder='Nova senha'></td>
								</tr>
								<tr>
									<td><input type='password' name='novasenha2' placeholder='Confime sua nova senha'></td>
								</tr>
								<tr>
									<td><input type='text' name='respostadapergunta' class='res' placeholder='Sua resposta'></td>
								</tr>
								<tr>
									<div class='alinhar'><td><input type='submit'  class='posicao3' value='Confimar' name='confirme'></td></div>
									<div class='alinhar'><td><a href='alterar.php'><input type='button'  class='posicao4' value='Cancelar' name='confirme'></a></td></div>
								</tr>
							</table>
						</form>";
						echo "<div class='perres'><font face='Arial'><b>Pergunta de segurança: </b><br>$_pergunta</font></div>";
	}elseif(@$_GET['go'] == 'nome1'){
		echo "<form method='post' action='?go=alterei'>
				<table>
				<tr>
					<td><input type='text' class='posicao' placeholder='Digite seu novo nome' name='nome'></td>
				</tr>
				<tr>
					<td><a href='alterar.php?go=dados'><input type='button' class='posicao2' value='Cancelar'></a></td>
					<td><input type='submit' class='posicao1' value='Confirmar'></td>
				</tr>
			</table>
			</form>";
	}elseif(@$_GET['go'] == 'email1'){
		echo "<form method='post' action='?go=alterei1'>
				<table>
				<tr>
					<td><input type='text' class='posicao' placeholder='Digite seu novo email' name='email'></td>
				</tr>
				<tr>
					<td><a href='alterar.php?go=dados'><input type='button' class='posicao2' value='Cancelar'></a></td>
					<td><input type='submit' class='posicao1' value='Confirmar'></td>
				</tr>
			</table>
			</form>";
	}elseif(@$_GET['go'] == 'nick1'){
		echo "<form method='post' action='?go=alterei2'>
				<table>
				<tr>
					<td><input type='text' class='posicao' placeholder='Digite seu novo apelido' name='nick'></td>
				</tr>
				<tr>
					<td><a href='alterar.php?go=dados'><input type='button' class='posicao2' value='Cancelar'></a></td>
					<td><input type='submit' class='posicao1' value='Confirmar'></td>
				</tr>
			</table>
			</form>";
	}elseif(@$_GET['go'] == 'alterei'){
		$_nome = $_POST['nome'];
		if(empty($_nome)){
			echo "<script type='text/javascript'>alert('Campo vazio')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=nome1'>";
		}else{
			mysql_query("update usuario set nome = '$_nome' where email = '$_email'");
			echo "<script type='text/javascript'>alert('Alterado com sucesso')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=dados'>";
		}
	}elseif(@$_GET['go'] == 'alterei1'){
		$_email1 = $_POST['email'];
		if(empty($_email1)){
			echo "<script type='text/javascript'>alert('Campo vazio')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=email1'>";
		}else{
			$_verificar = mysql_query("select * from usuario where email = '$_email1'");
			$_contarverificar = @mysql_num_rows($_verificar);
			if($_contarverificar > 0){
				echo "<script type='text/javascript'>alert('Email já está sendo utilizado')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=email1'>";
			}else{
			mysql_query("update usuario set email = '$_email1' where email = '$_email'");
			mysql_query("update nick set email = '$_email1' where email = '$_email'");
			mysql_query("update fotodeperfil set email = '$_email1' where email = '$_email'");
			mysql_query("update jogandonomomento set email = '$_email1' where email = '$_email'");
			mysql_query("update senhaalterada set email = '$_email1' where email = '$_email'");
			mysql_query("update fotos set email = '$_email1' where email = '$_email'");
			mysql_query("update denuncia set emailquedenunciou = '$_email1' where emailquedenunciou = '$_email'");
			mysql_query("update denuncia set emaildenunciado = '$_email1' where emaildenunciado = '$_email'");
			mysql_query("update erros set emailqueenviou = '$_email1' where emailqueenviou = '$_email'");
			echo "<script type='text/javascript'>alert('Você precisará realizar o login novamente!')</script>";
			unset ($_SESSION ['email']);
			unset ($_SESSION ['senha']);
			unset ($_SESSION['nick']);
			echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
			}
		}
	}elseif(@$_GET['go'] == 'alterei2'){
		$_apelido = $_POST['nick'];
		if(empty($_apelido)){
			echo "<script type='text/javascript'>alert('Campo vazio')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=nick1'>";
		}else{
			$_verificarnick = mysql_query("select * from nick where nick = '$_apelido'");
			$_contarverificarnick = @mysql_num_rows($_verificarnick);
			if ($_contarverificarnick > 0){
				echo "<script type='text/javascript'>alert('Nick já está sendo utilizado')</script>";
				echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=nick1'>";
			}else{
				if($_apelido == 'Usuario'){
					echo "<script type='text/javascript'>alert('Não é possível alterar seu apelido para 'Usuário'')</script>";
				}else{
				mysql_query("update nick set nick = '$_apelido' where email = '$_email'");
				mysql_query("update notificacao set nickremetente = '$_apelido' where nickremetente = '$_nick'");
				mysql_query("update notificacao set nickdestinatario = '$_apelido' where nickdestinatario = '$_nick'");
				mysql_query("update amigos set nickdestinatario = '$_apelido' where nickdestinatario = '$_nick'");
				mysql_query("update amigos set nickremetente = '$_apelido' where nickremetente = '$_nick'");
				mysql_query("update blok set nickquedeu = '$_apelido' where nickquedeu = '$_nick'");
				mysql_query("update blok set nickquetomou = '$_apelido' where nickquetomou = '$_nick'");
				mysql_query("update mensagem set nickremetente = '$_apelido' where nickremetente = '$_nick'");
				mysql_query("update mensagem set nickdestinatario = '$_apelido' where nickdestinatario = '$_nick'");
				mysql_query("update onlinenomomento set nick = '$_apelido' where nick = '$_nick'");
				mysql_query("update ranking set email = '$_apelido' where email = '$_nick'");
				mysql_query("update denuncia set nickdenunciado = '$_apelido' where email = '$_nick'");
				echo "<script type='text/javascript'>alert('Alterado com sucesso')</script>";
				echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=dados'>";
				}
			}
		}
	}elseif(@$_GET['go'] == 'foto1'){
		if (!empty($_FILES['nick']['name'])){
		$_temporario = $_FILES['nick']['tmp_name'];
		$_nome = $_FILES['nick']['name'];
		$_pegarextensao = pathinfo ($_nome,PATHINFO_EXTENSION);
		$_extensao = strtolower($_pegarextensao);
		if(strstr('.jpg;.jpeg;.png',$_extensao)) {
			$_novo = uniqid(time()).".$_extensao";
			$_destino = '../fotodeperfil/'.$_novo;
			move_uploaded_file($_temporario, $_destino);
			mysql_query("insert into fotos values ('$_email','$_novo','Sim')");
			mysql_query("update fotodeperfil set imagem = '$_novo' where email = '$_email'");
			mysql_query("update ranking set imagem = '$_novo' where email = '$_nick'");
			mysql_query("update fotos set atual = 'Não' where imagem != '$_novo'");
			mysql_query("update notificacao set imagemdodestinatario = '$_novo' where nickremetente = '$_nick'");
			echo "<script type='text/javascript'>alert('Alterada com sucesso')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php'>";
		}else{
			echo "<script type='text/javascript'>alert('Selecione uma imagem. Formatos aceitos: .JPG, .PNG, .JPEG')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=foto'>";
		}
		}else{
			echo "<script type='text/javascript'>alert('Selecione uma imagem')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=foto'>";
		}
	}elseif(@$_GET['go'] == 'trocando'){
		$_senhaatual = $_POST['senhaatual'];
		$_novasenha = $_POST['novasenha1'];
		$_novasenha2 = $_POST['novasenha2'];
		$_resposta = $_POST['respostadapergunta'];
		if(empty($_senhaatual)){
			echo "<script type='text/javascript'>alert('Preencha todos os campos')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=senha'>";	
	}elseif(empty($_novasenha)){
		echo "<script type='text/javascript'>alert('Preencha todos os campos')</script>";
		echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=senha'>";	
	}elseif(empty($_novasenha2)){
		echo "<script type='text/javascript'>alert('Preencha todos os campos')</script>";
		echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=senha'>";	
	}elseif(empty($_resposta)){
		echo "<script type='text/javascript'>alert('Preencha todos os campos')</script>";
		echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=senha'>";	
	}else{
		$_verificarsenha = mysql_query("select * from usuario where email = '$_email' and senha = '$_senhaatual'");
		$_contarverificarsenha = @mysql_num_rows($_verificarsenha);
		if($_contarverificarsenha > 0){
			if($_novasenha != $_novasenha2){
				echo "<script type='text/javascript'>alert('Por favor confirme sua senha')</script>";
				echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=senha'>";
			}else{
				$_verificarresposta = mysql_query("select * from usuario where email = '$_email' and pergunta = '$_pergunta' and resposta = '$_resposta'");
				$_contarverificarresposta = @mysql_num_rows($_verificarresposta);
				if ($_contarverificarresposta > 0){
					mysql_query("insert into senhaalterada values ('$_email','$_senhaatual')");
					mysql_query("update usuario set senha = '$_novasenha' where email = '$_email'");
					echo "<script type='text/javascript'>alert('Senha alterada com sucesso. Por favor efetue o login novamente')</script>";
					unset ($_SESSION ['email']);
					unset ($_SESSION ['senha']);
					unset ($_SESSION['nick']);
					unset ($_SESSION ['tipodepergunta']);
					unset ($_SESSION ['ranking']);
					echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
				}else{
					echo "<script type='text/javascript'>alert('Resposta de segurança inválida')</script>";
					echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=senha'>";
				}
			}
		}else{
			echo "<script type='text/javascript'>alert('Senha atual não confere')</script>";
			echo "<meta http-equiv='refresh' content='0, url=alterar.php?go=senha'>";
		}
	}
	}
?>