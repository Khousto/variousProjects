<script setup>
import { RouterLink } from "vue-router";
import headerClientComponent from "../components/headerClientComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      comment: {},
      comment_array: [],
    };
  },
  created() {
    // request to GET a comment
    console.log (this.$route.params.id);
    fetch("http://127.0.0.1:8000/api/comment/" + this.$route.params.id)
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => (console.log(data),this.comment = data));
  },
  methods: {
    changeCommentInApi(event) {
      event.preventDefault();
      //request to UPDATE a comment
      console.log(this.comment);
      fetch("http://127.0.0.1:8000/api/comment/" + this.$route.params.id, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          content: this.comment.content,
        }),
      })
        .then((res) => res.json())
        .then((data) => (this.comment = data));
        this.$toast.success("Commentaire modifié");
    },
    goBack() {
      this.$router.push("/profil");
    },
  },
};
</script>

<template>
  <div class="body_com">
    <headerClientComponent />
    <div class="affichage_com">
      <div class="affichage_post_com">
        <form>
          <input type="hidden" :value="this.$route.params.id"/>
          <textarea
            type="text"
            class="modif_content_com"
            v-model="this.comment.content"
          />
          <button class="back" @click="changeCommentInApi($event)">
            Enregistrer les modifications
          </button>
        </form>
      </div>
    </div>
    <div class="admin_buttons_com">
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
.body_com {
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
.affichage_com {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  background-color: #b8CBD0;
  padding: 30px;
  margin: 30px;
  border-radius: 24px;
}

.affichage_post_com {
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
  margin: 10px;
  padding: 15px;
  border: none;
  background-color: #b0b9a8;
}

.modif_content_com {
  font-family: 'Roboto Condensed';
  resize: none;
  padding: 15px;
  border: none;
  background-color: white;
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
