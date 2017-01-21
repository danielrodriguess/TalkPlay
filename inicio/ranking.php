<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];
		if(!isset($_SESSION ['ranking'])){
				echo "<meta http-equiv='refresh' content='0, url=index.php'>";
		}else{
		$_ranking = $_SESSION ['ranking'];
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
				<title>Ranking - Talkplay</title>
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
				<?php
					echo "<div class='exibirimagemnapergunta'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<div class='ranking5'><center><font face='Arial' size='5px'>Ranking</font></center></div><br><br><br>
				<center><font face='Arial' size='5px'>Categoria escolhida <?php echo "<b>".$_ranking."</b>"; ?></font></center>
				<?php
					$_mostrarranking = mysql_query("select * from ranking where categoria = '$_ranking' order by pontuacao desc limit 5");
					$_contarmostrarranking = @mysql_num_rows($_mostrarranking);
					for($_i=0;$_i<$_contarmostrarranking;$_i++){
						$_resultado = @mysql_fetch_array($_mostrarranking);
						$_email1 = $_resultado['email'];
						$_imagem = $_resultado['imagem'];
						$_pontuacao = $_resultado['pontuacao'];
						echo "<center><div class='mostrarranking'><font face='Arial'>";
						echo "<div class='alinharemail'><b>".$_email1."</div></b>";
						echo "<br><img src='../fotodeperfil/$_imagem' width='100px' height='100px' class='alinharimg'></img>";
						echo "<br><div class='alinharpontos'>";
						echo "<b>Pontuação: ".$_pontuacao;
						if($_email1 == $_nick){
							
						}else{
							echo "<a href='?go=desafiar'><center><input type='button' id='btnlogar8' value='Desafiar'></center></a>";					
							echo "<a href='?go=mensagem'><center><input type='button' id='btnlogar9' value='Enviar mensagem'></center></a>";
						}
						echo "<br></center></div></font></div></b>";
					}
				?>
				<div class='encontrar5'>
					<a href='busca.php'><font color='white' face='Arial'>ENCONTRE AMIGOS</a></font>
				</div>
				<div class='amigos8'>
					<a href='amigo.php'><font color='white' face='Arial'>MEUS AMIGOS</a></font>
				</div>
			</body>
		</html>
<?php
	}
	}
	if(@$_GET['go'] == 'sair'){
		unset ($_SESSION ['email']);
		unset ($_SESSION ['senha']);
		unset ($_SESSION['nick']);
		unset ($_SESSION ['tipodepergunta']);
		unset ($_SESSION ['ranking']);
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}
?>