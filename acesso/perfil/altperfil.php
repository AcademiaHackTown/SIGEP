<?php
session_start();

if(!isset($_POST))
    header("Location:../perfil");

require_once '../../_includes/conexao.php';

$a_senha = isset($_POST["a_senha"])?strip_tags($_POST["a_senha"]):"~";

$sql = "SELECT PSSENHACHA FROM pessoa WHERE PSSENHACHA = '".md5($a_senha)."' AND PSCODINT = ".$_SESSION["pscod"];    
$query = $myssql->query($sql);

$senhaCerta = mysqli_num_rows($query) > 0;
$query->free();

if(isset($_POST["seguranca"])){

    $novaSenha = isset($_POST["novasenha1"])?strip_tags($_POST["novasenha1"]):"~";
    $nome = isset($_POST["nome"])?strip_tags($_POST["nome"]):"~";

    if($a_senha == "")
        $a_senha = "~";

    if($novaSenha == "")
        $novaSenha = "~";

    if($nome == "")
        $nome = "~";


    if($a_senha == "~" && $novaSenha == "~" && $nome = "~"){
        setcookie("erroalterouperfil","A(s) senha(s) digitadas são inválidas. Digite corretamente para continuar");
        header("Location:../perfil");
        exit;
    }

    if($nome == "~" && $novaSenha != "~"){
        
        if($senhaCerta){
            $sql = "UPDATE pessoa SET PSSENHACHA = '".md5($novaSenha)."' WHERE PSCODINT = ".$_SESSION["pscod"];
            $myssql->query($sql);
            setcookie("alterouperfil",true);
        }else{
            setcookie("erroalterouperfil","Senha incorreta. Tente novamente.");
        }

    }elseif($nome != "~" && $novaSenha != "~"){

        if($senhaCerta){        
            $sql = "UPDATE pessoa SET PSNOMCHA = '".$nome."', PSSENHACHA = '".md5($novaSenha)."' WHERE PSCODINT = ".$_SESSION["pscod"];
            $myssql->query($sql);
            setcookie("alterouperfil",true);
        }else{
            setcookie("erroalterouperfil","Senha incorreta. Tente novamente.");
        }

    }elseif($nome != "~" && $novaSenha == "~"){

        if($senhaCerta){        
            $sql = "UPDATE pessoa SET PSNOMCHA = '".$nome."' WHERE PSCODINT = ".$_SESSION["pscod"];
            $myssql->query($sql);
            setcookie("alterouperfil",true);
        }else{
            setcookie("erroalterouperfil","Senha incorreta. Tente novamente.");
        }

    }
        
}else if(isset($_POST["voce"])){
    
    $cpf = isset($_POST["cpf"]) || $_POST["cpf"] != ""?"'".$_POST["cpf"]."'":"PSCPFCHA";
    $rg = isset($_POST["rg"]) || $_POST["rg"] != ""?"'".$_POST["rg"]."'":"PSRGCHAR";
    $orgao = isset($_POST["orgao"]) || $_POST["orgao"] != ""?"'".$_POST["orgao"]."'":"PSEXPCHA";
    $pai = isset($_POST["nomepai"]) || $_POST["nomepai"] != ""?"'".$_POST["nomepai"]."'":"PSPAICHA";
    $mae = isset($_POST["nomemae"]) || $_POST["nomemae"] != ""?"'".$_POST["nomemae"]."'":"PSMAECHA";
    
    $sql = "UPDATE pessoa SET PSCPFCHA = $cpf, PSRGCHAR = $rg, PSEXPCHA = $orgao, PSPAICHA = $pai, PSMAECHA = $mae WHERE PSCODINT = ".$_SESSION["pscod"];
    
    if($senhaCerta){
        if($myssql->query($sql))
            setcookie("alt_voce",true);
        else
            setcookie("alt_voce",false);
    }else{
        setcookie("errosenha",true);
    }
    
}else if(isset($_POST["endereco"])){
    
    $rua = isset($_POST["logradouro"]) || $_POST["logradouro"] != ""?"'".$_POST["logradouro"]."'":"PSRUAVCH";
    $bairro = isset($_POST["bairro"]) || $_POST["bairro"] != ""?"'".$_POST["bairro"]."'":"PSNBAVCH";
    $numero = isset($_POST["numero"]) || $_POST["numero"] != ""?"'".$_POST["numero"]."'":"PSNUMVCH";
    $comp = isset($_POST["complemento"]) || $_POST["complemento"]?"'".$_POST["complemento"]."'":"PSCOMVAR";
    $cep = isset($_POST["cep"]) || $_POST["cep"] != ""?"'".$_POST["cep"]."'":"PSCEPCHA";
    
    $sql = "UPDATE pessoa SET PSRUAVCH = $rua, PSNBAVCH = $bairro, PSNUMVCH = $numero, PSCOMVAR = $comp, PSCEPCHA = $cep WHERE PSCODINT = ".$_SESSION["pscod"];
    
    if($senhaCerta){
        if($myssql->query($sql))
            setcookie("alt_endereco",true);
        else
            setcookie("alt_endereco",false);
    }else{
        setcookie("errosenha",true);
    }
    
}else if(isset($_POST["contato"])){
    
    $tel = isset($_POST["telefone"]) || $_POST["telefone"] != ""?"'".$_POST["telefone"]."'":"PSTELCHA";
    $cel = isset($_POST["celular"]) || $_POST["celular"] != ""?"'".$_POST["celular"]."'":"PSCELCHA";
    
    $sql = "UPDATE pessoa SET PSTELCHA = $tel, PSCELCHA = $cel WHERE PSCODINT = ".$_SESSION["pscod"];
    
    if($senhaCerta){
        if($myssql->query($sql))
            setcookie("alt_contato",true);
        else
            setcookie("alt_contato",false);
    }else{
        setcookie("errosenha",true);
    }

}

header("Location:../perfil");

?>