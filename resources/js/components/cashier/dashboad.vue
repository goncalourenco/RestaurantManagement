<template>
  <v-container fluid>
    <invoice-list :invoices="invoices" @details="getInvoiceDetails" @edit="editInvoice"></invoice-list>
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
      axios.put("api/invoices/" + selectedInvoice.id, data).then(response => {
        Object.assign(this.selectedInvoice, response.data.data);
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

