<?php
session_start();
require_once("../../_includes/conexao.php");
if(!isset($_SESSION['login'])){
    setcookie("redirect","perfil/", time() + (86400 * 30), "/");
    //setcookie("redirectTipo",12, time() + (86400 * 30), "/");
    header("Location:../");
}
if(!isset($_SESSION["projeto"])){
    header("Location:../selectproj.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SIGEP - Perfil</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="../../_css/estilo.css">
    <link rel="stylesheet" type="text/css" href="../../_css/form.css">
    <script type="text/javascript" src="../../_javascript/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="../../_javascript/funcoes.js"></script>
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
    <div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../">inicio</a><span>perfil</span><a href="../" class="voltar">voltar</a></div>
    <section id="conteudo">
        <?php

        if(isset($_COOKIE["alterouperfil"])){
            echo "<div class='boaMsg'><img src='../../_icones/ok.png'/> As informações do seu perfil foram alteradas com sucesso. Relogue para as alterações terem efeito.<span onclick='hideBo()'>x</span></div>";
            echo '<script type="text/javascript">
            $(".boaMsg").slideDown();
            </script>';
            setcookie("alterouperfil",null);
        }else{
            if(isset($_COOKIE["erroalterouperfil"])){
                echo "<div class='errorMsg'><img src='../../_icones/opa.png'/>".$_COOKIE["erroalterouperfil"]."<span>x</span></div>";
                echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';
                setcookie("erroalterouperfil",null);
            }
        }
        
        if(isset($_COOKIE["alt_voce"])){
            if($_COOKIE["alt_voce"]){
                echo "<div class='boaMsg'><img src='../../_icones/ok.png'/> As informações de endereço foram atualizadas com sucesso.<span onclick='hideBo()'>x</span></div>";
                echo '<script type="text/javascript">
                $(".boaMsg").slideDown();
                </script>';
            }else{
                echo "<div class='errorMsg'><img src='../../_icones/opa.png'/> Ocorreu um erro na atualização de suas informações. Tente novamente.<span onclick='hideBo()'>x</span></div>";
                echo '<script type="text/javascript">
                $(".errorMsg").slideDown();
                </script>';
            }
            setcookie("alt_voce",null);
            
        }
        
        if(isset($_COOKIE["alt_endereco"])){
            if($_COOKIE["alt_endereco"]){
                echo "<div class='boaMsg'><img src='../../_icones/ok.png'/> As informações de endereço foram atualizadas com sucesso.<span onclick='hideBo()'>x</span></div>";
                echo '<script type="text/javascript">
                $(".boaMsg").slideDown();
                </script>';
            }else{
                echo "<div class='errorMsg'><img src='../../_icones/opa.png'/> Ocorreu um erro na atualização de suas informações. Tente novamente.<span onclick='hideBo()'>x</span></div>";
                echo '<script type="text/javascript">
                $(".errorMsg").slideDown();
                </script>';
            }
            setcookie("alt_endereco",null);
        }
        
        if(isset($_COOKIE["alt_contato"])){
            if($_COOKIE["alt_contato"]){
                echo "<div class='boaMsg'><img src='../../_icones/ok.png'/> As informações de contato foram atualizadas com sucesso.<span onclick='hideBo()'>x</span></div>";
                echo '<script type="text/javascript">
                $(".boaMsg").slideDown();
                </script>';
            }else{
                echo "<div class='errorMsg'><img src='../../_icones/opa.png'/> Ocorreu um erro na atualização de suas informações. Tente novamente.<span onclick='hideBo()'>x</span></div>";
                echo '<script type="text/javascript">
                $(".errorMsg").slideDown();
                </script>';
            }
            setcookie("alt_contato",null);
        }
        
        if(isset($_COOKIE["errosenha"])){
            echo "<div class='errorMsg'><img src='../../_icones/opa.png'/> Senha incorreta. Tente novamente. <span onclick='hideBo()'>x</span></div>";
            echo '<script type="text/javascript">
            $(".errorMsg").slideDown();
            </script>';
            setcookie("errosenha",null);
        }

        ?>
        <h3 class="titulo">Perfil</h3>
        <div id="mask"></div>
        <div id="confirma_login">
            <form>                
                <input type="password" id="input_confirma_login" placeholder="sua senha">
            </form>
            <button id="altera" class="botao">alterar</button>
            <button id="naoaltera" class="botao">cancelar</button>
        </div>
        <?php
        require_once '../../_includes/conexao.php';
        $sql = "SELECT * FROM pessoa WHERE PSCODINT = ".$_SESSION["pscod"];
        $query = $myssql->query($sql);
        $p = $query->fetch_array();
        $query->free();
        ?>
        <article>
            <form class="p" id="form_perfil" method="post" action="altperfil.php">
                <p>Você só precisa preencher os campos que deseja alterar. Os demais campos, não preenchidos, não sofrerão alteração.</p>
                <fieldset><legend>Suas informações</legend>
                    <br><label for="i_nome">Nome:</label>
                    <input style="width: 300px;" type="text" name="nome" id="i_nome" value="<?php echo $_SESSION["nomeCompleto"];?>">
                    <br>
                    <hr>                    
                    <br><label for="i_novasenha1">Nova senha:</label>
                    <input type="password" name="novasenha1" id="i_novasenha1">
                    <br><label for="i_novasenha2">Repita a nova senha:</label>
                    <input type="password" name="novasenha2" id="i_novasenha2">
                    <br><br>
                    <hr>
                    <br><br>
                    <label>Informações sobre o projeto vinculado atual:</label>
                    <br><br>
                    <label>Nome do projeto:</label>
                    <input style="width: 300px;" type="text" value="<?php echo $_SESSION["nomeProjeto"]; ?>" readonly="readonly" >
                    <br><label>Coordenador do projeto:</label>
                    <input style="width: 300px;" type="text" value="<?php echo $_SESSION["nomeCoordenador"]; ?>" readonly="readonly" >
                </fieldset>
                <input type="submit" name="seguranca" value="alterar informações">                
            </form>
            <form class="p" id="form_sobrevoce" method="post" action="altperfil.php">
                <fieldset><legend>Informações sobre você</legend>
                    <br><label for="i_cpf">CPF (seu login no sistema):</label>
                    <input type="text" name="cpf" id="i_cpf" value="<?php echo $p["PSCPFCHA"]; ?>">
                    <br><label for="i_rg">RG:</label>
                    <input type="text" name="rg" id="i_rg" value="<?php echo $p["PSRGCHAR"]; ?>">
                    <br><label for="i_orgao">Orgão Expedidor:</label>
                    <input type="text" name="orgao" id="i_orgao" value="<?php echo $p["PSEXPCHA"]; ?>">
                    <br><label for="i_nomepai">Nome do pai:</label>
                    <input type="text" name="nomepai" id="i_nomepai" value="<?php echo $p["PSPAICHA"]; ?>">
                    <br><label for="i_nomemae">Nome da mãe:</label>
                    <input type="text" name="nomemae" id="i_nomemae" value="<?php echo $p["PSMAECHA"]; ?>">
                </fieldset>
                <input type="submit" name="voce" value="alterar informações">
            </form>
            <form class="p" id="form_endereco" method="post" action="altperfil.php">
                <fieldset><legend>Informações de endereço</legend>
                    <br><label for="i_logradouro">Logradouro:</label>
                    <input type="text" name="logradouro" id="i_logradouro" value="<?php echo $p["PSRUAVCH"] ; ?>">
                    <br><label for="i_bairro">Bairro:</label>
                    <input type="text" name="bairro" id="i_bairro" value="<?php echo $p["PSNBAVCH"]; ?>">
                    <br><label for="i_numero">Número:</label>
                    <input type="text" name="numero" id="i_numero" value="<?php echo $p["PSNUMVCH"]; ?>">
                    <br><label for="i_complemento">Complemento:</label>
                    <input type="text" name="complemento" id="i_complemento" value="<?php echo $p["PSCOMVAR"]; ?>">
                    <br><label for="i_cep">CEP:</label>
                    <input type="text" name="cep" id="i_cep" value="<?php echo $p["PSCEPCHA"]; ?>">
                </fieldset>
                <input type="submit" name="endereco" value="alterar informações">
            </form>
            <form class="p" id="form_contato" method="post" action="altperfil.php">
                <fieldset><legend>Informações de contato</legend>
                    <br><label for="i_telefone">Telefone:</label>
                    <input type="text" name="telefone" id="i_telefone" value="<?php echo $p["PSTELCHA"]; ?>">
                    <br><label for="i_celular">Celular:</label>
                    <input type="text" name="celular" id="i_celular" value="<?php echo $p["PSCELCHA"]; ?>">
                </fieldset>
                <input type="submit" name="contato" value="alterar informações">
            </form>
        </article>
        <div id="top" title="Ir para o topo">&#9650;</div>
    </section>
    <footer>
        <img src="../../_imagens/cnpq.jpg">	<img src="../../_imagens/if.jpg">
    </footer>
</div>
</body>
</html>