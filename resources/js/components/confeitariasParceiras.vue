<template>
  <div class="container">
    <div class="">
      <div class="d-flex flex-wrap gap-3">
        <li v-for="(confeitaria, index) in confeitarias" :key="index">
          <div class="card shadow-sm">
            <img
              :src="confeitaria.logo"
              alt="Logo"
              style="max-width: 250px; max-height: 250px"
              class="shadow"
            />
            <div class="card-body">
              <p class="card-text">
                {{ confeitaria.nome }}
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a
                    :href="`confeitariasparceiras/${confeitaria.id}`"
                    type="button"
                    class="btn btn-sm btn-outline-secondary"
                    >Visualizar
                  </a>
                </div>
                <small class="text-body-secondary">{{
                  confeitaria.telefone
                }}</small>
              </div>
            </div>
          </div>
        </li>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      confeitarias: [],
    };
  },
  mounted() {
    const el = document.getElementById("vue-cp");
    if (el) {
      const data = el.dataset.confeitarias;
      this.confeitarias = JSON.parse(data);
    }
  },
};
</script>

<style scoped>
li {
  list-style: none;
}
</style>
