<?php
	session_start();
    require '../_includes/conexao.php';
	if(!isset($_SESSION["login"])) header("Location:../");
	if($_SESSION["tipo"] != 1){
		setcookie("redirect","../bolsistas/gp.php", time() + (86400 * 30), "/");
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
	<title>SIGEP - Gerenciamento de pessoas</title>
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
<div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><a href="gp.php">integrantes</a><span>editar função</span><a href="../bolsistas" class="voltar">voltar</a></div>
<section id="conteudo">
    <h3 class="titulo">Editar função de membro</h3>
	<article>
	    <?php
        
        if(isset($_POST["valida_editafuncao"])){
            $id = $_POST["id"];
            $novotipo = $_POST["novotipo"];
            
            $sql = "UPDATE pessoa_projeto SET PPTPFINT = $novotipo WHERE PPPSFINT = $id AND PPPRFINT = ".$_SESSION["projeto"];
            if($myssql->query($sql))
                echo '<div class="boaMsg"><img src="../_icones/ok.png"/>Função no projeto alterada com sucesso.<span>x</span></div>';
            else
                echo '<div class="errorMsg"><img src="../_icones/opa.png"/>Houve um erro enquanto alterávamos a função do membro. Tente novamente.<span>x</span></div>';
        }
        
        ?>
		<form action="#" method="post" id="formedifunc">
		    <fieldset><legend>Selecione abaixo</legend>
                <br><label for="i_id">Escolha o membro:</label>
		        <select name="id" id="i_id">
                    <option value="0">Selecione</option>
		            <?php
                    
                    $tipos = array(1 => "Coordenador", 2 => "Colaborador", 3 => "Bolsista - Graduacao", 4 => "Bolsista - Medio", 5 => "Adminstrador", 6 => "Aluno");
                    
                    $sql = "SELECT PSNOMCHA, PSCODINT, pessoa_projeto.PPTPFINT FROM pessoa INNER JOIN pessoa_projeto ON pessoa_projeto.PPPRFINT = ".$_SESSION["projeto"]." AND pessoa_projeto.PPPSFINT = pessoa.PSCODINT AND pessoa_projeto.PPPSFINT <> ".$_SESSION["pscod"];
                    $query = $myssql->query($sql);
                    while($p = $query->fetch_object()):
                    ?>
                    <option value="<?php echo $p->PSCODINT; ?>"><?php echo $p->PSNOMCHA; ?> (<?php echo $tipos[$p->PPTPFINT]; ?>)</option>
                    <?php
                    endwhile;
                    ?>
		        </select><br>
		        <label for="i_novotipo">Escolha a nova função:</label>
		        <select name="novotipo" id="i_novotipo">
                    <option value="1">Coordenador (além de você)</option>
                    <option value="2">Colaborador</option>
                    <option value="3">Bolsista - Graduação</option>
                    <option value="4">Bolsista - Médio</option>
                    <option value="6">Aluno</option>
		        </select>
		    </fieldset>
		    <input type="submit" name="valida_editafuncao" value="alterar">
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