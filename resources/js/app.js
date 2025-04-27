import './bootstrap'
import 'bootstrap/scss/bootstrap.scss';

import { createApp } from 'vue'
import App from './components/App.vue'
import ModalCadastro from './components/ModalCadastro.vue'
import minhasConfeitarias from './components/minhasConfeitarias.vue'
import confeitariasParceiras from './components/confeitariasParceiras.vue'
import produtosParceiros from './components/produtosParceiros.vue'

// Monta App.vue no #vue-app
const appEl = document.getElementById('vue-app')
if (appEl) {
  createApp(App).mount(appEl)
}

const mcEl = document.getElementById('vue-mc')
if (mcEl) {
  createApp(minhasConfeitarias).mount(mcEl)
}

const cpEl = document.getElementById('vue-cp')
if (cpEl) {
  createApp(confeitariasParceiras).mount(cpEl)
}

const ppEl = document.getElementById('vue-pp')
if (ppEl) {
  createApp(produtosParceiros).mount(ppEl)
}

// Monta ModalCadastro.vue no #vue-modal
const modalEl = document.getElementById('vue-modal')
if (modalEl) {
  const modalApp = createApp(ModalCadastro)  // Modifiquei de ModalLogin para ModalCadastro
  const modalInstance = modalApp.mount(modalEl)

  // Função global para abrir o modal de cadastro
  window.abrirModalLogin = () => modalInstance.open()

  // Função global para abrir o modal com dados para edição
  window.abrirModalComDados = (dados) => {
    modalInstance.openComDados(dados)  // Passando os dados da confeitaria
  }
}

if (document.getElementById('modalMapa')) {
  import('./renderMap').then((module) => {
    console.log('Mapa carregado!');
  }).catch((error) => {
    console.error('Erro ao carregar o mapa', error);
  });
}

if (document.getElementById('carouselProduto')) {
  import('./axModalCarrosel').then((module) => {
    console.log('Carousel carregado!');
  }).catch((error) => {
    console.error('Erro ao carregar o carousel', error);
  });
}



