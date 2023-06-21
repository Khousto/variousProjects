<script setup>
defineProps({
  id: {
    type: String,
    required: true,
  },
  content: {
    type: String,
    required: true,
  },
  nb_like: {
    type: Number,
    required: true,
  },
  id_user: {
    type: Number,
    required: true,
  },
  created_at: {
    type: Date,
    required: true,
  },
  id_post: {
    type: Number,
    required: true,
  },
});
</script>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    delete_comment() {
      // request to GET a user
      fetch("http://127.0.0.1:8000/api/comment/" + this.id, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
      })
        .then(() => {
          this.$toast.sucess("deleted comment");
        })
        .then(() => window.location.reload());
    },
  },
};
</script>

<template>
  <div class="admin_comment">
    <div class="com_content" :content="id">{{ content }}</div>
    <!-- <div class="com_nb_like">{{ nb_like }}</div> -->
    <!-- <div class="com_id_user">{{ id_user }}</div> -->
    <div class="com_created_at">Edité le : {{ created_at }}</div>
    <!-- <div class="com_id_post">{{ id_post }}</div> -->
    <button id="supprPost" @click="delete_comment()">Suppr</button>
  </div>
</template>

<style>
.admin_comment {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  border-radius: 12px;
  background-color: white;
  padding: 15px;
  margin-bottom: 20px;
}

.admin_comment * {
  color: #606c5a;
}

#supprPost {
  background-color: #b0b9a8;
  border: none;
  border-radius: 6px;
  color: white;
  padding: 15px;
  margin-right: 20px;
  cursor: pointer;
}
</style>
