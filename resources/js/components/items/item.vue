<template>
    <div class="container">
        <item_list :items="items"></item_list>
    </div>
</template>

<script>
import itemList from "./itemList.vue";
export default {
  data: {
    function() {
      return {
        items: []
      };
    }
  },
  methods: {
    getItems: function() {
      axios.get("api/items").then(response => {
        this.items = response.data.data;
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