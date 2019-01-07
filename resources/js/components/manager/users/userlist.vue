<template>
  <v-container fluid>
    <v-card>
      <v-card-title>All users</v-card-title>
    </v-card>
    <v-data-table :headers="tableHeaders" :items="users" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">
          <v-img :src="props.item.photo_url" :max-width="400" :max-height="400"></v-img>
        </td>
        <td class="text-xs-left">{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.username }}</td>
        <td class="text-xs-left">{{ props.item.email }}</td>
        <td class="text-xs-left">{{ props.item.type }}</td>
        <td class="text-xs-left">{{ getShiftInfo(props.item.shift_active) }}</td>
        <td class="text-xs-left">{{ props.item.blocked }}</td>
        <td class="justify-center layout px-0">
          <v-icon
            small
            class="mr-2"
            v-if="props.item.blocked=='No'"
            @click="blockUser(props.item.id)"
          >block</v-icon>
          <v-icon small class="mr-2" v-else @click="unblockUser(props.item.id)">lock_open</v-icon>
        </td>
      </template>
    </v-data-table>
    <br>
    <br>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      tableHeaders: [
        { text: "User", align: "left", sortable: true, value: "name" },
        { text: "Name", value: "name", sortable: true },
        { text: "Username", value: "username" },
        { text: "Email", value: "email", sortable: false },
        { text: "Type", value: "type" },
        { text: "Currently working", value: "shift_active" },
        { text: "Blocked", value: "blocked", align: "left" },
        { text: "Actions", value: "name", sortable: false }
      ]
    };
  },
  props: ["users"],
  methods: {
    getShiftInfo(shift_active) {
      return shift_active == 1 ? "Yes" : "No";
    },
    blockUser(id) {
      this.$emit("block-user", id);
    },
    unblockUser(id) {
      this.$emit("unblock-user", id);
    }
  }
};
</script>

