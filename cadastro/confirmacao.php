<?php
	session_start();
	require_once("../_includes/conexao.php");
    
	if(!isset($_POST["confirmouCadastro"])){
		header("Location:../cadastro");
	}
    
	//<div class="form-gp"><label for="i_user">Usuário: </label><input readonly type="text" readonly required id="i_user" name="user" value="'.$user.'" />
	$nome = $_POST["nome"];
	$cpf = $_POST["cpf"];
	$rg = $_POST["rg"];
	$exp = $_POST["exp"];
	$expdat = $_POST["expdat"];
	$nasc = $_POST["nasc"];
	$nomepai = $_POST["nomepai"];
	$nomemae = $_POST["nomemae"];
	$log = $_POST["logradouro"];
	$bairro = $_POST["bairro"];
	$num = $_POST["num"];
	$comp = $_POST["comp"];
	$cep = $_POST["cep"];
	$telefone = $_POST["tel"];
	$celular = $_POST["cel"];
	//$user = $_POST["user"];
	$email1 = $_POST["email1"];
	$email2 = $_POST["email2"];
	$senha1 = $_POST["senha1"];
	$senha2 = $_POST["senha2"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Confirmação de Cadastro</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
	<link rel="stylesheet" type="text/css" href="../_css/cadastro.css">
	<script type="text/javascript" src="../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#shs").click(function(){
				if(!shs){	
					$("#shs").css("background","#fff");
					$("#shs").css("color","#8A0000");
					$("#shs").css("width","60px");
					$("#shs").html("esconder");
				}else{
					$("#shs").css("background","#8A0000");
					$("#shs").css("color","#fff");
					$("#shs").css("width","55px");
					$("#shs").html("mostrar");
				}
				shs = !shs;
			});
		});

		$(function(){
		    $(window).scroll(function () {
		        if ($(this).scrollTop() > 258) {
		            $("#top").css("bottom","30px");
		            $("#top").css("bottom","10px");
		        } else {
		            $("#top").css("bottom","-70px");
		        }
		    });
		});

	</script>
</head>
<body>
<div id="bck"></div>
<div id="interface">
<div id="top_back">
<img src="../_imagens/logo_sigep.fw.png" alt="SIGEP">
<span>Sistema de Gerenciamento de Projeto</span></div>
<header>
	<?php
	if(isset($_SESSION["login"]) && $_SESSION["tipo"] != 5 && isset($_SESSION["projeto"])){
	?>
	<span id="infoProjeto">
		Logado como <?php echo $_SESSION["nome"] ?>. <span class="cor_verde"><?php echo $_SESSION["nomeTipo"] ?></span> no projeto</div>
		<span class="cor_verde"><?php echo $_SESSION["nomeProjeto"] ?></span>
	</span>
	<?php
	}	
	?>
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
<div id="or"><a href="../">inicio</a><span>solicitar cadastro</span><a href="../" class="voltar">voltar</a></div>
<section id="conteudo">
	<h2>Confirme seus dados</h2>
	<article>
		<form id="cadastro" action="cadastro.php" method="post">
			<?php echo '
			<fieldset><legend>Informações do usuário</legend>
				<div class="form-gp"><label for="i_nome">Nome: </label> <input type="text" readonly required name="nome" id="i_nome" value="'.$nome.'" /></div>
				<div class="form-gp"><label for="i_cpf">CPF: </label><input type="text" readonly required required name="cpf" id="i_cpf" value="'.$cpf.'" /></div>
				<div class="form-gp"><label for="i_rg">RG: </label><input type="text" readonly required required name="rg" id="i_rg" value="'.$rg.'" /></div>
				<div class="form-gp"><label for="i_exp">Orgão Expedidor:</label><input readonly type="text" type="text" name="exp" value="'.$exp.'"/></div>
				<div class="form-gp"><label for="i_expdat">Data de expedição:</label><input readonly id="i_expdat" type="text" name="expdat" value="'.$expdat.'"/></div>
				<div class="form-gp"><label for="i_nasc">Data de nascimento: </label><input readonly type="text" name="nasc" id="i_nasc" value="'.$nasc.'" /></div>
				<div class="form-gp"><label for="i_nomemae">Nome do pai: </label><input type="text" readonly required name="nomepai" id="i_nomemae" value="'.$nomepai.'" /></div>
				<div class="form-gp"><label for="i_nomepai">Nome da mãe: </label><input type="text" readonly required name="nomemae" id="i_nomepai" value="'.$nomemae.'" /></div>
			</fieldset>
			<fieldset><legend>Informações do Endereço</legend>
				<div class="form-gp"><label for="i_logradouro">Logradouro: </label><input type="text" readonly required name="logradouro" id="i_logradouro" value="'.$log.'"></div>
				<div class="form-gp"><label for="i_bairro">Bairro: </label><input type="text" readonly required name="bairro" id="i_bairro" value="'.$bairro.'"></div>
				<div class="form-gp"><label for="i_num">Numero: </label><input type="text" readonly required name="num" id="i_num" value="'.$num.'"></div>
				<div class="form-gp"><label for="i_comp">Complemento: </label><input type="text" readonly required name="comp" id="i_comp" value="'.$comp.'"></div>
				<div class="form-gp"><label for="i_cep">CEP: </label><input type="text" readonly required name="cep" id="i_cep" value="'.$cep.'"></div>
			</fieldset>
			<fieldset><legend>Informações de Contato</legend>
				<div class="form-gp"><label for="i_tel">Telefone: </label><input type="text" readonly required name="tel" id="i_tel" value="'.$telefone.'"/></div>
				<div class="form-gp"><label for="i_cel">Celular: </label><input type="text" readonly required name="cel" id="i_cel" value="'.$celular.'"/></div>
			</fieldset>
			<fieldset><legend>Informações de Usuário</legend>			
				<div class="form-gp"><label for="i_email1">e-mail:</label><input readonly type="email" id="i_email1" name="email1" value="'.$email1.'" /></div>
				<input type="hidden" value="'.$senha1.'" name="senha1"/>
				<input type="hidden" value="'.$email1.'" name="email1"/>
			</fieldset>
			';
			?>
			<button onclick="javascript:history.go(-1);">alterar</button><input type="submit" value="enviar" name="confirmou" />
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