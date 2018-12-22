<template>
  <v-container fluid>
    <v-layout row v-if="user.shift_active == 1">
      <v-btn flat @click.prevent="createMeal">Create a new Meal</v-btn>

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
  </v-container>
</template>

<script>
import createMeal from "./createMeal.vue";
export default {
  data() {
    return {
      user: this.$store.state.user,
      tables: [],
      showCreateMeal: false,
      message: ""
    };
  },
  mounted() {
    console.log("Mounted waiter dashboard.");
    this.getTables();
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
    getTables() {
      axios
        .get("api/meals/availableTables")
        .then(response => {
          this.tables = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  components: {
    createMeal
  }
};
</script>
