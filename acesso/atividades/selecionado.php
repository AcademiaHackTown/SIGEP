<?php
	session_start();
	if(!isset($_SESSION['login']) || !($_SESSION['tipo'] == 3 || $_SESSION["tipo"] == 4)){
		setcookie("redirect","atividades/selecionado.php");
		setcookie("redirectTipo",12);
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])){
		header("Location:../selectproj.php");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP</title>
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
<div id="or"><a href="../">inicio</a><a href="index.php">Atividades</a><a href="pendentes.php">Pendentes</a><span>Atividade X</span></div>
<section id="conteudo">
<section id="conteudo">
	<h3 class='titulo'>Atividade X </h3>
	<form id="atividades" method="post" action=""> <!-- Lembrando que vc, Jorge, deve alterar o action para mandar os dados para onde deseja. Ass.: Erika -->
				<center>
					<input type="text" name="atvdd" id="atvdd" value="titulo xxxxx"/>
					<input type="text" name="atvdd" id="atvdd" value="xxxxxxxxxxxxxxxxxxxxxxxxxx"/>
				</center><br><br><br>
			<a href="index.php"><button id="back"/>Voltar </a></button>
			<a href=""><button id="refa"/>Refazer </a></button> <!-- Na prototipação não apareceu como seria ao clicar em refazer. Ass.: Erika -->
			<input type="submit" name="visu" value="Visualizar" id="visua"/>
		</form>
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
</footer>
</div>
</body>
</html>