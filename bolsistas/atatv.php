<?php
	session_start();

	date_default_timezone_set("Brasil/Sao-Paulo");

	if(!isset($_POST["enviar"])) header("Location:attatv.php");
	$bolsista = $_POST["bols"];
	$atv = $_POST["tipo"];
	$entrega = $_POST["data"];
	$des = $_POST["atv"];
	$tit = $_POST["titulo"];
	//if($bolsista == "" || $bolsista == " " || $tipo == "" || $tipo == " " || $entrega == null || $des == "" || $des == " ") header("Location:attatv.php");

	$inicio = date("Y-m-d");

	require_once("../_includes/conexao.php");

	$sql = "INSERT INTO tarefas VALUES ($atv,0,'$des','$inicio','$entrega',0,$bolsista,".$_SESSION["projeto"].",'$tit')";

	$myssql->query($sql);
	setcookie("atatv",1);

	header("Location:attatv.php");
?>