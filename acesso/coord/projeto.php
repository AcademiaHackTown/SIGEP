<?php
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
		setcookie("redirect","coord/projeto.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",1, time() + (86400 * 30), "/");
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])) header("Location:../selectproj.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Preencher informacoes do projetos</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../../_css/form.css">
	<link rel="stylesheet" type="text/css" href="../../_css/estilo.css">
	<script type="text/javascript" src="../../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../../_javascript/funcoes.js"></script>
	<script type="text/javascript" src="../../_plugins/ckeditor_std/ckeditor.js"></script>
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
<div id="or"><a href="../selectproj.php">selecionar projeto<a href="../coord">inicio</a></a><span>preencher informações do projeto</span><a href="../coord" class="voltar">voltar</a></div>
<section id="conteudo">
	<?php
	if(isset($_COOKIE["prInfoF"])){
		?>
		<div class="errorMsg"><img src="../../_icones/opa.png"><?php echo $_COOKIE["prInfoF"]; ?><span>x</span></div>
		<script type="text/javascript">$(".errorMsg").slideDown(400);</script>
		<?php
		setcookie("prInfoF",null);
		}
	?>
	<h3 class="titulo">Informações do projeto</h3>
	<article>		
		<p>Preencha as informações do projeto abaixo para que este seja iniciado.</p>
		<form method="post" action="pre.php" id="preenche_projeto">
			<fieldset><legend>Projeto</legend>
				<label for="i_apelido">Titulo curto para o projeto (até 30 caracteres):</label><input required type="text" name="apelido" id="i_apelido" placeholder="Ex.: Meu 1 projeto - Sementes como alimento" maxlength="30" style="width: 350px;" />
				<br><label for="i_dataInicio">Data de Inicio:</label><input required type="date" name="dataInicio" id="i_dataInicio" />
				<br><label for="i_dataFim">Data de Término:</label><input required type="date" name="dataFim" id="i_dataFim" />
				<br><label for="i_tipoprojeto">Tipo de projeto: </label><select name="tipoprojeto" id="i_tipoprojeto">
					<?php
					$query = "SELECT TPCODINT, TPNOMCHA FROM tipo_projeto";
					$res = $myssql->query($query);
					while($r = $res->fetch_object()){
					?>
					<option value="<?php echo $r->TPCODINT; ?>"><?php echo $r->TPNOMCHA; ?></option>
					<?php
					}
					?>					
				</select>
			</fieldset>
			<fieldset id="cronograma_projeto"><legend>Cronograma do Projeto </legend>				
				<div id="barra"><span>Atividade(s):</span><span>Mes(es) de execução:</span></div>
				<div id="mes_exec">
				<label>1</label><label>2</label><label>3</label><label>4</label><label>5</label><label>6</label><label>7</label><label>8</label><label>9</label><label>10</label><label>11</label><label>12</label></div>
				<div class="cronograma_atividade">
				<br>				
				<textarea required name="atividade[]" required class="atividade" cols="30" rows="5"></textarea>
				<div class="cronograma_meses">
					<span class="div_meses"><input type="checkbox" name="mes1[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes2[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes3[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes4[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes5[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes6[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes7[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes8[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes9[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes10[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes11[]" value="1"></span>
					<span class="div_meses"><input type="checkbox" name="mes12[]" value="1"></span>
				</div>
				</div>
				<div id="delimiter"></div>
				<br><br><br>
				<button type="button" id="bt_addCr"><img src="../../_icones/icon_add24.png" alt="adicionar" /> adicionar</button>
				<button type="button" id="bt_remCr"><img src="../../_icones/icon_remove24.png" alt="remover" /> remover</button>
			</fieldset>
			<input type="reset" name="limpa" value="limpar" /><input type="submit" value="enviar" name="valida" />
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