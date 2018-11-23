<template>
  <div id="app">
    <language/>
    <main-menu/>
    <!-- <logon/> -->
    <!-- <unread-list/> -->
  </div>
</template>

<script>
import Language from './components/Language.vue'
import MainMenu from './components/MainMenu.vue'
//import Logon from './components/Logon.vue'
//import UnreadList from './components/UnreadList.vue'

export default {
  name: 'app',
  components: {
    Language, MainMenu //, Logon, UnreadList
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  
  margin-top: 15px;
}

* {
background-color: #f5f6fa;
transition: 0.5s;
}

</style>
