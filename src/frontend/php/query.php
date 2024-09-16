<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "database.php";

// Obtém o termo de busca da URL
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Prepara e executa a consulta SQL
$sql = $conn->prepare('SELECT id, name, description, quantity, price, sale_price, image,image_path, image_name FROM itens WHERE name LIKE ?');
$searchTerm = "%{$query}%";
$sql->bind_param('s', $searchTerm);
$sql->execute();

// Obtém os resultados da consulta
$result = $sql->get_result();

// Exibe os resultados em formato HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div id="resultado">';
        
        // Exibe a imagem se disponível
        $imagePath = isset($row['image_path']) ? htmlspecialchars($row['image_path']) : 'default-image.png';
        echo '<img src="' . $imagePath . '" alt="Imagem do item"';
        
        // Exibe outros dados do item
        echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
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
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/queryPhp.css">
    <link rel="stylesheet" href="../styles/mediaQueryQP.css">
</head>
</html>
