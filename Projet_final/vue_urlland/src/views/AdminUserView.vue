<!-- eslint-disable prettier/prettier -->
<script setup>
import { RouterLink } from "vue-router";
import headerAdminComponent from "../components/headerAdminComponent.vue";
import User from "../components/userComponent.vue";
import Post from "../components/adminPostComponent.vue";
import Comment from "../components/adminCommentComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      user: {},
      post_array: [],
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
    // request to GET a user
    console.log(this.$router);
    fetch("http://127.0.0.1:8000/api/user/" + this.$route.params.id)
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((user) => {
        user.logo_text = "../../public/logo0.svg";
        if (user.logo == 1) {
          user.logo_text = "../../public/logo1.png";
        } else if (user.logo == 2) {
          user.logo_text = "../../public/logo2.png";
        } else if (user.logo == 3) {
          user.logo_text = "../../public/logo3.png";
        } else if (user.logo == 4) {
          user.logo_text = "../../public/logo4.png";
        }
        this.user = user;
      });

    // request to GET all the posts of a user
    fetch("http://127.0.0.1:8000/api/user/" + this.$route.params.id + "/posts")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        // this.post_array = data;
        for (let post of data) {
          const date = new Date(post.created_at);
          const ymd = date.toISOString().split("T")[0].split("-");
          const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
          console.log(dmy);
          post.created_at = dmy;
          this.post_array.push(post);
        }
      });

    // request to GET all the comments of a user
    fetch(
      "http://127.0.0.1:8000/api/user/" + this.$route.params.id + "/comments"
    )
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
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
    goToAdmin() {
      this.$router.push("/admin");
    },
    goBack() {
      this.$router.push("/");
    },
    changeUserInApi(event) {
      event.preventDefault();
      //request to UPDATE a user
      fetch("http://127.0.0.1:8000/api/admin/user", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          id: this.user.id,
          nickname: this.user.nickname,
          email: this.user.email,
          logo: this.user.logo,
          is_admin: this.user.is_admin,
        }),
      })
        .then((res) => res.json())
        .then((user) => {
          user.logo_text = "../../public/logo0.svg";
          if (user.logo == 1) {
            user.logo_text = "../../public/logo1.png";
          } else if (user.logo == 2) {
            user.logo_text = "../../public/logo2.png";
          } else if (user.logo == 3) {
            user.logo_text = "../../public/logo3.png";
          } else if (user.logo == 4) {
            user.logo_text = "../../public/logo4.png";
          }
          this.user = user;
        });
        this.$toast.success("Utilisateur modifié");

    },
    deleteUserInApi() {
      // request to DELETE a user
      fetch("http://127.0.0.1:8000/api/user/" + this.$route.params.id, {
        method: "DELETE",
      }).then(() => this.goToAdmin());
    },
    changeLogo(logo_id) {
      this.user.logo = logo_id;
      this.user.logo_text = "../../public/logo0.svg";
      if (this.user.logo == 1) {
        this.user.logo_text = "../../public/logo1.png";
      } else if (this.user.logo == 2) {
        this.user.logo_text = "../../public/logo2.png";
      } else if (this.user.logo == 3) {
        this.user.logo_text = "../../public/logo3.png";
      } else if (this.user.logo == 4) {
        this.user.logo_text = "../../public/logo4.png";
      }
    },
  },
};
</script>

<template>
  <div class="body2">
    <headerAdminComponent />
    <div class="affichage">
      <div class="affichage_user">
        <form>
          <div class="admin_form">
            <input type="hidden" :value="user.id" name="user.id" />
            <img class="logo_user" :src="user.logo_text" />
            <input type="hidden" v-model="user.logo" />
            <div class="image_logos">
              <img
                class="logo_choice"
                src="../../public/logo1.png"
                @click="changeLogo(1)"
              />
              <img
                class="logo_choice"
                src="../../public/logo2.png"
                @click="changeLogo(2)"
              />
              <img
                class="logo_choice"
                src="../../public/logo3.png"
                @click="changeLogo(3)"
              />
              <img
                class="logo_choice"
                src="../../public/logo4.png"
                @click="changeLogo(4)"
              />
            </div>
            <label>Pseudonyme : </label>
            <input type="text" class="modif_nickname" v-model="user.nickname" />
            <label>Email : </label>
            <input typs="email" class="modif_email" v-model="user.email" />
            <div class="admin_choice">
              <label>Administrateur :</label>
              <input type="radio" v-model="user.is_admin" value="1" />
            </div>
            <div class="admin_choice">
              <label>Client :</label>
              <input type="radio" v-model="user.is_admin" value="0" />
            </div>
            <button class="back" @click="changeUserInApi($event)">
              Modifier
            </button>
          </div>
        </form>
        <button class="suppr_user" @click="deleteUserInApi()">Supprimer</button>
      </div>
      <div class="affichage_posts">
        <Post
          v-for="element in post_array"
          :key="element"
          :id="element.id"
          :title="element.title"
          :content="element.content"
          :picture="element.picture"
          :category="element.category"
          :is_admin="element.is_admin"
          :created_at="element.created_at"
        />
        <Comment
          v-for="element in comment_array"
          :key="element"
          :id="element.id"
          :content="element.content"
          :nb_like="element.nb_like"
          :created_at="element.created_at"
        />
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
.body2 {
  display: flex;
  flex-direction: column;
  background-color: white;
  margin: 0;
  min-height: 100vh;
}
.affichage {
  display: flex;
  flex-direction: row;
  background-color: #b0b9a8;
  padding: 30px;
  margin: 30px;
  border: solid 1px #606c5a;
  border-radius: 24px;
}

.affichage_user {
  min-height: 300px;
  min-width: 45%;
}

.admin_form {
  display: flex;
  flex-direction: column;
  padding: 40px;
}

.logo_user {
  width: 220px;
  border-radius: 50%;
  margin: 10px auto;
}

.logo_choice {
  width: 80px;
}

.image_logos {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  margin: 50px 20px;
}

.admin_form label {
  margin: 10px 0;
}
.admin_form input {
  padding: 15px;
  border: none;
  border-radius: 12px;
}

.admin_choice {
  margin: 10px;
}
.affichage_posts {
  padding: 20px;
  min-height: 300px;
  width: 50%;
}

.admin_buttons {
  display: flex;
  flex-direction: row;
}

.back {
  cursor: pointer;
  margin: 30px 0 10px 30px;
}

.suppr_user {
  cursor: pointer;
  margin: 0 0 5px 70px;
  font-family: "Roboto Condensed";
  color: #fffef6;
  width: 154px;
  height: 47px;
  background: #a47e16;
  border: none;
  border-radius: 12px;
}
</style>
