<template>
  <v-container fluid>
    <invoice-list
      :invoices="invoices"
      @pay="setAsPaid"
      @details="getInvoiceDetails"
      @edit="editInvoice"
    ></invoice-list>
    <invoice-summary
      :invoice="selectedInvoice"
      :invoice-items="invoiceItems"
      :show="showSummary"
      @close="closeSummary"
    ></invoice-summary>
    <edit-invoice
      :show="showEdit"
      :invoice="selectedInvoice"
      @cancel="cancelEdit"
      @save="saveInvoice"
    ></edit-invoice>
  </v-container>
</template>

<script>
import invoiceList from "./listInvoices.vue";
import invoiceSummary from "./invoiceSummary.vue";
import editInvoice from "./editInvoice.vue";
export default {
  data() {
    return {
      invoices: [],
      invoiceItems: [],
      showSummary: false,
      selectedInvoice: "",
      showEdit: false
    };
  },
  methods: {
    getInvoices() {
      axios.get("api/cashier/invoices").then(response => {
        this.invoices = response.data.data;
      });
    },
    getInvoiceDetails(invoice) {
      axios.get("api/invoiceitems/" + invoice.id).then(response => {
        this.selectedInvoice = invoice;
        this.invoiceItems = response.data.data;
        this.showSummary = true;
      });
    },
    closeSummary() {
      this.showSummary = false;
    },
    editInvoice(invoice) {
      this.selectedInvoice = invoice;
      this.showEdit = true;
    },
    cancelEdit() {
      this.showEdit = false;
    },
    saveInvoice(data) {
      axios
        .put("api/invoice/" + this.selectedInvoice.id, data)
        .then(response => {
          this.getInvoices();
          this.showEdit = false;
        });
    },
    setAsPaid(invoice) {
      let data = {
        state: "paid"
      };
      axios
        .patch("api/invoice/" + invoice.id + "/state", data)
        .then(response => {
          this.getInvoices();
        });
    }
  },
  components: {
    invoiceList,
    invoiceSummary,
    editInvoice
  },
  mounted() {
    this.getInvoices();
  }
};
</script>

