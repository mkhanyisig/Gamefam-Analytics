import { createRouter, createWebHistory } from "vue-router";
import HomeRoute from "../Pages/HomeRoute.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomeRoute,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
