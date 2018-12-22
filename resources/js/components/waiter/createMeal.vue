<template>
  <form>
    <v-layout column>
      <v-flex>
        <v-text-field
          v-model.trim="user.name"
          prepend-icon="person"
          name="Name"
          label="Name"
          id="Name"
          type="Name"
          readonly
        ></v-text-field>
      </v-flex>
      <v-flex>
        <v-select
          label="Table Number"
          prepend-icon="local_dining"
          v-model="selectedTable"
          :items="tables"
          single-line
          item-value="table_number"
          item-text="table_number"
        ></v-select>
      </v-flex>

      <v-btn color="success" class="font-weight-light" @click.prevent="saveMeal">Save</v-btn>
      <v-btn color="error" class="font-weight-light" @click.prevent="cancelMeal">Cancel</v-btn>
    </v-layout>
  </form>
</template>
<script>
export default {
  data() {
    return {
      selectedTable: ""
    };
  },
  props: ["user", "tables"],
  methods: {
    saveMeal() {
      let data = {
        table_number: this.selectedTable
      };
      axios
        .post("api/meals/create", data)
        .then(resposnse => {
          this.$emit("meal-saved");
        })
        .catch(error => {});
    },
    cancelMeal() {
      this.$emit("meal-canceled");
    }
  }
};
</script>