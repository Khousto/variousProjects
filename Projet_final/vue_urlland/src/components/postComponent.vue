<script setup>
defineProps({
  id: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  content: {
    type: String,
    required: true,
  },
  picture: {
    type: String,
    required: true,
  },
  category: {
    type: String,
    required: true,
  },
  nb_like: {
    type: Number,
    required: true,
  },
  created_at: {
    type: Date,
    required: true,
  },
});
</script>

<script>
export default {
  data() {
    return {};
  },
  created() {
  },
  methods: {
    // request to INCREMENTE number of like
    addLike(id) {
      if (localStorage.getItem("id") != null) {
        fetch("http://127.0.0.1:8000/api/like/" + id, {
          method: "PUT",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({}),
        })
          .then((res) => res.json())
          .then((data) => (this.post = data))
          .then(window.location.reload());
      }
      else {
        this.$toast.error("Vous devez vous connecter");
      }
    },
  },
};
</script>

<template>
  <div class="post">
    <router-link
      style="text-decoration: none; color: black"
      :to="/cardView/ + id"
    >
      <img class="post_picture" :src="picture" />
    </router-link>
    <div class="title_content">
      <h2 class="post_title" :title="id">{{ title }}</h2>
      <div class="post_content">{{ content }}</div>
      <div class="post_category">{{ category }}</div>
      <div class="post_created_at">Edité le : {{ created_at }}</div>
      <div class="post_nb_like">
        <img class="like_picture" src="../../public/clover.svg" alt="like" />
        {{ nb_like }}
        <img
        class="add_like"
        id="add_likes"
        src="../../public/cloverPlus.svg"
        alt="addlike"
        @click="addLike(id)"
      />
      </div>
      <!-- <img
        class="add_like"
        id="add_likes"
        src="../../public/cloverPlus.svg"
        alt="addlike"
        @click="addLike(id)"
      /> -->
    </div>
  </div>
</template>

<style>
.post {
  display: flex;
  flex-direction: row;
  border-radius: 24px;
  background-color: #fffef6;
  padding-top: 42px;
  margin-left: 150px;
  margin-right: 150px;
  margin-bottom: 1rem;
  height: auto;
}
.title_content {
  display: flex;
  flex-direction: column;
}
.post_title {
  font-family: "Roboto Condensed";
  font-size: 35px;
  text-transform: uppercase;
  font-weight: 400;
  border-radius: 10px 10px 0 0;
  margin-top: 0;
  margin-bottom: 0;
  padding: 0px 10px;
  color: #606c5a;
}

.post_content {
  font-family: "Roboto Condensed";
  font-size: 25px;
  padding: 15px;
  color: #606c5a;
}

#singlePostContent {
  overflow-y: auto;
  position: relative;
  max-height: 100px;
}

.post_category {
  font-family: 'Roboto Condensed';
  margin-left: 1rem;
}
.post_created_at{
  font-family: 'Roboto Condensed';
  margin-left: 1rem;
}

.post_picture {
  margin-left: 1rem;
}

.post_nb_like {
  font-family: 'Roboto Condensed';
  margin: 25px;
}

.like_picture {
  width: 30px;
  height: 30px;
}

.add_like {
  width: 20px;
  height: 20px;
  cursor: pointer;
}

.notDataPic {
  background-image: url("/public/EU landscape 2.jpg");
  width: 240px;
  height: 95%;
  margin: 15px;
}
</style>
