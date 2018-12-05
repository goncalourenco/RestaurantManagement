<template>
  <div class="container">
    <worker-details></worker-details>
  </div>
</template>

<script>
import workerDetails from "./showAccountDetails.vue";
export default {
  mounted() {
    console.log("Component mounted.");
  },
  components: {
    workerDetails
  }
};
</script>
