<?php
session_start();

if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 1){
	setcookie("redirect","../bolsistas/integrantes.php", time() + (86400 * 30), "/");
	setcookie("redirectTipo",1, time() + (86400 * 30), "/");
	header("Location:../acesso");
}
if(!isset($_SESSION["projeto"])) header("Location:../acesso/selectproj.php");
if(!isset($_SESSION["projetoAtivo"]) || !$_SESSION["projetoAtivo"]){
		header("Location:../acesso/coord/projeto.php");
	}
?>
<html lang="pt-br">
<head>
	<title>SIGEP</title>
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
				echo "<li><a href='../relatorios'><img src='../_icones/icon_relat.png' alt='Relatorios'/> relatorios</a></li>";
				echo "<li><a href='../acesso/logout'><img src='../_icones/icon_sair.png' alt='Sair'/> sair</a></li>";
			}
			?>
		</ul>
	</header>
	<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><a href="gp.php">integrantes</a><span>todos</span><a href="gp.php" class="voltar">voltar</a></div>
	<section id="conteudo">
		<h3 class='titulo'>Todos os Integrantes</h3>
		<article id="lista_th">
			<ul>
			<?php
			require_once("../_includes/conexao.php");
			$sql = "SELECT * FROM pessoa WHERE PSCODINT = ".$_SESSION["pscod"]."";
			$query = $myssql->query($sql);
			while($coord = $query->fetch_object()){
			?>
			<li><a href="#">&#10149; <?php echo $coord->PSNOMCHA ?></a> <span class="enf_verde">Coordenador</span><div class="extra">
				<p>Seus dados:</p>
				<ul class="clear_css">					
					<li><span>Nome:</span> <span><?php echo $coord->PSNOMCHA; ?></span></li>
					<li><span>CPF:</span> <span><?php echo $coord->PSCPFCHA; ?></span></li>
					<li><span>RG:</span> <span><?php echo $coord->PSRGCHAR; ?></span></li>
					<li><span>Endereco:</span> <span><?php echo $coord->PSRUAVCH; ?></span></li>
					<li><span>Complemento:</span> <span><?php echo $coord->PSCOMVAR; ?></span></li>
					<li><span>Nome do Pai:</span> <span><?php echo $coord->PSPAICHA; ?></span></li>
					<li><span>Nome da Mae:</span> <span><?php echo $coord->PSMAECHA; ?></span></li>
					<li><span>Telefone:</span> <span><?php echo $coord->PSTELCHA; ?></span></li>
					<li><span>Celular:</span> <span><?php echo $coord->PSCELCHA; ?></span></li>
                    <?php
                    $sql = "SELECT PPPLVCH FROM pessoa_projeto WHERE PPPSFINT = ".$_SESSION["pscod"]."";
                    $qr = $myssql->query($sql);
                    $re = $qr->fetch_object();
                    ?>
                    <li><span>Plano de trabalho: </span><span><?php echo $re->PPPLVCH; ?></span></li>
				</ul>
				</div></li>
			<?php
			}
			$query->free();
			$sql = "SELECT * FROM pessoa WHERE PSATINT = 1 AND PSTPFINT <> 5";
			$query = $myssql->query($sql);
			$qtd = 0;

			$funcao = array("","Coordenador","Colaborador","Bolsista - Graduacao","Bolsista - Medio","Adminstrador do Sistema","Aluno");
			
			while($pessoa = $query->fetch_object()){
				$pspr = "SELECT * FROM pessoa_projeto WHERE PPPSFINT = $pessoa->PSCODINT AND PPTPFINT <> 1 AND PPPRFINT = ".$_SESSION["projeto"]." ORDER BY PPCODINT ASC";
				$quer = $myssql->query($pspr);
				if(mysqli_num_rows($quer) > 0){                    
					$qtd++;
					while($pr = $quer->fetch_object()){                        
			?>			
				<li><a href="#">&#10149; <?php echo $pessoa->PSNOMCHA ?></a> <span class="enf_azul"><?php echo $funcao[$pr->PPTPFINT]; ?></span><div class="extra">
				<p>Dados do Integrante:</p>
				<ul class="clear_css">
					<li><span>Função no Projeto:</span> <span class="enf_verde"><?php echo $funcao[$pr->PPTPFINT]; ?></span></li>
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
				<div class="errorMsg"><img src="../_icones/opa.png">Nenhum integrante cadastrado no projeto.<span>x</span></div>
				<script type="text/javascript">$(".errorMsg").fadeIn(400);</script>
				<?php
			}
			?>
			</ul>
			</article>			
			<div id="top" title="Ir para o topo">&#9650;</div>
	</section>
	<footer>
		<img src="../_imagens/cnpq.jpg">	<img src="../_imagens/if.jpg">
	</footer>
</div>
</body>
</html>