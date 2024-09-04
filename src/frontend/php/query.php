<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "database.php";

// Obtém o termo de busca da URL
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Prepara e executa a consulta SQL
$sql = $conn->prepare('SELECT id, name, description, quantity, price, sale_price FROM itens WHERE name LIKE ?');
$searchTerm = "%{$query}%";
$sql->bind_param('s', $searchTerm);
$sql->execute();

// Obtém os resultados da consulta
$result = $sql->get_result();

// Exibe os resultados em formato HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">';
        
        // Exibe a imagem se disponível
        echo '<img src="../php/getImage.php?id=' . htmlspecialchars($row['id']) . '" style="width:100px;height:100px; object-fit: cover;">';
        // Exibe outros dados do item
        echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p>Quantidade: ' . htmlspecialchars($row['quantity']) . '</p>';
        echo '<p>Preço: R$ ' . number_format($row['price'], 2, ',', '.') . '</p>';
        echo '<p>Preço de Venda: R$ ' . number_format($row['sale_price'], 2, ',', '.') . '</p>';
        
        echo '</div>';
    }
} else {
    echo '<p>Nenhum item encontrado.</p>';
}

// Fecha a conexão
$sql->close();
$conn->close();
?>
