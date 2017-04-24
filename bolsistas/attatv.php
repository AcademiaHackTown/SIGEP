<?php
	session_start();
	if(!isset($_SESSION["login"])) header("Location:../");
	if($_SESSION["tipo"] != 1){
		setcookie("redirect","../bolsistas/attatv.php", time() + (86400 * 30), "/");
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
	<title>SIGEP - Atribuição de Tarefas</title>
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
<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><span>atribuir atividades</span><a href="../bolsistas" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Área do Coordenador</h3>
	<article id="submenu">
		<?php
		if(isset($_COOKIE["atatv"])){
			?>
			<div class="boaMsg"><img src="../_icones/ok.png" />Atividade atribuida com sucesso.<span>x</span></div>
			<?php
			setcookie("atatv",null);
		}
		?>
		<form action="atatv.php" method="POST">
			<fieldset><legend>Atribuição de Tarefas</legend>
				<label for="i_bols">Bolsista:</label><select required name="bols" id="i_bols">

					<?php
					require_once("../_includes/conexao.php");
					$sql = "SELECT * FROM pessoa_projeto WHERE PPPRFINT = ".$_SESSION["projeto"]." AND (PPTPFINT = 4 OR PPTPFINT = 3)";
					$quer = $myssql->query($sql);
					while($res = $quer->fetch_object()){
						$codP = $res->PPPSFINT;
						$sqll = "SELECT * FROM pessoa WHERE PSCODINT = $codP";
						$querr = $myssql->query($sqll);
						while($ress = $querr->fetch_object()){
							$nom = $ress->PSNOMCHA;
							?>
							<option value="<?php echo $codP; ?>"><?php echo $nom; ?></option>
							<?php
						}
					}
					?>
				</select>
				<br><label for="i_tipo">Atividade vinculada à tarefa:</label><select required name="tipo" id="i_tipo">
					<?php
					$sql = "SELECT * FROM atividade WHERE ATPRFINT = ".$_SESSION["projeto"]."";
					$query = $myssql->query($sql);
					while($res = $query->fetch_object()){
					?>
					<option value="<?php echo $res->ATCODINT; ?>"><?php echo $res->ATDESVAR; ?> </option>
					<?php
					}
					?>
					<option value="0">Outro</option>
				</select>
				<br><label for="i_titulo">Titulo da tarefa</label><input type="text" max="40" name="titulo" id="i_titulo" required/>
				<br><label for="i_data">Data de entrega:</label><input type="date" name="data" id="i_data" required>
				<br><label for="i_atv">Descrição:</label>
				<textarea name="atv" id="i_atv" cols="100" required></textarea>				
			</fieldset>
			<input type="reset" value="limpar"><input type="submit" name="enviar" value="enviar" >
		</form>
	</article>
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../_imagens/cnpq.jpg">	<img src="../_imagens/if.jpg">
</footer>
</div>
</body>
</html>