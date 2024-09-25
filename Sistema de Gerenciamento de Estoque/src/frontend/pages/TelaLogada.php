<?php
session_start();
error_log('Sessão atual: ' . print_r($_SESSION, true));

// Verificar se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../public/index.html'); // Redireciona para a página de login
    exit;
}
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MixControle - Estoque</title>
    <link rel="shortcut icon" href="../assets/entrega-rapida.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/telaLogada.css">
    <link rel="stylesheet" href="../styles/mediaQueryTelaLogada.css">
    <script src="../script/telaLogada.js"> </script>
    <script src="../script/query.js"></script>
</head>
<body>
    <main>
        <div class="bloco">
            <img src="../assets/MixControleLogo.png" alt="logo do site na tela to logado">
            <ul id='funcao'>
                <img id="IconBotaoAdd" src="../assets/addItens.png" alt="Icon do botão de adicionar itens">
                <li id="botaoAddItens" onclick="showForm('addItem')"><a>Adicionar itens</a></li>

                <img id="iconRvItens" src="../assets/RvItens.png" alt=" icon do botão para remover itens do estoque">
                <li id="botaoRvItens" onclick="showForm('removeItem')"><a>Remover</a></li>

                <img id="iconEdItens" src="../assets/editItens.png" alt=" icon do botão editar itens do estoque">
                <li id="botaoEdItens" onclick="showForm('editItem')"><a>Editar</a></li>
            </ul>

            <ul id="sair">

                <img id="iconSair" src="../assets/botaoDeSair.png" alt="icon do botão de sair de sair da tela to logado">
                <li id="botaoDeSaida"><a>SAIR</a></li>

            </ul>
        </div>
            </div>
            <div class="estoque">
                <form class="div_search" onsubmit="searchProducts(event)">
                    <input type="text" id="searchQuery" placeholder="Pesquisar itens...">
                </form>
                <div id="results" class="results-container">
                    <?php include '../php/query.php'; ?>
                </div>
            </div>

    </main>
    
    <div id="modalOverlay"></div>

    <div class="container">
        
        <!-- Formulários -->
        <div id="addItem" class="form-container">
            <button class="close-btn" onclick="closeForm()">X</button>
            <h2>Adicionar Item</h2>
            
            <form action="../php/add_item.php" method="POST" enctype="multipart/form-data">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>

                <label for="quantity">Quantidade:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="price">Preço:</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <label for="sale_price">Preço de Venda:</label>
                <input type="number" id="sale_price" name="sale_price" step="0.01" required>

                <label for="image">Imagem:</label>
                <input type="file" id="image" name="image" required>

                <input type="submit" value="Adicionar Item">
            </form>
        </div>

        <div id="removeItem" class="form-container">
            <button class="close-btn" onclick="closeForm()">X</button>
            <h2>Remover Item</h2>
            <form action="../php/remove_item.php" method="POST">
                <label for="name">Nome: </label>
                <input type="text" id="name" name="name" required>
                <input type="submit" value="Remover Item">
            </form>
        </div>

        <div id="editItem" class="form-container">
            <button class="close-btn" onclick="closeForm()">X</button>
            <h2>Editar Item</h2>
            <form action="../php/edit_item.php" method="POST">

                <label for="name">Nome: </label>
                <input type="text" id="name" name="name" >

                <label for="edit_quality">Nova Quantidade: </label>
                <input type="text" id="edit_quality" name="quality">

                <label for="edit_price">Novo Preço:</label>
                <input type="number" id="edit_price" name="price" step="0.01">

                <label for="edit_sale_price">Novo Preço de Venda:</label>
                <input type="number" id="edit_sale_price" name="sale_price" step="0.01">
                <input type="submit" value="Atualizar Item">
            </form>
        </div>
    </div>
        

</body>
</html>
