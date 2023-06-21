<script setup>
import { RouterLink } from "vue-router";
import headerClientComponent from "../components/headerClientComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>
<script>
export default {
  data() {
    return {
      newPost: {
        title: "",
        content: "",
        category: "",
        picture: "",
        nb_like: 0,
        id_user: localStorage.getItem("id"),
      },
    };
  },
  methods: {
    // request to CREATE a POST
    addPost(event) {
      event.preventDefault();
      if (localStorage.getItem("id") != null) {
        // console.log(localStorage.getItem('id'));
        fetch("http://127.0.0.1:8000/api/post", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            title: this.newPost.title,
            content: this.newPost.content,
            category: this.newPost.category,
            picture: this.newPost.picture,
            nb_like: this.newPost.nb_like,
            id_user: localStorage.getItem("id"),
          }),
        }).then(() => this.$router.push("/"));
        // .then((res) => this.posts = res.post);
      } else {
        return "Error 41Ouit: Je suis une cafetière...";
      }
    },
    goBack() {
      this.$router.push("/");
    },
  },
};
</script>

<template>
  <div class="body_post">
    <headerClientComponent />
    <main>
      <div class="new">
        <form>
          <div class="new_post">
            <!-- <input type="hidden" :value="localStorage.getItem('id')" v-model="newPost.id_user" /> -->

            <input
              class="post_title_new"
              v-model="newPost.title"
              placeholder="Titre "
            />
            <textarea
              class="post_content_new"
              rows="5"
              cols="33"
              v-model="newPost.content"
              placeholder="Partager votre expérience..."
            >
            </textarea>
            <div class="new_cat_choice">
              <label class="cat_title">Catégories : </label>
                <div class="A">
                  <label>Afrique :</label>
                  <input type="radio" v-model="newPost.category" value="Afrique" />
                </div>
                <div class="B">
                  <label>Amérique :</label>
                  <input type="radio" v-model="newPost.category" value="Amérique" />
                </div>
                <div class="C">
                  <label>Asie :</label>
                  <input type="radio" v-model="newPost.category" value="Asie" />
                </div>
                <div class="D">
                  <label>Europe :</label>
                  <input type="radio" v-model="newPost.category" value="Europe" />
                </div>
                <div class="E">
                  <label>Océanie :</label>
                  <input type="radio" v-model="newPost.category" value="Océanie" />
                </div>
            </div>
            <input
              class="post_pic_new"
              v-model="newPost.picture"
              placeholder="Lien de la photo "
            />
            <!-- <img src="../../public/landscape.jpg" /> -->
            <button class="valid" @click="addPost($event)">Poster !</button>
          </div>
        </form>
        <button class="back" @click="goBack()">Accueil</button>
      </div>
    </main>
    <Footer />
  </div>
</template>

<style>
template {

}
.body_post {
  background: linear-gradient(
    180deg,
    rgba(184, 203, 208, 1) 0%,
    rgba(255, 254, 246, 1) 100%
  );
  margin: 0;
  min-height: 100vh;
}
.new {
  background-color: #b8CBD0;
  padding: 30px;
  margin: 30px;
  border: none;
  border-radius: 24px;
}
.new_post{
  display: flex;
  flex-direction: column;
}

form {

}

.post_title_new {
  font-family: 'Roboto Condensed';
  font-size: 20px;
  border-radius: 12px;
  width: 50%;
  height: 50%;
  margin: 10px;
  padding: 10px;
  border: none;
  background-color: #FFFEF6;
}
.post_pic_new{
  font-family: 'Roboto Condensed';
  font-size: 20px;
  border-radius: 12px;
  width: 30%;
  height: 50%;
  margin: 10px;
  padding: 3px 10px;
  border: none;
}

.post_content_new {
  font-family: 'Roboto Condensed';
  resize: none;
  font-size: 20px;
  padding: 10px;
  border: none;
  background-color: #FFFEF6;
  border-radius: 12px;
  height: 300px;
  width: 50%;
  margin: 10px;
}
.A{
  display: flex;
  flex-direction: row;
}
.new_cat_choice{
  display: flex;
  flex-direction: column;
  font-family: 'Roboto Condensed';
  width: 35%;
  font-size: 18px;
  margin: 10px;

}
.cat_title{
  text-transform: uppercase;
}
.valid{
  font-family: 'Roboto Condensed';
  font-size: 15px;
  text-transform: uppercase;
  background-color: #a47e16;
  color: white;
  width: 10%;
  padding: 10px;
  border-radius: 12px;
  margin: 10px;
  border: none;
}
</style>
