<?php
	session_start();
	if(!isset($_POST["valida"])) header("Location:altprojeto.php");
	require_once("../../_includes/conexao.php");
	$titulo = isset($_POST["tit"])?strip_tags($_POST["tit"]):"Projeto sem titulo definido";
	$resumo = isset($_POST["res"])?strip_tags($_POST["res"]):"Projeto sem resumo";
	$palavras = isset($_POST["palavras"])?strip_tags($_POST["palavras"]):"Projeto sem palavras chave";
	$dataI = $_POST["dataInicio"];
	$dataF = $_POST["dataFim"];
	$titc = isset($_POST["titc"])?strip_tags($_POST["titc"]):"Projeto sem titulo curto";

	$resumo = trim(strip_tags($resumo));

	$sql = "UPDATE projeto SET PRTITVAR = '$titulo',PRAPEVAR = '$titc',PRRESVAR = '$resumo',PRCHVVAR = '$palavras',PRDTIDAT = '$dataI', PRDTFDAT = '$dataF' WHERE PRCODINT = ".$_SESSION["projeto"]."";
	$myssql->query($sql);
	setcookie("altprt",true);
	$_SESSION["nomeProjeto"] = $titc;


?>
<script type="text/javascript">window.location.href="altprojeto.php"</script>