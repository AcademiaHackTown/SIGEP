<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
	setcookie("redirect","../bolsistas/rg.php", time() + (86400 * 30), "/");
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
	<title>SIGEP - Registro de atividades</title>
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
	<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><a href="registros.php">registros de atividades</a><span>visualizar</span><a href="registros.php" class="voltar">voltar</a></div>
	<section id="conteudo">
        <?php
        require_once("../_includes/conexao.php");
        $ps = $_GET["id"];
        $getNome = "SELECT PSNOMCHA FROM pessoa WHERE PSCODINT = $ps";
        $query = $myssql->query($getNome);
        $n = $query->fetch_object();
        $nome = $n->PSNOMCHA;
        $query->free();
        ?>
		<h3 class='titulo'>Registros de atividades - <span class="enf_title"><?php echo $nome; ?></span></h3>
		<article>
        <div class="container">
        <table class="minimenu">
            <tr>
                <td class="th">Ordenar por :</td>
                <td class="btn" id="dtatividade"><a href="visualizar.php?ob=da">Data da atividade</a></td>
                <td class="btn" id="dtsubmetida"><a href="visualizar.php?ob=ds">Data da submissão</a></td>
            </tr>
        </table>
        <a href="imprimir_registro.php?b=<?php echo $ps; ?>" id="imp" class="btn" target="_blank"><img src="../_icones/icon_imprimir.png" alt="Imprimir"> versão para impressão</a>
        </div>
		<?php
		if(!isset($_GET["id"])){
			echo "<div class='errorMsg'><img src='../_icones/opa.png'/>Selecione um bolsista.<span>x</span></div>";
			echo '<script type="text/javascript">$(".errorMsg").slideDown(400);</script>';
		}else{			
            $sql = "";
            if(isset($_GET["ob"])){
                $ob = $_GET["ob"];
                if($ob == "da"){
                    $sql = "SELECT * FROM registro_atividade WHERE RAPSCODINT = $ps AND RAPRFINT = ".$_SESSION["projeto"]." ORDER BY RADTEDAT ASC";
                }elseif($ob == "ds"){
                    $sql = "SELECT * FROM registro_atividade WHERE RAPSCODINT = $ps AND RAPRFINT = ".$_SESSION["projeto"]." ORDER BY RADTADAT ASC";
                }
            }else{
                $sql = "SELECT * FROM registro_atividade WHERE RAPSCODINT = $ps AND RAPRFINT = ".$_SESSION["projeto"]." ORDER BY RACODINT ASC";
            }
            
			$query = $myssql->query($sql);
			$qtd = mysqli_num_rows($query);
			while($res = $query->fetch_array()){
			$data1 = date_format(date_create($res["RADTEDAT"]),"d/m/Y");
			$data2 = date_format(date_create($res["RADTADAT"]),"d/m/Y");

			?>
			<div class="extra"><h3>Registro</h3>
				<p><span class="destaque_extra">Data submetida (bolsista):</span> <?php echo $data2; ?></p>
				<p><span class="destaque_extra">Data submetida (sistema):</span> <?php  echo $data1; ?></p>
                <p><span class="destaque_extra">Conteudo submetido:</span>
				<br><span class="extra_extra"><?php echo $res["RACONTVAR"]; ?></span></p>
                <p><span class="destaque_extra">Detalhes:</span>
                <span class="extra_extra"><?php echo $res["RADTLVAR"]; ?></span></p>
			</div>
			<?php
			}
		}
		if($qtd <= 0){
		?>
		<div class="errorMsg"><img src="../_icones/opa.png">Nenhuma atividade registrada por este bolsista!<span>x</span></div>
		<script type="text/javascript">$(".errorMsg").slideDown(400);</script>
		<?php 
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