<template>
  <div class="columns">
    <div class="column" style="padding: 0; margin: 0">
      <div class="columns">
        <div class="column is-one-third">
          <foto-de-receta :receta="receta"></foto-de-receta>
        </div>
        <div class="column">
          <div class="media">
            <div class="media-content">
              <p class="title is-size-2">{{ receta.nombre }}</p>
            </div>
          </div>
          <div class="content is-medium">
            <p class="is-size-6">{{ receta.descripcion }}</p>
            <strong>Porciones&nbsp;</strong> {{ porciones }}
            <b-field
              class="oculto-impresion"
              grouped
              label="Porciones"
              message="Usted puede cambiar las porciones. La cantidad de ingredientes se ajustará"
            >
              <b-numberinput v-model="porciones"></b-numberinput>
            </b-field>
            <b-field>
              <b-button
                :loading="imprimiendo"
                class="oculto-impresion"
                @click="imprimir()"
                type="is-success is-light"
              >
                <b-icon icon="printer"></b-icon>&nbsp; Imprimir</b-button
              >
            </b-field>
          </div>
        </div>
      </div>

      <div class="content">
        <div class="columns">
          <div class="column">
            <h2 class="has-text-centered is-2">Ingredientes</h2>
            <b-field
              v-for="(ingrediente, indiceIngrediente) in receta.ingredientes"
              :key="indiceIngrediente"
            >
              <b-checkbox>{{ nombreIngrediente(ingrediente) }}</b-checkbox>
            </b-field>
          </div>
          <div class="column">
            <h2 class="has-text-centered is-2">Preparación</h2>
            <div v-for="(paso, indicePaso) in receta.pasos" :key="indicePaso">
              <b-checkbox class="mb-2">
                <strong>Paso {{ indicePaso + 1 }}</strong>
                <p>{{ paso }}</p>
              </b-checkbox>
            </div>
          </div>
        </div>
        <div class="columns" v-show="imprimiendo">
          <div class="column">
            <div class="content has-text-centered">
              <p>
                <strong>Gestión de recetas - Software de recetario </strong
                >creado y mantenido con
                <b-icon icon="heart" type="is-danger"></b-icon> por
                <a href="https://parzibyte.me/blog">Parzibyte</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Constantes from "../Constantes";
import RecetasService from "../services/RecetasService";
import FotoDeReceta from "./FotoDeReceta.vue";
export default {
  components: { FotoDeReceta },
  data: () => ({
    receta: {},
    porciones: null,
    imprimiendo: false,
  }),
  methods: {
    async imprimir() {
      this.imprimiendo = true;
      const tituloOriginal = document.title;
      document.title = "Receta de " + this.receta.nombre;
      await this.$nextTick();
      window.print();
      document.title = tituloOriginal;
      this.imprimiendo = false;
    },
    nombreIngrediente(ingrediente) {
      if (ingrediente.unidadMedida === Constantes.AL_GUSTO) {
        return `${ingrediente.nombre} ${Constantes.AL_GUSTO}`;
      } else {
        const cantidad = this.cantidadIngrediente(ingrediente.cantidad);
        return `${cantidad} ${ingrediente.unidadMedida}(s) de ${ingrediente.nombre}`;
      }
    },
    cantidadIngrediente(cantidad) {
      return ((cantidad * this.porciones) / this.receta.porciones).toFixed(1);
    },
  },
  async mounted() {
    const idReceta = this.$route.params.id;
    const receta = await RecetasService.obtenerRecetaPorId(idReceta);
    // Arreglar los pasos porque los regresa como objetos
    receta.pasos = receta.pasos.map((objetoPaso) => objetoPaso.paso);
    this.receta = receta;
    this.porciones = this.receta.porciones;
  },
};
</script>
<style >
</style>