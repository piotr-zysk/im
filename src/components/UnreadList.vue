<template>
  <div class="message_list">

<transition appear name="slide-fade">
<div v-if="this.resultsExist">
<table>
  <tr v-for="message in messages" :key="message.id">
    <td>{{message.priority}}</td>
    <td><div class="message_title">{{message.title}}</div><div class="message_author">{{message.authorFName}} {{message.authorSName}}, {{message.createdTime}}</div></td>    
    <td>{{message.expiredTime}}</td>
  </tr>
</table>
</div>>
</transition>
TO DO: jesli tytul wiadomosci jest za dlugi to skroc do X znakow i dodaj.. aby miescil sie w jednej linii

{{test}}

  </div>
</template>

<script>
import ImService from "@/../services/ImService";
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
    this.getGroups();
  },
  methods: {
    ...mapMutations(["changeTab","saveApiCall"]),
    async getGroups() {
      try {
        this.saveApiCall({function_name: ImService.getUnreadMessageList.name, function_params: this.user.token, from_tab: 'UnreadList'});
        const response = await ImService.getUnreadMessageList(this.user.token);
        this.messages = response.data;
        this.test = response.data;

        this.resultsExist = true;
      } catch (err) {
        //console.log(fn);
        //console.log(err);
        //this.test = err.message;
        this.changeTab('ApiFailedAlert');
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
.message_title {
 
 background-color: inherit;
}
.message_author {
  background-color: inherit;
  font-size: 80%;
  text-align: left;
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
