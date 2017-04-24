<?php
	session_start();
	require_once("../_includes/conexao.php");
	if(!isset($_SESSION["login"])) header("Location:../");
	if($_SESSION["tipo"] != 1){
		setcookie("redirect","../bolsistas/histo.php", time() + (86400 * 30), "/");
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
	<title>SIGEP - Histórico e estatística de atividades por bolsista</title>
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
<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><span>histórico</span><a href="../bolsistas" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class='titulo'>Histórico e estatística de atividades por bolsista</h3>
	<article class="grafico">
		<ul>
			<?php
			$sql = "SELECT * FROM pessoa_projeto WHERE PPPRFINT = ".$_SESSION["projeto"]." AND PPTPFINT > 2 AND PPTPFINT < 5";
			$buscaPS = $myssql->query($sql);
			$qtd = mysqli_num_rows($buscaPS);
			while($res = $buscaPS->fetch_object()){
				$sqll = "SELECT PSNOMCHA FROM pessoa WHERE PSCODINT = ".$res->PPPSFINT."";
				$r = $myssql->query($sqll);
				$rr = $r->fetch_object();
				
				$pesq = "SELECT * FROM tarefas WHERE trpsfint = ".$res->PPPSFINT."";
				$busca = $myssql->query($pesq);
				
				$total = mysqli_num_rows($busca);
				
				$busca->free();
				$pesq = "SELECT * FROM tarefas WHERE trstaint = 1 AND trpsfint = ".$res->PPPSFINT."";
				$busca = $myssql->query($pesq);
				
				$parcial = mysqli_num_rows($busca);
				
				$pct = 1;
				if($total != 0 && $parcial != 0) $pct = ($parcial*100)/$total;				
				$str = $pct."%";

				$color = "#000";

				if($pct < 20) $color = "rgb(255,40,40)";
				if($pct > 19 && $pct < 40) $color = "#E87909";
				if($pct > 39 && $pct < 70) $color = "#067CCA";
				if($pct > 69) $color = "#96CC00";

				$q = "SELECT trcodint FROM tarefas WHERE trpsfint = ".$res->PPPSFINT." AND trprfint = ".$_SESSION["projeto"]." AND trstaint = 0";
				$query = $myssql->query($q);
				$pendentes = mysqli_num_rows($query);
				$query->free();
				$q = "SELECT trcodint FROM tarefas WHERE trpsfint = ".$res->PPPSFINT." AND trprfint = ".$_SESSION["projeto"]." AND trstaint = 1";
				$query = $myssql->query($q);
				$concluidas = mysqli_num_rows($query);
				$query->free();
				$q = "SELECT trcodint FROM tarefas WHERE trpsfint = ".$res->PPPSFINT." AND trprfint = ".$_SESSION["projeto"]." AND trstaint = 2";
				$query = $myssql->query($q);
				$emAvaliacao = mysqli_num_rows($query);
				$query->free();
				
				echo '<li id="'.$res->PPPSFINT.'" title="clique sobre para mostrar estatísticas">'.$rr->PSNOMCHA.'<span style="width:'.$str.';background:'.$color.';"></span><span class="ppct">'.number_format($pct,0).'%</span><span></span>
				</li>';
				?>
				<div class="extra" id="extrahisto<?php echo $res->PPPSFINT; ?>">					
					<p>Atividades concluidas: <span class="enf_verde"><?php echo $concluidas; ?></span></p>
					<p>Atividades pendentes: <span class="enf_vermelho"><?php echo $pendentes; ?></span></p>
					<p>Atividades em avaliação: <span class="enf_azul"><?php echo $emAvaliacao; ?></span></p>
					<br><p><a target="_blank" href="visualizarhistorico.php?id=<?php echo $res->PPPSFINT; ?>&nome=<?php echo $rr->PSNOMCHA; ?>" class="botao" style="color: #FFF;"><img src="../_icones/icon_visualizaratividadesbolsista.png" alt="Atividades"> todas</a></p>
				</div>
				<?php				
				$busca->free();
			}
			$buscaPS->free();
			?>			
		</ul>
		<?php
		if($qtd <= 0){
			echo "<div class='errorMsg'><img src='../_icones/opa.png'/>Nenhum bolsista ou colaborador cadastrado no projeto.<span>x</span></div>";
			echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';
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
