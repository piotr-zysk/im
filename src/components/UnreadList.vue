<template>
  <div class="message_list">
    <div>{{test}}</div>
    
    unread list
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
.message_list {
  color: #333333;
}
</style>
