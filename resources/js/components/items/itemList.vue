<template>
  <template v-for="(item, index) in items">
    <v-flex xs12 sm6 offset-sm3 v-bind:key="index">
      <v-card>
        <v-img src="https://cdn.vuetifyjs.com/images/cards/desert.jpg" aspect-ratio="2.75"></v-img>

        <v-card-title primary-title>
          <div>
            <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
            <div>Located two hours south of Sydney in the
              <br>Southern Highlands of New South Wales, ...
            </div>
          </div>
        </v-card-title>

        <v-card-actions>
          <v-btn flat color="orange">Share</v-btn>
          <v-btn flat color="orange">Explore</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </template>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: ["items"],
  methods: {},
  mounted() {
    console.log("Component mounted.");
  }
};
</script>

