<template>
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
        <strong>Animal:</strong>{{ animalType }}<br>
        <strong>Nome do animal:</strong>{{ item.animal_name }}<br>
        <strong>Idade do animal:</strong>{{ item.age }}<br>
      </p>
      <p>
        <strong>Sintomas:</strong><br>
        {{ item.symptoms }}
      </p>
    </v-card-text>

    <v-card-actions>
      <v-btn color="primary" variant="flat" @click="dialog = true">
        Editar
      </v-btn>
      <v-btn v-if=" allowDelete" color="error" variant="flat" @click="deleteAppointment(item.id)">
        Excluir
      </v-btn>
    </v-card-actions>
  </v-card>

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
        <v-btn text="cancelar" color="error" variant="flat" @click="dialog = false"></v-btn>
        <v-btn text="Atualizar" color="primary" variant="flat" @click="updateAppointment"></v-btn>
      </template>
    </v-card>
  </v-dialog>

</template>

<script>
import axios from 'axios';
import moment from 'moment'

export default {
  name: 'Card',
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      appointments: [],
      doctors: [],
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
      user_id: 1
    };
  },
  
  methods: {
    async deleteAppointment(id) {
      await axios.delete(`/appointment/${id}`);
    },
    async updateAppointment() {
      const response = await axios.put(`/appointment/${this.id}`, {
        client_name: this.client_name,
        animal_name: this.animal_name,
        animal_type: this.animal_type,
        age: this.age,
        symptoms: this.symptoms,
        appointment_date: this.appointment_date,
        email: this.email,
        period: this.period,
        user_id: 1
      });
      this.appointments.push(response.data);
    },
  },
  computed: {
    periodTime() {
      return this.item.period == 'M' ? 'Manhã' : 'Tarde';
    },
    animalType() {
      const animalTypes = {
        C: 'Gato',
        D: 'Cachorro',
        F: 'Peixe',
        B: 'Ave',
      } 
      return animalTypes[this.item.animal_type];
    },
    formatDateTime() {
      return moment(this.item.appointment_date).format('HH:mm DD/MM/YYYY');
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
