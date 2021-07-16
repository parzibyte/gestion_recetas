<template>
  <div>
    <div class="columns">
      <div class="column">
        <b-table :data="recetas">
          <b-table-column
            field="nombre"
            label="Nombre"
            searchable
            v-slot="props"
          >
            {{ props.row.nombre }}
          </b-table-column>
          <b-table-column
            field="descripcion"
            label="Descripción"
            searchable
            sortable
            v-slot="props"
          >
            {{ props.row.descripcion }}
          </b-table-column>
          <b-table-column
            field="porciones"
            label="Porciones"
            numeric
            sortable
            searchable
            v-slot="props"
          >
            {{ props.row.porciones }}
          </b-table-column>
          <b-table-column field="id" label="Opciones" v-slot="props">
            <b-button @click="editarReceta(props.row)" type="is-warning">
              <b-icon icon="pencil"></b-icon>
            </b-button>
            <b-button @click="eliminarReceta(props.row)" type="is-danger">
              <b-icon icon="delete"></b-icon>
            </b-button>
          </b-table-column>
        </b-table>
      </div>
    </div>
  </div>
</template>
<script>
import RecetasService from "../services/RecetasService";
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
      this.recetas = await RecetasService.obtenerRecetas();
      this.cargando = false;
    },
    editarReceta(receta) {
      console.log({ receta });
    },
    async eliminarReceta(receta) {
      if (!confirm("Seguro?")) return;
      await RecetasService.eliminarReceta(receta.id);
      await this.obtenerRecetas();
      this.$buefy.toast.open("Receta eliminada");
    },
  },
};
</script>