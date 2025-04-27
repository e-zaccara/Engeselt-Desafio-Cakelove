<template>
  <div class="container">
    <div class="">
      <div class="d-flex flex-wrap gap-3">
        <li v-for="(produto, index) in produtos" :key="index">
          <div class="card shadow-sm">
            <img
              :src="produto.imagens[0]?.caminho"
              alt="Logo"
              style="max-width: 250px; max-height: 250px"
              class="shadow"
            />
            <div class="card-body">
              <p class="card-text">
                {{ produto.nome }}
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button
                    @click="abrirModal(produto)"
                    type="button"
                    class="btn btn-sm btn-outline-secondary"
                  >
                    Comprar
                  </button>
                </div>
                <small class="text-body-secondary"
                  >R$ {{ produto.valor }}</small
                >
              </div>
            </div>
          </div>
        </li>
      </div>
    </div>
  </div>

  <div
    class="modal fade show"
    tabindex="-1"
    style="display: block; background: rgba(0, 0, 0, 0.5)"
    v-if="showModal"
    @click.self="fecharModal"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ produtoSelecionado.nome }}</h5>
          <button type="button" class="btn-close" @click="fecharModal"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-between align-items-top">
            <div class="me-3">
              <div
                id="carouselProduto"
                class="carousel slide"
                data-bs-ride="carousel"
              >
                <div class="carousel-inner">
                  <div
                    v-for="(imagem, index) in produtoSelecionado.imagens"
                    :key="index"
                    :class="['carousel-item', { active: index === 0 }]"
                  >
                    <img
                      :src="imagem.caminho"
                      alt="Imagem Produto"
                      class="d-block"
                      style="
                        width: 250px; /* Faz com que a imagem ocupe toda a largura do carrossel */
                        height: 250px;
                        object-fit: cover; /* A imagem vai cobrir o espaço, mantendo a proporção */
                        transition: transform 0.5s ease; /* Suaviza a animação */
                      "
                    />
                  </div>
                </div>
                <button
                  class="carousel-control-prev"
                  type="button"
                  data-bs-target="#carouselProduto"
                  data-bs-slide="prev"
                >
                  <span class="carousel-control-prev-icon"></span>
                </button>
                <button
                  class="carousel-control-next"
                  type="button"
                  data-bs-target="#carouselProduto"
                  data-bs-slide="next"
                >
                  <span class="carousel-control-next-icon"></span>
                </button>
              </div>
            </div>
            <div>
              <p>
                <strong>Descrição:</strong> {{ produtoSelecionado.descricao }}
              </p>
              <p><strong>Valor:</strong> R$ {{ produtoSelecionado.valor }}</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="comprarProduto">
            Comprar
          </button>
          <button type="button" class="btn btn-secondary" @click="fecharModal">
            Fechar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      produtos: [],
      showModal: false,
      produtoSelecionado: {},
    };
  },
  mounted() {
    const el = document.getElementById("vue-pp");
    if (el) {
      const data = el.dataset.produtos;
      this.produtos = JSON.parse(data);
    }
  },
  methods: {
    abrirModal(produto) {
      this.produtoSelecionado = produto;
      this.showModal = true;
    },
    fecharModal() {
      this.showModal = false;
    },
  },
};
</script>

<style scoped>
li {
  list-style: none;
}
</style>
