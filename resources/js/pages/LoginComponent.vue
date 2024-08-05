<template>

  <Snackbar 
    v-model:show="snackbar.visible" 
    :color="snackbar.color" 
    :message="snackbar.message">
  </Snackbar>

  <div class="content">
    <v-container class="w-50">
      <v-card>
        <v-form 
          v-model="form" 
          @submit.prevent="login">
          <v-card-title>
            Acesse sua conta
          </v-card-title>
          <v-card-text>
            <v-form>
              <v-text-field 
                label="Email" 
                :rules="[required]" 
                v-model="email" 
                type="email" 
                required>
              </v-text-field>
              <v-text-field 
                label="Senha" 
                :rules="[required]" 
                v-model="password" 
                type="password"
                required>
              </v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions class="d-flex justify-space-between">
            <v-btn 
              color="primary" 
              class="mb-4 ml-4" 
              variant="flat" 
              type="submit">
              Acessar
            </v-btn>
            <v-btn 
              color="primary" 
              class="mb-4 mr-4"
              @click="newUser">
              Criar conta
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-container>
  </div>

  <NewUserModal v-model:show="dialog"></NewUserModal>

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
import Snackbar from '../components/Snackbar.vue';
import NewUserModal from '../components/modals/NewUserModal.vue'

export default {
  name: 'LoginComponent',
  components: {
    Snackbar,
    NewUserModal
  },
  data() {
    return {
      email: '',
      password: '',
      dialog: false,
      snackbar: {
        visible: false,
        message: '',
        color: ''
      },
    };
  },
  methods: {
    async login() {
        try {
          const response = await axios.post('/login', {
            email: this.email,
            password: this.password
          });

          if (response.data.status === 'success') {
            await localStorage.setItem('userType', response.data.user.user_type);
            await localStorage.setItem('user', response.data.authorization.token)
            window.location.href = '/home';
          }
        } catch (error) {
          this.showSnackbar('Usuario ou senha incorretos!!', 'error');
        }      
    },
    showSnackbar(message, result) {
      this.snackbar.visible = true;
      this.snackbar.message = message;
      this.snackbar.color = result;
    },
    newUser() {
      this.dialog = true
    }
  }
}
</script>

<style scoped>
.content {
  width: 100%;
  height: 100dvh;
  background-color: aliceblue;
  display: flex;
  padding: 16px;
  justify-content: center;
  align-items: center;
}
</style>
