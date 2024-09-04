<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];

    $imageData = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Prepara e executa a consulta SQL
    if ($stmt = $conn->prepare('INSERT INTO itens (name, description, quantity, price, sale_price, image) VALUES (?, ?, ?, ?, ?, ?)')) {
        $stmt->bind_param('ssddsb', $name, $description, $quantity, $price, $sale_price, $imageData);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Item adicionado com sucesso!';
            header('Location: ../pages/TelaLogada.php');
            exit(); // Certifique-se de sair após o redirecionamento
        } else {
            $_SESSION['error'] = 'Erro ao adicionar item: ' . $stmt->error;
            header('Location: ../pages/error.php'); // Redireciona para uma página de erro
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Erro na preparação da consulta: ' . $conn->error;
        header('Location: ../pages/error.php'); // Redireciona para uma página de erro
        exit();
    }
    echo $imageData;
    // Fecha a conexão
    $conn->close();
}
?>
