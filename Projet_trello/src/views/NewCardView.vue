<script setup>
import WPAPI from "wpapi";

defineProps({
  title: {
    title: "",
    type: String,
    required: true,
  },
  content: {
    content: "",
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
    // request to CREATE a card
    addCardInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.posts()
        .create({
          title: this.titre,
          content: this.contenu,
          status: "publish",
          categories: [this.$route.params.idlist],
        })
        .then(() => {
          this.$toast.info("Nouvelle carte créée");
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
    <div class="newcard">
      <input
        class="card_title_new"
        v-model="titre"
        placeholder="titre de la carte"
      />
      <textarea
        class="card_content_new"
        rows="5"
        cols="33"
        v-model="contenu"
        placeholder="contenu de la carte"
      >
      </textarea>
    </div>
      <img
        src="../assets/KEEP_DROP.svg"
        class="editCard"
        width="38"
        height="38"
        @click="addCardInApi()"
      />
  </form>
</template>

<style>

form {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.newcard {
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  background: linear-gradient(to top, #ffffff 0%, #596f8e 100%);
  padding: 10px;
  margin: 8px;
  width: 450px;
  height: 270px;
  box-shadow: 2px 5px 7px #35495e;
}

.card_title_new {
  font-family: "Amatic SC";
  font-size: 30px;
  border: none;
  padding: 5px 10px;
  border-radius: 10px;
  background: #596f8e67;
}

.card_content_new {
  font-family: "Amatic SC";
  font-size: 30px;
  border: none;
  border-radius: 10px;
  background-color: #d5e7ff50;
  padding: 5px 10px;
  margin-top: 10px;
  box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
}

.editCard {
  margin-top: 10px;
  border-radius: 20px;
  background: #596f8e67;
  padding: 10px;
  height: 40px;
  width: 40px;
}

</style>
