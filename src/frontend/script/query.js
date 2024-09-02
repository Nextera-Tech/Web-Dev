document.getElementById('searchInput').addEventListener('input', function() {
    let query = this.value;

    // Verificar se a barra de pesquisa não está vazia
    if (query.length > 0) {
        // Fazer a requisição AJAX
        fetch(`../php/query.php?busca=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                let itemList = document.getElementById('itemList');
                itemList.innerHTML = ''; // Limpar a lista antes de exibir os novos itens

                // Verificar se há resultados
                if (data.length > 0) {
                    data.forEach(item => {
                        let li = document.createElement('li');
                        li.textContent = `${item.nome} - ${item.descricao}`;
                        itemList.appendChild(li);
                    });
                } else {
                    itemList.innerHTML = '<li>Nenhum item encontrado</li>';
                }
            });
    } else {
        // Se a barra de pesquisa estiver vazia, limpar a lista
        document.getElementById('itemList').innerHTML = '';
    }
});
