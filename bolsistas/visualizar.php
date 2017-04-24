h<?php
session_start();
require_once("../_includes/conexao.php");
if(!isset($_SESSION["login"])) header("Location:../");
if($_SESSION["tipo"] != 1){
    setcookie("redirect","../bolsistas/visualizar.php", time() + (86400 * 30), "/");
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
    <title>SIGEP</title>
    <meta charset="UTF-8"/>
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
    <div id="or"><a href="../acesso/selectproj.php">selecionar projeto</a><a href="../acesso">inicio</a><a href="../bolsistas">bolsistas</a><a href="Anali_atvdd.php">análise</a><span>atividades</span><a href="<?php echo $_GET["src"].".php" ?>" class="voltar">voltar</a></div>
    <section id="conteudo">
        <h3 class='titulo'>Atividades para análise </h3>
        <article>
            <?php

            $x = "";
            $sel = "SELECT trtitvar FROM tarefas WHERE trcodint = ".$_GET["id"]."";
            $q = $myssql->query($sel);
            while($r = $q->fetch_object()){
                $x = $r->trtitvar;
            }

            $sql = "SELECT * FROM tarefas WHERE trcodint = ".$_GET["id"]."";
            $quer = $myssql->query($sql);            
            $status = array(0 => "<span class=\"enf_vermelho\">pendente</span>", 1 => "<span class=\"enf_verde\">concluido</span>", 2 => "<span class=\"enf_azul\">em correcao</span>");
            while($res = $quer->fetch_object()){
                $pesq = "SELECT * FROM pessoa WHERE PSCODINT = ".$res->trpsfint."";
                $q = $myssql->query($pesq);
                $ps = $q->fetch_object();
                $nome = $ps->PSNOMCHA;
                ?>
                <div class="extra"><h3><?php echo $x; ?></h3>
                    <p><span class="destaque_extra">Data de atribuicao: </span><?php echo date_format(date_create($res->trdticha),"d/m/Y"); ?></p>
                    <p><span class="destaque_extra">Previsão de entrega: </span><?php echo date_format(date_create($res->trdtfcha),"d/m/Y"); ?></p>
                    <p><span class="destaque_extra">Descrição:</span><br><br><span class="extra_extra"><?php echo $res->trdesvar; ?></span></p>
                    <p><span class="destaque_extra">Bolsista: </span><?php echo $nome; ?></p>
                    <p><span class="destaque_extra">Status: </span><?php echo $status[$res->trstaint]; ?></p>
                    <p><span class="destaque_extra">Conteúdo recebido: </span></p>
                    <?php
                    $pesq = "SELECT TECONTVAR, TEARQVAR FROM tarefa_entrega WHERE TETRFINT = $res->trcodint";
                    $v = $myssql->query($pesq);
                    $conteudo = "";
                    $arqq = "null";
                    while($result = $v->fetch_object()){
                        $conteudo = $result->TECONTVAR;
                        $arqq = $result->TEARQVAR;
                    }
                    echo '<span class="extra_extra">'.$conteudo.'</span><br><br>';
                    ?>
                    </div>
                    <?php
                        if($arqq != ""){ ?>
                        <p><span class="destaque_extra">Arquivo recebido:</span><br><br><a class="enf_arquivo" href="../_arquivos/<?php echo $arqq; ?>" download="../_arquivos/<?php echo $arqq; ?>"><?php echo $arqq; ?><span>baixar</span></a><br><br></p>
                        <?php
                        }                        
                    if($res->trstaint != 1){
                    ?>
                    <div class="extraEx">
                        <p>Avaliacao da atividade:</p>
                        <form name="f_avaliaAtv" id="f_avaliaAtv" method="post" action="avalia.php">
                            <input type="hidden" name="atividade" value=<?php echo '"'.$res->trcodint.'"'; ?>>
                            <input type="hidden" name="src" value="<?php echo $_GET["src"].'.php'; ?>" id="i_src">
                            <input id="i_aprova" type="submit" value="aprovar" name="aprovar" class="enf_verde" style="background: #96CC00;" /><button id="mask_desap">devolver para correcao &#9661;</button> <input id="i_desaprovar" type="submit" value="devolver para correcao" name="desaprovar" class="enf_vermelho" /><br><br>
                            <label for="i_detalhes">Motivo:</label><textarea name="detalhes" id="i_detalhes" cols="70" rows="10"></textarea>
                        </form>
                    </div>
                    <?php
                    }
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