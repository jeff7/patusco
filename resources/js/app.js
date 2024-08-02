import { createApp } from "vue";
import "vuetify/styles";
import '@mdi/font/css/materialdesignicons.css'; // Ícones
import { createVuetify } from "vuetify";

import axios from "axios";
import UserComponent from "./components/UserComponent.vue";
import AppointmentComponent from "./components/AppointmentComponent.vue";
import LoginComponent from "./components/LoginComponent.vue";
import HomeComponent from "./components/HomeComponent.vue";

const vuetify = createVuetify(); // Cria uma instância do Vuetify


axios.defaults.baseURL = "http://localhost:8000/api";

const app = createApp({
    components: {
        UserComponent,
        AppointmentComponent,
        LoginComponent,
        HomeComponent,
    },
});

app.config.globalProperties.$axios = axios;

app.use(vuetify);
app.component("user-component", UserComponent);
app.component("appointment-component", AppointmentComponent);
app.component("login-component", LoginComponent);
app.component("home-component", HomeComponent);
app.mount("#app");
