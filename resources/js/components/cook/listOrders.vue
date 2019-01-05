<template>
  <v-container fluid>
    <v-card>
      <v-card-title>My orders</v-card-title>
    </v-card>
    <v-data-table :headers="ordersHeaders" :items="cookOrders" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.table_number }}</td>
        <td class="text-xs-left">{{ props.item.meal_id }}</td>
        <td
          class="text-xs-left"
          :style="{backgroundColor: (props.item.state == 'confirmed' ? 'yellow' : 'orange') }"
        >{{ props.item.state }}</td>
        <td class="text-xs-left">{{ props.item.item_name }}</td>
        <td class="text-xs-left">{{ props.item.item_price }}</td>
        <td class="justify-center layout px-0">
          <v-icon
            small
            class="mr-2"
            v-if="props.item.state == 'confirmed'"
            @click="changeToInpreparation(props.item)"
          >play_arrow</v-icon>
          <v-icon
            small
            class="mr-2"
            v-if="props.item.state =='in preparation'"
            @click="changeToPrepared(props.item)"
          >done</v-icon>
        </td>
      </template>
    </v-data-table>
    <br>
    <br>
    <v-card>
      <v-card-title>Orders without a cook</v-card-title>
    </v-card>
    <v-data-table :headers="ordersHeaders" :items="unassignedOrders" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.table_number }}</td>
        <td class="text-xs-left">{{ props.item.meal_id }}</td>
        <td
          class="text-xs-left"
          :style="{backgroundColor: (props.item.state == 'confirmed' ? 'yellow' : 'orange') }"
        >{{ props.item.state }}</td>
        <td class="text-xs-left">{{ props.item.item_name }}</td>
        <td class="text-xs-left">{{ props.item.item_price }}</td>
        <td class="justify-center layout px-0">
          <v-icon small class="mr-2" @click="assignToCook(props.item)">assignment_ind</v-icon>
        </td>
      </template>
    </v-data-table>
    <br>
    <br>
  </v-container>
</template>
<script>
export default {
  props: ["cookOrders", "unassignedOrders"],
  data() {
    return {
      ordersHeaders: [
        {
          text: "Table",
          align: "left",
          sortable: true,
          value: "name"
        },
        { text: "Meal", value: "meal" },
        { text: "State", value: "state", align: "left" },
        { text: "Item", value: "item", align: "left" },
        { text: "Item price", value: "price", align: "left" },
        { text: "Actions", value: "name", sortable: false }
      ]
    };
  },
  methods: {
    assignToCook(order) {
      this.$emit("assign-order", order);
    },
    changeToInpreparation(order) {
      this.$emit("start-preparation", order);
    },
    changeToPrepared(order) {
      this.$emit("end-preparation", order);
    }
  }
};
</script>
