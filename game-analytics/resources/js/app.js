import "./bootstrap";
import { createApp } from "vue";
import router from "./router/index";
import App from "./App.vue";
import VueChartkick from "vue-chartkick";
import "chartkick/chart.js";

const app = createApp(App);

app.use(VueChartkick);

app.use(router);

app.mount("#app");
