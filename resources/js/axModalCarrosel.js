const modalProduto = document.getElementById('modalProduto');
modalProduto.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const produto = button.getAttribute('data-produto');
    const produtoData = JSON.parse(produto); // Recebe o produto em formato JSON

    // Preenche as informações do modal
    document.getElementById('modalProdutoLabel').textContent = produtoData.nome;
    document.getElementById('produtoDescricao').textContent = produtoData.descricao;
    document.getElementById('produtoValor').textContent = produtoData.valor;

    // Atualiza o carrossel de imagens
    const carouselInner = document.getElementById('carouselProdutoImages');
    carouselInner.innerHTML = ''; // Limpa imagens anteriores

    produtoData.imagens.forEach((imagem, index) => {
        const itemClass = index === 0 ? 'carousel-item active' : 'carousel-item';
        carouselInner.innerHTML += `
    <div class="${itemClass}">
        <img src="../${imagem.caminho}" class="d-block" alt="Imagem Produto" style="width: 250px; height: 250px;">
    </div>
    `;
    });
});
