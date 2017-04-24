<?php

if(!isset($_POST))
    header("Location:tiposprojetoRem.php");
    
$cod = $_POST["cod"];

require_once("../../_includes/conexao.php");

$sql = "SELECT TPDESVAR FROM tipo_projeto WHERE TPCODINT = $cod LIMIT 1";
$query = $myssql->query($sql);

$resul = $query->fetch_object();

echo utf8_encode($resul->TPDESVAR);

?>