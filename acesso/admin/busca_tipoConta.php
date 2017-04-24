<?php

if(!isset($_POST["validaBuscaTipo"])) header("Location:alt.php");

$cod = $_POST["cod"];

$tipo = array("","Coordenador","Colaborador","Bolsista - Graduacao","Bolsista - Médio","Admistrador","Aluno");

require_once("../../_includes/conexao.php");

$sql = "SELECT PSTPFINT FROM pessoa WHERE PSCODINT = ".$cod."";

$query = $myssql->query($sql);

$res = $query->fetch_object();

echo $tipo[$res->PSTPFINT];

?>