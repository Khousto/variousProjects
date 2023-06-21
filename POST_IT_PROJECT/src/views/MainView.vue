<script setup>
import { createDOMCompilerError } from "@vue/compiler-dom";
import MiniPostits from "../components/MiniPostitsComponent.vue";
import MainView from "../views/MainView.vue";


</script>

<script>

export default {
    data() {
      return {
        array: [],
      };
    },

    created(){
      fetch('http://5.135.119.239:3090/notes')
      .then((response) => response.json())
      .then((response) => {
        this.array = response;
        // console.log(response);
      });
      // console.log(this.array);
    },
};

</script>

<template>
  <header>
    <h1> Pensées Globales </h1>
  </header>
  <main class="body">
    <router-link class="new" to ="newpostview">Nouvelle Pensée</router-link>
    <MiniPostits
      v-for="note in array.notes"
        :key = "note"
        :title = "note.title"
        :content = "note.content[0]"
        :id = "note._id"
    />
    <div id="TWR">
      <img src="../assets/TW_ROSEY.PNG" style="height: 950px;">
    </div> 
  </main>
  <footer>
      <div class="copyright">
        <p> - Copyright Khousto MMXXII - </p>
      </div>
  </footer>
</template>










<style scoped>
  * {
    margin: 0;
  }
  html, body {
    height: 100%;
  }
  .body {
    min-height: fit-content;
    /* equal to footer height */
    margin-bottom: -750px; 
  }
  .body:after {
    content: "";
    display: block;
  }
  .copyright{
    height: 142px; 
    text-align: center;   
  }
  .copyright p{
    text-transform: uppercase;
    color:rgb(100, 149, 237, 0.5);
    font-size: 20px;
    font-weight: 300;
  }

  #TWR{
    display: flex;
    flex-direction: row;
    position: fixed;
    top: 60px;
    right: 150px;
    /* justify-content: flex-end;
    align-content: flex-start; */
    /* left: 400px;
    bottom: 100em; */

  }

  h1 {
    display: flex;
    flex-direction: row;
    font-family: 'Roboto';
    text-transform: uppercase;
    font-size: 70px;
    font-weight: 500;
    color: rgb(149, 17, 154);
    margin: 20px;
    padding: 5px;
    text-shadow: rgba(158, 55, 255, 0.5) 0px 5px, rgba(158, 55, 255, 0.3) 0px 10px, rgba(158, 55, 255, 0.2) 0px 15px, rgba(158, 55, 255, 0.1) 0px 20px, rgba(158, 55, 255, 0.05) 0px 25px;

    }

  p {
    color: black;
  }
  footer{
    /* position:  */
    width: 100%; 
    height: 150px;
    margin-top: 800px;
    /* bottom: 0; left: 0; right: 0; */
  }
  .new {
    font-family: 'Roboto';
    display: inline-block;
    text-transform: uppercase;

    background-color: hsl(309, 100%, 89%);
    border-radius: 15px;
    border: 4px double #cccccc;
    color: #bf6fbf;
    text-align: center;
    font-size: 14px;
    font-weight: 500;
    padding: 4px;
    width: fit-content;
    transition: all 0.5s;
    cursor: pointer;
    margin-top: 35px;
    margin-bottom: 35px;
    margin-left: -100px;
    box-shadow: rgb(85, 91, 255) 0px 0px 0px 3px, rgb(31, 193, 27) 0px 0px 0px 6px, rgb(255, 217, 19) 0px 0px 0px 9px, rgb(255, 156, 85) 0px 0px 0px 12px, rgb(255, 85, 85) 0px 0px 0px 15px;
  }
</style>

