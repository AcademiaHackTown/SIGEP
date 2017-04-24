<?php
	session_start();
    if(!isset($_POST)):
?>
<script type="text/javascript">window.history.go(-1);</script>
<?php
    exit;
    endif;
	require_once("../_includes/conexao.php");
	$atv = $_POST["atividade"];
	$detalhes = $_POST["detalhes"]?$_POST["detalhes"]:"";
	$acao = 0;
	$msg = "";
	echo $src = $_POST["src"];
	if(isset($_POST["aprovar"])){
		$acao = 1;
		$msg = "Atividade aprovada.";
	}elseif (!isset($_POST["aprovar"]) && isset($_POST["desaprovar"])) {
		$acao = 0;
		$msg = "Atividade enviada para correcao.";
	}else{
		header("Location:../");
	}
	setcookie("msgAcao",$msg);
	$sql = "SELECT * FROM tarefas WHERE trcodint = $atv";
	$query = $myssql->query($sql);
	$atSel = $query->fetch_object();
	$desc = $atSel->trdesvar;
	$query->free();

	$desc .= '<span class="correcao">'.$detalhes.'</span>';

	$sql = "UPDATE tarefas SET trstaint = $acao, trdesvar = '$desc' WHERE trcodint = $atv";
	$go = $myssql->query($sql);
	header("Location: $src");
?>