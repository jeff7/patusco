import { createApp } from "vue";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import VueTheMask from "vue-the-mask";

import axios from "axios";
import AppointmentComponent from "./pages/AppointmentComponent.vue";
import LoginComponent from "./pages/LoginComponent.vue";

const vuetify = createVuetify(); 

let token = await localStorage.getItem("user");
axios.defaults.baseURL = "http://localhost:8000/api";
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
axios.defaults.headers.common["Accept"] = "application/json";

const app = createApp({
    components: {
        AppointmentComponent,
        LoginComponent,
    },
});

app.config.globalProperties.$axios = axios;

app.use(vuetify);
app.use(VueTheMask);
app.component("appointment-component", AppointmentComponent);
app.component("login-component", LoginComponent);
app.mount("#app");
