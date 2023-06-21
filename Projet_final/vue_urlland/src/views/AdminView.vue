<script setup>
import { RouterLink } from "vue-router";
import headerAdminComponent from "../components/headerAdminComponent.vue";
import User from "../components/adminUserComponent.vue";
import Post from "../components/adminPostComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      user_array: [],
      post_array: [],
      nb_users: 0,
      nb_posts: 0,
      nb_comments: 0,
    };
  },
  created() {
    // vérification du status d'admin
    this.idVerif = localStorage.getItem("id")
    fetch("http://127.0.0.1:8000/api/user/isadmin/" + this.idVerif).then(
      async (res) => {
        const response = await res.text();
        console.log(response);
        if (response != "is admin") {
          this.$router.push("/");
        }
      }
    );
    // request to GET all the users
    fetch("http://127.0.0.1:8000/api/users")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        // this.user_array = data
        for (let user of data) {
          user.is_admin_text = "est un client";
          if (user.is_admin == 1) {
            user.is_admin_text = "est administrateur";
          }
          this.user_array.push(user);
        }
      });

    // request to GET all the posts
    fetch("http://127.0.0.1:8000/api/posts")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        console.log(data);
        for (let post of data) {
            const date = new Date(post.created_at);
            const ymd = date.toISOString().split("T")[0].split("-");
            const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
            console.log(dmy);
            post.created_at = dmy;
          this.post_array.push(post);
        }
    });


    // Stats
    fetch("http://127.0.0.1:8000/api/stats/numberOf")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        console.log(data.comments[0].nb_comments);
        console.log(data.posts[0].nb_posts);
        console.log(data.users[0].nb_users);
        this.nb_users = data.users[0].nb_users;
        this.nb_posts = data.posts[0].nb_posts;
        this.nb_comments = data.comments[0].nb_comments;
      });
  },
  methods: {
    addUserInApi() {
      fetch("http://127.0.0.1:8000/api/admin/user", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          nickname: this.nickname,
          email: this.email,
          password: this.password,
          is_admin: this.is_admin ? 1 : 0,
        }),
      })
        .then((res) => res.json())
        .then((data) => (this.user_array = data));
    },
    goToStat() {
      this.$router.push("/stats");
    },
  },
};
</script>

<template>
  <div class="body2">
    <headerAdminComponent />
    <div class="statistiques">
      <div class="espace_titre">
        <h2>Espace Administrateur</h2>
        <router-link to="/">
          <button class="back">Accueil</button>
        </router-link>
      </div>
      <div class="espace_stat" @click="goToStat()">
        <div>
          <span>{{ nb_users }}</span> utilisateurs
        </div>
        <div>
          <span>{{ nb_posts }}</span> publications
        </div>
        <div>
          <span>{{ nb_comments }}</span> commentaires
        </div>
      </div>
    </div>
    <div class="affichage">
      <div class="affichage_users">
        <User
          v-for="element in user_array"
          :key="element"
          :id="element.id"
          :nickname="element.nickname"
          :email="element.email"
          :password="element.password"
          :is_admin="element.is_admin_text"
        />
        <form id="form">
          <p class="titleadduser">Ajouter un utilisateur</p>
          <div class="newuser">
            <div class="champs">
              <label>Pseudonyme : </label>
              <input
                type="text"
                v-model="nickname"
                placeholder="pseudonyme de l'utilisateur"
              />
            </div>
            <div class="champs">
              <label>Email : </label>
              <input
                type="email"
                v-model="email"
                placeholder="email de l'utilisateur"
              />
            </div>
            <div class="champs">
              <label>Mot de passe : </label>
              <input
                type="password"
                v-model="password"
                placeholder="mot de passe de l'utilisateur"
              />
            </div>
            <input
              type="radio"
              id="is_admin"
              name="is_admin"
              v-model="is_admin"
              value="1"
            />
            <label for="admin">Administrateur</label>
            <p class="submituser" @click="addUserInApi()">Ajouter</p>
          </div>
        </form>
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
          :created_at="element.created_at"
        />
      </div>
    </div>
    <Footer />
  </div>
</template>

<style scoped>
.body2 {
  display: flex;
  flex-direction: column;
  background-color: white;
  margin: 0;
}

.statistiques {
  height: 200px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  padding: 20px 50px;
  border-top: solid 1px #606c5a;
  border-bottom: solid 1px #606c5a;
}

.espace_stat {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  cursor: pointer;
}

.espace_stat div {
  margin: 30px;
  font-size: 35px;
  color: #606c5a;
}

.espace_stat div span {
    color: #a47e16;
    font-size: 50px;
}

.espace_titre {
  display: flex;
  flex-direction: column;
}

.espace_titre h2 {
  color: #606c5a;
}

.back {
  margin-bottom: 5px;
}

.affichage {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
}

.affichage_users {
  background-color: #b0b9a8;
  border-radius: 24px;
  min-height: 250px;
  width: 45%;
  padding: 25px;
  margin: 10px 20px;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}

#form {
  background-color: white;
  border-radius: 12px;
  padding: 20px;
  height: 250px;
  width: 320px;
  margin-left: 20px;
  margin-top: 20px;
}

#form label {
  color: #606c5a;
}

.titleadduser {
  color: #606c5a;
}

.champs {
  margin-bottom: 20px;
}
.newuser{
  font-family: 'Roboto Condensed';

}

input {
  background-color: #b0b9a8;
  border: none;
  padding: 5px 15px 5px 15px;
  border-radius: 6px;
}

input::placeholder {
  color: white;
}

.submituser {
  background-color: #b0b9a8;
  border: none;
  padding: 6px;
  border-radius: 6px;
  width: 50px;
  color: white;
}

.affichage_posts {
  background-color: #b0b9a8;
  border-radius: 24px;
  min-height: 250px;
  width: 45%;
  padding: 25px;
  margin: 10px 20px;
  display: flex;
  flex-direction: column;
}
</style>
