<?php
	if(!isset($_POST["logar"])){
		header("Location:../acesso");
	}
	require_once("../_includes/conexao.php");
	$cpf = $_POST["cpf"];
	$senha = md5($_POST["senha"]);

	$sel = "SELECT PSCPFCHA, PSNOMCHA, PSCODINT, PSTPFINT, PSSENHACHA FROM pessoa WHERE PSCPFCHA = '$cpf' AND PSATINT = 1";
	$query = $myssql->query($sel);
	if(mysqli_num_rows($query) > 0){
		$pessoa = $query->fetch_object();
		if($pessoa->PSSENHACHA === $senha){
			session_start();
			$_SESSION['login'] = $cpf;
			$_SESSION['tipo'] = $pessoa->PSTPFINT;
			$_SESSION["pscod"] = $pessoa->PSCODINT;
			$_SESSION["nome"] = "";
            $_SESSION["nomeCompleto"] = $pessoa->PSNOMCHA;
			for($c = 0; $c <= strlen($pessoa->PSNOMCHA); $c++){
				if($pessoa->PSNOMCHA[$c] != " "){
					$_SESSION["nome"] .= $pessoa->PSNOMCHA[$c];
				}else{
					break;
				}
			}
			$_SESSION["nome"];
			if($_SESSION["tipo"] != 5){header("Location:selectproj.php");}else{
			    if(!isset($_COOKIE["redirect"])) {
                    header("Location:admin");
                }else{
                    if($_COOKIE["redirectTipo"] == 5){
                        $str = "Location:" . $_COOKIE["redirect"];
                        setcookie("redirect",null, time() - (86400 * 30), "/");
                        setcookie("redirectTipo",null, time() - (86400 * 30), "/");
                        header($str);
                    }
                }
			}
		}else{
			setcookie("erro","Senha Incorreta!");
			header("Location:../acesso");
		}
	}else{
		setcookie("erro","Usuário inválido!");
		header("Location:../acesso");
	}

?>