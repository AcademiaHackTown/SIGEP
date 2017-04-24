<?php
	session_start();
	if(!isset($_SESSION['login']) || !($_SESSION['tipo'] == 3 || $_SESSION["tipo"] == 4)){
		setcookie("redirect","atividades/concluidas.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",12, time() + (86400 * 30), "/");
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])){
		header("Location:../selectproj.php");
	}
?>
<html lang="pt-br">
<head>
	<title>SIGEP - Tarefas Concluídas</title>
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
	<div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../">inicio</a><a href="index.php">tarefas</a><span>concluidas</span><a href="../atividades" class="voltar">voltar</a></div>
	<section id="conteudo">
		<h3 class='titulo'>Tarefas Concluidas</h3>
		<article id="lista_th">
			<?php
			require_once("../../_includes/conexao.php");
			$sql = "SELECT trtitvar,trdtfcha,trcodint FROM tarefas WHERE trstaint = 1 AND trpsfint = ".$_SESSION["pscod"]." AND trprfint = ".$_SESSION["projeto"]."  ORDER BY trcodint DESC";
			$quer = $myssql->query($sql);
			$x = mysqli_num_rows($quer);
			if($x > 0){ ?>
				<table class="tb">
				    <thead>
				        <tr>
                            <th>Título da atividade:</th>
                            <th>Data limite:</th>
                            <th>Ação:</th>
                        </tr>
				    </thead>
					<?php
					while ($res = $quer->fetch_object()):
						?>
                        <tr>
                            <td><a href="visualizar.php?src=concluidas&id=<?php echo $res->trcodint; ?>" target="_blank"><?php echo $res->trtitvar; ?></a></td>
						    <td class="tb-data"><?php echo date_format(date_create($res->trdtfcha),"d/m/Y"); ?></td>
						    <td class="tb-acao"><a href="visualizar.php?src=pendentes&id=<?php echo $res->trcodint; ?>" target="_blank"><img alt="visualizar tarefa pendente" src="../../_icones/icon_olho16x.png"> ver</a></td>
						</tr>
				    <?php
					endwhile;
					$quer->free();
					?>
                </table>
				<?php
			}else{
				?>
				<div class="errorMsg"><img src="../../_icones/opa.png" alt="Erro">Nenhuma atividade concluida!<span>x</span></div>
				<?php
			}
			?>
			<div id="top" title="Ir para o topo">&#9650;</div>
			</article>
	</section>
	<footer>
		<img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
	</footer>
</div>
</body>
</html>
