<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SIGEP - Imprimir Registro de Atividades</title>
    </head>
    <body>
<?php

require '../../_includes/mpdf60/mpdf.php';
require '../../_includes/conexao.php';

$mpdf = new mpdf();
$css = file_get_contents('../../_css/imprimir.css');

$html = '';

$ps = $_SESSION["pscod"];
$sql = "SELECT * FROM registro_atividade WHERE RAPSCODINT = $ps AND RAPRFINT = ".$_SESSION["projeto"]." ORDER BY RADTEDAT DESC";

$query = $myssql->query($sql);
$qtd = mysqli_num_rows($query);

$html .= '<div class="cabecalho">';
$html .= '   <table>';
$html .= '        <tr>';
$html .= '            <td><img src="../../_imagens/logo_sigep.fw.png" style="width: 100px;" ></td>';
$html .= '            <td style="text-align: center;"><h1>Sistema de Gerenciamento de Projeto</h1></td>';
$html .= '        </tr>';
$html .= '        <tr>';
$html .= '            <td>Projeto:</td>';
$html .= '            <td>'.$_SESSION["nomeProjetoCompleto"].'</td>';
$html .= '        </tr>';
$html .= '        <tr>';
$html .= '            <td>Bolsista:</td>';
$html .= '            <td>'.$_SESSION["nomeCompleto"].'</td>';
$html .= '        </tr>';
$html .= '        <tr>';
$html .= '            <td>Coordenador:</td>';
$html .= '            <td>'.$_SESSION["nomeCoordenador"].'</td>';
$html .= '        </tr>';
$html .= '    </table>';
$html .= '</div>';
$html .= '<br><br><br>';
$html .= '<h2 style="text-align: center;">Registros de Atividades</h2>';
$html .= '<br><br>';
$html .= '        <table>';
$html .= '            <tr>';
$html .= '                <td style="text-align: center;">Data</td>';
$html .= '                <td style="text-align: center;">Conteúdo</td>';
$html .= '            </tr>';

while($res = $query->fetch_array()){
    
    $data = date_format(date_create($res["RADTEDAT"]),"d/m/Y");

    $html .= '            <tr class="c">';
    $html .= '                <td>'.$data.'</td>';
    if(strlen($res['RADTLVAR']) > 0):
        $html .= '                <td>'.$res["RADTLVAR"].'</td>';
    else:
        $html .= '                <td>'.$res["RACONTVAR"].'</td>';
    endif;
    $html .= '            </tr>';
    
}

$html .= '</table>';

$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html);
$mpdf->Output();

?>
</body>
</html>