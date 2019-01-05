<template>
  <v-container>
    <v-container v-if="showCreateTable">
      <create-table @create-table="createTable" @cancel="cancelCreateTable"></create-table>
    </v-container>
    <table-list
      :show-create="showCreateTable"
      :tables="tables"
      @delete-table="deleteTable"
      @show-form="showAddTableFrom"
    ></table-list>
    <v-btn @click.prevent="close">Close</v-btn>
  </v-container>
</template>
<script>
import tableList from "./tableList.vue";
import createTable from "./create.vue";
export default {
  data() {
    return {
      tables: [],
      showCreateTable: false
    };
  },
  methods: {
    getTables: function() {
      axios
        .get("api/tables")
        .then(response => {
          this.tables = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    createTable(tableNumber) {
      let valid = true;
      this.tables.forEach(table => {
        if (table.table_number == tableNumber) {
          window.alert("The table you are trying to create already exists");
          valid = false;
        }
      });
      if (valid) {
        let data = {
          table_number: tableNumber
        };
        axios.post("api/tables", data).then(response => {
          this.getTables();
          this.showCreateTable = false;
        });
      }
    },
    cancelCreateTable: function(tableNumber) {
      this.showCreateTable = false;
    },
    deleteTable: function(id) {
      axios.delete("api/table/" + id).then(response => {
        this.getTables();
      });
    },
    showAddTableFrom: function() {
      this.showCreateTable = true;
    },
    close() {
      this.$emit("close");
    }
  },
  components: {
    tableList,
    createTable
  },
  mounted() {
    this.getTables();
  }
};
</script>
