<?php
date_default_timezone_set('America/Sao_Paulo');
$MySQL = array(
  'servidor' => '',    // Endereço do servidor
  'usuario' => '',          // Usuário
  'senha' => '',            // Senha
  'banco' => ''            // Nome do banco de dados
);
$myssql = new MySQLi($MySQL['servidor'], $MySQL['usuario'], $MySQL['senha'], $MySQL['banco']);

if (mysqli_connect_errno())
    trigger_error(mysqli_connect_error(), E_USER_ERROR);

?>
