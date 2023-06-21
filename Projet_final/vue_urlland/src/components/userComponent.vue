<script setup>
import { RouterLink } from "vue-router";

defineProps({
  id: {
    required: true,
  },
  nickname: {
    type: String,
    required: true,
  },
  email: {
    type: String,
    required: true,
  },
  password: {
    type: String,
    required: true,
  },
  logo: {
    type: Number,
    required: true,
  },
  is_admin: {
    type: Number,
    required: true,
  },
});
</script>

<template>
  <router-link
    style="text-decoration: none; color: black"
    :to="/adminUser/ + id"
  >
    <div class="user">
      <h2 :nickname="id">{{ nickname }}</h2>
      <div>{{ email }}</div>
      <div>{{ logo }}</div>
      <div>{{ is_admin }}</div>
    </div>
  </router-link>
</template>

<style>
.user {
  background-color: yellow;
}
</style>
