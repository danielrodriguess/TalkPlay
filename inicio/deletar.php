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
				<title>Haplay - Compare seu conhecimento</title>
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
				<div class='a'><center><img src='../imagens/teste.png' alt='Haplay' width='50px' height='50px'></img></center></div>		
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
				<center><font face='Arial'>Tem certeza que deseja excluir seu perfil?</font></center>
				<a href='?go=sim'><input type='button' value='Sim' id='btnsim'></a>
				<a href='?go=nao'><input type='button' value='Não' id='btnnao'></a>
			</body>
		</html>
<?php
	}
	if(@$_GET['go'] == 'sair'){
		unset ($_SESSION ['email']);
		unset ($_SESSION ['senha']);
		unset ($_SESSION ['tipodepergunta']);
		unset ($_SESSION ['veperguntas']);
		unset ($_SESSION ['tipo']);
		unset ($_SESSION ['score']);
		unset ($_SESSION['nick']);
		unset ($_SESSION ['ranking']);
		mysql_query("update onlinenomomento set status = 'Não' where nick = '$_nick'");
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}elseif(@$_GET['go'] == 'sim'){
		mysql_query("update fotodeperfil set imagem = 'padrao.jpg' where nick = '$_nick'");
		mysql_query("update nick set statususer = 'Não' where nick = '$_nick'");
		mysql_query("update notificacao set imagemdodestinatario = 'padrao.jpg' where nickremetente = '$_nick'");
		mysql_query("update ranking set imagem = 'padrao.jpg' where email = '$_nick'");
		mysql_query("update amigos set status = 'Não' where nickremetente = '$_nick'");
		mysql_query("update amigos set status = 'Não' where nickdestinatario = '$_nick'");
		unset ($_SESSION ['email']);
		unset ($_SESSION ['senha']);
		unset ($_SESSION['nick']);
		unset ($_SESSION ['tipodepergunta']);
		unset ($_SESSION ['ranking']);
		echo "<script type='text/javascript'>alert('Deletado com sucesso')</script>";
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}elseif(@$_GET['go'] == 'nao'){
		echo "<meta http-equiv='refresh' content='0, url=alterar.php'>";
	}
?>