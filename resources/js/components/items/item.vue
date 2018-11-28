<template>
  <div class="container">
    <span>teste</span>
    <item-list :items="items"></item-list>
  </div>
</template>

<script>
import itemList from "./itemList.vue";
export default {
  data() {
    return {
      items: []
    };
  },
  methods: {
    getItems: function() {
      axios.get("api/items").then(response => {
        this.items = response.data.data;
        console.log(response.data.data);
      });
    }
  },
  mounted() {
    this.getItems();
    console.log("Component mounted.");
  },
  components: {
    itemList
  }
};
</script>