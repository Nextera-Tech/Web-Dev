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
    $sql = $conn->prepare('INSERT INTO itens (name, description, quantity, price, sale_price, image) VALUES (?, ?, ?, ?, ?, ?)');
    $sql->bind_param('ssddsb', $name, $description, $quantity, $price, $sale_price, $imageData);
    $sql->execute();

    if ($sql->execute()) {
        echo 'Item adicionado com sucesso!';
    } else {
        echo 'Erro ao adicionar item: ' . $sql->error;
    }

    // Redireciona ou exibe uma mensagem de sucesso
    header('Location: ../pages/TelaLogada.php');
}

// Fecha a conexão
$sql->close();
$conn->close();
?>