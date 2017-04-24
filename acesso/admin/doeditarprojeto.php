<?php
	require_once("../../_includes/conexao.php");
	session_start();
	if(!isset($_SESSION['login']) || $_SESSION['tipo'] != 5){
		setcookie("redirect","admin/doeditarprojeto.php", time() + (86400 * 30), "/");
		setcookie("redirectTipo",5, time() + (86400 * 30), "/");
		header("Location:../");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Editar projeto</title>
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
		<li><a href="../../"><img src="../../_icones/icon_sobre.png" alt="Sobre"> sobre</a></li>
		<li><a href="../../"><img src="../../_icones/icon_duvidas.png" alt="Duvidas"> duvidas</a></li>
		<li><a href="../../"><img src="../../_icones/icon_contato.png" alt="Contato"> contato</a></li>
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
<div class="mask"></div>
<div id="or"><a href="../admin">inicio</a><a href="projetos.php">gerenciar projetos</a><a href="editarprojeto.php">editar projeto</a><span>selecionado</span><a href="../admin" class="voltar">voltar</a></div>
<section id="conteudo">
	<h3 class="titulo">Editar informações de projeto</h3>
	<?php
    
    if(isset($_POST["valida_editarprojeto"])){
        $titulo = strip_tags($_POST["titulo"]);
        $resumo = strip_tags($_POST["res"]);
        $palavras = strip_tags($_POST["palavras"]);
        $idcoord = $_POST["idcoord"];
        $apelido = strip_tags($_POST["apelido"]);
        $tipo = $_POST["tipo"];
        $idprojeto = $_POST["idprojeto"];
        
        $rro = array("erro" => false, "msg" => "");
        
        //Pegando ID do coordenador atual do projeto
        $sql = "SELECT prcoordint FROM projeto WHERE PRCODINT = $idprojeto";
        $idcoordatual = $myssql->query($sql)->fetch_object()->prcoordint;
        
        //Verificando se já existe registro dele na tabela pessoa_projeto (claro que tem)
        $sql = "SELECT PPCODINT FROM pessoa_projeto WHERE PPPSFINT = $idcoordatual AND PPTPFINT = 1 AND PPPRFINT = $idprojeto";
        $query = $myssql->query($sql);
        if(mysqli_num_rows($query) > 0 && $id = $query->fetch_object()->PPCODINT){
            //Deletando o registro dele na tabela pessoa_projeto
            $sql = "DELETE FROM pessoa_projeto WHERE PPCODINT = $id";
            if(!$myssql->query($sql)){
                $rro["erro"] = true;
                $rro["msg"] = "Erro ao desvincular o atual coordenador do projeto. Tente novamente mais tarde.";
            }

            //Verificando se o novo coordenador já tem vínculo com o projeto
            if(!$rro["erro"]){
                $sql = "SELECT PPCODINT FROM pessoa_projeto WHERE PPPSFINT = $idcoord AND PPPRFINT = $idprojeto";
                $query = $myssql->query($sql);                
                if(mysqli_num_rows($query) > 0 && $ppcod = $query->fetch_object()->PPCODINT){
                    //Se tiver o vínculo vai mudar para o tipo coordenador
                    $sql = "UPDATE pessoa_projeto SET PPTPFINT = 1 WHERE PPCODINT = $ppcod";
                    
                    if(!$myssql->query($sql)){
                        $rro["erro"] = true;
                        $rro["msg"] = "Houve um erro durante a definição do novo coordenador. Tente novamente mais tarde.";
                    }else{
                        //Alterando coordenador na tabela projeto
                        $sql = "UPDATE projeto SET prcoordint = $idcoord WHERE PRCODINT = $idprojeto";
                        if(!$myssql->query($sql)){
                            $rro["erro"] = true;
                            $rro["msg"] = "Houve um erro durante a definição do novo coordenador. Tente novamente mais tarde.";
                        }
                    }
                }else{
                    //Se nao tiver o vínculo será criado
                    $sql = "INSERT INTO pessoa_projeto VALUES (0, $idprojeto, $idcoord, 1, 'Nenhum plano definido.')";
                    if(!$myssql->query($sql)){
                        $rro["erro"] = true;
                        $rro["msg"] = "Houve um erro durante a definição do novo coordenador. Tente novamente mais tarde.";
                    }else{
                        //Alterando coordenador na tabela projeto
                        $sql = "UPDATE projeto SET prcoordint = $idcoord WHERE PRCODINT = $idprojeto";
                        if(!$myssql->query($sql)){
                            $rro["erro"] = true;
                            $rro["msg"] = "Houve um erro durante a definição do novo coordenador. Tente novamente mais tarde.";
                        }
                    }
                }
            }
            
            $query->free();
        }
        
        
        if(!$rro["erro"]){
            
            $sql = "UPDATE projeto SET PRTITVAR = '$titulo', PRAPEVAR = '$apelido', PRRESVAR = '$resumo', PRCHVVAR = '$palavras', prcoordint = '$idcoord', PRTPFINT = $tipo WHERE PRCODINT = $idprojeto";
            if(!$myssql->query($sql)){
                $rro["erro"] = true;
                $rro["msg"] = "Houve um erro durante a definição do novo coordenador.";
            }
        }
        
        if($rro["erro"]){
            echo "<div class='errorMsg'><img src='../../_icones/opa.png'/>".$rro["msg"]."<span>x</span></div>";
            echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';    
        }else{
            echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>Informações do projeto atualizadas com sucesso.<span     onclick='hideBo()'>x</span></div>";
            echo '<script type="text/javascript">$(".boaMsg").slideDown();</script>';
        }
    }
    
    ?>
	<article>
		<?php
		if(isset($_GET["p"])):
        $id = $_GET["p"];
        $sql = "SELECT projeto.PRAPEVAR as apelido ,projeto.PRTITVAR as titulo, projeto.PRRESVAR as resumo, projeto.PRCHVVAR as palavrasChave, projeto.prcoordint as idcoord, pessoa.PSNOMCHA as nomecoord, pessoa.PSCODINT, tipo_projeto.TPCODINT as idtipo FROM projeto INNER JOIN pessoa ON pessoa.PSCODINT = projeto.prcoordint AND projeto.PRCODINT = $id INNER JOIN tipo_projeto ON projeto.PRTPFINT = tipo_projeto.TPCODINT LIMIT 1";
        
        $p = $myssql->query($sql)->fetch_array();
        ?>
		<form id="ediproj" action="#" method="post" class="estende">
			<fieldset><legend>Detalhes</legend>
			    <input type="hidden" name="idprojeto" value="<?php echo $_GET["p"]; ?>">
				<label for="i_titulo">Título:</label><input required type="text" name="titulo" id="i_titulo" maxlength="140" value="<?php echo $p["titulo"]; ?>" /><br>
				<label for="i_res">Resumo</label><textarea cols="90" required rows="10" name="res" id="i_res"><?php echo $p["resumo"]; ?></textarea><br>
				<label for="i_palavras">Palavras Chave:</label><input required type="text" name="palavras" id="i_palavras" value="<?php echo $p["palavrasChave"]; ?>"><br>                
                <label for="i_coord">Coordenador:</label>
                <div id="divEditacoord">
                    <input required readonly type="text" name="coord" id="i_coord" value="<?php echo $p["nomecoord"]; ?>">
                    <button id="editacoord"></button>
                    <input required id="i_idcoord" name="idcoord" type="hidden" value="<?php echo $p["idcoord"]; ?>">
                </div>
                <br><label for="i_apelido">Nome curto:</label><input type="text" name="apelido" id="i_apelido" value="<?php echo $p["apelido"]; ?>">
                <br><label for="i_tipo">Tipo: </label><select name="tipo" id="i_tipo">
                    <option value="0">Selecione</option>
                    <?php 
                        $sql = "SELECT TPNOMCHA as nometipo, TPCODINT as idtipo FROM tipo_projeto WHERE TPCODINT > 0";
                        $tpinfo = $myssql->query($sql);
                        while($tp = $tpinfo->fetch_array()):
                    ?>
                    <option <?php if($p["idtipo"] === $tp["idtipo"]) echo 'selected="selected"'; ?> value="<?php echo $tp["idtipo"]; ?>"><?php echo $tp["nometipo"]; ?></option>
                    <?php
                        endwhile;
                        $tpinfo->free();
                    ?>
                </select>
                <div class="lista" id="lista-coord">
                    <ul>
                       <li>Lista de coordenadores</li>
                        <?php
                            $sql = "SELECT PSCODINT, PSNOMCHA FROM pessoa WHERE PSTPFINT = 1 AND PSATINT = 1 ORDER BY PSNOMCHA ASC";
                            $query = $myssql->query($sql);
                            while($c = $query->fetch_array()):
                        ?>
                        <li id="coord-id-<?php echo $c["PSCODINT"]; ?>"><?php echo $c["PSNOMCHA"]; ?></li>
                        <?php
                            endwhile;
                            $query->free();
                        ?>
                    </ul>
                    <button class="botao" id="botao-lista-coord"><img src="../../_icones/icon_cancel.png" alt="Fechar lista de coordenadores"> fechar</button>
                </div>                                                
            </fieldset>
            <input type="submit" name="valida_editarprojeto" value="editar">
        </form>
    <?php
        endif;
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