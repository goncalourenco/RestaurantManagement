<template>
  <div class="container">
    <template v-for="(item, index) in items" style="margin-bottom: 5px">
      <v-flex xs12 sm6 offset-sm3 v-bind:key="index">
        <v-card>
          <v-img :src="urlToImage(item)" aspect-ratio="2.75"></v-img>

          <v-card-title primary-title>
            <div>
              <h2 class="headline mb-0">{{item.name}}</h2>
              <div>
                {{item.type}}
                <br>
                {{item.description}}
              </div>
            </div>
          </v-card-title>
          <!--<v-card-actions>
            <v-btn flat color="orange">Share</v-btn>
            <v-btn flat color="orange">Explore</v-btn>
          </v-card-actions>-->
        </v-card>
      </v-flex>
    </template>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: ["items"],
  methods: {
    urlToImage: function(item) {
      return "/storage/items/" + item.photo_url + ".jpg";
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>

