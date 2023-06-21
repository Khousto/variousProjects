<script setup>
import { RouterLink } from "vue-router";

defineProps({
  id: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  content: {
    type: String,
    required: true,
  },
  picture: {
    type: String,
    required: true,
  },
  category: {
    type: String,
    required: true,
  },
  nb_like: {
    type: Number,
    required: true,
  },
  created_at: {
    type: Date,
    required: true,
  },
});
</script>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    delete_post() {
      // request to GET a user
      fetch("http://127.0.0.1:8000/api/post/" + this.id, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
      }).then(function (res) {
        console.log(res),
          //   this.$toast.sucess("deleted post"),
          window.location.reload();
      });
      // .then(() => window.location.reload());
    },
  },
};
</script>

<template>
  <div class="adminpost">
    <router-link
      style="text-decoration: none; color: black"
      :to="/adminPost/ + id"
    >
      <img class="post_picture" :src="picture" alt="paysage d'illustration" />
    </router-link>
    <div class="admin_title_content">
      <div class="en-tete">
        <h2 class="admin_post_category">Catégorie : {{ category }}</h2>
        <h2 class="admin_post_title" :title="id">Titre : {{ title }}</h2>
      </div>
      <div class="description">
        <div class="admin_post_content">{{ content }}</div>
        <div class="admin_post_nb_like">{{ nb_like }}</div>
        <div class="admin_post_created_at">Edité le : {{ created_at }}</div>
      </div>
      <button id="admin_supprPost" @click="delete_post()">Supprimer</button>
    </div>
  </div>
</template>

<style>
.adminpost {
  display: flex;
  flex-direction: row;
  border-radius: 24px;
  background-color: white;
  padding: 15px;
  margin-bottom: 20px;
}

.adminpost * {
  color: #606c5a;
}

.admin_title_content {
  font-family: 'Roboto Condensed';
  font-weight: 200;
  display: flex;
  flex-direction: column;
  padding: 10px;
  width: 65%;
}

.admin_post_title {
  font-family: "Roboto Condensed";
  font-size: 30px;
  border-radius: 10px 10px 0 0;
  margin-top: 0;
  margin-bottom: 0;
  padding: 10px;
}

.admin_post_content {
  font-family: "Roboto Condensed";
  font-size: 20px;
}
.description {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.post_picture {
  width: 250px;
  height: 180px;
  margin-right: 10px;
}

#admin_supprPost {
  background-color: #b0b9a8;
  border: none;
  border-radius: 6px;
  color: white;
  padding: 15px;
  cursor: pointer;
}
</style>
