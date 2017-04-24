<?php
if(!isset($_POST["desativar"])){
	echo '<sccript>window.history.go(-1);</script>';
	exit;
}
require_once("../../_includes/conexao.php");
if(!isset($_POST["desativar"]) || $_POST["conta"] == null){
	setcookie("dtnao","Numero insuficiente de informacoes recebidas.");
	header("Location:dtacc.php");
}
$ps = $_POST["conta"];

$sql = "UPDATE pessoa SET PSATINT = 0 WHERE PSCODINT = $ps";
$myssql->query($sql);

setcookie("dtsim",true);
header("Location:dtacc.php");

?>