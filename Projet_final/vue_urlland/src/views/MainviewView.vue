<script setup>
// import PostComponent from '../components/PostComponent.vue';
import headerMain from "../components/headerMainComponent.vue";
import postComponent from "../components/postComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>

<script>
export default {
  data() {
    return {
      post_array: [],
      categoryChoice: "",
      searchElement: "",
      Post: { search: "" },
    };
  },
  mounted() {
    // request to GET all the posts
    fetch("http://127.0.0.1:8000/api/posts")
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
    if (localStorage.getItem("id") == null) {
      document.getElementById("navbar-online").style.display = "none";
      document.getElementById("navbar-offline").style.display = "block";
    } else {
      document.getElementById("navbar-offline").style.display = "none";
      document.getElementById("navbar-online").style.display = "block";
    }
  },
  methods: {
    displayFilterPosts() {
      fetch("http://127.0.0.1:8000/api/posts")
        .then(function (res) {
          if (res.ok) {
            return res.json();
          }
        })
        .then((data) => {
          for (let post of data) {
            const date = new Date(post.created_at);
            const ymd = date.toISOString().split("T")[0].split("-");
            const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
            console.log(dmy);
            post.created_at = dmy;
            this.post_array.push(post);
          }
          console.log(data);
          this.post_array = data.filter(
            (element) => element.category === this.categoryChoice
          );
          console.log(this.categoryChoice);
        });
    },
    func_LogOut() {
      localStorage.removeItem("id");
      document.getElementById("navbar-online").style.display = "none";
      document.getElementById("navbar-offline").style.display = "block";
    },
    /* function search */
    search() {
      fetch("http://127.0.0.1:8000/api/select/posts?search=" + this.Post.search)
        .then(function (res) {
          if (res.ok) {
            return res.json();
          }
        })
        .then((data) => {
          // this.post_array = data;
          this.post_array = [];
          for (let post of data) {
            const date = new Date(post.created_at);
            const ymd = date.toISOString().split("T")[0].split("-");
            const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
            console.log(dmy);
            post.created_at = dmy;
            this.post_array.push(post);
          }
        });
    },
    rechargerPage() {
      fetch("http://127.0.0.1:8000/api/posts")
        .then(function (res) {
          if (res.ok) {
            return res.json();
          }
        })

        .then((data) => {
          // this.post_array = data;
          this.post_array = [];
          for (let post of data) {
            const date = new Date(post.created_at);
            const ymd = date.toISOString().split("T")[0].split("-");
            const dmy = ymd[2] + "-" + ymd[1] + "-" + ymd[0];
            console.log(dmy);
            post.created_at = dmy;
            this.post_array.push(post);
          }
        });
    },
  },
};
</script>

<template>
  <header>
    <headerMain />
  </header>
  <main>
    <!-- navbar offline -->
    <nav id="navbar-offline">
      <RouterLink to="/Identification"
        ><button class="btnLog">CONNEXION/ INSCRIPTION</button></RouterLink
      >
    </nav>

    <!-- navbar online -->
    <nav id="navbar-online">
      <RouterLink to="/newpost"
        ><button class="btnAddPost" id="addPost">
          Ajouter une publication
        </button></RouterLink
      >
      <RouterLink to="/profil"
        ><button class="btnUserProfile">Mon Profil</button></RouterLink
      >

      <!-- Dropdown for LogOut -->
      <div class="dropdown">
        <button class="btnLog" id="btn-toggler">...</button>
        <div class="dropdown-content">
          <img
            src="../../public/logout.png"
            @click="func_LogOut()"
            class="btnLogOut"
          />
        </div>
      </div>
    </nav>
    <!-- Desktop view -->
    <div class="container">
      <!-- Display Posts part -->
      <div class="CardsView">
        <!-- <RouterLink to="/cardView/:id"> -->
        <postComponent
          v-for="element in post_array"
          :key="element"
          :id="element.id"
          :title="element.title"
          :content="element.content"
          :picture="element.picture"
          :category="element.category"
          :nb_like="element.nb_like"
          :created_at="element.created_at"
        />
        <!-- </RouterLink> -->
      </div>

      <!-- Filter part + Divers -->
      <div id="filterCard" class="BOXleft">
        <!-- <h3>FILTRE CARDS</h3> -->

        <!-- searchbar -->

        <form class="form_search" @submit.prevent="search()">
          <input
            class="post_search"
            v-model="Post.search"
            placeholder="Effectuer une recherche "
          />
          <button class="valid_search">Rechercher</button>
        </form>

        <!-- filters -->
        <div class="filters">
          <form class="form_radio" @submit.prevent="displayFilterPosts()">
            <label>Afrique :</label>
            <input type="radio" v-model="categoryChoice" value="Afrique" />
            <br />
            <label>Amérique :</label>
            <input type="radio" v-model="categoryChoice" value="Amérique" />
            <br />
            <label>Asie :</label>
            <input type="radio" v-model="categoryChoice" value="Asie" />
            <br />
            <label>Europe :</label>
            <input type="radio" v-model="categoryChoice" value="Europe" />
            <br />
            <label>Océanie :</label>
            <input type="radio" v-model="categoryChoice" value="Océanie" />
            <button type="submit" class="btnFilter_ok">
              Valider mon choix
            </button>
          </form>
          <button @click="rechargerPage()" class="btnFilter_del">
            Effacer mes filtres
          </button>
          <div class="filter__control"></div>
        </div>
      </div>
    </div>
  </main>
  <Footer />
</template>

<style scoped>
body {
  min-height: 100vh;
  background: linear-gradient(
    180deg,
    rgba(184, 203, 208, 1) 0%,
    rgba(255, 254, 246, 1) 100%
  );
  background-repeat: no-repeat;
}

nav {
  margin-top: 2rem;
  display: flex;
  flex-direction: row;
}

#navbar-offline {
  margin-left: auto;
  margin-right: 2rem;
  display: inline-block;
}

#navbar-online {
  display: content;
  margin-left: auto;
  margin-right: 2rem;
  display: inline-block;
}

/* CSS button */

.btnLog,
.btnAddPost {
  padding: 5px 10px 5px 10px;
  width: 200px;
  border: none;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  text-align: center;
  font-family: "Roboto Condensed";
  text-transform: uppercase;
}
.btnUserProfile {
  padding: 5px 10px 5px 10px;
  width: 120px;
  border: none;
  margin-left: 10px;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  text-align: center;
  font-family: "Roboto Condensed";
  text-transform: uppercase;
}

/* Dropdown  */
#btn-toggler {
  width: 50px;
  height: 30px;
  margin-left: 25px;
  margin-bottom: 10px;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  font-weight: bold;
  text-align: center;
  font-family: "Roboto Condensed";
  text-transform: uppercase;
}

.btnLogOut {
  width: 50px;
  height: 50px;
  margin-left: 23px;
  padding: 1px 1px 1px 5px;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  cursor: pointer;
}
/* dropdown function */
.dropdown {
  display: inline-block;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: transparent;
  z-index: 1;
}

.dropdown-content a {
  display: block;
  color: white;
  background-color: transparent;
  z-index: 1;
}

.dropdown-content:hover {
  display: content;
  background-color: transparent;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
  color: #a47e16;
}
/* end dropdown function */

/* searchbar */
.post_search {
  margin-top: 15px;
  border: none;
  padding: 3px;
  text-align: center;
  border-radius: 12px;
}

.valid_search {
  margin: 7px;
  padding: 7px;
  border: none;
}
.searchPart {
  border: none;
}
.searchPart input {
  border: none;
}
/* CSS for Filter + Divers */
#filterCard {
  text-align: center;
}
.filters {
}

.BOXleft {
  background-color: #b8cbd0;
  font-family: "Roboto Condensed";
  font-weight: 200;
  font-size: 15px;
  color: #fffef6;
  width: 195px;
  height: auto;
  text-align: center;
  margin: 0 auto 1rem 1rem;
  float: inline-start;
  border-radius: 24px;
}
.form_search {
  text-align: center;
  cursor: pointer;
}

.form_radio {
  text-align: right;
  margin-right: 55px;
  margin-top: 10px;
  cursor: pointer;
}

.btnFilter {
  text-align: center;
  border: none;
  padding: 5px;
  margin: 5px;
  cursor: pointer;
}
.btnFilter_X {
  text-align: center;
  border: none;
  padding: 5px 10px 5px 10px;
  margin: 5px;
}
.btnFilter_ok {
  margin-left: 54px;
  text-align: center;
  border: none;
  padding: 10px;
  margin-top: 15px;
  cursor: pointer;
}
.btnFilter_del {
  text-align: center;
  border: none;
  padding: 10px;
  margin: 5px;
  cursor: pointer;
}

button {
  margin-top: 10px;
  border: none;
  font-family: "Roboto Condensed";
  font-weight: 200;
  font-size: 15px;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  cursor: pointer;
}
button:hover {
  background-color: #ffe59d;
  color: black;
}

/* Every posts  */
.CardsView {
  float: right;
  margin-top: 1rem;
  width: 80%;
}

/* Mobile view */
.navbar-mobile {
  display: none;
  text-align: center;
  background-color: #b8cbd0;
}

@media (max-width: 900px) {
  .btnLog {
    margin-left: 50%;
  }
  .BOXleft {
    display: none;
    float: none;
  }

  .CardsView {
    width: auto;
    display: inline-block;
  }
  .navbar-mobile {
    display: contents;
    text-align: center;
    background-color: #b8cbd0;
  }
}
</style>
