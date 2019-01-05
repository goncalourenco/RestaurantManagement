<template>
  <v-container fluid>
    <v-card>
      <v-card-title>All tables
        <v-btn small fab dark color="indigo" @click="showAddTableFrom" v-if="!showCreate">
          <v-icon dark>add</v-icon>
        </v-btn>
      </v-card-title>
    </v-card>
    <v-data-table :headers="tableHeaders" :items="tables" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.table_number }}</td>
        <td class="text-xs-left">{{ props.item.created_at }}</td>
        <td class="text-xs-left">{{ props.item.updated_at }}</td>
        <td class="justify-center layout px-0">
          <v-icon small class="mr-2" @click="deleteTable(props.item.table_number)">delete</v-icon>
        </td>
      </template>
    </v-data-table>
    <br>
    <br>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      tableHeaders: [
        {
          text: "Table",
          align: "left",
          sortable: true,
          value: "name"
        },
        { text: "Created at", value: "meal" },
        { text: "Updated at", value: "state", align: "left" },
        { text: "Actions", value: "name", sortable: false }
      ]
    };
  },
  props: ["tables", "showCreate"],
  methods: {
    deleteTable(id) {
      this.$emit("delete-table", id);
    },
    showAddTableFrom() {
      this.$emit("show-form");
    }
  }
};
</script>

