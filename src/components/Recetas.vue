<template>
  <div>
    <div class="columns is-multiline is-desktop">
      <div
        class="column is-one-quarter-desktop"
        v-for="(receta, i) in recetas"
        :key="i"
      >
        <div class="card">
          <div class="card-image">
            <img src="https://picsum.photos/800" alt="Placeholder image" />
          </div>
          <div class="card-content">
            <div class="media">
              <div class="media-content">
                <p class="title is-4">{{ receta.nombre }}</p>
              </div>
            </div>
            <div class="content">
              {{ receta.descripcion }}
            </div>
          </div>
          <footer class="card-footer">
            <a href="#" class="card-footer-item">Leer más...</a>
          </footer>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import HttpService from "../services/HttpService";
export default {
  data: () => ({
    recetas: [],
    cargando: false,
  }),
  async mounted() {
    await this.obtenerRecetas();
  },
  methods: {
    async obtenerRecetas() {
      this.cargando = true;
      this.recetas = await HttpService.get("/obtener_recetas.php");
      this.cargando = false;
    },
  },
};
</script>