<script setup>
import { RouterLink } from "vue-router";
import headerAdminComponent from "../components/headerAdminComponent.vue";
import Footer from "../components/footerComponent.vue";
import { Chart } from "chart.js/auto";
import { resolveDirective } from "vue";
</script>

<script>
export default {
  data() {
    return {
      average: 0,
      total: 0,
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
  },
  mounted() {
    // Chart 1
    fetch("http://127.0.0.1:8000/api/stats/postsByCategory")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        const ctx = document.getElementById("chart1");

        new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: data.map((element) => element.category),
            datasets: [
              {
                label: "Nombre de publications par catégorie",
                data: data.map((element) => element.nb_posts),
                borderWidth: 1,
                backgroundColor: [
                  "#606c5a",
                  "#b0b9a8",
                  "#424340",
                  "#a47e16",
                  "#b8cbd0",
                ],
              },
            ],
          },
          //   options: {
          //     scales: {
          //       y: {
          //         beginAtZero: true,
          //       },
          //     },
          //   },
        });
      });
    // Chart 2
    fetch("http://127.0.0.1:8000/api/stats/postsByUser")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        const ctx = document.getElementById("chart2");

        new Chart(ctx, {
          type: "bar",
          data: {
            labels: data.map((element) => element.nickname),
            datasets: [
              {
                label: "Nombre de publications par utilisateur (5 premiers)",
                data: data.map((element) => element.nb_posts),
                borderWidth: 1,
                backgroundColor: [
                  "#606c5a",
                  "#b0b9a8",
                  "#424340",
                  "#a47e16",
                  "#b8cbd0",
                ],
              },
            ],
          },
        });
      });
    // Chart 3
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
        const resultat =
          parseFloat(data.comments[0].nb_comments) /
          parseFloat(data.posts[0].nb_posts);
        this.average = resultat.toFixed(2);
      });
    // Chart 4
    fetch("http://127.0.0.1:8000/api/stats/numberTotal")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        console.log(data.total[0].sumTotal);
        this.total = data.total[0].sumTotal;
      });
    // Chart 5
    fetch("http://127.0.0.1:8000/api/stats/postsByDate")
      .then(function (res) {
        if (res.ok) {
          return res.json();
        }
      })
      .then((data) => {
        const ctx = document.getElementById("chart5");
        new Chart(ctx, {
          type: "line",
          data: {
            labels: data.map((element) => element.date),
            datasets: [
              {
                label: "Nombre de publications par jour (3 derniers jours)",
                data: data.map((element) => element.nb_posts),
                borderWidth: 3,
                borderColor: "#606c5a",
                backgroundColor: "#606c5a",
              },
            ],
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
              },
            },
          },
        });
      });
  },
  methods: {
    goToAdmin() {
      this.$router.push("/admin");
    },
    goBack() {
      this.$router.push("/");
    },
  },
};
</script>

<template>
  <div class="body3">
    <headerAdminComponent />
    <div class="centre_page">
      <div class="admin_button stat">
        <button class="back" @click="goToAdmin()">Espace administrateur</button>
        <button class="back" @click="goBack()">Accueil</button>
      </div>
      <div class="chart">
        <canvas id="chart1"></canvas>
      </div>
      <div class="chart">
        <canvas id="chart2"></canvas>
      </div>
      <div class="chart">
        <p>Nombre moyen de commentaires par publications</p>
        <p id="chart3">{{ average }}</p>
      </div>
      <div class="chart">
        <p>Nombre total de connexions</p>
        <p id="chart4">{{ total }}</p>
      </div>
      <div class="chart">
        <canvas id="chart5"></canvas>
      </div>
    </div>
    <Footer />
  </div>
</template>

<style scoped>
template {
  display: flex;
  flex-direction: column;
}
.body3 {
  display: flex;
  flex-direction: column;
  background-color: white;
  margin: 0;
  min-height: 100vh;
}

.centre_page {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}
.admin_button {
  display: flex;
  flex-direction: column;
}

.back {
  margin: 20px auto;
}
.stat {
  width: 30%;
  margin: 30px;
  height: 280px;
}

.chart {
  width: 500px;
  height: 400px;
  margin: 20px 10px;
}

.chart p {
  text-align: center;
  color: #606c5a;
}

#chart3,
#chart4 {
  color: #a47e16;
  font-size: 100px;
  font-weight: bold;
  text-align: center;
}
</style>
