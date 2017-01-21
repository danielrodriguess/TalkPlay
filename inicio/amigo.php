<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];
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
				<title>Seus amigos - Talkplay</title>
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
				<?php
					echo "<div class='exibirimagemamigo'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<br><br><br><div class='listaramigos'>
					<?php
						$_cacar = mysql_query("select * from amigos where nickremetente = '$_nick' && status = 'Sim' or nickdestinatario = '$_nick' && status = 'Sim'");
						$_contarcacar = mysql_num_rows($_cacar);
						echo "<center><div class='mostrandotodos' style='z-index:1; overflow: auto'>";
						if($_contarcacar > 0){
						for($_i=0;$_i<$_contarcacar;$_i++){
							$_resultado = mysql_fetch_array($_cacar);
							$_nickremetente = $_resultado['nickremetente'];
							$_nickdestinatario = $_resultado['nickdestinatario'];
							$_pemail = mysql_query("select * from nick where nick = '$_nickdestinatario'");
							$_contarpemail = mysql_num_rows($_pemail);
							$_emaildestino = @mysql_result($_pemail,0,'email');
							$_pemail1 = mysql_query("select * from nick where nick = '$_nickremetente'");
							$_contarpemail1 = mysql_num_rows($_pemail1);
							$_emaildestino1 = @mysql_result($_pemail1,0,'email');
							$_id = $_resultado['id'];
							if($_nickremetente == $_nick){
								$_destinatario = mysql_query("select * from nick where nick = '$_nickdestinatario'");
								$_emaildestinatario = @mysql_result($_destinatario,0,'email');
								$_pegardestinatario = mysql_query("select * from fotodeperfil where email = '$_emaildestinatario'");
								$_imgdestinatario = @mysql_result($_pegardestinatario,0,'imagem');
								echo "<center><div class='alinharamigo'><img src='../fotodeperfil/$_imgdestinatario' width='100px' height='100px'></img></div>";
								echo "<div class='alinharamigo1'><font face='Arial'>$_nickdestinatario</font></div>";
								echo "<form method='post' action='desfazer.php'>
									<input type='hidden' value='$_id' name='id'>
									<input type='hidden' value='$_nick' name='meunick'>
									<input type='hidden' value='$_nickdestinatario' name='destino'>
									<input type='hidden' value='$_caminho' name='imgre'>
									<input type='submit' value='Desfazer amizade' id='btndesfazer'>
									</form></center>
									<form method='post' action='blok.php'>
									<input type='hidden' value='$_id' name='id'>
									<input type='hidden' value='$_nick' name='meunick'>
									<input type='hidden' value='$_nickdestinatario' name='destino'>
									<input type='hidden' value='$_caminho' name='imgre'>
									<input type='submit' value='Bloquear' id='btnbloquear'>
									</form>
									<form method='post' action='?go=den'>
									<input type='hidden' value='$_nickdestinatario' name='nickdestino'>
									<input type='hidden' value='$_emaildestino' name='emaildestino'>
									<input type='submit' value='Denunciar' id='btndenunciar'>
									</form>
									<div class='barradeamigos'>
									</div><br><br><br><br><br><br><br><br>";
							}elseif($_nickdestinatario == $_nick){
								$_remetente = mysql_query("select * from nick where nick = '$_nickremetente'");
								$_emailremetente = @mysql_result($_remetente,0,'email');
								$_pegarremetente = mysql_query("select * from fotodeperfil where email = '$_emailremetente'");
								$_imgremetente = @mysql_result($_pegarremetente,0,'imagem');
								echo "<center><div class='alinharamigo'><img src='../fotodeperfil/$_imgremetente' width='100px' height='100px'></img></div>";
								echo "<div class='alinharamigo1'><font face='Arial'>$_nickremetente</font></div>";
									echo "<form method='post' action='desfazer.php'>
									<input type='hidden' value='$_id' name='id'>
									<input type='hidden' value='$_nick' name='meunick'>
									<input type='hidden' value='$_nickremetente' name='destino'>
									<input type='hidden' value='$_caminho' name='imgre'>
									<input type='submit' value='Desfazer amizade' id='btndesfazer'>
									</form></center>
									<form method='post' action='blok.php'>
									<input type='hidden' value='$_id' name='id'>
									<input type='hidden' value='$_nick' name='meunick'>
									<input type='hidden' value='$_nickremetente' name='destino'>
									<input type='hidden' value='$_caminho' name='imgre'>
									<input type='submit' value='Bloquear' id='btnbloquear'>
									</form>
									<form method='post' action='?go=den'>
									<input type='hidden' value='$_nickremetente' name='nickdestino'>
									<input type='hidden' value='$_emaildestino1' name='emaildestino'>
									<input type='submit' value='Denunciar' id='btndenunciar'>
									</form>
									<div class='barradeamigos'>
									</div><br><br><br><br><br><br><br><br>";
							}
						}
						}else{
							echo "<font face='Arial'>Você não possui amigos</font>";
						}
						echo "</div></center>";
					?>
				</div>
				<div class='encontrar2'>
					<a href='busca.php'><font color='white' face='Arial'>ENCONTRE AMIGOS</a></font>
				</div>
				<div class='amigos5'>
					<font color='white' face='Arial'>MEUS AMIGOS</font>
				</div>
				<div class='blokk'>
				<a href='?go=blok'><input type='button' value='Usuários bloqueados' id='btnblokk'></a>
				</div>
			</body>
		</html>
<?php
	}
	if(@$_GET['go'] == 'sair'){
		mysql_query("update jogandonomomento set categoria = 'Nada' where email = '$_email'");
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
	}else if(@$_GET['go'] == 'blok'){
		echo "<br><br><br><div class='listaramigos'>";
		$_cacar = mysql_query("select * from blok where nickquedeu = '$_nick'");
						$_contarcacar = mysql_num_rows($_cacar);
						echo "<center><div class='mostrandotodos1' style='z-index:1; overflow: auto'>";
						if($_contarcacar > 0){
						for($_i=0;$_i<$_contarcacar;$_i++){
							$_resultado = mysql_fetch_array($_cacar);
							$_nickremetente = $_resultado['nickquedeu'];
							$_nickdestinatario = $_resultado['nickquetomou'];
								$_destinatario = mysql_query("select * from nick where nick = '$_nickdestinatario'");
								$_emaildestinatario = @mysql_result($_destinatario,0,'email');
								$_pegardestinatario = mysql_query("select * from fotodeperfil where email = '$_emaildestinatario'");
								$_imgdestinatario = @mysql_result($_pegardestinatario,0,'imagem');
								echo "<center><div class='alinharamigo'><img src='../fotodeperfil/$_imgdestinatario' width='100px' height='100px'></img></div>";
								echo "<div class='alinharamigo1'><font face='Arial'>$_nickdestinatario</font></div>";
echo "
									<form method='post' action='desblok.php'>
									<input type='hidden' value='$_nickremetente' name='dei'>
									<input type='hidden' value='$_nickdestinatario' name='destino'>
									<input type='submit' value='Desbloquear' id='btnbloquear'>
									</form>
									<div class='barradeamigos'>
									</div><br><br><br><br><br><br><br><br>";
				
						}
						}else{
							echo "<font face='Arial'>Você não bloqueou ninguém</font>";
						}
						echo "</div></center>";
	}else if(@$_GET['go'] == 'den'){
		$_emaildestino1 = $_POST['emaildestino'];
		$_nickdestino1 = $_POST['nickdestino'];
		mysql_query("insert into denuncia values('$_email','$_emaildestino1','$_nickdestino1',null,null)");
		echo "<meta http-equiv='refresh' content='0, url=denunciar.php'>";
	}
?>