<template>
  <v-container fluid>
    <v-layout row v-if="user.shift_active == 1">
      <v-btn flat @click.prevent="createMeal" v-if="!showCreateMeal">Create a new Meal</v-btn>

      <v-flex v-if="showCreateMeal" xs12 sm6 mt-3 offset-sm0>
        <create-meal
          :user="user"
          :tables="tables"
          @meal-canceled="mealCanceled"
          @meal-saved="mealSaved"
        ></create-meal>
      </v-flex>
    </v-layout>
    <h1 v-else>You are not currently on shif</h1>
    <v-dialog max-width="500px" v-model="showMealDetails">
      <v-card>
        <v-card-title>
          <span class="headline">Meal Summary</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-layout column>
                <p>
                  <b>Table number:</b>
                  {{selectedMeal.table_number}}
                </p>
                <p>
                  <b>Price preview:</b>
                  {{selectedMeal.total_price_preview}}€
                </p>
              </v-layout>
              <v-layout column>
                <p
                  v-for="order in ordersForMeal"
                  v-bind:key="order.id"
                >{{order.item_name}} {{order.item_price}}€</p>
              </v-layout>
            </v-layout>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="closeSummaryDialog">Close</v-btn>
          <v-btn color="blue darken-1" flat @click="terminateMeal">Terminate order</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-container>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>
            <span class="headline">Add a order this meal</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-autocomplete
                  persistent-hint
                  label="Item"
                  prepend-icon="fastfood"
                  v-model="selectedItem"
                  :items="items"
                  single-line
                  item-value="id"
                  item-text="name"
                ></v-autocomplete>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="closeOrderDialog">Cancel</v-btn>
            <v-btn color="blue darken-1" flat @click="saveOrder">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-card>
        <v-card-title>My active meals</v-card-title>
      </v-card>
      <v-data-table :headers="mealHeaders" :items="myMeals" class="elevation-1">
        <template slot="items" slot-scope="props">
          <td class="text-xs-left">{{ props.item.id }}</td>
          <td class="text-xs-left">{{ props.item.responsible_waiter_name }}</td>
          <td class="text-xs-left">{{ props.item.state }}</td>
          <td class="text-xs-left">{{ props.item.table_number }}</td>
          <td class="text-xs-left">{{ props.item.total_price_preview }}</td>
          <td class="justify-center layout px-0">
            <v-icon small class="mr-2" @click.prevent="createOrder(props.item)">add</v-icon>
            <v-icon small class="mr-2" @click.prevent="mealSummary(props.item)">details</v-icon>
          </td>
        </template>
      </v-data-table>
      <br>
      <br>

      <v-card>
        <v-card-title>My orders</v-card-title>
      </v-card>
      <v-data-table :headers="ordersHeaders" :items="myOrders" class="elevation-1">
        <template slot="items" slot-scope="props">
          <td class="text-xs-left">{{ props.item.table_number }}</td>
          <td class="text-xs-left">{{ props.item.meal_id }}</td>
          <td
            class="text-xs-left"
            :style="{backgroundColor: (props.item.state == 'pending' || props.item.state=='confirmed' ? props.item.state == 'pending' ? 'yellow' : 'green' : 'transparent' ) }"
          >{{ props.item.state }}</td>
          <td class="text-xs-left">{{ props.item.item_name }}</td>
          <td class="text-xs-left">{{ props.item.item_price }}</td>
          <td class="justify-center layout px-0">
            <v-icon
              small
              class="mr-2"
              @click.prevent="deleteOrder(props.item)"
              v-if="props.item.state == 'pending'"
            >delete</v-icon>
            <v-icon
              small
              class="mr-2"
              @click.prevent="deliverOrder(props.item)"
              v-if="props.item.state =='prepared'"
            >done</v-icon>
          </td>
        </template>
      </v-data-table>
    </v-container>
  </v-container>
</template>

<script>
import createMeal from "./createMeal.vue";
import mealDetails from "./mealDetails.vue";
export default {
  data() {
    return {
      dialog: false,
      user: this.$store.state.user,
      tables: [],
      myMeals: [],
      showCreateMeal: false,
      message: "",
      mealHeaders: [
        {
          text: "Meals",
          align: "left",
          sortable: true,
          value: "name"
        },
        { text: "Waiter", value: "waiter" },
        { text: "State", value: "state", align: "left" },
        { text: "Table number", value: "table_number", align: "left" },
        { text: "Price preview", value: "price", align: "left" },
        { text: "Actions", value: "name", sortable: false }
      ],
      items: [],
      selectedItem: "",
      selectedMeal: "",
      myOrders: [],
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
      ],
      showMealDetails: "",
      ordersForMeal: [],
      cancellable: true,
      newMeal: ""
    };
  },
  mounted() {
    this.getTables();
    this.getMyMeals();
    this.getItems();
    this.getMyOrders();
  },
  methods: {
    createMeal() {
      this.showCreateMeal = true;
    },
    mealSaved() {
      this.showCreateMeal = false;
      this.message = "Meal created with success!";
    },
    mealCanceled() {
      this.showCreateMeal = false;
    },
    getItems() {
      axios.get("api/items").then(response => {
        this.items = response.data.data;
      });
    },
    getTables() {
      axios
        .get("api/meals/availableTables")
        .then(response => {
          this.tables = response.data.data;
        })
        .catch(error => {});
    },
    getMyMeals() {
      axios
        .get("api/waiter/meals")
        .then(response => {
          this.myMeals = response.data.data;
        })
        .catch(error => {});
    },
    getMyOrders() {
      axios.get("api/waiter/orders").then(response => {
        this.myOrders = response.data.data;
      });
    },
    createOrder(meal) {
      this.dialog = true;
      this.selectedMeal = meal;
    },
    closeOrderDialog() {
      this.dialog = false;
    },
    saveOrder() {
      let data = {
        meal_id: this.selectedMeal.id,
        item_id: this.selectedItem
      };
      axios
        .post("/api/orders/create", data)
        .then(response => {
          //updates the price preview
          this.newMeal = response.data.data;
          this.$socket.emit("order_created", response.data.data);
          //this.getMyOrders();
          this.dialog = false;
          this.selectedItem = null;
          this.cancellable = true;
          setTimeout(() => {
            if (this.cancellable) {
              this.cancellable = false;
              let data = {
                state: "confirmed"
              };
              axios
                .patch("/api/order/" + this.newMeal.id + "/state", data)
                .then(response => {
                  this.newMeal = response.data.data;
                  this.$socket.emit("order_created", response.data.data);
                });
            }
          }, 5000);
        })
        .catch(error => {});
    },
    deleteOrder(order) {
      if (this.cancellable) {
        axios.delete("api/orders/" + order.id).then(response => {
          this.getMyOrders();
          this.cancellable = false;
        });
      }
    },
    deliverOrder(order) {
      let data = {
        state: "delivered"
      };
      axios
        .patch("/api/order/" + order.id + "/state", data)
        .then(response => {
          this.getMyOrders();
        })
        .catch(error => {});
    },
    mealSummary(meal) {
      this.selectedMeal = meal;
      this.showMealDetails = true;
      this.getOrdersForMeal(meal.id);
    },
    getOrdersForMeal(id) {
      axios
        .get("api/meals/" + id + "/orders")
        .then(response => {
          this.ordersForMeal = response.data.data;
        })
        .catch(error => {});
    },
    closeSummaryDialog() {
      this.showMealDetails = false;
    },
    terminateMeal() {
      let order;
      let allDelivered = true;
      for (order in this.ordersForMeal) {
        if (order.state != "delivered") {
          allDelivered = false;
        }
      }
      if (!allDelivered) {
        if (
          confirm(
            "Not all orders are delivered. If you continue all pending orders will be close"
          )
        ) {
          axios
            .patch("api/meals/" + this.selectedMeal.id + "/terminate")
            .then(response => {
              this.selectedMeal = response.data.data;
              this.showMealDetails = false;
              this.$socket.emit("order_terminated", response.data.data);
              this.$socket.emit("invoice_created", response.data.data);
            });
        }
      }
    }
  },
  components: {
    createMeal,
    mealDetails
  },
  sockets: {
    connect() {
      console.log("socket connected (socket ID = " + this.$socket.id + ")");
    },
    order_created(order) {
      this.getMyOrders();
      this.getMyMeals();
    },
    order_terminated(order) {
      this.getMyOrders();
      this.getMyMeals();
    },
    order_prepared(order) {
      this.getMyOrders();
    },
    meal_created(meal) {
      this.getMyMeals();
    }
  }
};
</script>
