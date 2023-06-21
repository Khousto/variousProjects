<script setup>
import WPAPI from "wpapi";
import Card from "../components/CardComponent.vue";
defineProps({
  name: {
    type: String,
    required: true,
  },
  id: {
    type: Number,
    required: true,
  },
});
</script>

<script>
export default {
  data() {
    return {
      array: [],
    };
  },
  created() {
    // request to GET the cards oh this list
    const wp = new WPAPI({
      endpoint: import.meta.env.VITE_WORDPRESS_API,
    });
    wp.posts()
      .categories(this.id)
      .get()
      .then((data) => {
        this.array = data;
      });
  },
  methods: {
    // request to DELETE this list and cards it contains
    deleteListInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.categories()
        .id(this.id)
        .param("force", true)
        .delete()
        .then(() => {
          for (const element of this.array) {
            wp.posts().id(element.id).delete();
          }
        })
        .then(() => {
          this.$toast.info("List supprimée");
        })
        .then(() => window.location.reload())
        .catch(() => {
          this.$toast.error("Erreur rencontrée");
        });
    },
  },
};
</script>

<template>
  <div class="list">
    <router-link style="text-decoration: none" :to="/displaylist/ + this.id">
      <h2 class="title_list">{{ name }}</h2>
    </router-link>
    <Card
      v-for="element in array"
      :key="element"
      :id="element.id"
      :title="element.title.rendered"
      :content="element.content.rendered"
    />
    <div class="add_supp">
      <router-link style="text-decoration: none; color: black;" :to="/newcard/ + id">
        <p class="creation">+ Ajouter une carte</p>
      </router-link>
      <div class="del_logo">
        <img
          src="../assets/NO_DROP.svg"
          width="35"
          height="35"
          @click="deleteListInApi()"
        />
      </div>
    </div>
  </div>
</template>

<style>
.list { 
  display: flex;
  flex-direction: column;
  background-color: azure;
  border-radius: 20px;
  min-height: 30px;
  width: 280px;
  margin-left: 10px;
  margin-right: 10px;
  box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 8px;
}

.title_list {
  font-family: "Amatic SC";
  font-size: 35px;
  border-radius: 20px 20px 0 0;
  margin-top: 0;
  margin-bottom: 0;
  background: #596f8e;
  color: rgb(230, 230, 230);
  text-decoration: none;
  padding: 10px;
  min-width: 250px;
}

.add_supp {
  align-self: center;
  flex: auto;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 10px;
}

.creation {
  font-family: "Amatic SC";
  font-size: 20px;
  margin: 5px;
}
</style>
