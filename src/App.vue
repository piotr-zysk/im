<template>
  <div id="app">
    <language/>
    <main-menu/>
    <component :is="navigation.tab"></component>
    <Footer/>
    <vue-progress-bar></vue-progress-bar>
  </div>
</template>

<script>
import Language from "./components/Language.vue";
import MainMenu from "./components/MainMenu.vue";
import { mapState, mapMutations } from "vuex";
//import Logon from './components/Logon.vue'
import UnreadList from "./components/UnreadList.vue";
import ReadList from "./components/ReadList.vue";
import SentList from "./components/SentList.vue";
import ViewMessage from "./components/ViewMessage.vue";
import NewMessage from "./components/NewMessage.vue";
import ApiFailedAlert from "./components/ApiFailedAlert.vue";
import Footer from "./components/Footer.vue";
import ImService from "@/../services/ImService";

export default {
  name: "app",
  computed: mapState(["navigation", "tab_locked","dbcache","user"]),
  components: {
    Language,
    MainMenu,
    UnreadList,
    ReadList,
    SentList,
    ApiFailedAlert,
    ViewMessage,
    NewMessage,
    Footer
  },
    mounted() {
    this.loadDbCache();
  },
  methods: {
    ...mapMutations(["loadUsersToDbcache","changeTab","saveApiCall","unlockMenu"]),
    async loadDbCache() {
      try {
        this.$Progress.start();
        const response = await ImService.getUsers(this.user.token);
        this.loadUsersToDbcache(response.data)

        //tu doczytaj grupy, kampanie itd


        this.resultsExist = true;
        this.$Progress.finish();
        this.unlockMenu();
      } catch (err) {
        //console.log(err);
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

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;

  margin-top: 15px;
}

* {
  background-color: #f5f6fa;
  transition: all 1.2s;
}
</style>
