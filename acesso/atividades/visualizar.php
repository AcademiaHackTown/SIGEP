<?php
    session_start();
    require_once("../../_includes/conexao.php");
    if(!isset($_SESSION['login']) || !($_SESSION['tipo'] == 3 || $_SESSION["tipo"] == 4)){
        setcookie("redirect","atividades/visualizar.php", time() + (86400 * 30), "/");
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
    <title>SIGEP - Visualizar tarefa</title>
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
    <?php
        $id = isset($_GET["id"])?$_GET["id"]:0-1;
        $source = isset($_GET["src"])?$_GET["src"]:"nenhuma";
        if($source != "nenhuma") {
            ?>
            <div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../">inicio</a><a href="index.php">atividades</a><a
                    href="<?php echo $source ?>.php"><?php if($source == "emavaliacao"){echo "em avaliacao";}else{echo $source;}?></a><span>visualizar</span><a href="../atividades/<?php echo $source; ?>.php" class="voltar">voltar</a></div>
            <?php
        }else{ ?>
            <div id="or"><a href="../">inicio</a><a href="../">acesso</a><a href="index.php">tarefas</a><span>nenhuma</span></div>
        <?php
        }
    ?>
    <section id="conteudo">
        <h3 class='titulo'>Visualizar</h3>
        <article>
            <?php
            if(!isset($_GET["id"]) || !isset($_GET["src"])){
                ?>
                <div class="errorMsg"><img src="../../_icones/opa.png">Numero insuficiente de informacoes recebidas.<span>x</span></div>
            <?php
            }else{
                $sql = "SELECT * FROM tarefas WHERE trcodint = ".$id."";
                $quer = $myssql->query($sql);
                $tp = "nenhum";
                while($res = $quer->fetch_object()){                    
                    ?>
                    <div class="extra"><h3><?php echo "- ".$res->trtitvar.""; ?></h3>
                        <?php
                        $dataAt = date_format(date_create($res->trdticha),"d/m/Y");
                        $dataPrev = date_format(date_create($res->trdtfcha),"d/m/Y");
                        ?>
                        <p><span class="destaque_extra">Data de atribuicao: </span><?php echo $dataAt; ?></p>
                        <p><span class="destaque_extra">Previsao de entrega: </span><?php echo $dataPrev; ?></p>
                        <p><span class="destaque_extra">Descricao:</span><br><br><span class="extra_extra"><?php echo $res->trdesvar; 
                        ?></span></p>
                        <?php
                        if($source == "concluidas"){
                        ?>
                        <p><span class="destaque_extra">Conteudo enviado:</span><br><br>
                        <?php
                        $atve = "SELECT TEARQVAR, TECONTVAR, TETRFINT FROM tarefa_entrega WHERE TETRFINT = $id";
                        $query = $myssql->query($atve);
                        $at = $query->fetch_object();                        
                        ?>                    
                        <span class="extra_extra"><?php echo $at->TECONTVAR;?></span></p>                        
                        <?php
                        if($at->TEARQVAR != null){ ?>
                        <p><span class="destaque_extra">Arquivo enviado:</span><br><br><a class="enf_arquivo" href="../../_arquivos/<?php echo $at->TEARQVAR; ?>"><?php echo $at->TEARQVAR; ?><span>baixar</span></a><br><br></p>
                        <?php
                        }
                        ?>
                        <?php
                        }
                    }
                        ?>
                    </div>
                    <?php                
                $quer->free();
                }
            ?>            
        </article>
    </section>
    <footer>
        <img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
    </footer>
</div>
</body>
</html>