<?php	
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
		setcookie("redirect","coord/altprojeto.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",1, time() + (86400 * 30), "/");
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])) header("Location:../selectproj.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Editar informações do projeto</title>
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
<div id="or"><a href="../selectproj.php">selecionar projeto<a href="../coord">inicio</a></a><span>alterar informações do projeto</span><a href="../coord" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Informações do projeto</h3>
	<article>
		<?php
		if(isset($_COOKIE["altprt"])){
		?>
		<div class="boaMsg"><img src="../../_icones/ok.png">Informações alteradas. Voce será desconectado do projeto para as alterações serem salvas.<span>x</span></div>
		<script type="text/javascript">
		$(".boaMsg").slideDown(400);
		setTimeout(function(){window.location.href="altrst.php";},4000);
		</script>
		<?php
		setcookie("altprt",null);
		}
		if(isset($_COOKIE["altprf"])){
		?>
		<div class="errorMsg"><img src="../../_icones/opa.png"><?php echo $_COOKIE["altprf"]; ?><span>x</span></div>
		<script type="text/javascript">$(".errorMsg").slideDown(400);</script>
		<?php
		setcookie("altprf",null);
		}
		?>
		<p>Edite as informações do projeto abaixo.</p>
		<?php
		$sql = "SELECT * FROM projeto WHERE PRCODINT = ".$_SESSION["projeto"]."";
		$query = $myssql->query($sql);
		while($pr = $query->fetch_object()){
			$dataI = date_format(date_create($pr->PRDTIDAT),"d/m/Y");
			$dataF = date_format(date_create($pr->PRDTFDAT),"d/m/Y");
		?>
		<form method="post" action="alt.php" id="preenche_projeto">
			<fieldset><legend>Projeto</legend>
				<label for="i_tit">Titulo:</label><input required type="text" name="tit" id="i_tit" maxlength="200" value="<?php echo $pr->PRTITVAR; ?>" style="width:450px;"/>
				<br><label for="i_titc">Titulo curto (ate 40 caracteres):</label><input required type="text" name="titc" id="i_titc" maxlength="40" value="<?php echo $_SESSION['nomeProjeto']; ?>" style="width:450px;"/>
				<br><label for="i_res">Resumo:</label><textarea required cols="80" rows="20" name="res" id="i_res"><?php echo trim($pr->PRRESVAR); ?></textarea>
				<br><label for="i_palavras">Palavras chave:</label><input required type="text" name="palavras" id="i_palavras" value="<?php echo $pr->PRCHVVAR; ?>" />
				<br><label for="i_dataInicio">Data de Inicio: <span class="enf_azul"><?php echo $dataI; ?></span></label><input required type="date" name="dataInicio" id="i_dataInicio" />
				<br><label for="i_dataFim">Data de Término: <span class="enf_azul"><?php echo $dataF; ?></span></label><input required type="date" name="dataFim" id="i_dataFim" />				
			</fieldset>
            <fieldset id="cronograma_projeto"><legend>Cronograma do Projeto </legend>				
				<div id="barra"><span>Atividade(s):</span><span>Mes(es) de execução:</span></div>
				<div id="mes_exec">
				<label>1</label><label>2</label><label>3</label><label>4</label><label>5</label><label>6</label><label>7</label><label>8</label><label>9</label><label>10</label><label>11</label><label>12</label></div>
                <?php
                    require '../../_includes/conexao.php';
                    $sql = "SELECT * FROM cronograma_projeto WHERE CPPRFINT = ".$_SESSION["projeto"];
                    $resul = $myssql->query($sql);
                    while($cronograma = $resul->fetch_object()):
                        $sql = "SELECT ATDESVAR FROM atividade WHERE ATCODINT = ".$cronograma->CPATFINT;
                        $at = $myssql->query($sql);
                        $natv = $at->fetch_object()->ATDESVAR;
                        $at->free();
            
                        $checked = $cronograma;
                ?>
				<div class="cronograma_atividade">
				<br>
				<textarea required name="atividade[]" required class="atividade" cols="30" rows="5"><?php echo $natv; ?></textarea>
				<div class="cronograma_meses">
                    <?php            
                    for($i = 1; $i <= 12; $i++):
                        $mes = "mes".$i;
                        $mex = "CPME".$i."INT";
                        $checked = $cronograma->$mex == 1?'checked="checked"':'';
                    ?>
					<span class="div_meses"><input type="checkbox" <?php echo $checked; ?> name="<?php echo $mes; ?>[]" value="1"></span>
                    <?php endfor; ?>
				</div>
				</div>
                <?php
                endwhile;
                ?>
				<div id="delimiter"></div>
				<br><br><br>
				<button type="button" id="bt_addCr"><img src="../../_icones/icon_add24.png" alt="adicionar" /> adicionar</button>
				<button type="button" id="bt_remCr"><img src="../../_icones/icon_remove24.png" alt="remover" /> remover</button>
			</fieldset>
			<input type="reset" name="limpa" value="preencher" /><input type="submit" value="enviar" name="valida" />
		</form>
		<?php
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