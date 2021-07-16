<template>
  <div class="card">
    <div class="card-image">
      <img src="https://picsum.photos/2000" :alt="'Foto de ' + receta.nombre" />
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
</template>
<script>
export default {
  props: ["receta"],
};
</script>