document.getElementById('botaoDeSaida').addEventListener('click', function() {
    // Redireciona para o script de logout
    window.location.href = '../php/logout.php';
});

function showForm(formId) {
    // Esconde todos os formulários
    var forms = document.querySelectorAll('.form-container');
    var overlay = document.getElementById('modalOverlay');
    forms.forEach(function(form) {
        form.classList.remove('active');
    });

    // Exibe o formulário selecionado
    var activeForm = document.getElementById(formId);
    if (activeForm) {
        activeForm.classList.add('active');
    }

    // Exibe a sobreposição
    overlay.classList.add('active');
}

function closeForm() {
    var forms = document.querySelectorAll('.form-container');
    var overlay = document.getElementById('modalOverlay');
    forms.forEach(function(form) {
        form.classList.remove('active');
    });
    overlay.classList.remove('active');
}