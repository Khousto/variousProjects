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
    <div class="admin_user">
      <h2 :nickname="id">Pseudonyme : {{ nickname }}</h2>
      <div>Email : {{ email }}</div>
      <div>{{ logo }}</div>
      <div class="isadmin">{{ is_admin }}</div>
    </div>
  </router-link>
</template>

<style>
.admin_user {
  font-family: 'Roboto Condensed';
  font-weight: 200;
  background-color: white;
  margin-top: 0;
  margin: 10px;
  margin-left: 193px;
  width: 320px;
  border-radius: 12px;
  padding: 20px;
  height: 150px;
  padding-left: 40px;
  padding-right: 40px;
}

.admin_user * {
  color: #606c5a;
}

.isadmin {
  margin-top: 20px;
}
</style>
