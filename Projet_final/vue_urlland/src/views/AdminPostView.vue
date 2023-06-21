<script setup>
import { RouterLink } from "vue-router";
import headerAdminComponent from "../components/headerAdminComponent.vue";
import Post from "../components/adminPostComponent.vue";
import Comment from "../components/adminCommentComponent.vue";
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
     // vérification du status d'admin
    this.idVerif = localStorage.getItem("id");
    fetch("http://127.0.0.1:8000/api/user/isadmin/" + this.idVerif).then(
      async (res) => {
        const response = await res.text();
        console.log(response);
        if (response != "is admin") {
          this.$router.push("/");
        }
      }
    );
    // request to GET a post
    fetch("http://127.0.0.1:8000/api/post/" + this.$route.params.id)
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => (this.post = data));

    //request to GET all the comments of a post
    fetch(
      "http://127.0.0.1:8000/api/post/" + this.$route.params.id + "/comments"
    )
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        console.log(data);
        for (let comment of data) {
            const date = new Date(comment.created_at);
            const ymd = date.toISOString().split("T")[0].split("-");
            const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
            console.log(dmy);
            comment.created_at = dmy;
          this.comment_array.push(comment);
        }
    });
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
    addCommentInApi(event) {
      event.preventDefault();
      fetch("http://127.0.0.1:8000/api/comment", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          content: this.comment_content,
          id_user: localStorage.getItem("id"),
          id_post: this.$route.params.id,
        }),
      })
        .then((res) => res.json())
        .then((data) => (this.comment_array = data.comment));
    },
    goToAdmin() {
      this.$router.push("/admin");
    },
    goBack() {
      this.$router.push("/");
    },
  },
};
</script>

<template>
  <div class="body3">
    <headerAdminComponent />
    <div class="affichage">
      <div class="affichage_post">
        <form>
          <img
            :src="post.picture"
            alt="image de la publication"
            class="post_picture"
          />
          <input type="text" class="modif_title" v-model="post.title" />
          <textarea typs="text" class="modif_content" v-model="post.content" />
          <p class="pic_change">Changer l'image :</p>
          <input type="text" class="modif_pic" v-model="post.picture" />
          <button class="back" @click="changePostInApi($event)">
            Modifier
          </button>
        </form>
      </div>
      <div class="affichage_comments">
        <div>
          <Comment
            v-for="element in comment_array"
            :key="element"
            :id="element.id"
            :content="element.content"
            :nb_like="element.nb_like"
            :created_at="element.created_at"
          />
        </div>
        <form>
          <label class="label_comment">Ajouter un commentaire :</label>
          <div class="new_comment">
            <input
              type="text"
              class="modif_content_comment"
              v-model="comment_content"
            />
            <button class="addComment" @click="addCommentInApi($event)">Ajouter</button>
          </div>
        </form>
      </div>
    </div>
    <div class="admin_buttons">
      <button class="back" @click="goToAdmin()">Espace administrateur</button>
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
  background-color: white;
  margin: 0;
  min-height: 100vh;
}
.affichage {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  background-color: #b0b9a8;
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
  font-size: 17px;
  margin: 10px;
  padding: 15px;
  border: none;
  background-color: white;
  border-radius: 12px;
}
.pic_change{
  font-family: 'Roboto Condensed';
  font-size: 17px;
  margin: 0;
}
.modif_pic{
  font-family: 'Roboto Condensed';
  font-size: 17px;
  margin: 10px 10px 35px 10px;
  padding: 5px;
  border: none;
  border-radius: 12px;
}

.modif_content {
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
  font-family: 'Roboto Condensed';
  font-size: 17px;
  margin-bottom: 15px;
  color: black;
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
  margin-right: 0;
  margin-top: 0;
  color: white;
  cursor: pointer;
}
.back{
  font-family: 'Roboto Condensed';
  width: fit-content;
  padding: 10px;
  font-size: 16px;
}
</style>
