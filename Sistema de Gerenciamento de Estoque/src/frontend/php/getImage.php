<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "database.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Sanitize the input to prevent SQL injection

    // Prepara a consulta SQL para buscar a imagem
    $stmt = $conn->prepare('SELECT image FROM itens WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($imageData);
    $stmt->fetch();
    

    // Verifica se há dados da imagem
    if ($imageData) {
        // Define o tipo MIME da imagem (ajuste conforme o tipo real da imagem)
        header('Content-Type: image/jpeg'); // Ou 'image/png' para PNG, etc.
        echo $imageData;
    } else {
        echo 'Imagem não encontrada.';
    }
} else {
    echo 'ID da imagem não fornecido.';
}
$stmt->close();
$conn->close();
?>
