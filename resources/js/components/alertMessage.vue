<template>
  <v-alert :value="showAlert" dismissible :color="typeOfMsg" icon="warning" outline>{{message}}</v-alert>
</template>

<script>
export default {
  props: ["message", "showAlert", "typeOfMsg"]
};
</script>
