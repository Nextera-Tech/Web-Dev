<?php
// Configurações do banco de dados
include_once "database.php";
session_start();


// Obtém o ID do item a ser removido
$name = $_POST['name'];

// Prepara a instrução SQL
$sql = "DELETE FROM itens WHERE name = ?";

// Prepara a consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name); // 'i' para integer

// Executa a consulta
if ($stmt->execute()) {
    echo "<script>
                alert('Item removido com sucesso!');
                setTimeout(function() {
                    window.location.href = '../pages/TelaLogada.php';
                }, 50);
            </script>";
} else {
    echo "Erro ao remover item: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
