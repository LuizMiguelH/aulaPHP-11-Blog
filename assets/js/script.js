// Função para verificar comentários quando a página carregar
document.addEventListener('DOMContentLoaded', () => {
    // Pega todos os botões "ver mais"
    const botoesVerMais = document.querySelectorAll('.vermais');
    
    botoesVerMais.forEach(botao => {
        const postId = botao.getAttribute('data-post-id');
        const comentariosContainer = document.querySelector(`.comentarios[data-post-id="${postId}"]`);
        
        if (comentariosContainer) {
            const comentarios = comentariosContainer.querySelectorAll('.comentario');
            
            // Se não houver comentários, desabilita o botão e muda o texto
            if (comentarios.length === 0) {
                botao.textContent = 'Nenhum comentário';
                botao.disabled = true;
            }
        }
    });
});

document.addEventListener("click", (e) => {
    // Lógica para os corações
    if (e.target.classList.contains("bi-heart")) {
        e.target.style.display = "none";
        e.target.nextElementSibling.style.display = "inline-block";
    }
    
    if (e.target.classList.contains("bi-heart-fill")) {
        e.target.style.display = "none";
        e.target.previousElementSibling.style.display = "inline-block";
    }

    // Lógica para ver mais comentários
    if (e.target.classList.contains("vermais") && !e.target.disabled) {
        const postId = e.target.getAttribute("data-post-id");
        const comentariosContainer = document.querySelector(`.comentarios[data-post-id="${postId}"]`);
        const overflowContainer = comentariosContainer.parentElement;
        
        if (comentariosContainer) {
            const comentarios = comentariosContainer.querySelectorAll(".comentario");
            const todosOcultos = overflowContainer.style.display === "none" || overflowContainer.style.display === "";
            
            // Mostra/oculta o container com overflow
            overflowContainer.style.display = todosOcultos ? "block" : "none";
            
            // Mostra/oculta os comentários
            comentarios.forEach(comentario => {
                comentario.style.display = todosOcultos ? "block" : "none";
            });
            
            // Atualiza o texto do botão apenas se houver comentários
            e.target.textContent = todosOcultos ? "Ocultar comentários" : "Ver comentários";
        }
    }
});
