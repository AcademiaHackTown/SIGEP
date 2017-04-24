<?php
	session_start();	
	if(!isset($_SESSION['login']) || !($_SESSION['tipo'] == 3 || $_SESSION["tipo"] == 4)){
		setcookie("redirect","arquivos", time() + (86400 * 30), "/");
		setcookie("redirectTipo",12, time() + (86400 * 30), "/");
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])){
		header("Location:../selectproj.php");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Upload de arquivos (bolsista > aluno)</title>
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
<div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../../acesso">inicio</a><span>upload de arquivos</span><a href="../../acesso" class="voltar">voltar</a></div>
<section id="conteudo">
	<h1 class="titulo">Área do Bolsista - Upload de Arquivo</h1>
	<?php
	if(isset($_COOKIE["enviouarquivo"])){
		echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>Arquivo enviado com sucesso. <span>x</span></div>";
		echo '<script type="text/javascript">$(".boaMsg").slideDown();</script>';
		setcookie("enviouarquivo",null);
	}
	if(isset($_COOKIE["nenviouarquivo"])){
		echo "<div class='errorMsg'><img src='../../_icones/opa.png'/>".$_COOKIE["nenviouarquivo"]."<span>x</span></div>";
		echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';
		setcookie("nenviouarquivo",null);
	}
	?>
	<article>
	<p>Obs.: A apostila do curso é única. Portanto, um upload de apostila irá substituir a apostila anterior.</p>
		<form method="post" enctype="multipart/form-data" action="do.php">			
			<fieldset><legend>Upload de Arquivo</legend>
				<label for="i_tipo">Tipo de arquivo:</label><select name="tipo" id="i_tipo">
					<option value="0">Apostila do Curso</option>
					<option value="1">Atividade</option>
					<option value="2">Slide</option>
					<option value="3">Outro</option>
				</select>
				<br><input required type="file" name="arquivo" id="i_arquivo" />
			</fieldset>
			<input type="submit" name="valida" value="enviar" />
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