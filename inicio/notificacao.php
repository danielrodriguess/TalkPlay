<?php
		require_once "../config.php";
		session_start();
		if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
			echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
		}else{
			$_email = $_SESSION['email'];
			$_senha = $_SESSION['senha'];
			mysql_query("update jogandonomomento set categoria = '' where email = '$_email'");
			mysql_query("delete from denuncia where emailquedenunciou = '$_email' and descricao IS NULL and numero IS NULL");
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
				<title>Notificações - Talkplay</title>
				<script type="text/javascript">
					function carrega(){
						$("#vermensagem").load("notificacao.php #vermensagem");
					}
					function tempoatualiza(){
						setInterval("carrega()", 0500);
						setInterval("carrega1()", 0500);
					}
					function carrega1(){
						$(".porra").load("notificacao.php .porra");
						$(".imgnotificacao2").load("notificacao.php .imgnotificacao2");
						//document.getElementById('.notificacao').index.php = location.reload();
					}
				</script>
			</head>
			<body bgcolor='#DCDCDC' link="#E1E1E1" alink="#E1E1E1" vlink="#E1E1E1" onload="tempoatualiza();">
				<a href='index.php'><div class='a'><center><img src='../imagens/teste.png' alt='Haplay' width='50px' height='50px'></img></center></div></a>		
				<div class='lupa'><center><img src='../imagens/lupa.png' alt='Haplay' width='15px' height='15px'></img></center></div>
				<div class='amigo'><center><img src='../imagens/amigo.png' alt='Haplay' width='15px' height='15px'></img></center></div>
				<div class='sair'><a href='?go=sair'><font color='Black' face='Arial'>SAIR</a></font></div>
				<div class='logando'>
					<?php
						$_linhaa = mysql_query("select * from nick where email = '$_email'");
						$_nick = @mysql_result($_linhaa,0,'nick');
						$_SESSION['nick'] = $_nick;
						$_atualizar = mysql_query("update notificacao set status = 'Visto' where nickdestinatario = '$_nick' && notificacao = 'Aceitou' or nickdestinatario = '$_nick' && notificacao = 'Não aceitou' or nickdestinatario = '$_nick' && notificacao = 'Foi deletado'");
						$_atualizar1 = mysql_query("update notificacao set status = 'Visto' where nickdestinatario = '$_nick' && notificacao = 'amigoo'");
						$_imagem = mysql_query("select * from fotodeperfil where email = '$_email'");
						$_caminho = @mysql_result($_imagem,0,'imagem');
					?>
				</div>
				<div class='nick'>
					<?php 
						echo "<font face='Arial'>BEM-VINDO</font>";
					?>
				</div>
				<div class='notificacao1'>
					<?php
						$_notificacao = mysql_query("select * from notificacao where nickdestinatario = '$_nick' and status = 'Não vista'");
						$_contarnotificacao = @mysql_num_rows($_notificacao);
						if($_contarnotificacao > 0){
							echo "<center><div class='porra'><font face='Arial'>Notificações($_contarnotificacao)</font></center></div>";
						}else{
							echo "<center><div class='porra'><font face='Arial'>Notificações($_contarnotificacao)</font></center></div>";
						}
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
					<a href='alterar.php'><font color='Black' face='Arial'>ALTERAR DADOS</a></font>
				</div>
				<div class='paginainicial'>
					<font face='Arial'><a href='index.php'>PÁGINA INICIAL</a></font>
				</div>
				<br>		
			<div class='imgmensagem4'><img src='../Imagens/mensagem.png' width='27px' height='20px'></div>
				<?php
					if($_contarnotificacao > 0){
						echo "<div class='imgnotificacao2'><img src='../Imagens/comnotificacao.png' width='20px' height='20px'></div>";
					}else{
						echo "<div class='imgnotificacao2'><img src='../Imagens/semnotificacao.png' width='20px' height='20px'></div>";
					}
				?>
				<?php
					echo "<div class='nick5'>";
					echo "<font face='Arial'>".$_nick."</font>";
					echo "</div>";
				?>
				<?php
					echo "<div class='exibirimagemnotificacao'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<font face='Arial'><center><div class='mostrartodas' style='z-index:1; overflow: auto'>
					<b><font face='Arial'>Todas as notificações</font></b><br><br>
					<?php
						$_mostrando = mysql_query("select * from notificacao where nickdestinatario = '$_nick' order by id desc");
						$_contarmostrando = @mysql_num_rows($_mostrando);
						for($_i=0;$_i<$_contarmostrando;$_i++){
							$_resultado = mysql_fetch_assoc($_mostrando);
							$_nickremetente = $_resultado['nickremetente'];
							$_notificacao = $_resultado['notificacao'];
							$_status = $_resultado['status'];
							$_blok = mysql_query("select * from blok where nickquedeu = '$_nick' && status = 'Sim' || nickquetomou = '$_nick' && status = 'Sim'");
							$_pegarblok = @mysql_num_rows($_blok);
							if($_pegarblok == 0){
							$_imagem = $_resultado['imagemdodestinatario'];
							}else{
								$_imagem = "padrao.jpg";
							}
							$_tipo = $_resultado['tipo'];
							$_categoria = $_resultado['categoria'];
							$_id = $_resultado['id'];
							$_imagem1 = mysql_query("select * from fotodeperfil where email = '$_email'");
							$_caminho1 = @mysql_result($_imagem1,0,'imagem');
							if($_tipo == 'desafio'){
							if($_status == 'Não vista'){
								echo "<div class='cada1'>";
								echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
								echo "<b>       ".$_nickremetente."</b>";
								echo " te desafiou na categoria $_categoria";
								echo "<br><form method='post' action='tratar.php'>
								<input type='hidden' value='$_id' name='id'>
								<input type='hidden' value='$_nick' name='nick'>
								<input type='hidden' value='$_caminho1' name='imagem'>
								<input type='hidden' value='$_nickremetente' name='nickr'>
								<input type='hidden' value='$_caminho1' name='img'>
								<input type='hidden' value='Aceitar' id='btaceitar'>
								<input type='submit' value='Aceitar' id='btaceitar'>
								<input type='submit' value='Recusar' id='btrecusar'>
								</form></div><br><br>";
							}else{
								echo "<div class='cada'>";
								echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
								echo "<b>       ".$_nickremetente."</b>";
								echo " te desafiou na categoria $_categoria";
								echo "</div><br><br>";
							}
							}elseif($_tipo == 'amigo'){
								if($_notificacao == 'Não aceitou'){
									echo "<div class='cada'>";
									echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
									echo "<b>       ".$_nickremetente."</b>";
									echo " Não aceitou sua solicitação de amizade";
									echo "</div><br><br>";
								}elseif($_notificacao == 'Aceitou'){
									echo "<div class='cada'>";
									echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
									echo "<b>       ".$_nickremetente."</b>";
									echo " aceitou sua solicitação de amizade";
									echo "</div><br><br>";
								}elseif($_notificacao == 'Foi deletado'){
									echo "<div class='cada'>";
									echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
									echo "<b>       ".$_nickremetente."</b>";
									echo " te deletou da lista de amigos";
									echo "</div><br><br>";
								}
								else{
								if($_status == 'Não vista'){
								echo "<div class='cada1'>";
								echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
								echo "<b>       ".$_nickremetente."</b>";
								echo " te enviou uma solicitação de amizade";
								echo "<br><form method='post' action='adicionar1.php'>
								<input type='hidden' value='$_id' name='id'>
								<input type='hidden' value='$_nick' name='nick'>
								<input type='hidden' value='$_caminho1' name='imagem'>
								<input type='hidden' value='$_nickremetente' name='nickr'>
								<input type='hidden' value='$_caminho1' name='img'>							
								<input type='submit' value='Recusar' id='btrecusar'>
								</form>
								<form method='post' action='adicionar2.php'>
									<input type='hidden' value='$_id' name='id'>
								<input type='hidden' value='$_nick' name='nick'>
								<input type='hidden' value='$_caminho1' name='imagem'>
								<input type='hidden' value='$_nickremetente' name='nickr'>
								<input type='hidden' value='$_caminho1' name='img'>
								<input type='submit' value='Aceitar' id='btaceitar1'>
								</form>
								</div><br><br>";							
							}else{
								echo "<div class='cada'>";
								echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
								echo "<b>       ".$_nickremetente."</b>";
								echo " te enviou uma solicitação de amizade";
								echo "</div><br><br>";
							}
							}
							}elseif($_tipo == 'admin'){
								if($_notificacao == 'amigoo'){
									echo "<div class='cada'>";
									echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
									echo "<b>       ".$_nickremetente.":</b> ";
									echo $_categoria;
									echo "</div><br><br>";
								}
							}elseif($_tipo == 'pontos'){
								if($_status == 'Não vista'){
									if($_notificacao == 'Olha ae'){
										echo "<div class='cada2'>";
										echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
										echo "<b>       ".$_nickremetente."</b>";
										$_pontos = mysql_query("select * from ranking where email = '$_nickremetente' and categoria = '$_categoria'");
										$_peguei = @mysql_result($_pontos,0,'pontuacao');		
										echo " fez $_peguei pontos no TalkResponde na categoria $_categoria. Jogue agora!!!";
										echo "<form method='post' action='?go=jogar'>
										<input type='hidden' value='$_id' name='id'>
										<input type='hidden' value='$_categoria' name='categoria'>
										<input type='submit' value='Jogar agora' id='btnjogaragora'>
										</form>";
										echo "<form method='post' action='?go=jogarnao'>
										<input type='hidden' value='$_id' name='id'>
										<input type='submit' value='Agora não' id='btnagoranao'>
										</form>";
										echo "</div><br><br>";
									}
								}else{
									if($_notificacao == 'Olha ae'){
										echo "<div class='cada3'>";
										echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
										echo "<b>       ".$_nickremetente."</b>";
										$_pontos = mysql_query("select * from ranking where email = '$_nickremetente' and categoria = '$_categoria'");
										$_peguei = @mysql_result($_pontos,0,'pontuacao');		
										echo " fez $_peguei pontos no TalkResponde na categoria $_categoria.";
										echo "</div><br><br>";
									}
								}
							}elseif($_tipo == 'pergunta'){
								if($_status == 'Não vista'){
									if($_notificacao == 'Olha ae'){
										echo "<div class='cada2'>";
										echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
										echo "<b>       ".$_nickremetente."</b>";	
										echo " enviou uma pergunta para o TalkResponde na categoria $_categoria, confere aí. Jogue agora!!!";
										echo "<form method='post' action='?go=jogar'>
										<input type='hidden' value='$_id' name='id'>
										<input type='hidden' value='$_categoria' name='categoria'>
										<input type='submit' value='Jogar agora' id='btnjogaragora'>
										</form>";
										echo "<form method='post' action='?go=jogarnao'>
										<input type='hidden' value='$_id' name='id'>
										<input type='submit' value='Agora não' id='btnagoranao'>
										</form>";
										echo "</div><br><br>";
									}
								}else{
									if($_notificacao == 'Olha ae'){
										echo "<div class='cada3'>";
										echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
										echo "<b>       ".$_nickremetente."</b>";
										$_pontos = mysql_query("select * from ranking where email = '$_nickremetente' and categoria = '$_categoria'");
										$_peguei = @mysql_result($_pontos,0,'pontuacao');		
										echo " enviou uma pergunta para o TalkResponde na categoria $_categoria, confere aí.";
										echo "</div><br><br>";
									}
								}
							}else if($_tipo == 'aceitacomsucesso'){
								if($_status == 'Não vista'){
									if($_notificacao == 'perguntaaceita'){
										echo "<div class='cada2'>";
										echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
										echo "<b>       ".$_nickremetente."</b>";	
										echo " aceitou sua pergunta para o TalkResponde na categoria $_categoria. Compartilhe com seus amigos!!!";
										echo "<form method='post' action='?go=comp'>
										<input type='hidden' value='$_id' name='id'>
										<input type='hidden' value='$_categoria' name='categoria'>
										<input type='submit' value='Compartilhar' id='btncomp'>
										</form>";
										echo "<form method='post' action='?go=jogarnao'>
										<input type='hidden' value='$_id' name='id'>
										<input type='submit' value='Agora não' id='btnagoranao'>
										</form>";
										echo "</div><br><br>";
									}
								}else{
									if($_notificacao == 'perguntaaceita'){
										echo "<div class='cada3'>";
										echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
										echo "<b>       ".$_nickremetente."</b>";	
										echo " aceitou sua pergunta para o TalkResponde na categoria $_categoria.";
										echo "</div><br><br>";
									}
								}						
							}elseif($_tipo == 'recusadacomsucesso'){
								if($_status == 'Não vista'){
									echo "<div class='cada2'>";
										echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
										echo "<b>       ".$_nickremetente."</b>";	
										echo " não aceitou sua pergunta para o TalkResponde na categoria $_categoria. Envie outra!!!";
										echo "<form method='post' action='?go=envieoutra'>
										<input type='hidden' value='$_id' name='id'>
										<input type='submit' value='Enviar' id='btncomp'>
										</form>";
										echo "<form method='post' action='?go=naoenvieoutra'>
										<input type='hidden' value='$_id' name='id'>
										<input type='submit' value='Agora não' id='btnagoranao'>
										</form>";
										echo "</div><br><br>";
								}else{
								echo "<div class='cada3'>";
								echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
								echo "<b>       ".$_nickremetente."</b>";	
								echo " não aceitou sua pergunta para o TalkResponde na categoria $_categoria.";
								echo "</div><br><br>";
								}
							}else{
								if($_status == 'Não vista'){
								echo "<div class='cada1'>";
								echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
								echo "<b>       ".$_nickremetente.": </b>";
								echo $_notificacao;
								echo "</div><br><br>";
							}else{
								echo "<div class='cada'>";
								echo "<img src='../fotodeperfil/$_imagem' witdh='25px' height='25px'></img>";
								echo "<b>       ".$_nickremetente.": </b>";
								echo "aa";
								echo "</div><br><br>";
							}
							}
		}
							
					?>
				</div></center></font>
				<div class='encontrar2'>
					<a href='busca.php'><font color='white' face='Arial'>ENCONTRE AMIGOS</a></font>
				</div>
				<div class='amigos5'>
					<a href='amigo.php'><font color='white' face='Arial'>MEUS AMIGOS</a></font>
				</div>
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
		unset ($_SESSION ['score']);
		unset ($_SESSION['nick']);
		unset ($_SESSION ['ranking']);
		mysql_query("update onlinenomomento set status = 'Não' where nick = '$_nick'");
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}elseif(@$_GET['go'] == 'jogar'){
		$_id = $_POST['id'];
		$_categoria = $_POST['categoria'];
		if($_categoria == 'Lógica'){
			mysql_query("update jogandonomomento set categoria = '$_categoria' where email = '$_email'");
			mysql_query("update notificacao set status = 'Visto' where id = $_id");
			unset($_SESSION ['veperguntas']);
			unset($_SESSION ['tipo']);
			unset($_SESSION ['score']);
			echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
		}else{
			mysql_query("update jogandonomomento set categoria = '$_categoria' where email = '$_email'");
			mysql_query("update notificacao set status = 'Visto' where id = $_id");
			unset($_SESSION ['veperguntas']);
			unset($_SESSION ['tipo']);
			unset($_SESSION ['score']);
			echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
		}
	}elseif(@$_GET['go'] == 'jogarnao'){
		$_id = $_POST['id'];
		mysql_query("update notificacao set status = 'Visto' where id = $_id");
		echo "<meta http-equiv='refresh' content='0, url=notificacao.php'>";
	}elseif(@$_GET['go'] == 'comp'){
		$_id = $_POST['id'];
		$_categoria = $_POST['categoria'];
		$_img = $_caminho;
		mysql_query("update notificacao set status = 'Visto' where id = $_id");
		$_verificaramigo = mysql_query("select * from amigos where nickdestinatario = '$_nick' && status = 'Sim' || nickremetente = '$_nick' && status = 'Sim'");
				$_contarverificaramigo = mysql_num_rows($_verificaramigo);
				if($_contarverificaramigo > 0){
					for($_i=0;$_i<$_contarverificaramigo;$_i++){
						$_resultado = mysql_fetch_array($_verificaramigo);
						$_nickremetente = $_resultado['nickremetente'];
						$_nickdestinatario = $_resultado['nickdestinatario'];
						if($_nick == $_nickremetente){
							mysql_query("insert into notificacao values (null,'$_nick','$_img','$_nickdestinatario','Olha ae','pergunta','$_categoria','Não vista')");
							echo "<meta http-equiv='refresh' content='0, url=enviesuapergunta.php'>";
						}elseif($_nick == $_nickdestinatario){
							mysql_query("insert into notificacao values (null,'$_nickdestinatario','$_img','$_nickremetente','Olha ae','pergunta','$_categoria','Não vista')");
							echo "<meta http-equiv='refresh' content='0, url=enviesuapergunta.php'>";
						}
					}
				}else{
					echo "<script type='text/javascript'>alert('Você não possui amigos')</script>";
					echo "<meta http-equiv='refresh' content='0, url=notificacao.php'>";
				}
		echo "<meta http-equiv='refresh' content='0, url=notificacao.php'>";
	}elseif(@$_GET['go'] == 'envieoutra'){
		$_id = $_POST['id'];
		mysql_query("update notificacao set status = 'Visto' where id = $_id");
		echo "<meta http-equiv='refresh' content='0, url=enviesuapergunta.php'>";
	}elseif(@$_GET['go'] == 'naoenvieoutra'){
		$_id = $_POST['id'];
		mysql_query("update notificacao set status = 'Visto' where id = $_id");
	}
?>