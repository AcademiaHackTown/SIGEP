<?php
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
		setcookie("redirect","admin/atacc.php", time() + (86400 * 30), "/");
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
<div id="or"><a href="../admin">inicio</a><a href="gc.php">gerenciar contas</a><span>ativar conta</span><a href="gc.php" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Ativação de conta</h3>
	<article id="submenu">
		<?php
        if(isset($_COOKIE["atsim"])){
				echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>Conta ativada com sucesso<span>x</span></div>";
				echo '<script type="text/javascript">$(".boaMsg").slideDown(400);</script>';
				setcookie("atsim",null);
			}elseif(isset($_COOKIE["atnao"])){
				echo "<div class='errorMsg'><img src='../../_icones/opa.png'/>".$_COOKIE["atnao"]."<span>x</span></div><br>";
				echo '<script type="text/javascript">$(".errorMsg").slideDown(400);</script>';				
				setcookie("atnao",null);
			}else{}
		$sel = "SELECT * FROM pessoa WHERE PSATINT = 0";
		$query = $myssql->query($sel);	
		if(mysqli_num_rows($query) > 0){
		?>
		<form id="f_atacc" method="post" action="at.php">					
			<fieldset><legend>Contas cadastradas:</legend>
				<label for="i_conta">Nome do usuário:</label>
				<select name="conta" id="i_conta">
					<?php
						$sel = "SELECT * FROM pessoa WHERE PSATINT = 0";
						$query = $myssql->query($sel);
						while($resul = $query->fetch_object()){
							echo '<option value="'.$resul->PSCODINT.'">'.$resul->PSNOMCHA.'</option>';
						}
					?>
				</select><br>
				<label for="i_tipo">Categoria da conta:</label>
				<select name="tipo" id="i_tipo">			
					<option value="1">Coordenador</option>
					<option value="2">Colaborador</option>
					<option value="3">Bolsista - Graduação</option>
					<option value="4">Bolsista - Medio</option>					
					<option value="6">Aluno</option>
					<option value="6">Visitante</option>
				</select>				
			</fieldset>
            <input type="submit" value="ativar" name="ativar" />
		</form>
		<?php
		}else{
		?>
		<div class="boaMsg"><img src="../../_icones/ok.png">Todas as contas já estão ativadas!<span>x</span></div>		
		<?php
		$query->free();
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