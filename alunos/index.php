<?php
	session_start();
	require_once("../_includes/conexao.php");
	if(isset($_SESSION['login'])){
		switch($_SESSION['tipo']){
			case 1:				
				break;
			case 2:
				header("Location:../acesso/colabor");
				break;
			case 3:
				header("Location:../acesso/bolsistas");
				break;
			case 4:
				header("Location:../acesso/bolsista");
				break;
			case 5:
				header("Location:../acesso/admin");
				break;
			case 6:
				header("Location:../acesso/aluno");
				break;
			default:
				header("Location:../acesso/aluno");					
				break;
		}
	}else{
		setcookie("redirect","../alunos", time() + (86400 * 30), "/");
		setcookie("redirectTipo",1, time() + (86400 * 30), "/");
		header("Location:../acesso");
	}
	if(!isset($_SESSION["projetoAtivo"]) || !$_SESSION["projetoAtivo"]){
		header("Location:../acesso/coord/projeto.php");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Alunos cadastrados</title>
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
<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso/coord">inicio</a><span>alunos</span><a href="../acesso/coord" class="voltar">voltar</a></div>
<section id="conteudo">
	<article id="lista_th">
    <h2 class="titulo">Lista de alunos cadastrados no projeto</h2>
        <ul>
			<?php
			require_once("../_includes/conexao.php");			
			$sql = "SELECT * FROM pessoa WHERE PSATINT = 1 AND PSTPFINT <> 5";
			$query = $myssql->query($sql);
			$qtd = 0;

			$funcao = array("","Coordenador","Colaborador","Bolsista - Graduacao","Bolsista - Medio","Adminstrador do Sistema","Aluno");
			
			while($pessoa = $query->fetch_object()){
				$pspr = "SELECT * FROM pessoa_projeto WHERE PPPSFINT = $pessoa->PSCODINT AND PPTPFINT = 6 AND PPPRFINT = ".$_SESSION["projeto"]." ORDER BY PPCODINT ASC";
				$quer = $myssql->query($pspr);
				if(mysqli_num_rows($quer) > 0){                    
					$qtd++;
					while($pr = $quer->fetch_object()){                        
			?>			
				<li><a href="#">&#10149; <?php echo $pessoa->PSNOMCHA ?></a><div class="extra">
				<p>Dados do Aluno:</p>
				<ul class="clear_css">					
					<li><span>Nome:</span> <span><?php echo $pessoa->PSNOMCHA; ?></span></li>
					<li><span>CPF:</span> <span><?php echo $pessoa->PSCPFCHA; ?></span></li>
					<li><span>RG:</span> <span><?php echo $pessoa->PSRGCHAR; ?></span></li>
					<li><span>Endereco:</span> <span><?php echo $pessoa->PSRUAVCH; ?></span></li>
					<li><span>Complemento:</span> <span><?php echo $pessoa->PSCOMVAR; ?></span></li>
					<li><span>Nome do Pai:</span> <span><?php echo $pessoa->PSPAICHA; ?></span></li>
					<li><span>Nome da Mae:</span> <span><?php echo $pessoa->PSMAECHA; ?></span></li>
					<li><span>Telefone:</span> <span><?php echo $pessoa->PSTELCHA; ?></span></li>
					<li><span>Celular:</span> <span><?php echo $pessoa->PSCELCHA; ?></span></li>	
                    <li><span>Plano de Trabalho:</span> <span><?php echo $pr->PPPLVCH; ?></span></li>
				</ul>
				</div></li>			
				<?php
					}
				}
                $quer->free();
			}
			if($qtd == 0){
				?>
				<div class="errorMsg"><img src="../_icones/opa.png">Nenhum aluno cadastrado no projeto.<span>x</span></div>
				<script type="text/javascript">$(".errorMsg").fadeIn(400);</script>
				<?php
			}
			?>
			</ul>
	</article>
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../_imagens/cnpq.jpg"><img src="../_imagens/if.jpg">
</footer>
</div>
</body>
</html>