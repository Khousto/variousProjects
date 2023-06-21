<script setup>
import { RouterLink } from "vue-router";
import headerClientComponent from "../components/headerClientComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      post: {},
      comment_array: [],
    };
  },
  created() {
    // request to GET a post
    console.log (this.$route.params.id);
    fetch("http://127.0.0.1:8000/api/post/" + this.$route.params.id)
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => (this.post = data));
  },
  methods: {
    changePostInApi(event) {
      event.preventDefault();
      //request to UPDATE a post
      console.log(this.post);
      fetch("http://127.0.0.1:8000/api/post/" + this.$route.params.id, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          title: this.post.title,
          content: this.post.content,
          // picture: this.post.picture,
        }),
      })
        .then((res) => res.json())
        .then((data) => (this.post = data));
        this.$toast.success("Publication modifiée");
    },
    goBack() {
      this.$router.push("/profil");
    },
  },
};
</script>

<template>
  <div class="body3">
    <headerClientComponent />
    <div class="affichage">
      <div class="affichage_post">
        <form>
          <img
            :src="post.picture"
            alt="image de la publication"
            class="post_picture"
          />
          <input type="text" class="modif_title" v-model="post.picture" />
          <input type="text" class="modif_title" v-model="post.title" />
          <textarea type="text" class="modif_content" v-model="post.content" />
          <button class="back" @click="changePostInApi($event)">
            Enregistrer les modifications
          </button>
        </form>
      </div>
    </div>
    <div class="admin_buttons">
      <button class="back" @click="goBack()">Accueil</button>
    </div>
    <Footer />
  </div>
</template>

<style scoped>
template {
  display: flex;
  flex-direction: column;
}
.body3 {
  display: flex;
  flex-direction: column;
  background: linear-gradient(
    180deg,
    rgba(184, 203, 208, 1) 0%,
    rgba(255, 254, 246, 1) 100%
  );
  margin: 0;
  min-height: 100vh;
}
.affichage {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  background-color: #b8CBD0;
  padding: 30px;
  margin: 30px;
  border: none;
  border-radius: 24px;
}

.affichage_post {
  width: 35%;
  padding: 20px;
}

form {
  display: flex;
  flex-direction: column;
}

.post_picture {
  width: 100%;
  height: 100%;
}

.modif_title {
  font-family: 'Roboto Condensed';
  font-size: 20px;
  border-radius: 12px;
  margin: 10px;
  padding: 15px;
  border: none;
  background-color: #FFFEF6;
}

.modif_content {
  font-family: 'Roboto Condensed';
  resize: none;
  padding: 15px;
  border: none;
  background-color: #FFFEF6;
  border-radius: 12px;
  height: 300px;
  margin: 20px 0;
}
.affichage_comments {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 60%;
  margin-left: 30px;
  margin-top: 15px;
}

.label_comment {
  color: white;
}

.new_comment {
  background-color: white;
  padding: 20px;
  border-radius: 12px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
.new_comment input {
  width: 80%;
  border: none;
}

.addComment {
  background-color: #b0b9a8;
  border: none;
  border-radius: 6px;
  padding: 15px;
  color: white;
  cursor: pointer;
}
</style>
