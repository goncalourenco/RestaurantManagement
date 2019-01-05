<template>
  <v-toolbar color="#1867c0" app>
    <v-toolbar-side-icon></v-toolbar-side-icon>
    <v-toolbar-title>
      <v-btn round flat @click="route('/')">Restaurant Management</v-btn>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn round style="text-transform: none !important;" to="/items" flat>Items</v-btn>
      <template v-if="!this.$store.state.user">
        <v-btn style="text-transform: none !important;" flat to="/login">Login</v-btn>
      </template>
      <template v-if="this.$store.state.user">
        <end-start-shift></end-start-shift>
        <v-menu bottom offset-y icon>
          <v-btn
            style="text-transform: none !important;"
            round
            flat
            slot="activator"
          >{{this.$store.state.user.name}}</v-btn>
          <v-list dense subheader icon>
            <v-list-tile to="/worker">
              <v-list-tile-title>
                <v-icon>home</v-icon>My Profile
              </v-list-tile-title>
            </v-list-tile>
            <v-list-tile to="/waiter" v-if="this.$store.state.user.type=='waiter'">
              <v-list-tile-title>
                <v-icon>dashboard</v-icon>Waiter Dashboard
              </v-list-tile-title>
            </v-list-tile>
            <v-list-tile to="/cook" v-if="this.$store.state.user.type=='cook'">
              <v-list-tile-title>
                <v-icon>dashboard</v-icon>Cook Dashboard
              </v-list-tile-title>
            </v-list-tile>
            <v-list-tile to="/manager" v-if="this.$store.state.user.type=='manager'">
              <v-list-tile-title>
                <v-icon>dashboard</v-icon>Manager Dashboard
              </v-list-tile-title>
            </v-list-tile>
            <v-list-tile to="/logout">
              <v-list-tile-title>
                <v-icon>logout</v-icon>Logout
              </v-list-tile-title>
            </v-list-tile>
          </v-list>
        </v-menu>
        <!--<v-btn round style="text-transform: none !important;" flat to="/logout">Logout</v-btn>-->
      </template>
      <!--<router-link to="/login"  v-show="!this.$store.state.user">Login</router-link> -->
      <!--<router-link to="/logout" v-show="this.$store.state.user">Logout</router-link>-->
    </v-toolbar-items>
  </v-toolbar>
</template>

<script>
import endStartShift from "./worker/endStartShift.vue";
export default {
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    logout() {
      this.showMessage = false;
      axios
        .post("api/logout")
        .then(response => {
          this.$store.commit("clearUserAndToken");
        })
        .catch(error => {
          this.$store.commit("clearUserAndToken");
          console.log(error);
        });
    },
    route(path) {
      this.$router.push({
        path: "/items"
      });
    }
  },
  components: {
    endStartShift
  }
};
</script>

