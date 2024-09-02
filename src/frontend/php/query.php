<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "database.php";
session_start();

$query = isset($_GET['q']) ? $_GET['q'] : '';

// Prepara e executa a consulta SQL
$sql = $conn->prepare('SELECT * FROM itens WHERE name LIKE ?');
$searchTerm = "%{$query}%";
$sql->bind_param('s', $searchTerm);
$sql->execute();

// Obtém os resultados da consulta
$result = $sql->get_result();

// Exibe os resultados em formato HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div>';
        if (!empty($row['image'])) {
            $imageData = base64_encode($row['image']);
            echo '<img src="data:image/jpeg;base64,' . $imageData . '" style="width:100px;height:100px;">';
        }
        echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p>Quantidade: ' . htmlspecialchars($row['quantity']) . '</p>';
        echo '<p>Preço: R$ ' . htmlspecialchars($row['price']) . '</p>';
        echo '<p>Preço de Venda: R$ ' . htmlspecialchars($row['sale_price']) . '</p>';
        echo '</div>';
    }
} else {
    echo 'Nenhum item encontrado.';
}

// Fecha a conexão
$sql->close();
$conn->close();
?>
