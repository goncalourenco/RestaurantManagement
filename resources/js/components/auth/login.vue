<template>
  <v-container fuild>
    <v-layout row wrap>
      <v-flex xs12 class="text-xs-center" mt-5>
        <h1>Sign In</h1>
      </v-flex>
      <v-flex xs12 sm6 offset-sm3 mt-3>
        <form>
          <v-layout column>
            <v-flex>
              <show-alert xs12 :message="message" :showAlert="showAlert" :typeOfMsg="typeOfMsg"></show-alert>
              <v-text-field
                v-model.trim="user.email"
                prepend-icon="person"
                name="email"
                label="email"
                id="email"
                type="email"
                required
              ></v-text-field>
            </v-flex>
            <v-flex>
              <v-text-field
                v-model="user.password"
                prepend-icon="lock"
                name="password"
                label="Password"
                id="password"
                type="password"
                required
              ></v-text-field>
            </v-flex>

            <v-flex class="text-xs-center" mt-5>
              <v-btn color="primary" type="submit" v-on:click.prevent="login">Sign In</v-btn>
            </v-flex>
          </v-layout>
        </form>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import alertMessage from "../alertMessage";
export default {
  data: function() {
    return {
      user: {
        email: "",
        password: ""
      },
      message: "",
      showAlert: false,
      typeOfMsg: ""
    };
  },
  methods: {
    login() {
      this.showAlert = false;
      axios
        .post("api/login", this.user)
        .then(response => {
          this.$store.commit("setToken", response.data.token.access_token);
          return axios.get("api/users/me");
          this.$router.push({ path: "/dashboard" });
        })
        .then(response => {
          console.log(response.data.data);
          this.$store.commit("setUser", response.data.data);
          this.typeOfMsg = "sucess";
          this.message = "User authenticated";
          this.showAlert = true;
          this.$router.push({ path: "/items" });
        })
        .catch(error => {
          this.$store.commit("clearUserAndToken");
          this.typeOfMsg = "error";
          this.message = "Invalid credentials";
          this.showAlert = true;
          console.log(error);
        });
    }
  },
  components: {
    "show-alert": alertMessage
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
