<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs8 class="text-xs-left">
        <h1>Change Name/Username</h1>
      </v-flex>
      <v-flex xs12 sm6 mt-3>
        <v-form>
          <v-layout column>
            <v-flex>
              <v-text-field
                v-model="user.name"
                :rules="nameRules"
                :counter="50"
                label="Name"
                required
              ></v-text-field>
              <alert-message
                type-of-msg="error"
                :show-alert="showErrorName"
                :message="errorMessage"
              ></alert-message>
              <v-text-field
                v-model="user.username"
                :rules="usernameRules"
                label="Username"
                required
              ></v-text-field>

              <div class="input-group">
                <label class="input-group-btn">
                  <span class="btn btn-primary">
                    Browse:
                    <input
                      type="file"
                      class="custom-file-input"
                      v-on:change="onFileChanged"
                      accept=".jpg, .jpeg, .png"
                      style="display: none;"
                      required
                    >
                  </span>
                </label>
                <input type="text" class="form-control" :value="filename" readonly>
              </div>
              <v-btn color="success" class="font-weight-light" @click.prevent="saveUser">Save</v-btn>
              <v-btn color="error" class="font-weight-light" @click.prevent="cancelEdit">Cancel</v-btn>
            </v-flex>
          </v-layout>
        </v-form>
      </v-flex>
    </v-layout>
  </v-container>
  <!--<file-upload v-on:fileChanged="onFileChanged"></file-upload>-->
</template>


<script>
import alertMessage from "../alertMessage.vue";
export default {
  data: function() {
    return {
      showErrorName: false,
      showErrorUsername: false,
      errorMessage: "",
      filename: "",
      file: "",
      nameRules: [
        v => !!v || "Name is required",
        v => v.length <= 50 || "Name must be less than 50 characters"
      ],
      usernameRules: [
        v => !!v || "Username is required",
        v => v.length >= 2 || "Min 2 characters"
      ],
      photo: ""
    };
  },
  props: ["user"],
  methods: {
    saveUser: function() {
      var data = new FormData();
      //TODO FOTO
      console.log(data);
      axios
        .put("api/users/" + this.user.id, this.user)
        .then(response => {
          // Copy object properties from response.data.data to this.user
          // without creating a new reference
          Object.assign(this.user, response.data.data);
          this.$emit("user-saved", this.user);
        })
        .catch(error => {
          errorMessage = error.data.errors.username;
          showErrorName = true;
          console.log(error.response);
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
    onFileChanged: function(fileChanged) {
      this.file = event.target.files[0];
      this.filename = this.file.name;
    }
  },
  mounted() {
    console.log("Mounted Edit compoment");
  },
  components: {
    alertMessage
  }
};
</script>