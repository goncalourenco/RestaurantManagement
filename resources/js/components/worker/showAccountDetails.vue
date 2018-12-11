<template>
  <div>
    <v-container fill-height fluid grid-list-xl>
      <v-img :src="user.photo_url" alt="Card image cap"></v-img>

      <v-layout row wrap>
        <v-flex xs8 md8>
          <v-container>
            <p>
              <b>Name:</b>
              {{user.name}}
            </p>
            <p>
              <b>Username:</b>
              {{user.username}}
            </p>
            <p>
              <b>Email:</b>
              {{user.email}}
            </p>
            <p>
              <b>Type:</b>
              {{user.type}}
            </p>
            <p>
              <b>Last shift:</b>
              {{user.last_shift_start}} - {{user.last_shif_end}}
            </p>
            <p>
              <b>Currently on shift:</b>
              {{currentlyOnShift(user.shift_active)}}
            </p>
          </v-container>
        </v-flex>
      </v-layout>
    </v-container>
    <v-container fill-height fluid>
      <v-btn color="info" class="font-weight-light" @click.prevent="editUser(user)">Edit</v-btn>
      <v-btn
        color="info"
        class="font-weight-light"
        @click.prevent="changePassword(user)"
      >Change Password</v-btn>
    </v-container>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Mounted show details.");
  },
  props: ["user"],
  methods: {
    currentlyOnShift(value) {
      if (value == 1) {
        return "Yes";
      }
      return "No";
    },
    editUser(user) {
      this.$emit("edit-click", user);
    },
    changePassword(user) {
      this.$emit("password-click", user);
    }
  }
};
</script>