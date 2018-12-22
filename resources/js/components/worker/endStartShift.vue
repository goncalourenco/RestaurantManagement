<template>
  <v-container fuild>
    <v-btn
      round
      style="text-transform: none !important;"
      v-if="user.shift_active== 0"
      flat
      @click.prevent="startShift"
    >Start Shift {{time}}</v-btn>
    <v-btn
      round
      style="text-transform: none !important;"
      flat
      v-else
      @click.prevent="endShift"
    >End Shift {{time}}</v-btn>
  </v-container>
</template>

<script>
export default {
  data: function() {
    return {
      time: "",
      dateShift: "",
      timer: "",
      now: "",
      dateToUpdate: "",
      user: []
    };
  },
  methods: {
    updateTime() {
      this.now = moment(); /*
      let timeInMiliseconds = moment(this.now, "YYYY-MM-DD HH:mm:ss").diff(
        moment(this.dateToUpdate, "YYYY-MM-DD HH:mm:ss")
      );
      let days = moment.duration(timeInMiliseconds);
      */
      let timeInMiliseconds = this.now.diff(this.dateToUpdate);
      let duration = moment.duration(timeInMiliseconds);
      this.time =
        Math.floor(duration.asHours()) +
        moment.utc(timeInMiliseconds).format(":mm:ss");
    },
    getUser() {
      axios
        .get("api/users/me")
        .then(response => {
          this.user = response.data.data;
          if (this.user.shift_active == 0) {
            this.dateToUpdate = moment(this.user.last_shift_end);
          } else {
            this.dateToUpdate = moment(this.user.last_shift_start);
          }
          this.$nextTick(function() {
            this.timer = window.setInterval(() => {
              this.updateTime();
            }, 1000);
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    endShift() {
      let data = {
        end_shift_date: moment().format("YYYY-MM-DD HH:mm:ss")
      };
      axios
        .patch("api/users/" + this.user.id + "/endshift/", data)
        .then(response => {
          this.user = response.data.data;
          this.dateToUpdate = moment(this.user.last_shift_end);
        })
        .catch(error => {
          console.log(error);
        });
    },
    startShift() {
      let data = {
        start_shift_date: moment().format("YYYY-MM-DD HH:mm:ss")
      };
      axios
        .patch("api/users/" + this.user.id + "/startshift/", data)
        .then(response => {
          this.$store.commit("setUser", response.data.data);
          this.user = response.data.data;
          this.dateToUpdate = moment(this.user.last_shift_start);
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getUser();
  }
};
</script>