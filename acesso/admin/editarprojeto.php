<?php
    session_start();
    require_once '../../_includes/conexao.php';
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
		setcookie("redirect","admin/editarprojeto.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",5, time() + (86400 * 30), "/");
		header("Location:../");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Gerenciar projetos</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../../_css/estilo.css">
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
<div id="or"><a href="../admin">inicio</a><a href="projetos.php">gerenciar projetos</a><span>editar projeto</span><a href="../admin" class="voltar">voltar</a></div>
<section id="conteudo">
    <h3 class="titulo">Selecione um projeto na lista e clique em <strong>"editar"</strong>:</h3>
	<article>
		<table class="tb">
            <thead>
                <tr>
                    <th><a href="?o=titulo" style="text-decoration: none; color: #fff;">Título do projeto:</a></th>
                    <th><a href="?o=coord" style="text-decoration: none; color: #fff;">Coordenador:</a></th>
                    <th><a href="?o=data" style="text-decoration: none; color: #fff;">Data de início:</a></th>
                    <th>Ação:</th>
                </tr>
            </thead>
            <tbody>
            <?php
                
            $o = isset($_GET["o"]) ? $_GET["o"] : "titulo";
            $or = array("titulo" => "projeto.PRTITVAR","coord" => "pessoa.PSNOMCHA","data" => "projeto.PRDTIDAT");
                
            $sql = "SELECT projeto.PRCODINT as codprojeto, projeto.PRTITVAR as titulo, projeto.PRDTIDAT as dataInicio, pessoa.PSNOMCHA as nomeCoord FROM projeto INNER JOIN pessoa ON pessoa.PSCODINT = projeto.prcoordint ORDER BY ".$or[$o]." ASC";
            $query = $myssql->query($sql);
            while($p = $query->fetch_object()):
            ?>
            <tr>
                <td><?php echo $p->titulo; ?></td>
                <td><?php echo $p->nomeCoord; ?></td>
                <td><?php echo date_format(date_create($p->dataInicio),"d/m/Y"); ?></td>
                <td class="editar"><a href="doeditarprojeto.php?p=<?php echo $p->codprojeto; ?>"><img alt="Editar projeto" src="../../_icones/icon_editarprojeto.png"> editar</a></td>
            </tr>
            <?php endwhile;
            $query->free();
            ?>
            </tbody>
		</table>
	</article>	
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
</footer>
</div>
</body>
</html>