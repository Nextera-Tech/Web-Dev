<?php
//ARQUIVO DE CONEXÃO COM O BANCO DE DADOS.
include_once "../php/database.php";

try{
//PEGANDO OS INPUTS DO FORMULARIO.
$name = $_POST['nome'];
$description = $_POST['description'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$sale_price = $_POST['sale_price'];

//INSERINDO NO BANCO UTILIZANDO STATMENTS E BIND PARAM.
$stmt = $conn->prepare("INSERT INTO itens (name, description, quantity, price, sale_price) VALUES (?,?,?,?,?)");

$stmt->bind_param("ssidd", $name, $description, $quantity, $price, $sale_price);
$stmt->execute();
echo "Item adicionado com sucesso!";
$stmt->close();

//POSSIVEIS MELHORIAS: VALIDAÇÕES PARA OS ITENS.

}catch(mysqli_sql_exception $e){
    echo "Erro: " . $e->getMessage();
}

?>