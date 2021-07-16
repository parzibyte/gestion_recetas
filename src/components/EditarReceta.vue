<template>
  <div>
    <div class="columns">
      <div class="column has-text-centered">
        <h4 class="is-size-4">Editando receta</h4>
      </div>
    </div>
    <div class="columns is-desktop is-multiline">
      <div class="column is-two-thirds">
        <b-field grouped>
          <b-field label="Nombre">
            <b-input
              placeholder="Nombre de la receta"
              v-model="receta.nombre"
            ></b-input>
          </b-field>
          <b-field label="Porciones">
            <b-numberinput v-model="receta.porciones"></b-numberinput>
          </b-field>
        </b-field>
        <b-field label="Descripción">
          <b-input
            expanded
            maxlength="2048"
            type="textarea"
            placeholder="Describe la receta"
            v-model="receta.descripcion"
          ></b-input>
        </b-field>
      </div>
      <div class="column is-one-third">
        <foto-de-receta :receta="receta"></foto-de-receta>
        <b-field
          message="Si no quieres reemplazar la foto, deja este campo intacto"
        >
          <b-upload v-model="foto" accept="image/png,image/jpeg">
            <span class="file-cta">
              <b-icon class="file-icon" icon="upload"></b-icon>
              <span class="file-label">{{
                foto ? foto.name : "Elige la foto para reemplazar a la actual"
              }}</span>
            </span>
          </b-upload>
        </b-field>
      </div>
      <div class="column has-text-centered">
        <h2 class="is-size-4">Ingredientes</h2>
        <table class="table is-fullwidth">
          <thead>
            <tr>
              <td>Cantidad</td>
              <td>Unidad medida</td>
              <td>Ingrediente</td>
              <td></td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(ingrediente, indice_ingrediente) in receta.ingredientes"
              :key="indice_ingrediente"
            >
              <td>
                <b-field>
                  <b-input v-model.number="ingrediente.cantidad"></b-input>
                </b-field>
              </td>
              <td>
                <b-field>
                  <b-select v-model="ingrediente.unidadMedida">
                    <option
                      v-for="(unidad, claveUnidad) in unidadesMedida"
                      :value="unidad"
                      :key="claveUnidad"
                    >
                      {{ unidad }}
                    </option>
                  </b-select>
                </b-field>
              </td>
              <td>
                <b-field>
                  <b-input
                    placeholder="Nombre de ingrediente"
                    v-model="ingrediente.nombre"
                  ></b-input>
                </b-field>
              </td>
              <td>
                <b-button
                  v-show="puedeMostrarBotonEliminarIngrediente()"
                  @click="eliminarIngrediente(indice_ingrediente)"
                  type="is-danger"
                >
                  <b-icon icon="delete"></b-icon>
                </b-button>
              </td>
              <td>
                <b-button
                  :disabled="!deberiaHabilitarBotonAgregarIngrediente()"
                  v-show="
                    puedeMostrarBotonAgregarIngrediente(indice_ingrediente)
                  "
                  @click="agregarIngrediente()"
                  type="is-info"
                  ><b-icon icon="plus"></b-icon
                ></b-button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="column is-half">
        <h2 class="is-size-4">Pasos</h2>
        <b-field
          :label="'#' + (indicePaso + 1)"
          v-for="(paso, indicePaso) in receta.pasos"
          :key="indicePaso"
        >
          <b-input v-model="receta.pasos[indicePaso]"></b-input>
          <p class="control">
            <b-button
              @click="eliminarPaso(indicePaso)"
              v-show="puedeMostrarBotonEliminarPaso()"
              type="is-danger"
            >
              <b-icon icon="delete"></b-icon>
            </b-button>
          </p>
          <p class="control">
            <b-button
              @click="agregarPaso()"
              :disabled="!deberiaHabilitarBotonAgregarPaso()"
              v-show="puedeMostrarBotonAgregarPaso(indicePaso)"
              type="is-info"
            >
              <b-icon icon="plus"></b-icon>
            </b-button>
          </p>
        </b-field>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <b-button
          @click="guardarReceta()"
          :disabled="
            !deberiaHabilitarBotonAgregarIngrediente() ||
            !deberiaHabilitarBotonAgregarPaso()
          "
          type="is-success"
          :loading="cargando"
          >Guardar</b-button
        >
        &nbsp;
        <b-button @click="volver()" type="is-primary">Volver</b-button>
      </div>
    </div>
  </div>
</template>
<script>
import RecetasService from "../services/RecetasService";
import Constantes from "../Constantes";
import FotoDeReceta from "./FotoDeReceta.vue";
export default {
  components: { FotoDeReceta },
  data: () => ({
    unidadesMedida: Constantes.UNIDADES_MEDIDA,
    cargando: false,
    receta: {
      nombre: "",
      descripcion: "",
      porciones: 1,
      ingredientes: [],
      pasos: [],
    },
    foto: null,
  }),
  methods: {
    volver() {
      this.$router.push({
        name: "Recetas",
      });
    },
    obtenerFoto() {
      if (!this.receta.foto) {
        return false;
      }
      return RecetasService.ubicacionFoto(this.receta.foto);
    },
    limpiarFormulario() {
      this.receta = {
        nombre: "",
        descripcion: "",
        porciones: 1,
        ingredientes: [],
        pasos: [],
      };
      this.agregarPaso();
      this.agregarIngrediente();
      this.foto = null;
    },
    eliminarPaso(indice) {
      this.receta.pasos.splice(indice, 1);
    },
    eliminarIngrediente(indice) {
      this.receta.ingredientes.splice(indice, 1);
    },
    agregarPaso() {
      this.receta.pasos.push("");
    },
    agregarIngrediente() {
      this.receta.ingredientes.push({
        nombre: "",
        cantidad: 1,
        unidadMedida: this.unidadesMedida[0],
      });
    },
    puedeMostrarBotonEliminarIngrediente() {
      if (this.receta.ingredientes.length <= 1) {
        return false;
      } else {
        return true;
      }
    },
    deberiaHabilitarBotonAgregarIngrediente() {
      if (this.receta.ingredientes.length <= 0) return false;
      const ultimoIngrediente =
        this.receta.ingredientes[this.receta.ingredientes.length - 1];
      return (
        ultimoIngrediente.nombre &&
        ultimoIngrediente.cantidad &&
        ultimoIngrediente.unidadMedida
      );
    },
    puedeMostrarBotonAgregarIngrediente(indice_ingrediente) {
      const esElUltimoIngrediente =
        indice_ingrediente === this.receta.ingredientes.length - 1;
      if (this.receta.ingredientes.length <= 0 || esElUltimoIngrediente) {
        return true;
      } else {
        return false;
      }
    },
    puedeMostrarBotonEliminarPaso() {
      if (this.receta.pasos.length <= 1) {
        return false;
      } else {
        return true;
      }
    },
    deberiaHabilitarBotonAgregarPaso() {
      if (this.receta.pasos.length <= 0) return false;
      if (this.receta.pasos[this.receta.pasos.length - 1]) {
        return true;
      } else {
        return false;
      }
    },
    puedeMostrarBotonAgregarPaso(indicePaso) {
      const esElUltimoPaso = indicePaso === this.receta.pasos.length - 1;
      if (this.receta.pasos.length <= 0 || esElUltimoPaso) {
        return true;
      } else {
        return false;
      }
    },
    async guardarReceta() {
      this.cargando = true;
      const respuesta = await RecetasService.actualizarReceta(
        this.receta,
        this.foto
      );
      if (respuesta) {
        this.$buefy.toast.open("Receta guardada");
        this.limpiarFormulario();
        this.$router.push({
          name: "Recetas",
        });
      } else {
        this.$buefy.toast.open("Error guardando receta");
      }
      this.cargando = false;
    },
  },
  async mounted() {
    const idReceta = this.$route.params.id;
    const receta = await RecetasService.obtenerRecetaPorId(idReceta);
    // Arreglar los pasos porque los regresa como objetos
    receta.pasos = receta.pasos.map((objetoPaso) => objetoPaso.paso);
    this.receta = receta;
  },
};
</script>