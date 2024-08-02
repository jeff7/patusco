<template>
  <v-container class="w-50">
    <v-card>
      <v-card-title>
        Acesse sua conta
      </v-card-title>

      <v-card-text>
        <v-form>
          <v-text-field label="Email" v-model="email" type="email" required></v-text-field>
          <v-text-field label="Senha" v-model="password" type="password" required></v-text-field>
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-btn color="primary" @click="login">
          Acessar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: ''
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
            await localStorage.setItem('user', response.data.user.user_type)
            window.location.href = '/home';
          }
        } catch (error) {
          alert('Login failed');
        }      
    }
  }
}
</script>

