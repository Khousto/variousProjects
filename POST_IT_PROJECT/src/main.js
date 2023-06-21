import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import Toaster from "@meforma/vue-toaster";

import "./assets/main.css";
// import responsive from 'vue-responsive';

// Vue.use(responsive);

const app = createApp(App);

app.use(router).use(Toaster);

app.mount("#app");
