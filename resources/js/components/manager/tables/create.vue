<template>
  <v-card>
    <form>
      <v-layout column>
        <v-flex>
          <v-slider
            v-model="newTableNumber"
            label="Table Number"
            hint="New Table Number"
            min="1"
            max="100"
            thumb-label
          ></v-slider>
        </v-flex>
        <v-btn color="success" class="font-weight-light" @click.prevent="createTable">Save</v-btn>
        <v-btn color="error" class="font-weight-light" @click.prevent="cancel">Cancel</v-btn>
      </v-layout>
    </form>
  </v-card>
</template>
<script>
export default {
  data() {
    return {
      newTableNumber: 1
    };
  },
  methods: {
    createTable() {
      this.$emit("create-table", this.newTableNumber);
    },
    cancel() {
      this.$emit("cancel");
    }
  }
};
</script>
