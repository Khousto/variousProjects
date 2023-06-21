import { createApp } from "vue";
import App from "./App.vue";
import Toaster from "@meforma/vue-toaster";
import router from "./router";


const app = createApp(App);

app.use(router).use(Toaster);

app.mount("#app");
