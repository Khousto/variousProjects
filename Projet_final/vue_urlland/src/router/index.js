import { createRouter, createWebHistory } from "vue-router";
import MainView from "../views/MainviewView.vue";
import IdentificationView from "../views/IdentificationView.vue";
import CardView from "../views/CardView.vue";
import AdminView from "../views/AdminView.vue";
import AdminUserView from "../views/AdminUserView.vue";
import AdminStatView from "../views/AdminStatView.vue";
import AdminPostView from "../views/AdminPostView.vue";
import NewPostView from "../views/NewpostView.vue";
import ProfilView from "../views/ProfilView.vue";
import PostToModifyView from "../views/PostToModifyView.vue";
import CommentToModifyView from "../views/CommentToModifyView.vue";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "main",
      component: MainView,
    },
    {
      path: "/cardView/:id",
      name: "customer",
      component: CardView,
    },
    {
      path: "/Identification",
      name: "id",
      component: IdentificationView,
    },
    {
      path: "/profil",
      name: "profil",
      component: ProfilView,
    },
    {
      path: "/postToModify/:id",
      name: "postToModify",
      component: PostToModifyView,
    },
    {
      path: "/commentToModify/:id",
      name: "commentToModify",
      component: CommentToModifyView,
    },

    {
      path: "/admin",
      name: "admin",
      component: AdminView,
    },
    {
      path: "/adminUser/:id",
      name: "adminUser",
      component: AdminUserView,
    },
    {
      path: "/stats",
      name: "stats",
      component: AdminStatView,
    },
    {
      path: "/adminPost/:id",
      name: "adminPost",
      component: AdminPostView,
    },
    {
      path: "/newpost",
      name: "newPost",
      component: NewPostView,
    },
  ],
});

export default router;
