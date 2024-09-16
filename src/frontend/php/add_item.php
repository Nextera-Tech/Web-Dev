<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];

    // Guardando o arquivo em uma variável para reutilização
    $imageData = $_FILES['image'];
        
    if ($imageData['error']) {
        die("Falha ao enviar arquivo");
    }
        
    if ($imageData['size'] > 2097152) {
        die("Arquivo grande demais");
    }
        
    $pasta = "../upload/";
    $nome_arquivo = $imageData['name'];
    $novo_nome_arquivo = uniqid() . '.' . strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novo_nome_arquivo;
        
    // Validando as extensões do arquivo
    $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
    if ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {            
        echo "<script>
        alert('Tipo de arquivo não suportado! Apenas png, jpeg e jpg ');
        window.location.href = '../pages/TelaLogada.php';
    </script>";
    }

    $check = move_uploaded_file($imageData["tmp_name"], $path);
    if (!$check) {
        die("Falha ao mover o arquivo para o diretório de upload.");
    }

    // Inserindo no banco de dados
    if ($stmt = $conn->prepare('INSERT INTO itens (name, quantity, price, sale_price, image_path) VALUES (?, ?, ?, ?, ?)')) {
        $stmt->bind_param('sddss', $name, $quantity, $price, $sale_price, $path);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Item adicionado com sucesso!';
            header('Location: ../pages/TelaLogada.php');
            exit();
        } else {
            $_SESSION['error'] = 'Erro ao adicionar item: ' . $stmt->error;
            header('Location: ../pages/error.php');
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Erro na preparação da consulta: ' . $conn->error;
        header('Location: ../pages/error.php');
        exit();
    }
    
    // Fecha a conexão
    $conn->close();
}
?>
