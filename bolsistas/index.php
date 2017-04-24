<?php
	session_start();
	if(!isset($_SESSION["login"])) header("Location:../");
	if($_SESSION["tipo"] != 1){
		setcookie("redirect","../bolsistas/", time() + (86400 * 30), "/");
		setcookie("redirectTipo",1, time() + (86400 * 30), "/");
		header("Location:../acesso");
	}
	if(!isset($_SESSION["projeto"])) header("Location:../acesso/selectproj.php");
	if(!isset($_SESSION["projetoAtivo"]) || !$_SESSION["projetoAtivo"]){
		header("Location:../acesso/coord/projeto.php");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Gerenciar bolsistas/colaboradores</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
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
			if(isset($_SESSION['login'])){
				if($_SESSION["tipo"] == 1 || $_SESSION["tipo"] == 5){
					echo "<li><a href='../relatorios'><img src='../_icones/icon_relat.png' alt='Relatorios'/> relatórios</a></li>";
				}
        ?>
				<li><a id="perfil" href='#'><img src="../_icones/icon_perfilMenu.png" alt="Você" > <?php echo $_SESSION["nome"]; ?></a>
                    <ul>
                        <li><a href="../acesso/perfil"><img src="../_icones/icon_perfil.png" alt="Ir ao perfil"> perfil</a></li>
                        <li><a href="../acesso/logout"><img src="../_icones/icon_sair.png" alt="Finalizar sessão"> sair</a></li>
                    </ul>
                </li>
        <?php
			}
		?>
	</ul>
</header>
<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><span>bolsistas</span><a href="../acesso" class="voltar">voltar</a></div>
<section id="conteudo">
	<article id="submenu">
		<ul>
			<li dest="attatv.php">Atribuição de atividades<br><img src="../_icones/icon_atribuiratividade.png" alt="atribuir atividades"/><span>enviar tarefa</span></li>
			<li dest="Anali_atvdd.php">Análise das atividades<br><img src="../_icones/icon_analisaratividade.png" alt="análise de atividades"/><span>andamento de atividades</span></li>
			<li dest="histo.php">Histórico Bolsistas<br><img src="../_icones/icon_historico.png" alt="historico de bolsistas"/><span>andamento de bolsistas</span></li>
			<li dest="gp.php">Integrantes<br><img src="../_icones/icon_integrantes.png" alt="gerenciar pessoas"/><span>gerenciar pessoas</span></li>
			<li dest="registros.php">Ver registros<br><img src="../_icones/icon_registroatividadesvisualizar.png" alt="gerenciar pessoas"/><span>registros de atividades</span></li>
		</ul>
	</article>	
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../_imagens/cnpq.jpg">	<img src="../_imagens/if.jpg">
</footer>
</div>
</body>
</html>