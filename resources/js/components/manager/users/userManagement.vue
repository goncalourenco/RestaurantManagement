<template>
  <v-container fluid>
    <user-list :users="users" @block-user="blockUser" @unblock-user="unblockUser"></user-list>
    <v-btn @click.prevent="close">Close</v-btn>
  </v-container>
</template>
<script>
import userList from "./userlist.vue";
export default {
  data() {
    return {
      users: []
    };
  },
  methods: {
    getUserList() {
      axios.get("api/users").then(response => {
        this.users = response.data.data;
      });
    },
    close() {
      this.$emit("close");
    },
    blockUser(id) {
      axios.patch("api/user/" + id + "/block").then(response => {
        this.$socket.emit("user_blocked", response.data.data);
      });
    },
    unblockUser(id) {
      axios.patch("api/user/" + id + "/unblock").then(response => {
        this.$socket.emit("user_unblocked", response.data.data);
      });
    }
  },
  components: {
    userList
  },
  mounted() {
    this.getUserList();
  },
  sockets: {
    connect() {
      console.log("socket connected (socket ID = " + this.$socket.id + ")");
    },
    user_blocked(user) {
      this.getUserList();
    },
    user_unblocked(user) {
      this.getUserList();
    }
  }
};
</script>

