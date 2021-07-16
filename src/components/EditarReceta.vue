<template>
  <p>Editar receta</p>
</template>
<script>
export default {
  mounted() {
    const idReceta = this.$route.params.id;
    console.log({ idReceta });
  },
};
</script>