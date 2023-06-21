<script setup>
import WPAPI from "wpapi";
import Comment from "../components/CommentComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      data: {},
      array: [],
      // id of the card in URL
      idsearch: this.$router.currentRoute.value.params["id"],
    };
  },
  created() {
    // request to GET the card
    const wp = new WPAPI({
      endpoint: import.meta.env.VITE_WORDPRESS_API,
    });
    wp.posts()
      .id(this.idsearch)
      .get()
      .then((data) => {
        this.data.title = data.title.rendered;
        this.data.content = data.content.rendered.replace(/<[^>]*>?/gm, "");
      });
    // requet to GET comments of this card
    wp.comments()
      .post(this.idsearch)
      .get()
      .then((data) => {
        this.array = data;
      });
  },
  methods: {
    // request to UPDATE the card
    changeCardInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.posts().id(this.idsearch).update({
        title: this.data.title,
        content: this.data.content,
        status: "publish",
      });
      this.$toast.info("Carte modifiée");
      this.$router.push("/");
    },
    // request to DELETE the card
    deleteCardInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.posts().id(this.idsearch).param("force", true).delete();
      this.$toast.info("Carte supprimée");
      this.$router.push("/");
    },
    // request to CREATE a comment
    addCommentInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.comments()
        .create({
          content: this.contenu,
          author: 1,
          post: this.idsearch,
          status: "publish",
        })
        .then(() => {
          this.$toast.info("Commentaire ajouté");
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
  <form class="bg_modif">
    <div class="info_card">
      <input class="modif_title" v-model="this.data.title" />
      <textarea class="modif_content" v-model="this.data.content"></textarea>
      <div class="logos">
        <img
          src="../assets/KEEP_DROP.svg"
          class="save_drop"
          @click="changeCardInApi()"
        />
        <img
          src="../assets/NO_DROP.svg"
          class="del_drop"
          @click="deleteCardInApi()"
        />
      </div>
    </div>
    <div class="info_comment">
      <!-- Comment component -->
      <Comment
        v-for="element in array"
        :key="element"
        :id="element.id"
        :author="element.author_name"
        :content="element.content.rendered"
      />
      <!-- New comment -->
      <div class="new_comment">
        <div class="newcomment_input">
          <p>Nouveau commentaire :</p>
          <input type="text" v-model="contenu" />
        </div>
        <img
          class="add_com"
          src="../assets/ADD_DROP.png"
          @click="addCommentInApi()"
        />
      </div>
    </div>
  </form>
</template>

<style>
.bg_modif {
  display: flex;
  flex-direction: row;
  border-radius: 20px;
  background: linear-gradient(to top, #ffffff 0%, #596f8e 100%);
  box-shadow: 2px 5px 7px #35495e;
  margin: 10px;
  align-items: flex-start;
}

.info_card {
  height: 100%;
  width: 50%;
  padding: 10px;
  display: flex;
  flex-direction: column;
}

.modif_title {
  font-family: "Amatic SC";
  font-size: 30px;
  border: none;
  outline: none;
  padding: 5px 10px;
  margin-bottom: 5px;
  border-radius: 10px;
  background: #596f8e67;
}
.modif_content {
  font-family: "Amatic SC";
  font-size: 25px;
  min-height: 250px;
  border: none;
  outline: none;
  border-radius: 10px;
  background-color: #d5e7ff50;
  padding: 5px;
  margin: 5px;
}

.logos {
  margin: 5px;
}

.logos img {
  border-radius: 20px;
  background: #596f8e67;
  margin-right: 3px;
  padding: 10px;
  height: 40px;
  width: 40px;
}

.info_comment {
  border-left: solid 2px #596f8e;
}

.new_comment {
  border-radius: 10px;
  background: #505f7248;
  padding: 10px;
  padding-bottom: 20px;
  margin: 10px 170px;
  width: 450px;
  height: 120px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
.newcomment_input{
  width: 370px;
}
.newcomment_input p {
  font-family: "Amatic SC";
  font-size: 25px;
}
.newcomment_input input {
  font-family: "Amatic SC";
  font-size: 30px;
  width: 95%;
  border: none;
  padding: 5px 15px;
  border-radius: 10px;
  background: #596f8e67;
}
.add_com {
  margin-top: 10px;
  border-radius: 10px;
  background: #596f8e67;
  padding: 10px;
  height: 40px;
  width: 40px;
}
</style>
