<template>
  <div class="message_view">
    <transition appear name="slide-fade">
      <div>
        <div class="message_menu">
          <a href="#">
            <i class="fas fa-reply"></i>
            <p>{{$ml.get('reply')}}</p>
          </a>
          <a href="#">
            <i class="fas fa-reply-all"></i>
            <p>{{$ml.get('reply')}}</p>
          </a>
          <a href="#">
            <i class="fas fa-search-plus"></i>
            <p>{{$ml.get('zoom_in')}}</p>
          </a>
          <a href="#">
            <i class="fas fa-search-minus"></i>
            <p>{{$ml.get('zoom_out')}}</p>
          </a>
          <a href="#">
            <i class="fas fa-angle-double-right"></i>
            <p>{{$ml.get('next_message')}}</p>
          </a>
        </div>

        <h2>{{this.message.title}}</h2>
        <p>{{this.message.authorFName}} {{this.message.authorSName}}</p>

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
          tab: "ApiFailedAlert",
          source: { tab: "ViewMessage" },
          content: { id: this.navigation.content.id }
        });
        this.$Progress.fail();
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.message_view {
  margin-top: 30px;
}

.message_menu {
  border: 1px solid #ddd; /* #40739e; */
  box-shadow: 0 2px 2px #ddd;
  border-radius: 5px;
  padding: 7px 0;
  display: inline-block;
  margin-bottom: 20px;
  background-color: #fff;
  width: 500px;
}

.message_menu div {
  font-size: 3px;
}
.message_menu a {
  padding: 2px;
  border-right: 1px solid #ddd;
  width: 19%;
  display: inline-block;
  text-decoration: none;
  font-weight: 600;
  color: #40739e;
  transition: none; /* color 0.05s; */
}
.message_menu a:hover {
  color: #c23616;
}
.message_menu a:last-of-type {
  border-right: none;
}
.message_menu a,
.message_menu i,
.message_menu p {
  background-color: inherit;
}
.message_menu i {
  font-size: 130%;
}
.message_menu p {
  font-size: 70%;
  margin: 2px;
}
</style>
