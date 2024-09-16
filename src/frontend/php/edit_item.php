<?php
// Configurações do banco de dados
include_once "database.php";
session_start();

// Obtém os dados do formulário
$name = $_POST['name'];
$quantity = $_POST['quantity'] ?? null;
$price = $_POST['price'] ?? null;
$sale_price = $_POST['sale_price'] ?? null;

// Constrói a instrução SQL dinâmica
$sql = "UPDATE itens SET ";
$updates = [];

if ($quantity !== null) {
    $updates[] = "quantity = ?";
}
if ($price !== null) {
    $updates[] = "price = ?";
}
if ($sale_price !== null) {
    $updates[] = "sale_price = ?";
}

$sql .= implode(", ", $updates) . " WHERE name = ?";

// Prepara a consulta
$stmt = $conn->prepare($sql);

// Verifica se a preparação foi bem-sucedida
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Faz o binding dos parâmetros
$types = '';
$values = [];

if ($quantity !== null) {
    $types .= 's';
    $values[] = $quantity;
}
if ($price !== null) {
    $types .= 'd';
    $values[] = $price;
}
if ($sale_price !== null) {
    $types .= 'd';
    $values[] = $sale_price;
}

$values[] = $name; // Adiciona o ID para o parâmetro WHERE
$types .= 's'; 

$stmt->bind_param($types, ...$values);

// Executa a consulta
if ($stmt->execute()) {
    echo "<script>
    alert('Item atualizado com sucesso!');
    window.location.href = '../pages/TelaLogada.php';
    </script>";
} else {
    echo "<script>
    alert('Erro ao atualizar item:.');
    window.location.href = ../pages/TelaLogada.php';
    </script>" . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
