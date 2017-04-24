<?php
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
		setcookie("redirect","admin/alt.php", time() + (86400 * 30), "/");
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
<div id="or"><a href="../admin">inicio</a><a href="gc.php">gerenciar contas</a><span>alterar tipo de conta</span><a href="gc.php" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Alterar tipo de conta</h3>
	<article id="submenu">
		<?php
		$sel = "SELECT * FROM pessoa WHERE PSATINT = 1";
		$query = $myssql->query($sel);	
		if(mysqli_num_rows($query) > 0){
		?>
		<form id="f_atacc" method="post" action="tpf.php">
			<?php
			if(isset($_COOKIE["alts"])){
				echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>".$_COOKIE["alts"]."<span>x</span></div>";
				echo '<script type="text/javascript">$(".boaMsg").slideDown(400);</script>';
				setcookie("alts",null);
			}elseif(isset($_COOKIE["altn"])){
				echo "<div class='errorMsg'><img src='../../_icones/opa.png'/>".$_COOKIE["altn"]."<span>x</span></div><br>";
				echo '<script type="text/javascript">$(".errorMsg").slideDown(400);</script>';				
				setcookie("altn",null);
			}else{}
			?>
			<fieldset><legend>Contas cadastradas:</legend>
				<label for="i_conta">Nome do usuário:</label>
				<select name="conta" id="i_conta">
					<?php
						$sel = "SELECT PSCODINT,PSTPFINT,PSNOMCHA FROM pessoa WHERE PSATINT = 1 AND PSTPFINT <> 5 ORDER BY PSNOMCHA DESC";
						$query = $myssql->query($sel);
                        $tp = 0;
						while($resul = $query->fetch_object()){
							echo '<option value="'.$resul->PSCODINT.'">'.$resul->PSNOMCHA.'</option>';
                            if($tp == 0)
                                $tp = $resul->PSTPFINT;
						}
					?>
                </select><div class="enf_azul" id="tipo_conta"><?php
            $tipo = array("Indefinido","Coordenador","Colaborador","Bolsista - Graduacao","Bolsista - Médio","Admistrador","Aluno");
            echo $tipo[$tp];
            $query->free();
            ?></div><br>
				<label for="i_tipo">Categoria da conta:</label>
				<select name="tipo" id="i_tipo">
					<option value="1">Coordenador</option>
					<option value="2">Colaborador</option>
					<option value="3">Bolsista - Graduação</option>
					<option value="4">Bolsista - Medio</option>
					<option value="6">Aluno</option>
					<option value="5">Adminstrador do Sistema</option>
				</select>
			</fieldset>
			<input type="submit" value="alterar" name="alterar" />
		</form>
		<?php
		}else{
		?>
		<div class="errorMsg"><img src="../../_icones/ok.png">Nenhuma conta ativada no sistema.<span>x</span></div>		
		<?php
		$query->free();
		}
		?>
	</article>	
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../../_imagens/cnpq.jpg" alt="CNPq">	<img src="../../_imagens/if.jpg" alt="Instituto Federal">
</footer>
</div>
</body>
</html>