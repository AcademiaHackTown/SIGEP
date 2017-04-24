<?php
	session_start();
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
		setcookie("redirect","coord/registro.php", time() + (86400 * 30), "/");
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
	<link rel="stylesheet" type="text/css" href="../../_css/estilo.css">
	<link rel="stylesheet" type="text/css" href="../../_css/form.css">
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
<div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../coord">inicio</a><span>registro de atividades</span><a href="../bolsistas" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Registro de Atividades</h3>
	<?php
	if(isset($_COOKIE["rgatv"])){
		setcookie("rgatv",null);
	?>
	<div class="boaMsg"><img src="../../_icones/ok.png">Atividade registrada.<span>x</span></div>
	<script type="text/javascript">$(".boaMsg").slideDown();</script>
	<?php	
	}
	if(isset($_COOKIE["ergatv"])){
	?>
	<div class="errorMsg"><img src="../../_icones/opa.png"><?php echo $_COOKIE["ergatv"]; ?><span>x</span></div>
	<script type="text/javascript">$(".errorMsg").slideDown();</script>
	<?php
		setcookie("ergatv",null);
	}
	?>
	<article>
		<form method="post" action="reg_do.php">
			<fieldset><legend>Registro de atividades</legend>
				<label for="i_data">Data:</label><input type="date" name="data" id="i_data" required="required"/><br>
				<label for="i_cont">O que foi feito:</label><textarea required="required" cols="100" rows="20" name="cont" id="i_cont"></textarea>				
			</fieldset>
			<input type="submit" name="valida" value="enviar">
		</form>
	</article>	
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
</footer>
</div>
</body>
</html>