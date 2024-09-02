<?php
include_once "database.php";
session_start();

//Definindo a variável para realizar a busca via GET
$search = $_GET['buscar'];

//Preparar a consulta SQL
$sql = "SELECT * FROM itens WHERE name LIKE '%busca%' OR description LIKE '%busca%'";

//Verificando se há resultados
if ($result->num_rows >0) {
    //Retorna os itens como uma lista JSON
    $itens = [];
    while($row = $result->fetch_assoc()) {
        $itens[] = $row;
    }
    echo json_encode($itens);
} else {
    echo json_encode([]);
}

$conn->close();
?>