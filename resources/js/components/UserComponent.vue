<template>
  <div>
    <h1>Usuários</h1>
    <form @submit.prevent="createUser">
      <input type="text" v-model="name" placeholder="Name">
      <input type="email" v-model="email" placeholder="Email">
      <input type="password" v-model="password" placeholder="Password">
      <input type="text" v-model="user_type" placeholder="Tipo de usuario">
      <button type="submit">Criar Usuário</button>
    </form>

    <ul>
      <li v-for="user in users" :key="user.id">
        {{ user.name }} - {{ user.email }}
        <button @click="deleteUser(user.id)">Deletar</button>
      </li>
    </ul>
  </div>
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
      users: [],
      name: '',
      email: '',
      password: '',
      user_type: ''
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    async getUsers() {
      const response = await axios.get('/user');
      this.users = response.data;
    },
    async createUser() {
      const response = await axios.post('/user', {
        name: this.name,
        email: this.email,
        password: this.password,
        user_type: this.user_type
      });
      this.users.push(response.data);
    },
    async deleteUser(id) {
      await axios.delete(`/user/${id}`);
      this.getUsers();
    }
  } 
}
</script>
