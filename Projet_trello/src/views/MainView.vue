<script setup>
import { RouterLink, RouterView } from "vue-router";
import WPAPI from "wpapi";
import List from "../components/ListComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      tableau: [],
    };
  },
  created() {
    // request to GET all the lists
    const wp = new WPAPI({
      endpoint: import.meta.env.VITE_WORDPRESS_API,
    });
    wp.categories()
      .orderby("id")
      .get((err, data) => {
        this.tableau = data;
      });
  },
};
</script>

<template>
  <div class="page">
    <!--Display of List Components-->
    <List
      v-for="element in tableau"
      :key="element"
      :id="element.id"
      :name="element.name"
    />
    <router-link to="newlist"
      ><img
        class="add_list"
        src="../assets/ADD_DROP.png"
        alt="Pour une liste supplémentaire !"
    /></router-link>
  </div>
</template>

<style>
.page {
  display: flex;
  flex-direction: row;
  margin: 15px;
}

.add_list {
  border-radius: 20px;
  background: #596f8e67;
  height: 50px;
  width: 50px;
  /* margin: 30px; */
  padding: 10px;
}
</style>
