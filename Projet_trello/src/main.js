import { createApp } from "vue";
import Toaster from "@meforma/vue-toaster";
import App from "./App.vue";
import router from "./router";

// import "./assets/main.css";

const app = createApp(App);

app.use(router).use(Toaster);

app.mount("#app");
