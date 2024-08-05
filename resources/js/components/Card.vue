<template>

  <Snackbar 
    v-model:show="snackbar.visible" 
    :color="snackbar.color" 
    :message="snackbar.message">
  </Snackbar>

  <v-card class="my-8 ">
    <v-card-title class="d-flex justify-space-between">
      {{ item.client_name }}
      <span>{{ formatDateTime }} - {{ periodTime }}</span>
    </v-card-title>
    <v-card-subtitle>
      <strong>Email: </strong>{{ item.email }}
    </v-card-subtitle>
    <v-card-text>
      <p>
        <strong>Médico: </strong>{{ item.user.name }}<br>
        <strong>Animal: </strong>{{ animalType }}<br>
        <strong>Nome do animal: </strong>{{ item.animal_name }}<br>
        <strong>Idade do animal: </strong>{{ item.age }}<br>
      </p>
      <p>
        <strong>Sintomas: </strong><br>
        {{ item.symptoms }}
      </p>
    </v-card-text>
    <v-card-actions>
      <v-btn 
        color="primary" 
        variant="flat" 
        @click="dialog = true">
        Editar
      </v-btn>
      <v-btn v-if=" allowDelete" 
        color="error" 
        variant="flat" 
        @click="deleteAppointment(item.id)">
        Excluir
      </v-btn>
    </v-card-actions>
  </v-card>

  <AppointmentModal 
    :isUpdate="true" 
    v-model:show="dialog" 
    :item="item" 
    :reload="reload">
  </AppointmentModal>

</template>

<script>
import axios from 'axios';
import moment from 'moment'
import Snackbar from '../components/Snackbar.vue'
import AppointmentModal from './modals/AppointmentModal.vue'

export default {
  name: 'Card',
  components: {
    Snackbar,
    AppointmentModal
  },
  props: {
    item: {
      type: Object,
      required: true
    },
    reload: {
      type: Function,
      required: true
    }
  },
  data() {
    return {
      id: this.item.id,
      client_name: this.item.client_name,
      animal_name: this.item.animal_name,
      animal_type: this.item.animal_type,
      age: this.item.age,
      symptoms: this.item.symptoms,
      appointment_date: this.item.appointment_date,
      email: this.item.email,
      period: this.item.period,
      dialog: false,
      isReadonly: true,
      user_id: this.item.user.id,
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
      snackbar: {
        visible: false,
        message: '',
        color: ''
      },
    };
  },
  
  methods: {
    showSnackbar(message, result) {
      this.snackbar.visible = true;
      this.snackbar.message = message;
      this.snackbar.color = result;
    },
    async deleteAppointment(id) {
      await axios.delete(`/appointment/${id}`)
        .then(
          async () => {
            this.dialog = false;
            await this.reload();
            this.showSnackbar('Agendamento deletado com sucesso!!', 'success')
          })
        .catch(
          async () => {
            this.dialog = false;
            await this.reload();
            this.showSnackbar('Agendamento não deletado!!', 'error')
          }
        );
    },
  },
  computed: {
    periodTime() {
      return this.item.period == 'M' ? 'Manhã' : 'Tarde';
    },
    formatDateTime() {
      return moment(this.item.appointment_date).format('HH:mm DD/MM/YYYY');
    },
    animalType() {
      let animal = this.animalTypes.find(item => item.id === this.animal_type);
      return animal ? animal.name : null;
    },
    allowDelete() {
      let type = localStorage.getItem('userType')
      return type == 'R' ? true : false
    },

  }
};
</script>

<style scoped>
.card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 16px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-title {
  margin: 0;
  font-size: 1.5em;
}

.card-content {
  margin-top: 16px;
}
</style>
