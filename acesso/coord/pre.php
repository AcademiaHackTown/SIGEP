<?php
session_start();
if(!isset($_POST["valida"])) header("Location:projeto.php");

$inicio = $_POST["dataInicio"];
$fim = $_POST["dataFim"];
$apelidoProjeto = $_POST["apelido"];
$tipo = $_POST["tipoprojeto"];

if($tipo == "" || $tipo == null){
	setcookie("prInfoF","Selecione um tipo de projeto!");
	header("Location:projeto.php");	
}

if($inicio > $fim || empty($inicio) || empty($fim)){
	setcookie("prInfoF","Preencha as datas corretamente!");
	header("Location:projeto.php");
}

require_once("../../_includes/conexao.php");

$sql = "UPDATE projeto SET PRAPEVAR = '$apelidoProjeto',PRDTIDAT = '$inicio',PRDTFDAT = '$fim',PRTPFINT = $tipo, PRSTAINT = 1 WHERE PRCODINT = ".$_SESSION["projeto"]."";
$myssql->query($sql);

$atividade = isset($_POST["atividade"])?$_POST["atividade"]:"Nenhuma atividade.";

$mes1 = isset($_POST["mes1"])?$_POST["mes1"]:null;
$mes2 = isset($_POST["mes2"])?$_POST["mes2"]:null;
$mes3 = isset($_POST["mes3"])?$_POST["mes3"]:null;
$mes4 = isset($_POST["mes4"])?$_POST["mes4"]:null;
$mes5 = isset($_POST["mes5"])?$_POST["mes5"]:null;
$mes6 = isset($_POST["mes6"])?$_POST["mes6"]:null;
$mes7 = isset($_POST["mes7"])?$_POST["mes7"]:null;
$mes8 = isset($_POST["mes8"])?$_POST["mes8"]:null;
$mes9 = isset($_POST["mes9"])?$_POST["mes9"]:null;
$mes10 = isset($_POST["mes10"])?$_POST["mes10"]:null;
$mes11 = isset($_POST["mes11"])?$_POST["mes11"]:null;
$mes12 = isset($_POST["mes12"])?$_POST["mes12"]:null;

$max = count($_POST["atividade"]);

for($c = 1; $c <= $max; $c++){
	$sql = "INSERT INTO cronograma_projeto (CPPRFINT) VALUES (".$_SESSION["projeto"].")";
	$myssql->query($sql);

	$cod = 0;
	$codAt = 0;


	$sql = "SELECT * FROM cronograma_projeto ORDER BY CPCODINT ASC";
	$q = $myssql->query($sql);
	while($x = $q->fetch_object()){
		$cod = $x->CPCODINT;		
	}
	$q->free();

	$sql = "INSERT INTO atividade VALUES (0,".$_SESSION["projeto"].",'".$atividade[$c-1]."')";
	$myssql->query($sql);

	$sql = "SELECT ATCODINT FROM atividade ORDER BY ATCODINT ASC";
	$query = $myssql->query($sql);
	while($x = $query->fetch_object()){
		$codAt = $x->ATCODINT;
	}
	$query->free();

	if(isset($mes1)){
		foreach ($mes1 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME1INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes2)){
		foreach ($mes2 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME2INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		} }
	if(isset($mes3)){
		foreach ($mes3 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME3INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes4)){
		foreach ($mes4 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME4INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes5)){
		foreach ($mes5 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME5INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes6)){
		foreach ($mes6 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME6INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes7)){
		foreach ($mes7 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME7INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;

			}
		}
	}
	if(isset($mes8)){
		foreach ($mes8 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME8INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes9)){
		foreach ($mes9 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME9INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes10)){
		foreach ($mes10 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME10INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes11)){
		foreach ($mes11 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME11INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
	if(isset($mes12)){
		foreach ($mes12 as $r) {
			if($r == $c){
				$sql = "UPDATE cronograma_projeto SET CPATFINT = $codAt, CPME12INT = 1 WHERE CPPRFINT = ".$_SESSION["projeto"]." AND CPCODINT = $cod";
				$myssql->query($sql);
				
				break 1;
			}
		}
	}
}

$_SESSION["projetoAtivo"] = true;
$_SESSION["nomeProjeto"] = $apelidoProjeto;

setcookie("prInfoT",true);

?>
<script type="text/javascript">window.location.href="../coord";</script>