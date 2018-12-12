<template>
  <v-form>
      <h1>Change Password</h1>
    <v-text-field
      v-model="newPassword"
      :append-icon="show ? 'visibility_off' : 'visibility'"
      :rules="passwordRules"
      :type="show ? 'text' : 'password'"
      name="input-10-1"
      label="Password"
      hint="At least 3 characters"
      counter
      @click:append="show = !show"
    ></v-text-field>
    <v-btn color="success" class="font-weight-light" @click.prevent="saveUser">Save</v-btn>
    <v-btn color="error" class="font-weight-light" @click.prevent="cancelEdit">Cancel</v-btn>
  </v-form>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      passwordRules: [
        value => !!value || "Required.",
        value => value.length >= 3 || "Min 3 characters"
      ],
      newPassword: ""
    };
  },
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
    }
  },
  mounted() {
    console.log("Mounted Edit compoment");
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