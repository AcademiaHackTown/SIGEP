<?php
	require_once("../../_includes/conexao.php");
	session_start();
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
		setcookie("redirect","admin/newproj.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",5, time() + (86400 * 30), "/");
		header("Location:../");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP</title>
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
		<li><a href="../../"><img src="../../_icones/icon_sobre.png" alt="Sobre"> sobre</a></li>
		<li><a href="../../"><img src="../../_icones/icon_duvidas.png" alt="Duvidas"> duvidas</a></li>
		<li><a href="../../"><img src="../../_icones/icon_contato.png" alt="Contato"> contato</a></li>
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
<div id="or"><a href="../admin">inicio</a><a href="projetos.php">gerenciar projetos</a><span>cadastrar projeto</span><a href="../admin" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Cadastrar novo projeto</h3>
	<article id="submenu">
		<?php
		if(!isset($_GET["adproj"])){
        ?>
		<form id="cadproj" action="#" method="get">
			<fieldset><legend>projeto</legend>
				<label for="i_titulo">Título:</label><input required type="text" name="titulo" id="i_titulo" maxlength="140" /><br>
				<label for="i_res">Resumo</label><textarea cols="90" required rows="10" name="res" id="i_res"></textarea><br>
				<label for="i_palavras">Palavras Chave:</label><input required type="text" name="palavras" id="i_palavras"><br>
				<label>Coordenador:</label><select id="i_coord" name="coord">';
        <?php
            $pesquisa = "SELECT PSCODINT,PSNOMCHA FROM pessoa WHERE PSTPFINT = 1";
            $quer = $myssql->query($pesquisa);			

            while($pes = $quer->fetch_object()): ?>
                <option value='$pes->PSCODINT'><?php echo $pes->PSNOMCHA ?></option>;
            <?php endwhile; ?>
            </select>			
            </fieldset>
            <input type="reset" value="limpar"><input type="submit" name="adproj" value="cadastrar" >
        </form>
        <?php
		}else{
			$titulo = $_GET["titulo"];
			$resumo = $_GET["res"];
			$coord = $_GET["coord"];
			$palavras = $_GET["palavras"];
			$x = "SELECT PSNOMCHA FROM pessoa WHERE PSCODINT = ".$coord."";
			$quer = $myssql->query($x);
			$xx = $quer->fetch_object();
			$x = $xx->PSNOMCHA;
            $quer->free();

			$pesquisa = "INSERT INTO projeto (PRTITVAR,PRRESVAR,PRCHVVAR,prcoordint,PRTPFINT) VALUES ('".$titulo."','".$resumo."','".$palavras."','".$coord."','1')";
			$myssql->query($pesquisa);
            
			$pesquisa = "SELECT PRCODINT FROM projeto WHERE PRTITVAR = '".$titulo."'";
			$quer = $myssql->query($pesquisa);
            $prid = -1;
			while ($re = $quer->fetch_object()){
				$prid = $re->PRCODINT;
			}
			$pesquisa = "INSERT INTO pessoa_projeto VALUES (0,$prid,$coord,1,'Nenhum plano.')";
			$myssql->query($pesquisa);
			?>			
			<div class="boaMsg"><img src="../../_icones/ok.png"> Projeto Adicionado<span>x</span></div>
			<div class="extra">
                <p><span class="destaque_extra">Título: </span> <?php echo $titulo; ?> </p>
                <p><span class="destaque_extra">Resumo: </span> <?php echo $resumo; ?> </p>
                <p><span class="destaque_extra">Palavras chave: </span> <?php echo $palavras; ?> </p>
                <p><span class="destaque_extra">Coordenador: </span> <?php echo $x; ?> </p>
            </div>
		<?php
            $quer->free();
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