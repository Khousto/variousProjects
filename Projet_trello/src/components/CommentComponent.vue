<script setup>
import WPAPI from "wpapi";

defineProps({
  author: {
    type: String,
    required: true,
  },
  content: {
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
      tempContent: this.content.replace(/<[^>]*>?/gm, ""),
    };
  },
  methods: {
    // request to UPDATE the comment
    changeCommentInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.comments()
        .id(this.id)
        .update({
          content: this.tempContent,
          status: "publish",
        })
        .then(() => {
          this.$toast.info("Commentaire modifié");
        })
        .then(() => window.location.reload())
        .catch(() => {
          this.$toast.error("Erreur rencontrée");
        });
    },
    // request to DELETE a comment
    deleteCommentInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.comments()
        .id(this.id)
        .param("force", true)
        .delete()
        .then(() => {
          this.$toast.info("Commentaire supprimé");
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
  <div class="comment">
    <input class="comment_content" v-model="tempContent" />
    <div class="comment_footer">
      <p>Ecrit par : {{ author }}</p>
      <img
        src="../assets/KEEP_DROP.svg"
        class="save_drop"
        width="35"
        height="35"
        @click="changeCommentInApi()"
      />
      <img
        class="add_list"
        src="../assets/NO_DROP.svg"
        v-on:click="deleteCommentInApi()"
      />
    </div>
  </div>
</template>

<style>
.comment {
  display: flex;
  flex-direction: column;
  border-radius: 10px;
  background: #d5e7ff50;
  padding: 10px;
  margin: 10px 170px;
  width: 450px;
  height: 120px;
}

.comment_content {
  font-family: "Amatic SC";
  font-size: 30px;
  border: none;
  padding: 5px 15px;
  border-radius: 10px;
  background: #596f8e67;
}
.comment p {
  font-family: "Amatic SC";
  font-size: 20px;
}
.comment_footer {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
}

.comment_footer img {
  margin-top: 10px;
  border-radius: 10px;
  background: #596f8e67;
  padding: 10px;
  height: 40px;
  width: 40px;
}
</style>

