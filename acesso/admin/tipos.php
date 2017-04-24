<?php
if(!isset($_POST["validaAdiciona"]) && !isset($_POST["validaRemove"])) header("Location:tiposprojeto.php");
require_once("../../_includes/conexao.php");


if(isset($_POST["validaAdiciona"])){
	$tipo = $_POST["tipo"];
    $desc = $_POST["descricao"];
	$sql = "INSERT INTO tipo_projeto (TPNOMCHA,TPDESVAR) VALUES ('$tipo','$desc')";
	$myssql->query($sql);
	setcookie("adt",true, time() + (8400 * 30), "/");
    echo '<script type="text/javascript">window.location.href="tiposprojetoAdd.php";</script>';
}

if(isset($_POST["validaRemove"])){
	$tipo = $_POST["tipoR"];
	$sql = "DELETE FROM tipo_projeto WHERE TPCODINT = $tipo";
	$myssql->query($sql);
	setcookie("remv",true, time() + (8400 * 30), "/");
    echo '<script type="text/javascript">window.location.href="tiposprojetoRem.php";</script>';
}
?>