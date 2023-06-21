<script setup>
import WPAPI from "wpapi";
defineProps({
  name: {
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
      array: [],
      // id of the list, in URL
      idsearch: this.$router.currentRoute.value.params["id"],
    };
  },
  created() {
    // request to GET the list
    const wp = new WPAPI({
      endpoint: import.meta.env.VITE_WORDPRESS_API,
    });
    wp.categories()
      .id(this.idsearch)
      .get()
      .then((data) => {
        this.array = data;
      });
  },
  methods: {
    // request to UPDATE the list
    changeListInApi() {
      const wp = new WPAPI({
        endpoint: import.meta.env.VITE_WORDPRESS_API,
        username: import.meta.env.VITE_WORDPRESS_USERNAME,
        password: import.meta.env.VITE_WORDPRESS_PASSWORD,
        auth: true,
      });
      wp.categories()
        .id(this.idsearch)
        .update({
          name: this.array.name,
        })
        .then(() => {
          this.$toast.info("Liste modifiée");
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
  <form class="changelist">
    <div>
      <input class="list_title" v-model="this.array.name" />
    </div>
    <img
      src="../assets/KEEP_DROP.svg"
      class="editList"
      @click="changeListInApi()"
    />
  </form>
</template>

<style>
.changelist {
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  background: linear-gradient(to top, #ffffff 0%, #596f8e 100%);
  padding: 10px;
  margin: 40px auto;
  width: 450px;
  height: 120px;
  box-shadow: 2px 5px 7px #35495e;
  align-items: center;
}

.list_title {
  font-family: "Amatic SC";
  font-size: 30px;
  border: none;
  padding: 5px 15px;
  border-radius: 10px;
  background: #596f8e67;
}

.editList {
  margin-top: 10px;
  border-radius: 10px;
  background: #596f8e67;
  padding: 10px;
  height: 40px;
  width: 40px;
}
</style>
