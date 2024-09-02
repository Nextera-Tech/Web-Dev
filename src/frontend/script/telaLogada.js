document.addEventListener('DOMContentLoaded', function() {
    const logoutLink = document.getElementById('botaoDeSaida');

    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link
            console.log('Logout link clicado'); // Depuração
            window.location.href = '../php/logout.php'; // Redireciona para o script de logout
        });
    } else {
        console.log('Elemento de logout não encontrado');
    }
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