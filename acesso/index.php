<?php
	session_start();

    function setDestino(){
        switch ($_SESSION['tipo']) {
				case 1:
					header("Location:coord");
					break;
				case 2:
					header("Location:colabor");
					break;
				case 3:
				case 4:
					header("Location:bolsistas");
					break;
				case 5:
					header("Location:admin");
					break;
				case 6:
					header("Location:aluno");
					break;
				default:
					header("Location:aluno");
					break;
			}
    }

	if(isset($_SESSION['login'])){
		if(!isset($_COOKIE["redirect"])) {
			setDestino();
		}else{
			if($_COOKIE["redirectTipo"] == $_SESSION["tipo"] || ($_COOKIE["redirectTipo"] == 12 && ($_SESSION["tipo"] == 3 || $_SESSION["tipo"] == 4))) {
				$str = "Location:" . $_COOKIE["redirect"];
				setcookie("redirect",null, time() - (86400 * 30), "/");
				setcookie("redirectTipo",null, time() - (86400 * 30), "/");
				header($str);
			}else{
                setDestino();   
            }
		}
	}		
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Acesso</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
	<link rel="stylesheet" type="text/css" href="../_css/login.css">
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
<div id="or"><a href="../">inicio</a><span>acesso</span></div>
<section id="conteudo">
	<article>
		<form id="login" method="post" action="login.php">
			<?php
			if(isset($_COOKIE["erro"])){
			?>
			<h3 class="errorMsg" id="er"><img src="../_icones/opa.png" ><?php echo $_COOKIE["erro"]; ?><span>x</span></h3>
			<script>
			$("h3.errorMsg").slideDown(400);
            </script>
			<?php
			}
			setcookie("erro",null);
			?>
			<fieldset><legend>Login</legend>
				<label for="i_cpf">CPF:</label><input type="text" name="cpf" id="i_cpf" placeholder="apenas números"/><br>
				<label for="i_senha">Senha:</label><input type="password" name="senha" id="i_senha" placeholder="sua senha"/>
				<input type="submit" value="entrar" name="logar" />
				<span><a href="../cadastro#conteudo">efetuar cadastro</a></span>
			</fieldset>
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
