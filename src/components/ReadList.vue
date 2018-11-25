<template>
  <div class="message_list">

<transition appear name="slide-fade">
<div v-if="this.resultsExist">
<table>
  <tr v-for="message in messages" :key="message.id">
    <td>{{message.priority}}</td>
    <td><div class="message_title">{{message.title | truncate(140)}}
    <i v-if="message.attachment!=null" class="icon ion-md-attach"></i></div>
    <div class="message_author">{{message.authorFName}} {{message.authorSName}}, {{$ml.get('message_created')}}: {{message.createdTime}}, {{$ml.get('message_expires')}}: {{message.expiredTime}}</div>
    </td>
  </tr>
</table>
</div>
</transition>


<!-- {{test}} -->

  </div>
</template>

<script>
import ImService from "@/../services/ImService";
import IdArray from "@/../services/idarray";
import { mapState, mapMutations } from "vuex";

export default {
  name: "UnreadList",
  computed: mapState(["guser", "user"]),
  data: function() {
    return {
      test: "null",
      resultsExist: false,
      messages: []
    };
  },
  mounted() {
    this.getUnreadMessageList();
  },
  methods: {
    ...mapMutations(["changeTab", "saveApiCall", "saveMessageList"]),
    async getUnreadMessageList() {
      try {
        this.saveApiCall({ from_tab: "ReadList" });
        const response = await ImService.getReadMessageList(this.user.token);
        this.messages = response.data;
        this.saveMessageList(IdArray.getList(this.messages));

        //this.test = response.data;

        this.resultsExist = true;
      } catch (err) {
        //console.log(fn);
        //console.log(err);
        //this.test = err.message;
        this.changeTab("ApiFailedAlert");
        //zrob fajny alert "Brak mozliwosci pobrania danych. Zaloguj sie ponownie / powiadmo administratora"
      }
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
  color: #353b48ce;
}
td {
  border-radius: 4px;
  padding: 3px;
  white-space: nowrap;
  overflow: hidden;
}
tr:nth-child(even) td {
  background-color: #fff;
}
tr:nth-child(odd) td {
  background-color: #dcdde1;
}
.message_title {
  font-weight: 600;
  background-color: inherit;
}
.message_author {
  background-color: inherit;
  font-size: 80%;
  text-align: left;
}
i {
  background-color: inherit;
  font-size: 120%;
  float: right;
  padding: 0 5px;
}
/*
.slide-fade-enter-active {
  transition: all 0.7s ease;
}

.slide-fade-enter,
.slide-fade-leave-to,
.slide-fade-leave {
  transform: translateX(10px);
  opacity: 0;
}
*/
</style>
