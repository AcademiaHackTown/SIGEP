<?php
	session_start();	
	if(!isset($_POST["valida"])) header("Location:../arquivos");
	$er = false;

	if($_FILES["arquivo"]["size"] > 2000000){
		setcookie("nenviouarquivo","Arquivo muito grande. Tamanho máximo: 2mb");
		$er = true;
		header("Location:../arquivos");
	}

	if(!$er){

		$tipo = $_POST["tipo"];

		$dir = "../../_arquivos/".$_FILES["arquivo"]["name"];
		$pasta = "../../_arquivos/";

		$extarq = pathinfo($dir,PATHINFO_EXTENSION);
		$novo_nome = "";

		if($tipo != 0){
			$novo_nome = date_format(new DateTime(),"dmYHis").$_FILES['arquivo']['name'];
		}else{
			$novo_nome = "apostila".$_SESSION["projeto"].".".$extarq;			
			if(file_exists($pasta.$novo_nome)){
				unlink($pasta.$novo_nome);
			}
		}

		if($extarq != "pdf"){
			setcookie("nenviouarquivo","Envie um arquivo com extensao .pdf");
			$er = true;
			header("Location:../arquivos");
		}

		if(!$er){			
			if(move_uploaded_file($_FILES["arquivo"]["tmp_name"], utf8_decode($pasta.$novo_nome))){
				require_once("../../_includes/conexao.php");

				if($tipo == 0){
					$sql = "SELECT ARIDINT FROM arquivos WHERE ARPRFINT = ".$_SESSION["projeto"]."";
					$q = $myssql->query($sql);
					if(mysqli_num_rows($q) <= 0){
						$sql = "INSERT INTO arquivos VALUES (0,'$novo_nome',$tipo,".$_SESSION["projeto"].",".$_SESSION["pscod"].")";
						$myssql->query($sql);
					}
				}else{
					$sql = "INSERT INTO arquivos VALUES (0,'$novo_nome',$tipo,".$_SESSION["projeto"].",".$_SESSION["pscod"].")";
					$myssql->query($sql);
				}	

				setcookie("enviouarquivo",true);
				header("Location:../arquivos");
			}
		}
	}

?>