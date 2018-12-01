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
import { mapState } from "vuex";
//import Logon from './components/Logon.vue'
import UnreadList from "./components/UnreadList.vue";
import ReadList from "./components/ReadList.vue";
import ViewMessage from "./components/ViewMessage.vue";
import ApiFailedAlert from "./components/ApiFailedAlert.vue";
import Footer from "./components/Footer.vue";

export default {
  name: "app",
  computed: mapState(["navigation", "tab_locked"]),
  components: {
    Language,
    MainMenu,
    UnreadList,
    ReadList,
    ApiFailedAlert,
    ViewMessage,
    Footer
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
