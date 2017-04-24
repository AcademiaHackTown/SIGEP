<?php
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || !($_SESSION['tipo'] == 3 || $_SESSION["tipo"] == 4)){
		setcookie("redirect","atividades", time() + (86400 * 30), "/");
		setcookie("redirectTipo",12, time() + (86400 * 30), "/");
		header("Location:../");
	}
	if(!isset($_SESSION["projeto"])){
		header("Location:../selectproj.php");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Tarefas</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../../_css/estilo.css">
	<script type="text/javascript" src="../../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../../_javascript/funcoes.js"></script>
    <?php echo '<script type="text/javascript">
        setInterval(attTarefas,5000);
        function attTarefas(){
            $.post("busca_tarefasTodas.php",{pessoa:'.$_SESSION["pscod"].',projeto:'.$_SESSION["projeto"].'},function(data){
                var pendentes_texto = $(".indice").first().text();
                var avaliacao_texto = $(".indice_parado_azul").first().text();
                var concluidas_texto = $(".indice_parado").first().text();
                var pendentes = "-1", avaliacao = "-1", concluidas = "-1";
                var qtd = 0;
                
                $(data).find("pendentes").each(function(){
                    qtd++;
                    if(pendentes == "-1")
                        pendentes = $(this).text();
                });
                $(data).find("avaliacao").each(function(){
                    qtd++;
                    if(avaliacao == "-1")
                        avaliacao = $(this).text();
                });
                $(data).find("concluidas").each(function(){
                    qtd++;
                    if(concluidas == "-1")
                        concluidas = $(this).text();
                });
                
                //pendentes
                if(pendentes_texto == ""){
                    if(pendentes != "-1" && pendentes != "0"){
                        $("ul#itens li:first-child br:first-child").before("<span></span>");
                        $("ul#itens li:first-child span:first-child").addClass("indice");
                        $("ul#itens li:first-child span:first-child").text(pendentes);
                    }
                }else{
                    if(pendentes != "0")
                        $("ul#itens li:first-child span.indice").text(pendentes);
                    else
                        $("ul#itens li:first-child span.indice").remove();
                }
                
                //avaliacao
                if(avaliacao_texto == ""){
                    if(avaliacao != "-1" && avaliacao != "0"){
                        $("ul#itens li").eq(1).children("br").before("<span></span>");
                        $("ul#itens li").eq(1).children("span:first-child").addClass("indice_parado_azul");
                        $("ul#itens li").eq(1).children("span.indice_parado_azul").text(avaliacao);
                    }
                }else{
                    if(avaliacao != "0")
                        $("ul#itens li").eq(1).children("span:first-child").text(avaliacao);
                    else
                        $("ul#itens li").eq(1).children("span:first-child").remove();
                }
                
                //concluidas
                if(concluidas_texto == ""){
                    if(concluidas != "-1" && concluidas != "0"){
                        $("ul#itens li").eq(2).children("br").before("<span></span>");
                        $("ul#itens li").eq(2).children("span:first-child").addClass("indice_parado");
                        $("ul#itens li").eq(2).children("span.indice_parado").text(concluidas);
                    }
                }else{
                    if(concluidas != "0")
                        $("ul#itens li").eq(2).children("span:first-child").text(concluidas);
                    else
                        $("ul#itens li").eq(2).children("span:first-child").remove();
                }
            });
        }
    </script>'; ?>
</head>
<body onload="javascript:piscar();">
<div id="bck"></div>
<div id="interface">
<div id="top_back"><img src="../../_imagens/logo_sigep.fw.png" alt="SIGEP">
<span>Sistema de Gerenciamento de Projeto</span></div>
<header>
	<span id="infoProjeto">
		Logado como <?php echo $_SESSION["nome"] ?>. <span class="cor_verde"><?php echo $_SESSION["nomeTipo"] ?></span> no projeto<br>
		<span class="cor_verde"><?php echo $_SESSION["nomeProjeto"] ?></span>
	</span>
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
<div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../">inicio</a><span>tarefas</span><a href="../" class="voltar">voltar</a></div>
<section id="conteudo">
	<?php
	$sql = "SELECT * FROM tarefas WHERE trstaint = 0 AND trpsfint = ".$_SESSION["pscod"]." AND trprfint = ".$_SESSION["projeto"]."";
	$quer = $myssql->query($sql);
	$pdt = mysqli_num_rows($quer);
	$quer->free();
	
	$sql = "SELECT * FROM tarefas WHERE trstaint = 2 AND trpsfint = ".$_SESSION["pscod"]." AND trprfint = ".$_SESSION["projeto"]."";
	$quer = $myssql->query($sql);
	$emv = mysqli_num_rows($quer);
	$quer->free();
	
	$sql = "SELECT * FROM tarefas WHERE trstaint = 1 AND trpsfint = ".$_SESSION["pscod"]." AND trprfint = ".$_SESSION["projeto"]."";
	$quer = $myssql->query($sql);
	$cc = mysqli_num_rows($quer);
	$quer->free();
	?>
	<h3 class="titulo">Suas tarefas</h3>
	<article id="submenu">
		<ul id="itens">
			<li dest="pendentes.php">Pendentes <?php if($pdt > 0) echo'<span class="indice">'.$pdt.'</span>'; ?><br><img src="../../_icones/icon_atividadePendente.png" alt="Pendentes"><span>tarefas inconcluídas</span></li>
			<li dest="emavaliacao.php">Em avaliação<?php if($emv > 0) echo'<span class="indice_parado_azul">'.$emv.'</span>'; ?><br><img src="../../_icones/icon_atividadeEmavaliacao.png" alt="Em avaliação"><span>relação das enviadas</span></li>
			<li dest="concluidas.php">Concluídos <?php if($cc > 0) echo'<span class="indice_parado">'.$cc.'</span>'; ?><br><img src="../../_icones/icon_atividadeConcluida.png" alt="Concluídos"><span>avaliadas</span></li>
			<li dest="enviar.php">Enviar<br><img src="../../_icones/icon_atividadeEnviar.png" alt="Enviar"><span>submeter tarefa</span></li>
		</ul>
	</article>	
	<div id="top" title="Ir para o topo">&#9650;</div>
</section>
<footer>
	<img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
</footer>
</div>
</body>
</html>