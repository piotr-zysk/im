<template>
  <div class="message_view">

<transition appear name="slide-fade">

<p>duparerer</p>

</transition>


rererere

  </div>
</template>

<script>
import ImService from "@/../services/ImService";
//import IdArray from "@/../services/idarray";
//import Settings from "@/../services/settings";
import { mapState, mapMutations } from "vuex";

export default {
  name: "ViewMessage",
  computed: mapState(["guser", "user", "navigation"]),
  data: function() {
    return {
      test: "null",
      resultsExist: false,
      messages: []
    };
  },
  /*
  mounted() {
    this.getUnreadMessageList();
  },
  */
  methods: {
    ...mapMutations(["changeTab","saveApiCall"]),
    async getUnreadMessageList() {
      try {
        this.saveApiCall({from_tab: 'UnreadList'});
        const response = await ImService.getUnreadMessageList(this.user.token);
        this.messages = response.data;
       //this.saveMessageList(IdArray.getList(this.messages));
        this.resultsExist = true;
      } catch (err) {
        this.changeTab('ApiFailedAlert');
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
