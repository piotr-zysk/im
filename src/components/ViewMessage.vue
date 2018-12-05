<template>
  <div class="message_view" v-if="(this.message.recipients!='')&&(this.message.recipients!=null)">
    <transition appear name="slide-fade">
      <div>
        <div class="message_menu">
          <a href="#">
            <i class="fas fa-reply"></i>
            <p>{{$ml.get('reply')}}</p>
          </a>
          <a href="#">
            <i class="fas fa-reply-all"></i>
            <p>{{$ml.get('reply_all')}}</p>
          </a>
          <!--
          <a href="#">
            <i class="fas fa-search-plus"></i>
            <p>{{$ml.get('zoom_in')}}</p>
          </a>
          <a href="#">
            <i class="fas fa-search-minus"></i>
            <p>{{$ml.get('zoom_out')}}</p>
          </a>
          -->
          <a href="#" v-if="this.navigation.content.message_status=='sent'" @click="deleteMessageGoNext()">
            <i class="fas fa-eraser"></i>
            <p>{{$ml.get('withdraw_message')}}</p>
          </a>
          <a href="#" v-if="this.navigation.content.message_status!='sent'" @click="deleteMessageGoNext()">
            <i class="fas fa-trash"></i>
            <p>{{$ml.get('del_message')}}</p>
          </a>
          <a href="#" v-if="previousMessageId!=-1" @click="getPreviousMessage()">
            <i class="fas fa-angle-double-left"></i>
            <p>{{$ml.get('prev_message')}}</p>
          </a>
          <a href="#" v-if="nextMessageId!=-1" @click="getNextMessage()">
            <i class="fas fa-angle-double-right"></i>
            <p>{{$ml.get('next_message')}}</p>
          </a>
        </div>

        <h2>{{this.message.title}}</h2>
        <div class="message_properties">
          <p>{{$ml.get('from')}}: {{message.authorFName}} {{message.authorSName}}, {{$ml.get('message_created')}}: {{message.createdTime}}, {{$ml.get('message_expires')}}: {{message.expiredTime}}</p>
          <p>{{$ml.get('to')}}: {{getRecipientNames(message.recipients,10) | truncate(150)}}</p>
        </div>
        <div class="message_content" v-html="this.message.content"></div>
      </div>
    </transition>
  </div>
</template>

<script>
import ImService from "@/../services/ImService";
import IdArray from "@/../services/idarray";
import Dbcache from "@/../services/dbcache";
//import Settings from "@/../services/settings";
import { mapState, mapMutations } from "vuex";

export default {
  name: "ViewMessage",
  computed: mapState(["user", "navigation", "messageList","dbcache"]),
  props: ["type"],
  data: function() {
    return {
      test: "null",
      resultsExist: false,
      message: { recipients: "" },
      nextMessageId: null,
      previousMessageId: null
    };
  },
  mounted() {
    this.getMessage();
  },
  methods: {
    ...mapMutations(["changeTab", "saveApiCall"]),
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
    getNextMessageId() {
      return IdArray.getNext(this.messageList, this.navigation.content.id);
    },
    getPreviousMessageId() {
      return IdArray.getPrevious(this.messageList, this.navigation.content.id);
    },
    // messageToDelete: id of message to be deleted
    // id of the message to be displayed is taken from this.navigation.content.id
    async getMessage(messageToDelete) {
      this.nextMessageId = this.getNextMessageId();
      this.previousMessageId = this.getPreviousMessageId();
      try {
        this.$Progress.start();
        let response = "";

        if (messageToDelete > 0) {
          if (this.navigation.content.message_status == "sent")
            response = await ImService.withdrawMessageGoNext(
              this.user.token,
              messageToDelete,
              this.navigation.content.id
            );
          else
            response = await ImService.deleteMessageGoNext(
              this.user.token,
              messageToDelete,
              this.navigation.content.id
            );
        } else
          response = await ImService.getMessage(
            this.user.token,
            this.navigation.content.id
          );
        //console.log(response);
        if (response.data) this.message = response.data;
        else this.message = { recipients: "" };

        //this.saveMessageList(IdArray.getList(this.messages));
        this.resultsExist = true;
        //console.log(this.message);
        this.$Progress.finish();
      } catch (err) {
        //console.log(err);
        this.changeTab({
          tab: "ApiFailedAlert",
          source: { tab: "ViewMessage" },
          content: { id: this.navigation.content.id }
        });
        this.$Progress.fail();
      }
    },
    getNextMessage() {
      if (this.nextMessageId == -1) {
        //console.log("nie ma wiecej wiadomości");
      } else {
        this.changeTab({ content: { id: this.nextMessageId } });
        this.getMessage(0);
      }
    },
    getPreviousMessage() {
      if (this.previousMessageId != -1) {
        this.changeTab({ content: { id: this.previousMessageId } });
        this.getMessage(0);
      }
    },
    deleteMessageGoNext() {
      let messageToDelete = this.navigation.content.id;
      this.changeTab({ content: { id: this.nextMessageId } });
      this.getMessage(messageToDelete);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.message_view {
  margin-top: 15px;
}

.message_menu {
  border: 1px solid #ddd; /* #40739e; */
  box-shadow: 0 2px 2px #ddd;
  border-radius: 5px;
  padding: 5px 0;
  display: inline-block;
  margin-bottom: 10px;
  background-color: #fff;
}

.message_menu div {
  font-size: 3px;
}
.message_menu a {
  padding: 2px;
  border-left: 1px solid #ddd;
  width: 100px;
  display: inline-block;
  text-decoration: none;
  font-weight: 600;
  color: #40739e;
  transition: none; /* color 0.05s; */
}
.message_menu a:hover {
  color: #c23616;
}
.message_menu a:first-of-type {
  border-left: none;
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
h2 {
  font-weight: 100;
}
.message_properties {
  border: 1px solid #ddd;
  border-radius: 5px;
  margin: 0 20px;
  padding: 5px;
  background-color: #fff;
  color: #666;
}

.message_properties p {
  background-color: inherit;
  margin: 0;
  text-align: left;
  font-size: 80%;
  font-weight: 400;
}
</style>
