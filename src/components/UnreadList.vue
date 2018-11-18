<template>
  <div class="message_list">
    <div>{{test}}</div>
    
  </div>
</template>

<script>
import ImService from '@/../services/ImService'
export default {
  name: "UnreadList",
  data: function() {
    return {
      test: "null"
    };
  },
  mounted() {
    this.getGroups()
  },
  methods: {
    async getGroups() {
      const response = await ImService.getGroups();
      this.test=response.data;
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
