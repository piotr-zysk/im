<template>
  <div class="message_view">
    <transition appear name="slide-fade">
      <div>
        <div class="message_content" v-html="this.message.content"></div>
      </div>
    </transition>
  </div>
</template>

<script>
import ImService from "@/../services/ImService";
//import IdArray from "@/../services/idarray";
//import Settings from "@/../services/settings";
import { mapState, mapMutations } from "vuex";

export default {
  name: "ViewMessage",
  computed: mapState(["user", "navigation"]),
  data: function() {
    return {
      test: "null",
      resultsExist: false,
      message: ""
    };
  },
  mounted() {
    this.getMessage();
  },
  methods: {
    ...mapMutations(["changeTab", "saveApiCall"]),
    async getMessage() {
      try {
        this.$Progress.start();
        const response = await ImService.getMessage(
          this.user.token,
          this.navigation.content.id
        );
        this.message = response.data;
        //this.saveMessageList(IdArray.getList(this.messages));
        this.resultsExist = true;
        console.log(this.message);
        this.$Progress.finish();
      } catch (err) {
        this.changeTab({
          "tab": "ApiFailedAlert",
          "source": {"tab": "ViewMessage" },
          "content": {"id": this.navigation.content.id}
        });
        this.$Progress.fail();
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.message_content {
  font-size: 70%;
  border: 1px solid #ccc;
  box-shadow: 0 5px 20px #ccc;
  margin: 30px;
  padding: 10px;
}

.message_content table {
  background-color: #fff;
  border: 1px solid #aaa;
}
</style>
