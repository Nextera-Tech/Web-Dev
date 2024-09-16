async function searchProducts(event) {
    event.preventDefault(); // Previne o comportamento padrão de submit do formulário
    const query = document.getElementById('searchQuery').value;
    console.log("Searching for:", query); // Adicione este log para depuração
    const response = await fetch(`../php/query.php?q=${encodeURIComponent(query)}`);
    const resultsHtml = await response.text();
    console.log("Results HTML:", resultsHtml); // Adicione este log para depuração
    document.getElementById('results').innerHTML = resultsHtml;}