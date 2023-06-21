import { createRouter, createWebHistory } from "vue-router";
import MainView from "../views/MainView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "postit",
      component: MainView,
    },
    {
      path: "/NewPostView",
      name: "newpostview",
      component: () => import("../views/NewPostView.vue"),
    },
    // {
    //   path: "/BigPostView/:id",
    //   name: "postitVisual",
    //   props: { id : true },
    //   component: () =>import("../views/BigPostView.vue"),
    // },
    {
      path: "/BigPostView/:title/:content/:id",
      name: "postitVisual",
      component: () => import("../views/BigPostView.vue"),
    }
  ],
});

export default router;
