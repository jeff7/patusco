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
    <v-card title="Novo Usuário">
      <v-form 
        v-model="form" 
        @submit.prevent="createUser">
        <v-card-text>
          <v-text-field 
            label="Nome do Usuario" 
            :rules="[required]" 
            v-model="name" 
            type="text" 
            required>
          </v-text-field>
          <v-text-field 
            label="Email de Usuario" 
            v-model="newEmail" 
            :rules="[required]" 
            type="email"
            required>
          </v-text-field>
          <v-text-field 
            label="Senha" 
            :rules="[required]" 
            v-model="newPassword" 
            type="password" 
            required>
          </v-text-field>
          <v-select 
            :items="userTypes" 
            item-title="name" 
            item-value="id" 
            v-model="user_type" 
            label="Tipo de Usuário"
            required>
          </v-select>
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
            text="Criar" 
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
  name: 'NewUserModal',
  components: {
    Snackbar
  },
  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      isVisible: this.show,
      newEmail: '',
      newPassword: '',
      user_type: '',
      name: '',
      snackbar: {
        visible: false,
        message: '',
        color: ''
      },
      userTypes: [
        { id: 'D', name: 'Médico' },
        { id: 'R', name: 'Recepcionista' },
      ]
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
    async createUser() {
      try {
        const response = await axios.post('/user', {
          email: this.newEmail,
          password: this.newPassword,
          user_type: this.user_type,
          name: this.name
        })

        if (response.data.status === 'success') {
          this.isVisible = false;
          await localStorage.setItem('userType', this.user_type);
          await localStorage.setItem('user', response.data.authorization.token)
          window.location.href = '/home';
          this.showSnackbar('Usuário criado com sucesso!!', 'success');
        } else {
          this.isVisible = false;
          this.showSnackbar('Usuário não criado!!', 'error');
        }

      } catch (error) {
        this.showSnackbar('Usuário não criado!!', 'error');
      }
    }
  }
}
</script>
