<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<script>
export default {
  data() {
    return {
      isPlaying: false,
      audio: new Audio("src/assets/water.mp3"),
    };
  },
  methods: {
    // function which play music
    playMusic() {
      if (this.isPlaying == false) {
        this.audio.play();
        this.isPlaying = true;
      } else {
        this.audio.pause();
        this.isPlaying = false;
      }
    },
  },
};
</script>

<template>
  <img
    src="./assets/big-wave.svg"
    alt="grosses vagues"
    class="wave"
    width="55"
    height="55"
    @click.prevent="playMusic()"
  />
  <header class="overlay">
    <router-link style="text-decoration: none" to="/">
      <h1>Très L'Eau</h1>
    </router-link>
  </header>
  <h2 class="main_slogan">Pour une organisation "Fluide"</h2>
  <RouterView />
</template>

<style>
body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  overflow-x: scroll;
  background: rgb(232, 255, 249);
  background-image: linear-gradient(#596f8e, #fff6cbb7),
    url(./assets/BG_JAP_02_small.jpg);
}

header {
  width: 100%;
}

h1 {
  text-align: center;
  font-family: "Amatic SC";
  font-size: 180px;
  margin-top: 0;
  margin-bottom: 0;
  text-transform: uppercase;
  color: azure;
}

.main_slogan {
  text-align: center;
  font-family: "Amatic SC";
  font-size: 50px;
  font-weight: 700;
  margin-top: 0;
  margin-bottom: 0;
  text-transform: uppercase;
  color: azure;
}
</style>
