<?php

if(!isset($_POST["alterar"])) header("Location:alt.php");

require_once("../../_includes/conexao.php");

$tof = array("","Coordenador","Colaborador","Bolsista - Graduacao","Bolsista - Tecnico","Adminstrador do Sistema","Aluno");

$ps = $_POST["conta"];
$tipo = $_POST["tipo"];

$sql = "UPDATE pessoa SET PSTPFINT = $tipo WHERE PSCODINT = $ps";
$myssql->query($sql);

setcookie("alts","Tipo de usuario alterado para ".$tof[$tipo]."");
header("Location:alt.php");


?>