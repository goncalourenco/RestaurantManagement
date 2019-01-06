<template>
  <v-container fluid>
    <v-card>
      <v-card-title>Pending invoices</v-card-title>
    </v-card>
    <v-data-table :headers="invoiceHeaders" :items="invoices" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.id }}</td>
        <td class="text-xs-left">{{ props.item.table_number }}</td>
        <td class="text-xs-left">{{ props.item.waiter_name }}</td>
        <td class="text-xs-left">{{ props.item.meal_id }}</td>
        <td class="text-xs-left">{{ props.item.total_price }}</td>
        <td class="text-xs-left">{{ props.item.state }}</td>
        <td class="justify-center layout px-0">
          <v-icon small class="mr-2" @click.prevent="details(props.item)">details</v-icon>
          <v-icon small class="mr-2" @click.prevent="edit(props.item)">edit</v-icon>
          <v-icon
            small
            class="mr-2"
            v-if="props.item.name != null && props.item.nif !=null"
            @click="setAsPaid(props.item)"
          >done</v-icon>
        </td>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  props: ["invoices"],
  data() {
    return {
      invoiceHeaders: [
        {
          text: "ID",
          align: "left",
          sortable: true,
          value: "name"
        },
        { text: "Table Number", value: "tablenumber" },
        { text: "Waiter Name", value: "waiterName", align: "left" },
        { text: "Meal ID", value: "mealID", align: "left" },
        { text: "Total price", value: "totalPrice", align: "left" },
        { text: "State", value: "state", align: "left" },
        { text: "Actions", value: "name", sortable: false }
      ]
    };
  },
  methods: {
    details(invoice) {
      this.$emit("details", invoice);
    },
    edit(invoice) {
      this.$emit("edit", invoice);
    },
    setAsPaid(invoice) {
      this.$emit("pay", invoice);
    }
  }
};
</script>

