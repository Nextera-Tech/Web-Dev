<?php
// Configurações do banco de dados
include_once "../php/database.php";
session_start();

// Obtém os dados do formulário
$id = $_POST['id'];
$description = $_POST['description'] ?? null;
$quality = $_POST['quality'] ?? null;
$price = $_POST['price'] ?? null;
$sale_price = $_POST['sale_price'] ?? null;

// Constrói a instrução SQL dinâmica
$sql = "UPDATE itens SET ";
$updates = [];

if ($description !== null) {
    $updates[] = "description = ?";
}
if ($quality !== null) {
    $updates[] = "quantity = ?";
}
if ($price !== null) {
    $updates[] = "price = ?";
}
if ($sale_price !== null) {
    $updates[] = "sale_price = ?";
}

$sql .= implode(", ", $updates) . " WHERE id = ?";

// Prepara a consulta
$stmt = $conn->prepare($sql);

// Verifica se a preparação foi bem-sucedida
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Faz o binding dos parâmetros
$types = '';
$values = [];

if ($description !== null) {
    $types .= 's';
    $values[] = $description;
}
if ($quality !== null) {
    $types .= 's';
    $values[] = $quality;
}
if ($price !== null) {
    $types .= 'd';
    $values[] = $price;
}
if ($sale_price !== null) {
    $types .= 'd';
    $values[] = $sale_price;
}

$values[] = $id; // Adiciona o ID para o parâmetro WHERE
$types .= 'i'; // Tipo para o ID

$stmt->bind_param($types, ...$values);

// Executa a consulta
if ($stmt->execute()) {
    echo "Item atualizado com sucesso!";
} else {
    echo "Erro ao atualizar item: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
