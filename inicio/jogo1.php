<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{		
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];		
		if(!isset($_SESSION ['tipo'])){
				//echo "<script type='text/javascript'>alert('Escolha uma categoria')</script>";
				echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
		}else{
		$_tipo = $_SESSION['tipo'];
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
				<div class='jogando'>
					<?php
						$_linhaa = mysql_query("select * from nick where email = '$_email'");
						$_nick = @mysql_result($_linhaa,0,'nick');
						$_SESSION['nick'] = $_nick;
						$_imagem = mysql_query("select * from fotodeperfil where email = '$_email'");
						$_caminho = @mysql_result($_imagem,0,'imagem');
					?>
				</div>
				<?php
					echo "<div class='nick1'>";
					echo "<font face='Arial'>".$_nick."</font>";
					echo "</div>";
				?>
				<?php
					echo "<div class='exibirimagemnojogo'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<a href='?go=cancelar'><center><input type='button' id='btnfecharjogo' value='Cancelar'></center></a>
				<?php  
					if($_tipo != 'Responder com tempo'){
					echo "<br><br><br><br><br><br><font face='Arial'><center>Você pode escolher uma pessoa para te ajudar a responder.<br> Caso queira ir sozinho clique no botão 'Ir sozinho' e diverta-se</center></font><br><br><br><br><br><br>";
					}else{
					echo "<br><br><br><br><br><br><font face='Arial'><center>Na categoria responder com tempo, não tem a opção de adicionar pessoas, clique em Iniciar </center></font><br><br><br><br><br><br>";
					}
				?>
				<center><div class='criargrupo'>
					<?php
					if($_tipo == 'Responder com tempo'){
						$_amigo = mysql_query("select * from amigos where nickremetente = '$_nick' && status = 'Sim' || nickdestinatario = '$_nick' && status = 'Sim'");
						$_contaramigo = mysql_num_rows($_amigo);
						if($_contaramigo > 0){
							for($_i=0;$_i<$_contaramigo;$_i++){
								$_resultado = mysql_fetch_array($_amigo);
								$_nickremetente = $_resultado['nickremetente'];
								$_nickdestinatario = $_resultado['nickdestinatario'];
								if($_nick == $_nickremetente){
								$_on = mysql_query("select * from onlinenomomento where nick = '$_nickdestinatario' && status = 'Sim'");
								$_contaron = mysql_num_rows($_on);
								}elseif($_nick == $_nickdestinatario){
									$_on = mysql_query("select * from onlinenomomento where nick = '$_nickremetente' && status = 'Sim'");
									$_contaron = mysql_num_rows($_on);
								}
								if($_nick == $_nickremetente){
									$_pegar = mysql_query("select * from nick where nick = '$_nickdestinatario'");
									$_emailre = @mysql_result($_pegar,0,'email');
								}elseif($_nick == $_nickdestinatario){
									$_pegar = mysql_query("select * from nick where nick = '$_nickremetente'");
									$_emailre = @mysql_result($_pegar,0,'email');
								}
								$_jog = mysql_query("select * from jogandonomomento where email = '$_emailre' && jogandonomomento != 'Sim'");
								$_contarjog = mysql_num_rows($_jog);
								if($_contaron > 0 && $_contarjog > 0){
								if($_nick == $_nickremetente){
									$_pegarimagem = mysql_query("select * from nick where nick = '$_nickdestinatario'");
									$_pegando = @mysql_result($_pegarimagem,0,'email');
									$_pegarimagem2 = mysql_query("select * from fotodeperfil where email = '$_pegando'");
									$_img = @mysql_result($_pegarimagem2,0,'imagem');
									echo "<div class='mexernaimg'><img src='../fotodeperfil/$_img' width='100px' height='100px'></img></div>";
									echo "<div class='mexernonick'><font face='Arial'>".$_nickdestinatario."</font></div>";
									echo "<form action='grupo.php' method='post'> 
											<input type='submit' id='btngrupo' value='Escolher'>	
										</form>
										<div class='barragrupo'></div>";
								}elseif($_nick == $_nickdestinatario){
									$_pegarimagem = mysql_query("select * from nick where nick = '$_nickremetente'");
									$_pegando = @mysql_result($_pegarimagem,0,'email');
									$_pegarimagem2 = mysql_query("select * from fotodeperfil where email = '$_pegando'");
									$_img = @mysql_result($_pegarimagem2,0,'imagem');
									echo "<div class='mexernaimg'><img src='../fotodeperfil/$_img' width='100px' height='100px'></img></div>";
									echo "<div class='mexernonick'><font face='Arial'>".$_nickremetente."</font></div>";
									echo "<form action='grupo.php' method='post'>
											<input type='submit' id='btngrupo' value='Escolher'>								
										</form>
										<div class='barragrupo'></div>";
									
								}
								}else{
									echo "<center><font face='Arial'>Você não possui nenhum amigo disponivel</font></center>";
								}
							}
						}else{
							echo "<center><font face='Arial'>Você não possui nenhum amigo</font></center>";
						}
						echo "<center>
									<a href='?go=aa'><input type='button' value='Ir sozinho' id='btnjogar'></a>
									</center>";
					}else{
						echo "<a href='?go=a'><input type='submit' id='btngrupo1' value='Iniciar'></a>";
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
		echo "<div class='certeza'><center><font face='Arial'>Tem certeza?</font></center></div>";
		echo "<a href='?go=nao'><center><input type='button' id='btnfecharjogo1' value='Não'></center></a>";
		echo "<a href='?go=sim'><center><input type='button' id='btnfecharjogo2' value='Sim'></center></a>";
	}elseif(@$_GET['go'] == 'nao'){
		echo "<meta http-equiv='refresh' content='0, url=jogo1.php'>";
	}elseif(@$_GET['go'] == 'sim'){
		unset($_SESSION['tipo']);
		mysql_query("update jogandonomomento set categoria = 'Nada' where email = '$_email'");
		mysql_query("update jogandonomomento set jogandonomomento = 'Não' where email = '$_email'");
		echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
	}elseif(@$_GET['go'] == 'a'){
		mysql_query("update jogandonomomento set jogandonomomento = 'Sim' where email = '$_email'");
		$_SESSION['veperguntas'] = 1;
		echo "<meta http-equiv='refresh' content='0, url=quiz.php'>";
	}elseif(@$_GET['go'] == 'aa'){
		$_SESSION['score'] = 0;
		mysql_query("update jogandonomomento set jogandonomomento = 'Sim' where email = '$_email'");
		$_SESSION['veperguntas'] = 1;
		echo "<meta http-equiv='refresh' content='0, url=quiz.php'>";
	}
?>