<template>
  <v-container fluid>
    <v-layout row>
      <v-btn @click.prevent="showHideTable" v-if="!showTableManagement">Table Management</v-btn>
      <v-btn @click.prevent="showHideUsers" v-if="!showUserManagement">User Management</v-btn>
    </v-layout>
    <table-management v-if="showTableManagement" @close="showHideTable"></table-management>
    <user-management v-if="showUserManagement" @close="showHideUsers"></user-management>
  </v-container>
</template>
<script>
import tableManagement from "./tables/tableManagement.vue";
import userManagement from "./users/userManagement.vue";
export default {
  data() {
    return {
      showTableManagement: false,
      showUserManagement: false
    };
  },
  components: {
    tableManagement,
    userManagement
  },
  methods: {
    showHideTable: function() {
      this.showTableManagement = !this.showTableManagement;
      this.showUserManagement = false;
    },
    showHideUsers: function() {
      this.showUserManagement = !this.showUserManagement;
      this.showTableManagement = false;
    }
  }
};
</script>
