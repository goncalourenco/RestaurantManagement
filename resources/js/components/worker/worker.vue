<template>
  <div class="container">
    <worker-details
      :user="user"
      @edit-click="editUser"
      @password-click="changePassword"
      v-if="!currentUser"
    ></worker-details>
    <edit-account-details
      :user="currentUser"
      @user-saved="savedUser"
      @user-canceled="cancelEdit"
      v-if="editingUser"
    ></edit-account-details>
    <change-password
      :user="currentUser"
      @user-saved="savedUser"
      @user-canceled="cancelEdit"
      v-if="changingPassword"
    ></change-password>
  </div>
</template>

<script>
import workerDetails from "./showAccountDetails.vue";
import editAccountDetails from "./editAccountDetails";
import changePassword from "./changePassword.vue";
export default {
  mounted() {
    console.log("Component mounted.");
    this.getUserInfo();
  },
  data() {
    return {
      user: [],
      currentUser: null,
      showSuccess: false,
      successMessage: "",
      editingUser: false,
      changingPassword: false
    };
  },
  components: {
    workerDetails,
    editAccountDetails,
    changePassword
  },
  methods: {
    getUserInfo: function() {
      axios.get("api/users/me").then(response => {
        this.user = response.data.data;
        //console.log(response.data.data);
      });
    },
    editUser: function(user) {
      //console.log("Edit user");
      //console.log(user);
      this.currentUser = user;
      this.editingUser = true;
      this.showSuccess = false;
    },
    changePassword: function(user) {
      this.currentUser = user;
      this.changingPassword = true;
      console.log("ChangePassowrd");
    },
    savedUser: function() {
      this.currentUser = null;
      this.editingUser = false;
      this.changingPassword = false;
      this.showSuccess = true;
      this.successMessage = "User Saved";
    },
    cancelEdit: function() {
      this.currentUser = null;
      this.editingUser = false;
      this.changingPassword = false;
      this.showSuccess = false;
    }
  }
};
</script>
