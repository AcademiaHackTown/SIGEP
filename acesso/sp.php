<?php
session_start();
require_once("../_includes/conexao.php");

if(!isset($_POST["valida"])){
	header("Location:selectproj.php");
}

$projeto = $_POST["projeto"];

$sql = "SELECT * FROM pessoa_projeto WHERE PPPRFINT = $projeto AND PPPSFINT = ".$_SESSION["pscod"]."";
$query = $myssql->query($sql);

$tipo = 0-1;

while($r = $query->fetch_object()){$tipo = $r->PPTPFINT;}

$_SESSION["tipo"] = $tipo;
$_SESSION["projeto"] = $projeto;

$tipos = array("","Coordenador","Colaborador","Bolsista - Graduacao","Bolsista - Medio","Adminstrador","Aluno");
$_SESSION["nomeTipo"] = $tipos[$tipo];

$query->free();

$sql = "SELECT PRAPEVAR,PRTITVAR, prcoordint FROM projeto WHERE PRCODINT = $projeto";
$query = $myssql->query($sql);

$n = $query->fetch_object();

$_SESSION["nomeProjeto"] = $n->PRAPEVAR;
$_SESSION["nomeProjetoCompleto"] = $n->PRTITVAR;

//$query->free();

$sql = "SELECT PSNOMCHA FROM pessoa WHERE PSCODINT = ".$n->prcoordint;
$query2 = $myssql->query($sql);
$nnn  = "";
while($nn = $query2->fetch_object())
    $_SESSION["nomeCoordenador"] = $nn->PSNOMCHA;

$query->free();
$query2->free();

header("Location:../acesso");

?>