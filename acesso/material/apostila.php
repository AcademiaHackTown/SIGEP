<?php
	session_start();
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 6){
		setcookie("redirect","material/apostila.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",6, time() + (86400 * 30), "/");
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])) header("Location:../selectproj.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Apostila</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../../_css/estilo.css">
	<script type="text/javascript" src="../../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../../_javascript/funcoes.js"></script>
</head>
<body>
<div id="bck"></div>
<div id="interface">
<div id="top_back"><img src="../../_imagens/logo_sigep.fw.png" alt="SIGEP">
<span>Sistema de Gerenciamento de Projeto</span></div>
<header>
	<span id="infoProjeto">
		Logado como <?php echo $_SESSION["nome"] ?>. <span class="cor_verde"><?php echo $_SESSION["nomeTipo"] ?></span> no projeto<br>
		<span class="cor_verde"><?php echo $_SESSION["nomeProjeto"] ?></span>
	</span>	
	<ul>
		<li><a href="../../"><img src="../../_icones/icon_home.png" alt="Inicio"> inicio</a></li>
		<li><a href="../../sobre"><img src="../../_icones/icon_sobre.png" alt="Sobre"> sobre</a></li>
		<li><a href="../../duvidas"><img src="../../_icones/icon_duvidas.png" alt="Duvidas"> duvidas</a></li>
		<li><a href="../../contato"><img src="../../_icones/icon_contato.png" alt="Contato"> contato</a></li>
		<?php			
			if(isset($_SESSION['login'])){
				if($_SESSION["tipo"] == 1 || $_SESSION["tipo"] == 5){
					echo "<li><a href='../../relatorios'><img src='../../_icones/icon_relat.png' alt='Relatorios'/> relatórios</a></li>";
				}
        ?>
				<li><a id="perfil" href='#'><img src="../../_icones/icon_perfilMenu.png" alt="Você" > <?php echo $_SESSION["nome"]; ?></a>
                    <ul>
                        <li><a href="../../acesso/perfil"><img src="../../_icones/icon_perfil.png" alt="Ir ao perfil"> perfil</a></li>
                        <li><a href="../../acesso/logout"><img src="../../_icones/icon_sair.png" alt="Finalizar sessão"> sair</a></li>
                    </ul>
                </li>
        <?php
			}
		?>
	</ul>
</header>
<div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../">inicio</a><a href="../material">material</a><span>apostila</span><a href="../material" class="voltar">voltar</a></div>
<section id="conteudo">
	<h1 class="titulo">Apostila do treinamento/curso</h1>
	<article id="lista_th">
		<p>A apostila contém todos os assuntos do treinamento/curso em questão. Clique sobre para baixar.</p>
		<?php
		require_once("../../_includes/conexao.php");
		$sql = "SELECT ARARQCHA FROM arquivos WHERE ARTPINT = 0 AND ARPRFINT = ".$_SESSION["projeto"]."";
		$q = $myssql->query($sql);

		if(mysqli_num_rows($q) > 0){
		?>
		<ul>
			<?php
			while($x = $q->fetch_object()){
			?>
			<a href="../../_arquivos/<?php echo $x->ARARQCHA; ?>" target="_blank"><li>&#10154; Apostila do treinamento/curso</li></a>
			<?php
			}
			?>
		</ul>
		<?php
		}else{
			echo "<p>Nenhuma apostila disponivel.</p>";
		}
		?>
	</article>	
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
</footer>
</div>
</body>
</html>