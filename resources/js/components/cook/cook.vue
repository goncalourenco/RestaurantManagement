<template>
  <v-container fluid>
    <cook-orders
      :cookOrders="orders"
      :unassignedOrders="unassignedOrders"
      @assign-order="assignOrder"
      @start-preparation="startPreparation"
      @end-preparation="endPreparation"
    ></cook-orders>
  </v-container>
</template>

<script>
import cookOrders from "./listOrders";
export default {
  mounted() {
    console.log("Component mounted.");
    this.getOrders();
    this.getOrdersWithoutCook();
  },
  data() {
    return {
      orders: [],
      unassignedOrders: []
    };
  },
  methods: {
    getOrders: function() {
      axios
        .get("api/orders/cook/" + this.$store.state.user.id)
        .then(response => {
          this.orders = response.data.data;
          console.log(response.data.data);
        });
    },
    getOrdersWithoutCook: function() {
      axios.get("api/orders/unassigned").then(response => {
        this.unassignedOrders = response.data.data;
        console.log(response.data.data);
      });
    },
    assignOrder: function(order) {
      axios.patch("api/order/" + order.id + "/assign").then(response => {
        this.getOrders();
        this.getOrdersWithoutCook();
      });
    },
    startPreparation(order) {
      let data = {
        state: "in preparation"
      };
      axios.patch("api/order/" + order.id + "/state", data).then(response => {
        this.getOrders();
      });
    },
    endPreparation(order) {
      let data = {
        state: "prepared"
      };
      axios.patch("api/order/" + order.id + "/state", data).then(response => {
        this.$socket.emit("order_prepared", response.data.data);
      });
    }
  },
  components: {
    cookOrders
  },
  sockets: {
    connect() {
      console.log("socket connected (socket ID = " + this.$socket.id + ")");
    },
    order_created(order) {
      this.getOrdersWithoutCook();
    },
    order_prepared(order) {
      this.getOrders();
    }
  }
};
</script>