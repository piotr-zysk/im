<template>
  <div class="message_list">

<transition appear name="slide-fade">
<table>
  <tr><td>1  </td><td>hjhj</td></tr>
  <tr><td>1  </td><td>edee</td></tr>
<tr><td>1  </td><td>jkjk</td></tr>
  
</table>
</transition>

  </div>
</template>

<script>
import ImService from "@/../services/ImService";
import { mapState } from "vuex";

export default {
  name: "UnreadList",
  computed: mapState(["guser"]),
  data: function() {
    return {
      test: "null"
    };
  },
  mounted() {
    this.getGroups();
  },
  methods: {
    async getGroups() {
      const response = await ImService.authenticate(this.guser.token);
      this.test = response.data;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

table {
  width: 80%;
  margin: 60px auto;
  border-collapse: separate;
  border-spacing: 1px 1px;
    transition-duration: 1s;
  transition: 1s;
}
td {
  border-radius: 4px;
  padding: 3px;
}
tr:nth-child(even) td {
  background-color: #fff;  
}
tr:nth-child(odd) td {
  background-color: #dcdde1;
  
}

.slide-fade-enter-active {
  transition: all 0.7s ease;
}

.slide-fade-enter,
.slide-fade-leave-to,
.slide-fade-leave {
  transform: translateX(10px);
  opacity: 0;
}

</style>
