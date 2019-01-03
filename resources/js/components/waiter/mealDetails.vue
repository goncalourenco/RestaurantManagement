<template>
  <v-dialog max-width="500px">
    <v-card>
      <v-card-title>
        <span class="headline">Meal Summary</span>
      </v-card-title>
      <v-card-text>
        <v-container grid-list-md>
          <v-layout wrap></v-layout>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" flat @click="closeDialog">Close</v-btn>
        <v-btn color="blue darken-1" flat @click="terminateOrder">Terminate order</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    meal: Object
  },
  methods: {
    closeDialog: function() {
      this.$emit("close-dialog");
    },
    terminateOrder: function() {
      this.$emit("terminate-order");
    }
  }
};
</script>
