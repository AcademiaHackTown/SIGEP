<?php
	require_once("../../_includes/conexao.php");
	$conta = $_POST["conta"];
	$tipo = $_POST["tipo"];
	$sel = "UPDATE pessoa SET PSATINT = 1,PSTPFINT = $tipo WHERE PSCODINT = '$conta'";
	$myssql->query($sel) or trigger_error($myssql->error,E_USER_ERROR);
	setcookie("atsim","Conta cadastrada com sucesso!");
	header("Location:atacc.php");
	
?>