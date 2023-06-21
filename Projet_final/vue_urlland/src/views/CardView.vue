<script setup>
import { RouterLink } from "vue-router";
import headerClientComponent from "../components/headerClientComponent.vue";
import postComponent from "../components/postComponent.vue";
import commentComponent from "../components/commentComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      post: {},
      comments: [],
      newCom: {
        content: "",
        id_user: localStorage.getItem("id"),
        id_post: this.$route.params.id,
      },
    };
  },
  created() {
    // request to GET the card
    fetch("http://127.0.0.1:8000/api/post/" + this.$route.params.id)
      .then(function (res) {
        if (res.ok == true) {
          return res.json();
        }
      })
      .then((data) => {
        const date = new Date(data.created_at);
        const ymd = date.toISOString().split("T")[0].split("-");
        const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
        console.log(dmy);
        data.created_at = dmy;
        this.post = data;
      });

    //request to GET the comments
    fetch(
      "http://127.0.0.1:8000/api/post/" + this.$route.params.id + "/comments"
    )
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      // .then((data) => {
      //   this.comments = data;
      // });
      .then((data) => {
        console.log(data);
        for (let comment of data) {
          const date = new Date(comment.created_at);
          const ymd = date.toISOString().split("T")[0].split("-");
          const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
          console.log(dmy);
          comment.created_at = dmy;
          this.comments.push(comment);
        }
      });
  },
  methods: {
    // request to CREATE a comment
    addComment() {
      if (localStorage.getItem("id") != null) {
        // console.log(sessionStorage.getItem('id'));
        // console.log(this.content);
        // console.log(this.$route.params.id);
        fetch("http://127.0.0.1:8000/api/comment", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            content: this.newCom.content,
            id_user: this.newCom.id_user,
            id_post: this.newCom.id_post,
          }),
        })
          .then((res) => res.json())
          // .then((res) => this.comments = res.comment);
          .then((data) => {
            // this.post_array = data;
            console.log(data)
            let comments = []
            for (let comment of data.comment) {
              const date = new Date(comment.created_at);
              const ymd = date.toISOString().split("T")[0].split("-");
              const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
              console.log(dmy);
              comment.created_at = dmy;
              comments.push(comment);
            }
            this.comments = comments
            // window.location.reload();
            // this.$router.push("/cardView/" + this.$route.params.id);
          });
      } else {
        return "Je suis une cafetière...";
      }
    },
  },
};
</script>

<template>
  <main>
    <headerClientComponent />
    <router-link to="/">
      <button class="back">Retour</button>
    </router-link>
    <!-- <postComponent /> -->
    <postComponent
      :id="post.id"
      :title="post.title"
      :content="post.content"
      :picture="post.picture"
      :category="post.category"
      :nb_like="post.nb_like"
      :created_at="post.created_at"
    />
    <commentComponent
      v-for="comment in comments"
      :key="comment"
      :id="comment.id"
      :content="comment.content"
      :nb_like="comment.nb_like"
      :id_user="comment.id_user"
      :created_at="comment.created_at"
    />
    <form @submit.prevent="addComment()">
      <div class="addComment">
        <div class="addComment_input">
          <p class="newComment">Nouveau commentaire :</p>
          <input class="form_txt" type="text" v-model="newCom.content" />
          <button class="addCom">Ajouter le Commentaire</button>
        </div>
      </div>
    </form>
  </main>
  <Footer />
</template>

<style>
main {
  display: flex;
  flex-direction: column;
}
p {
  font-family: "Roboto Condensed";
  size: 30px;
}

.comments {
  border-radius: 12px;
  background-color: #fffef6;
  margin-top: 15px;
  margin-left: 150px;
  margin-right: 150px;
  padding: 15px;
}
.comment_1 {
  background-color: #fffef6;
  margin-top: 15px;
  padding: 15px;
  border: 1px solid #424340;
  border-radius: 6px;
}
.comment_2 {
  background-color: #fffef6;
  margin-top: 15px;
  padding: 15px;
  border: 1px solid #424340;
  border-radius: 6px;
}
.back {
  font-family: "Roboto Condensed";
  color: #fffef6;
  width: 100px;
  height: 40px;
  background: #a47e16;
  border: none;
  border-radius: 12px;
  margin-bottom: 30px;
  margin-right: 25px;
  float: right;
  cursor: pointer;
}
.addComment {
  display: flex;
  flex-direction: row;
  border-radius: 24px;
  background-color: #fffef6;
  margin-top: 10px;
  margin-left: 150px;
  margin-right: 150px;
  padding: 15px;
  padding-bottom: 95px;
}
.addCom {
  padding: 5px 10px 5px 10px;
  width: 130px;
  border: none;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  margin-top: 10px;
  cursor: pointer;
}

.com_content {
  font-family: "Roboto Condensed";
  font-size: 20px;
  color: #606c5a;
}
.com_created_at {
  text-align: center;
  font-family: "Roboto Condensed";
  color: #606c5a;
  text-align: right;
  margin-left: 20px;
  height: 20px;
  padding-top: 10px;
}
.newComment {
  font-family: "Roboto Condensed";
  text-transform: uppercase;
  color: #606c5a;
  margin-top: 0;
}
.form_txt {
  background-color: #b8cbd0;
  border-radius: 12px;
  padding: 15px;
  width: 151%;
  border: none;
  height: 70%;
}
</style>
