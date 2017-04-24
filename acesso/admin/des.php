<?php
if(!isset($_POST["valida"])){
	echo '<script>window.history.go(-1);</script>';
	exit;
}
session_start();
require_once("../../_includes/conexao.php");
if(!isset($_POST["valida"])) header("Location:desproj.php");

$pr = $_POST["projeto"];

$sql = "UPDATE projeto SET PRSTAINT = 0 WHERE PRCODINT = $pr";
$myssql->query($sql);
setcookie("desOK",true);
header("Location:desproj.php");
?>