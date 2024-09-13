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

            //guardando o arquivo em uma variavel. reaproveitamento.
    $imageData = $_FILES['image'];
        
    if($imageData['error']){
        die("Falha ao enviar arquivo");
    }
        
    if($imageData['size'] > 2097152){
            die("Arquivo grande demais");
    }
            //guardando o caminho da imagem.
    $pasta = __DIR__ . '../upload';

    if(!is_dir($pasta)){
        mkdir($pasta, 0775, true);
    }
            //guardando o nome da imagem.
    $nome_arquivo = $imageData['name'];
            //troca o nome recebido da imagem evitando o dup de nome e segurança no banco.
    $novo_nome_arquivo = uniqid($nome_arquivo);
            //pega a extensão do arquivo enviado: jpg/jpeg/pdf/txt/etc.
    $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
        
    $image_path = $pasta . $novo_nome_arquivo . "." . $extensao;
        
            //validando as extensões do arquivo.
    if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg"){
            die("Tipo de arquivo não suportado: apenas png, jpge e jpg");
    }
    $check = move_uploaded_file($imageData["tmp_name"], $path);
    if($check){
        $conn->query("INSERT INTO itens (image_name, path) VALUES ('$nome_arquivo', '$path')") or die($conn->error);
    }
    $sql = $conn->query("SELECT * FROM arquivos") or die($conn->error);

    // Prepara e executa a consulta SQL
    if ($stmt = $conn->prepare('INSERT INTO itens (name, description, quantity, price, sale_price, image) VALUES (?, ?, ?, ?, ?, ?)')) {
        $stmt->bind_param('ssddsb', $name, $description, $quantity, $price, $sale_price, $imageData);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Item adicionado com sucesso!';
            header('Location: ../pages/TelaLogada.php');
            exit(); // Certifique-se de sair após o redirecionamento
        } else {
            $_SESSION['error'] = 'Erro ao adicionar item: ' . $stmt->error;
            header('Location: ../pages/error.php'); // Redireciona para uma página de erro
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Erro na preparação da consulta: ' . $conn->error;
        header('Location: ../pages/error.php'); // Redireciona para uma página de erro
        exit();
    }
    // Fecha a conexão
    $conn->close();
}
?>
