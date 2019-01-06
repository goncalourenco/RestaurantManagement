<template>
  <v-layout row justify-center>
    <v-dialog v-model="show" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Add Nif and client to invoice {{invoice.id}}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md4>
                <v-text-field
                  v-model="name"
                  :rules="nameRules"
                  label="NIF*"
                  hint="Client's NIF"
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-text-field v-model="nif" label="Name" hint="Client's name" required></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.prevent="cancel">Cancel</v-btn>
          <v-btn color="blue darken-1" flat @click.prevent="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>
<script>
export default {
  data() {
    return {
      name: "",
      nif: "",
      nameRules: [
        v => !!v || "Name is required",
        v => v.length <= 50 || "Name must be less than 50 characters",
        v => /^[a-zA-Z ]+$/.test(v) || "Invalid characters"
      ],
      nifRules: [
        v => !!v || "Nif is required",
        v => v.length != 9 || "Must be exactly 9 characters",
        v => /\d{9}/.test(v) || "Invalid characters"
      ]
    };
  },
  props: ["invoice", "show"],
  methods: {
    cancel() {
      this.$emit("cancel");
    },
    save() {
      if (this.name.trim() == "" || this.nif.trim() == "") {
      } else {
        let data = {
          name: this.name,
          nif: this.nif
        };
        this.$emit("saveInvoice", data);
      }
    }
  }
};
</script>
