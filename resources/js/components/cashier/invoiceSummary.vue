<template>
  <v-dialog max-width="500px" v-model="show">
    <v-card>
      <v-card-title>
        <span class="headline">Meal Summary</span>
      </v-card-title>
      <v-card-text>
        <v-container grid-list-md>
          <v-layout wrap>
            <v-layout column>
              <p>
                <b>Waiter:</b>
                {{invoice.waiter_name}}
              </p>
              <p>
                <b>Name:</b>
                {{invoice.name}}
              </p>
              <p>
                <b>NIF:</b>
                {{invoice.nif}}
              </p>
              <p>
                <b>Date:</b>
                {{invoice.date}}
              </p>
              <p>
                <b>Table number:</b>
                {{invoice.table_number}}
              </p>
              <p>
                <b>Price preview:</b>
                {{invoice.total_price}}€
              </p>
            </v-layout>
            <v-layout column>
              <p
                v-for="invoiceItem in invoiceItems"
                v-bind:key="invoiceItem.invoice_id + '' + '' + invoiceItem.item_id"
              >{{invoiceItem.item_name}} - {{invoiceItem.item_price}}€ x {{invoiceItem.quantity}} -> {{invoiceItem.sub_total_price}}</p>
            </v-layout>
          </v-layout>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: ["show", "invoice", "invoiceItems"],
  methods: {
    close() {
      this.$emit("close");
    }
  }
};
</script>
