<?php
include_once "database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * , name, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Define as variáveis de sessão
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            // Redirecionamento para a página inicial
            header('Location: ../Html/segundaParte2.html');
            exit;
        }  else {
            echo "<script>
                alert('Senha incorreta.');
                setTimeout(function() {
                    window.location.href = '../login.html';
                }, 50);
            </script>";
        }
        
    } else {
        echo "<script>
        alert('Conta não registrada');
        setTimeout(function() {
            window.location.href = '../login.html';
        }, 50);
    </script>";
    }    
    $stmt->close();
    $conn->close();
} else {
    // Caso não o metodo não seja POST, então retorna para a página inicial em logoff
    header('Location: ../login.html');
    exit;
}

?>


