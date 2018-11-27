<template>
    <div>
      <v-data-table :headers="headers" :items="items" class="elevation-1" >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-right">{{ props.item.name }}</td>
          <td class="text-xs-right">{{ props.item.type }}</td>
          <td class="text-xs-right">{{ props.item.carbs }}</td>
          <td class="text-xs-right">{{ props.item.protein }}</td>
          <td class="text-xs-right">{{ props.item.iron }}</td>
        </template>
      </v-data-table>
    </div>
</template>
<script>
export default {
  data() {
    return {
      headers: [
        {
          text: "Dessert (100g serving)",
          align: "left",
          sortable: false,
          value: "name"
        },
        { text: "Calories", value: "calories" },
        { text: "Fat (g)", value: "fat" },
        { text: "Carbs (g)", value: "carbs" },
        { text: "Protein (g)", value: "protein" },
        { text: "Iron (%)", value: "iron" }
      ],
      desserts: items
    };
  },
  props: ["items"],
  methods: {},
  mounted() {
    console.log("Component mounted.");
  }
};
</script>

  "id": 1,
            "name": "7-Up",
            "type": "drink",
            "description": "Alice. It looked good-natured, she thought: still it had entirely disappeared; so the King very decidedly, and the arm that was trickling down his brush, and had just begun to repeat it, but her.",
            "photo_url": "pGasOx32JrJWoPcr.jpg",
            "price": "1.40",
            "deleted_at": null,
            "created_at": "2017-03-31 11:53:33",
            "updated_at": "2018-05-23 04:58:30"