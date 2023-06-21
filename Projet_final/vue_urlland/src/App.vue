<script setup>
import { RouterView } from "vue-router";

</script>

<template>
  <RouterView />
  <!-- <footer>
    <p> - Copyright Les Préchauns - 2022 - </p>
    <p class="crea_name">Anaïs - Runyi - Khousto</p>
  </footer> -->
  
</template>

<style>
  body{
    min-height: 100vh;
    margin: 0;
    background: linear-gradient(180deg, rgba(184,203,208,1) 0%, rgba(255,254,246,1) 100%);
  }

  /* footer {
    font-family: 'Roboto Condensed';
    font-size: 15px;
    font-weight: 200;
    text-align: center;
    position:absolute;
    width:100%;
    height:50px;
  }
  footer p{
    margin-bottom: 0;
  }
  .crea_name{
    font-size: 10px;
    margin: 0;
  } */
</style>
