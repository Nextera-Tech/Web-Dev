<?php
session_start();
error_log('Sessão antes de destruir: ' . print_r($_SESSION, true));
session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Destrói a sessão
error_log('Sessão após destruir: ' . print_r($_SESSION, true));
header('Location: ../public/index.html'); // Redireciona para a página de login
exit;
?>
