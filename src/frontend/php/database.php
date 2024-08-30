<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "mixcontrole";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $db_name);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
