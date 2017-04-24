<?php
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
        setcookie("redirect","admin/desproj.php", time() + (86400 * 30), "/");
        setcookie("redirectTipo",5, time() + (86400 * 30), "/");
		header("Location:../");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Desativar projeto</title>
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
<div id="or"><a href="../admin">inicio</a><a href="projetos.php">gerenciar projetos</a><span>desativar projeto</span><a href="../admin" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Desativar projeto</h3>
	<article>
		<?php
		if(isset($_COOKIE["desOK"])){
			echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>Projeto desativado com sucesso.<span>x</span></div>";
			echo '<script type="text/javascript">$(".boaMsg").slideDown();</script>';
			setcookie("desOK",null);
		}
		?>
		<form id="desativar_projeto" method="post" action="des.php">
			<fieldset><legend>Selecionar projeto</legend>
				<label for="i_projeto">Todos os projetos em execução:</label><select name="projeto" id="i_projeto">
					<?php
					require_once("../../_includes/conexao.php");
					$sql = "SELECT PRCODINT, PRTITVAR FROM projeto WHERE PRSTAINT = 1";
					$query = $myssql->query($sql);
					$qtd = mysqli_num_rows($query);
					if($qtd > 0){
						while($res = $query->fetch_object()){
						?>
						<option value="<?php echo $res->PRCODINT; ?>"><?php echo $res->PRTITVAR; ?></option>
						<?php
						}
					}
					?>
				</select>				
			</fieldset>
            <?php           
            if($qtd > 0){
            ?>
			 <input type="submit" name="valida" value="desativar" />
            <?php
            }
            ?>
		</form>
        <?php
        if($qtd <= 0){
            echo "<div class='errorMsg'><img src='../../_icones/opa.png'/>Nenhum projeto está ativo para ser desativado.<span>x</span></div>";
            echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';
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