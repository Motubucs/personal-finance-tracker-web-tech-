import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

// ✅ GLOBAL axios setup
import axios from "axios";
axios.defaults.headers.post["Content-Type"] = "application/json";

const app = createApp(App);
app.use(Toast);
app.use(router);
app.mount("#app");
