<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{
		$_tipo = "Conhecimentos gerais";
		$_tipo1 = "Lógica";
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];
		mysql_query("update jogandonomomento set jogandonomomento = 'Não' where email = '$_email'");
		unset ($_SESSION ['ranking']);
		if(!isset($_SESSION['tipo'])){
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
				<title>Jogos - Talkplay</title>       
				<script type="text/javascript">
					function carrega(){
						$("#vermensagem").load("index.php #vermensagem");
					}
					function tempoatualiza(){
						setInterval("carrega()", 0500);
						setInterval("carrega1()", 0500);
						setInterval("carrega2()", 0500);
					}
					function carrega1(){
						$(".notificacao").load("index.php .notificacao");
						$(".imgnotificacao").load("index.php .imgnotificacao");
						//document.getElementById('.notificacao').index.php = location.reload();
					}
					function carrega2(){
						//$(".lazer").load("index.php .lazer");
						document.getElementById('.lazer').index.php = location.reload();
					}
				</script>
			</head>
			<body bgcolor='#DCDCDC' link="#E1E1E1" alink="#E1E1E1" vlink="#E1E1E1" onload="tempoatualiza();" onLoad="history.go(+1)">
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
				<?php
					echo "<div class='exibirimagem'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<div class='encontrar'>
					<a href='busca.php'><font color='white' face='Arial'>ENCONTRE AMIGOS</a></font>
				</div>
				<div class='amigos'>
					<a href='amigo.php'><font color='white' face='Arial'>MEUS AMIGOS</a></font>
				</div>
				<div class='lazer' style='z-index:1; overflow: auto'>
					<font face='Arial'><center>Meus amigos online</center></font>
					<?php
						$_online = mysql_query("select * from amigos where nickremetente = '$_nick' && status = 'Sim' || nickdestinatario = '$_nick' && status = 'Sim'");
						$_contaronline = mysql_num_rows($_online);
						if($_contaronline > 0){
							for($_o=0;$_o<$_contaronline;$_o++){
								$_result1 = mysql_fetch_array($_online);
								$_nickremetente = $_result1['nickremetente'];
								$_nickdestinatario = $_result1['nickdestinatario'];
								if($_nickremetente == $_nick){
									$_online1 = mysql_query("select * from amigos where nickremetente = '$_nick' && nickdestinatario = '$_nickdestinatario' && status = 'Sim'");
								}elseif($_nickdestinatario == $_nick){
									$_online1 = mysql_query("select * from amigos where nickdestinatario = '$_nick' && nickremetente = '$_nickremetente' && status = 'Sim'");
								}			
							$_momento = mysql_query("select * from onlinenomomento where nick = '$_nickdestinatario' && status = 'Sim' && nick != '$_nick' || nick = '$_nickremetente' && status = 'Sim' && nick != '$_nick'");
							$_contarmomento = mysql_num_rows($_momento);
									for($_i=0;$_i<$_contarmomento;$_i++){
										$_resultado = mysql_fetch_array($_momento);
										$_nickamigo = $_resultado['nick'];
										
											if($_nickamigo == $_nick){
											
											}else{										
											$_pegaremail = mysql_query("select * from nick where nick = '$_nickamigo'");
											$_ok = @mysql_result($_pegaremail,0,'email');
											$_pegarfoto = mysql_query("select * from fotodeperfil where email = '$_ok'");
											$_imgamigo = @mysql_result($_pegarfoto,0,'imagem');
											echo "<img src='../fotodeperfil/$_imgamigo' width='25px' height='25px'></img>";
										echo "<font face='Arial'> $_nickamigo</font>";
										echo "<form method='post' action='enviar.php'>
										<input type='hidden' value='$_nick' name='nickremetente'>
										<input type='hidden' value='$_nickamigo' name='nickdestinatario'>
											<input type='submit' value='Conversar' name='conv' id='btnconversar'>
										</form>";
										echo "<div class='barraonline'></div>";
										echo "<br>";
										}
									
									}
							
							}
						}else{
							echo "<font face='Arial'><center>Adicione pessoas e comunique-se</center></font>";
						}
					?>
				</div>
				<br>
				<div class='construindojogo'>
					<center><font face='Arial'>Área de jogos</font></center>
				</div>
				<br><br><br>
				<font face='Arial'>No momento temos apenas jogos na categoria 'Quiz', por favor escolha um tema abaixo e diverta-se com seus amigos</font>
				<br><br><br>
				<div class='tema1'><center><font face='Arial'>Teste seus conhecimentos</font></center></div>
				<li><a href='?go=categoria'><font color='Black' face='Arial'>Harry Potter</font></a></li>
				<br><br><br><br>
				<div class='tema2'><center><font face='Arial'>Lógica</font></center></div>
				<li><a href='?go=categoria1'><font color='Black' face='Arial'>Teste de raciocínio</font></a></li>
				<center><div class='apk'><font face='Arial'>Baixe no seu smartphone também e diverta-se</font></div></center>
				<center><div class='apk2'><a href='https://mega.nz/#!X853QSZR!D-POyQRocsvvvGadz_HAP6QHyPHWa5zyaGrLiuBPqb4' target="_blank"><img src='../imagens/download.png' width='210px' height='50px'></img></a></div></center>
				<br><br><br><br><br><br><br><center><div class='apk3'><font face='Arial' size='1'>*apenas para Android nas versões a partir da 4.4.2</font></div></center>
				<div class='apk4'>
					<a href='enviesuapergunta.php'><font face='Arial' color='black'>Envie sua pergunta para nós</font></a>
				</div>
			</body>
		</html>
<?php
	}else{
		echo "<meta http-equiv='refresh' content='0, url=jogo.php'>";
	}
	}
	if(@$_GET['go'] == 'sair'){
		mysql_query("update jogandonomomento set categoria = 'Nada' where email = '$_email'");
		unset ($_SESSION ['email']);
		unset ($_SESSION ['senha']);
		unset ($_SESSION ['veperguntas']);
		unset ($_SESSION ['score']);
		unset ($_SESSION['nick']);
		unset ($_SESSION ['ranking']);
		mysql_query("update onlinenomomento set status = 'Não' where nick = '$_nick'");
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else if(@$_GET['go'] == 'categoria'){
		mysql_query("update jogandonomomento set categoria = '$_tipo' where email = '$_email'");
		echo "<meta http-equiv='refresh' content='0, url=jogo.php'>";
	}else if(@$_GET['go'] == 'categoria1'){
		mysql_query("update jogandonomomento set categoria = '$_tipo1' where email = '$_email'");		
		echo "<meta http-equiv='refresh' content='0, url=jogo.php'>";
	}
?>