<?php
session_start();
error_log("Logout iniciado");

// Destruir todas as variáveis de sessão
$_SESSION = array();
error_log("Variáveis de sessão limpas");

// Finalmente, destruir a sessão
session_destroy();
error_log("Sessão destruída");

// Redirecionar para a página de login
header('Location: ../login.html');
exit;
?>
