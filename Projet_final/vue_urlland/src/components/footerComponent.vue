<template>
  <RouterView />
  <footer>
    <p> - Copyright Les Préchauns - 2022 - </p>
    <p class="crea_name">Anaïs - Runyi - Khousto</p>
  </footer>
</template>

<style>
footer {
    font-family: 'Roboto Condensed';
    font-size: 15px;
    font-weight: 200;
    text-align: center;
    opacity: 0.3;
    margin-bottom: 0px;
    padding-bottom: 15px;
  }
  
  
  footer p{
    margin-bottom: 0;
  }
  .crea_name{
    font-size: 10px;
    margin: 0;
  }
</style>