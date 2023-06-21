<script setup>
import headerMainComponent from "../components/headerMainComponent.vue";
import Footer from "../components/footerComponent.vue";
</script>

<script>
/* function register */
const URL = "http://127.0.0.1:8000/api/register/user";

export default {
  data() {
    return {
      newUser: { nickname: "", email: "", password: "", passwordV2: "" },
      User: { email: "", password: "" },
      idVerif: 0,
    };
  },
  methods: {
    async func_Login() {
      const url = "http://127.0.0.1:8000/api/connexion";
      await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          email: this.User.email,
          password: this.User.password,
        }),
      }).then(async (res) => {
        if (res.status !== 200) {
          const error = await res.json();
          alert(error);
        } else {
          await res.json().then((response) => {
            window.localStorage.setItem("id", response);
            console.log(localStorage.getItem("id"));
            this.idVerif = localStorage.getItem("id");
          });
          fetch("http://127.0.0.1:8000/api/user/isadmin/" + this.idVerif)
            .then(async (res) => {
              const response = await res.text();
              console.log(response);
              if (response == "is admin") {
                this.$router.push("/admin");
              } else {
                this.$router.push("/");
              }
            })
            .catch((err) => console.log(err));
          fetch(
            "http://127.0.0.1:8000/api/user/number/connexion/" + this.idVerif,
            {
              method: "POST",
              headers: { "Content-Type": "application/json" },
            }
          );
        }
      });
    },
    func_Register() {
      fetch(URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          nickname: this.newUser.nickname,
          email: this.newUser.email,
          password: this.newUser.password,
          passwordV2: this.newUser.passwordV2,
        }),
      })
        .then((res) => res.json())
        .then((data) => console.log(data));
      alert("Inscription réussie.").catch((error) => console.log("Fail"));
    },
  },
};
</script>

<template>
  <headerMainComponent />
  <RouterLink to="/"><button id="btnReturn">Retour</button></RouterLink>

  <div class="containers">
    <div class="Inscription">
      <h3>INSCRIPTION</h3>
      <form>
        <label for="nickname">Pseudonyme</label>
        <input type="text" name="nickname" v-model="newUser.nickname" />
        <label for="email">Email</label>
        <input type="email" name="email" v-model="newUser.email" />
        <label for="password">Mot de passe</label>
        <input type="password" name="password" v-model="newUser.password" />
        <label for="passwordV2">Confirmation du mot de passe</label>
        <input type="password" name="passwordV2" v-model="newUser.passwordV2" />
        <button type="submit" id="btnRegister" @click="func_Register()">
          Je m'inscris
        </button>
      </form>
    </div>
    <div class="Connection">
      <h3>CONNEXION</h3>
      <form>
        <label for="email">Adresse Email</label>
        <input type="email" id="email" name="email" v-model="User.email" />
        <label for="password">Mot de passe</label>
        <input type="password" id="pwd" name="password" v-model="User.password" />
      </form>
      <button id="btnConnection" @click="func_Login()">Je me connecte</button>
    </div>
  </div>

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

h3 {
  font-family: 'Roboto Condensed';
  font-weight: 400;
  font-size: 25px;
  text-align: center;
}
.containers{
  display: flex;
  flex-direction: row;
  justify-content: center;
}

/* CSS for form part */
.Inscription {
  background-color: #FFFEF6;
  width: 400px;
  height: 410px;
  border-radius: 24px;
  margin-right: 10px;
  padding: 10px;
}

.Connection {
  background-color: #FFFEF6;
  width: 400px;
  height: 410px;
  border-radius: 24px;
  margin-left: 10px;
  padding: 10px;
}

form {
  display: flex;
  flex-direction: column;
  font-family: 'Roboto Condensed';
  font-weight: 200;
  text-transform: uppercase;

}

label {
  margin-left: 1rem;
  margin-top: 15px;
}

input {
  display: flex;
  flex-direction: column;
  font-family: 'Roboto Condensed';
  font-size: 15px;
  border: none;
  border-radius: 12px;
  padding: 7px;
  background-color: rgba(184, 203, 208, 1);
}


/* CSS for Buttons */

#btnConnection {
  padding: 5px 10px 5px 10px;
  width: 120px;
  border: none;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  margin-left: 65%;
  margin-top: 20px;
}

#btnReturn {
  padding: 5px 10px 5px 10px;
  margin-left: 80%;
  margin-top: 1rem;
  width: 120px;
  border: none;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
}

#btnRegister {
  padding: 5px 10px 5px 10px;
  width: 120px;
  border: none;
  background-color: #a47e16;
  color: white;
  border-radius: 12px;
  margin-left: 65%;
  margin-top: 20px;
}

/* Reactive */
@media (max-width: 900px) {
  .Inscription {
    float: right;
    margin-right: 2rem;
    margin-left: 2rem;
    margin-bottom: 2rem;
  }

  .Connection {
    margin-right: 2rem;
    margin-left: 2rem;
  }

  #btnReturn {
    margin-left: 67%;
  }
}
</style>
