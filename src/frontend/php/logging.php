<?php
include_once "database.php";
session_start();

// Verificar se o método da solicitação é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar a consulta SQL para buscar o usuário
    $sql = "SELECT id, name, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verificar a senha
        if (password_verify($password, $user['password'])) {
            // Define as variáveis de sessão
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];

            // Redirecionamento para a página inicial
            header('Location: ../pages/telaLogada.php');
            exit;
        } else {
            echo "<script>
                alert('Senha incorreta.');
                window.location.href = '../public/index.html';
            </script>";
        }
    } else {
        echo "<script>
            alert('Conta não registrada.');
            window.location.href = '../public/index.html';
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Se o método não for POST, redireciona para a página inicial
    header('Location: ../public/index.html');
    exit;
}
?>
