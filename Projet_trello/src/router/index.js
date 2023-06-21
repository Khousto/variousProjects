import { createRouter, createWebHistory } from "vue-router";
import MainView from "../views/MainView.vue";
import NewListView from "../views/NewListView.vue";
import NewCardView from "../views/NewCardView.vue";
import DisplayCardView from "../views/DisplayCardView.vue";
import DisplayListView from "../views/DisplayListView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "main",
      component: MainView,
    },
    {
      path: "/newlist",
      name: "newlist",
      component: NewListView,
    },

    {
      path: "/newcard/:idlist",
      name: "newcard",
      component: NewCardView,
    },
    {
      path: "/displaylist/:id",
      name: "displaylist",
      component: DisplayListView,
    },
    {
      path: "/displaycard/:id",
      name: "displaycard",
      component: DisplayCardView,
    },
  ],
});

export default router;
