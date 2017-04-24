<?php
session_start();
if(!isset($_POST["valida"])) header("Location:../registro");
require_once("../../_includes/conexao.php");
$ps = $_SESSION["pscod"];
$pr = $_SESSION["projeto"];


$cont = $_POST["cont"];
$data = $_POST["data"];
$dtl = $_POST["detalhes"];

$dataHoje = date("Y-m-d H:i:s");

$sql = "INSERT INTO registro_atividade VALUES (0,'$cont','$dataHoje','$data',$ps,$pr,'$dtl')";
$myssql->query($sql);

setcookie("rgatv",true);
header("Location:../registro");

?>