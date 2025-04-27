<template>
  <div v-if="visible" class="modal-container">
    <div class="modal-content">
      <h2>
        {{ modo === "editar" ? "Editar confeitaria" : "Cadastrar confeitaria" }}
      </h2>
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <input type="hidden" name="_token" :value="csrf" />
        <input type="hidden" name="_method" value="PUT" />
        <!-- ESPECIFICA QUE O MÉTODO É PUT -->
        <input type="hidden" v-if="modo === 'editar'" name="id" :value="id" />

        <input
          v-model="nome"
          name="nome"
          type="text"
          placeholder="Nome do estabelecimento"
          required
        />
        <input
          type="text"
          v-model="ll"
          placeholder="Latitude, Longitude"
          class="form-control"
        />
        <input
          v-model="cep"
          name="cep"
          @input="buscarEndereco"
          placeholder="CEP"
          maxlength="9"
        />
        <p id="endereco">{{ endereco }}</p>
        <input type="hidden" name="endereco" :value="endereco" />
        <input
          v-model="end_numero"
          name="end_numero"
          type="text"
          placeholder="Número residencial"
          required
        />
        <input
          v-model="telefone"
          name="telefone"
          type="tel"
          placeholder="Telefone para contato"
          required
        />

        <!-- LOGO OBRIGATÓRIA, CASO ESTIVER NO MODO CADASTRO -->
        <input
          @change="handleLogoChange"
          name="logo"
          type="file"
          :required="modo === 'cadastro'"
        />

        <div class="actions">
          <button type="submit">
            {{ modo === "editar" ? "Salvar" : "Cadastrar" }}
          </button>
          <button type="button" @click="close">Fechar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      visible: false,
      modo: "cadastro", // DEFINE O MODO DO MODAL, CADASTRO OU EDIÇÃO
      id: null, // ARMAZENA O ID QUANDO FOR EDITAR
      nome: "",
      ll: "",
      cep: "",
      endereco: "",
      end_numero: "",
      telefone: "",
      logo: null, // ARMAZENAR O ARQUIVO DA LOGO, DEPENDENDO DO MODO QUE ESTIVER
    };
  },
  methods: {
    open() {
      this.visible = true;
      this.modo = "cadastro"; // RESETE PARA O CADASTRO ABRIR
      this.limparCampos(); // LIMPAR CAMPOS PARA CADASTRO
    },
    openComDados(dados) {
      this.visible = true;
      this.modo = "editar"; // ALTERAR PARA MODO EDIÇÃO
      this.id = dados.id;
      this.nome = dados.nome || "";
      this.ll = dados.ll || "";
      this.cep = dados.cep || "";
      this.endereco = dados.endereco || "";
      this.end_numero = dados.end_numero || "";
      this.telefone = dados.telefone || "";
      this.logo = dados.logo || null; // NÃO EXIBE A LOGO NO MODAL, MAS MANTÉM PARA ATUALIZAÇÃO
      this.buscarEndereco(); // PREENCHER ENDEREÇO DINAMICAMENTE SE NECESSÁRIO
    },
    close() {
      this.visible = false;
    },
    async buscarEndereco() {
      // MASCARA PARA REMOVER CARACTERES NÃO NUMERICOS
      const cepLimpo = this.cep.replace(/\D/g, "");

      if (cepLimpo.length === 8) {
        // VERIFICA SE O CEP TEM 8 DIGITOS
        try {
          const response = await fetch(
            `https://viacep.com.br/ws/${cepLimpo}/json/`
          );
          const data = await response.json();

          // VERIFICA SE A RESPOSTA CONTÉM ERRO
          if (!data.erro) {
            this.endereco = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
          } else {
            this.endereco = "CEP não encontrado.";
          }
        } catch (error) {
          console.error("Erro ao buscar endereço:", error);
          this.endereco = "Erro ao buscar endereço.";
        }
      } else {
        this.endereco = "CEP inválido.";
      }
    },
    handleLogoChange(event) {
      const file = event.target.files[0]; // PEGA O ARQUIVO SELECIONADO
      this.logo = file; // ARMAZENA O ARQUIVO NA VARIAVEL LOGO
    },
    async submitForm() {
      const formData = new FormData();
      formData.append("nome", this.nome);
      formData.append("ll", this.ll);
      formData.append("cep", this.cep);
      formData.append("endereco", this.endereco);
      formData.append("end_numero", this.end_numero);
      formData.append("telefone", this.telefone);
      if (this.logo) formData.append("logo", this.logo);

      const base = "http://localhost:8080/cakelove/public"; // (X)-> COD UGLY | ALTERAR 
      const url =
        this.modo === "editar"
          ? `${base}/minhasconfeitarias/edit/${this.id}` // (X)-> COD UGLY | ALTERAR 
          : `${base}/cadastroconfeitarias`; // (X)-> COD UGLY | ALTERAR 

      if (this.modo === "editar") {
        formData.append("_method", "PUT"); // EDIÇÃO
      }

      try {
        const response = await fetch(url, {
          method: "POST", // CADASTRO
          headers: {
            "X-CSRF-TOKEN": this.csrf,
          },
          body: formData,
        });

        const contentType = response.headers.get("Content-Type");
        let result;

        // VERIFICA A RESPOSTA JSON E TENTA TRATAR
        if (contentType && contentType.includes("application/json")) {
          result = await response.json();
          console.log("Sucesso:", result);
        } else {
          const text = await response.text();
          console.log("Resposta do servidor:", text);
          if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
        }

        window.location.reload(); // RECARREGA A PÁGINA

        this.close(); // FECHA MODAL
      } catch (error) {
        console.error("Erro ao enviar formulário:", error);
      }
    },
    limparCampos() {
      this.nome = "";
      this.ll = "";
      this.cep = "";
      this.endereco = "";
      this.end_numero = "";
      this.telefone = "";
      this.logo = null;
    },
  },
};
</script>

<style scoped>
h2 {
  color: black;
  text-align: start;
}

p {
  color: black;
  text-align: start;
}

.modal-container {
  position: fixed;
  top: 30%;
  right: 50%;
  transform: translate(50%, -50%);
  z-index: 9999;
}

.modal-content {
  background: white;
  border: 1px solid #ddd;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 300px;
}

.modal-content h2 {
  margin-bottom: 1rem;
  font-size: 1.2rem;
}

.modal-content input {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 0.5rem;
  box-sizing: border-box;
}

.actions {
  display: flex;
  justify-content: space-between;
}

.actions button {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.actions button[type="submit"] {
  background-color: #4caf50;
  color: white;
}

.actions button[type="button"] {
  background-color: #ccc;
  color: black;
}
</style>
