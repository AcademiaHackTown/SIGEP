<?php	
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
		setcookie("redirect","coord/", time() + (86400 * 30), "/");
		setcookie("redirectTipo",1, time() + (86400 * 30), "/");
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])) header("Location:../selectproj.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../../_css/form.css">
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
<div id="or"><a href="../selectproj.php">selecionar projeto</a><span>inicio</span><a href="../selectproj.php" class="voltar">voltar</a></div>
<section id="conteudo">	
	<article id="submenu">
		<?php
		if(isset($_COOKIE["prInfoT"])){
		?>
		<div class="boaMsg"><img src="../../_icones/ok.png">Informações preenchidas. O projeto agora está ativo e voce pode gerenciá-lo nos  botões abaixo.<span>x</span></div>
		<script type="text/javascript">$(".boaMsg").slideDown(400);</script>
		<?php
		setcookie("prInfoT",null);
		}		
		?>
		<ul>
			<?php
			require_once("../../_includes/conexao.php");
			$sql = "SELECT PRCODINT FROM projeto WHERE PRCODINT = ".$_SESSION["projeto"]." AND PRSTAINT = 1";
			$query = $myssql->query($sql);
			if(mysqli_num_rows($query) > 0){
				$_SESSION["projetoAtivo"] = true;
			?>
			<li dest="../../bolsistas">Colaboradores<br><img src="../../_icones/icon_colaboradores.png" alt="colaboradores"/><span>supervisionar</span></li>
			<li dest="../../alunos">Alunos<br><img src="../../_icones/icon_alunos.png" alt="alunos"/><span>relatório de alunos</span></li>
			<li dest="registro.php">Registro de Atividades<br><img src="../../_icones/icon_registroAtividades.png" alt="registro de atividades"/><span>preencher</span></li>
			<li dest="altprojeto.php">Projeto<br><img src="../../_icones/icon_projeto.png" alt="alterar informações do projeto"/><span>alterar informações</span></li>
			<?php
			}else{
				$_SESSION["projetoAtivo"] = false;
			?>
			<li dest="projeto.php">Projeto<br><img src="../../_icones/icon_projetoPreenche.png" alt="alterar informações do projeto"/><span>preencher informações</span></li>
			<?php
			}
			?>
		</ul>
	</article>
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
</footer>
</div>
</body>
</html>