<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];
		unset($_SESSION ['score']);
			$_ve = mysql_query("select * from jogandonomomento where email = '$_email' && categoria != 'Nada'");
			$_contave = mysql_num_rows($_ve);
			if($_contave > 0){
				$_categoria = @mysql_result($_ve,0,'categoria');
				$_tipo = $_categoria;
				$_SESSION ['tipo'] = $_tipo;
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
				<title>Talkplay</title>
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
				<div class='sair'><a href='?go=sair'><font color='Black' face='Arial'>SAIR</a></font></div>
				<div class='logando'>
					<?php
						$_linhaa = mysql_query("select * from nick where email = '$_email'");
						$_nick = @mysql_result($_linhaa,0,'nick');
						$_SESSION['nick'] = $_nick;
						mysql_query("update onlinenomomento set status = 'Sim' where nick = '$_nick'");
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
						echo "<font face='Arial'><a href='mensagem.php'>Mensagens($_contarmensagem)</a></font>";
					?>
				</div>
				<div class='alterar'>
					<a href='alterar.php'><font color='Black' face='Arial'>ALTERAR DADOS</a></font>
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
				<div class='paginainicial1'>
					<font face='Arial'><a href='index.php'>PÁGINA INICIAL</a></font>
				</div>
				<div class='encontrar10'>
					<a href='busca.php'><font color='white' face='Arial'>ENCONTRE AMIGOS</a></font>
				</div>
				<div class='amigos10'>
					<a href='amigo.php'><font color='white' face='Arial'>MEUS AMIGOS</a></font>
				</div>
				<?php
					echo "<div class='exibirimagem10'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<center><div class='enfeites'>
				<center><font face='Arial'><b>Você escolheu </b>'<?php echo $_tipo; ?>'</font></center>
				<br><br><center><a href='jogo1.php'><img src='../imagens/pergunta.png' width='210px' height='350px'></img></a></center>
				</div></center>
				<div class='rankingplay'><font face='Arial'>Ranking de jogadores nessa categoria</font></div>
				<div class='listandopessoas'>
				<?php
					$_pegarranking = mysql_query("select * from ranking where categoria = '$_tipo' order by pontuacao desc limit 5");
					$_contarpegarranking = mysql_num_rows($_pegarranking);
					$_confirme = 0;
					if($_contarpegarranking > 0){
						for($_i=1;$_i<=$_contarpegarranking;$_i++){
							
							$_resultado = @mysql_fetch_array($_pegarranking);
						$_email1 = $_resultado['email'];
						$_imagem = $_resultado['imagem'];
						$_pontuacao = $_resultado['pontuacao'];
						echo "<center><div class='mostrarranking'><font face='Arial'>";
						echo "<div class='alinhaposicaoa'>$_i °</div>";	
						echo "<div class='alinharemail'><b>".$_email1."</div></b>";
						echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
						echo "<br><div class='alinharpontos'>";
						echo "<b>Pontuação: ".$_pontuacao."</b>";
						if($_email1 == $_nick){
							echo "<br><br><div class='suaposicao'><b>Sua posição</b></div>";
							$_confirme += 1;
						}else{
							$_pegarranking1 = mysql_query("select * from amigos where nickremetente = '$_nick' && nickdestinatario = '$_email1' && status = 'Não' || nickremetente = '$_nick' && nickdestinatario = '$_email1' &&  status = 'Sim' || nickremetente = '$_email1' && nickdestinatario = '$_nick' && status = 'Sim' || nickremetente = '$_email1' && nickdestinatario = '$_nick' && status = 'Não'");
							$_contarpegarranking1 = mysql_num_rows($_pegarranking1);
							if($_contarpegarranking1 == 0){
								echo "<form method='post' action='adicionarjogo.php'>
								<input type='hidden' value='$_nick' name='meunick'>
								<input type='hidden' value='$_caminho' name='fotominha'>
								<input type='hidden' value='$_email1' name='destiny'>
								<center><input type='submit' id='btnlogar8' value='Adicionar aos amigos'></center>
								</form>";				
							}else{
								$_pegarranking2 = mysql_query("select * from amigos where nickremetente = '$_nick' && nickdestinatario = '$_email1' && status = 'Não' || nickremetente = '$_email1' && nickdestinatario = '$_nick' && status = 'Não'");
								$_contarpegarranking2 = mysql_num_rows($_pegarranking2);
								if($_contarpegarranking2 > 0){
									echo "<br><br><div class='suaposicao'><b>Solicitação enviada</b></div>";
								}
							}
						}
						echo "<br></center></div></font></div></b>";
						}
						}else{
							echo "<br><br><div class='jogouainda'><font face='Arial'><b>Ninguém jogou ainda. Seja o primeiro!</b></font></div>";
					}
					if($_confirme == 1){
						
					}else{
							$_pegarranking = mysql_query("select * from ranking where categoria = '$_tipo' and email = '$_nick'");
						$_contarpegarranking = mysql_num_rows($_pegarranking);
						if($_contarpegarranking > 0){
						for($_i=0;$_i<$_contarpegarranking;$_i++){
							$_confirme = 0;
							$_resultado = @mysql_fetch_array($_pegarranking);
						$_email1 = $_resultado['email'];
						$_imagem = $_resultado['imagem'];
						$_pontuacao = $_resultado['pontuacao'];
						$_a = $_i+1;
						echo "<center><div class='mostrarranking'><font face='Arial'>";
						echo "<div class='alinhaposicaoa'>$_a °</div>";
						echo "<div class='alinharemail'><b>".$_email1."</div></b>";
						echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
						echo "<br><div class='alinharpontos'>";
						echo "<b>Pontuação: ".$_pontuacao."</b>";
					}
					}else{
						echo "<br><br><div class='jogouainda'><font face='Arial'><b>Jogue e entre no ranking</b></font></div>";
					}
					}
				?>
				</div>
				
			</body>
		</html>
<?php
	}else{
				echo "<script type='text/javascript'>alert('Selecione uma categoria primeiro')</script>";
				echo "<meta http-equiv='refresh' content='0, url=diversao.php'>";
			}
	}
	if(@$_GET['go'] == 'sair'){
		mysql_query("update jogandonomomento set categoria = 'Nada' where email = '$_email'");
		unset ($_SESSION ['email']);
		unset ($_SESSION ['senha']);
		unset ($_SESSION ['veperguntas']);
		unset ($_SESSION ['tipo']);
		unset ($_SESSION ['score']);
		unset ($_SESSION['nick']);
		unset ($_SESSION ['ranking']);
		mysql_query("update onlinenomomento set status = 'Não' where nick = '$_nick'");
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}
?>