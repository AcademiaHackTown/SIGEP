<?php	
	session_start();
	require_once("../_includes/conexao.php");
	if(!isset($_SESSION['login'])){
		header("Location:../");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Selecionar projeto</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/form.css">
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
	<script type="text/javascript" src="../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../_javascript/funcoes.js"></script>
</head>
<body>
<div id="bck"></div>
<div id="interface">
<div id="top_back"><img src="../_imagens/logo_sigep.fw.png" alt="SIGEP">
<span>Sistema de Gerenciamento de Projeto</span></div>
<header>
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
<div id="or"><a href="../">inicio</a><span>selecionar projeto</span><a href="../" class="voltar">voltar</a></div>
<section id="conteudo">	
	<h3 class="titulo">Escolha de projeto</h3>
	<article id="submenu">
		<form method="post" action="sp.php">
			<fieldset><legend>Selecione um projeto</legend>
				<label for="i_projeto">Nome do Projeto:</label><select name="projeto" id="i_projeto">
					<option>selecione</option>
					<?php
					$pesq = "SELECT PPPRFINT FROM pessoa_projeto WHERE PPPSFINT = ".$_SESSION['pscod']."";
					$quer = $myssql->query($pesq);
					if(mysqli_num_rows($quer) > 0){
						while($res = $quer->fetch_object()){
							$sql = "SELECT PRCODINT,PRTITVAR FROM projeto WHERE PRCODINT = $res->PPPRFINT";
							$projeto = $myssql->query($sql);
							if(mysqli_num_rows($projeto) > 0){
								while($pr = $projeto->fetch_object()){
								?>
								<option value="<?php echo $pr->PRCODINT; ?>"><?php echo $pr->PRTITVAR; ?></option>
								<?php
								}
							}
						}
					}					
					?>					
				</select>
			</fieldset>
			<input type="submit" name="valida" value="selecionar" />
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