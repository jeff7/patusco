<template>

  <Snackbar 
    v-model:show="snackbar.visible" 
    :color="snackbar.color" 
    :message="snackbar.message">
  </Snackbar>

  <v-container class="w-80 home">
    <div>
      <div class="d-flex justify-space-between mb-10">
        <h1>Agendamentos</h1>
        <div>
          <v-btn v-if="isRecepcionist" 
            color="primary" 
            @click="dialog = true">
            Novo Agendamento
          </v-btn>
          <v-btn 
            class="ml-4" 
            color="error" 
            @click="logout">
            Sair
          </v-btn>
        </div>
      </div>

      <div class="d-flex justify-space-between">
        <v-col cols="12" sm="4">
          <h2>Filtre o agendamento por:</h2>
        </v-col>
        <v-col cols="12" sm="4">
          <v-select 
            :items="animalTypes" 
            item-title="name" 
            item-value="id" 
            v-model="animal_filter" 
            label="O animal é: "
            required>
          </v-select>
        </v-col>
        <v-col cols="12" sm="4">
          <v-text-field 
            label="Data 00/00/0000" 
            v-mask="'##/##/####'" 
            v-model="data_filter" 
            type="text">
          </v-text-field>
        </v-col>
      </div>

      <div v-if="appointments.length > 0" v-for="appointment in appointments" :key="appointment.id">
        <card 
          :item="appointment" 
          :reload="getAppointments">
        </card>
      </div>

      <div v-else class="w-100 d-flex justify-center mt-12">
        <h2>Você não tem agendamentos</h2>
      </div>

      <AppointmentModal 
        :isUpdate="false" 
        v-model:show="dialog" 
        :reload="getAppointments">
      </AppointmentModal>
    </div>
  </v-container>
</template>

<script>
import axios from 'axios';
import Card from '../components/Card.vue';
import Snackbar from '../components/Snackbar.vue'
import AppointmentModal from '../components/modals/AppointmentModal.vue'

export default {
  name: 'AppointmentComponent',
  components: {
    Card,
    AppointmentModal
  },
  data() {
    return {
      appointments: [],
      client_name: '',
      animal_name: '',
      animal_type: '',
      age: '',
      symptoms: '',
      appointment_date: '',
      email: '',
      period: '',
      dialog: false,
      user_id: null,
      animal_filter: 'A',
      data_filter: '',
      snackbar: {
        visible: false,
        message: '',
        color: ''
      },
      animalTypes: [
        { id: 'B', name: 'Ave' },
        { id: 'D', name: 'Cachorro' },
        { id: 'F', name: 'Peixe' },
        { id: 'C', name: 'Gato' },
        { id: 'A', name: 'Todos' }
      ],
      periodTypes: [
        { id: 'T', name: 'Tarde' },
        { id: 'M', name: 'Manha' },
      ],
    };
  },
  mounted() {
    this.getAppointments();
  },
  watch: {
    animal_filter: 'getAppointments',
    data_filter: 'filterDate',
  },
  computed: {
    isRecepcionist() {
      let type = localStorage.getItem('userType')
      return type == 'R' ? true : false
    },
  },
  methods: {
    buildUrl(baseUrl, params) {
      const queryParams = new URLSearchParams(params).toString();

      return `${baseUrl}?${queryParams}`;
    },
    async logout() {
      await localStorage.removeItem('userType');
      await localStorage.removeItem('user')
      window.location.href = '/';
    },
    async getAppointments(formated = '') {
      const search = '/appointment'

      let params = {};

      if (this.animal_filter && this.animal_filter != 'A')
        params.tipo = this.animal_filter;

      if (this.data_filter && this.data_filter != '')
        params.data = formated;

      const url = this.buildUrl(search, params);

      const response = await axios.get(url);
      this.appointments = response.data;
    },
    async filterDate() {
      if (this.data_filter.length == 10 || this.data_filter.length == 0)
        this.getAppointments(this.data_filter.split('/').reverse().join('-'));
    },
    showSnackbar(message, result) {
      this.snackbar.visible = true;
      this.snackbar.message = message;
      this.snackbar.color = result;
    },
  }
}
</script>

<style>
.home {
  background-color: whitesmoke;
  height: 100dvh;
}
</style>
