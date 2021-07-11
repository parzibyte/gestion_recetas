<template>
  <div>
    <div class="columns">
      <div class="column">
        <b-field grouped>
          <b-field label="Nombre">
            <b-input v-model="receta.nombre"></b-input>
          </b-field>
          <b-field label="Porciones">
            <b-numberinput v-model="receta.porciones"></b-numberinput>
          </b-field>
        </b-field>
        <b-field label="Descripción">
          <b-input
            maxlength="2048"
            type="textarea"
            v-model="receta.descripcion"
          ></b-input>
        </b-field>
      </div>
      <div class="column has-text-centered">
        <h2 class="is-size-4">Ingredientes</h2>
        <table class="table is-fullwidth">
          <thead>
            <tr>
              <td>Cantidad</td>
              <td>Unidad medida</td>
              <td>Nombre</td>
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
                  <b-input v-model="ingrediente.nombre"></b-input>
                </b-field>
              </td>
              <td>
                <b-button
                  v-show="puedeMostrarBotonEliminarIngrediente()"
                  @click="eliminarIngrediente(indice_ingrediente)"
                  type="is-danger"
                  >D</b-button
                >
              </td>
              <td>
                <b-button
                  :disabled="!deberiaHabilitarBotonAgregarIngrediente()"
                  v-show="
                    puedeMostrarBotonAgregarIngrediente(indice_ingrediente)
                  "
                  @click="agregarIngrediente()"
                  type="is-info"
                  >+</b-button
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="column">
        <h2 class="is-size-4 has-text-centered">Pasos</h2>
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
              >D</b-button
            >
          </p>
          <p class="control">
            <b-button
              @click="agregarPaso()"
              :disabled="!deberiaHabilitarBotonAgregarPaso()"
              v-show="puedeMostrarBotonAgregarPaso(indicePaso)"
              type="is-info"
              >+</b-button
            >
          </p>
        </b-field>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <b-button
          @click="guardarReceta()"
          :disabled="!deberiaHabilitarBotonAgregarIngrediente()"
          type="is-success"
          >Guardar</b-button
        >
      </div>
    </div>
  </div>
</template>
<script>
import HttpService from "../services/HttpService";
import Constantes from "../Constantes";
export default {
  data: () => ({
    unidadesMedida: Constantes.UNIDADES_MEDIDA,
    receta: {
      nombre: "",
      descripcion: "",
      porciones: 1,
      ingredientes: [],
      pasos: [],
    },
  }),
  methods: {
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
      const respuesta = await HttpService.post(
        "/agregar_receta.php",
        this.receta
      );
      console.log({ respuesta });
    },
  },
  async mounted() {
    this.agregarIngrediente();
    this.agregarPaso();
  },
};
</script>