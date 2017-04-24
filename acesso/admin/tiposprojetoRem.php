<?php session_start();
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
		setcookie("redirect","admin/tiposprojeto.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",5, time() + (86400 * 30), "/");
		header("Location:../");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Gerenciar tipos de projeto</title>
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
<div id="or"><a href="../../acesso">inicio</a><a href="tiposprojeto.php">tipos de projeto</a><span>remover</span><a href="../../" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Remover tipo de projeto existente</h3>
	<?php
	if(isset($_COOKIE["remv"])){
		echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>Tipo de projeto removido. <span>x</span></div>";
		echo '<script type="text/javascript">$(".boaMsg").slideDown();</script>';
		setcookie("remv",null,time() - (8400 * 30), "/");
	}elseif(isset($_COOKIE["remvErro"])){
        echo "<div class='errorMsg'><img src='../../_icones/opa.png'/>".$_COOKIE["remvErro"]."<span>x</span></div>";
		echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';
		setcookie("remvErro",null,time() - (8400 * 30), "/");
    }else{}
	?>
	<article>
		<?php
		require_once("../../_includes/conexao.php");
		?>
		<form method="post" action="tipos.php" id="delTPpr">
			<fieldset><legend>Remover tipo de projeto</legend>
				<select name="tipoR">
				<?php
				$sql = "SELECT TPCODINT,TPNOMCHA,TPDESVAR FROM tipo_projeto ORDER BY TPNOMCHA ASC";
				$query = $myssql->query($sql);
                $des = ".';-";
				if(mysqli_num_rows($query) > 0){
					while($r = $query->fetch_object()){
                        if($des == ".';-")
                            $des = $r->TPDESVAR;
					?>
					<option value="<?php echo $r->TPCODINT; ?>"><?php echo $r->TPNOMCHA; ?></option>
					<?php
					}
				}
				$query->free();
				?>
				</select><br>
                <div id="nomeTipo" class="extra" style="margin:0px;width:400px;"><?php echo utf8_encode($des); ?></div>
			</fieldset>
			<input type="submit" name="validaRemove" value="remover" />
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