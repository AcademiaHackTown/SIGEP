<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
	setcookie("redirect","../bolsistas/todas.php", time() + (86400 * 30), "/");
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
	<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><a href="Anali_atvdd.php">análise</a><span>todas</span><a href="Anali_atvdd.php" class="voltar">voltar</a></div>
	<section id="conteudo">
		<h3 class='titulo'>Todas as Atividades</h3>
		<article>
			<?php
			require_once("../_includes/conexao.php");
			$sql = "SELECT * FROM tarefas WHERE trprfint = ".$_SESSION["projeto"]." ORDER BY trcodint DESC";
			$quer = $myssql->query($sql);
			$x = mysqli_num_rows($quer);
			if($x > 0){ ?>
				<ul id="i_atividade">				
					<?php
					while ($res = $quer->fetch_object()) {
						$sel = "SELECT trdesvar FROM tarefas WHERE trcodint = $res->tratfint";
						$q = $myssql->query($sel);
						$titulo = "";
						while($r = $q->fetch_object()){
							$titulo = $r->trdesvar;
						}
						?>
						<li>
							<?php echo $res->trdesvar;	?>
						</li>
						<?php
					}
					$quer->free();
					$q->free();
					?>
				</ul>
				<?php
			}else{
				?>
				<div class="errorMsg"><img src="../_icones/opa.png">Não existe histórico de nenhuma tarefa recebida ou enviada.<span>x</span></div>
				<script type="text/javascript">$(".errorMsg").fadeIn(400);</script>				
				<?php
			}
			?>
			<div id="top" title="Ir para o topo">&#9650;</div>
			</article>
	</section>
	<footer>
		<img src="../_imagens/cnpq.jpg">	<img src="../_imagens/if.jpg">
	</footer>
</div>
</body>
</html>