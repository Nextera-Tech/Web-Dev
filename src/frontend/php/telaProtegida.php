<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../public/index.html'); // Redireciona para a página de login
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Protegida</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
    <a href="logout.php">Sair</a>
</body>
</html>
