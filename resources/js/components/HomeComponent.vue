<template>
  <div class="content">
    <login-component></login-component>
  </div>
</template>

<script>
import LoginComponent from './LoginComponent.vue';

export default {
  name: 'HomeComponent',
  components: {
    LoginComponent
  },
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
  }</style>
