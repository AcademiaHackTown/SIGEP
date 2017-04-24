<?php
session_start();
$_SESSION["projeto"] = null;
$_SESSION["nomeProjeto"] = null;
$_SESSION["projetoAtivo"] = null;
header("Location:../selectproj.php");
?>