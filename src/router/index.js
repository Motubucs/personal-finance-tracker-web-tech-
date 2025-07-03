import { createRouter, createWebHashHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue";

const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
  },
  {
    path: "/add",
    name: "AddForm",
    component: () => import("../views/AddForm.vue"),
  },
  {
    path: "/update/:id",
    name: "UpdateForm",
    component: () => import("../views/UpdateForm.vue"),
    props: true,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
