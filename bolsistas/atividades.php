<?php
	session_start();
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
		setcookie("redirect","../bolsistas/atividades.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",1, time() + (86400 * 30), "/");
		header("Location:../acesso");
	}
	if(!isset($_SESSION["projeto"])) header("Location:../acesso/selectproj.php");
	if(!isset($_SESSION["projetoAtivo"]) || !$_SESSION["projetoAtivo"]){
		header("Location:../acesso/coord/projeto.php");
	}
?>
<html lang="pt-br">
<head>
	<title>SIGEP - Atividades para Análise</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
	<link rel="stylesheet" type="text/css" href="../_css/form.css">
	<script type="text/javascript" src="../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../_javascript/funcoes.js"></script>
</head>
<body>
<div id="bck"></div>
<div id="interface">
	<div id="top_back"><img src="../_imagens/logo_sigep.fw.png" alt="SIGEP">
<span>Sistema de Gerenciamento de Projeto</span></div>
	<header>
	<span id="infoProjeto">
		Logado como <?php echo $_SESSION["nome"] ?>. <span class="cor_verde"><?php echo $_SESSION["nomeTipo"] ?></span> no projeto<br>
		<span class="cor_verde"><?php echo $_SESSION["nomeProjeto"] ?></span>
	</span>
		<ul>
			<li><a href="../"><img src="../_icones/icon_home.png" alt="Inicio"> inicio</a></li>
			<li><a href="../sobre"><img src="../_icones/icon_sobre.png" alt="Sobre"> sobre</a></li>
			<li><a href="../duvidas"><img src="../_icones/icon_duvidas.png" alt="Duvidas"> duvidas</a></li>
			<li><a href="../contato"><img src="../_icones/icon_contato.png" alt="Contato"> contato</a></li>
			<?php
				if(isset($_SESSION["login"])){
					echo "<li><a href='../relatorios'><img src='../_icones/icon_relat.png' alt='Relatorios'/> relatorios</a></li>";
					echo "<li><a href='../acesso/logout'><img src='../_icones/icon_sair.png' alt='Sair'/> sair</a></li>";
				}
			?>
		</ul>
	</header>
	<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><a href="../bolsistas/Anali_atvdd.php">análise</a><span>tarefas</span><a href="Anali_atvdd.php" class="voltar">voltar</a></div>
	<section id="conteudo">
		<h3 class='titulo'>Atividades para análise</h3>
		<article id="lista_th">
			<?php
			require_once("../_includes/conexao.php");
			$sql = "SELECT trtitvar, trdtfcha, trcodint FROM tarefas WHERE trstaint = 2 AND trprfint = ".$_SESSION["projeto"]." ORDER BY trcodint DESC";
			$quer = $myssql->query($sql);
			$x = mysqli_num_rows($quer);
			if($x > 0){ ?>
				<ul id="i_atividade">
					<?php
					while ($res = $quer->fetch_object()) {
						?>
						<li onclick="urlAbre('<?php echo 'visualizar.php?src=atividades&id='.$res->trcodint.'';
						?>')">
							<?php
								echo "&#10154;".$res->trtitvar." - até ".$res->trdtfcha."";
							?>
						</li>
						<?php
					}
					$quer->free();
					?>
				</ul>
				<?php
			}else{
				?>
				<div class="errorMsg"><img src="../_icones/opa.png">Nenhuma tarefa recebida para avaliar.<span>x</span></div>
				<script type="text/javascript">$(".errorMsg").fadeIn(400);</script>
				<?php
			}
			?>
			</article>			
			<div id="top" title="Ir para o topo">&#9650;</div>
	</section>
	<footer>
		<img src="../_imagens/cnpq.jpg">	<img src="../_imagens/if.jpg">
	</footer>
</div>
</body>
</html>