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
        echo '<img src="' . $imagePath . '" alt="Imagem do item" style="width:70px;height:70px; object-fit: cover; margin-bottom: 0px;">';
        
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
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        #resultado{
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-style: italic; 
            padding: 10px; 
            margin-bottom: 10px;
            width: 198.87px;
            height: 210px;
            text-align: center;
            text-transform: capitalize;
            background-color: #008575;
            border-radius: 15px;
            box-shadow: 1px 1px 15px black;
        }

        #resultado > h2{
            margin-top: 0px;
            margin-bottom: 5px;
            font-size: 15pt;
            text-align: center;
        }
        #resultado > p {
            font-size: 10pt;
            margin-bottom: 0px;
            margin-top: 0px;
            text-align: justify;
        }
    </style>
</head>
</html>
