<template>
  <div id="app">
    
    <Logon/>
    <UnreadList/>
  </div>
</template>

<script>
import MainMenu from './components/MainMenu.vue'
import Logon from './components/Logon.vue'
import UnreadList from './components/UnreadList.vue'

export default {
  name: 'app',
  components: {
    MainMenu, Logon, UnreadList
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
  
  margin-top: 60px;
}
/*
* {
background-color: #34495e;
}
*/
</style>
