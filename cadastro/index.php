<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGEP - Formulario de Cadastro</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../_css/estilo.css">
	<link rel="stylesheet" type="text/css" href="../_css/cadastro.css">
	<script type="text/javascript" src="../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../_javascript/funcoes.js"></script>
	<script type="text/javascript" src="../_plugins/vanilla-masker.min.js"></script>
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
		Logado como <?php echo $_SESSION["nome"] ?>. <span class="cor_verde"><?php echo $_SESSION["nomeTipo"] ?></span> no projeto
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
	<h2>Formulário de Cadastro</h2>
	<article>
        <div class="info_cadastro_progress">
            <div class="ativa"><span class="title">Sobre você</span><br><img src="../_icones/icon_pessoa.png" alt="Icone pessoa"/><br><span class="status andamento">em andamento</span></div>
            <div><span class="title">Seu endereço</span><br><img src="../_icones/icon_map.png" alt="Icone mapa"/><br><span class="status">nenhum</span></div>
            <div><span class="title">Contato</span><br><img src="../_icones/icon_contact.png" alt="Icone contato"/><br><span class="status">nenhum</span></div>
            <div><span class="title">Informações de Usuário</span><br><img src="../_icones/icon_user.png" alt="Icone usuario"/><br><span class="status">nenhum</span></div>
        </div>
		<form id="cadastro" method="post" action="confirmacao.php" onkeypress="javascript:void(0)">
			<fieldset id="info_pessoa" class="ativo cadastro"><legend>Informações da pessoa</legend>
				<div class="form-gp"><label for="i_nome">Nome: </label> <input type="text" required name="nome" id="i_nome" placeholder="nome completo"/></div>
                <div class="form-gp"><label for="i_cpf">CPF: </label><input type="text" required name="cpf" id="i_cpf" placeholder="apenas números" max="14" /></div>
                    <div class="form-gp"><label for="i_rg">RG: </label><input type="text" required name="rg" id="i_rg" placeholder="apenas números" /></div>
                    <div class="form-gp"><label for="i_exp">Orgão Expedidor: </label><input type="text" required id="i_exp" maxlength="6" name="exp"></div>
                    <div class="form-gp"><label for="i_expdat">Data de expedição: </label><input type="date" required id="i_expdat" name="expdat" ></div>
                    <div class="form-gp"><label for="i_nasc">Data de nascimento: </label><input type="date" required name="nasc" id="i_nasc"/></div>
                    <div class="form-gp"><label for="i_nomemae">Nome do pai: </label><input type="text" required name="nomepai" id="i_nomemae" placeholder="nome completo" /></div>
                    <div class="form-gp"><label for="i_nomepai">Nome da mãe: </label><input type="text" required name="nomemae" id="i_nomepai" placeholder="nome completo" /></div>				
			</fieldset>
			<fieldset id="info_ende" class="cadastro"><legend>Informações do Endereço</legend>
                <div class="form-gp"><label for="i_cep">CEP: </label><input type="text" required id="i_cep" name="cep"></div>
                <div class="form-gp"><label for="i_logradouro">Logradouro: </label><input type="text" required name="logradouro" id="i_logradouro" placeholder="Rua, Av, Trav"></div>
                <div class="form-gp"><label for="i_bairro">Bairro: </label><input type="text" required name="bairro" id="i_bairro"></div>
                <div class="form-gp"><label for="i_num">Numero: </label><input type="text" required name="num" id="i_num"></div>
                <div class="form-gp"><label for="i_comp">Complemento: </label><input type="text" value="Nenhum" name="comp" id="i_comp"></div>
				<!-- <label for="i_est">Estado: </label>
				<select name="est" id="i_est"/>
                <option value="ac">Acre</option>
                <option value="al">Alagoas</option>
                <option value="am">Amazonas</option>
                <option value="ap">Amapá</option>
                <option value="ba">Bahia</option>
                <option value="ce">Ceará</option>
                <option value="df">Distrito Federal</option>
                <option value="es">Espírito Santo</option>
                <option value="go">Goiás</option>
                <option value="ma">Maranhão</option>
                <option value="mt">Mato Grosso</option>
                <option value="ms">Mato Grosso do Sul</option>
                <option value="mg">Minas Gerais</option>
                <option value="pa">Pará</option>
                <option value="pb">Paraíba</option>
                <option value="pr">Paraná</option>
                <option value="pe" selected>Pernambuco</option>
                <option value="pi">Piauí</option>
                <option value="rj">Rio de Janeiro</option>
                <option value="rn">Rio Grande do Norte</option>
                <option value="ro">Rondônia</option>
                <option value="rs">Rio Grande do Sul</option>
                <option value="rr">Roraima</option>
                <option value="sc">Santa Catarina</option>
                <option value="se">Sergipe</option>
                <option value="sp">São Paulo</option>
                <option value="to">Tocantins</option>
                </select> -->
			</fieldset>
			<fieldset id="info_contato" class="cadastro"><legend>Informações de Contato</legend>
                <div class="form-gp"><label for="i_tel">Telefone: </label><input type="text" required name="tel" id="i_tel" placeholder="(XX) 9999-9999" max="14"/></div>
                    <div class="form-gp"><label for="i_cel">Celular: </label><input type="text" required name="cel" id="i_cel" placeholder="(XX) 99999-9999" max="15"/></div>
			</fieldset>
			<fieldset id="info_user" class="cadastro"><legend>Informações de Usuário</legend>
				<!-- <label for="i_user">Usuário: </label><input type="text" required id="i_user" name="user" placeholder="ex.: JOSE_MARIA12" /> -->
                <div class="form-gp"><label for="i_email1">e-mail:</label><input type="email" id="i_email1" name="email1" placeholder="exemplo@site.com" /></div>
                    <div class="form-gp"><label for="i_email2">confirme o e-mail:</label><input type="text" required id="i_email2" name="email2" placeholder="" /></div>
                    <div class="form-gp"><label for="i_senha1">Senha:</label><input type="password" required id="i_senha1" name="senha1" /></div>
                    <div class="form-gp"><label for="i_senha2">Confirme a senha:</label><input type="password" required id="i_senha2" name="senha2" /></div>
			</fieldset>
            <input type="hidden" name="confirmouCadastro" value="1"/>
			<script type="text/javascript">
				VMasker(document.querySelectorAll("#i_cpf")).maskPattern("999.999.999-99");
				VMasker(document.querySelectorAll("#i_cel")).maskPattern("(99) 99999-9999");
				VMasker(document.querySelectorAll("#i_tel")).maskPattern("(99) 9999-9999");
				VMasker(document.querySelectorAll("input[type=\"date\"]")).maskPattern("99/99/9999");
			</script>
            <div class="next"><img src="../_icones/icon_next.png" alt="Próximo"></div>
		</form>
	</article>
	<div id="top" title="Ir para o topo">&#9650;</div>	
</section>
<footer>
	<img src="../_imagens/cnpq.jpg"><img src="../_imagens/if.jpg">
</footer>
</div>
</body>
</html>