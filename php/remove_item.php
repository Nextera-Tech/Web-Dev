<?php
// Configurações do banco de dados
include_once "../php/database.php";
session_start();


// Obtém o ID do item a ser removido
$id = $_POST['id'];

// Prepara a instrução SQL
$sql = "DELETE FROM itens WHERE id = ?";

// Prepara a consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // 'i' para integer

// Executa a consulta
if ($stmt->execute()) {
    echo "Item removido com sucesso!";
} else {
    echo "Erro ao remover item: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
