<template>
  <v-container fluid>
    <v-btn @click.prevent="showHideTable" v-if="!showTableManagement">Table Management</v-btn>
    <table-management v-if="showTableManagement" @close="showHideTable"></table-management>
  </v-container>
</template>
<script>
import tableManagement from "./tables/tableManagement.vue";
export default {
  data() {
    return {
      showTableManagement: false
    };
  },
  components: {
    tableManagement
  },
  methods: {
    showHideTable: function() {
      this.showTableManagement = !this.showTableManagement;
    }
  }
};
</script>
