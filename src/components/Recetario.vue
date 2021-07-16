<template>
  <div>
    <div class="columns is-multiline is-desktop">
      <div
        class="column is-one-third-desktop"
        v-for="(receta, i) in recetas"
        :key="i"
      >
        <tarjeta-receta :receta="receta"></tarjeta-receta>
      </div>
    </div>
  </div>
</template>
<script>
import RecetasService from "../services/RecetasService";
import TarjetaReceta from "./TarjetaReceta.vue";
export default {
  components: { TarjetaReceta },
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
      this.recetas = await RecetasService.obtenerRecetas();
      this.cargando = false;
    },
  },
};
</script>