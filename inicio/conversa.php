<?php
	require_once "../config.php";
	session_start();
	if(!isset($_SESSION['email']) && !isset($_SESSION['senha'])){
		echo "<meta http-equiv='refresh' content='0, url=../index.php'>";
	}else{
		$_email = $_SESSION['email'];
		$_senha = $_SESSION['senha'];
		mysql_query("delete from denuncia where emailquedenunciou = '$_email' and descricao IS NULL and numero IS NULL");
		mysql_query("update jogandonomomento set jogandonomomento = 'Não' where email = '$_email'");
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
				<title>Suas conversas - Talkplay</title>       
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
				<?php
					echo "<div class='exibirimagem'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<div class='encontrar'>
					<a href='busca.php'><font color='white' face='Arial'>ENCONTRE AMIGOS</a></font>
				</div>
				<div class='amigos'>
					<a href='amigo.php'><font color='white' face='Arial'>MEUS AMIGOS</a></font>
				</div>
				<div class='mostrandotodas'>
				<font face='Arial'><center>Minhas conversas</center></font>
					<?php
						$_pegacoversa = mysql_query("select distinct nickdestinatario,nickremetente from mensagem where nickremetente != '$_nick' || nickdestinatario != '$_nick'");
					$_contando = mysql_num_rows($_pegacoversa);
					
					for($_i=0;$_i<$_contando;$_i++){
						$_resultado = mysql_fetch_array($_pegacoversa);
						$_remetente = $_resultado['nickdestinatario'];
						$_destino = $_resultado['nickremetente'];
						if($_destino == $_nick){
						$_amizade = mysql_query("select * from amigos where nickdestinatario = '$_destino' && nickremetente = '$_remetente' && status = 'Sim' || nickdestinatario = '$_remetente' && nickremetente = '$_destino' && status = 'Sim'");
						$_contaramizar = mysql_num_rows($_amizade);
						for($_a=0;$_a<$_contaramizar;$_a++){
						$_e = mysql_query("select * from nick where nick = '$_remetente'");
						$_er = @mysql_result($_e,0,'email');
						$_e1 = mysql_query("select * from fotodeperfil where email = '$_er'");
						$_er1 = @mysql_result($_e1,0,'imagem');						
						echo "<form method='post' action='?go=ve'>
								<div class='separarmensagem'>";
						echo "<img src='../fotodeperfil/$_er1' width='30px' height='30px'>";
						echo "<font face='Arial'>".$_remetente."</font>
						<input type='hidden' value='$_remetente' name='remetente'>
						<input type='submit' value='Ver conversa' id='btnconversar1'>";
						echo "</div></form><br><br>";
					}
					}else if($_remetente == $_nick){
						$_amizade = mysql_query("select * from amigos where nickdestinatario = '$_destino' && nickremetente = '$_remetente' && status = 'Sim' || nickdestinatario = '$_remetente' && nickremetente = '$_destino' && status = 'Sim'");
						$_contaramizar = mysql_num_rows($_amizade);
						for($_a=0;$_a<$_contaramizar;$_a++){
						$_e = mysql_query("select * from nick where nick = '$_destino'");
						$_er = @mysql_result($_e,0,'email');
						$_e1 = mysql_query("select * from fotodeperfil where email = '$_er'");
						$_er1 = @mysql_result($_e1,0,'imagem');						
						echo "<form method='post' action='?go=ve1'>
								<div class='separarmensagem'>";
						echo "<img src='../fotodeperfil/$_er1' width='30px' height='30px'>";
						echo "<font face='Arial'>".$_destino."</font>
						<input type='hidden' value='$_destino' name='destino'>
						<input type='submit' value='Ver conversa' id='btnconversar1'>";
						echo "</div></form><br><br>";
					}
					}
					}
					?>
				</div>
				<?php
				$_mensagem = mysql_query("select * from mensagem where nickremetente = '$_nick' && mensagem IS NULL && status IS NULL && datahora IS NULL");
	$_contarmensagem = mysql_num_rows($_mensagem);
		for($_i=0;$_i<$_contarmensagem;$_i++){
			mysql_query("delete from mensagem where nickremetente = '$_nick' && mensagem IS NULL && status IS NULL && datahora IS NULL");
			$_result = mysql_fetch_array($_mensagem);
			$_nickd = $_result['nickdestinatario'];
			$_email1 = mysql_query("select * from nick where nick = '$_nickd'");
			$_nickdd = @mysql_result($_email1,0,'email');
			$_img1 = mysql_query("select * from fotodeperfil where email = '$_nickdd'");
			$_img2 = @mysql_result($_img1,0,'imagem');
			echo "<center><font face='Arial'> <img src='../fotodeperfil/$_img2' width='50px' height='50px' class='imgdaconversa'></img><b><div class='mostrarnickc'>".$_nickd."</div></b></font>";
			echo "<div class='caixadeconversa'>";
			
				$_puxar = mysql_query("select * from mensagem where nickremetente = '$_nick' && nickdestinatario = '$_nickd' || nickremetente = '$_nickd' && nickdestinatario = '$_nick' order by datahora asc");
				$_contarpuxar = mysql_num_rows($_puxar);
				for($_i=0;$_i<$_contarpuxar;$_i++){
					$_hist = mysql_fetch_array($_puxar);
					$_nickremente = $_hist['nickremetente'];
					$_nickdestinatario = $_hist['nickdestinatario'];
					$_mensagem = $_hist['mensagem'];
					if($_nick != $_nickremente){
						echo 
						"<div class='remetente'><font face='Arial'><div class='nick20'><b>$_nickremente</b></div> $_mensagem</font></div>"
						;
					}else{
						echo 
						"<div class='destinatario'><font face='Arial'>$_mensagem</font></div>"
						;
					}
					
					echo "<br>";
				}
			
			echo "</div>";
			echo "<form method='post' action='?go=enviar'>
				<input type='hidden' value='$_nickd' name=n>
				<textarea rows='8' cols='95' name='mensagem' class='texto'></textarea>
				<input type='submit' value='Enviar mensagem' id='btnconversando'>
			</form></center>";
		}
	?>
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
	}elseif(@$_GET['go'] == 'enviar'){
		$_mensagem = $_POST['mensagem'];
		$_nicka = $_POST['n'];
		mysql_query("insert into mensagem values (null,'$_nick','$_nicka','$_mensagem','Não lida',NOW())");
		echo "<meta http-equiv='refresh' content='0, url=conversa.php'>";
	}elseif(@$_GET['go'] == 've'){
		$_remetente = $_POST['remetente'];
		$_mensagem = mysql_query("select * from mensagem where nickdestinatario = '$_remetente'");
	$_contarmensagem = mysql_num_rows($_mensagem);
		for($_i=0;$_i<$_contarmensagem;$_i++){
			mysql_query("delete from mensagem where nickremetente = '$_nick' && mensagem IS NULL && status IS NULL && datahora IS NULL");
			$_result = mysql_fetch_array($_mensagem);
			$_nickd = $_result['nickdestinatario'];
			$_email1 = mysql_query("select * from nick where nick = '$_nickd'");
			$_nickdd = @mysql_result($_email1,0,'email');
			$_img1 = mysql_query("select * from fotodeperfil where email = '$_nickdd'");
			$_img2 = @mysql_result($_img1,0,'imagem');
			echo "<center><font face='Arial'> <img src='../fotodeperfil/$_img2' width='50px' height='50px' class='imgdaconversa'></img><b><div class='mostrarnickc'>".$_nickd."</div></b></font>";
			echo "<div class='caixadeconversa'>";
			
				$_puxar = mysql_query("select * from mensagem where nickremetente = '$_nick' && nickdestinatario = '$_nickd' || nickremetente = '$_nickd' && nickdestinatario = '$_nick' order by datahora asc");
				$_contarpuxar = mysql_num_rows($_puxar);
				for($_i=0;$_i<$_contarpuxar;$_i++){
					$_hist = mysql_fetch_array($_puxar);
					$_nickremente = $_hist['nickremetente'];
					$_nickdestinatario = $_hist['nickdestinatario'];
					$_mensagem = $_hist['mensagem'];
					if($_nick != $_nickremente){
						echo 
						"<div class='remetente'><font face='Arial'><div class='nick20'><b>$_nickremente</b></div> $_mensagem</font></div>"
						;
					}else{
						echo 
						"<div class='destinatario'><font face='Arial'>$_mensagem</font></div>"
						;
					}
					
					echo "<br>";
				}
			
			echo "</div>";
			echo "<form method='post' action='?go=enviar'>
				<input type='hidden' value='$_nickd' name=n>
				<textarea rows='8' cols='95' name='mensagem' class='texto'></textarea>
				<input type='submit' value='Enviar mensagem' id='btnconversando'>
			</form></center>";
		}
	}elseif(@$_GET['go'] == 've1'){
		$_remetente = $_POST['destino'];
		$_mensagem = mysql_query("select * from mensagem where nickdestinatario = '$_remetente'");
	$_contarmensagem = mysql_num_rows($_mensagem);
		for($_i=0;$_i<$_contarmensagem;$_i++){
			$_result = mysql_fetch_array($_mensagem);
			$_nickd = $_result['nickremetente'];
			$_email1 = mysql_query("select * from nick where nick = '$_nickd'");
			$_nickdd = @mysql_result($_email1,0,'email');
			$_img1 = mysql_query("select * from fotodeperfil where email = '$_nickdd'");
			$_img2 = @mysql_result($_img1,0,'imagem');
			echo "<center><font face='Arial'> <img src='../fotodeperfil/$_img2' width='50px' height='50px' class='imgdaconversa'></img><b><div class='mostrarnickc'>".$_nickd."</div></b></font>";
			echo "<div class='caixadeconversa'>";
			
				$_puxar = mysql_query("select * from mensagem where nickremetente = '$_nick' && nickdestinatario = '$_nickd' || nickremetente = '$_nickd' && nickdestinatario = '$_nick' order by datahora asc");
				$_contarpuxar = mysql_num_rows($_puxar);
				for($_i=0;$_i<$_contarpuxar;$_i++){
					$_hist = mysql_fetch_array($_puxar);
					$_nickremente = $_hist['nickremetente'];
					$_nickdestinatario = $_hist['nickdestinatario'];
					$_mensagem = $_hist['mensagem'];
					if($_nick != $_nickremente){
						echo 
						"<div class='remetente'><font face='Arial'><div class='nick20'><b>$_nickremente</b></div> $_mensagem</font></div>"
						;
					}else{
						echo 
						"<div class='destinatario'><font face='Arial'>$_mensagem</font></div>"
						;
					}
					
					echo "<br>";
				}
			
			echo "</div>";
			echo "<form method='post' action='?go=enviar'>
				<input type='hidden' value='$_nickd' name=n>
				<textarea rows='8' cols='95' name='mensagem' class='texto'></textarea>
				<input type='submit' value='Enviar mensagem' id='btnconversando'>
			</form></center>";
		}
	}
			
?>