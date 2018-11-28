<template>
  <div class="container">
    <v-card>
      <v-card-title>Item List
        <v-spacer></v-spacer>
        <v-spacer></v-spacer>
        <v-spacer></v-spacer>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
      </v-card-title>
    </v-card>
    <v-data-table :headers="headers" :items="items" class="elevation-1" :search="search">
      <template slot="items" slot-scope="items">
        <td>{{ items.item.name }}</td>
        <td class="text-xs-right">{{ capitalizeFirstLetter(items.item.type) }}</td>
        <td class="text-xs-left">{{ items.item.description }}</td>
        <td class="text-xs-left">{{ items.item.price }}</td>
        <td class="text-xs-left">
          <v-img :src="urlToImage(items.item)" :max-width="400" :max-height="400"></v-img>
        </td>
      </template>
    </v-data-table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      search: "",
      headers: [
        {
          text: "Item",
          align: "left",
          sortable: true,
          value: "name"
        },
        { text: "Type", value: "type" },
        { text: "Description", value: "description", align: "left" },
        { text: "Price (€)", value: "price", align: "left" },
        { text: "Image", value: "image", align: "left" }
      ]
    };
  },
  props: ["items"],
  methods: {
    urlToImage: function(item) {
      return "/storage/items/" + item.photo_url;
    },
    capitalizeFirstLetter: function(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>

