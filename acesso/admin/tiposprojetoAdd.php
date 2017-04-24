<?php session_start();
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
		setcookie("redirect","admin/tiposprojeto.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",5, time() + (86400 * 30), "/");
		header("Location:../");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Gerenciar tipos de projeto</title>
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
<div id="or"><a href="../../acesso">inicio</a><a href="tiposprojeto.php" >tipos de projeto</a><span>adicionar</span><a href="../../" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Criar novo tipo de projeto</h3>
	<?php
	if(isset($_COOKIE["adt"])){
		echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>Tipo de projeto adicionado. <span>x</span></div>";
		echo '<script type="text/javascript">$(".boaMsg").slideDown();</script>';
		setcookie("adt",null,time() - (8400 * 30), "/");
	}
	?>
	<article>
		<form method="post" action="tipos.php">
			<fieldset><legend>Adicionar tipo de projeto</legend>
				<label for="i_tipo">Sigla:</label><input type="text" name="tipo" id="i_tipo" maxlength="12" placeholder="Ex.: PIBIC-Jr" />
                <br><label for="i_descricao">Descricao:</label><input type="text" name="descricao" id="i_descricao" maxlength="90" placeholder="Ex.: Descricao da sigla do tipo" />
			</fieldset>
			<input type="submit" name="validaAdiciona" value="adicionar" />
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