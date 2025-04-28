const c=document.getElementById("modalProduto");c.addEventListener("show.bs.modal",function(o){const n=o.relatedTarget.getAttribute("data-produto"),t=JSON.parse(n);document.getElementById("modalProdutoLabel").textContent=t.nome,document.getElementById("produtoDescricao").textContent=t.descricao,document.getElementById("produtoValor").textContent=t.valor;const e=document.getElementById("carouselProdutoImages");e.innerHTML="",t.imagens.forEach((d,a)=>{const r=a===0?"carousel-item active":"carousel-item";e.innerHTML+=`
    <div class="${r}">
        <img src="../${d.caminho}" class="d-block" alt="Imagem Produto" style="width: 250px; height: 250px;">
    </div>
    `})});
