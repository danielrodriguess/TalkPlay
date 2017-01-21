<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{		
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];		
		if(empty($_SESSION ['tipo'])){
				//echo "<script type='text/javascript'>alert('Escolha uma categoria')</script>";
				echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
		}else{
		$_tipo = $_SESSION ['tipo'];
		$_valor = $_SESSION['veperguntas'];
		mysql_query("update jogandonomomento set jogandonomomento = 'Sim' where email = '$_email'");
		$_c = mysql_query("select * from jogandonomomento where email = '$_email'");
		$_pegandostatus = @mysql_result($_c,0,'jogandonomomento');
		if($_pegandostatus == 'Sim'){		
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
				<title>Diversão - Talkplay</title>
			</head>
			<body bgcolor='#DCDCDC' link="#E1E1E1" alink="#E1E1E1" vlink="#E1E1E1">	
				<div class='jogando1'>
					<?php
						$_linhaa = mysql_query("select * from nick where email = '$_email'");
						$_nick = @mysql_result($_linhaa,0,'nick');
						$_SESSION['nick'] = $_nick;
						$_imagem = mysql_query("select * from fotodeperfil where email = '$_email'");
						$_caminho = @mysql_result($_imagem,0,'imagem');
					?>
				</div>
				<?php
					echo "<div class='nick50'>";
					echo "<font face='Arial'>".$_nick."</font>";
					echo "</div>";
				?>
				<?php
					echo "<div class='exibirimagemnojogo1'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<a href='?go=cancelar'><center><input type='button' id='btnfecharjogocancelar' value='Cancelar'></center></a>
				
				<center><div class='criargrupo1'>
					<?php
					if($_tipo == 'Conhecimentos gerais'){
						$_tipo1 = "conhecimentosgerais";
					}elseif($_tipo == 'Lógica'){
						$_tipo1 = "logica";
					}
						if($_valor == 1){
							
							$_olhar = mysql_query("select min(id) from $_tipo1 where categoria = '$_tipo' group by categoria");
						}else{
							$_olhar = mysql_query("select * from $_tipo1 where categoria = '$_tipo' and id = '$_valor' group by categoria");
						}
						$_contarolhar = mysql_num_rows($_olhar);
						if($_contarolhar > 0){
							if($_valor == 1){
								$_resultado = mysql_fetch_array($_olhar);
								$_pegarid = $_resultado[0];
								$_valor = $_pegarid;
								$_SESSION['veperguntas'] = $_valor;
							}else{
								$_resultado = mysql_fetch_array($_olhar);
								$_pegarid = $_resultado['id'];
								$_valor = $_pegarid;
								$_SESSION['veperguntas'] = $_valor;
							}
							if($_valor == 1){
								echo "<div class='alinharscore'><font face='Arial'><b>Pontuação: </b>0</font></div>";
							}else{
								$_score = $_SESSION['score'];
								echo "<div class='alinharscore'><font face='Arial'><b>Pontuação: </b>".$_score."</font></div>";
							}
							$_pergunta1 = mysql_query("select * from $_tipo1 where categoria = '$_tipo' and id = '$_pegarid'");
							$_pergunta = @mysql_result($_pergunta1,0,'pergunta');
							$_op1 = @mysql_result($_pergunta1,0,'alternativa1');
							$_op2 = @mysql_result($_pergunta1,0,'alternativa2');
							$_op3 = @mysql_result($_pergunta1,0,'alternativa3');
							$_op4 = @mysql_result($_pergunta1,0,'alternativa4');
							$_altercerta = @mysql_result($_pergunta1,0,'alternativacerta');
							echo "<font face='Arial'>".$_pergunta."<br><br><br>";
							echo "<div class='alinharpergunta'><center><form method='post' action='verificarresposta.php'> 
							<table class='alinharpergunta1'>
							<tr>
							<td><input name='opcao' type='radio' value='$_op1'><label for='op1'>$_op1</label><br></td>
							</tr>
							<tr>
							<td><input name='opcao' type='radio' value='$_op2'><label for='op1'>$_op2</label><br></td>
							</tr>
							<tr>
							<td><input name='opcao' type='radio' value='$_op3'><label for='op1'>$_op3</label><br></td>
							</tr>
							<tr>
							<td><input name='opcao' type='radio' value='$_op4'><label for='op1'>$_op4</label><br></td>
							</tr>
							</table>
							<input type='hidden' value='$_altercerta' name='certo'>;
							<input type='submit' value='Responder' id='btnresponder1'>
							</form></center></div><font>";
						}else{
							if($_valor == 1){
								echo "<font face='Arial'>Não temos perguntas nessa categoria</font>";
							}else{
								echo "<font face='Arial'>Respondeu todas as perguntas. Parabéns!</font>";
								$_ver = mysql_query("select * from ranking where email = '$_nick' and categoria = '$_tipo'");
								$_contarver = mysql_num_rows($_ver);
								if($_contarver > 0){
									$_score = $_SESSION['score'];
									mysql_query("update ranking set pontuacao = '$_score' where email = '$_nick' and categoria = '$_tipo'");
									echo "<br><b>Sua nova pontuação: $_score</b>";
									echo "<br><b>Sua nova posição:</b>";
									$_pegarranking = mysql_query("select * from ranking where categoria = '$_tipo' and email = '$_nick'");
									$_contarpegarranking = mysql_num_rows($_pegarranking);
									if($_contarpegarranking > 0){
										for($_i=1;$_i<=$_contarpegarranking;$_i++){
										$_resultado = @mysql_fetch_array($_pegarranking);
										$_email1 = $_resultado['email'];
										$_imagem = $_resultado['imagem'];
										$_pontuacao = $_resultado['pontuacao'];
										$_valormax = mysql_query("select max(pontuacao) from ranking where categoria = '$_tipo'");
										$_contarvalormax = mysql_num_rows($_valormax);
										if($_contarvalormax > 0){
										$_resultado2 = mysql_fetch_array($_valormax);
										$_pegaridd = $_resultado2[0];
										if($_pegaridd <= $_pontuacao){
											echo "<center><div class='mostrarrankin2'><font face='Arial'>";
											echo "<div class='alinhaposicaoa'>$_i °</div>";
											echo "<div class='alinharemail'><b>".$_email1."</div></b>";
											echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
											echo "<br><div class='alinharpontos'>";
											echo "<b>Pontuação: ".$_pontuacao."</b>";
											echo "<a href='diversao.php'><input type='button' value='Jogar outros' id='btnha'></a>";
											echo "<form method='post' action='compartilhar.php'>
											<input type='hidden' value='$_nick' name='meunick'>
											<input type='hidden' value='$_caminho' name='minhaimagem'>
											<input type='hidden' value='$_tipo' name='pergunta'>
											<input type='submit' value='Compartilhar' id='btnha1'>
											</form>";
											echo "<div class='ajustandofot'><a href='enviesuapergunta.php'><font face='Arial' color='black'>Envie perguntas. Clique aqui</font></a></div>";
										}else{
											$_pegarf = mysql_query ("select count(pontuacao) as total_registrs from ranking where pontuacao > '$_pontuacao'");
											$_contarpegarf = mysql_num_rows($_pegarf);
											$_w1 = mysql_fetch_array($_pegarf); 
											$_total1 = $_w1['total_registrs'];
											$_aa = $_total1;
											echo "<center><div class='mostrarrankin2'><font face='Arial'>";
											echo "<div class='alinhaposicaoa'>$_aa °</div>";
											echo "<div class='alinharemail'><b>".$_email1."</div></b>";
											echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
											echo "<br><div class='alinharpontos'>";
											echo "<b>Pontuação: ".$_pontuacao."</b>";
											echo "<a href='diversao.php'><input type='button' value='Jogar outros' id='btnha'></a>";
											echo "<form method='post' action='compartilhar.php'>
											<input type='hidden' value='$_nick' name='meunick'>
											<input type='hidden' value='$_caminho' name='minhaimagem'>
											<input type='hidden' value='$_tipo' name='pergunta'>
											<input type='submit' value='Compartilhar' id='btnha1'>
											</form>";
											echo "<div class='ajustandofot'><a href='enviesuapergunta.php'><font face='Arial' color='black'>Envie perguntas. Clique aqui</font></a></div>";
										}
										}else{
											echo "<center><div class='mostrarrankin2'><font face='Arial'>";
											echo "<div class='alinhaposicaoa'>$_i°</div>";
											echo "<div class='alinharemail'><b>".$_email1."</div></b>";
											echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
											echo "<br><div class='alinharpontos'>";
											echo "<b>Pontuação: ".$_pontuacao."</b>";
											echo "<a href='diversao.php'><input type='button' value='Jogar outros' id='btnha'></a>";
											echo "<form method='post' action='compartilhar.php'>
											<input type='hidden' value='$_nick' name='meunick'>
											<input type='hidden' value='$_caminho' name='minhaimagem'>
											<input type='hidden' value='$_tipo' name='pergunta'>
											<input type='submit' value='Compartilhar' id='btnha1'>
											</form>";
											echo "<div class='ajustandofot'><a href='enviesuapergunta.php'><font face='Arial' color='black'>Envie perguntas. Clique aqui</font></a></div>";
										}
										}
									}
								}else{
									$_score = $_SESSION['score'];
									mysql_query("insert into ranking values ('$_nick','$_caminho','$_tipo','$_score')");
									echo "<br><b>Seus pontos: $_score</b>";
									echo "<br><b>Sua posição:</b>";
									$_pegarranking = mysql_query("select * from ranking where categoria = '$_tipo' and email = '$_nick'");
									$_contarpegarranking = mysql_num_rows($_pegarranking);
									if($_contarpegarranking > 0){
										for($_i=1;$_i<=$_contarpegarranking;$_i++){
											$_resultado = @mysql_fetch_array($_pegarranking);
										$_email1 = $_resultado['email'];
										$_imagem = $_resultado['imagem'];
										$_pontuacao = $_resultado['pontuacao'];
										$_valormax = mysql_query("select max(pontuacao) from ranking where categoria = '$_tipo'");
										$_contarvalormax = mysql_num_rows($_valormax);
										if($_contarvalormax > 0){
										$_resultado2 = mysql_fetch_array($_valormax);
										$_pegaridd = $_resultado2[0];
										if($_pegaridd <= $_pontuacao){
											$_score = $_SESSION['score'];
											echo "<center><div class='mostrarrankin2'><font face='Arial'>";
											echo "<div class='alinhaposicaoa'>$_i °</div>";
											echo "<div class='alinharemail'><b>".$_email1."</div></b>";
											echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
											echo "<br><div class='alinharpontos'>";
											echo "<b>Pontuação: ".$_pontuacao."</b>";
											echo "<a href='diversao.php'><input type='button' value='Jogar outros' id='btnha'></a>";
											echo "<form method='post' action='compartilhar.php'>
											<input type='hidden' value='$_nick' name='meunick'>
											<input type='hidden' value='$_caminho' name='minhaimagem'>
											<input type='hidden' value='$_tipo' name='pergunta'>
											<input type='submit' value='Compartilhar' id='btnha1'>
											</form>";
											echo "<div class='ajustandofot'><a href='enviesuapergunta.php'><font face='Arial' color='black'>Envie perguntas. Clique aqui</font></a></div>";
										}else{
											$_score = $_SESSION['score'];
											$_pegarposicao = mysql_query("select count(*) from ranking where pontuacao < (select pontuacao from ranking where pontuacao = '$_pontuacao')");
											$_contarpegarposicao = mysql_num_rows($_pegarposicao);
											$_aa = $_contarpegarposicao + 1;
											echo "<center><div class='mostrarrankin2'><font face='Arial'>";
											echo "<div class='alinhaposicaoa'>$_aa °</div>";
											echo "<div class='alinharemail'><b>".$_email1."</div></b>";
											echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
											echo "<br><div class='alinharpontos'>";
											echo "<b>Pontuação: ".$_pontuacao."</b>";
											echo "<a href='diversao.php'><input type='button' value='Jogar outros' id='btnha'></a>";
											echo "<form method='post' action='compartilhar.php'>
											<input type='hidden' value='$_nick' name='meunick'>
											<input type='hidden' value='$_caminho' name='minhaimagem'>
											<input type='hidden' value='$_tipo' name='pergunta'>
											<input type='submit' value='Compartilhar' id='btnha1'>
											</form>";
											echo "<div class='ajustandofot'><a href='enviesuapergunta.php'><font face='Arial' color='black'>Envie perguntas. Clique aqui</font></a></div>";
										}
										}else{
											$_score = $_SESSION['score'];
											echo "<center><div class='mostrarrankin2'><font face='Arial'>";
											echo "<div class='alinhaposicaoa'>$_i°</div>";
											echo "<div class='alinharemail'><b>".$_email1."</div></b>";
											echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
											echo "<br><div class='alinharpontos'>";
											echo "<b>Pontuação: ".$_pontuacao."</b>";
											echo "<a href='diversao.php'><input type='button' value='Jogar outros' id='btnha'></a>";
											echo "<form method='post' action='compartilhar.php'>
											<input type='hidden' value='$_nick' name='meunick'>
											<input type='hidden' value='$_caminho' name='minhaimagem'>
											<input type='hidden' value='$_tipo' name='pergunta'>
											<input type='submit' value='Compartilhar' id='btnha1'>
											</form>";
											echo "<div class='ajustandofot'><a href='enviesuapergunta.php'><font face='Arial' color='black'>Envie perguntas. Clique aqui</font></a></div>";
										}
										}
									}
						}
							}
						}
					?>
				</div></center>
			</body>
		</html>
<?php
	}
	else{
		echo "<meta http-equiv='refresh' content='0, url=index.php'>";
	}
	}
	}if(@$_GET['go'] == 'cancelar'){
		echo "<div class='certeza1'><center><font face='Arial'>Tem certeza?</font></center></div>";
		echo "<a href='?go=nao'><center><input type='button' id='btnfecharjogonao' value='Não'></center></a>";
		echo "<a href='?go=sim'><center><input type='button' id='btnfecharjogosim' value='Sim'></center></a>";
	}elseif(@$_GET['go'] == 'nao'){
		echo "<meta http-equiv='refresh' content='0, url=quiz.php'>";
	}elseif(@$_GET['go'] == 'sim'){
		unset($_SESSION['tipo']);
		mysql_query("update jogandonomomento set categoria = 'Nada' where email = '$_email'");
		mysql_query("update jogandonomomento set jogandonomomento = 'Não' where email = '$_email'");
		echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
	}
?>