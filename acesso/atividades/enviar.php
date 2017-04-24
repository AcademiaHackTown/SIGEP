<?php
	session_start();
	require_once("../../_includes/conexao.php");
	if(!isset($_SESSION['login']) || !($_SESSION['tipo'] == 3 || $_SESSION["tipo"] == 4)){
		setcookie("redirect","atividades/enviar.php", time() + (86400 * 30), "/");
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
	<title>SIGEP - Submeter tarefa</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../../_css/estilo.css">
	<link rel="stylesheet" type="text/css" href="../../_css/form.css">
	<script type="text/javascript" src="../../_javascript/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../../_javascript/funcoes.js"></script>
	<script type="text/javascript" src="../../_plugins/ckeditor/ckeditor.js"></script>
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
<div id="or"><a href="../selectproj.php">selecionar projeto</a><a href="../../">inicio</a><a href="../atividades">atividades</a><span>enviar</span><a href="../atividades" class="voltar">voltar</a></div>
<section id="conteudo">	
	<article>
        <h2 class="titulo">Área do Bolsista</h2>
		<?php
		if(isset($_POST["enviar"])){
		$atividade = $_POST["atividade"];
		$tipo = -1;
		$sql = "SELECT * FROM tarefas WHERE trcodint = ".$_POST["atividade"]."";
		$quer = $myssql->query($sql);
		while($res = $quer->fetch_object()){
			$tipo = $res->tratfint;
		}
		$falha = false;
		$quer->free();		
		if($_FILES["arquivo_atv"]["size"] == 0){
			
			$cont = $_POST["atividade_res"];
			$sql = "INSERT INTO tarefa_entrega (TETRFINT,TEPSFINT,TECONTVAR) VALUES ($atividade,".$_SESSION["pscod"].",'$cont')";
			$quer = $myssql->query($sql);
			$sql = "UPDATE tarefas SET trstaint = 2 WHERE trcodint = ".$_POST["atividade"]."";
			$quer = $myssql->query($sql);
			
		}else{
			$_UP['renomeia'] = true;
			$_UP['pasta'] = '../../_arquivos/';
			$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
			$_UP['extensoes'] = array('doc', 'docx', 'pdf');
			if(!$falha){
				$tmmp = explode('.', $_FILES['arquivo_atv']['name']);
				$extensao = strtolower(end($tmmp));
				if (array_search($extensao, $_UP['extensoes']) == false) {
				  echo '<div class="errorMsg"><img src="../../_icones/opa.png" />Apenas as seguintes extensoes são aceitas pelo sistema: .docx .doc .pdf .odt .txt <span>x</span></div>';
				  echo '<script type="text/javascript">$(".errorMsg").slideDown();</script>';
				  $falha = true;
				}
				$nome_final = "";
				if ($_UP['renomeia'] == true && !$falha){
				 	$nome_final = date_format(new DateTime(),"dmYHis").$_FILES['arquivo_atv']['name'];
				} else {
				 	$nome_final = $_FILES['arquivo_atv']['name'];
				}				
				if(!$falha){			
					if (move_uploaded_file($_FILES['arquivo_atv']['tmp_name'], utf8_decode($_UP['pasta'].$nome_final))) {
						$sql = "UPDATE tarefas SET trstaint = 2 WHERE trcodint = ".$_POST["atividade"]."";
						$quer = $myssql->query($sql);
						$sql = "INSERT INTO tarefa_entrega (TETRFINT,TEPSFINT,TEARQVAR,TECONTVAR) VALUES ($atividade,".$_SESSION["pscod"].",'".$nome_final."','".$_POST["atividade_res"]."')";
						$quer = $myssql->query($sql);
					}else{					
						echo '<div class="errorMsg"><img src="../../_icones/opa.png" />Nao foi possivel enviar o arquivo. Tente novamente.<span>x</span></div>';
					}
				}	
				?>				
				<?php
				}
				if(!$falha || !isset($falha)){
					echo "<div class='boaMsg'><img src='../../_icones/ok.png'/>Atividade enviada para avaliação.<span>x</span></div>";
					echo '<script type="text/javascript">$(".boaMsg").slideDown();</script>';
				}
			}

		}
		?>
		<form enctype="multipart/form-data" method="post" action="#" id="evAt">
			<fieldset><legend>Enviar atividade</legend>
				<br>				
				<select required="required" name="atividade" id="select_evAt">
					<option value="0">selecione</option>
					<?php
					$sql = "SELECT * FROM tarefas WHERE trstaint = 0 AND trpsfint = ".$_SESSION["pscod"]."";
					$query = $myssql->query($sql);
					while($res = $query->fetch_object()){ ?>
					<option value="<?php echo $res->trcodint; ?>" <?php if(isset($_POST["atividade"])){
						if($_POST["atividade"] == $res->trcodint){ ?>
							selected="selected"
					<?php
					}
					}?> ><?php echo $res->trtitvar; ?></option>
					<?php
					}
					$query->free();
					?>
				</select>
				<?php
				if(isset($_POST["atividade"])){
					$sql = "SELECT * FROM tarefas WHERE trcodint = ".$_POST["atividade"]."";
					$query = $myssql->query($sql);
					$res = $query->fetch_object(); ?>
					<div class="extra">		
						<p><?php echo $res->trdesvar; ?></p>
						<input type="hidden" name="atividade_tipo" <?php echo 'value="'.$res->tratfint.'"'; ?>/>
					</div>
				<?php
				}else{ ?>
					<p><span class="ast_imp">*&nbsp;</span>Selecione uma tarefa para visualizar sua descrição.</p>
				<?php
				}
				?>
			</fieldset>
			<fieldset><legend>Preenchimento da Tarefa</legend>
				<p>Selecione o arquivo para submissão da tarefa.</p>
				<input type="file" name="arquivo_atv" id="i_arquivo_atv">
				<br><br><label for="i_atividade">Conteudo da tarefa:</label>
				<textarea name="atividade_res" id="i_atividade_res" cols="105" rows="15"></textarea>
			</fieldset>
			<input type="submit" name="enviar" value="enviar">
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