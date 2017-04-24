<?php
	session_start();
	require_once("../_includes/conexao.php");
	if(!isset($_SESSION["login"])) header("Location:../");
	if($_SESSION["tipo"] != 1){
		setcookie("redirect","../bolsistas/addm.php", time() + (86400 * 30), "/");
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
	<title>SIGEP - Adicionar pessoa ao projeto</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
	<link rel="stylesheet" type="text/css" href="../_css/form.css">
	<script type="text/javascript" src="../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../_javascript/funcoes.js"></script>
	<script type="text/javascript" src="../_plugins/ckeditor/ckeditor.js"></script>
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
<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><a href="gp.php">integrantes</a><span>adicionar pessoa</span><a href="gp.php" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Adicionar Pessoa</h3>
	<article id="submenu">
		<?php
			if(isset($_COOKIE["ok"])){
				echo '<div class="boaMsg"><img src="../_icones/ok.png"/>Integrante adicionado!<span>x</span></div>';
				setcookie("ok",null);
			}
		?>
		<form id="f_addbol" method="get" action="ad.php">
			<fieldset><legend>Adicionar pessoa - Cadastrados no sistema</legend>
				<label for="i_nome">Nome:</label><select name="nome" id="i_nome">
                <option>selecione</option>
					<?php
						$sel = "SELECT PSCODINT,PSNOMCHA FROM pessoa WHERE PSATINT = 1 AND PSTPFINT <> 0 AND PSCODINT <> ".$_SESSION["pscod"]." AND PSTPFINT <> 5 ORDER BY PSNOMCHA DESC";
						$query = $myssql->query($sel);
						$quer = null;
						while($res = $query->fetch_object()){
							$sql = "SELECT * FROM pessoa_projeto WHERE PPPRFINT = ".$_SESSION["projeto"]." AND PPPSFINT = ".$res->PSCODINT."";
							$quer = $myssql->query($sql);
							if(mysqli_num_rows($quer) <= 0) echo '<option value="'.$res->PSCODINT.'">'.$res->PSNOMCHA.'</option>';
						}
						$quer->free();
						$query->free();
					?>
				</select>
				<br><label for="i_tipo">Função no Projeto:</label><select name="tipo" id="i_tipo">
                    <option value="1">Coordenador (além de você)</option>
					<option value="2">Colaborador</option>
					<option value="3">Bolsista Graduação</option>
					<option value="4">Bolsista Médio</option>
					<option value="6">Aluno</option>
				</select>
				<br><label for="i_plano">Plano de Trabalho</label><textarea required name="plano" id="i_plano" cols="100" rows="10" required></textarea>				
				<div id="coloca">
				</div>
			</fieldset>
			<input type="submit" value="adicionar" name="valida" />
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
