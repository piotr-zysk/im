<template>
  <div class="message_list">
    <transition appear name="slide-fade">
      <div v-if="this.resultsExist">
        <table>
          <tr v-for="(message, index) in messages" :key="message.id">
            <td class="row_id" :style="pcolor(message.priority)">{{index+1}}</td>
            <td>
              <a
                href="#"
                @click="changeTab({'tab': 'ViewMessage', 'content': {'id': message.id, 'message_status': type}})"
              >
                <div class="message_title">
                  {{message.title | truncate(140) | no_empty('['+$ml.get('no_title')+']')}}
                  <i
                    v-if="message.attachment!=null"
                    class="icon ion-md-attach"
                  ></i>
                </div>
                <div
                  v-if="type!='sent'"
                  class="message_author"
                >{{message.authorFName}} {{message.authorSName}}, {{$ml.get('message_created')}}: {{message.createdTime}}, {{$ml.get('message_expires')}}: {{message.expiredTime}}</div>
                <div
                  v-else
                  class="message_author"
                >{{$ml.get('message_created')}}: {{message.createdTime}} {{$ml.get('to')}}: {{getRecipientNames(message.recipients,10) | truncate(100)}}</div>
              </a>
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
import Dbcache from "@/../services/dbcache";
import Settings from "@/../services/settings";
import { mapState, mapMutations } from "vuex";

export default {
  name: "MessageList",
  props: ["type"],
  computed: {
    ...mapState(["guser", "user", "navigation","dbcache"]),
    getSource: function() {
      if(this.type=='sent') return 'SentList';
      else if(this.type=='unread') return 'UnreadList';
      else return 'ReadList';
    }
  },
  data: function() {
    return {
      test: "null",
      resultsExist: false,
      messages: []
    };
  },
  mounted() {
    this.getMessageList();
  },
  methods: {
    ...mapMutations(["changeTab", "saveApiCall", "saveMessageList"]),
  getRecipientNames(idstring,limit=0) {
      //limit 0 = no limit (better to limit number of users to translate form ID to username, for performance reason)
      if (limit==0) limit=10000;
      let output='';
      let count=0;
      let ids=idstring.toString().split(",");
      ids.forEach(element => {
        if ((element!=2509)&&(count<limit)) //2509 = 'messenger admin' account
        {
        count++;
        if (output!='') output+=', ';
        output+=Dbcache.getUserName(this.dbcache.users,element)
        }});
        if (output=='') output=' ';
        return output;
    },
    pcolor(x) {
      return "background-color: " + Settings.getPriorityColor()[x] + ";"; //Settings.getPriorityColor()[x];
    },
    async getMessageList() {
      try {
        this.$Progress.start();
        const response = await ImService.getMessageList(
          this.user.token,
          this.type
        );
        this.messages = response.data;
        this.saveMessageList(IdArray.getList(this.messages));
        this.resultsExist = true;
        this.$Progress.finish();
      } catch (err) {
        this.changeTab({
          tab: "ApiFailedAlert",
          source: { tab: this.getSource }
        });
        this.$Progress.fail();
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
table {
  width: 80%;
  margin: 50px auto 20px auto;
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
.row_id {
  font-size: 80%;
  font-weight: bold;
  width: 25px;
  border-radius: 3px;
}
a {
  text-decoration: none;
  background-color: inherit;
  color: inherit;
}
table {
  box-shadow: 0 5px 10px #ccc;
  transition: 0.7s;
}
table:hover {
  box-shadow: 0 5px 20px #aaa;
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
