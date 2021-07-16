<template>
  <div>
    <div class="columns">
      <div class="column">
        <b-field label="Buscar receta">
          <b-input
            @keyup.native="buscar()"
            v-model="busqueda"
            placeholder="Ingresa el término de búsqueda"
            icon-right="close-circle"
            icon-right-clickable
            @icon-right-click="cancelarBusqueda()"
            :loading="cargando"
          ></b-input>
        </b-field>
      </div>
    </div>
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
import Utiles from "../services/Utiles";
export default {
  components: { TarjetaReceta },
  data: () => ({
    recetas: [],
    cargando: false,
    busqueda: "",
  }),
  async mounted() {
    await this.obtenerRecetas();
    this.buscar = Utiles.debounce(async () => {
      if (!this.busqueda) {
        await this.cancelarBusqueda();
        return;
      }
      this.cargando = true;
      this.recetas = await RecetasService.buscarRecetas(this.busqueda);
      this.cargando = false;
    }, 500);
  },
  methods: {
    async cancelarBusqueda() {
      if (!this.busqueda) return;
      this.busqueda = "";
      await this.obtenerRecetas();
    },
    async obtenerRecetas() {
      this.cargando = true;
      this.recetas = await RecetasService.obtenerRecetas();
      this.cargando = false;
    },
  },
};
</script>