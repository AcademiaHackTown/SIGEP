<?php
	session_start();
	if(!isset($_POST["confirmou"])){
		echo "<script>history.go(-1);</script>";
	}
	require_once("../_includes/conexao.php");
	$nome = $_POST["nome"];
	$cpf = retiraEspaco($_POST["cpf"]);
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
	$senha1 = md5($_POST["senha1"]);
	$ad = false;
	$sel = "SELECT * FROM pessoa WHERE PSCPFCHA = '$cpf'";
	$query = $myssql->query($sel);
	$er = "";
	if(mysqli_num_rows($query) > 0){
		$er = "Já existe um cadastro com este número de CPF!";
	}else{
		$sel = "INSERT INTO pessoa (PSCPFCHA,PSTPFINT,PSNOMCHA,PSRGCHAR,PSEXPCHA,PSMAECHA,PSPAICHA,PSCEPCHA,PSRUAVCH,PSNUMVCH,PSNBAVCH,PSCOMVAR,PSTELCHA,PSCELCHA,PSSENHACHA,PSEMVCH,PSATINT) VALUES ('$cpf',0,'$nome','$rg','$exp','$nomemae','$nomepai','$cep','$log',$num,'$bairro','$comp','$telefone','$celular','$senha1','$email1',0)";
		$myssql->query($sel) or trigger_error($myssql->error,E_USER_ERROR);
		$ad = true;
	}

    function retiraEspaco($str){
        $tam = strlen($str);
        $nstr = "";
        
        for($c = 0; $c < $tam; $c++){
            if($str[$c] == "-" || $str[$c] == "."){
                
            }else{
                $nstr .= $str[$c];
            }
        }
        
        return $nstr;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Cadastro</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
	<script type="text/javascript" src="../_javascript/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="../_javascript/funcoes.js"></script>
	<script type="text/javascript">function hideEr(){document.getElementById('er').style.display = 'none';}</script>
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
		Logado como <?php echo $_SESSION["nome"] ?>. <span class="cor_verde"><?php echo $_SESSION["nomeTipo"] ?></span> no projeto<br>
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
    <div id="or"><a href="../">inicio</a><a href="index.php">solicitar cadastro</a><a href="../" class="voltar">voltar</a></div>
<section id="conteudo">
	<article>
		<?php 
		if($ad){
			echo "<div class='boaMsg'><img src='../_icones/ok.png'/>Cadastro realizado com sucesso. Voce deve esperar que o adminstrador do sistema ative a sua conta.<span onclick='hideBo()'>x</span></div>";
			echo '<script type="text/javascript">$(".boaMsg").slideDown();</script>';
		}else{
			echo "<div class='errorMsg'><img src='../_icones/opa.png'/>$er<span>x</span></div>";
			echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';
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