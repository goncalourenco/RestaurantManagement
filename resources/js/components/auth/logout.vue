<template></template>
<script>
export default {
  methods: {
    logout() {
      this.showMessage = false;
      axios
        .post("api/logout")
        .then(response => {
          this.$store.commit("clearUserAndToken");
          this.$router.push({ path: "/items" });
        })
        .catch(error => {
          this.$store.commit("clearUserAndToken");
          this.$router.push({ path: "/items" });

          console.log(error);
        });
    }
  },
  mounted() {
    this.logout();
  }
};
</script>
