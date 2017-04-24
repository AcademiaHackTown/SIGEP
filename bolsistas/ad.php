<?php
	session_start();
	if(!isset($_POST["valida"])) header("Location:addm.php");
	require_once("../_includes/conexao.php");

	$cod = $_GET["nome"];
	$tipo = $_GET["tipo"];
	$plano = $_GET["plano"];
	
	echo $sel = "INSERT INTO pessoa_projeto VALUES (0,".$_SESSION["projeto"].",$cod,$tipo,'$plano')";
	$myssql->query($sel);	

	setcookie("ok","ok");
	header("Location:addm.php");
?>