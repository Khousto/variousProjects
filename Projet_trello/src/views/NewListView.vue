<script setup>
import WPAPI from "wpapi";
import { RouterLink, RouterView } from "vue-router";

defineProps({
  name: {
    name: "",
    type: String,
    required: true,
  },
  id: {
    id: "",
    type: String,
  },
});
</script>

<script>
export default {
  methods: {
    // request to CREATE a list
    addListInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.categories()
        .create({
          name: this.nom,
        })
        .then(() => {
          this.$toast.info("Nouvelle liste créée");
          this.$router.push("/");
        })
        .catch(() => {
          this.$toast.error("Erreur rencontrée");
        });
    },
  },
};
</script>

<template>
  <form>
    <div class="newlist">
      <input
        class="list_title"
        v-model="nom"
        placeholder="titre de la nouvelle liste"
      />
      <img
        src="../assets/KEEP_DROP.svg"
        class="editList"
        width="38"
        height="38"
        @click="addListInApi()"
      />
    </div>
  </form>
</template>

<style>
.newlist {
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  background: linear-gradient(to top, #ffffff 0%, #596f8e 100%);
  padding: 10px;
  margin-top: 40px;
  width: 450px;
  height: 120px;
  box-shadow: 2px 5px 7px #35495e;
  align-items: center;
}

.list_title {
  font-family: "Amatic SC";
  font-size: 30px;
  border: none;
  padding: 5px 15px;
  border-radius: 10px;
  outline: none;
  background: #596f8e67;
}

.editList {
  margin-top: 10px;
  border-radius: 10px;
  background: #596f8e67;
  padding: 10px;
  height: 40px;
  width: 40px;
}
</style>
