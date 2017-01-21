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
				<title>Encontre seus amigos - Talkplay</title>
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
					echo "<div class='exibirimagem1'><img src='../fotodeperfil/$_caminho' width='25px' height='25px'></img></div>";
				?>
				<div class='encontrar3'>
					<font color='white' face='Arial'>ENCONTRE AMIGOS</font>
				</div>
				<div class='amigos6'>
					<a href='amigo.php'><font color='white' face='Arial'>MEUS AMIGOS</a></font>
				</div><br><br>
				<center><div class='buscando' style='z-index:1; overflow: auto'>
					<form action='?go=buscar' method='post'>
						<table>
							<tr>
								<td><input type='text' name='busca' id='txtbuscar' placeholder='Busque pelo apelido'></td>
								<td><input type='submit' value='Buscar' id='btnbuscar'></td>
							</tr>
						</table>
					</form></center>
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
	}elseif(@$_GET['go'] == 'buscar'){
		$_nome = $_POST['busca'];
		if(empty($_nome)){
				echo "<script type='text/javascript'>alert('Digite algo no campo')</script>";
				echo "<meta http-equiv='refresh' content='0, url=busca.php'>";
			}else{
		echo "<font face='Arial'><center><div class='mostraramigos' style='z-index:1; overflow: auto'>";
			$_linha1 = mysql_query("select * from nick where nick like '%$_nome%' and statususer != 'Não' and statusadmin != 'Não'");
			$_contador = @mysql_num_rows($_linha1);
			if($_contador > 0){
			for($_i=0;$_i<$_contador;$_i++){
				$_resultado = mysql_fetch_assoc($_linha1);
				$_nick1 = $_resultado['nick'];
				$_pegarblok = mysql_query("select * from blok");
				$_contarblok = mysql_num_rows($_pegarblok);
				if($_contarblok > 0){
					$_nickquedeu1 = @mysql_result($_pegarblok,0,'nickquedeu');
					$_nickquetomou1 = @mysql_result($_pegarblok,0,'nickquetomou');
				}
				if($_nick1 == $_nick){
					
				}else{
					if($_nick1 == 'Usuario'){
						
					}else{
					if($_contarblok > 0 && $_nickquedeu1 == $_nick1 || $_contarblok > 0 && $_nickquetomou1 == $_nick1){
						for($_a=0;$_a<$_contarblok;$_a++){
							$_result = mysql_fetch_array($_pegarblok);
						$_nickquetomou = $_result['nickquetomou'];
						$_nickquedeu = $_result['nickquedeu'];
						if($_nickquetomou == $_nick1 || $_nickquedeu == $_nick1){
						
					}
					}
					}else{
				$_email5 = $_resultado['email'];
				echo "<div id='mostrandonick'>".$_nick1."</div>";
				$_linha2 = mysql_query("select * from fotodeperfil where email = '$_email5'");
				$_imagem3 = @mysql_result($_linha2,0,'imagem');
				$_linhaa44 = mysql_query("select * from nick where email = '$_email'");
				$_nick11 = @mysql_result($_linhaa44,0,'nick');
				echo "<div class='imgperfil'><img src='../fotodeperfil/$_imagem3' width='50px' height='50px'></img></div>";
				echo "<div class='adiocionaraosamigos'></div>";
				$_imagem1 = mysql_query("select * from fotodeperfil where email = '$_email'");
				$_caminho1 = @mysql_result($_imagem1,0,'imagem');
				$_linhaa44 = mysql_query("select * from nick where email = '$_email'");
				$_nick10 = @mysql_result($_linhaa44,0,'nick');
				$_linha5 = mysql_query("select * from amigos where nickdestinatario = '$_nick1' && nickremetente = '$_nick' || nickremetente = '$_nick1' && nickdestinatario = '$_nick'");
				$_contador5 = @mysql_num_rows($_linha5);
				if($_contador5 > 0){
					$_status1 = @mysql_result($_linha5,0,'status');
					if($_status1 == 'Sim'){
						echo "<div class='add1'>
			Vocês já são amigos
				</div>";
				echo "<div class='barrinhabusca1'></div>";
				echo "<br><br>";
					}elseif($_status1 == 'Não aceita'){
					echo "<div class='add1'>
				Não aceitou sua solicitação
			</div>";
				echo "<div class='barrinhabusca1'></div>";
				echo "<br><br>";
					}else{
						echo "<div class='add1'>
				Solicitação já enviada
			</div>";
				echo "<div class='barrinhabusca1'></div>";
				echo "<br><br>";
					}
				}else{
				echo "<div class='add'><form method='post' action='adicionar.php'>
				<input type='hidden' name='nick' value='$_nick1'>
				<input type='hidden' name='nick1' value='$_caminho1'>
				<input type='hidden' name='nick2' value='$_nick10'>
				<input type='submit' class='btnenviar' value='Enviar solicitação'>
				</form></div>";
				echo "<div class='barrinhabusca'></div>";
				echo "<br><br>";
				}
					}
				}
				}
			}
			
			}else{
				echo "Não achamos resultados";
			}
			}
		echo "</div></center></font>";
	}
?>