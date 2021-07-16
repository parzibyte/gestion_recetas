<template>
  <img :src="fotoDeReceta()" :alt="'Foto de ' + receta.nombre" />
</template>
<script>
import RecetasService from "../services/RecetasService"
export default {
  props: ["receta"],
  methods: {
    fotoDeReceta() {
      if (!this.receta.foto) {
        return false;
      }
      return RecetasService.ubicacionFoto(this.receta.foto);
    },
  },
};
</script>