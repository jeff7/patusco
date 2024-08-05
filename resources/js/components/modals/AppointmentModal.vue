<template>

  <Snackbar 
    v-model:show="snackbar.visible" 
    :color="snackbar.color" 
    :message="snackbar.message">
  </Snackbar>

  <v-dialog 
    v-model="isVisible" 
    width="650px" 
    persistent>
    <v-card :title="isUpdateTitle">
      <v-form 
        v-model="form" 
        @submit.prevent="createOrUpdate">
        <v-card-text>
          <v-text-field 
            label="Nome do Cliente" 
            :rules="[required]" 
            v-model="client_name" 
            type="text"
            required>
          </v-text-field>
          <v-text-field 
            label="Email de contato" 
            v-model="email" 
            :rules="[required]" 
            type="email"
            required>
          </v-text-field>
          <v-text-field 
            label="Data do atendimento yyyy-mm-dd hh:min" 
            :rules="[required]" 
            v-model="appointment_date"
            type="text" 
            required>
          </v-text-field>
          <v-text-field 
            label="Nome do animal" 
            v-model="animal_name" 
            type="text" 
            required>
          </v-text-field>
          <div class="d-flex justify-space-between">
            <v-col cols="12" sm="4">
              <v-select 
                :items="animalTypes" 
                item-title="name" 
                item-value="id" 
                v-model="animal_type"
                label="O animal é: " required>
              </v-select>
            </v-col>
            <v-col cols="12" sm="4">
              <v-text-field 
                label="Idade do animal" 
                v-model="age" 
                type="number" required>
              </v-text-field>
            </v-col>
            <v-col cols="12" sm="4">
              <v-select 
              :items="periodTypes" 
                v-model="period" 
                item-title="name" 
                item-value="id" 
                label="Periodo do dia"
                required>
              </v-select>
            </v-col>
          </div>
          <v-text-field 
            label="Quais os sintomas do animal?" 
            v-model="symptoms" 
            type="text" 
            required>
          </v-text-field>
          <v-select 
            :items="doctors" 
            item-title="name" 
            item-value="id" 
            v-model="user_id" 
            label="Médico Veterinário"
            required></v-select>
        </v-card-text>
        <v-card-actions class="d-flex justify-space-between p8">
          <v-btn 
            text="cancelar" 
            color="error" 
            class="mb-4 ml-4" 
            variant="flat" 
            @click="isVisible = false">
          </v-btn>
          <v-btn 
            :text="isUpdateButtonLabel" 
            color="primary" 
            class="mb-4 mr-4" 
            variant="flat" 
            type="submit">
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>

</template>

<script setup>
  import { ref } from 'vue'

  const form = ref(false)

  function required(v) {
    return !!v || 'Field is required'
  }
</script>

<script>
import axios from 'axios';
import Snackbar from '../Snackbar.vue';

export default {
  name: 'AppointmentModal',
  components: {
    Snackbar
  },
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    isUpdate: {
      type: Boolean,
    },
    reload: {
      type: Function,
      required: true
    },
    item: {
      type: Object,
    },
  },
  computed: {
    isUpdateTitle() {
      return this.isUpdate ? "Atualizar agendamento" : "Novo agendamento"
    },
    isUpdateButtonLabel() {
      return this.isUpdate ? "Atualizar" : "Agendar"
    },
  },
  mounted() {
    this.getDoctors();
  },
  data() {
    return {
      isVisible: this.show,
      doctors: [],
      id: this?.item?.id || '',
      client_name: this?.item?.client_name || '',
      animal_name: this?.item?.animal_name || '',
      animal_type: this?.item?.animal_type || '',
      age: this?.item?.age || '',
      symptoms: this?.item?.symptoms || '',
      appointment_date: this?.item?.appointment_date || '',
      email: this?.item?.email || '',
      period: this?.item?.period || '',
      user_id: this?.item?.user_id || null, 
      snackbar: {
        visible: false,
        message: '',
        timeout: 3000,
        color: ''
      },
      animalTypes: [
        { id: 'B', name: 'Ave' },
        { id: 'D', name: 'Cachorro' },
        { id: 'F', name: 'Peixe' },
        { id: 'C', name: 'Gato' },
      ],
      periodTypes: [
        { id: 'T', name: 'Tarde' },
        { id: 'M', name: 'Manha' },
      ],
    };
  },
  watch: {
    show(newVal) {
      this.isVisible = newVal;
    },
    isVisible(newVal) {
      this.$emit('update:show', newVal);
    },
  },
  methods: {
    showSnackbar(message, result) {
      this.snackbar.visible = true;
      this.snackbar.message = message;
      this.snackbar.color = result;
    },
    async getDoctors() {
      const response = await axios.get('/doctors');
      this.doctors = response.data;
    },
    async createOrUpdate() {
      this.isUpdate ? this.updateAppointment() : this.createAppointment()
    },
    async createAppointment() {
      await axios.post('/appointment', {
        client_name: this.client_name,
        animal_name: this.animal_name,
        animal_type: this.animal_type,
        age: this.age,
        symptoms: this.symptoms,
        appointment_date: this.appointment_date,
        email: this.email,
        period: this.period,
        user_id: this.user_id
      }).then(async () => {
        this.showSnackbar('Agendamento criado com sucesso!!', 'success')
        this.isVisible = false;
        await this.reload();
      })
        .catch(
          async () => {
            this.showSnackbar('Agendamento não criado!!', 'error')
            this.isVisible = false;
            await this.reload();
          }
        );
    },
    async updateAppointment() {
      await axios.put(`/appointment/${this.id}`, {
        client_name: this.client_name,
        animal_name: this.animal_name,
        animal_type: this.animal_type,
        age: this.age,
        symptoms: this.symptoms,
        appointment_date: this.appointment_date,
        email: this.email,
        period: this.period,
        user_id: this.user_id
      })
        .then(
          async () => {
            this.isVisible = false;
            await this.reload();
            this.showSnackbar('Agendamento atualizado com sucesso!!', 'success')
          })
        .catch(
          async () => {
            this.isVisible = false;
            await this.reload();
            this.showSnackbar('Agendamento não atualizado!!', 'error')
          }
        );
    },
  }
}
</script>
