<?php

#Automatização de login no banco de dados
include_once "database.php";

#Condicional para verificar se o metodo utilziado é o POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    #Inserindo os valores na nos campos relacionados a tabela
    $sql_check_email = "SELECT * FROM users WHERE email = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_email->num_rows > 0) {
        echo "Erro: o email já está cadastrado.";
        exit;
    }
    
    #Incrementando o hashing para aumentar a segunraça
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sss", $name, $email, $hashed_password);
    if ($stmt->execute()) {
        header('Location:../public/index.html ');
        exit;
    } else {
        echo "Erro ao cadastrar o usuário: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    header('Location:../public/index.html');
    exit;
}
