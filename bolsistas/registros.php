<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
	setcookie("redirect","../bolsistas/registros.php", time() + (86400 * 30), "/");
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
	<title>SIGEP</title>
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
	<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><span>registros de atividades</span><a href="Anali_atvdd.php" class="voltar">voltar</a></div>
	<section id="conteudo">
		<h3 class="titulo">Registros de bolsistas - selecione um</h3>
		<article id="lista_th">		
		<?php
		require_once("../_includes/conexao.php");
		$getPs = "SELECT PPPSFINT FROM pessoa_projeto WHERE PPPRFINT = ".$_SESSION["projeto"]."";
		$query = $myssql->query($getPs);
		if(mysqli_num_rows($query) > 0){
			echo "<ul>";
			while($rGp = $query->fetch_object()){
				$getNome = "SELECT PSNOMCHA FROM pessoa WHERE PSCODINT = ".$rGp->PPPSFINT."";
				$quer = $myssql->query($getNome);
				$nome = $quer->fetch_object();
				$str = "rg.php?id=$rGp->PPPSFINT";
				?>
				<li onclick="urlAbre('<?php echo $str; ?>')">&#10149; <?php echo $nome->PSNOMCHA; ?></li>
			<?php
			}
		}else{
		?>
		<div class='errorMsg'><img src='_icones/opa.png'/>Nenhum integrante cadastrado no projeto!<span>x</span></div>;
		<script type="text/javascript">$(".errorMsg").slideDown();</script>;
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