<script setup>
import { RouterLink, RouterView } from "vue-router";

defineProps({
  title: {
    type: String,
    required: true,
  },
  content: {
    type: String,
    required: true,
  },
  id: {
    type: Number,
    required: true,
  },
});
</script>

<template>
  <router-link
    style="text-decoration: none; color: black"
    :to="/displaycard/ + id"
  >
    <div class="card">
      <h2 class="card_title_view" :title="id">{{ title }}</h2>
      <div class="card_content" v-html="content"></div>
    </div>
  </router-link>
</template>

<style>
.card {
  border-radius: 10px;
  background-color: #596f8e67;
  margin: 5px;
}

.card_title_view {
  font-family: "Amatic SC";
  font-size: 30px;
  border-radius: 10px 10px 0 0;
  background: rgba(17, 12, 46, 0.15);
  margin-top: 0;
  margin-bottom: 0;
  padding: 5px 10px;
}

.card_content {
  font-family: "Amatic SC";
  font-size: 20px;
  padding: 0 10px 5px 10px;
}
</style>
