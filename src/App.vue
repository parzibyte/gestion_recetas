<template>
  <div>
    <b-navbar style="border: 2px solid #ffe08a">
      <template #brand>
        <b-navbar-item tag="a" target="_blank" :href="logo">
          <img :src="logo" style="min-height: 85px" />
        </b-navbar-item>
      </template>
      <template #start>
        <b-navbar-item tag="router-link" :to="{ name: 'NuevaReceta' }"
          ><b-icon icon="car" class="mr-1"></b-icon>Nueva receta</b-navbar-item
        >
        <b-navbar-item tag="router-link" :to="{ name: 'Recetas' }"
          >Recetas</b-navbar-item
        >
      </template>
      <template #end>
        <b-navbar-item tag="div">
          <div class="buttons">
            <a href="https://parzibyte.me/#contacto" class="button is-danger">
              <b-icon icon="help"></b-icon>
              <strong>Ayuda y soporte</strong>
            </a>
          </div>
        </b-navbar-item>
      </template>
    </b-navbar>
    <section class="section">
      <router-view></router-view>
    </section>
    <footer class="footer">
      <div class="content has-text-centered">
        <p>
          <strong
            >Programa para el control de estacionamientos / parqueaderos </strong
          >creado y mantenido con
          <b-icon icon="heart" type="is-danger"></b-icon> por
          <a href="https://parzibyte.me/blog">Parzibyte</a>
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
import Logo from "./assets/parzibyte.png";
export default {
  name: "app",
  data: () => ({
    logo: Logo,
  }),
  methods: {},
};
</script>