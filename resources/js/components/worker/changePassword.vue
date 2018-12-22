<template>
  <v-form>
    <h1>Change Password</h1>
    <alert-message :showAlert="showErrorMessage" :message="errorMessage" :typeOfMsg="typeOfMsg"></alert-message>

    <v-text-field
      v-model="oldPassword"
      :append-icon="show ? 'visibility_off' : 'visibility'"
      :rules="passwordRules"
      :type="show ? 'text' : 'password'"
      name="input-10-1"
      label="Current Password"
      hint="At least 3 characters"
      counter
      @click:append="show = !show"
    ></v-text-field>
    <v-text-field
      v-model="newPassword"
      :append-icon="show ? 'visibility_off' : 'visibility'"
      :rules="passwordRules"
      :type="show ? 'text' : 'password'"
      name="input-10-1"
      label="New Password"
      hint="At least 3 characters"
      counter
      @click:append="show = !show"
    ></v-text-field>
    <v-text-field
      v-model="confirmPassword"
      :append-icon="show ? 'visibility_off' : 'visibility'"
      :rules="confirmPasswordRules"
      :type="show ? 'text' : 'password'"
      name="input-10-1"
      label="Confirm new Password"
      hint="At least 3 characters"
      counter
      @click:append="show = !show"
    ></v-text-field>
    <v-btn color="success" class="font-weight-light" @click.prevent="saveUser">Save</v-btn>
    <v-btn color="error" class="font-weight-light" @click.prevent="cancelEdit">Cancel</v-btn>
  </v-form>
</template>

<script>
import alertMessage from "../alertMessage";
export default {
  data() {
    return {
      show: false,
      passwordRules: [
        value => !!value || "Required.",
        value => value.length >= 3 || "Min 3 characters"
      ],
      confirmPasswordRules: [
        value => !!value || "Required.",
        value => value.length >= 3 || "Min 3 characters",
        value => value == this.newPassword || "Passwords must match"
      ],
      newPassword: "",
      confirmPassword: "",
      oldPassword: "",
      showErrorMessage: "",
      errorMessage: "",
      typeOfMsg: "",
      errors: ""
    };
  },
  props: ["user"],
  methods: {
    saveUser: function() {
      this.showErrorMessage = false;
      let passwords = {
        old_password: this.oldPassword,
        password: this.newPassword,
        password_confirmation: this.confirmPassword
      };
      console.log(passwords);
      axios
        .patch("api/users/password/" + this.user.id, passwords)
        .then(response => {
          // Copy object properties from response.data.data to this.user
          // without creating a new reference
          console.log(response);
          Object.assign(this.user, response.data.data);
          this.$emit("user-saved", this.user);
        })
        .catch(error => {
          console.log(error.response.data.errors);
          this.typeOfMsg = "error";
          //this.showErrorMessage = true;
          this.errors = error.response.data.errors;
          //this.errorMessage = error.response.data.errors.old_password[0];
        });
    },
    cancelEdit: function() {
      axios.get("api/users/me").then(response => {
        // Copy object properties from response.data.data to this.user
        // without creating a new reference
        Object.assign(this.user, response.data.data);
        this.$emit("user-canceled", this.user);
      });
    }
  },
  mounted() {
    console.log("Mounted Edit compoment");
  },
  components: {
    alertMessage
  }
};
/*
export default {
  data: () => ({
    show = false,
    passwordRules: [
      value => !!value || "Required.",
      value => value.length >= 3 || "Min 3 characters"
    ],
  }),
  props: ["user"],
  methods: {
    saveUser: function() {
      axios.put("api/users/" + this.user.id, this.user).then(response => {
        // Copy object properties from response.data.data to this.user
        // without creating a new reference
        Object.assign(this.user, response.data.data);
        this.$emit("user-saved", this.user);
      });
    },
    cancelEdit: function() {
      axios.get("api/users/me").then(response => {
        // Copy object properties from response.data.data to this.user
        // without creating a new reference
        Object.assign(this.user, response.data.data);
        this.$emit("user-canceled", this.user);
      });
    },
    mounted() {
      console.log("Mounted change password compoment.");
    }
  }
};*/
</script>