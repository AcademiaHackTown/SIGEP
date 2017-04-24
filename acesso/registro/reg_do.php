<?php
session_start();
if(!isset($_POST["valida"])) header("Location:registro.php");
require_once("../../_includes/conexao.php");
$ps = $_SESSION["pscod"];
$pr = $_SESSION["projeto"];


$cont = $_POST["cont"];
$data = $_POST["data"];

$dataHoje = date("Y-m-d H:i:s");

if($dataHoje < $data){
	setcookie("ergatv","Voce nao pode registrar uma atividade em um dia que ainda não aconteceu.");
	header("Location:registro.php");
}else{
	$sql = "INSERT INTO registro_atividade VALUES (0,'$cont','$dataHoje','$data',$ps,$pr)";
	$myssql->query($sql);

	setcookie("rgatv",true);
	header("Location:registro.php");
}

?>