<template>
  <v-snackbar 
    location="top" 
    v-model="isVisible" 
    :timeout="3000" 
    :color="color">
    {{ message }}
  </v-snackbar>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    color: {
      type: String,
      default: 'primary',
    },
    message: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      isVisible: this.show,
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
};
</script>
