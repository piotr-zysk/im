<template>
  <div id="app">
    
    <Logon/>
  </div>
</template>

<script>
import MainMenu from './components/MainMenu.vue'
import Logon from './components/Logon.vue'

export default {
  name: 'app',
  components: {
    MainMenu, Logon
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
  background-color: #34495e;
  margin-top: 60px;
}
</style>
