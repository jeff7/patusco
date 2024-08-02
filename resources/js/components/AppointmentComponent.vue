<template>
  <v-container class="w-80">
    <div>
      <div class="d-flex justify-space-between mb-10">
        <h1>Agendamentos</h1>
        <v-btn color="primary" @click="dialog = true">
          Novo Agendamento
        </v-btn>
      </div>

      <div v-for="appointment in appointments" :key="appointment.id">
        <card :item="appointment"></card>
      </div>

      <v-dialog v-model="dialog" width="650px" persistent>
        <v-card title="Novo agendamento">
          <v-card-text>
            <v-text-field label="Nome do Cliente" v-model="client_name" type="text" required></v-text-field>
            <v-text-field label="Email de contato" v-model="email" type="email" required></v-text-field>
            <v-text-field label="Data do atendimento hh:min dd/mm/yy" v-model="appointment_date" type="text"
              required></v-text-field>
            <v-text-field label="Nome do animal" v-model="animal_name" type="text" required></v-text-field>
            <div class="d-flex justify-space-between">
              <v-col cols="12" sm="4">
                <v-select :items="['Cachorro', 'Gato', 'Peixe', 'Ave']" v-model="animal_type" label="O animal é: "
                  required></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field label="Idade do animal" v-model="age" type="number" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select :items="['Tarde', 'Manha']" v-model="period" label="Periodo do dia" required></v-select>
              </v-col>
            </div>
            <v-text-field label="Quais os sintomas do animal?" v-model="symptoms" type="text" required></v-text-field>
            <v-select :items="doctors" v-model="user_id" label="Médico Veterinário" required></v-select>
          </v-card-text>
          <template v-slot:actions>
            <v-btn text="cancelar" color="error" variant="flat" @click="hanldeClose"></v-btn>
            <v-btn text="Agendar" color="primary" variant="flat" @click="createUser"></v-btn>
          </template>
        </v-card>
      </v-dialog>

    </div>
  </v-container>
</template>

<script>
import axios from 'axios';
import Card from './Card.vue';

export default {
  name: 'UserComponent',
  components: {
    Card
  },
  data() {
    return {
      appointments: [],
      doctors: [],
      client_name: '',
      animal_name: '',
      animal_type: '',
      age: '', 
      symptoms: '',
      appointment_date: '',
      email: '',
      period: '',
      dialog: false,
      user_id: ''
    };
  },
  mounted() {
    this.getAppointments();
    this.getDoctors();
  },
  methods: {
    async getAppointments() {
      const response = await axios.get('/appointment');
      this.appointments = response.data;
    },
    async getDoctors() {
      const response = await axios.get('/user');
      this.doctors = response.data.map(user => user.name);
    },
    hanldeClose() {
      this.client_name = '',
      this.animal_name = '',
      this.animal_type = '',
      this.age = '',
      this.symptoms = '',
      this.appointment_date = '',
      this.email = '',
      this.period = '',
      this.user_id = ''
      this.dialog = false;
    },
    async createAppointment() {
      const response = await axios.post('/appointment', {
        client_name: this.client_name,
        animal_name: this.animal_name,
        animal_type: this.animal_type,
        age: this.age,
        symptoms: this.symptoms,
        appointment_date: this.appointment_date,
        email: this.email,
        period: this.period
      });
      this.appointments.push(response.data);
    },
  } 
}
</script>
